<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BackupResource\Pages;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Spatie\BackupServer\Models\Backup;

class BackupResource extends Resource
{
    protected static ?string $model = Backup::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('status')
                    ->required()
                    ->maxLength(255),

                Select::make('destination_id')
                    ->label('Backup Destination')
                    ->relationship('destination', 'name')
                    ->nullable(),

                Select::make('source_id')
                    ->label('Backup Source')
                    ->relationship('source', 'name')
                    ->nullable(),

                TextInput::make('disk_name')
                    ->required()
                    ->maxLength(255)
                    ->label('Disk Name'),

                TextInput::make('path')
                    ->nullable(),

                TextInput::make('size_in_kb')
                    ->label('Size (KB)')
                    ->numeric()
                    ->minValue(0)
                    ->step(1),

                TextInput::make('real_size_in_kb')
                    ->label('Real Size (KB)')
                    ->numeric()
                    ->minValue(0)
                    ->step(1),

                Forms\Components\Textarea::make('rsync_summary')
                    ->label('Rsync Summary')
                    ->rows(5)
                    ->nullable(),

                TextInput::make('rsync_time_in_seconds')
                    ->label('Rsync Duration (s)')
                    ->numeric()
                    ->minValue(0)
                    ->step(1)
                    ->nullable(),

                TextInput::make('rsync_current_transfer_speed')
                    ->label('Current Speed')
                    ->nullable(),

                TextInput::make('rsync_average_transfer_speed_in_MB_per_second')
                    ->label('Avg Speed (MB/s)')
                    ->nullable(),

                DateTimePicker::make('completed_at')
                    ->label('Completed At'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('status')->sortable(),
                TextColumn::make('destination.name')
                    ->label('Backup Destination')
                    ->sortable(),
                TextColumn::make('source.name')
                    ->label('Backup Source')
                    ->sortable(),
                TextColumn::make('disk_name')
                    ->label('Disk Name')
                    ->sortable(),
                TextColumn::make('path')->sortable(),
                TextColumn::make('size_in_kb')
                    ->label('Size')
                    ->sortable()
                    ->formatStateUsing(fn (int $state) => static::formatSize($state)),
                TextColumn::make('real_size_in_kb')
                    ->label('Real Size')
                    ->sortable()
                    ->formatStateUsing(fn (int $state) => static::formatSize($state)),
                TextColumn::make('completed_at')
                    ->label('Completed At')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('rsync_summary')
                    ->label('Summary')
                    ->limit(50),

                TextColumn::make('rsync_time_in_seconds')
                    ->label('Duration (s)')
                    ->sortable(),

                TextColumn::make('rsync_current_transfer_speed')
                    ->label('Current Speed'),

                TextColumn::make('rsync_average_transfer_speed_in_MB_per_second')
                    ->label('Avg Speed (MB/s)'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    protected static function formatSize(int $value): string
    {
        $sizeInMB = $value / 1024;
        $sizeInGB = $sizeInMB / 1024;

        if ($sizeInGB >= 1) {
            return number_format($sizeInGB, 2).' GB';
        }

        if ($sizeInMB >= 1) {
            return number_format($sizeInMB, 2).' MB';
        }

        return $value.' KB';
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
            'index' => Pages\ListBackups::route('/'),
        ];
    }
}
