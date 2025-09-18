<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold transition-colors duration-500 ease-in-out">Challenges</h2>
    </x-slot>

    <div class="grid grid-cols-3 gap-4 p-6 transition-colors duration-500 ease-in-out">
        @foreach($challenges as $challenge)
        <a href="{{ route('challenges.show', $challenge) }}"
            class="p-4 bg-white dark:bg-gray-800 rounded shadow hover:shadow-lg transition-colors duration-500 ease-in-out">
            <h3 class="font-semibold text-gray-900 dark:text-gray-100 transition-colors duration-500 ease-in-out">{{ $challenge->title }}</h3>
        </a>
        @endforeach
    </div>
</x-app-layout>
