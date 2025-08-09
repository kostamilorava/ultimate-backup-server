<?php

namespace App\Providers;

use App\Settings\GeneralSettings;
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
        // Run after ALL providers (including Spatie) have booted
        $this->app->booted(function () {
            $settings = app(GeneralSettings::class);

            config()->set('backup-server.notifications.mail.to', $settings->emailToNotify);
        });
    }
}
