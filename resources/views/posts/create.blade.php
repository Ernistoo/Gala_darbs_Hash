<x-app-layout>
<x-slot name="header"></x-slot>
    <div class="flex justify-center py-6">
    <x-form :action="route('posts.store')" :categories="$categories" /> 
    </div>
</x-app-layout>
