<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex">
            <div class="w-full md:w-1/2 flex flex-col items-center justify-center p-8">
    <div class="w-full sm:max-w-md">
        {{-- Ubah bagian ini agar nama aplikasi juga terlihat --}}
        <a href="/" class="flex flex-col items-center mb-6">
            <x-application-logo class="w-20 h-20 fill-current text-gray-800" />
            <span class="mt-4 text-3xl font-bold text-gray-800">
                {{ config('app.name', 'Laravel') }}
            </span>
        </a>

        <div class="w-full px-6 py-8 bg-white shadow-xl rounded-lg overflow-hidden">
            {{ $slot }}
        </div>
    </div>
</div>

            <div class="hidden md:block w-1/2 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1590402494587-44b71d7772f6?q=80&w=1974&auto=format&fit=crop');">
                <div class="w-full h-full bg-gray-900 bg-opacity-50"></div>
            </div>
        </div>
    </body>
</html>
