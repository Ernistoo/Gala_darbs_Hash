<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="max-w-3xl mx-auto p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
        <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Create New Category</h2>

        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-gray-700 dark:text-gray-300">Category Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                @error('name')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 dark:text-gray-300">Image (optional)</label>
                <input type="file" name="image" accept="image/*"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                @error('image')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg">
                Create
            </button>
        </form>
    </div>
</x-app-layout>
