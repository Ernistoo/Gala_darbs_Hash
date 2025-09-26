<x-app-layout>
<x-slot name="header"></x-slot>
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
                                <x-challenge-card :challenge="$challenge" />
                            </a>
                        @endforeach
                    </div>
                </main>
            </div>
        </div>
    </body>
</x-app-layout>
