<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Iesniegumi uzdevumam: {{ $challenge->title }}</h2>

        <div class="grid grid-cols-3 gap-4">
            @forelse($submissions as $submission)
            <div class="bg-white dark:bg-gray-800 p-2 rounded shadow">
                <img src="{{ asset('storage/' . $submission->image) }}" alt="submission" class="w-full h-48 object-cover rounded">
                <p class="text-sm mt-2 text-gray-600 dark:text-gray-400">Iesniedza: {{ $submission->user->name }}</p>
            </div>
            @empty
            <p class="col-span-3 text-gray-500">Vēl nav iesniegumu.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>