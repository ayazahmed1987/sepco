<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageComponent extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['title','parent_id','page_id','type','component_id','related_type','fields_data','status','sorting'];
    
    protected static function booted()
    {
        static::deleting(function ($component) {
            $component->children()->delete();
        });
    }

    protected $casts = [
        'fields_data' => 'array', // Automatically casts JSON to array
    ];

    // Scope to get only active menus
    public function scopeIsParent($query)
    {
        return $query->whereNull('parent_id');
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    // Parent component (belongsTo relationship)
    public function parent()
    {
        return $this->belongsTo(PageComponent::class, 'parent_id', 'id');
    }

    // Child components (hasMany relationship)
    public function children()
    {
        return $this->hasMany(PageComponent::class, 'parent_id', 'id');
    }

    public function component()
    {
        return $this->belongsTo(Component::class);
    }
}
