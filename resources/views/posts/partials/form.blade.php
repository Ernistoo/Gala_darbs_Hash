<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="w-full max-w-2xl bg-white/80 dark:bg-gray-800/80 backdrop-blur-md p-6 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
    @csrf
    @if($update ?? false) @method('PUT') @endif

    <div class="mb-6">
        <label class="block mb-2 font-semibold text-gray-800 dark:text-gray-200">Title</label>
        <input type="text" name="title" value="{{ old('title', $post->title ?? '') }}" class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg input-focus focus:ring-2 focus:ring-purple-500 text-gray-900 dark:text-gray-100 transition" required>
        @error('title') <p class="text-red-500 text-sm mt-2">{{ $message }}</p> @enderror
    </div>

    <div class="mb-6">
        <label class="block mb-2 font-semibold text-gray-800 dark:text-gray-200">Content</label>
        <textarea name="content" rows="5" class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg input-focus focus:ring-2 focus:ring-purple-500 text-gray-900 dark:text-gray-100 transition">{{ old('content', $post->content ?? '') }}</textarea>
        @error('content') <p class="text-red-500 text-sm mt-2">{{ $message }}</p> @enderror
    </div>
    
    @include('posts.partials.image-upload', ['post' => $post ?? null])
    
    @include('posts.partials.youtube-field', ['post' => $post ?? null])

    <div class="mb-6">
        <label class="block mb-2 font-semibold text-gray-800 dark:text-gray-200">Category</label>
        <select name="category_id" required class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg input-focus focus:ring-2 focus:ring-purple-500 text-gray-900 dark:text-gray-100 transition">
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $post->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="flex justify-end space-x-3">
        <a href="{{ route('posts.index') }}" class="px-5 py-2.5 bg-gray-300 dark:bg-gray-600 rounded-lg text-gray-800 dark:text-gray-200 hover:bg-gray-400 dark:hover:bg-gray-500 transition">Cancel</a>
        <button type="submit" class="px-5 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition">Save</button>
    </div>
</form>
