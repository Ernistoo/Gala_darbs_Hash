<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <section class="py-8">
                @include('profile.partials.update-profile-information-form')
            </section>

            <div class="border-t border-gray-200 dark:border-gray-700"></div>

            <section class="py-8">
                <header class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                        {{ __('Update Password') }}
                    </h2>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Ensure your account is using a long, random password to stay secure.') }}
                    </p>
                </header>

                @include('profile.partials.update-password-form')
            </section>

            <div class="border-t border-gray-200 dark:border-gray-700"></div>

            <section class="py-8">
                <header class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                        {{ __('Delete Account') }}
                    </h2>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                    </p>
                </header>

                @include('profile.partials.delete-user-form')
            </section>

            <div class="border-t border-gray-200 dark:border-gray-700"></div>

            <section class="py-8">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center justify-center w-full px-4 py-3 rounded-lg text-sm font-medium 
                               text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 
                               border border-red-200 dark:border-red-800 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        {{ __('Log Out') }}
                    </button>
                </form>
            </section>
        </div>
    </div>
</x-app-layout>