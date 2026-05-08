<?php

namespace App\Observers;

use App\Models\ProductVariant;
use Illuminate\Support\Facades\Cache;

class ProductVariantObserver
{
    public function saved(ProductVariant $variant): void
    {
        $this->clearProductCache($variant);
    }

    public function deleted(ProductVariant $variant): void
    {
        $this->clearProductCache($variant);
    }

    private function clearProductCache(ProductVariant $variant): void
    {
        $slug = $variant->product?->slug;
        if ($slug) {
            Cache::forget("product.{$slug}");
        }
        // Also clear home data since active_variants_count changes
        Cache::forget('homepage.data');
    }
}
