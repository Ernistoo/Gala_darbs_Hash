<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Edit Post - {{ config('app.name', 'Hash') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        purple: {
                            50: '#faf5ff',
                            100: '#f3e8ff',
                            200: '#e9d5ff',
                            300: '#d8b4fe',
                            400: '#c084fc',
                            500: '#a855f7',
                            600: '#9333ea',
                            700: '#7e22ce',
                            800: '#6b21a8',
                            900: '#581c87',
                        },
                    },
                    fontFamily: {
                        sans: ['Figtree', 'sans-serif'],
                    },
                }
            }
        }
    </script>
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

        .carousel-transition {
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gradient-to-br from-gray-200 to-purple-100 dark:from-black dark:to-purple-900 transition-colors duration-500 ease-in-out min-h-screen">
    <div class="min-h-screen flex">
        <!-- Sidebar would be here -->

        <!-- Main content -->
        <div class="flex-1 flex flex-col ml-64 transition-colors duration-500 ease-in-out">
            <header class="transition-colors duration-500 ease-in-out">
                <div class="px-6 py-4 transition-colors duration-500 ease-in-out text-gray-900 dark:text-gray-100">
                    <h2 class="text-xl font-semibold">Edit Post</h2>
                </div>
            </header>

            <main class="p-6 transition-colors duration-500 ease-in-out text-gray-900 dark:text-gray-100">
                <div class="max-w-2xl mx-auto fade-in">
                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Title -->
                            <div class="mb-6">
                                <label for="title" class="block mb-2 font-semibold text-gray-800 dark:text-gray-200">Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}"
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg input-focus focus:outline-none focus:ring-2 focus:ring-purple-500 text-gray-900 dark:text-gray-100 transition">
                                @error('title')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Content -->
                            <div class="mb-6">
                                <label for="content" class="block mb-2 font-semibold text-gray-800 dark:text-gray-200">Content</label>
                                <textarea name="content" id="content"
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg input-focus focus:outline-none focus:ring-2 focus:ring-purple-500 text-gray-900 dark:text-gray-100 transition" rows="5">{{ old('content', $post->content) }}</textarea>
                                @error('content')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Image -->
                            <div class="mb-6">
                                <label for="image" class="block mb-2 font-semibold text-gray-800 dark:text-gray-200">Image</label>
                                <div class="flex items-center justify-center w-full">
                                    <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-purple-500 dark:hover:border-purple-400 transition bg-white dark:bg-gray-700">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-10 h-10 mb-3 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF (MAX. 5MB)</p>
                                        </div>
                                        <input id="image" name="image" type="file" class="hidden" />
                                    </label>
                                </div>
                                @if($post->image)
                                <div class="mt-4 flex justify-center">
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="Current image" class="w-48 h-48 object-cover rounded-lg shadow-md">
                                </div>
                                @endif
                                @error('image')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- YouTube URL -->
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

                            <!-- Category -->
                            <div class="mb-6">
                                <label class="block mb-2 font-semibold text-gray-800 dark:text-gray-200">Category</label>
                                <select
                                    name="category_id"
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg input-focus focus:outline-none focus:ring-2 focus:ring-purple-500 text-gray-900 dark:text-gray-100 transition"
                                    required>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('posts.index') }}"
                                    class="px-5 py-2.5 bg-gray-300 dark:bg-gray-600 rounded-lg text-gray-800 dark:text-gray-200 hover:bg-gray-400 dark:hover:bg-gray-500 transition">Cancel</a>
                                <button type="submit"
                                    class="px-5 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 btn-transition transition">Update Post</button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Update file upload label when a file is selected
        document.getElementById('image').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            const label = document.querySelector('label[for="image"]');

            if (fileName) {
                label.querySelector('p:first-child').innerHTML = `<span class="font-semibold">${fileName}</span>`;
            }
        });

        // Theme toggle logic
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