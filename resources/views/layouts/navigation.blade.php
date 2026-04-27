<nav class="flex flex-col h-full bg-gradient-to-b from-gray-200 to-purple-100 dark:from-black dark:to-purple-900 transition-colors duration-500 ease-in-out">

    <div class="hidden lg:flex items-center space-x-2 p-4 shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 group cursor-pointer">
            <img src="{{ asset('images/chat.png') }}"
                alt="{{ config('app.name') }} logo"
                class="h-16 w-16 object-contain transition-transform duration-300 group-hover:scale-110" />
            <span class="text-lg font-bold text-gray-800 dark:text-gray-200 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition">
                {{ config('app.name') }}
            </span>
        </a>
    </div>

    <div class="flex lg:hidden items-center justify-center p-3 border-b border-gray-300 dark:border-gray-700 shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center justify-center space-x-2 cursor-pointer group">
            <img src="{{ asset('images/chat.png') }}"
                alt="{{ config('app.name') }} logo"
                class="h-12 w-12 object-contain transition-transform duration-300 group-hover:scale-110" />
        </a>
    </div>

    <div class="flex-1 overflow-y-auto flex flex-col gap-1 px-4 mt-4 lg:mt-4">
        <x-nav-link :href="route('posts.index')" :active="request()->routeIs('posts.index')"
            class="flex items-center gap-3 bg-transparent dark:transparent rounded-lg p-3 shadow hover:shadow-md transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>
            {{ __('Explore') }}
        </x-nav-link>

        <x-nav-link :href="route('search.index')" :active="request()->routeIs('search.index')"
            class="flex items-center gap-3 bg-transparent dark:transparent rounded-lg p-3 shadow hover:shadow-md transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            {{ __('Search') }}
        </x-nav-link>

        <x-nav-link :href="route('collections.index')" :active="request()->routeIs('collections.index')"
            class="flex items-center gap-3 bg-transparent dark:transparent rounded-lg p-3 shadow hover:shadow-md transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            {{ __('Collections') }}
        </x-nav-link>

        <x-nav-link :href="route('challenges.index')" :active="request()->routeIs('challenges.index')"
            class="flex items-center gap-3 bg-transparent dark:transparent rounded-lg p-3 shadow hover:shadow-md transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
            </svg>
            {{ __('Challenges') }}
        </x-nav-link>

        <x-nav-link :href="route('leaderboard.index')" :active="request()->routeIs('leaderboard.index')"
            class="flex items-center gap-3 bg-transparent dark:transparent rounded-lg p-3 shadow hover:shadow-md transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            {{ __('Leaderboard') }}
        </x-nav-link>

        <x-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.index')"
            class="relative flex items-center gap-3 bg-transparent dark:transparent rounded-lg p-3 shadow hover:shadow-md transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            {{ __('Notifications') }}
            @if(auth()->user()->unreadNotifications->count() > 0)
                <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                    {{ auth()->user()->unreadNotifications->count() }}
                </span>
            @endif
        </x-nav-link>

        <x-nav-link :href="route('friends.index')" :active="request()->routeIs('friends.index')"
    class="relative flex items-center gap-3 bg-transparent dark:transparent rounded-lg p-3 shadow hover:shadow-md transition">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
    </svg>
    {{ __('Friends') }}
    
    @php $unreadChatCount = auth()->user()->unreadChatSendersCount(); @endphp
    @if($unreadChatCount > 0)
        <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">
            {{ $unreadChatCount }}
        </span>
    @endif
</x-nav-link>

        @role('admin')
        <x-nav-link :href="route('admin')" :active="request()->routeIs('admin')"
            class="flex items-center gap-3 bg-transparent dark:transparent rounded-lg p-3 shadow hover:shadow-md transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            {{ __('Admin') }}
        </x-nav-link>
        @endrole
    </div>

    <div class="p-4 shrink-0">
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

    <div class="shrink-0 p-3 sm:p-4 border-t border-gray-200 dark:border-gray-700">
        <a href="{{ route('users.show', auth()->user()) }}"
            class="flex items-center gap-3 hover:bg-gray-100 dark:hover:bg-gray-700 p-2 rounded-lg transition">
            <img src="{{ userAvatar(auth()->user()->profile_photo) }}"
                alt="{{ auth()->user()->name }}"
                class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600" />
            <div>
                <p class="font-semibold text-sm sm:text-base text-gray-800 dark:text-gray-200">{{ auth()->user()->name }}</p>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">{{ '@'.auth()->user()->username }}</p>
            </div>
        </a>
    </div>
</nav>