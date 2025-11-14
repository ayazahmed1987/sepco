<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TechnicalEvaluation;
use App\Models\Tender;
use App\Http\Requests\Backend\TechnicalEvaluationRequest;
use App\Services\FileService;

class TechnicalEvaluationController extends Controller
{
    public function index(Request $request){
        try{
            $query = TechnicalEvaluation::with('tender');
            $filters = [
                'search' => $request->input('search')
            ];
            if (!empty($filters['search'])) {
                $searchTerm = $filters['search'];
            
                $query->whereHas('tender', function ($q) use ($searchTerm) {
                    $q->where('ref_no', 'like', "%{$searchTerm}%");
                });
            }
            $technical_evaluations = $query->latest('published_date')->paginate(10);
            if($request->ajax()){
                return view('backend.tenders.technical-evaluations.rendering-components.paginated-listing', compact('technical_evaluations'));
            }
            return view('backend.tenders.technical-evaluations.index',compact('technical_evaluations'));
        } catch (\Exception $e) {
            \Log::error('Error fetching technical evaluations in controller: ' . $e->getMessage());
            return redirect()->route('manager.dashboard')->with('error', 'An error occurred while fetching technical evaluations.');
        }
    }

    public function create(){
        $tenders = Tender::select('id','ref_no')->get();
        return view('backend.tenders.technical-evaluations.create',compact('tenders'));
    }

    public function store(TechnicalEvaluationRequest $request){
        try{
            $data = $request->validated();
            if($data['file']){
                $data['file'] = FileService::upload($data['file'],'uploads/technical-evaluation/media');
            }
            TechnicalEvaluation::create($data);
            return redirect()->route('manager.technical-evaluations.index')->with('success','Technical Evaluations created!');
        } catch (\Exception $e) {
            \Log::error('Error storing Technical Evaluations in controller: ' . $e->getMessage());
            return redirect()->route('manager.dashboard')->with('error', 'An error occurred while storing Technical Evaluations.');
        }
    }

    public function edit(TechnicalEvaluation $technical_evaluation){
        $tenders = Tender::select('id','ref_no')->get();
        return view('backend.tenders.technical-evaluations.edit',compact('tenders','technical_evaluation'));
    }

    public function update(TechnicalEvaluationRequest $request, TechnicalEvaluation $technical_evaluation){
        try{
            $Tender = Tender::where('id', $request->tender_id)->first();
            if(!$Tender){
                return redirect()->back()->with('error', 'Invalid Request!');
            }
            $data = $request->validated();
            if (isset($data['file']) && $data['file'] instanceof \Illuminate\Http\UploadedFile) {
                if (isset($technical_evaluation->file)) {
                    FileService::delete($technical_evaluation->file);
                }
                $data['file'] = FileService::upload($data['file'], 'uploads/technical-evaluation/files');
            }
            $technical_evaluation->update($data);
            return redirect()->back()->with('success', 'Technical evaluation has been updated');
        } catch (\Exception $e) {
            \Log::error('Error storing Technical Evaluations in controller: ' . $e->getMessage());
            return redirect()->route('manager.dashboard')->with('error', 'An error occurred while storing Technical Evaluations.');
        }
    }

    public function mediaRemove(TechnicalEvaluation $technical_evaluation, $field){
        FileService::delete($technical_evaluation->$field);
        $technical_evaluation->$field="";
        $technical_evaluation->save();
        return redirect()->back()->with('success','Media got removed!');
    }

    public function destroy(TechnicalEvaluation $technical_evaluation){
        try{
            FileService::delete($technical_evaluation->file);
            $technical_evaluation->delete();
            return redirect()->route('manager.technical-evaluations.index')->with('success','Technical Evaluation deleted!');
        } catch (\Exception $e) {
            \Log::error('Error deleting Technical Evaluation in controller: ' . $e->getMessage());
            return redirect()->route('manager.dashboard')->with('error', 'An error occurred while deleting Technical Evaluation.');
        }
    }
}
