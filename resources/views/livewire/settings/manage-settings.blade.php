<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pengaturan Global
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                <form wire:submit.prevent="save">
                    <div class="p-6 space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Pengaturan Jam Kerja</h3>
                            <p class="mt-1 text-sm text-gray-600">Atur jam kerja standar yang berlaku untuk validasi absensi.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="jam_masuk_kerja" class="block text-sm font-medium text-gray-700">Jam Masuk</label>
                                <input type="time" step="1" wire:model="jam_masuk_kerja" id="jam_masuk_kerja" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                @error('jam_masuk_kerja') <span class="text-red-500 text-sm">{{ $errors->first('jam_masuk_kerja') }}</span> @enderror
                            </div>
                            <div>
                                <label for="batas_jam_terlambat" class="block text-sm font-medium text-gray-700">Batas Terlambat</label>
                                <input type="time" step="1" wire:model="batas_jam_terlambat" id="batas_jam_terlambat" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                @error('batas_jam_terlambat') <span class="text-red-500 text-sm">{{ $errors->first('batas_jam_terlambat') }}</span> @enderror
                            </div>
                            <div>
                                <label for="jam_pulang_kerja" class="block text-sm font-medium text-gray-700">Jam Pulang</label>
                                <input type="time" step="1" wire:model="jam_pulang_kerja" id="jam_pulang_kerja" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                @error('jam_pulang_kerja') <span class="text-red-500 text-sm">{{ $errors->first('jam_pulang_kerja') }}</span> @enderror
                            </div>
                        </div>

                        <hr/>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Pengaturan Lokasi Kantor</h3>
                            <p class="mt-1 text-sm text-gray-600">Digunakan untuk fitur Geofencing di masa depan.</p>
                        </div>

                         <div class="space-y-4">
    {{-- Input Pencarian Alamat --}}
    <div>
        <label for="address_search" class="block text-sm font-medium text-gray-700">Cari Alamat Kantor</label>
        <div class="mt-1 flex rounded-md shadow-sm">
            <input type="text" id="address_search" class="flex-1 block w-full rounded-none rounded-l-md border-gray-300" placeholder="Contoh: Menara BEJ, Jakarta">
            <button type="button" id="search_button" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-r-md text-gray-700 bg-gray-50 hover:bg-gray-100">
                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                <span>Cari</span>
            </button>
        </div>
    </div>

    {{-- Kontainer untuk Peta --}}
    <div id="map" class="w-full h-80 rounded-lg shadow-md" wire:ignore></div>

    {{-- Input Lat/Lon tetap ada, tapi disembunyikan dan diisi oleh peta --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="lokasi_lat" class="block text-sm font-medium text-gray-700">Latitude</label>
            <input type="text" wire:model="lokasi_lat" id="lokasi_lat" readonly class="mt-1 w-full border-gray-300 rounded-md shadow-sm bg-gray-100">
        </div>
        <div>
            <label for="lokasi_lon" class="block text-sm font-medium text-gray-700">Longitude</label>
            <input type="text" wire:model="lokasi_lon" id="lokasi_lon" readonly class="mt-1 w-full border-gray-300 rounded-md shadow-sm bg-gray-100">
        </div>
    </div>
</div>

                    </div>
                    <div class="px-6 py-4 bg-gray-50 text-right">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            <span wire:loading.remove wire:target="save">Simpan Pengaturan</span>
                            <span wire:loading wire:target="save">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        // Ambil nilai awal dari Livewire, atau set default ke Jakarta
       let lat = @js($lokasi_lat) || -6.2088;
       let lon = @js($lokasi_lon) || 106.8456;

        // Inisialisasi Peta
        const map = L.map('map').setView([lat, lon], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Inisialisasi Marker
        let marker = L.marker([lat, lon], { draggable: true }).addTo(map);

        // Event saat marker digeser
        marker.on('dragend', function(event) {
            const position = marker.getLatLng();
            // Update nilai Livewire secara langsung dari JavaScript
            @this.set('lokasi_lat', position.lat);
            @this.set('lokasi_lon', position.lng);
        });

        // Event saat tombol cari diklik
        document.getElementById('search_button').addEventListener('click', function() {
            const address = document.getElementById('address_search').value;
            if (!address) return;

            // Panggil API Nominatim untuk Geocoding
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        const newLat = data[0].lat;
                        const newLon = data[0].lon;
                        const newPos = new L.LatLng(newLat, newLon);

                        map.setView(newPos, 16);
                        marker.setLatLng(newPos);

                        // Update nilai Livewire
                        @this.set('lokasi_lat', newLat);
                        @this.set('lokasi_lon', newLon);
                    } else {
                        alert('Alamat tidak ditemukan.');
                    }
                });
        });
    });
</script>
@endpush
