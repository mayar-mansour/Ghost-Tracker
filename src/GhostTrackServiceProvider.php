<?php
namespace Mayar\GhostTrack;

use Illuminate\Support\ServiceProvider;

class GhostTrackServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/quiet-logger.php', 'quiet-logger');

        $this->app->singleton('quiet-logger', function () {
            return new GhostTrackManager();
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/quiet-logger.php' => config_path('quiet-logger.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
