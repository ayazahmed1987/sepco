<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class TechnicalEvaluation extends Model
{
    protected $fillable = ['tender_id', 'published_date', 'financial_opening_date', 'file'];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('published_date', '>', now()->subDays(7)->toDateString());
    }

    public function scopeArchived(Builder $query): Builder
    {
        return $query->where('published_date', '<=', now()->subDays(7)->toDateString());
    }

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }
}
