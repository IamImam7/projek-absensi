<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\Employee;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')] // <-- Pastikan attribute ini ada
class Dashboard extends Component
{
    public string $greeting;
    public array $todayStats = [];
    public ?Attendance $employeeAttendanceToday = null;
    public array $chartData = [];

    public function mount()
    {
        $hour = now()->format('H');
        if ($hour < 12) {
            $this->greeting = 'Selamat Pagi';
        } elseif ($hour < 18) {
            $this->greeting = 'Selamat Siang';
        } else {
            $this->greeting = 'Selamat Malam';
        }
    }

    public function prepareChartData()
    {
        $user = Auth::user();
         /** @var \App\Models\User $user */
        if ($user->hasRole('admin')) {
            $attendances = Attendance::whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->get()
                ->groupBy(function($date) {
                    return \Carbon\Carbon::parse($date->tanggal)->format('d');
                });

            $labels = [];
            $tepatWaktu = [];
            $terlambat = [];

            for ($i = 1; $i <= now()->day; $i++) {
                $day = str_pad($i, 2, '0', STR_PAD_LEFT);
                $labels[] = $day;

                if (isset($attendances[$day])) {
                    $tepatWaktu[] = $attendances[$day]->where('status_kehadiran', 'Tepat Waktu')->count();
                    $terlambat[] = $attendances[$day]->where('status_kehadiran', 'Terlambat')->count();
                } else {
                    $tepatWaktu[] = 0;
                    $terlambat[] = 0;
                }
            }

            $this->chartData = [ 'labels' => $labels, /* ... data lainnya ... */ ];
            $this->dispatch('update-chart', data: $this->chartData);
        }
    }

    public function render()
    {
        $user = Auth::user();
        /** @var \App\Models\User $user */
        if ($user->hasRole('admin')) {
            $totalEmployees = Employee::where('status_karyawan', 'Aktif')->count();
            $presentToday = Attendance::where('tanggal', today())->whereNotNull('check_in')->count();
            $lateToday = Attendance::where('tanggal', today())->where('status_kehadiran', 'Terlambat')->count();

            $this->todayStats = [
                'hadir' => $presentToday, 'terlambat' => $lateToday, 'absen' => $totalEmployees - $presentToday, 'total' => $totalEmployees,
            ];
        } else {
            $employee = $user->employee;
            if ($employee) {
                $this->employeeAttendanceToday = Attendance::where('employee_id', $employee->id)
                    ->where('tanggal', today())->first();
            }
        }
        $this->prepareChartData();

        return view('livewire.dashboard'); // <-- Pastikan me-return view yang benar
    }
}
