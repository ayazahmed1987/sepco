<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ManagementPerson;
use App\Http\Requests\Backend\ManagementPersonRequest;
use App\Services\FileService;

class ManagementPersonController extends Controller
{
    public function index(Request $request){
        try{
            $search = $request->input('search');
            $query = ManagementPerson::query();
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                    $q->orWhere('designation', 'like', "%{$search}%");
                });
            }
            $management_persons = $query->paginate(10);
            if($request->ajax()){
                return view('backend.cms.management-persons.rendering-components.paginated-listing', compact('management_persons'));
            }
            return view('backend.cms.management-persons.index',compact('management_persons'));
        } catch (Exception $e) {
            \Log::error('Error fetching management persons in controller: ' . $e->getMessage());
            return redirect()->route('manager.dashboard')->with('error', 'An error occurred while fetching management persons.');
        }
    }

    public function create(){
        return view('backend.cms.management-persons.create');
    }

    public function store(ManagementPersonRequest $request){
        try{
            $data = $request->validated();
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $data['image'] = FileService::upload($data['image'], 'uploads/management-persons/images');
            }
            ManagementPerson::create($data);
            return redirect()->route('manager.cms.management-persons.index')->with('success', 'Management Person has been inserted!');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    
    public function toggleStatus(Request $request){
        try{
            $management_person= ManagementPerson::where('id',$request->id)->first();
            $management_person->status = $request->status;
            $management_person->save();
            return response()->json([],200);
        }catch(\Exception $e){
            return response()->json([
                'error' => 'An error occurred while toggling the person status.'
            ], 500);
        }
    }

    public function edit(ManagementPerson $management_person){
        return view('backend.cms.management-persons.edit',compact('management_person'));
    }

    public function mediaRemove(ManagementPerson $management_person, $field){
        if(isset($management_person->$field)){
            FileService::delete($management_person->$field);
            $management_person->$field = '';
            $management_person->save();
        }
        return redirect()->back()->with('success','Media has been removed');
    }

    public function update(ManagementPersonRequest $request, ManagementPerson $management_person){
        try{
            $data = $request->validated();
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                if (isset($management_person->image)) {
                    FileService::delete($management_person->image);
                }
                $data['image'] = FileService::upload($data['image'], 'uploads/management-persons/images');
            }
            $management_person->update($data);
            return redirect()->back()->with('success', 'Management Person has been updated!');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(ManagementPerson $management_person){
        try{
            if (isset($management_person->image)) {
                FileService::delete($management_person->image);
            }
            $management_person->delete();
            return redirect()->back()->with('success', 'Management Person has been deleted!');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
