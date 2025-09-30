<x-app-layout>
    <x-header>
        {{ __('Challenges') }}
    </x-header>

    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
        Complete challenges to earn rewards and level up!
    </p>

    <main class="p-6 text-gray-900 dark:text-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 fade-in">
            @foreach($challenges as $challenge)
                <a href="{{ route('challenges.show', $challenge) }}" class="block">
                    <x-challenges.challenge-card :challenge="$challenge" />
                </a>
            @endforeach
        </div>
    </main>
</x-app-layout>
