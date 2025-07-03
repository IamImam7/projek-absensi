<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Import DB Facade

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kita akan memasukkan data secara manual ke tabel 'settings'
        // untuk menghindari error 'MissingSettings' saat seeding.

        DB::table('settings')->insert([
            [
                'group' => 'general',
                'name' => 'jam_masuk_kerja',
                'payload' => json_encode('08:00:00'),
                'locked' => false,
            ],
            [
                'group' => 'general',
                'name' => 'batas_jam_terlambat',
                'payload' => json_encode('08:15:00'),
                'locked' => false,
            ],
            [
                'group' => 'general',
                'name' => 'jam_pulang_kerja',
                'payload' => json_encode('17:00:00'),
                'locked' => false,
            ],
            [
                'group' => 'general',
                'name' => 'lokasi_lat',
                'payload' => json_encode(-6.2088),
                'locked' => false,
            ],
            [
                'group' => 'general',
                'name' => 'lokasi_lon',
                'payload' => json_encode(106.8456),
                'locked' => false,
            ],
        ]);
    }
}
