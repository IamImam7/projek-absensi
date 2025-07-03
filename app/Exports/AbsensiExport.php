<?php

namespace App\Exports;

use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AbsensiExport implements FromQuery, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;
    protected $search;
    protected $user;

    public function __construct(string $startDate, string $endDate, ?string $search)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->search = $search;
        $this->user = Auth::user();
    }

    public function query()
    {
        // Logika query ini harus sama persis dengan yang ada di komponen Livewire
        $query = Attendance::with('employee')
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->orderBy('tanggal', 'desc');

        if ($this->user->hasRole('karyawan')) {
            $query->where('employee_id', $this->user->employee->id);
        } else {
            if (!empty($this->search)) {
                $query->whereHas('employee', function ($q) {
                    $q->where('nama_lengkap', 'like', '%' . $this->search . '%');
                });
            }
        }
        return $query;
    }

    public function headings(): array
    {
        // Definisikan header kolom
        $headings = [
            'Tanggal',
            'Check-in',
            'Check-out',
            'Status Kehadiran',
            'Keterangan',
        ];
        // Tambahkan kolom 'Nama Karyawan' jika yang mengekspor adalah admin
        if ($this->user->hasRole('admin')) {
            array_unshift($headings, 'Nama Karyawan');
        }
        return $headings;
    }

    public function map($attendance): array
    {
        // Format setiap baris data
        $row = [
            \Carbon\Carbon::parse($attendance->tanggal)->isoFormat('D MMMM Y'),
            $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i:s') : '-',
            $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i:s') : '-',
            $attendance->status_kehadiran,
            $attendance->keterangan,
        ];
        if ($this->user->hasRole('admin')) {
             array_unshift($row, $attendance->employee->nama_lengkap ?? 'N/A');
        }
        return $row;
    }
}
