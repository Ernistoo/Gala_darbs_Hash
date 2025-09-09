<nav class="flex flex-col flex-1 
            bg-gradient-to-b from-gray-100 to-yellow-50 
            dark:from-black dark:to-purple-900">
    <!-- Logo -->
    <div class="flex items-center space-x-2 p-4">
        <x-application-logo class="h-16 w-16 text-gray-800 dark:text-gray-200" />
        <span class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ config('app.name') }}</span>
    </div>

    <div class="flex-1 flex flex-col gap-3 px-4 mt-4">
    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
        class="block bg-transparent dark:transparent rounded-lg p-3 shadow hover:shadow-md transition">
        {{ __('Dashboard') }}
    </x-nav-link>

    <x-nav-link :href="route('posts.index')" :active="request()->routeIs('posts')"
        class="block bg-transparent dark:transparent rounded-lg p-3 shadow hover:shadow-md transition">
        {{ __('Posts') }}
    </x-nav-link>

    <x-nav-link :href="route('clubs')" :active="request()->routeIs('clubs')"
        class="block bg-transparent dark:transparent rounded-lg p-3 shadow hover:shadow-md transition">
        {{ __('Clubs') }}
    </x-nav-link>

    <x-nav-link :href="route('collections')" :active="request()->routeIs('collections')"
        class="block bg-transparent dark:transparent rounded-lg p-3 shadow hover:shadow-md transition">
        {{ __('Collections') }}
    </x-nav-link>
</div>


    <!-- Theme toggle button -->
    <div class="p-4">
        <button id="theme-toggle" type="button"
            class="text-gray-700 dark:text-gray-200 
                   hover:bg-gray-200 dark:hover:bg-purple-800 
                   focus:outline-none focus:ring-4 
                   focus:ring-gray-300 dark:focus:ring-purple-600 
                   rounded-lg text-sm p-2.5">
            <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor"
                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
            </svg>
            <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor"
                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M10 2a1 1 0 011 1v1a1 1 0 
                    11-2 0V3a1 1 0 011-1zm4 8a4 4 0 
                    11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 
                    1 0 001.414-1.414l-.707-.707a1 1 0 
                    00-1.414 1.414zm2.12-10.607a1 1 0 
                    010 1.414l-.706.707a1 1 0 
                    11-1.414-1.414l.707-.707a1 1 0 
                    011.414 0zM17 11a1 1 0 100-2h-1a1 
                    1 0 100 2h1zm-7 4a1 1 0 011 
                    1v1a1 1 0 11-2 0v-1a1 1 0 
                    011-1zM5.05 6.464A1 1 0 106.465 
                    5.05l-.708-.707a1 1 0 00-1.414 
                    1.414l.707.707zm1.414 8.486l-.707.707a1 
                    1 0 01-1.414-1.414l.707-.707a1 1 0 
                    011.414 1.414zM4 11a1 1 0 
                    100-2H3a1 1 0 000 2h1z">
                </path>
            </svg>
        </button>
    </div>

    <div class="border-t border-gray-200 dark:border-gray-700 p-4">
        <div class="text-gray-700 dark:text-gray-300 font-medium">
            {{ Auth::user()->name }}
        </div>
        <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
            {{ __('Profile Settings') }}
        </x-nav-link>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="block w-full text-left px-4 py-2 rounded-lg text-sm 
                       text-red-500 hover:bg-red-100 dark:hover:bg-purple-800">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</nav>
