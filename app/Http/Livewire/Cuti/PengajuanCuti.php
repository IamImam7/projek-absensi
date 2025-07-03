<?php

namespace App\Http\Livewire\Cuti;

// Pastikan Anda meng-import Component dari Livewire
use App\Models\User;
use Livewire\Component;
use App\Models\LeaveRequest;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

// Pastikan komponen ini menggunakan layout utama
#[Layout('layouts.app')]
// Pastikan class ini "extends Component"
class PengajuanCuti extends Component
{
    // Properti untuk form
    public $jenis_cuti = 'Cuti Tahunan';
    public $tanggal_mulai;
    public $tanggal_selesai;
    public $alasan;

    /**
     * Method ini berjalan saat komponen pertama kali dimuat.
     */
    public function mount()
    {
        $this->tanggal_mulai = now()->format('Y-m-d');
        $this->tanggal_selesai = now()->format('Y-m-d');
    }

    /**
     * Method untuk menyimpan pengajuan cuti.
     */
    public function submit()
    {
        $this->validate([
            'jenis_cuti' => 'required|in:Cuti Tahunan,Sakit,Izin Khusus',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|min:10',
        ]);

        LeaveRequest::create([
            'employee_id' => Auth::user()->employee->id,
            'jenis_cuti' => $this->jenis_cuti,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
            'alasan' => $this->alasan,
            'status_pengajuan' => 'Menunggu',
        ]);

        session()->flash('success', 'Pengajuan cuti berhasil dikirim.');

        // ---- GANTI BAGIAN NOTIFIKASI ----
        // Ambil semua user dengan role admin
        $admins = User::role('admin')->get();
        $namaKaryawan = auth()->user()->name;

        // Buat notifikasi di database untuk setiap admin
        foreach ($admins as $admin) {
            \App\Models\RealtimeNotification::create([
                'user_id' => $admin->id,
                'message' => "Pengajuan cuti baru dari {$namaKaryawan}",
            ]);
        }

        // Reset form setelah berhasil
        $this->reset(['jenis_cuti', 'alasan']);
        $this->mount();
    }

    /**
     * Method untuk merender view.
     */
    public function render()
    {
        $riwayatPengajuan = LeaveRequest::where('employee_id', Auth::user()->employee->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.cuti.pengajuan-cuti', [
            'riwayatPengajuan' => $riwayatPengajuan,
        ]);
    }
}
