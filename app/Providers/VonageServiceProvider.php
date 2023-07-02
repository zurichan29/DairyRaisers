<?php

namespace App\Providers;

use Vonage\Client as VonageClient;
use Vonage\Client\Credentials\Basic;
use Illuminate\Support\ServiceProvider;

class VonageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(VonageClient::class, function ($app) {
            return new VonageClient(new Basic(config('app.VONAGE_API_KEY'), config('app.VONAGE_API_SECRET')));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
