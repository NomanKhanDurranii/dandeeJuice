<?php

namespace App\Providers;

use App\Models\CarouselSlide;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Product;
use App\Models\Review;
use App\Observers\CarouselSlideObserver;
use App\Observers\CategoryObserver;
use App\Observers\FaqObserver;
use App\Observers\ProductObserver;
use App\Observers\ReviewObserver;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->registerObservers();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function registerObservers(): void
    {
        Product::observe(ProductObserver::class);
        Category::observe(CategoryObserver::class);
        CarouselSlide::observe(CarouselSlideObserver::class);
        Faq::observe(FaqObserver::class);
        Review::observe(ReviewObserver::class);
    }

    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
