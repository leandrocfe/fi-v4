<?php

namespace App\Providers;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\TextInput;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Assets\Js;
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
        TextInput::configureUsing(function(TextInput $input){
            $input->autocomplete(false);
        });
        FilamentAsset::register([
            Js::make('slug', 'https://cdn.jsdelivr.net/npm/slug@9.1.0/slug.min.js'),
            Js::make('custom-script', __DIR__ . '/../../resources/js/custom.js'),
        ]);
    }
}
