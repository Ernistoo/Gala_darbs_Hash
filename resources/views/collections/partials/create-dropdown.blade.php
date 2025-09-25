<div class="mb-4 relative" x-data="{ open: false }">
    <button @click="open = !open"
        class="inline-flex items-center justify-center w-12 h-12 bg-purple-600 text-white rounded-full shadow hover:bg-purple-700 transition">
        <img src="{{ asset('images/add.svg') }}" alt="Create Collection" class="w-6 h-6">
    </button>

   
    <div x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        @click.away="open = false"
        class="absolute mt-2 w-80 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 shadow-lg rounded-lg p-4 z-50">

        <form action="{{ route('collections.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-2">
            @csrf
            <input type="text" name="name" placeholder="Collection Name"
                class="border rounded p-2 w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-400"
                required>
            <textarea name="description" placeholder="Description"
                class="border rounded p-2 w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-400"></textarea>
            <input type="file" name="image"
                class="border rounded p-2 w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
            <div class="flex justify-end gap-2 mt-2">
                <button type="button" @click="open = false"
                    class="px-3 py-1 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded">Cancel</button>
                <button type="submit"
                    class="px-3 py-1 bg-purple-600 text-white rounded hover:bg-purple-700 transition">Create</button>
            </div>
        </form>
    </div>
</div>
