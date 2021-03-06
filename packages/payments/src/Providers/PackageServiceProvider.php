<?php

namespace Packages\Payments\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Packages\Payments\Console\Commands\CompleteDeposits;
use Packages\Payments\Console\Commands\SendWithdrawals;

class PackageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $packageBaseDir = __DIR__ . '/../../';
        // load migrations
        $this->loadMigrationsFrom($packageBaseDir . 'database/migrations');
        // load routes
        $this->loadRoutesFrom($packageBaseDir . 'routes/web.php');
        // load views fom current package
        $this->loadViewsFrom($packageBaseDir . 'resources/views', 'payments');
        // register commands and schedules
        if ($this->app->runningInConsole()) {
            $this->commands([
                CompleteDeposits::class,
                SendWithdrawals::class
            ]);

            $this->app->booted(function () {
                $schedule = $this->app->make(Schedule::class);
                $schedule->command('deposits:complete')->everyMinute();
                $schedule->command('withdrawals:send')->everyFiveMinutes();
            });
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $packageBaseDir = __DIR__ . '/../../';
        // load package config
        $this->mergeConfigFrom(
            $packageBaseDir . 'config/config.php', 'payments'
        );

        // register package event service provider
        $this->app->register(EventServiceProvider::class);
    }
}
