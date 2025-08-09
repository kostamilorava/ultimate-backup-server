<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings as GeneralSettingsSetting;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class GeneralSettings extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = GeneralSettingsSetting::class;

    protected static ?int $navigationSort = 10;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Toggle::make('backupEnabled')
                    ->label('Enable or disable future backup tasks')
                    ->required(),
            ]);
    }
}
