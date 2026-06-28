<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'EduSubmit') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex">
            {{-- Sisi kiri — dekorasi --}}
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-pink-500 to-rose-400 flex-col items-center justify-center p-12 text-white">
                <img src="{{ asset('images/logo-pnc.png') }}" alt="Logo PNC" class="h-28 w-auto mb-6 drop-shadow-lg">
                <h1 class="text-4xl font-bold mb-3">EduSubmit</h1>
                <p class="text-lg text-pink-100 text-center">Platform Pengumpulan Tugas Digital</p>
                <p class="text-sm text-pink-200 text-center mt-2">Politeknik Negeri Cilacap</p>
                <div class="mt-10 grid grid-cols-3 gap-4 text-center">
                    <div class="bg-white/20 rounded-xl p-4">
                        <p class="text-2xl font-bold">📚</p>
                        <p class="text-xs mt-1">Kelola Course</p>
                    </div>
                    <div class="bg-white/20 rounded-xl p-4">
                        <p class="text-2xl font-bold">📝</p>
                        <p class="text-xs mt-1">Buat Tugas</p>
                    </div>
                    <div class="bg-white/20 rounded-xl p-4">
                        <p class="text-2xl font-bold">📤</p>
                        <p class="text-xs mt-1">Kumpulkan</p>
                    </div>
                </div>
            </div>

            {{-- Sisi kanan — form --}}
            <div class="w-full lg:w-1/2 flex flex-col items-center justify-center p-8 bg-pink-50">
                {{-- Logo mobile --}}
                <div class="flex flex-col items-center mb-6 lg:hidden">
                    <img src="{{ asset('images/logo-pnc.png') }}" alt="Logo PNC" class="h-16 w-auto mb-2">
                    <h1 class="text-xl font-bold text-pink-600">EduSubmit</h1>
                    <p class="text-xs text-gray-500">Politeknik Negeri Cilacap</p>
                </div>

                <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>