<?php

namespace App\Http\Livewire\Absensi;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class RiwayatAbsensi extends Component
{
    // Gunakan trait untuk pagination
    use WithPagination;

    // Properti untuk filter
    public $startDate;
    public $endDate;
    public $search = '';

    // Lindungi dari error jika user belum login
    protected $employee;

    public function mount()
    {
        // Set tanggal default: awal dan akhir bulan ini
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->endOfMonth()->format('Y-m-d');

        // Ambil data employee dari user yang login
        $this->employee = Auth::user()->employee;
    }

    // Method ini akan dipanggil setiap kali ada perubahan pada properti
    public function updatingSearch()
    {
        $this->resetPage(); // Reset pagination saat melakukan pencarian
    }

    #[Layout('layouts.app')]
    public function render()
    {
        // Mulai query dasar
        $query = Attendance::with('employee')
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->orderBy('tanggal', 'desc');

         $user = Auth::user();

    // TAMBAHKAN KOMENTAR INI
    /** @var \App\Models\User $user */
        // Filter berdasarkan role
         /** @var \App\Models\User $user */
        if ($user->hasRole('karyawan')) {
            // Jika karyawan, hanya tampilkan data miliknya
            if ($this->employee) {
                $query->where('employee_id', $this->employee->id);
            } else {
                // Handle jika user karyawan tidak punya relasi employee
                $query->whereRaw('1 = 0'); // Trik untuk tidak menampilkan data
            }
        } else {
            // Jika admin, izinkan pencarian berdasarkan nama karyawan
            if (!empty($this->search)) {
                $query->whereHas('employee', function ($q) {
                    $q->where('nama_lengkap', 'like', '%' . $this->search . '%');
                });
            }
        }

        // Ambil data dengan pagination
        $attendances = $query->paginate(10);

        return view('livewire.absensi.riwayat-absensi', [
            'attendances' => $attendances,
        ]);
    }


public function exportExcel()
{
    $params = http_build_query([
        'startDate' => $this->startDate,
        'endDate' => $this->endDate,
        'search' => $this->search
    ]);

    return redirect()->to(route('laporan.absensi.excel') . '?' . $params);
}
public function exportPdf()
{
     $params = http_build_query([
        'startDate' => $this->startDate,
        'endDate' => $this->endDate,
        'search' => $this->search
    ]);

    return redirect()->to(route('laporan.absensi.pdf') . '?' . $params);
}
}
