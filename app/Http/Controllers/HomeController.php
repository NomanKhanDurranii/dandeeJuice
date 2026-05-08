<?php

namespace App\Http\Controllers;

use App\Models\CarouselSlide;
use App\Models\Category;
use App\Models\Faq;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class HomeController extends Controller
{
    private const TTL = 1800; // 30 minutes

    public function index(): View
    {
        $categories = Cache::remember('homepage.data', self::TTL, fn () =>
            Category::query()
                ->where('is_active', true)
                ->orderBy('order_column')
                ->with(['activeProducts' => fn ($q) => $q->orderBy('order_column')->withCount('activeVariants')])
                ->get()
        );

        $slides = Cache::remember('homepage.slides', self::TTL, fn () =>
            CarouselSlide::active()->get()
        );

        return view('welcome', compact('categories', 'slides'));
    }

    public function contact(): View
    {
        $categories = Cache::remember('nav.categories', self::TTL, fn () =>
            Category::where('is_active', true)->orderBy('order_column')->get()
        );

        $faqs = Cache::remember('faqs.active', self::TTL, fn () =>
            Faq::active()->get()
        );

        return view('contact', compact('categories', 'faqs'));
    }

    public function about(): View
    {
        $categories = Cache::remember('nav.categories', self::TTL, fn () =>
            Category::where('is_active', true)->orderBy('order_column')->get()
        );

        return view('about', compact('categories'));
    }

    public function catering(): View
    {
        $categories = Cache::remember('nav.categories', self::TTL, fn () =>
            Category::where('is_active', true)->orderBy('order_column')->get()
        );

        return view('catering', compact('categories'));
    }
}
