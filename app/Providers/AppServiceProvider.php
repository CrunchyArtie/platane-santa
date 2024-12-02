<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->share('settings', $this->getSettings()->toArray());
    }

    private function getSettings()
    {
        return \Schema::hasTable('settings') ? Setting::all()->mapWithKeys(function ($setting) {
            return [$setting->key => $setting->value];
        }) : collect();
    }
}
