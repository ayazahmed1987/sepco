<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinalEvaluation;
use App\Models\Tender;
use App\Http\Requests\Backend\FinalEvaluationRequest;
use App\Services\FileService;

class FinalEvaluationController extends Controller
{
    public function index(Request $request){
        try{
            $query = FinalEvaluation::with('tender');
            $filters = [
                'search' => $request->input('search')
            ];
            if (!empty($filters['search'])) {
                $searchTerm = $filters['search'];
            
                $query->whereHas('tender', function ($q) use ($searchTerm) {
                    $q->where('ref_no', 'like', "%{$searchTerm}%");
                });
            }
            $final_evaluations = $query->latest('published_date')->paginate(10);
            if($request->ajax()){
                return view('backend.tenders.final-evaluations.rendering-components.paginated-listing', compact('final_evaluations'));
            }
            return view('backend.tenders.final-evaluations.index',compact('final_evaluations'));
        } catch (\Exception $e) {
            \Log::error('Error fetching final Evaluations in controller: ' . $e->getMessage());
            return redirect()->route('manager.dashboard')->with('error', 'An error occurred while fetching final Evaluations.');
        }
    }

    public function create(){
        $tenders = Tender::select('id','ref_no')->get();
        return view('backend.tenders.final-evaluations.create',compact('tenders'));
    }

    public function store(FinalEvaluationRequest $request){
        try{
            $data = $request->validated();
            if($data['file']){
                $data['file'] = FileService::upload($data['file'],'uploads/final-evaluation/media');
            }
            FinalEvaluation::create($data);
            return redirect()->route('manager.final-evaluations.index')->with('success','Final Evaluations created!');
        } catch (\Exception $e) {
            \Log::error('Error storing Final Evaluations in controller: ' . $e->getMessage());
            return redirect()->route('manager.dashboard')->with('error', 'An error occurred while storing Final Evaluations.');
        }
    }

    public function edit(FinalEvaluation $final_evaluation){
        $tenders = Tender::select('id','ref_no')->get();
        return view('backend.tenders.final-evaluations.edit',compact('tenders','final_evaluation'));
    }

    public function update(FinalEvaluationRequest $request, FinalEvaluation $final_evaluation){
        try{
            $Tender = Tender::where('id', $request->tender_id)->first();
            if(!$Tender){
                return redirect()->back()->with('error', 'Invalid Request!');
            }
            $data = $request->validated();
            if (isset($data['file']) && $data['file'] instanceof \Illuminate\Http\UploadedFile) {
                if (isset($final_evaluation->file)) {
                    FileService::delete($final_evaluation->file);
                }
                $data['file'] = FileService::upload($data['file'], 'uploads/final-evaluation/files');
            }
            $final_evaluation->update($data);
            return redirect()->back()->with('success', 'Final evaluation has been updated');
        } catch (\Exception $e) {
            \Log::error('Error storing Final Evaluations in controller: ' . $e->getMessage());
            return redirect()->route('manager.dashboard')->with('error', 'An error occurred while storing Final Evaluations.');
        }
    }

    public function mediaRemove(FinalEvaluation $final_evaluation, $field){
        FileService::delete($final_evaluation->$field);
        $final_evaluation->$field="";
        $final_evaluation->save();
        return redirect()->back()->with('success','Media got removed!');
    }

    public function destroy(FinalEvaluation $final_evaluation){
        try{
            FileService::delete($final_evaluation->file);
            $final_evaluation->delete();
            return redirect()->route('manager.final-evaluations.index')->with('success','Final Evaluation deleted!');
        } catch (\Exception $e) {
            \Log::error('Error deleting Final Evaluation in controller: ' . $e->getMessage());
            return redirect()->route('manager.dashboard')->with('error', 'An error occurred while deleting Final Evaluation.');
        }
    }
}
