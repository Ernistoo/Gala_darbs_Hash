<div class="challenge-card border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden card-hover h-full">
    <!-- Augstāka bilde -->
    <div class="h-56 relative overflow-hidden">
        @if($challenge->image)
            <img src="{{ asset('storage/' . $challenge->image) }}"
                 alt="{{ $challenge->title }}"
                 class="absolute inset-0 w-full h-full object-cover">
        @else
            <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-r from-purple-500 to-pink-500">
                <svg class="w-16 h-16 text-white opacity-30" fill="currentColor" viewBox="0 0 20 20">
                    <path ... />
                </svg>
            </div>
        @endif
        <div class="absolute bottom-4 left-4">
            <span class="bg-white/90 dark:bg-gray-800/90 text-purple-600 dark:text-purple-400 text-xs font-bold px-2 py-1 rounded-md">
                +{{ $challenge->xp_reward ?? 0 }} XP
            </span>
        </div>
    </div>

    <!-- Mazāks tekstu bloks -->
    <div class="p-4">
        <h3 class="font-semibold text-base mb-1">{{ $challenge->title }}</h3>
        <p class="text-gray-600 dark:text-gray-400 text-xs line-clamp-2">
            {{ Str::limit($challenge->description, 80) }}
        </p>
    </div>
</div>
