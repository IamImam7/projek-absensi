<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'tanggal',
        'check_in',
        'check_out',
        'status_kehadiran',
        'lokasi_check_in',
        'lokasi_check_out',
        'keterangan',
         'tipe_absensi',
    'foto_bukti',
    'catatan_pekerjaan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
