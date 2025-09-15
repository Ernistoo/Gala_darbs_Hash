<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Hash') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center
             bg-gradient-to-b from-gray-100 to-purple-300 
             dark:from-black dark:to-purple-900 relative overflow-hidden">

    <!-- Background Image with opacity -->
    <img src="{{ asset('images/chat.png') }}" 
         class="absolute inset-0 w-full h-full object-cover opacity-20 -z-10">

    <!-- Main Content -->
    <div class="text-center space-y-6 z-10">
        <h1 class="text-6xl font-bold text-gray-900 dark:text-white">
            {{ config('app.name', 'Hash') }}
        </h1>

        <div class="flex justify-center gap-4">
            <a href="{{ route('login') }}"
               class="px-6 py-2 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                Login
            </a>

            <a href="{{ route('register') }}"
               class="px-6 py-2 rounded-lg bg-gray-200 text-gray-900 font-medium hover:bg-gray-300 transition dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700">
                Register
            </a>
        </div>
    </div>
</body>
</html>
