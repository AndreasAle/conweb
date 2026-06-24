<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('*', function ($view) {
            $s = Setting::all_cached();
            $view->with([
                's' => $s,
                'brand' => $s['brand.name'] ?? 'ConWeb',
                'suffix' => $s['brand.suffix'] ?? 'ID',
                'logo' => $s['site.logo'] ?? null,
                'email' => $s['site.email'] ?? 'hello@conweb.id',
                'wa' => $s['site.whatsapp'] ?? '#',
            ]);
        });
    }
}
