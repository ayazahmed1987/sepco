<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TenderCategory;
use App\Http\Requests\Backend\TenderCategoryRequest;
use Illuminate\Database\Eloquent\Builder;

class TenderCategoryController extends Controller
{
    public function index(Request $request){
        try{
            $search = $request->input('search');
            $query = TenderCategory::query();
            if (!empty($search)) {
                $query->where(function (Builder $q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            }
            $tender_categories = $query->paginate(10);
            if($request->ajax()){
                return view('backend.tenders.tender-categories.rendering-components.paginated-listing', compact('tender_categories'));
            }
            return view('backend.tenders.tender-categories.index',compact('tender_categories'));
        } catch (Exception $e) {
            \Log::error('Error fetching tender categories in controller: ' . $e->getMessage());
            return redirect()->route('manager.dashboard')->with('error', 'An error occurred while fetching tender categories.');
        }
    }

    public function create(){
        return view('backend.tenders.tender-categories.create');
    }

    public function store(TenderCategoryRequest $request){
        try{
            TenderCategory::create($request->validated());
            return redirect()->route('manager.tender-categories.index')->with('success','Tender category created!');
        } catch (Exception $e) {
            \Log::error('Error creating tender category in controller: ' . $e->getMessage());
            return redirect()->route('manager.dashboard')->with('error', 'An error occurred while creating tender category.');
        }
    }

    public function edit(TenderCategory $tender_category){
        return view('backend.tenders.tender-categories.edit',compact('tender_category'));
    }

    public function update(TenderCategory $tender_category, TenderCategoryRequest $request){
        try{
            $tender_category->update($request->validated());
            return redirect()->route('manager.tender-categories.edit', $tender_category)->with('success','Tender category updated!');
        } catch (Exception $e) {
            \Log::error('Error updating tender category in controller: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating tender category.');
        }
    }

    public function destroy(TenderCategory $tender_category){
        try{
            $tender_category->delete();
            return redirect()->route('manager.tender-categories.index')->with('success','Tender category deleted!');
        } catch (Exception $e) {
            \Log::error('Error deleting tender category in controller: ' . $e->getMessage());
            return redirect()->route('manager.tender-categories.index')->with('error', 'An error occurred while deleting tender category.');
        }
    }

}
