<?php

namespace App\Filament\Resources\Sources\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\Sources\SourceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSource extends EditRecord
{
    protected static string $resource = SourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
