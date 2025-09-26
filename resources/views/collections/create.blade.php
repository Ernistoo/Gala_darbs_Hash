<x-app-layout>
    <x-slot name="header"></x-slot>
    <form action="{{ route('challenges.store') }}" method="POST" class="space-y-4 max-w-lg mx-auto">
        @csrf
        <div>
            <label class="block mb-1 font-medium">Title</label>
            <input type="text" name="title" class="w-full border rounded p-2">
        </div>
        <div>
            <label class="block mb-1 font-medium">Description</label>
            <textarea name="description" class="w-full border rounded p-2"></textarea>
        </div>
        <div>
            <label class="block mb-1 font-medium">XP Reward</label>
            <input type="number" name="xp_reward" class="w-full border rounded p-2">
        </div>
        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded">
            Create Challenge
        </button>
    </form>
</x-app-layout>