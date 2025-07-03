<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #dddddd; text-align: left; padding: 8px; font-size: 12px;}
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Laporan Absensi</h2>
    <p>Periode: {{ \Carbon\Carbon::parse(request('startDate'))->isoFormat('D MMMM Y') }} - {{ \Carbon\Carbon::parse(request('endDate'))->isoFormat('D MMMM Y') }}</p>
    <table>
        <thead>
            <tr>
                @if(auth()->user()->hasRole('admin'))
                    <th>Nama Karyawan</th>
                @endif
                <th>Tanggal</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $attendance)
            <tr>
                @if(auth()->user()->hasRole('admin'))
                    <td>{{ $attendance->employee->nama_lengkap ?? 'N/A' }}</td>
                @endif
                <td>{{ \Carbon\Carbon::parse($attendance->tanggal)->isoFormat('D MMM Y') }}</td>
                <td>{{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i:s') : '-' }}</td>
                <td>{{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i:s') : '-' }}</td>
                <td>{{ $attendance->status_kehadiran }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
