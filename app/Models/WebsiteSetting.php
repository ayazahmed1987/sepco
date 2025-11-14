<?php
namespace App\Models;

use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\SoftDeletes;

class WebsiteSetting extends Model implements HasMedia
{
    use InteractsWithMedia;
	//use HasFactory, Notifiable, HasRoles, SoftDeletes, InteractsWithMedia;
	
	protected $fillable = [
        'site_name',
        'logo',
        'favicon',
        'phone',
        'email',
        'address',
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'youtube',
        'copyright_text',
		'location_map',
		'google_analytic',
    ];
	
	
	public function registerMediaConversions(Media $media = null): void
    {
		//$this->addMediaConversion('small')->fit(Fit::Crop, 50, 50)->format('webp')->quality(50)->nonQueued();
		//$this->addMediaConversion('thumbnail')->fit(Fit::Crop, 300, 300)->format('webp')->quality(50)->nonQueued();
		//$this->addMediaConversion('medium')->fit(Fit::Max, 600, 600)->format('webp')->quality(50)->nonQueued();
		//$this->addMediaConversion('large')->fit(Fit::Max, 800, 800)->format('webp')->quality(50)->nonQueued();
		$this->addMediaConversion('full')->format('webp')->quality(50)->nonQueued(); 
		
		
		//php artisan media-library:regenerate
		//php artisan media-library:clear
		//php artisan media-library:clean
		
    }
	
}
