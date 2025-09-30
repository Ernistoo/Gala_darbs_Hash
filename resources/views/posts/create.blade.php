<x-app-layout>
<x-header>        
            {{ __('Create') }}
    </x-header>
    <div class="flex justify-center py-6">
    <x-posts.form :action="route('posts.store')" :categories="$categories" />
    </div>
</x-app-layout>
