<?php

namespace App\Filament\Resources\Sources\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Sources\SourceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSources extends ListRecords
{
    protected static string $resource = SourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
