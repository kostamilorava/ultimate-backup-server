<?php

namespace App\Filament\Resources\Logs\Pages;

use App\Filament\Resources\Logs\LogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLogs extends ListRecords
{
    protected static string $resource = LogResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
