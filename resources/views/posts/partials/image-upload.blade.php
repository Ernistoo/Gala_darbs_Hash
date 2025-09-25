@props(['post' => null])

<div class="mb-6">
    <label for="image" class="block mb-2 font-semibold text-gray-800 dark:text-gray-200">
        Featured Image
    </label>

    <div class="flex items-center justify-center w-full">
        <label for="image"
               class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed
                      border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer
                      hover:border-purple-500 dark:hover:border-purple-400
                      transition bg-white dark:bg-gray-700">
            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                <svg class="w-10 h-10 mb-3 text-gray-400 dark:text-gray-500"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                    <span class="font-semibold">Click to upload</span> or drag and drop
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF (MAX. 5MB)</p>
            </div>
            <input id="image" name="image" type="file" class="hidden" />
        </label>
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
