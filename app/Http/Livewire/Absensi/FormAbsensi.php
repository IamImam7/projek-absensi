<?php

namespace App\Http\Livewire\Absensi;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Settings\GeneralSettings;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
class FormAbsensi extends Component
{
     use WithFileUploads;
    public $employee;
     public $tipe_absensi = 'Di Kantor';
    public $foto_bukti;
    public $catatan_pekerjaan;
    public ?Attendance $todayAttendance;
    public bool $isCheckInAllowed = false;
    public bool $isCheckOutAllowed = false;

    public function mount()
    {
        $this->employee = Auth::user()->employee;
        $this->checkAttendanceStatus();
    }

    public function checkAttendanceStatus()
    {
        $this->todayAttendance = Attendance::where('employee_id', $this->employee->id)
            ->where('tanggal', today())
            ->first();

        $now = now();
        // Jam kerja: 07:00 - 17:00
        $this->isCheckInAllowed = !$this->todayAttendance && $now->between(today()->setTime(7, 0), today()->setTime(17, 0));
        $this->isCheckOutAllowed = $this->todayAttendance && !$this->todayAttendance->check_out && $now->isAfter(today()->setTime(16, 0));
    }

    public function checkIn(GeneralSettings $settings)
    {
        // Validasi ulang untuk mencegah double-click
        if (!$this->isCheckInAllowed) return;
        $this->validate([
            'tipe_absensi' => 'required|in:Di Kantor,Luar Kantor',
            'foto_bukti' => Rule::requiredIf($this->tipe_absensi == 'Luar Kantor') . '|nullable|image|max:2048', // Wajib jika 'Luar Kantor', maks 2MB
            'catatan_pekerjaan' => Rule::requiredIf($this->tipe_absensi == 'Luar Kantor') . '|nullable|string|min:10',
        ]);
        $batasTerlambat = $settings->batas_jam_terlambat;

        // Validasi jam terlambat (misal: setelah jam 08:00)
         $status = now()->format('H:i:s') > $batasTerlambat ? 'Terlambat' : 'Tepat Waktu';

          $path_foto = null;
        if ($this->foto_bukti) {
            // Simpan foto ke storage/app/public/bukti-absensi
            $path_foto = $this->foto_bukti->store('bukti-absensi', 'public');
        }
        Attendance::create([
            'employee_id' => $this->employee->id,
            'tanggal' => today(),
            'check_in' => now()->format('H:i:s'),
            'status_kehadiran' => $status,
             'tipe_absensi' => $this->tipe_absensi, // <-- 5. Simpan data baru
            'foto_bukti' => $path_foto,
            'catatan_pekerjaan' => $this->catatan_pekerjaan,
        ]);

        session()->flash('success', 'Check-in berhasil direkam!');
         $this->reset(['tipe_absensi', 'foto_bukti', 'catatan_pekerjaan']);
        $this->checkAttendanceStatus();
    }

    public function checkOut()
    {
        if (!$this->isCheckOutAllowed) return;

        $this->todayAttendance->update([
            'check_out' => now()->format('H:i:s'),
        ]);

        session()->flash('success', 'Check-out berhasil direkam!');
        $this->checkAttendanceStatus(); // Refresh status
    }

    public function render()
    {
        return view('livewire.absensi.form-absensi');
    }
}
