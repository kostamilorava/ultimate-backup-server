<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public bool $backupEnabled = true;
    public string $emailToNotify = "";

    public static function group(): string
    {
        return 'general';
    }
}
