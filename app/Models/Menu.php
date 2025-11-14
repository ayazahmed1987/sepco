<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\MenuRedirectionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = ['type','parent_id','title','title_ur','redirection_type','page_id','route','url','status','sorting'];
    
    protected $casts = [
        'redirection_type' => MenuRedirectionType::class,
    ];

    // Scope to get only active menus
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    // Parent component (belongsTo relationship)
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id', 'id')->active();
    }

    // Child components (hasMany relationship)
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id')->orderBy('sorting','ASC')->active();
    }

    // Page
    public function page()
    {
        return $this->belongsTo(Page::class);
    }   

    public function getRedirectUrlAttribute()
    {
        try {
            return match ($this->redirection_type->value) {
                1 => route('website.page.show', $this->page->slug),
                2 => route($this->route),
                3 => $this->url,
                default => '#',
            };
        } catch (\Exception) {
            return '#';
        }
    }
}
