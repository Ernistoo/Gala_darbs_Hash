<x-app-layout>
    <div class="max-w-2xl mx-auto py-6">
        <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">My Friends</h2>

        @forelse ($friends as $friend)
            <div class="flex items-center gap-3 bg-white dark:bg-gray-800 p-4 rounded-lg mb-2">
            @foreach(auth()->user()->allFriends() as $friend)
    <img src="{{ $friend->profile_photo ? asset('storage/' . $friend->profile_photo) : asset('default-avatar.png') }}" />
@endforeach
                <div>
                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $friend->name }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ '@'.$friend->username }}</p>
                </div>
            </div>
        @empty
            <p class="text-gray-500 dark:text-gray-400">No friends yet.</p>
        @endforelse
    </div>
</x-app-layout>
