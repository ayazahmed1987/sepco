<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomPost extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['title','table_name','fields','design','css','javascript','status','sorting'];

    protected $casts = [
        'fields' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
	
	public function getpages()
    {
		return $this->belongsToMany(Page::class);
    }
	
	public function custompostdata()
    {
		//return $this->belongsToMany(CustomPostData::class);
		return $this->hasMany(CustomPostData::class)->where('status', 1)->orderBy('sorting', 'asc');
		
    }
}
