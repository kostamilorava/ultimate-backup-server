<?php

namespace App\Filament\Resources\Sources\RelationManagers;

use App\Filament\Resources\Backups\BackupResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Spatie\BackupServer\Models\Backup;
use Spatie\BackupServer\Tasks\Backup\Actions\CreateBackupAction;

class BackupsRelationManager extends RelationManager
{
    protected static string $relationship = 'backups';

    protected static ?string $relatedResource = BackupResource::class;

    public function table(Table $table): Table
    {
        //(new CreateBackupAction)->execute($source)
        return $table
            ->headerActions([
                Action::make('Dispatch new backup job')
                    ->requiresConfirmation()
                    ->action(function () {
                        $source = $this->getOwnerRecord();
                        (new CreateBackupAction)->execute($source);

                        Notification::make()
                            ->title('Job dispatched successfully')
                            ->success()
                            ->send();
                    })
            ]);
    }
}
