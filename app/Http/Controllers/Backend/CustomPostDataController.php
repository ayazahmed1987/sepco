<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

use App\Models\CustomPost;
use App\Models\CustomPostData;
use App\Services\FileService;
use App\Services\CustomPostDataService;
use App\Http\Requests\Backend\CustomPostDataRequest;
use App\Http\Requests\Backend\UpdateCustomPostDataRequest;

class CustomPostDataController extends Controller
{

	
	
	protected CustomPostDataService $custompostdataService;

    public function __construct(CustomPostDataService $custompostdataService)
    {
         //$this->middleware('permission:custompostdata-list', ['only' => ['index']]);
         //$this->middleware('permission:custompostdata-create', ['only' => ['create','store']]);
         //$this->middleware('permission:custompostdata-edit', ['only' => ['edit','update']]);
         //$this->middleware('permission:custompostdata-delete', ['only' => ['destroy']]);
		
		 $this->custompostdataService = $custompostdataService;
    }

    /**
     * Display a listing of the resource.
     */
	 public function index(Request $request, $custompostid){
       try {
		   $row_id = decrypt($custompostid);
           $custompost = CustomPost::findOrFail($row_id);
		   $custompostdata = CustomPostData::where('custom_post_id', $row_id)->get();
            $filters = [
                'custom_post_id' => $row_id,
				'search' => $request->input('search')
				
            ];
            $custompostdatas = $this->custompostdataService->getAllCustompostsDataPaginated($filters,10);
            if($request->ajax()){
                return view('backend.cms.custompostdatas.rendering-custompostdatas.paginated-listing', compact('custompostdatas'));
            }
            return view('backend.cms.custompostdatas.index', compact('custompostdatas','custompost'));
			
			
        } catch (Exception $e) {
            \Log::error('Error fetching custompostdatas in controller: ' . $e->getMessage());
            return redirect()->route('manager.dashboard')->with('error', 'An error occurred while fetching custompostdatas.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($custompostid)
    {
		try {
		$decrypted = Crypt::decryptString($custompostid);
		$row_id = decrypt($custompostid);
		$custompost = CustomPost::findOrFail($row_id);
		$fields = $custompost->fields['fields'] ?? [];
		//dump($custompost->fields);
		return view('backend.cms.custompostdatas.create', compact('fields','custompost'));

		} catch (DecryptException $e) {
		    //abort(404, 'Custom Post Not Found');
		    Log::error('Error fetching custompostdata in controller: ' . $e->getMessage());
            return redirect()->route('manager.dashboard')->with('error', 'An error occurred while fetching custompost.');
		}
		
		
		
		
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomPostDataRequest $request)
    {
        try {
			//dump($request->validated());
			//dump($request->all());
            //$this->custompostdataService->createCustompostdata($request->validated());
			
			$this->custompostdataService->createCustompostdata($request->all());
            return redirect()->route('manager.cms.custompostdata.index', encrypt($request->custom_post_id))->with('success', 'Custompost data created successfully!');
			
			
        } catch (Exception $e) {
            \Log::error('Error creating custompost in controller: ' . $e->getMessage());
            return redirect()->route('manager.cms.custompostdata.create', encrypt($request->custom_post_id))->with('error', 'An error occurred while creating the custompost.');
        }
    }
	

    /**
     * Show the form for editing the specified custompost.
     */
    public function edit($custompostid)
    {
        try {
		$decrypted = Crypt::decryptString($custompostid);
		$custompostid = decrypt($custompostid);
		
		$custompostdata = CustomPostData::findOrFail($custompostid);
		$custompost = CustomPost::findOrFail($custompostdata->custom_post_id);
		
		$fields = $custompost->fields['fields'] ?? [];
		$existingData = $custompostdata->fields_data ?? [];
		return view('backend.cms.custompostdatas.edit', compact('fields','existingData','custompostdata'));
		} catch (DecryptException $e) {
		    //abort(404, 'Custom Post Data Not Found');
		    Log::error('Error fetching custompostdata in controller: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching custompostdata.');
		}
    }

    /**
     * Update the specified custompost in storage.
     */
    public function update(UpdateCustomPostDataRequest $request, CustomPostData $custompostdata)
    {
        try {
			//dump($request->validated());
			
			//$this->custompostdataService->updateCustompostdata($custompostdata, $request->all());
			$this->custompostdataService->updateCustompostdata($request->validated(), $custompostdata);
            return redirect()
			//->route('manager.cms.custompostdata.index', encrypt($request->custom_post_id))
			->route('manager.cms.custompostdata.edit', encrypt($custompostdata->id))
			->with('success', 'CustomPostData updated successfully!');
			
			
        } catch (Exception $e){
            \Log::error('Error updating custompostdata in controller: ' . $e->getMessage());
            return redirect()->route('manager.cms.custompostdata.edit', encrypt($custompostdata->id))->with('error', 'An error occurred while updating the custompost.');
        }
    }
	
	

    public function mediaRemove(CustomPostData $custompostdata, $field){
        try {
			    $fileName = $field;
			    if ($fileName && !empty($custompostdata->fields_data[$fileName])) {
                    FileService::delete($custompostdata->fields_data[$fileName]);
                }
			
			
            $json = $custompostdata->fields_data;
            $json[$field] = null;
            $custompostdata->fields_data = $json;
            $custompostdata->save();
            return redirect()->back()->with('success', 'Media got removed!');
        } catch (Exception $e) {
            \Log::error('Error deleting media custompostdata in controller: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Media did not got removed!');
        }
    }
	
	
	public function specificMediaRemove(CustomPostData $custompostdata, $mediaFile)
	{

    // image path sent from the front-end
    $imagePath = decrypt($mediaFile);
	
	// Decode JSON field if needed
    $fieldsData = is_array($custompostdata->fields_data)
        ? $custompostdata->fields_data
        : json_decode($custompostdata->fields_data, true);

    // Get existing image array from 'image' field
    $images = isset($fieldsData['image']) && is_array($fieldsData['image'])
        ? $fieldsData['image']
        : [];

    // Remove the image that matches the given path
    $filtered = array_filter($images, function ($img) use ($imagePath) {
        return $img !== $imagePath;
    });

    // Delete physical file from storage
    FileService::delete($imagePath);

    // Update JSON field
    $fieldsData['image'] = array_values($filtered);
    $custompostdata->fields_data = $fieldsData;
    $custompostdata->save();

	return redirect()->back()->with('success', 'Specific media gallery got removed!');
    }
	
	

    /**
     * Remove the specified custompost from storage.
     */
    public function destroy(CustomPostData $custompostdata)
    {
		
		try {
            $this->custompostdataService->deleteCustompostdata($custompostdata);
			activity()->causedBy(auth()->user())->performedOn($custompostdata)->event('deleted')->log('Delete custompostdata');
			return redirect()->route('manager.cms.custompostdata.index', encrypt($custompostdata->custom_post_id))->with('success', 'Custompost Data deleted successfully!');
        } catch (Exception $e) {
            \Log::error('Error deleting custompostdata in controller: ' . $e->getMessage());
            return redirect()->route('manager.cms.custompostdatas.index')
                             ->with('error', 'An error occurred while deleting the custompostdata.');
        }
		
    }
	


    /**
     * Toggle the status of existing custompost
     */
    public function toggleStatus(Request $request)
    {
        try {
            $custompost = $this->custompostdataService->toggleStatus($request);
            return response()->json($custompost, 200);
        } catch (Exception $e) {
            \Log::error('Error toggling custompost status: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while toggling the custompost status.'
            ], 500);
        }
    }

    /**
     * Render CustomPostDatas Related Fields
     */
    /*
	public function fieldsRender(Request $request)
    {
        try {
            $html = $this->custompostdataService->fieldsRender($request);
            return response()->json($html, 200);
        } catch (Exception $e) {
            \Log::error('Error rendering custompost fields: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while rendering custompost fields.'
            ], 500);
        }
    }
	*/
	
}
