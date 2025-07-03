<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pengajuan Cuti / Izin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                    <p class="font-bold">Berhasil</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            {{-- Form Pengajuan --}}
            <div class="bg-white overflow-hidden shadow-lg rounded-lg mb-8">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Buat Pengajuan Baru</h3>
                </div>
                <form wire:submit.prevent="submit">
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Jenis Pengajuan</label>
                                <select wire:model="jenis_cuti" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                    <option>Cuti Tahunan</option>
                                    <option>Sakit</option>
                                    <option>Izin Khusus</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                                <input type="date" wire:model="tanggal_mulai" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                @error('tanggal_mulai') <span class="text-red-500 text-sm">{{ $errors->first('tanggal_mulai') }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                                <input type="date" wire:model="tanggal_selesai" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                @error('tanggal_selesai') <span class="text-red-500 text-sm">{{ $errors->first('tanggal_selesai') }}</span> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Alasan Lengkap</label>
                                <textarea wire:model="alasan" rows="4" class="mt-1 w-full border-gray-300 rounded-md shadow-sm"></textarea>
                                @error('alasan') <span class="text-red-500 text-sm">{{ $errors->first('alasan') }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 text-right">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Kirim Pengajuan</button>
                    </div>
                </form>
            </div>

            {{-- Riwayat Pengajuan --}}
            <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Riwayat Pengajuan Anda</h3>
                    <ul class="space-y-4">
                        @forelse ($riwayatPengajuan as $request)
                            <li class="p-4 border rounded-md flex justify-between items-center">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $request->jenis_cuti }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($request->tanggal_mulai)->isoFormat('D MMM Y') }} - {{ \Carbon\Carbon::parse($request->tanggal_selesai)->isoFormat('D MMM Y') }}
                                    </p>
                                </div>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($request->status_pengajuan == 'Disetujui') bg-green-100 text-green-800
                                    @elseif($request->status_pengajuan == 'Ditolak') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ $request->status_pengajuan }}
                                </span>
                            </li>
                        @empty
                            <p class="text-center text-gray-500 py-6">Belum ada riwayat pengajuan.</p>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
