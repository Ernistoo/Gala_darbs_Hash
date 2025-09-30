<div class="relative bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden hover:scale-105 transform transition cursor-pointer"
    x-data="{ menuOpen: false, editModal: false, deleteModal: false }">

    <a href="{{ route('collections.show', $collection) }}" class="block">
        
        <img src="{{ $collection->image ? Storage::url($collection->image) : asset('default-avatar.png') }}"
            class="w-full h-48 object-cover">

        
        <div class="p-4 bg-gradient-to-r from-gray-100 via-gray-200 to-gray-100 dark:from-gray-700 dark:via-gray-800 dark:to-gray-700">
            <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100 truncate">
                {{ $collection->name }}
            </h3>
            @if($collection->description)
                <p class="text-gray-700 dark:text-gray-300 text-sm mt-1 line-clamp-2">
                    {{ $collection->description }}
                </p>
            @endif
        </div>
    </a>

    
    <div class="absolute top-2 right-2">
        <button @click="menuOpen = !menuOpen" class="p-1 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">⋮</button>
        <div x-show="menuOpen" @click.away="menuOpen = false"
            class="absolute right-0 mt-2 w-32 bg-white dark:bg-gray-800 rounded shadow-lg z-50">
            <button @click="editModal = true; menuOpen = false"
                class="w-full text-left px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Edit</button>
            <button @click="deleteModal = true; menuOpen = false"
                class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-100 dark:hover:bg-red-700">Delete</button>
        </div>
    </div>

    
    <div x-show="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div @click.away="editModal = false"
            class="bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 p-6 rounded shadow w-96">
            <h2 class="text-xl font-bold mb-4">Edit Collection</h2>
            <form action="{{ route('collections.update', $collection) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="text" name="name" value="{{ $collection->name }}"
                    class="border rounded p-2 w-full mb-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" required>
                <textarea name="description"
                    class="border rounded p-2 w-full mb-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                    placeholder="Description">{{ $collection->description }}</textarea>
                <input type="file" name="image"
                    class="border rounded p-2 w-full mb-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                <div class="flex justify-end gap-2">
                    <button type="button" @click="editModal = false"
                        class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
                </div>
            </form>
        </div>
    </div>

   
    <div x-show="deleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div @click.away="deleteModal = false"
            class="bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 p-6 rounded shadow w-96">
            <h2 class="text-xl font-bold mb-4 text-red-600">Delete Collection</h2>
            <p class="mb-4 text-gray-800 dark:text-gray-200">Are you sure you want to delete "{{ $collection->name }}"?</p>
            <div class="flex justify-end gap-2">
                <button type="button" @click="deleteModal = false"
                    class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded">Cancel</button>
                <form action="{{ route('collections.destroy', $collection) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
