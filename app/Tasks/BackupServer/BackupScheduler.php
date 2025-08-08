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
    private readonly GeneralSettings $generalSettings;

    public function shouldBackupNow(Source $source): bool
    {

        $backupEnabled = $this->generalSettings->backupEnabled;

        if (! $backupEnabled) {
            return false;
        }

        $shouldBeBackedUpByCron = (new CronExpression($source->cron_expression))->isDue(Carbon::now());

        $pendingBackup = Backup::where([
            'status' => 'pending',
            'source_id' => $source->id,
        ])->count();

        return $shouldBeBackedUpByCron && ! $pendingBackup;
    }
}
