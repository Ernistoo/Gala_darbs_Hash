<x-app-layout>
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Challenges - {{ config('app.name', 'Hash') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        colors: {
                            purple: {
                                50: '#faf5ff',
                                100: '#f3e8ff',
                                200: '#e9d5ff',
                                300: '#d8b4fe',
                                400: '#c084fc',
                                500: '#a855f7',
                                600: '#9333ea',
                                700: '#7e22ce',
                                800: '#6b21a8',
                                900: '#581c87',
                            },
                        },
                        fontFamily: {
                            sans: ['Figtree', 'sans-serif'],
                        },
                    }
                }
            }
        </script>
        <style>
            .fade-in {
                animation: fadeIn 0.5s ease-in-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .card-hover {
                transition: all 0.3s ease;
            }

            .card-hover:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            }

            .progress-ring {
                transition: stroke-dashoffset 0.5s ease;
            }

            .challenge-card {
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(250, 245, 255, 0.9) 100%);
            }

            .dark .challenge-card {
                background: linear-gradient(135deg, rgba(55, 65, 81, 0.9) 0%, rgba(76, 29, 149, 0.2) 100%);
            }

            .badge-pulse {
                animation: pulse 2s infinite;
            }

            @keyframes pulse {
                0% {
                    box-shadow: 0 0 0 0 rgba(168, 85, 247, 0.7);
                }

                70% {
                    box-shadow: 0 0 0 10px rgba(168, 85, 247, 0);
                }

                100% {
                    box-shadow: 0 0 0 0 rgba(168, 85, 247, 0);
                }
            }
        </style>
    </head>

    <body class="font-sans antialiased bg-gradient-to-br from-gray-200 to-purple-100 dark:from-black dark:to-purple-900 transition-colors duration-500 ease-in-out min-h-screen">
        <div class="min-h-screen flex">
            <!-- Sidebar would be here -->

            <!-- Main content -->
            <div class="flex-1 flex flex-col ml-64 transition-colors duration-500 ease-in-out">
                <header class="transition-colors duration-500 ease-in-out">
                    <div class="px-6 py-4 transition-colors duration-500 ease-in-out text-gray-900 dark:text-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-2xl font-bold">Challenges</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Complete challenges to earn rewards and level up</p>
                            </div>
                            <div class="flex items-center space-x-2 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md px-4 py-2 rounded-full">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm font-medium">125 XP</span>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="p-6 transition-colors duration-500 ease-in-out text-gray-900 dark:text-gray-100">
                    <!-- Challenges Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 fade-in">
                        @foreach($challenges as $challenge)
                        <a href="{{ route('challenges.show', $challenge) }}" class="block">
                            <div class="challenge-card border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden card-hover h-full">
                                <!-- Challenge Image/Icon -->
                                <div class="h-40 bg-gradient-to-r from-purple-500 to-pink-500 relative overflow-hidden">
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-white opacity-30" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="absolute top-4 right-4">
                                        @if($challenge->completed)
                                        <span class="badge-pulse bg-green-500 text-white text-xs font-semibold px-2 py-1 rounded-full">Completed</span>
                                        @else
                                        <span class="bg-purple-100 dark:bg-purple-900/40 text-purple-800 dark:text-purple-200 text-xs font-semibold px-2 py-1 rounded-full">Active</span>
                                        @endif
                                    </div>
                                    <div class="absolute bottom-4 left-4">
                                        <span class="bg-white/90 dark:bg-gray-800/90 text-purple-600 dark:text-purple-400 text-xs font-bold px-2 py-1 rounded-md">
                                            +{{ $challenge->xp_reward }} XP
                                        </span>
                                    </div>
                                </div>

                                <!-- Challenge Content -->
                                <div class="p-5">
                                    <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100 mb-2">{{ $challenge->title }}</h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">{{ Str::limit($challenge->description, 80) }}</p>

                                    <!-- Progress Bar -->
                                    <div class="mb-4">
                                        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                                            <span>Progress</span>
                                            <span>{{ $challenge->completed ? '100%' : '0%' }}</span>
                                        </div>
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                            <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $challenge->completed ? '100%' : '0%' }}"></div>
                                        </div>
                                    </div>

                                    <!-- Deadline & Participants -->
                                    <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>{{ $challenge->deadline ? $challenge->deadline->diffForHumans() : 'No deadline' }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                            </svg>
                                            <span>{{ rand(5, 50) }} participants</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </main>
            </div>
        </div>

        <script>
            // Theme toggle logic
            if (
                localStorage.getItem('color-theme') === 'dark' ||
                (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
            ) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
    </body>

    </html>
</x-app-layout>