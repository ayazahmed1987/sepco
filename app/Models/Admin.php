<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes, InteractsWithMedia;
    protected $guard_name = "admin";
	
    protected $fillable = [
        'name',
        'user_code', 		
		'email', 
		'password',
    ];
	
    protected $hidden = [
        'password', 
		'remember_token',
    ];
	
	
	public function getGuardNameAttributeValue(){
       return $this->guard_name;
    }
	
	
	// Optional: define conversions (like thumbnail)
	public function registerMediaConversions(Media $media = null): void
    {
		
		$this->addMediaConversion('small')->fit(Fit::Crop, 50, 50)->format('webp')->quality(50)->nonQueued();
		$this->addMediaConversion('thumbnail')->fit(Fit::Crop, 300, 300)->format('webp')->quality(50)->nonQueued();
		$this->addMediaConversion('medium')->fit(Fit::Max, 600, 600)->format('webp')->quality(50)->nonQueued();
		$this->addMediaConversion('large')->fit(Fit::Max, 800, 800)->format('webp')->quality(50)->nonQueued();
		$this->addMediaConversion('full')->format('webp')->quality(50)->nonQueued(); 
		
		
		//php artisan media-library:regenerate
		//php artisan media-library:clear
		//php artisan media-library:clean
		
		//$file = $request->file('avatar');
		//$path = $file->store('media/admin/avatars', 'public');
		//$admin->addMedia(storage_path('app/public/' . $path))->preservingOriginal()->toMediaCollection('avatar');
		
    }

	
}
