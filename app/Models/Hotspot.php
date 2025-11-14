<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotspot extends Model
{
    use SoftDeletes;
    protected $fillable = ['tab_item_content_id','type','feature','detail','top','left','image'];

    public function tabItemContent()
    {
        return $this->belongsTo(TabItemContent::class);
    }
}
