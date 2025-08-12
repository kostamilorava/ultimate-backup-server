<?php

namespace App\Filament\Resources\Logs;

use Filament\Schemas\Schema;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\Logs\Pages\ListLogs;
use App\Filament\Resources\LogResource\Pages;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Spatie\BackupServer\Models\BackupLogItem;

class LogResource extends Resource
{
    protected static ?string $model = BackupLogItem::class;
    protected static ?string $label = "Logs";

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-folder-open';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('source_id')
                    ->relationship('source', 'name')
                    ->label('Source')
                    ->disabled()
                    ->visibleOn('view'),

                Select::make('backup_id')
                    ->relationship('backup', 'id')
                    ->label('Backup')
                    ->disabled()
                    ->visibleOn('view'),

                TextInput::make('task')
                    ->disabled()
                    ->visibleOn('view'),

                TextInput::make('level')
                    ->disabled()
                    ->visibleOn('view'),

                Textarea::make('message')
                    ->rows(6)
                    ->disabled()
                    ->visibleOn('view'),

                DateTimePicker::make('created_at')
                    ->label('Created At')
                    ->disabled()
                    ->visibleOn('view'),

                DateTimePicker::make('updated_at')
                    ->label('Updated At')
                    ->disabled()
                    ->visibleOn('view'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('source.name')
                    ->label('Source')
                    ->sortable(),

                TextColumn::make('backup.id')
                    ->label('Backup')
                    ->sortable(),

                TextColumn::make('task')
                    ->sortable(),

                TextColumn::make('level')
                    ->badge()
                    ->sortable()
                    ->color(fn (string $state): string => match ($state) {
                        'error' => 'danger',
                        'info' => 'success',
                        default => 'primary',
                    }),

                TextColumn::make('message')
                    ->limit(50)
                    ->wrap(),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLogs::route('/'),
        ];
    }
}
