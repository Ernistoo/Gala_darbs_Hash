<nav class="flex flex-col flex-1 
            bg-gradient-to-b from-gray-200 to-purple-100 
            dark:from-black dark:to-purple-900">

    <!-- Logo -->
    <div class="flex items-center space-x-2 p-4">
        <x-application-logo class="h-16 w-16 text-gray-800 dark:text-gray-200" />
        <span class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ config('app.name') }}</span>
    </div>

    <!-- Navigation Links -->
    <div class="flex-1 flex flex-col gap-3 px-4 mt-4">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
            class="block bg-transparent dark:transparent rounded-lg p-3 shadow hover:shadow-md transition">
            {{ __('Dashboard') }}
        </x-nav-link>

        <x-nav-link :href="route('posts.index')" :active="request()->routeIs('posts')"
            class="block bg-transparent dark:transparent rounded-lg p-3 shadow hover:shadow-md transition">
            {{ __('Posts') }}
        </x-nav-link>

        <x-nav-link :href="route('collections.index')" :active="request()->routeIs('collections')"
            class="block bg-transparent dark:transparent rounded-lg p-3 shadow hover:shadow-md transition">
            {{ __('Collections') }}
        </x-nav-link>

        <x-nav-link :href="route('challenges.index')" :active="request()->routeIs('challenges')"
            class="block bg-transparent dark:transparent rounded-lg p-3 shadow hover:shadow-md transition">
            {{ __('Challenges') }}
        </x-nav-link>



        @role('admin')
        <x-nav-link :href="route('admin')" :active="request()->routeIs('admin')"
            class="block bg-transparent dark:transparent rounded-lg p-3 shadow hover:shadow-md transition">
            {{ __('Admin') }}
        </x-nav-link>
        @endrole
    </div>

    <!-- Theme toggle button -->
    <div class="p-4">
        <button id="theme-toggle" type="button" class="text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-purple-800 focus:outline-none focus:ring-4 focus:ring-gray-300 dark:focus:ring-purple-600 rounded-lg text-sm p-2.5">
            <!-- SVG icons here -->
        </button>
    </div>

    <!-- User Info at Bottom -->
    <div class="mt-auto p-4 border-t border-gray-200 dark:border-gray-700">
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 hover:bg-gray-100 dark:hover:bg-gray-700 p-2 rounded-lg transition">
            <img
                src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('default-avatar.png') }}"
                alt="{{ auth()->user()->name }}"
                class="w-12 h-12 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600" />
            <div>
                <p class="font-semibold text-gray-800 dark:text-gray-200">{{ auth()->user()->name }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ auth()->user()->username }}</p>
            </div>
        </a>
    </div>
</nav>