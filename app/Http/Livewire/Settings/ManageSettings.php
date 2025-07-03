<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Settings\GeneralSettings;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ManageSettings extends Component
{
    // Properti untuk di-binding ke form
    public string $jam_masuk_kerja = '';
    public string $batas_jam_terlambat = '';
    public string $jam_pulang_kerja = '';
    public ?float $lokasi_lat;
    public ?float $lokasi_lon;

    // Inisialisasi properti dengan data pengaturan yang sudah ada
    public function mount(GeneralSettings $settings)
    {
        $this->jam_masuk_kerja = $settings->jam_masuk_kerja ?? '08:00:00';
        $this->batas_jam_terlambat = $settings->batas_jam_terlambat ?? '08:15:00';
        $this->jam_pulang_kerja = $settings->jam_pulang_kerja ?? '17:00:00';
        $this->lokasi_lat = $settings->lokasi_lat;
        $this->lokasi_lon = $settings->lokasi_lon;
    }

    public function save(GeneralSettings $settings)
    {
        $validated = $this->validate([
            'jam_masuk_kerja' => 'required|date_format:H:i:s',
            'batas_jam_terlambat' => 'required|date_format:H:i:s',
            'jam_pulang_kerja' => 'required|date_format:H:i:s',
            'lokasi_lat' => 'nullable|numeric',
            'lokasi_lon' => 'nullable|numeric',
        ]);

        // Simpan semua data ke pengaturan
        $settings->fill($validated);
        $settings->save();

        session()->flash('success', 'Pengaturan berhasil disimpan.');
    }

    public function render()
    {
        return view('livewire.settings.manage-settings');
    }
}
