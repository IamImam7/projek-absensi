<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Absensi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div>
                            <label for="startDate" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                            <input type="date" wire:model.live="startDate" id="startDate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="endDate" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                            <input type="date" wire:model.live="endDate" id="endDate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        @role('admin')
                        <div class="md:col-span-2">
                            <label for="search" class="block text-sm font-medium text-gray-700">Cari Nama Karyawan</label>
                            <input type="text" wire:model.live.debounce.300ms="search" id="search" placeholder="Ketik nama..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        @endrole
                    </div>

                    <div class="mb-4">
                        <button wire:click="exportExcel" wire:loading.attr="disabled" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
    <i class="fas fa-file-excel"></i> Export Excel
</button>
                       <button wire:click="exportPdf" wire:loading.attr="disabled" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
    <i class="fas fa-file-pdf"></i> Export PDF
</button>
                    </div>

                    <div class="mt-6 overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                @role('admin')
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Karyawan</th>
                @endrole
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check-in</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check-out</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($attendances as $attendance)
                <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ \Carbon\Carbon::parse($attendance->tanggal)->isoFormat('dddd, D MMMM Y') }}
                    </td>
                    @role('admin')
                    
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
    <div class="font-medium text-gray-900">{{ $attendance->employee->nama_lengkap ?? 'N/A' }}</div>
    {{-- Tampilkan tipe absensi --}}
    <div class="text-xs text-blue-600">{{ $attendance->tipe_absensi }}</div>

    {{-- Jika ada foto, tampilkan link --}}
    @if($attendance->foto_bukti)
        <a href="{{ asset('storage/' . $attendance->foto_bukti) }}" target="_blank" class="text-xs text-indigo-500 hover:underline">Lihat Foto Bukti</a>
    @endif
</td>
                    @endrole
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i:s') : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i:s') : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($attendance->status_kehadiran == 'Tepat Waktu') bg-green-100 text-green-800
                            @elseif($attendance->status_kehadiran == 'Terlambat') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $attendance->status_kehadiran }}
                        </span>
                    </td>
                </tr>
           @empty
    <tr>
        <td colspan="{{ auth()->user()->hasRole('admin') ? 5 : 4 }}">
            <div class="text-center py-16 px-6">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">Belum Ada Riwayat Absensi</h3>
                @role('karyawan')
                    <p class="mt-1 text-sm text-gray-500">Lakukan check-in pertama Anda dan riwayat akan muncul di sini.</p>
                @else
                    <p class="mt-1 text-sm text-gray-500">Belum ada karyawan yang melakukan absensi pada rentang tanggal ini.</p>
                @endrole
            </div>
        </td>
    </tr>
@endforelse
        </tbody>
    </table>
</div>

                    <div class="mt-4">
                        {{ $attendances->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
