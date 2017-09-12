<?php

namespace NotificationChannels\Flowroute;

use Illuminate\Support\ServiceProvider;

class FlowrouteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->singleton(Flowroute::class, function ($app) {
            return new Flowroute(config('services.flowroute'));
        });
    }
}
