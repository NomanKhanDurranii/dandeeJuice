<?php

namespace App\Http\Controllers;

use App\Models\CarouselSlide;
use App\Models\Category;
use App\Models\Faq;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('order_column')
            ->with(['activeProducts' => fn ($q) => $q->orderBy('order_column')])
            ->get();

        $slides = CarouselSlide::active()->get();

        return view('welcome', compact('categories', 'slides'));
    }

    public function contact(): View
    {
        $categories = Category::where('is_active', true)->orderBy('order_column')->get();
        $faqs = Faq::active()->get();

        return view('contact', compact('categories', 'faqs'));
    }

    public function about(): View
    {
        $categories = Category::where('is_active', true)->orderBy('order_column')->get();

        return view('about', compact('categories'));
    }

    public function catering(): View
    {
        $categories = Category::where('is_active', true)->orderBy('order_column')->get();

        return view('catering', compact('categories'));
    }
}
