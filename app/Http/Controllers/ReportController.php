<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\AbsensiExport;
use App\Models\Attendance;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf; // 1. PASTIKAN ANDA MENGGUNAKAN 'use' STATEMENT INI

class ReportController extends Controller
{
    public function exportExcel(Request $request)
    {
        $startDate = $request->query('startDate', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->query('endDate', now()->endOfMonth()->format('Y-m-d'));
        $search = $request->query('search');

        return Excel::download(new AbsensiExport($startDate, $endDate, $search), 'laporan-absensi.xlsx');
    }

    // 2. HAPUS 'DomPDF $pdf' DARI PARAMETER METHOD DI BAWAH INI
    public function exportPdf(Request $request)
    {
        $startDate = $request->query('startDate', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->query('endDate', now()->endOfMonth()->format('Y-m-d'));
        $search = $request->query('search');
        $user = Auth::user();

        // Query data (tanpa pagination)
        $query = Attendance::with('employee')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc');
 /** @var \App\Models\User $user */
        if ($user->hasRole('karyawan')) {
            $query->where('employee_id', $user->employee->id);
        } else {
            if (!empty($search)) {
                $query->whereHas('employee', function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', '%' . $search . '%');
                });
            }
        }
        $attendances = $query->get();

        // 3. GUNAKAN FACADE 'PDF' UNTUK MEMBUAT FILE PDF
        $pdf = PDF::loadView('reports.absensi-pdf', compact('attendances'));

        // Download PDF
        return $pdf->download('laporan-absensi.pdf');
    }
}
