<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Enums\Fit;

class CarouselSlide extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'subtitle',
        'button_text',
        'button_url',
        'order_column',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('slide')->useDisk('public')->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('banner')
            ->fit(Fit::Crop, 1920, 600)
            ->quality(80)
            ->performOnCollections('slide');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order_column');
    }
}
