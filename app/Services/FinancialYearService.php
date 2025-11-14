<?php

namespace App\Services;

use Carbon\Carbon;

class FinancialYearService
{
    public function getLastFinancialYears($count = 5): array
    {
        $years = [];
        $now = now();
        $startYear = $now->month >= 7 ? $now->year : $now->year - 1;

        for ($i = 0; $i < $count; $i++) {
            $from = $startYear - $i;
            $to = $from + 1;
            $years[] = "$from-$to";
        }

        return $years;
    }
}