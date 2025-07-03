<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleAndUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Nonaktifkan pengecekan foreign key untuk truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Role::truncate();
        User::truncate();
        Employee::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Buat Roles
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleKaryawan = Role::create(['name' => 'karyawan']);

        // 2. Buat User Admin
        $adminEmployee = Employee::create([
            'nama_lengkap' => 'Admin Utama',
            'divisi' => 'IT',
            'jabatan' => 'System Administrator',
            'status_karyawan' => 'Aktif',
            'tanggal_bergabung' => now()->subYears(1),
        ]);

        $adminUser = User::create([
            'name' => $adminEmployee->nama_lengkap,
            'email' => 'admin@sakam.com',
            'password' => Hash::make('password'), // Ganti dengan password yang aman
        ]);

        // Hubungkan User dengan Employee dan berikan Role
        $adminEmployee->user_id = $adminUser->id;
        $adminEmployee->save();
        $adminUser->assignRole($roleAdmin);


        // 3. Buat User Karyawan (Contoh)
        $karyawanData = [
            [
                'nama' => 'Budi Santoso',
                'email' => 'budi.s@sakam.com',
                'divisi' => 'Marketing',
                'jabatan' => 'Staff Marketing',
            ],
            [
                'nama' => 'Citra Lestari',
                'email' => 'citra.l@sakam.com',
                'divisi' => 'Keuangan',
                'jabatan' => 'Akuntan',
            ],
            [
                'nama' => 'Doni Firmansyah',
                'email' => 'doni.f@sakam.com',
                'divisi' => 'Operasional',
                'jabatan' => 'Supervisor Lapangan',
            ],
        ];

        foreach ($karyawanData as $data) {
            $employee = Employee::create([
                'nama_lengkap' => $data['nama'],
                'divisi' => $data['divisi'],
                'jabatan' => $data['jabatan'],
                'status_karyawan' => 'Aktif',
                'tanggal_bergabung' => now()->subMonths(rand(1, 12)),
            ]);

            $user = User::create([
                'name' => $employee->nama_lengkap,
                'email' => $data['email'],
                'password' => Hash::make('password'), // Password default untuk semua karyawan
            ]);

            // Hubungkan User dengan Employee dan berikan Role
            $employee->user_id = $user->id;
            $employee->save();
            $user->assignRole($roleKaryawan);
        }
    }
}
