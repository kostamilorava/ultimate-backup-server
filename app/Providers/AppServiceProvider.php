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
        $this->app->booted(function () {
            // TODO@kosta: Refactor this to use bootstrappers instead of ugly approach
            rescue(function () {
                $settings = app(GeneralSettings::class);
                config()->set('backup-server.notifications.mail.to', $settings->emailToNotify);
            }, false, report: false);
        });
    }
}
