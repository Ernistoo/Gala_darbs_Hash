<x-app-layout>
    <div class="max-w-lg mx-auto py-8">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">Edit Category</h1>

        <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}"
                       class="w-full mt-1 px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200"
                       required>
                @error('name')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Image</label>
                @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}"
                         alt="{{ $category->name }}"
                         class="w-full h-40 object-cover rounded-md mb-2">
                @endif
                <input type="file" name="image" accept="image/*"
                       class="w-full mt-1 text-sm text-gray-600 dark:text-gray-300">
                @error('image')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg shadow">
                Update
            </button>
        </form>
    </div>
</x-app-layout>
