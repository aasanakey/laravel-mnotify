<?php

namespace Sanakey\Mnotify;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Notification;
use Sanakey\Mnotify\MnotifyChannel;

class MnotifyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //Make config publishment optional by merging the config from the package.
        $this->mergeConfigFrom(
            __DIR__.'/../config/mnotify.php',
            'laravel-mnotify'
        );
        Notification::extend('mnotify', function ($app) {
            return new MnotifyChannel();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Publishes configuration file.
        $this->publishes([
            __DIR__.'/../config/mnotify.php' => config_path('mnotify.php'),
        ], 'mnotify-config');
    }
}
