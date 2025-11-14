<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomPostData extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['custom_post_id','fields_data','status','sorting'];
	
	//protected static function booted()
    //{
       // static::deleting(function ($custompost) {
        //    $custompost->children()->delete();
       // });
    //}

    protected $casts = [
        'fields_data' => 'array', // Automatically casts JSON to array
    ];



    
	
    public function custompost()
    {
        //return $this->belongsTo(CustomPost::class);
		return $this->belongsTo(CustomPost::class, 'custom_post_id');
		
    }
}
