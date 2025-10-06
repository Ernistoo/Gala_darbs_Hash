@props(['post' => null])

<div class="mb-6">
    <label class="block mb-2 font-semibold text-gray-800 dark:text-gray-200">
        Featured Image
    </label>

    <div id="drag-area"
         class="drag-area flex flex-col items-center justify-center w-full h-40 border-2 border-dashed
                border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-purple-500
                dark:hover:border-purple-400 transition bg-white dark:bg-gray-700 p-6 text-center">

        <input type="file" name="image" id="file-input" class="hidden" accept="image/*">

        <div id="drag-content">
            <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-gray-500 dark:text-gray-400">
                Drag & drop your image here or
                <span class="text-purple-600 dark:text-purple-400 font-medium">browse files</span>
            </p>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                PNG, JPG, GIF, WEBP up to 5MB
            </p>
        </div>

       
        <div id="preview-container" class="hidden mt-4">
            <img id="preview-image" class="preview-image mx-auto max-h-24 rounded-lg shadow-md">
            <button type="button" id="remove-image"
                    class="mt-2 text-sm text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300">
                Remove image
            </button>
        </div>
    </div>

    @if($post?->image)
        <div class="mt-4 flex justify-center">
            <img src="{{ asset('storage/' . $post->image) }}"
                 alt="Current image"
                 class="w-48 h-48 object-cover rounded-lg shadow-md">
        </div>
    @endif

    @error('image')
        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
    @enderror
</div>

