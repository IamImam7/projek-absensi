<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    {{-- Kita bungkus semua konten dengan div Alpine.js --}}
    <div x-data="{ tab: 'profile' }" class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow-md rounded-lg">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button @click="tab = 'profile'"
                            :class="{ 'border-indigo-500 text-indigo-600': tab === 'profile', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'profile' }"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Informasi Profil
                    </button>

                    <button @click="tab = 'password'"
                            :class="{ 'border-indigo-500 text-indigo-600': tab === 'password', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'password' }"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Ubah Password
                    </button>

                    <button @click="tab = 'delete'"
                            :class="{ 'border-indigo-500 text-indigo-600': tab === 'delete', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'delete' }"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Hapus Akun
                    </button>
                </nav>
            </div>
        </div>

        <div>
            <div x-show="tab === 'profile'" x-cloak>
                <div class="p-4 sm:p-8 bg-white shadow-md rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div x-show="tab === 'password'" x-cloak>
                <div class="p-4 sm:p-8 bg-white shadow-md rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div x-show="tab === 'delete'" x-cloak>
                <div class="p-4 sm:p-8 bg-white shadow-md rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
