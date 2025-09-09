<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center text-2xl font-bold">Create Post</h2>
    </x-slot>

    <div class="flex justify-center mt-6">
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="w-full max-w-lg bg-white p-6 rounded shadow">
            @csrf
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Title</label>
                <input type="text" name="title" class="border p-2 w-full rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Content</label>
                <textarea name="content" class="border p-2 w-full rounded" rows="4"></textarea>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Image</label>
                <input type="file" name="image" id="image" class="w-full">
            </div>
            <div class="text-center">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition">Create</button>
            </div>
        </form>
    </div>
</x-app-layout>
