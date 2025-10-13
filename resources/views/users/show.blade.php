<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="max-w-4xl mx-auto p-6 space-y-8">
        <x-profile.header :user="$user" />

        <x-profile.badges :user="$user" />

        <x-profile.posts-grid :posts="$posts" />
    </div>
</x-app-layout>