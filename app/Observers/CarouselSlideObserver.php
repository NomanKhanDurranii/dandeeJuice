<?php

namespace App\Observers;

use App\Models\CarouselSlide;
use Illuminate\Support\Facades\Cache;

class CarouselSlideObserver
{
    public function saved(CarouselSlide $slide): void
    {
        Cache::forget('homepage.slides');
    }

    public function deleted(CarouselSlide $slide): void
    {
        Cache::forget('homepage.slides');
    }
}
