<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Services\IHolidayService;
use App\Http\Services\HolidayService;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
		$this->app->bind(IHolidayService::class, HolidayService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
