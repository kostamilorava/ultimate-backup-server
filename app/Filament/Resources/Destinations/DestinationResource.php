<?php

namespace App\Filament\Resources\Destinations;

use Filament\Schemas\Schema;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\Destinations\Pages\ListDestinations;
use App\Filament\Resources\Destinations\Pages\CreateDestination;
use App\Filament\Resources\Destinations\Pages\EditDestination;
use App\Filament\Resources\DestinationResource\Pages;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Spatie\BackupServer\Models\Destination as DestinationModel;

class DestinationResource extends Resource
{
    protected static ?string $model = DestinationModel::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-map-pin';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('status')
                    ->default('active')
                    ->required()
                    ->maxLength(255),

                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('disk_name')
                    ->label('Disk Name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('keep_all_backups_for_days')
                    ->label('Keep All Backups (Days)')
                    ->numeric()
                    ->nullable(),

                TextInput::make('keep_daily_backups_for_days')
                    ->label('Keep Daily Backups (Days)')
                    ->numeric()
                    ->nullable(),

                TextInput::make('keep_weekly_backups_for_weeks')
                    ->label('Keep Weekly Backups (Weeks)')
                    ->numeric()
                    ->nullable(),

                TextInput::make('keep_monthly_backups_for_months')
                    ->label('Keep Monthly Backups (Months)')
                    ->numeric()
                    ->nullable(),

                TextInput::make('keep_yearly_backups_for_years')
                    ->label('Keep Yearly Backups (Years)')
                    ->numeric()
                    ->nullable(),

                TextInput::make('delete_oldest_backups_when_using_more_megabytes_than')
                    ->label('Delete Oldest When Exceeding MB')
                    ->numeric()
                    ->nullable(),

                TextInput::make('healthy_maximum_backup_age_in_days_per_source')
                    ->label('Healthy Max Age (Days) per Source')
                    ->numeric()
                    ->nullable(),

                TextInput::make('healthy_maximum_storage_in_mb_per_source')
                    ->label('Healthy Max Storage (MB) per Source')
                    ->numeric()
                    ->nullable(),

                TextInput::make('healthy_maximum_storage_in_mb')
                    ->label('Healthy Max Storage (MB)')
                    ->numeric()
                    ->nullable(),

                TextInput::make('healthy_maximum_inode_usage_percentage')
                    ->label('Healthy Max Inode Usage (%)')
                    ->numeric()
                    ->nullable(),

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
            ->defaultSort('id', 'desc')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('status')->sortable()->searchable(),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('disk_name')->label('Disk Name')->sortable()->searchable(),

                TextColumn::make('created_at')->dateTime()->label('Created At')->sortable(),
                TextColumn::make('updated_at')->dateTime()->label('Updated At')->sortable(),
            ])
            ->filters([
                Filter::make('active')
                    ->query(fn (Builder $query) => $query->where('status', 'active'))
                    ->label('Active'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
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
            'index' => ListDestinations::route('/'),
            'create' => CreateDestination::route('/create'),
            'edit' => EditDestination::route('/{record}/edit'),
        ];
    }
}
