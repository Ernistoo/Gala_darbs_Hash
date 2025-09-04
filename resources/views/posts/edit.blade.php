<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Post
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}"
                           class="border rounded-lg w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content -->
                <div class="mb-4">
                    <label for="content" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Content</label>
                    <textarea name="content" id="content"
                              class="border rounded-lg w-full px-3 py-2 h-32 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div class="mb-4">
                    <label for="image" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Image</label>
                    <input type="file" name="image" id="image"
                           class="border rounded-lg w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Current image" class="mt-2 w-32 h-auto rounded-md">
                    @endif
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('posts.index') }}"
                       class="px-4 py-2 bg-gray-300 dark:bg-gray-600 rounded-lg text-gray-800 dark:text-gray-200 hover:bg-gray-400 dark:hover:bg-gray-500">Cancel</a>
                    <button type="submit"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
