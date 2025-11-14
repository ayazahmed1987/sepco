<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Tender extends Model
{
    use SoftDeletes;
    protected $fillable = ['type','ref_no','title','published_date','participation_closing_date','participation_closing_time','bids_opening_date','bids_opening_time','tender_person_id'];
    
    
    protected $casts = [
        'type' => \App\Enums\TenderCategoryType::class,
    ];

    public function scopeActive(Builder $query): Builder
    {
        $now = now();

        return $query->whereDate('published_date', '<=', $now->toDateString())
            ->where(function ($q) use ($now) {
                $q->where('participation_closing_date', '>', $now->toDateString())
                ->orWhere(function ($q2) use ($now) {
                    $q2->where('participation_closing_date', $now->toDateString())
                        ->where('participation_closing_time', '>', $now->toTimeString());
                });
            });
    }

    public function scopeArchived(Builder $query): Builder
    {
        $now = now();

        return $query->where(function ($q) use ($now) {
            $q->where('participation_closing_date', '<', $now->toDateString())
            ->orWhere(function ($q2) use ($now) {
                $q2->where('participation_closing_date', $now->toDateString())
                    ->where('participation_closing_time', '<=', $now->toTimeString());
            });
        });
    }

    public function tenderPerson()
    {
        return $this->belongsTo(TenderPerson::class, 'tender_person_id');
    }
    
    public function tenderAttachments()
    {
        return $this->hasMany(TenderAttachment::class);
    }
}
