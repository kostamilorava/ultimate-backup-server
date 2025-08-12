<?php

namespace App\Filament\Resources\Destinations\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Destinations\DestinationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDestinations extends ListRecords
{
    protected static string $resource = DestinationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
