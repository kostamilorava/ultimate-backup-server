<?php


use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Spatie\BackupServer\Tasks\Summary\Jobs\SendServerSummaryNotificationJob;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::command('backup-server:dispatch-backups')->everyMinute();
Schedule::command('backup-server:cleanup')->daily();
Schedule::command('backup-server:monitor')->daily();
Schedule::command('logs:delete')->daily();

Schedule::job(new SendServerSummaryNotificationJob(now()->subDay()))->dailyAt('09:00');
