<nav class="flex flex-col flex-1 bg-gradient-to-b from-gray-200 to-purple-100 dark:from-black dark:to-purple-900 transition-colors duration-500 ease-in-out">

 
    <div class="hidden lg:flex items-center space-x-2 p-4">
        <x-application-logo class="h-16 w-16 text-gray-800 dark:text-gray-200" />
        <span class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ config('app.name') }}</span>
    </div>

 
    <div class="flex-1 flex flex-col gap-3 px-4 mt-4 lg:mt-4">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
            class="block bg-transparent dark:transparent rounded-lg p-3 shadow hover:shadow-md transition">
            {{ __('Dashboard') }}
        </x-nav-link>

        <x-nav-link :href="route('posts.index')" :active="request()->routeIs('posts.index')"
            class="block bg-transparent dark:transparent rounded-lg p-3 shadow hover:shadow-md transition">
            {{ __('Explore') }}
        </x-nav-link>

        <x-nav-link :href="route('collections.index')" :active="request()->routeIs('collections.index')"
            class="block bg-transparent dark:transparent rounded-lg p-3 shadow hover:shadow-md transition">
            {{ __('Collections') }}
        </x-nav-link>

        <x-nav-link :href="route('challenges.index')" :active="request()->routeIs('challenges.index')"
            class="block bg-transparent dark:transparent rounded-lg p-3 shadow hover:shadow-md transition">
            {{ __('Challenges') }}
        </x-nav-link>

        <x-nav-link :href="route('leaderboard.index')" :active="request()->routeIs('leaderboard.index')"
            class="block bg-transparent dark:transparent rounded-lg p-3 shadow hover:shadow-md transition">
            {{ __('Leaderboard') }}
        </x-nav-link>

        <x-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.index')"
            class="relative block bg-transparent dark:transparent rounded-lg p-3 shadow hover:shadow-md transition">
            {{ __('Notifications') }}

            @if(auth()->user()->unreadNotifications->count() > 0)
                <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                    {{ auth()->user()->unreadNotifications->count() }}
                </span>
            @endif
        </x-nav-link>

        <x-nav-link :href="route('friends.index')" :active="request()->routeIs('friends.index')"
            class="block bg-transparent rounded-lg p-3 shadow hover:shadow-md transition">
            {{ __('Friends') }}
        </x-nav-link>

        @role('admin')
        <x-nav-link :href="route('admin')" :active="request()->routeIs('admin')"
            class="block bg-transparent dark:transparent rounded-lg p-3 shadow hover:shadow-md transition">
            {{ __('Admin') }}
        </x-nav-link>
        @endrole
    </div>


    <div class="p-4">
        <button id="theme-toggle" type="button"
            class="flex items-center justify-center w-full text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 transition">
            <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
            </svg>
            <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>

    <div class="mt-auto p-4 border-t border-gray-200 dark:border-gray-700">
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 hover:bg-gray-100 dark:hover:bg-gray-700 p-2 rounded-lg transition">
            <img src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('default-avatar.png') }}"
                alt="{{ auth()->user()->name }}"
                class="w-12 h-12 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600" />
            <div>
                <p class="font-semibold text-gray-800 dark:text-gray-200">{{ auth()->user()->name }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ auth()->user()->username }}</p>
            </div>
        </a>
    </div>
</nav>