<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Hash') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans flex items-center justify-center min-h-screen 
                 bg-gradient-to-br from-gray-100 to-yellow-50 
                 dark:from-black dark:to-purple-900">
        <div class="w-full sm:max-w-sm mt-6 px-6 py-4 
                    bg-white/80 dark:bg-gray-800/80 
                    backdrop-blur-md shadow-lg sm:rounded-lg">
            <div class="flex justify-center mb-6">
                <a href="/">
                    <x-application-logo class="w-16 h-16 text-gray-600 dark:text-gray-300" />
                </a>
            </div>

            {{ $slot }}
        </div>
    </body>
</html>
