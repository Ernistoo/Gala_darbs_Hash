<x-app-layout>
    <x-slot name="header">
        <h2>Create Post</h2>
    </x-slot>

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label>Title</label>
            <input type="text" name="title" class="border p-2 w-full" required>
        </div>
        <div>
            <label>Content</label>
            <textarea name="content" class="border p-2 w-full"></textarea>
        </div>
        <div>
            <label>Image</label>
            <input type="file" name="image">
        </div>
        <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Create</button>
    </form>
</x-app-layout>
