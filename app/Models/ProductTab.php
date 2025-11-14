<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductTab extends Model
{
    use SoftDeletes;
    protected $fillable = ['product_id','type','title'];

    protected static function booted()
    {
        static::deleting(function ($product_tab) {
            $product_tab->tabItems()->delete();
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function tabItems()
    {
        return $this->hasMany(TabItem::class, 'tab_id');
    }
}
