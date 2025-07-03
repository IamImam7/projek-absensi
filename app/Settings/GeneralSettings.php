<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public ?string $jam_masuk_kerja;      // <-- Tambahkan ?
    public ?string $batas_jam_terlambat;  // <-- Tambahkan ?
    public ?string $jam_pulang_kerja;     // <-- Tambahkan ?
    public ?float $lokasi_lat;
    public ?float $lokasi_lon;

    public static function group(): string
    {
        return 'general';
    }
}
