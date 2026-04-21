@props(['post' => null])

<div class="mb-6">
    <label class="block mb-2 font-semibold text-gray-800 dark:text-gray-200">Upload Video</label>

    <div class="video-upload-area flex flex-col items-center justify-center w-full h-40 border-2 border-dashed
                border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-purple-500
                dark:hover:border-purple-400 transition bg-white dark:bg-gray-700 p-6 text-center">

        <input type="file" name="video" class="hidden" accept="video/*">

        <div class="video-drag-content">
            <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
            </svg>
            <p class="text-gray-500 dark:text-gray-400">Drag & drop your video here or
                <span class="text-purple-600 dark:text-purple-400 font-medium">browse files</span>
            </p>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">MP4, MOV, AVI, WMV, FLV, MKV, WEBM up to 50MB</p>
        </div>

        <div class="video-preview-container hidden mt-4 w-full">
            <video class="video-preview mx-auto max-h-32 rounded-lg shadow-md" controls></video>
            <button type="button" class="remove-video mt-2 text-sm text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300">
                Remove video
            </button>
        </div>
    </div>

    @if($post?->video)
        <div class="mt-4 flex justify-center">
            <video src="{{ asset('storage/' . $post->video) }}" controls
                   class="w-full max-w-md rounded-lg shadow-md"></video>
        </div>
    @endif

    @error('video')
        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
    @enderror
</div>

<script>
(function() {
    const area = document.currentScript.parentElement.querySelector('.video-upload-area');
    if (!area) return;
    const input = area.querySelector('input[type="file"]');
    const dragContent = area.querySelector('.video-drag-content');
    const previewContainer = area.querySelector('.video-preview-container');
    const videoPreview = area.querySelector('.video-preview');
    const removeBtn = area.querySelector('.remove-video');
    
    const handleFile = (file) => {
        if (!file || !file.type.startsWith('video/')) return;
        const reader = new FileReader();
        reader.onload = e => {
            videoPreview.src = e.target.result;
            dragContent.classList.add('hidden');
            previewContainer.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    };
    
    area.addEventListener('click', (e) => {
        if (e.target.closest('button, .remove-video')) return;
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
        videoPreview.src = '';
        previewContainer.classList.add('hidden');
        dragContent.classList.remove('hidden');
    });
})();
</script>