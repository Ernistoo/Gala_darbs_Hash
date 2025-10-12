<x-app-layout>
    <x-slot name="header"></x-slot>
    <div class="max-w-4xl mx-auto p-6">

        <div class="flex items-center gap-4 mb-6 w-full">
            <img src="{{ userAvatar($user->profile_photo) }}"
                class="w-20 h-20 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600" />

            <div class="flex-1">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                            {{ $user->name }}

                            @if(auth()->check() && auth()->id() !== $user->id)
                            @php
                            $areFriends = auth()->user()->allFriends()->contains('id', $user->id);
                            @endphp
                            @if($areFriends)
                            <span class="text-sm font-normal text-green-600 dark:text-green-400">
                                ~ Friends
                            </span>
                            @endif
                            @endif
                        </h2>
                        <p class="text-gray-500 dark:text-gray-400">
                            {{ '@' . $user->username }}
                        </p>
                    </div>

                    @if(auth()->check())
                    @if(auth()->id() === $user->id)
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                            class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 text-2xl leading-none">
                            ⋮
                        </button>

                        <div x-show="open"
                            @click.away="open = false"
                            x-transition
                            class="absolute right-0 mt-2 w-52 bg-white dark:bg-gray-800 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700 z-10">

                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-2 px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-purple-600">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                                Edit Profile
                            </a>

                            <a href="{{ route('friends.index') }}"
                                class="flex items-center gap-2 px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-purple-600">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                </svg>
                                Manage Friends
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="flex items-center gap-2 w-full text-left px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-red-100 dark:hover:bg-red-700 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-red-600">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                                    </svg>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                    @elseif(auth()->user()->can('delete', $user))
                    <div x-data="{ open: false, deleteUserModal: false }" class="relative">
                        <button @click="open = !open" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 text-2xl">
                            ⋮
                        </button>

                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-32 bg-white dark:bg-gray-700 shadow rounded border dark:border-gray-600 z-10">
                            <button type="button" @click="deleteUserModal = true; open = false"
                                class="flex items-center gap-2 w-full text-left px-4 py-2 text-red-600 hover:bg-red-100 dark:hover:bg-red-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-red-600">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6 7.5h12m-9 4.5v6m6-6v6M4.5 7.5h15M9 3h6l1 3H8l1-3Z" />
                                </svg>
                                Delete User
                            </button>
                        </div>

                        <div x-show="deleteUserModal"
                            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                            <div @click.away="deleteUserModal = false"
                                class="bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 p-6 rounded shadow w-96">
                                <h2 class="text-xl font-bold mb-4 text-red-600">Delete User</h2>
                                <p class="mb-4 text-gray-800 dark:text-gray-200">
                                    Are you sure you want to permanently delete <b>{{ $user->name }}</b>?
                                </p>
                                <div class="flex justify-end gap-2">
                                    <button type="button" @click="deleteUserModal = false"
                                        class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded">
                                        Cancel
                                    </button>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endif
                </div>

                @if(auth()->check() && auth()->id() !== $user->id)
                @php
                $alreadyFriend = auth()->user()->allFriends()->contains('id', $user->id);

                $pending = \App\Models\Friendship::where(function($q) use ($user) {
                $q->where('user_id', auth()->id())
                ->where('friend_id', $user->id);
                })
                ->orWhere(function($q) use ($user) {
                $q->where('user_id', $user->id)
                ->where('friend_id', auth()->id());
                })
                ->where('status', 'pending')
                ->exists();
                @endphp
                <div class="mt-3">
                    @if($pending)
                    <span class="px-4 py-2 bg-yellow-500 text-white rounded">Request sent…</span>
                    @elseif(!$alreadyFriend)
                    <form action="{{ route('friends.send', $user) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded">
                            Add Friend
                        </button>
                    </form>
                    @endif
                </div>
                @endif
            </div>

            @php $xp = $user->xp_progress; @endphp
            <div class="mt-6 w-full max-w-md">
                <div class="flex justify-between text-sm text-gray-700 dark:text-gray-300 mb-1">
                    <span class="font-semibold">Level {{ $xp['level'] }}</span>
                    <span>{{ $xp['current_xp'] }} / {{ $xp['needed_xp'] }} XP</span>
                </div>

                <div class="relative w-full h-5 bg-gray-300 dark:bg-gray-700 rounded-full overflow-hidden shadow-lg">
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-800 via-pink-400 to-purple-400 
                            animate-pulse transition-all duration-700 ease-out"
                        style="width: {{ $xp['progress_percent'] }}%">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-500/40 via-pink-400/30 to-yellow-300/20 blur-md"></div>
                </div>

                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    {{ $xp['remaining_xp'] }} XP to next level
                </p>
            </div>
        </div>

        <div x-data="{ open: false }" class="mb-8">
            <button @click="open = !open"
                class="flex items-center justify-between w-full text-left text-lg font-semibold text-gray-800 dark:text-gray-200 focus:outline-none transition">
                <div class="flex items-center gap-2">
                    🏅 Badges
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor"
                    class="w-5 h-5 transform transition-transform duration-300"
                    :class="{ 'rotate-180': open }">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>

            <div x-show="open" x-transition.duration.400ms x-cloak class="mt-4">
                @if($user->badges->count())
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @foreach($user->badges as $badge)
                    <div class="group relative bg-gradient-to-br from-gray-100 via-gray-200 to-gray-100 
                                    dark:from-gray-800 dark:via-gray-900 dark:to-gray-800 
                                    rounded-xl shadow-md hover:shadow-xl overflow-hidden transition-transform transform hover:-translate-y-1 p-4">
                        <div class="flex flex-col items-center text-center relative z-10">
                            <img src="{{ asset('images/' . $badge->image) }}"
                                alt="{{ $badge->name }}"
                                class="w-16 h-16 rounded-full border-2 border-purple-400 dark:border-purple-600 mb-2 
                                            group-hover:scale-105 transition-transform duration-300">
                            <h4 class="font-semibold text-gray-900 dark:text-gray-100 text-sm">
                                {{ $badge->name }}
                            </h4>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 line-clamp-2">
                                {{ $badge->description }}
                            </p>
                        </div>
                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-500 
                                        bg-gradient-to-r from-purple-600/20 via-pink-500/20 to-yellow-400/20 blur-md">
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500 dark:text-gray-400 mt-2">No badges earned yet.</p>
                @endif
            </div>
        </div>

        <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">Posts</h3>
        @if($posts->count())
        <div class="columns-2 sm:columns-3 md:columns-4 lg:columns-5 gap-4 space-y-4">
            @foreach($posts as $post)
            <a href="{{ route('posts.show', $post) }}"
                class="group relative break-inside-avoid block rounded-xl shadow hover:shadow-lg overflow-hidden transition transform hover:-translate-y-1 mb-4">
                @if($post->image)
                <img src="{{ Storage::url($post->image) }}"
                    alt="{{ $post->title }}"
                    class="w-full object-cover">
                @endif
                <div class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <h3 class="text-sm font-semibold text-white text-center px-2 line-clamp-2">
                        {{ $post->title }}
                    </h3>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <p class="text-gray-500 dark:text-gray-400">This user has no posts yet.</p>
        @endif
    </div>
</x-app-layout>