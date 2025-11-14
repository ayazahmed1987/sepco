<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tender;
use App\Models\TechnicalEvaluation;
use App\Models\FinalEvaluation;

class ReportingController extends Controller
{
    public function tenders(Request $request){
        $query = Tender::query();
        if (!empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('ref_no', 'like', "%{$searchTerm}%");
                $q->orWhere('title', 'like', "%{$searchTerm}%");
                $q->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }
        if ($request->filled('start_date') || $request->filled('end_date')) {
            $start = $request->start_date ?? '1970-01-01';
            $end = $request->end_date ?? now()->toDateString();
            $query->whereBetween('published_date', [$start, $end]);
        }

        if ($request->filled('opening_date') || $request->filled('opening_date_end')) {
            $start = $request->opening_date ?? '1970-01-01';
            $end = $request->opening_date_end ?? now()->toDateString();
            $query->whereBetween('bids_opening_date', [$start, $end]);
        }

        if ($request->filled('tender_person')) {
            $query->where('tender_person_id', $request->tender_person);
        }

        $tenders = $query->latest('published_date')->paginate(10);
        if($request->ajax()){
            return view('backend.reporting.tenders.paginated-records',compact('tenders'));
        }
        return view('backend.reporting.tenders.index',compact('tenders'));
    }

    public function technicalEvaluations(Request $request){
        $query = technicalEvaluation::with('tender');
        if (!empty($request->search)) {
            $searchTerm = $request->search;
            $query->whereHas('tender', function ($q) use ($searchTerm) {
                $q->where('ref_no', 'like', "%{$searchTerm}%");
                $q->orWhere('title', 'like', "%{$searchTerm}%");
                $q->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }
        if ($request->filled('start_date') || $request->filled('end_date')) {
            $start = $request->start_date ?? '1970-01-01';
            $end = $request->end_date ?? now()->toDateString();
            $query->whereBetween('published_date', [$start, $end]);
        }
        if ($request->filled('opening_start_date') || $request->filled('opening_end_date')) {
            $start = $request->opening_start_date ?? '1970-01-01';
            $end = $request->opening_end_date ?? now()->toDateString();
            $query->whereBetween('financial_opening_date', [$start, $end]);
        }
        if ($request->filled('tender_person_id')) {
            $query->whereHas('tender', function ($q) use ($request) {
                $q->where('tender_person_id', $request->tender_person_id);
            });
        }
        $technical_evaluations = $query
        ->when($request->status == '1', fn($q) => $q->active())
        ->when($request->status == '2', fn($q) => $q->archived())
        ->latest('published_date')
        ->paginate(10);
        if($request->ajax()){
            return view('backend.reporting.technical-evaluations.paginated-records',compact('technical_evaluations'));
        }
        return view('backend.reporting.technical-evaluations.index',compact('technical_evaluations'));
    }
    
    public function finalEvaluations(Request $request){
        $query = FinalEvaluation::with('tender');
        if (!empty($request->search)) {
            $searchTerm = $request->search;
            $query->whereHas('tender', function ($q) use ($searchTerm) {
                $q->where('ref_no', 'like', "%{$searchTerm}%");
                $q->orWhere('title', 'like', "%{$searchTerm}%");
                $q->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }
        if ($request->filled('start_date') || $request->filled('end_date')) {
            $start = $request->start_date ?? '1970-01-01';
            $end = $request->end_date ?? now()->toDateString();
            $query->whereBetween('published_date', [$start, $end]);
        }
        if ($request->filled('po_issuance_start_date') || $request->filled('po_issuance_end_date')) {
            $start = $request->po_issuance_start_date ?? '1970-01-01';
            $end = $request->po_issuance_end_date ?? now()->toDateString();
            $query->whereBetween('po_issuance_date', [$start, $end]);
        }
        if ($request->filled('tender_person_id')) {
            $query->whereHas('tender', function ($q) use ($request) {
                $q->where('tender_person_id', $request->tender_person_id);
            });
        }
        $final_evaluations = $query
        ->when($request->status == '1', fn($q) => $q->active())
        ->when($request->status == '2', fn($q) => $q->archived())
        ->latest('published_date')
        ->paginate(10);

        if($request->ajax()){
            return view('backend.reporting.final-evaluations.paginated-records',compact('final_evaluations'));
        }
        return view('backend.reporting.final-evaluations.index',compact('final_evaluations'));
    }
}
