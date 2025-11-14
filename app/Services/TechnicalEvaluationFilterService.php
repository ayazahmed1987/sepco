<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Tender;
use App\Models\TechnicalEvaluation;
use Carbon\Carbon;
use App\Services\FinancialYearService;

class TechnicalEvaluationFilterService
{
    public function __construct(
        protected FinancialYearService $financialYearService
    ){}

    public function filter(Request $request)
    {
        $years = $this->financialYearService->getLastFinancialYears();
        $selectedYear = $request->input('year') ?: $years[0];
        $selectedStatus = $request->input('status', 'active');

        $query = TechnicalEvaluation::with('tender');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('tender', function ($q) use ($search) {
                $q->where('ref_no', 'like', "%{$search}%");
                $q->orWhere('title', 'like', "%{$search}%");
            });
        }

        // Year filter
        if ($selectedYear) {
            [$start, $end] = explode('-', $selectedYear);
            $from = Carbon::create($start, 7, 1)->startOfDay();
            $to = Carbon::create($end, 6, 30)->endOfDay();
            $query->whereBetween('published_date', [$from, $to]);
        }

        // Status scope
        if (in_array($selectedStatus, ['active', 'archived'])) {
            $query->{$selectedStatus}();
        }

        return [
            'query' => $query,
            'years' => $years,
            'selectedYear' => $selectedYear,
            'selectedStatus' => $selectedStatus,
        ];
    }
}
