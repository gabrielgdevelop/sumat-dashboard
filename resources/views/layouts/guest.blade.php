<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-cover font-sans" style="background-image: url('{{ asset('imgs/bg_sumat.jpeg') }}')">
        <div class="min-h-screen flex items-center flex-col justify-center py-12">
            <div class="text-center mb-4">
                <a href="/">
                    <x-application-logo class="h-16 object-contain" />
                </a>
            </div>

            <div class="w-full max-w-md mt-0 px-6 py-6 bg-white/80 rounded shadow backdrop-blur border border-gray-300">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
