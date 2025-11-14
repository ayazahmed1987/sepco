<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

use Illuminate\Notifications\Notifiable;



class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
	
	// Optional: define conversions (like thumbnail)
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('small')->fit(Fit::Crop, 50, 50)->format('webp')->quality(50)->nonQueued();
		$this->addMediaConversion('thumbnail')->fit(Fit::Crop, 300, 300)->format('webp')->quality(50)->nonQueued();
		$this->addMediaConversion('medium')->fit(Fit::Crop, 600, 600)->format('webp')->quality(50)->nonQueued();
		$this->addMediaConversion('large')->fit(Fit::Max, 800, 800)->format('webp')->quality(50)->nonQueued();
		$this->addMediaConversion('full')->format('webp')->quality(50)->nonQueued();
    }
}
