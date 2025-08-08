<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Command\Command as CommandAlias;

class DeleteOldLogs extends Command
{
    protected $signature = 'logs:delete';

    protected $description = 'Delete old logs';

    public function handle(): int
    {
        $weekAgo = Carbon::now()->subWeek();

        DB::table('backup_server_backup_log')
            ->where('created_at', '<', $weekAgo)
            ->delete();

        $this->info('Old logs have been deleted');

        return CommandAlias::SUCCESS;
    }
}
