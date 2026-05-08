<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ProductController extends Controller
{
    private const TTL = 1800; // 30 minutes

    public function show(string $slug): View
    {
        $product = Cache::remember("product.{$slug}", self::TTL, fn () =>
            Product::where('slug', $slug)
                ->where('is_active', true)
                ->with(['category', 'approvedReviews', 'activeVariants'])
                ->firstOrFail()
        );

        // Related products are not cached — they're random by design
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->inRandomOrder()
            ->take(4)
            ->get();

        $approvedReviews    = $product->approvedReviews;
        $reviewCount        = $approvedReviews->count();
        $avgRating          = $reviewCount > 0 ? round($approvedReviews->avg('rating'), 1) : 0;

        $ratingDistribution = collect(range(5, 1))->mapWithKeys(
            fn ($star) => [$star => $approvedReviews->where('rating', $star)->count()]
        );

        return view('product', compact(
            'product',
            'relatedProducts',
            'avgRating',
            'reviewCount',
            'ratingDistribution',
        ));
    }
}
