<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Tender;
use Carbon\Carbon;

class TenderFilterService
{

    public function __construct(
        protected FinancialYearService $financialYearService
    ){}

    public function filter(Request $request)
    {
        $years = $this->financialYearService->getLastFinancialYears();
        $selectedYear = $request->input('year') ?: $years[0];
        $selectedStatus = $request->input('status', 'active');

        $query = Tender::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ref_no', 'like', "%{$search}%")
                ->orWhere('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
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