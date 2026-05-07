<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(string $slug): View
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with(['category', 'approvedReviews'])
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->inRandomOrder()
            ->take(4)
            ->get();

        $approvedReviews = $product->approvedReviews;
        $reviewCount     = $approvedReviews->count();
        $avgRating       = $reviewCount > 0 ? round($approvedReviews->avg('rating'), 1) : 0;

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
