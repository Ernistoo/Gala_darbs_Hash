<x-app-layout>
    <div class="max-w-5xl mx-auto py-6">
        <h2 class="text-2xl font-bold mb-6">Categories</h2>

        <a href="{{ route('categories.create') }}" 
           class="px-4 py-2 bg-purple-600 text-white rounded-lg mb-6 inline-block">Add Category</a>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($categories as $category)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" 
                             alt="{{ $category->name }}" 
                             class="w-full h-32 object-cover rounded">
                    @else
                        <div class="w-full h-32 flex items-center justify-center bg-gray-200 text-gray-500">
                            No Image
                        </div>
                    @endif

                    <h3 class="mt-2 font-semibold">{{ $category->name }}</h3>

                    <div class="flex gap-2 mt-3">
                        <a href="{{ route('categories.edit', $category) }}" 
                           class="text-blue-500 text-sm">Edit</a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" 
                              onsubmit="return confirm('Delete this category?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 text-sm">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
