<div>
    @if ($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60">

        {{-- 1. Tambahkan kelas flex, flex-col, dan max-h-[90vh] pada panel modal utama --}}
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl flex flex-col max-h-[90vh]">

            <div class="p-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">{{ $employeeId ? 'Edit Karyawan' : 'Tambah Karyawan Baru' }}</h2>
                <p class="text-sm text-gray-500 mt-1">Isi detail di bawah ini untuk mengelola data karyawan.</p>
            </div>

            <form wire:submit.prevent="save" class="flex flex-col flex-1 overflow-hidden">
                {{-- 2. Tambahkan kelas overflow-y-auto pada badan modal agar bisa di-scroll --}}
                <div class="p-6 flex-1 overflow-y-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nama Lengkap --}}
                        <div class="col-span-2">
                            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" wire:model="nama_lengkap" id="nama_lengkap" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            @error('nama_lengkap') <span class="text-red-500 text-sm">{{ $errors->first('nama_lengkap') }}</span> @enderror
                        </div>
                        {{-- Email --}}
                        <div class="col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                            <input type="email" wire:model="email" id="email" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            @error('email') <span class="text-red-500 text-sm">{{ $errors->first('email') }}</span> @enderror
                        </div>
                        {{-- Divisi --}}
                        <div>
                            <label for="divisi" class="block text-sm font-medium text-gray-700">Divisi</label>
                            <input type="text" wire:model="divisi" id="divisi" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            @error('divisi') <span class="text-red-500 text-sm">{{ $errors->first('divisi') }}</span> @enderror
                        </div>
                        {{-- Jabatan --}}
                        <div>
                            <label for="jabatan" class="block text-sm font-medium text-gray-700">Jabatan</label>
                            <input type="text" wire:model="jabatan" id="jabatan" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            @error('jabatan') <span class="text-red-500 text-sm">{{ $errors->first('jabatan') }}</span> @enderror
                        </div>
                        {{-- Tanggal Bergabung --}}
                        <div>
                            <label for="tanggal_bergabung" class="block text-sm font-medium text-gray-700">Tanggal Bergabung</label>
                            <input type="date" wire:model="tanggal_bergabung" id="tanggal_bergabung" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            @error('tanggal_bergabung') <span class="text-red-500 text-sm">{{ $errors->first('tanggal_bergabung') }}</span> @enderror
                        </div>
                        {{-- Status --}}
                        <div>
                            <label for="status_karyawan" class="block text-sm font-medium text-gray-700">Status</label>
                            <select wire:model="status_karyawan" id="status_karyawan" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="Aktif">Aktif</option>
                                <option value="Non-Aktif">Non-Aktif</option>
                                <option value="Cuti Panjang">Cuti Panjang</option>
                            </select>
                            @error('status_karyawan') <span class="text-red-500 text-sm">{{ $errors->first('status_karyawan') }}</span> @enderror
                        </div>
                        <hr class="col-span-2 my-2"/>
                        <p class="col-span-2 text-sm text-gray-600">Isi password untuk membuat user baru atau mengganti password.</p>
                        {{-- Password --}}
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" wire:model="password" id="password" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            @error('password') <span class="text-red-500 text-sm">{{ $errors->first('password') }}</span> @enderror
                        </div>
                        {{-- Konfirmasi Password --}}
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                            <input type="password" wire:model="password_confirmation" id="password_confirmation" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-gray-50 flex justify-end space-x-4 rounded-b-lg">
                    <button type="button" wire:click="closeModal" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        <span wire:loading.remove wire:target="save">Simpan Data</span>
                        <span wire:loading wire:target="save">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
