<x-app-layout>
<x-slot name="header"></x-slot>
    <div class="flex justify-center py-6">
        @include('posts.partials.form', ['action' => route('posts.store')])
    </div>
</x-app-layout>
