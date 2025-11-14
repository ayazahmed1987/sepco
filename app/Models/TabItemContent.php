<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TabItemContent extends Model
{
    use SoftDeletes;
    protected $fillable = ['tab_item_id','title','content','image','is_reversed','sorting'];

    protected static function booted()
    {
        static::deleting(function ($tab_item) {
            $tab_item->hotspots()->delete();
        });
    }

    public function tabItem()
    {
        return $this->belongsTo(TabItem::class);
    }

    public function hotspots()
    {
        return $this->hasMany(Hotspot::class);
    }
}
