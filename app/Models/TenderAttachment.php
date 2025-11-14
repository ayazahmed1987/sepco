<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenderAttachment extends Model
{
    protected $fillable = ['type','tender_id','file_title','file','sorting'];

    protected $casts = [
        'type' => \App\Enums\TenderAttachmentType::class,
    ];

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }
}
