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
    <body class="antialiased bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen flex">
        <!-- Left side: Form -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                {{ $slot }}
            </div>
        </div>

        <!-- Right side: Image -->
        <div class="hidden md:block w-1/2 bg-cover bg-center" style="background-image: url('https://www.verywellmind.com/thmb/QGS470MKXc4IEqpbQl3qm1bUsuQ=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/GettyImages-1057500046-f7e673d3a91546b0bd419c5d8336b2e0.jpg')">
            <!-- Placeholder image, replace URL later -->
        </div>
    </div>
    
</body>
</html>
