<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">My Collections</h2>
    </x-slot>

    <div class="max-w-6xl mx-auto py-6 space-y-6">

        <!-- Create Collection button + dropdown form -->
        <div class="mb-4 relative" x-data="{ open: false }">
            <button @click="open = !open"
                    class="inline-flex items-center justify-center w-12 h-12 bg-purple-600 text-white rounded-full shadow hover:bg-purple-700 transition">
                <img src="{{ asset('images/add.svg') }}" alt="Create Collection" class="w-6 h-6">
            </button>

            <!-- Dropdown Form -->
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 @click.away="open = false"
                 class="absolute mt-2 w-80 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 z-50">

                <form action="{{ route('collections.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-2">
                    @csrf
                    <input type="text" name="name" placeholder="Collection Name" class="border rounded p-2 w-full" required>
                    <textarea name="description" placeholder="Description" class="border rounded p-2 w-full"></textarea>
                    <input type="file" name="image" class="border rounded p-2 w-full">
                    <div class="flex justify-end gap-2 mt-2">
                        <button type="button" @click="open = false" class="px-3 py-1 bg-gray-300 dark:bg-gray-700 rounded">Cancel</button>
                        <button type="submit" class="px-3 py-1 bg-purple-600 text-white rounded hover:bg-purple-700 transition">Create</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Collections Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mt-4">
            @foreach($collections as $collection)
            <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden hover:scale-105 transform transition cursor-pointer"
                 x-data="{ menuOpen: false, editModal: false, deleteModal: false }">

                <a href="{{ route('collections.show', $collection) }}" class="block">
                    <img src="{{ $collection->image ? Storage::url($collection->image) : asset('default-avatar.png') }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $collection->name }}</h3>
                        @if($collection->description)
                        <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $collection->description }}</p>
                        @endif
                    </div>
                </a>

                <!-- Three Dots Dropdown -->
                <div class="absolute top-2 right-2">
                    <button @click="menuOpen = !menuOpen" class="p-1 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">⋮</button>
                    <div x-show="menuOpen" @click.away="menuOpen = false"
                         class="absolute right-0 mt-2 w-32 bg-white dark:bg-gray-800 rounded shadow-lg z-50">
                        <button @click="editModal = true; menuOpen = false" class="w-full text-left px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Edit</button>
                        <button @click="deleteModal = true; menuOpen = false" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-100 dark:hover:bg-red-700">Delete</button>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div x-show="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                    <div @click.away="editModal = false" class="bg-white dark:bg-gray-800 p-6 rounded shadow w-96">
                        <h2 class="text-xl font-bold mb-4">Edit Collection</h2>
                        <form action="{{ route('collections.update', $collection) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="text" name="name" value="{{ $collection->name }}" class="border rounded p-2 w-full mb-2" required>
                            <textarea name="description" class="border rounded p-2 w-full mb-2" placeholder="Description">{{ $collection->description }}</textarea>
                            <input type="file" name="image" class="border rounded p-2 w-full mb-2">
                            <div class="flex justify-end gap-2">
                                <button type="button" @click="editModal = false" class="px-4 py-2 bg-gray-300 dark:bg-gray-700 rounded">Cancel</button>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Modal -->
                <div x-show="deleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                    <div @click.away="deleteModal = false" class="bg-white dark:bg-gray-800 p-6 rounded shadow w-96">
                        <h2 class="text-xl font-bold mb-4 text-red-600">Delete Collection</h2>
                        <p class="mb-4">Are you sure you want to delete "{{ $collection->name }}"?</p>
                        <div class="flex justify-end gap-2">
                            <button type="button" @click="deleteModal = false" class="px-4 py-2 bg-gray-300 dark:bg-gray-700 rounded">Cancel</button>
                            <form action="{{ route('collections.destroy', $collection) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            @endforeach
        </div>

    </div>
</x-app-layout>
