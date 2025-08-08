<?php
use Spatie\BackupServer\Tasks\Summary\Jobs\SendServerSummaryNotificationJob;


Schedule::command('backup-server:dispatch-backups')->everyMinute();
Schedule::command('backup-server:cleanup')->daily();
Schedule::command('backup-server:monitor')->daily();
Schedule::command('logs:delete')->daily();

Schedule::job(new SendServerSummaryNotificationJob(now()->subDay()))->dailyAt('09:00');
