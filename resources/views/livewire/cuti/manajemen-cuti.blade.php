<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Pengajuan Cuti
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4">
                        <label>Filter Status:</label>
                        <select wire:model.live="filterStatus" class="border-gray-300 rounded-md">
                            <option value="Menunggu">Menunggu</option>
                            <option value="Disetujui">Disetujui</option>
                            <option value="Ditolak">Ditolak</option>
                            <option value="">Semua</option>
                        </select>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                           {{-- ... thead ... --}}
                           <tbody>
                                @forelse ($requests as $request)
                                <tr>
                                    <td class="px-6 py-4">{{ $request->employee->nama_lengkap ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">{{ $request->jenis_cuti }}</td>
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($request->tanggal_mulai)->isoFormat('D MMM Y') }} - {{ \Carbon\Carbon::parse($request->tanggal_selesai)->isoFormat('D MMM Y') }}</td>
                                    <td class="px-6 py-4">{{ $request->status_pengajuan }}</td>
                                    <td class="px-6 py-4">
                                        @if ($request->status_pengajuan == 'Menunggu')
                                            <button wire:click="approve({{ $request->id }})" class="text-sm bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded">Setujui</button>
                                            <button wire:click="reject({{ $request->id }})" class="text-sm bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded ml-2">Tolak</button>
                                        @else
                                            <span class="text-sm text-gray-500">Dikelola oleh {{ $request->approver->name ?? '-' }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center py-4">Tidak ada data pengajuan.</td></tr>
                                @endforelse
                           </tbody>
                        </table>
                    </div>
                     <div class="mt-4">{{ $requests->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
