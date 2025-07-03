<?php

namespace App\Http\Livewire\Karyawan;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Employee;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout; // <--- TAMBAHKAN KEMBALI

#[Layout('layouts.app')] // <--- TAMBAHKAN KEMBALI
class ListKaryawan extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[On('employee-saved')]
    public function refreshList()
    {
        // Cukup dengan merender ulang, Livewire akan mengambil data terbaru
    }

    public function delete($employeeId)
    {
        $employee = Employee::find($employeeId);
        if ($employee) {
            if ($employee->user) {
                $employee->user->delete();
            }
            $employee->delete();
            session()->flash('success', 'Data karyawan berhasil dihapus.');
        }
    }

    public function render()
    {

        $karyawan = Employee::with('user')
            ->where(function ($query) {
                $query->where('nama_lengkap', 'like', '%'.$this->search.'%')
                    ->orWhereHas('user', function ($subQuery) {
                        $subQuery->where('email', 'like', '%' . $this->search . '%');
                    });
            })
            ->latest() // Mengurutkan dari yang terbaru
            ->paginate(10);

        return view('livewire.karyawan.list-karyawan', [
            'karyawan' => $karyawan
        ]);
    }
}
