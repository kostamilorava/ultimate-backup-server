<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DestinationResource\Pages;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
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

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListDestinations::route('/'),
            'create' => Pages\CreateDestination::route('/create'),
            'edit' => Pages\EditDestination::route('/{record}/edit'),
        ];
    }
}
