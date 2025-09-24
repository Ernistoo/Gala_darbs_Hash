<x-app-layout>
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
        }

        .challenge-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(250, 245, 255, 0.9) 100%);
        }

        .dark .challenge-card {
            background: linear-gradient(135deg, rgba(55, 65, 81, 0.9) 0%, rgba(76, 29, 149, 0.2) 100%);
        }
    </style>

    <body class="font-sans antialiased bg-gradient-to-br from-gray-200 to-purple-100 dark:from-black dark:to-purple-900 min-h-screen">
        <div class="min-h-screen flex">
            <div class="flex-1 flex flex-col ml-20">
                <header>
                    <div class="px-6 py-4 text-gray-900 dark:text-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-2xl font-bold">Challenges</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    Complete challenges to earn rewards and level up
                                </p>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 fade-in">
                        @foreach($challenges as $challenge)
                        <a href="{{ route('challenges.show', $challenge) }}" class="block">
                            <div class="challenge-card border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden card-hover h-full">

                                <!-- Challenge Image or Fallback -->
                                <div class="h-40 relative overflow-hidden">
                                    @if($challenge->image)
                                    <img src="{{ asset('storage/' . $challenge->image) }}"
                                        alt="{{ $challenge->title }}"
                                        class="absolute inset-0 w-full h-full object-cover">
                                    @else
                                    <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-r from-purple-500 to-pink-500">
                                        <svg class="w-16 h-16 text-white opacity-30" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    @endif

                                    <!-- XP Badge -->
                                    <div class="absolute bottom-4 left-4">
                                        <span class="bg-white/90 dark:bg-gray-800/90 text-purple-600 dark:text-purple-400 text-xs font-bold px-2 py-1 rounded-md">
                                            +{{ $challenge->xp_reward ?? 0 }} XP
                                        </span>
                                    </div>
                                </div>

                                <!-- Challenge Content -->
                                <div class="p-5">
                                    <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100 mb-2">
                                        {{ $challenge->title }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                                        {{ Str::limit($challenge->description, 80) }}
                                    </p>

                                    <div class="mb-4">
                                        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                                            <span>Progress</span>
                                            <span>{{ $challenge->completed ? '100%' : '0%' }}</span>
                                        </div>
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                            <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $challenge->completed ? '100%' : '0%' }}"></div>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>{{ $challenge->deadline ? \Carbon\Carbon::parse($challenge->deadline)->diffForHumans() : 'No deadline' }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                            </svg>
                                            <span>{{ $challenge->participants_count }} participants</span>
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
    </body>
</x-app-layout>