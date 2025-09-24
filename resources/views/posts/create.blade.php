<x-app-layout>

    <style>
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.2);
        }

        .btn-transition {
            transition: all 0.2s ease-in-out;
        }

        .dark .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.4);
        }
    </style>

    <a href="{{ route('posts.index') }}" class="inline-flex items-center justify-center w-10 h-10 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-full shadow hover:bg-purple-100 dark:hover:bg-purple-800 transition btn-transition">
        <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
    </a>

    <body class="font-sans antialiased bg-gradient-to-br from-gray-200 to-purple-100 dark:from-black dark:to-purple-900 transition-colors duration-500 ease-in-out min-h-screen">
        <div class="min-h-screen flex">
            <div class="flex-1 flex flex-col transition-colors duration-500 ease-in-out">
                <header class="transition-colors duration-500 ease-in-out">
                    <div class="px-6 py-4 transition-colors duration-500 ease-in-out text-gray-900 dark:text-gray-100">
                        <h2 class="text-center text-2xl font-bold">Create Post</h2>
                    </div>
                </header>

                <main class="p-6 transition-colors duration-500 ease-in-out text-gray-900 dark:text-gray-100">
                    <div class="flex justify-center mt-2 fade-in">
                        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="w-full max-w-2xl bg-white/80 dark:bg-gray-800/80 backdrop-blur-md p-6 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                            @csrf


                            <div class="mb-6">
                                <label class="block mb-2 font-semibold text-gray-800 dark:text-gray-200">Title</label>
                                <input
                                    type="text"
                                    name="title"
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg input-focus focus:outline-none focus:ring-2 focus:ring-purple-500 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 transition"
                                    placeholder="Enter a compelling title"
                                    required>
                            </div>

                            <div class="mb-6">
                                <label class="block mb-2 font-semibold text-gray-800 dark:text-gray-200">Content</label>
                                <textarea
                                    name="content"
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg input-focus focus:outline-none focus:ring-2 focus:ring-purple-500 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 transition"
                                    rows="5"
                                    placeholder="Write your post content here..."></textarea>
                            </div>

                            <!-- Image Upload -->
                            <div class="mb-6">
                                <label class="block mb-2 font-semibold text-gray-800 dark:text-gray-200">Featured Image</label>
                                <div id="uploadBox"
                                    class="relative flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-purple-500 dark:hover:border-purple-400 transition bg-white dark:bg-gray-700 overflow-hidden">

                                    <!-- Default content -->
                                    <div id="uploadPlaceholder" class="flex flex-col items-center justify-center pointer-events-none">
                                        <svg class="w-10 h-10 mb-3 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                            <span class="font-semibold">Click to upload</span> or drag and drop
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF (MAX. 5MB)</p>
                                    </div>

                                    <!-- Preview image -->
                                    <img id="previewImg" src="#" alt="Preview"
                                        class="hidden max-h-40 max-w-full object-contain rounded-lg" />

                                    <!-- Cancel button -->
                                    <button type="button" id="removeImage"
                                        class="hidden absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded hover:bg-red-700 transition">
                                        ✕
                                    </button>

                                    <input id="image" name="image" type="file" class="hidden" accept="image/*" />
                                </div>

                                @error('image')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!--Youtube URL-->
                            <div class="mb-6">
                                <label for="youtube_url" class="block mb-2 font-semibold text-gray-800 dark:text-gray-200">YouTube URL</label>
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
                                        </svg>
                                    </span>
                                    <input
                                        type="url"
                                        id="youtube_url"
                                        name="youtube_url"
                                        value="{{ old('youtube_url', $post->youtube_url ?? '') }}"
                                        class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-r-lg input-focus focus:outline-none focus:ring-2 focus:ring-purple-500 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 transition"
                                        placeholder="https://www.youtube.com/watch?v=XXXX">
                                </div>
                                @error('youtube_url')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!--Category Field-->
                            <div class="mb-6">
                                <label class="block mb-2 font-semibold text-gray-800 dark:text-gray-200">Category</label>
                                <select
                                    name="category_id"
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg input-focus focus:outline-none focus:ring-2 focus:ring-purple-500 text-gray-900 dark:text-gray-100 transition"
                                    required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="text-center">
                                <button
                                    type="submit"
                                    class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 btn-transition focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 transition">
                                    Create Post
                                </button>
                            </div>
                        </form>
                    </div>
                </main>
            </div>
        </div>

        <script>
            const fileInput = document.getElementById('image');
            const previewImg = document.getElementById('previewImg');
            const placeholder = document.getElementById('uploadPlaceholder');
            const removeBtn = document.getElementById('removeImage');
            const uploadBox = document.getElementById('uploadBox');

            // Click uz kastes atver file chooser
            uploadBox.addEventListener('click', () => fileInput.click());

            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        previewImg.src = ev.target.result;
                        previewImg.classList.remove('hidden');
                        removeBtn.classList.remove('hidden');
                        placeholder.classList.add('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });

            removeBtn.addEventListener('click', function(e) {
                e.stopPropagation(); // lai nesaprot kā klikšķi uz uploadBox
                fileInput.value = '';
                previewImg.src = '#';
                previewImg.classList.add('hidden');
                removeBtn.classList.add('hidden');
                placeholder.classList.remove('hidden');
            });

            // Dark mode init (tavs kods)
            if (
                localStorage.getItem('color-theme') === 'dark' ||
                (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
            ) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

    </body>

    </html>
</x-app-layout>