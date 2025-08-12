<?php

namespace App\Filament\Pages;

use Filament\Schemas\Schema;
use App\Settings\GeneralSettings as GeneralSettingsSetting;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;

class GeneralSettings extends SettingsPage
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = GeneralSettingsSetting::class;

    protected static ?int $navigationSort = 10;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Toggle::make('backupEnabled')
                    ->label('Enable or disable future backup tasks')
                    ->required(),

                TextInput::make('emailToNotify')
                    ->label('Email to notify users about backup progress')
                    ->required(),
            ]);
    }
}
