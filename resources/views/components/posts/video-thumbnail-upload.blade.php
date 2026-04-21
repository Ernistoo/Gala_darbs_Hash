@props(['post' => null])

<div class="mb-6">
    <label class="block mb-2 font-semibold text-gray-800 dark:text-gray-200">Video Thumbnail (optional)</label>

    <div class="thumbnail-upload-area flex flex-col items-center justify-center w-full h-32 border-2 border-dashed
                border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-purple-500
                dark:hover:border-purple-400 transition bg-white dark:bg-gray-700 p-4 text-center">

        <input type="file" name="video_thumbnail" class="hidden" accept="image/*">

        <div class="thumbnail-drag-content">
            <svg class="w-8 h-8 text-gray-400 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                <span class="text-purple-600 dark:text-purple-400 font-medium">Choose a thumbnail</span> or drag & drop
            </p>
            <p class="text-xs text-gray-400 dark:text-gray-500">Will be displayed with a play icon</p>
        </div>

        <div class="thumbnail-preview-container hidden mt-2">
            <img class="thumbnail-preview mx-auto max-h-20 rounded-lg shadow-md">
            <button type="button" class="remove-thumbnail mt-1 text-xs text-red-600 dark:text-red-400">Remove</button>
        </div>
    </div>

    @if($post?->video_thumbnail)
    <div class="mt-2">
        <p class="text-sm text-gray-600 dark:text-gray-400">Current thumbnail:</p>
        <img src="{{ Storage::url($post->video_thumbnail) }}" class="h-20 rounded-lg">
    </div>
    @endif
</div>

<script>
    (function() {
        const area = document.currentScript.parentElement.querySelector('.thumbnail-upload-area');
        if (!area) return;
        const input = area.querySelector('input[type="file"]');
        const dragContent = area.querySelector('.thumbnail-drag-content');
        const previewContainer = area.querySelector('.thumbnail-preview-container');
        const previewImg = area.querySelector('.thumbnail-preview');
        const removeBtn = area.querySelector('.remove-thumbnail');

        const handleFile = (file) => {
            if (!file || !file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = e => {
                previewImg.src = e.target.result;
                dragContent.classList.add('hidden');
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        };

        area.addEventListener('click', (e) => {
            if (e.target.closest('button, .remove-thumbnail')) return;
            input.click();
        });

        input.addEventListener('change', () => handleFile(input.files[0]));

        ['dragenter', 'dragover'].forEach(ev => area.addEventListener(ev, e => {
            e.preventDefault();
            area.classList.add('border-purple-500');
        }));
        ['dragleave', 'drop'].forEach(ev => area.addEventListener(ev, e => {
            e.preventDefault();
            area.classList.remove('border-purple-500');
        }));
        area.addEventListener('drop', e => handleFile(e.dataTransfer.files[0]));

        removeBtn?.addEventListener('click', () => {
            input.value = '';
            previewImg.src = '';
            previewContainer.classList.add('hidden');
            dragContent.classList.remove('hidden');
        });
    })();
</script>