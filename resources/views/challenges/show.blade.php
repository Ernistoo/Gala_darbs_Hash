<x-app-layout>
    <div class="max-w-2xl mx-auto p-6 transition-colors duration-500 ease-in-out">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 transition-colors duration-500 ease-in-out">{{ $challenge->title }}</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-2 transition-colors duration-500 ease-in-out">{{ $challenge->description }}</p>

        <!-- Submission Form -->
        <form action="{{ route('submissions.store', $challenge) }}" method="POST" enctype="multipart/form-data" class="mt-4">
            @csrf
            <input type="file" name="image" required class="block mb-2 transition-colors duration-500 ease-in-out">
            <x-primary-button class="transition-colors duration-500 ease-in-out">{{ __('Iesniegt bildi') }}</x-primary-button>
        </form>

        <a href="{{ route('submissions.index', $challenge) }}" class="text-blue-500 mt-4 inline-block transition-colors duration-500 ease-in-out">Skatīt iesniegumus</a>
    </div>
</x-app-layout>
