<div>
    {{-- Slot header untuk judul halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold">{{ $greeting }}, {{ auth()->user()->name }}!</h3>

                    {{-- TAMPILAN UNTUK ADMIN --}}
                    @role('admin')
                        <p class="mt-1 text-gray-600">Berikut adalah rekapitulasi absensi hari ini.</p>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
                            <div class="bg-blue-100 p-4 rounded-lg">
                                <h4 class="text-lg font-semibold text-blue-800">Total Karyawan</h4>
                                <p class="text-3xl font-bold text-blue-900">{{ $todayStats['total'] ?? 0 }}</p>
                            </div>
                            <div class="bg-green-100 p-4 rounded-lg">
                                <h4 class="text-lg font-semibold text-green-800">Hadir</h4>
                                <p class="text-3xl font-bold text-green-900">{{ $todayStats['hadir'] ?? 0 }}</p>
                            </div>
                            <div class="bg-yellow-100 p-4 rounded-lg">
                                <h4 class="text-lg font-semibold text-yellow-800">Terlambat</h4>
                                <p class="text-3xl font-bold text-yellow-900">{{ $todayStats['terlambat'] ?? 0 }}</p>
                            </div>
                            <div class="bg-red-100 p-4 rounded-lg">
                                <h4 class="text-lg font-semibold text-red-800">Absen</h4>
                                <p class="text-3xl font-bold text-red-900">{{ $todayStats['absen'] ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="mt-8">
                            <h4 class="text-lg font-medium text-gray-900 mb-2">Grafik Kehadiran Bulan Ini</h4>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <canvas id="attendanceChart"></canvas>
                            </div>
                        </div>
                    @endrole

                    {{-- TAMPILAN UNTUK KARYAWAN --}}
                    @role('karyawan')
                        <div class="mt-4 border-t pt-4">
                            @if($employeeAttendanceToday && $employeeAttendanceToday->check_in)
                                <p class="text-green-700">✅ Anda sudah melakukan check-in hari ini pada pukul <strong>{{ \Carbon\Carbon::parse($employeeAttendanceToday->check_in)->format('H:i') }}</strong>.</p>
                                @if($employeeAttendanceToday->check_out)
                                    <p class="text-blue-700">✅ Anda sudah melakukan check-out hari ini pada pukul <strong>{{ \Carbon\Carbon::parse($employeeAttendanceToday->check_out)->format('H:i') }}</strong>.</p>
                                @endif
                            @else
                                <p class="text-red-700">Anda belum melakukan absensi check-in hari ini.</p>
                            @endif

                            <div class="mt-6">
                                <livewire:absensi.form-absensi />
                            </div>
                        </div>
                    @endrole
                </div>
            </div>
        </div>
    </div>
</div>
