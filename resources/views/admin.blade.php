<x-app-layout>
    <x-header>        
        {{ __('Admin Table') }}
    </x-header>

    <div class="flex items-center justify-center bg-transparent">
        <div class="text-center animate-fade-in-up">
            <div class="mt-48 flex flex-col items-center gap-4">
                <a href="{{ route('challenges.create') }}"
                   class="px-6 py-3 bg-purple-600 text-white rounded-lg shadow hover:bg-purple-700 transition mt-32">
                   Create New Challenge
                </a>

                <a href="{{ route('categories.create') }}"
                   class="px-6 py-3 bg-pink-600 text-white rounded-lg shadow hover:bg-pink-700 transition">
                   Create New Category
                </a>

                <a href="{{ route('categories.index') }}"
                   class="px-6 py-3 bg-gray-600 text-white rounded-lg shadow hover:bg-gray-700 transition">
                   Manage Categories
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
