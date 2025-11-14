<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Component extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['component_name','type','fields','design','css','javascript','status'];

    protected $casts = [
        'fields' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
