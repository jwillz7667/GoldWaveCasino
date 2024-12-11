<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ErrorHandlingServiceProvider extends ServiceProvider
{
    public function register()
    {
        if (!config('app.debug')) {
            error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
            ini_set('display_errors', 'Off');
        }
    }

    public function boot()
    {
        //
    }
} 