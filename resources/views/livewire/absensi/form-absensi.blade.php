<div>
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Form ini hanya tampil jika user BISA check-in --}}
    @if ($isCheckInAllowed)
        <div class="space-y-4">
            {{-- Pilihan Tipe Absensi --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Tipe Absensi</label>
                <select wire:model.live="tipe_absensi" class="mt-1 block w-full md:w-1/3 rounded-md border-gray-300 shadow-sm">
                    <option>Di Kantor</option>
                    <option>Luar Kantor</option>
                </select>
            </div>

            {{-- Form Kondisional untuk Absensi Luar Kantor --}}
            @if ($tipe_absensi == 'Luar Kantor')
                <div class="p-4 border-l-4 border-blue-400 bg-blue-50 space-y-4 rounded-r-lg">
                    {{-- Input Catatan Pekerjaan --}}
                    <div>
                        <label for="catatan_pekerjaan" class="block text-sm font-medium text-gray-700">Catatan Pekerjaan Hari Ini</label>
                        <textarea wire:model="catatan_pekerjaan" id="catatan_pekerjaan" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Contoh: Bertemu klien di A, mengerjakan proyek B..."></textarea>
                        @error('catatan_pekerjaan') <span class="text-red-500 text-sm">{{ $errors->first('catatan_pekerjaan') }}</span> @enderror
                    </div>

                    {{-- Input Foto Bukti --}}
                    <div>
                        <label for="foto_bukti" class="block text-sm font-medium text-gray-700">Unggah Foto Bukti (Selfie)</label>
                        <input type="file" wire:model="foto_bukti" id="foto_bukti" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <div wire:loading wire:target="foto_bukti">Mengunggah...</div>
                        @error('foto_bukti') <span class="text-red-500 text-sm">{{ $errors->first('foto_bukti') }}</span> @enderror

                        {{-- Preview Gambar --}}
                        @if ($foto_bukti)
                            <img src="{{ $foto_bukti->temporaryUrl() }}" class="mt-4 h-48 w-auto rounded-lg">
                        @endif
                    </div>
                </div>
            @endif
        </div>
    @endif
    <div class="flex space-x-4 mt-6">
        @if ($isCheckInAllowed)
            <button wire:click="checkIn" wire:loading.attr="disabled" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <span wire:loading.remove wire:target="checkIn">
                    <i class="fas fa-sign-in-alt"></i> Check-in Sekarang
                </span>
                <span wire:loading wire:target="checkIn">
                    Memproses...
                </span>
            </button>
        @endif

        @if ($isCheckOutAllowed)
            <button wire:click="checkOut" wire:loading.attr="disabled" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                 <span wire:loading.remove wire:target="checkOut">
                    <i class="fas fa-sign-out-alt"></i> Check-out Sekarang
                </span>
                <span wire:loading wire:target="checkOut">
                    Memproses...
                </span>
            </button>
        @endif
    </div>

    @if (!$isCheckInAllowed && !$isCheckOutAllowed && $todayAttendance)
        <p class="text-gray-600 mt-4">Aktivitas absensi untuk hari ini telah selesai. Sampai jumpa besok!</p>
    @elseif (!$isCheckInAllowed && !$isCheckOutAllowed && !$todayAttendance)
        <p class="text-gray-600 mt-4">Waktu untuk absensi belum dibuka atau sudah terlewat.</p>
    @endif
</div>
