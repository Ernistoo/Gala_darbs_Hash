<div class="flex items-center justify-between mb-6 relative">
    <h2 class="font-semibold text-xl  
               bg-gradient-to-r from-purple-700 via-blue-600 to-indigo-600 
               dark:bg-gradient-to-r dark:from-purple-600 dark:via-purple-400 dark:to-pink-400
               inline-block text-transparent bg-clip-text leading-tight">
        {{ $slot }}
    </h2>

    <div class="flex items-center space-x-2 
                bg-white/80 dark:bg-gray-800/80 
                backdrop-blur-md px-4 py-2 rounded-full shadow">
        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" 
             fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" 
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" 
                  clip-rule="evenodd"/>
        </svg>
        <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
            {{ auth()->user()->xp ?? 0 }} XP
        </span>
    </div>
</div>
