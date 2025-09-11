<x-app-layout>
    <div class="max-w-2xl mx-auto p-6">
        <h2 class="text-2xl font-bold">{{ $challenge->title }}</h2>
        <p class="text-gray-600 mt-2">{{ $challenge->description }}</p>

        <!-- Forma iesniegšanai -->
        <form action="{{ route('submissions.store', $challenge) }}" method="POST" enctype="multipart/form-data" class="mt-4">
            @csrf
            <input type="file" name="image" required class="block mb-2">
            <x-primary-button>{{ __('Iesniegt bildi') }}</x-primary-button>
        </form>

        <a href="{{ route('submissions.index', $challenge) }}" class="text-blue-500 mt-4 inline-block">Skatīt iesniegumus</a>
    </div>
</x-app-layout>