<?php

namespace App\Observers;

use App\Models\Review;
use Illuminate\Support\Facades\Cache;

class ReviewObserver
{
    public function saved(Review $review): void
    {
        if ($review->product) {
            Cache::forget("product.{$review->product->slug}");
        }
    }
}
