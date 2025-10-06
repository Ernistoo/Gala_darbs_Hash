<x-app-layout>
<x-header></x-header>

    <div class="min-h-screen flex">
        <div class="flex-1 flex flex-col lg:ml-64 lg:mr-40 transition-colors duration-500 ease-in-out">
            <header class="transition-colors duration-500 ease-in-out">
                <x-challenges.challenge-header :challenge="$challenge"/>
            </header>

            <main class="p-4 lg:p-6 text-gray-900 dark:text-gray-100">
                <div class="max-w-3xl mx-auto fade-in">
                    <x-challenges.challenge-details :challenge="$challenge"/>
                    <x-challenges.challenge-submission :challenge="$challenge"/>

                    <div class="mt-6 text-center">
                        <a href="{{ route('submissions.index', $challenge) }}" 
                           class="inline-flex items-center text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 transition">
                            View all submissions
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
