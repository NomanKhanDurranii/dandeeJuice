<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    public function saved(Product $product): void
    {
        $this->clearCache($product);
    }

    public function deleted(Product $product): void
    {
        $this->clearCache($product);
    }

    private function clearCache(Product $product): void
    {
        Cache::forget('homepage.data');
        Cache::forget('nav.categories');
        Cache::forget("product.{$product->slug}");

        if ($product->category_id) {
            Cache::forget("category.{$product->category_id}.products");
        }
    }
}
