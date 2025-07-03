<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

     protected $fillable = [
        'employee_id',
        'jenis_cuti',
        'tanggal_mulai',
        'tanggal_selesai',
        'alasan',
        'file_pendukung',
        'status_pengajuan',
        'approved_by',
        'catatan_admin',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

     public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Relasi ke user yang menyetujui/menolak
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
