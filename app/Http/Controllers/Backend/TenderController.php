<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TenderService;
use App\Models\Tender;
use App\Models\TenderPerson;
use App\Http\Requests\Backend\TenderRequest;

class TenderController extends Controller
{
    protected TenderService $service;

    public function __construct(TenderService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request){
        try{
            $filters = [
                'search' => $request->input('search')
            ];
            $tenders = $this->service->getAllPaginated($filters,10);
            if($request->ajax()){
                return view('backend.tenders.rendering-components.paginated-listing', compact('tenders'));
            }
            return view('backend.tenders.index',compact('tenders'));
        } catch (\Exception $e) {
            \Log::error('Error fetching tenders in controller: ' . $e->getMessage());
            return redirect()->route('manager.dashboard')->with('error', 'An error occurred while fetching tenders.');
        }
    }

    public function create(){
        $tender_persons = TenderPerson::all();
        return view('backend.tenders.create',compact('tender_persons'));
    }

    public function store(TenderRequest $request){
        try{
            $this->service->create($request->validated());
            return redirect()->route('manager.tenders.index')->with('success','Tender created!');
        } catch (\Exception $e) {
            \Log::error('Error storing tender in controller: ' . $e->getMessage());
            return redirect()->route('manager.dashboard')->with('error', 'An error occurred while storing tender.');
        }
    }

    public function edit(Tender $tender){
        $tender_persons = TenderPerson::all();
        return view('backend.tenders.edit',compact('tender_persons','tender'));
    }

    public function update(Tender $tender, TenderRequest $request){
        try{
            $this->service->update($tender, $request->validated());
            return redirect()->route('manager.tenders.edit', $tender)->with('success','Tender updated!');
        } catch (\Exception $e) {
            \Log::error('Error updating tender in controller: ' . $e->getMessage());
            return redirect()->route('manager.dashboard')->with('error', 'An error occurred while updating tender.');
        }
    }

    public function destroy(Tender $tender){
        try{
            $tender->delete();
            return redirect()->route('manager.tenders.index')->with('success','Tender deleted!');
        } catch (\Exception $e) {
            \Log::error('Error deleting tender in controller: ' . $e->getMessage());
            return redirect()->route('manager.dashboard')->with('error', 'An error occurred while deleting tender.');
        }
    }
}
