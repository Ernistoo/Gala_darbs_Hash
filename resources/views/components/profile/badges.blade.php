<div x-data="{ open: false }" class="mb-8">
    <button @click="open = !open"
        class="flex items-center justify-between w-full text-left text-lg font-semibold text-gray-800 dark:text-gray-200 focus:outline-none transition">
        <div class="flex items-center gap-2">🏅 Badges</div>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor"
            class="w-5 h-5 transform transition-transform duration-300"
            :class="{ 'rotate-180': open }">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="m19.5 8.25-7.5 7.5-7.5-7.5" />
        </svg>
    </button>

    <div x-show="open" x-transition.duration.400ms x-cloak class="mt-4">
        @if($user->badges->count())
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @foreach($user->badges as $badge)
            <div class="group relative bg-gradient-to-br from-gray-100 via-gray-200 to-gray-100 
                        dark:from-gray-800 dark:via-gray-900 dark:to-gray-800 
                        rounded-xl shadow-md hover:shadow-xl overflow-hidden transition-transform transform hover:-translate-y-1 p-4">
                <div class="flex flex-col items-center text-center relative z-10">
                    <img src="{{ asset('images/' . $badge->image) }}"
                        alt="{{ $badge->name }}"
                        class="w-16 h-16 rounded-full border-2 border-purple-400 dark:border-purple-600 mb-2 
                                    group-hover:scale-105 transition-transform duration-300">
                    <h4 class="font-semibold text-gray-900 dark:text-gray-100 text-sm">
                        {{ $badge->name }}
                    </h4>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 line-clamp-2">
                        {{ $badge->description }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500 dark:text-gray-400 mt-2">No badges earned yet.</p>
        @endif
    </div>
</div>