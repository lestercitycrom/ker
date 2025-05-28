<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Assets\Css;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register an external CSS file to override Filament styles
        FilamentAsset::register([
            Css::make(
                'filament-overrides',             // unique ID
                asset('css/filament-overrides.css') // URL to your CSS
            ),
        ]);
    }
}
