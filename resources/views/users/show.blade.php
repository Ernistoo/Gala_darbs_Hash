<x-app-layout>
<x-slot name="header"></x-slot>
    <div class="max-w-4xl mx-auto p-6">

        <div class="inline-flex items-center gap-4 mb-6 w-full">
            <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('default-avatar.png') }}"
                 class="w-20 h-20 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600" />

            <div class="flex-1">
                <div class="flex items-center gap-3">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $user->name }}
                        </h2>
                        <p class="text-gray-500 dark:text-gray-400">
                            {{ '@' . $user->username }}
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        @foreach($user->badges as $badge)
                            <img src="{{ asset('images/' . $badge->image) }}" alt="{{ $badge->name }}" title="{{ $badge->description }}"
                                 class="w-8 h-8 rounded-full border-2 border-gray-300 dark:border-gray-600">
                        @endforeach
                    </div>
                </div>

                {{-- Draudzības pogas --}}
                @if(auth()->check() && auth()->id() !== $user->id)
                    @php
                        $alreadyFriend = auth()->user()->friends->contains($user->id);
                        $pending = \App\Models\Friendship::where('user_id', auth()->id())
                                    ->where('friend_id', $user->id)
                                    ->where('status', 'pending')
                                    ->exists();
                    @endphp

                    <div class="mt-3">
                        @if($alreadyFriend)
                            <span class="px-4 py-2 bg-green-500 text-white rounded">Friends ✓</span>
                        @elseif($pending)
                            <span class="px-4 py-2 bg-yellow-500 text-white rounded">Request sent…</span>
                        @else
                        <form action="{{ route('friends.send', $user) }}" method="POST">
    @csrf
    <button type="submit" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded">
        Add Friend
    </button>
</form>
                        @endif
                    </div>
                @endif
            </div>

            @can('delete', $user)
            <div x-data="{ open: false, deleteUserModal: false }" class="relative">
                <button @click="open = !open" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                    ⋮
                </button>
                <div x-show="open" @click.away="open = false"
                     class="absolute right-0 mt-2 w-32 bg-white dark:bg-gray-700 shadow rounded border dark:border-gray-600 z-10">
                    <button type="button" @click="deleteUserModal = true; open = false"
                            class="block w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                        Dzēst lietotāju
                    </button>
                </div>

                <div x-show="deleteUserModal"
                     class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                    <div @click.away="deleteUserModal = false"
                        class="bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 p-6 rounded shadow w-96">
                        <h2 class="text-xl font-bold mb-4 text-red-600">Dzēst lietotāju</h2>
                        <p class="mb-4 text-gray-800 dark:text-gray-200">
                            Vai tiešām vēlies neatgriezeniski dzēst lietotāju <b>{{ $user->name }}</b>?
                        </p>
                        <div class="flex justify-end gap-2">
                            <button type="button" @click="deleteUserModal = false"
                                class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded">
                                Atcelt
                            </button>
                            <form action="{{ route('users.destroy', $user) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">
                                    Dzēst
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endcan
        </div>

        {{-- Draugu saraksts --}}
        <h3 class="text-lg font-semibold mb-3 text-gray-800 dark:text-gray-200">Friends</h3>
        <div class="flex gap-3 mb-6">
            @forelse($user->friends as $friend)
                <a href="{{ route('users.show', $friend) }}">
                    <img src="{{ $friend->profile_photo ? asset('storage/' . $friend->profile_photo) : asset('default-avatar.png') }}"
                         class="w-12 h-12 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600"
                         title="{{ $friend->name }}">
                </a>
            @empty
                <p class="text-gray-500 dark:text-gray-400">No friends yet.</p>
            @endforelse
        </div>

        <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">Posts</h3>

        @if($posts->count())
        <div class="columns-2 sm:columns-3 md:columns-4 lg:columns-5 gap-4 space-y-4">
            @foreach($posts as $post)
                <a href="{{ route('posts.show', $post) }}"
                   class="break-inside-avoid block bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-lg overflow-hidden transition transform hover:-translate-y-1 mb-4">
                    @if($post->image)
                        <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="w-full object-cover">
                    @endif

                    <div class="p-4">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100 line-clamp-2">
                            {{ $post->title }}
                        </h4>
                        <p class="text-gray-600 dark:text-gray-400">{{ Str::limit($post->content, 100) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
        @else
            <p class="text-gray-500 dark:text-gray-400">Šim lietotājam vēl nav postu.</p>
        @endif
    </div>
</x-app-layout>
