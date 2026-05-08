<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class Product extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'is_active',
        'order_column',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = static::generateUniqueSlug($product->name);
            }
        });
    }

    public static function generateUniqueSlug(string $name): string
    {
        $base = Str::slug($name) ?: 'product';
        $slug = $base;
        $i = 2;
        while (static::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->useDisk('public')
            ->useFallbackUrl('/images/placeholder-product.jpg');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('status', 'approved')->latest();
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class)->orderBy('order_column');
    }

    public function activeVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class)->where('is_active', true)->orderBy('order_column');
    }
}
