<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ManagementPerson extends Model
{
    protected $fillable = ['type','name','designation','description','image','sorting','status'];

    protected static function booted()
    {
        static::creating(function ($management_person) {
            $management_person->slug = static::generateUniqueSlug($management_person->name);
        });
    
        static::updating(function ($management_person) {
            if ($management_person->isDirty('name')) {
                $management_person->slug = static::generateUniqueSlug($management_person->name, $management_person->id);
            }
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
}
