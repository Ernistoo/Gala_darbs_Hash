<nav class="flex flex-col flex-1">
    <!-- Logo -->
    <div class="flex items-center space-x-2 p-4">
      <x-application-logo class="h-16 w-16 text-gray-800 dark:text-gray-200" />
        <span class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ config('app.name') }}</span>
    </div>

    
    <div class="flex-1 space-y-2 px-4">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-nav-link>
        <x-nav-link :href="route('posts.index')" :active="request()->routeIs('posts')">
            {{ __('Posts') }}
        </x-nav-link>
        <x-nav-link :href="route('clubs')" :active="request()->routeIs('clubs')">
            {{ __('Clubs') }}
        </x-nav-link>
        <x-nav-link :href="route('collections')" :active="request()->routeIs('collections')">
            {{ __('Collections') }}
        </x-nav-link>
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
                    class="block w-full text-left px-4 py-2 rounded-lg text-sm text-red-500 hover:bg-red-100 dark:hover:bg-gray-700">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</nav>
