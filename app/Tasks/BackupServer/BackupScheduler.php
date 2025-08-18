<?php

namespace App\Tasks\BackupServer;

use App\Settings\GeneralSettings;
use Cron\CronExpression;
use Illuminate\Support\Carbon;
use Spatie\BackupServer\Models\Backup;
use Spatie\BackupServer\Models\Source;
use Spatie\BackupServer\Tasks\Backup\Support\BackupScheduler\BackupScheduler as BackupSchedulerInterface;

class BackupScheduler implements BackupSchedulerInterface
{
    public function shouldBackupNow(Source $source): bool
    {

        $backupEnabled = app(GeneralSettings::class)->backupEnabled;

        // If there are pending backups, or backups in progress, do not schedule a new backup.
        // Also, do not schedule a backup if the last backup was created more than 8 hours ago.
        $pendingOrInProgressBackup = Backup::where('source_id', $source->id)
            ->whereIn('status', ['pending', 'in_progress'])
            ->where('created_at', '>=', Carbon::now()->subHours(8))
            ->exists();

        if (! $backupEnabled || $pendingOrInProgressBackup) {
            return false;
        }

        $shouldBeBackedUpByCron = (new CronExpression($source->cron_expression))->isDue(Carbon::now());

        return $shouldBeBackedUpByCron;
    }
}
