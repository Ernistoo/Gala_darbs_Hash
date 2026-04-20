<div class="break-inside-avoid bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl overflow-hidden transition-all duration-300 transform hover:-translate-y-1.5 relative mb-4 group border border-gray-100 dark:border-gray-700">
    
    <!-- Clickable Image Container -->
    <div class="relative overflow-hidden cursor-pointer" onclick="openLightbox('{{ asset('storage/' . $submission->image) }}')">
        <img src="{{ asset('storage/' . $submission->image) }}" 
             alt="submission" 
             class="w-full object-cover rounded-t-xl group-hover:scale-105 transition-transform duration-500">
        
        <!-- Gradient Overlay on Hover -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
        
        <!-- Expand Icon -->
        <div class="absolute bottom-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <svg class="w-5 h-5 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
            </svg>
        </div>
    </div>

    <div class="p-4">
        <!-- User Info Row -->
        <div class="flex items-center justify-between mb-3">
            <a href="{{ route('users.show', $submission->user) }}" class="flex items-center gap-3 group/user">
                <div class="relative">
                    <img src="{{ userAvatar($submission->user->profile_photo) }}"
                         alt="{{ $submission->user->name }}"
                         class="w-10 h-10 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600 group-hover/user:border-purple-400 transition-colors">
                </div>
                <div>
                    <span class="text-sm font-semibold text-gray-800 dark:text-gray-200 group-hover/user:text-purple-600 dark:group-hover/user:text-purple-400 transition">
                        {{ $submission->user->name }}
                    </span>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $submission->created_at->diffForHumans() }}
                    </p>
                </div>
            </a>

            <!-- Vote Section -->
            <div class="flex flex-col items-center">
                <button type="button"
                    class="upvote-btn focus:outline-none group/upvote"
                    data-submission-id="{{ $submission->id }}">
                    <div class="p-1.5 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <img src="{{ asset('images/upvote.svg') }}"
                            alt="Upvote"
                            class="w-5 h-5 upvote-icon transition-transform group-hover/upvote:scale-110">
                    </div>
                </button>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 upvote-count">
                    {{ $submission->votes()->count() }}
                </span>
            </div>
        </div>

        <!-- Title -->
        @if($submission->title ?? false)
        <h4 class="font-semibold text-gray-800 dark:text-gray-200 text-sm line-clamp-2 leading-snug">
            {{ $submission->title }}
        </h4>
        @endif

        
    </div>
</div>