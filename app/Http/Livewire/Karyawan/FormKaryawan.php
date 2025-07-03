<?php

namespace App\Http\Livewire\Karyawan;

use App\Models\User;
use Livewire\Component;
use App\Models\Employee;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FormKaryawan extends Component
{
    public bool $showModal = false;
    public ?int $employeeId = null;

    public string $nama_lengkap = '';
    public string $email = '';
    public string $divisi = '';
    public string $jabatan = '';
    public string $status_karyawan = 'Aktif';
    public string $tanggal_bergabung = '';
    public string $password = '';
    public string $password_confirmation = '';

    #[On('open-form')]
    public function create()
    {
        $this->resetValidation();
        $this->reset();
        $this->tanggal_bergabung = now()->format('Y-m-d');
        $this->showModal = true;
    }

    #[On('edit-employee')]
    public function edit($id)
    {
        $this->resetValidation();
        $this->reset('password', 'password_confirmation');
        $employee = Employee::with('user')->find($id);

        if ($employee) {
            $this->employeeId = $employee->id;
            $this->nama_lengkap = $employee->nama_lengkap;
            $this->email = $employee->user->email ?? '';
            $this->divisi = $employee->divisi;
            $this->jabatan = $employee->jabatan;
            $this->status_karyawan = $employee->status_karyawan;
            $this->tanggal_bergabung = $employee->tanggal_bergabung;
            $this->showModal = true;
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset();
    }

    public function save()
    {
        $userId = $this->employeeId ? Employee::find($this->employeeId)->user_id : null;

        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($userId)],
            'divisi' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'status_karyawan' => 'required|in:Aktif,Non-Aktif,Cuti Panjang',
            'tanggal_bergabung' => 'required|date',
        ];

        if (!$this->employeeId || !empty($this->password)) {
            $rules['password'] = 'required|min:8|confirmed';
        }

        $this->validate($rules);

        DB::transaction(function () {
            if ($this->employeeId) {
                $employee = Employee::find($this->employeeId);
                $employee->update(
                    $this->only(['nama_lengkap', 'divisi', 'jabatan', 'status_karyawan', 'tanggal_bergabung'])
                );

                if ($employee->user) {
                    $employee->user->update(['name' => $this->nama_lengkap, 'email' => $this->email]);
                    if (!empty($this->password)) {
                        $employee->user->update(['password' => Hash::make($this->password)]);
                    }
                }
            } else {
                $user = User::create([
                    'name' => $this->nama_lengkap,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                ]);
                $user->assignRole('karyawan');

                $user->employee()->create(
                    $this->only(['nama_lengkap', 'divisi', 'jabatan', 'status_karyawan', 'tanggal_bergabung'])
                );
            }
        });

        session()->flash('success', 'Data karyawan berhasil disimpan.');
        $this->closeModal();
        $this->dispatch('employee-saved');
    }

    public function render()
    {
        return view('livewire.karyawan.form-karyawan');
    }
}
