<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'divisi',
        'jabatan',
        'status_karyawan',
        'tanggal_bergabung',
    ];

     public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi one-to-many ke Attendances
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Relasi one-to-many ke LeaveRequests
     */
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }
}
