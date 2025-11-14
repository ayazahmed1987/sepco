<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TabItem extends Model
{
    use SoftDeletes;
    protected $fillable = ['tab_id','item_name','image','content','sorting'];

    protected static function booted()
    {
        static::deleting(function ($tab_item) {
            $tab_item->tabItemContents()->delete();
        });
    }

    public function productTab()
    {
        return $this->belongsTo(ProductTab::class, 'tab_id' ,'id');
    }

    public function tabItemContents()
    {
        return $this->hasMany(TabItemContent::class);
    }
}
