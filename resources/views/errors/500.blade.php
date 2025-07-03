<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Kesalahan Server</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans">
        <div class="min-h-screen bg-gray-100 flex flex-col items-center justify-center">
            <div class="text-center">
                <div class="mb-4">
                    <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h1 class="text-6xl font-extrabold text-red-600">500</h1>
                <p class="text-2xl md:text-3xl font-light text-gray-800 mt-4">
                    Terjadi Kesalahan Pada Server
                </p>
                <p class="mt-4 mb-8 text-gray-500">
                    Maaf, kami sedang mengalami masalah teknis. Tim kami telah diberitahu.
                </p>
                <a href="{{ url('/') }}" class="px-6 py-3 text-sm font-semibold text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition duration-150 ease-in-out">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </body>
</html>
