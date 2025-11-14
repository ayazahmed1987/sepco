<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomPost;
use App\Models\Page;
use App\Services\CustomPostService;
use App\Http\Requests\Backend\CustomPostRequest;
use App\Http\Requests\Backend\UpdateCustomPostRequest;

class CustomPostController extends Controller
{

	
	
	protected CustomPostService $custompostService;

    public function __construct(CustomPostService $custompostService)
    {
         $this->middleware('permission:custompost-list', ['only' => ['index']]);
         $this->middleware('permission:custompost-create', ['only' => ['create','store']]);
         $this->middleware('permission:custompost-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:custompost-delete', ['only' => ['destroy']]);
		
		 $this->custompostService = $custompostService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
		
       try {
            $filters = [
                'search' => $request->input('search')
            ];
            $customposts = $this->custompostService->getAllCustompostsPaginated($filters,10);
            if($request->ajax()){
                return view('backend.cms.customposts.rendering-customposts.paginated-listing', compact('customposts'));
            }
            return view('backend.cms.customposts.index', compact('customposts'));
        } catch (Exception $e) {
            \Log::error('Error fetching customposts in controller: ' . $e->getMessage());
            return redirect()->route('manager.dashboard')
                             ->with('error', 'An error occurred while fetching customposts.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pages = Page::pluck('title','id')->all();
		return view('backend.cms.customposts.create', compact('pages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomPostRequest $request)
    {
        try {
            $this->custompostService->createCustompost($request->validated());
			//activity()->causedBy(auth()->user())->performedOn($request)->event('created')->log('Add new custompost');
            return redirect()->route('manager.cms.customposts.index')->with('success', 'Custompost created successfully!');
        } catch (Exception $e) {
            \Log::error('Error creating custompost in controller: ' . $e->getMessage());
            return redirect()->route('manager.cms.customposts.create')
                             ->with('error', 'An error occurred while creating the custompost.');
        }
    }

    /**
     * Show the form for editing the specified custompost.
     */
    public function edit(CustomPost $custompost)
    {
        $pages = Page::pluck('title','id')->all();
		//$pages = Page::select('id','title')->get();
		return view('backend.cms.customposts.edit', compact('custompost','pages'));  // Assuming your edit view is located at 'resources/views/backend/customposts/edit.blade.php'
    }

    /**
     * Update the specified custompost in storage.
     */
    public function update(UpdateCustomPostRequest $request, CustomPost $custompost)
    {
        try {
            $this->custompostService->updateCustompost($custompost, $request->validated());
			activity()->causedBy(auth()->user())->performedOn($custompost)->withProperties($request)->event('updated')->log('updated custompost');
            return redirect()->route('manager.cms.customposts.index')->with('success', 'CustomPost updated successfully!');
        } catch (Exception $e) {
            \Log::error('Error updating custompost in controller: ' . $e->getMessage());
            return redirect()->route('manager.cms.customposts.edit', $custompost->id)
                             ->with('error', 'An error occurred while updating the custompost.');
        }
    }

    /**
     * Remove the specified custompost from storage.
     */
    public function destroy(CustomPost $custompost)
    {
        try {
            $this->custompostService->deleteCustompost($custompost);
			activity()->causedBy(auth()->user())->performedOn($custompost)->event('deleted')->log('Delete custompost');
            return redirect()->route('manager.cms.customposts.index')->with('success', 'Custompost deleted successfully!');
        } catch (Exception $e) {
            \Log::error('Error deleting custompost in controller: ' . $e->getMessage());
            return redirect()->route('manager.cms.customposts.index')
                             ->with('error', 'An error occurred while deleting the custompost.');
        }
    }

    /**
     * Toggle the status of existing custompost
     */
    public function toggleStatus(Request $request)
    {
        try {
            $custompost = $this->custompostService->toggleStatus($request);
            return response()->json($custompost, 200);
        } catch (Exception $e) {
            \Log::error('Error toggling custompost status: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while toggling the custompost status.'
            ], 500);
        }
    }

    /**
     * Render CustomPosts Related Fields
     */
    public function fieldsRender(Request $request)
    {
        try {
            $html = $this->custompostService->fieldsRender($request);
            return response()->json($html, 200);
        } catch (Exception $e) {
            \Log::error('Error rendering custompost fields: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while rendering custompost fields.'
            ], 500);
        }
    }
}
