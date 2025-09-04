<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Posts
            </h2>
           
        </div>
        
    </x-slot>
    <a href="{{ route('posts.create') }}"
               class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-lg">
                Create Post
            </a>
</x-app-layout>
