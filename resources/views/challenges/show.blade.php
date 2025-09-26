<x-app-layout>
<x-slot name="header"></x-slot>
    <div class="min-h-screen flex">
        <div class="flex-1 flex flex-col ml-64 transition-colors duration-500 ease-in-out mr-40">
            <header class="transition-colors duration-500 ease-in-out">
                <div class="px-6 py-4 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('challenges.index') }}" class="inline-flex items-center text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 transition mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Challenges
                    </a>

                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold">{{ $challenge->title }}</h2>

                        @role('admin')
                            <form action="{{ route('challenges.destroy', $challenge) }}" method="POST" onsubmit="return confirm('Vai tiešām dzēst šo challenge?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">
                                    Delete
                                </button>
                            </form>
                        @endrole
                    </div>
                </div>
            </header>

            <main class="p-6 text-gray-900 dark:text-gray-100">
                <div class="max-w-3xl mx-auto fade-in">

                    
                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl shadow-lg p-6 mb-6 border border-gray-200 dark:border-gray-700">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 dark:bg-purple-900/40 text-purple-800 dark:text-purple-200">
                                    {{ $challenge->category }}
                                </span>
                                <span class="ml-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-200">
                                    +{{ $challenge->xp_reward }} XP
                                </span>
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                {{ $challenge->deadline ? 'Deadline: ' . $challenge->deadline->format('M d, Y') : 'No deadline' }}
                            </div>
                        </div>

                        <p class="text-gray-600 dark:text-gray-400 mb-6">{{ $challenge->description }}</p>

                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                            </svg>
                            <span>{{ $challenge->participants_count }} people have submitted</span>
                        </div>
                    </div>

                    
                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold mb-4">Submit Your Entry</h3>

                        <form action="{{ route('submissions.store', $challenge) }}" method="POST" enctype="multipart/form-data" id="submission-form">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Upload your image
                                </label>

                                <div id="drag-area" class="drag-area rounded-lg p-8 text-center cursor-pointer">
                                    <input type="file" name="image" id="file-input" class="hidden" accept="image/*" required>
                                    <div id="drag-content">
                                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400">Drag & drop your image here or <span class="text-purple-600 dark:text-purple-400 font-medium">browse files</span></p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">PNG, JPG, GIF, WEBP up to 5MB</p>
                                    </div>
                                    <div id="preview-container" class="hidden mt-4">
                                        <img id="preview-image" class="preview-image mx-auto max-h-48 rounded-lg shadow-md">
                                        <button type="button" id="remove-image" class="mt-2 text-sm text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300">
                                            Remove image
                                        </button>
                                    </div>
                                </div>

                                @error('image')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition">
                                {{ __('Submit Entry') }}
                                <svg class="w-5 h-5 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </form>
                    </div>

                    
                    <div class="mt-6 text-center">
                        <a href="{{ route('submissions.index', $challenge) }}" class="inline-flex items-center text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 transition">
                            View all submissions
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
