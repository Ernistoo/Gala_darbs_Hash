@php $xp = $user->xp_progress; @endphp

<div class="w-full max-w-md">
    <div class="flex justify-between text-sm text-gray-700 dark:text-gray-300 mb-1">
        <span class="font-semibold">Level {{ $xp['level'] }}</span>
        <span>{{ $xp['current_xp'] }} / {{ $xp['needed_xp'] }} XP</span>
    </div>

    <div class="relative w-full h-5 bg-gray-300 dark:bg-gray-700 rounded-full overflow-hidden shadow-lg">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-800 via-pink-400 to-purple-400 animate-pulse transition-all duration-700 ease-out"
            style="width: {{ $xp['progress_percent'] }}%"></div>
    </div>

    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
        {{ $xp['remaining_xp'] }} XP to next level
    </p>
</div>