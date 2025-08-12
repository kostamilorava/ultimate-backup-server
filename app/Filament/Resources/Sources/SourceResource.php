<?php

namespace App\Filament\Resources\Sources;

use Filament\Schemas\Schema;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\Sources\Pages\ListSources;
use App\Filament\Resources\Sources\Pages\CreateSource;
use App\Filament\Resources\Sources\Pages\EditSource;
use App\Filament\Resources\SourceResource\Pages;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Spatie\BackupServer\Models\Source as SourceModel;

class SourceResource extends Resource
{
    protected static ?string $model = SourceModel::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('status')
                    ->default('active')
                    ->required()
                    ->maxLength(255),

                Toggle::make('healthy')
                    ->label('Healthy')
                    ->default(false),

                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('host')
                    ->required()
                    ->maxLength(255),

                TextInput::make('ssh_user')
                    ->label('SSH User')
                    ->required()
                    ->maxLength(255),

                TextInput::make('ssh_port')
                    ->label('SSH Port')
                    ->numeric()
                    ->default(22)
                    ->required(),

                TextInput::make('ssh_private_key_file')
                    ->label('SSH Private Key File')
                    ->maxLength(512)
                    ->nullable(),

                TextInput::make('cron_expression')
                    ->label('Cron Expression')
                    ->required(),

                KeyValue::make('pre_backup_commands')
                    ->label('Pre Backup Commands')
                    ->columns(1)
                    ->nullable(),

                KeyValue::make('post_backup_commands')
                    ->label('Post Backup Commands')
                    ->columns(1)
                    ->nullable(),

                KeyValue::make('includes')
                    ->label('Includes')
                    ->columns(1)
                    ->nullable(),

                KeyValue::make('excludes')
                    ->label('Excludes')
                    ->columns(1)
                    ->nullable(),

                Select::make('destination_id')
                    ->label('Backup Destination')
                    ->relationship('destination', 'name')
                    ->nullable(),

                TextInput::make('cleanup_strategy_class')
                    ->label('Cleanup Strategy Class')
                    ->maxLength(255)
                    ->nullable(),

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

                TextInput::make('healthy_maximum_backup_age_in_days')
                    ->label('Healthy Max Age (Days)')
                    ->numeric()
                    ->nullable(),

                TextInput::make('healthy_maximum_storage_in_mb')
                    ->label('Healthy Max Storage (MB)')
                    ->numeric()
                    ->nullable(),

                DateTimePicker::make('pause_notifications_until')
                    ->label('Pause Notifications Until')
                    ->nullable(),

                DateTimePicker::make('completed_at')
                    ->label('Completed At')
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
            ->defaultSort('id', 'desc')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('status')->sortable()->searchable(),
                TextColumn::make('name')->sortable()->searchable(),
                IconColumn::make('healthy')
                    ->label('Healthy')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->colors([])
                    ->sortable(),
                TextColumn::make('host')->sortable()->searchable(),
                TextColumn::make('ssh_user')->label('SSH User')->sortable()->searchable(),
                TextColumn::make('ssh_port')->label('SSH Port')->sortable(),
                TextColumn::make('cron_expression')->label('Cron Expression')->sortable()->searchable(),
                TextColumn::make('destination.name')->label('Backup Destination')->sortable()->searchable(),
                TextColumn::make('created_at')->dateTime()->label('Created At')->sortable(),
                TextColumn::make('updated_at')->dateTime()->label('Updated At')->sortable(),
            ])
            ->filters([
                Filter::make('active')
                    ->query(fn (Builder $query) => $query->where('status', 'active'))
                    ->label('Active'),
                Filter::make('healthy')
                    ->query(fn (Builder $query) => $query->where('healthy', true))
                    ->label('Healthy'),
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
            'index' => ListSources::route('/'),
            'create' => CreateSource::route('/create'),
            'edit' => EditSource::route('/{record}/edit'),
        ];
    }
}
