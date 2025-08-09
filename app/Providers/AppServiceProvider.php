<?php

namespace App\Providers;

use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\DB;
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
            // Only when connection to DB is established, set configurations
            $connected = rescue(fn () => DB::connection()->getPdo(), false, report: false);
            if (! $connected) {
                return;
            }

            $settings = app(GeneralSettings::class);

            config()->set('backup-server.notifications.mail.to', $settings->emailToNotify);
        });
    }
}
