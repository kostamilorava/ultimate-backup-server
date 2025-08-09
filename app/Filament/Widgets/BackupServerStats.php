<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Spatie\BackupServer\Models\Backup;
use Spatie\BackupServer\Models\Destination;
use Spatie\BackupServer\Models\Source;

class BackupServerStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Destinations', Destination::count()),
            Stat::make('Total Sources', Source::count()),
            Stat::make('Running Backups', Backup::where('status', 'in_progress')->count()),
            Stat::make('Pending Backups', Backup::where('status', 'pending')->count()),
            Stat::make('Completed Backups', Backup::where('status', 'completed')->count()),
            Stat::make('Failed Backups', Backup::where('status', 'failed')->count()),
        ];
    }
}
