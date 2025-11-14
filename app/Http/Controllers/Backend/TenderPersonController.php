<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TenderPersonService;
use App\Http\Requests\Backend\TenderPersonRequest;
use App\Models\TenderPerson;
class TenderPersonController extends Controller
{
    public function __construct(
        protected TenderPersonService $service
    ) {}

    public function index(Request $request){
        try{
            $filters = [
                'search' => $request->input('search')
            ];
            $tender_persons = $this->service->getAllPaginated($filters,10);
            if($request->ajax()){
                return view('backend.tenders.tender-persons.rendering-components.paginated-listing', compact('tender_persons'));
            }
            return view('backend.tenders.tender-persons.index',compact('tender_persons'));
        } catch (\Exception $e) {
            \Log::error('Error fetching tender persons in controller: ' . $e->getMessage());
            return redirect()->route('manager.dashboard')->with('error', 'An error occurred while fetching tender persons.');
        }
    }

    public function create(){
        return view('backend.tenders.tender-persons.create');
    }

    public function store(TenderPersonRequest $request){
        try{
            $this->service->create($request->validated());
            return redirect()->route('manager.tender-persons.index')->with('success','Tender person created!');
        } catch (\Exception $e) {
            \Log::error('Error storing tender persons in controller: ' . $e->getMessage());
            return redirect()->route('manager.dashboard')->with('error', 'An error occurred while storing tender persons.');
        }
    }

    public function edit(TenderPerson $tender_person){
        return view('backend.tenders.tender-persons.edit',compact('tender_person'));
    }

    public function update(TenderPerson $tender_person, TenderPersonRequest $request){
        try{
            $data = $this->service->update($tender_person, $request->validated());
            return redirect()->route('manager.tender-persons.edit', $data)->with('success','Tender person updated!');
        } catch (\Exception $e) {
            \Log::error('Error updating tender persons in controller: ' . $e->getMessage());
            return redirect()->route('manager.dashboard')->with('error', 'An error occurred while updating tender persons.');
        }
    }

    public function destroy(TenderPerson $tender_person){
        try{
            $tender_person->delete();
            return redirect()->route('manager.tender-persons.index')->with('success','Tender person deleted!');
        } catch (\Exception $e) {
            \Log::error('Error deleting tender persons in controller: ' . $e->getMessage());
            return redirect()->route('manager.dashboard')->with('error', 'An error occurred while deleting tender persons.');
        }
    }
}
