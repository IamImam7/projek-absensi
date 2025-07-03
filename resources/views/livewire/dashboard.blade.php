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
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500 flex items-center justify-between">
        <div>
            <h4 class="text-sm font-medium text-gray-500 uppercase">Total Karyawan</h4>
            <p class="text-3xl font-bold text-gray-800">{{ $todayStats['total'] ?? 0 }}</p>
        </div>
        <div class="bg-blue-100 p-3 rounded-full">
            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500 flex items-center justify-between">
        <div>
            <h4 class="text-sm font-medium text-gray-500 uppercase">Hadir</h4>
            <p class="text-3xl font-bold text-gray-800">{{ $todayStats['hadir'] ?? 0 }}</p>
        </div>
        <div class="bg-green-100 p-3 rounded-full">
            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500 flex items-center justify-between">
        <div>
            <h4 class="text-sm font-medium text-gray-500 uppercase">Terlambat</h4>
            <p class="text-3xl font-bold text-gray-800">{{ $todayStats['terlambat'] ?? 0 }}</p>
        </div>
        <div class="bg-yellow-100 p-3 rounded-full">
            <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-red-500 flex items-center justify-between">
        <div>
            <h4 class="text-sm font-medium text-gray-500 uppercase">Absen</h4>
            <p class="text-3xl font-bold text-gray-800">{{ $todayStats['absen'] ?? 0 }}</p>
        </div>
        <div class="bg-red-100 p-3 rounded-full">
            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
        </div>
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
