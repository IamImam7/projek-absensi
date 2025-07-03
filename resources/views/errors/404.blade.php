<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Halaman Tidak Ditemukan</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans">
        <div class="min-h-screen bg-gray-100 flex flex-col items-center justify-center">
            <div class="text-center">
                <div class="mb-4">
                    <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-6xl font-extrabold text-indigo-600">404</h1>
                <p class="text-2xl md:text-3xl font-light text-gray-800 mt-4">
                    Halaman Tidak Ditemukan
                </p>
                <p class="mt-4 mb-8 text-gray-500">
                    Maaf, halaman yang Anda cari tidak ada atau telah dipindahkan.
                </p>
                <a href="{{ url('/') }}" class="px-6 py-3 text-sm font-semibold text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition duration-150 ease-in-out">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </body>
</html>
