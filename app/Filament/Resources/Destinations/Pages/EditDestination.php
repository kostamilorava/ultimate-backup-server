<?php

namespace App\Filament\Resources\Destinations\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\Destinations\DestinationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDestination extends EditRecord
{
    protected static string $resource = DestinationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
