<?php

namespace App\Http\Livewire\Cuti;

use Livewire\Component;
use App\Models\LeaveRequest;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class ManajemenCuti extends Component
{
    use WithPagination;

    public $filterStatus = 'Menunggu';

    public function approve($id)
    {
        $request = LeaveRequest::find($id);
        if ($request) {
            $request->update([
                'status_pengajuan' => 'Disetujui',
                'approved_by' => Auth::id(),
            ]);
            session()->flash('success', 'Pengajuan berhasil disetujui.');
        }
    }

    public function reject($id)
    {
        $request = LeaveRequest::find($id);
        if ($request) {
            $request->update([
                'status_pengajuan' => 'Ditolak',
                'approved_by' => Auth::id(),
            ]);
            session()->flash('success', 'Pengajuan berhasil ditolak.');
        }
    }

    public function render()
    {
        $requests = LeaveRequest::with('employee.user', 'approver')
            ->when($this->filterStatus, function ($query) {
                $query->where('status_pengajuan', $this->filterStatus);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.cuti.manajemen-cuti', [
            'requests' => $requests
        ]);
    }
}
