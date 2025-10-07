<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Hash') }}</title>

    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <!-- Fonts -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script>
        if (
            localStorage.getItem('color-theme') === 'dark' ||
            (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
        ) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

@if(session('badge_earned'))
    <div 
        x-data="{ show: true }" 
        x-show="show" 
        x-transition 
        x-init="setTimeout(() => show = false, 5000)" 
        class="fixed bottom-6 right-6 bg-white dark:bg-gray-800 border border-purple-500 rounded-lg shadow-lg p-4 flex items-center space-x-3 z-50"
    >
        <img src="{{ asset('images/' . session('badge_image')) }}" 
             alt="{{ session('badge_name') }}" 
             class="w-10 h-10 rounded-full border-2 border-purple-500">

        <div>
            <p class="text-sm font-bold text-gray-900 dark:text-gray-100">
                🎉 {{ session('badge_name') }}
            </p>
            <p class="text-xs text-gray-600 dark:text-gray-400">
                {{ session('badge_description') }}
            </p>
        </div>

        <button @click="show = false" 
                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
            ✕
        </button>
    </div>
@endif

<body class="font-sans antialiased bg-gradient-to-br from-gray-200 to-purple-100 dark:from-black dark:to-purple-900 transition-colors duration-500 ease-in-out" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex">

        <div class="lg:hidden fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 px-4 py-3 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <x-application-logo class="h-10 w-10 text-gray-800 dark:text-gray-200" />
                <span class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ config('app.name') }}</span>
            </div>
            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600 dark:text-gray-300 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!sidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="sidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"></div>

        <aside class="fixed top-0 left-0 w-64 h-screen flex flex-col bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border-r border-gray-200 dark:border-gray-700 transition-all duration-300 ease-in-out z-50"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
            @include('layouts.navigation')
        </aside>

        <div class="flex-1 flex flex-col lg:ml-64 pt-16 lg:pt-0 transition-colors duration-500 ease-in-out bg-gradient-to-br from-gray-200 to-purple-100 dark:from-black dark:to-purple-900">

            @isset($header)
            <header class="transition-colors duration-500 ease-in-out">
                <div class="px-4 lg:px-6 py-4 transition-colors duration-500 ease-in-out text-gray-900 dark:text-gray-100">
                    {{ $header }}
                </div>
            </header>
            @endisset

            <main class="p-4 lg:p-6 transition-colors duration-500 ease-in-out text-gray-900 dark:text-gray-100">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>