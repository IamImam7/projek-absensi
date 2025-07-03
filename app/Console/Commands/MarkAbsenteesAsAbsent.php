<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;

class MarkAbsenteesAsAbsent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // Nama command yang akan kita panggil di terminal
    protected $signature = 'app:mark-absentees-as-absent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tandai karyawan aktif yang tidak check-in sebagai "Absen" pada hari kerja.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Menggunakan Carbon dengan timezone yang sudah kita atur di config/app.php
        $today = Carbon::today();

        // 1. Jangan jalankan command jika hari ini adalah hari Minggu
        if ($today->isSunday()) {
            $this->info('Hari ini adalah hari Minggu. Command tidak dijalankan.');
            return;
        }

        // 2. Dapatkan ID semua karyawan yang sudah melakukan absensi hari ini
        $presentEmployeeIds = Attendance::where('tanggal', $today->toDateString())
            ->pluck('employee_id')
            ->toArray();

        // 3. Dapatkan semua karyawan aktif yang TIDAK ADA di dalam daftar yang sudah absen
        $absentEmployees = Employee::where('status_karyawan', 'Aktif')
            ->whereNotIn('id', $presentEmployeeIds)
            ->get();

        if ($absentEmployees->isEmpty()) {
            $this->info('Semua karyawan aktif telah melakukan absensi hari ini.');
            return;
        }

        $this->info("Menemukan {$absentEmployees->count()} karyawan yang tidak hadir. Memproses...");

        // 4. Loop setiap karyawan yang tidak hadir dan buat record absensi untuk mereka
        foreach ($absentEmployees as $employee) {
            Attendance::create([
                'employee_id' => $employee->id,
                'tanggal' => $today->toDateString(),
                'status_kehadiran' => 'Absen',
                'check_in' => null, // Tidak ada check-in
                'check_out' => null,
                'keterangan' => 'Tidak melakukan check-in.',
            ]);
            $this->line("Karyawan '{$employee->nama_lengkap}' telah ditandai sebagai Absen.");
        }

        $this->info('Proses selesai. Semua karyawan yang tidak hadir telah ditandai.');
    }
}
