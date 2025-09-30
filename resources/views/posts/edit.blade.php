<x-app-layout>
<x-header>        
    {{ __('Edit') }}
</x-header>
    <div class="flex justify-center py-6">
    <x-form :action="route('posts.update', $post)" :post="$post" :update="true" :categories="$categories" />

    </div>
</x-app-layout>
