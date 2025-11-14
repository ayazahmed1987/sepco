<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['title','title_ur','description','description_ur','image','meta_title','meta_description','meta_keywords','status'];
    
    protected static function booted()
    {
        static::creating(function ($page) {
            $page->slug = static::generateUniqueSlug($page->title);
        });
    
        static::updating(function ($page) {
            if ($page->isDirty('title')) {
                $page->slug = static::generateUniqueSlug($page->title, $page->id);
            }
        });

        static::deleting(function ($page) {
            $page->Allcomponents()->delete();
        });
    }
    
    protected static function generateUniqueSlug($title, $excludeId = null)
    {
        $slug = Str::slug($title);
        $original = $slug;
        $count = 1;
    
        while (static::where('slug', $slug)
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->exists()) {
            $slug = $original . '-' . $count++;
        }
    
        return $slug;
    }

    public function components()
    {
        return $this->hasMany(PageComponent::class)->whereNull('parent_id')->where('status', 1)->orderBy('sorting', 'asc')->whereNull('parent_id');
    }

    public function Allcomponents()
    {
        return $this->hasMany(PageComponent::class);
    }
	
	public function customposts()
    {
		return $this->belongsToMany(CustomPost::class)->where('status', 1)->orderBy('sorting', 'asc');
		//return $this->hasMany(CustomPost::class)->where('status', 1)->orderBy('sorting', 'asc');
    }
}


