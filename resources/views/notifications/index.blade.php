<x-app-layout>
    <x-header></x-header>
    <div class="max-w-2xl mx-auto py-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Notifications</h2>

            @if(auth()->user()->notifications->count())
                <form action="{{ route('notifications.markAllRead') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700 transition">
                        Clear All
                    </button>
                </form>
            @endif
        </div>

        @forelse (auth()->user()->notifications as $notification)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-3 flex justify-between items-center">
                <div>
                    @php
                        $sender = isset($notification->data['sender_id'])
                            ? \App\Models\User::find($notification->data['sender_id'])
                            : null;

                        $friendship = null;
                        if ($sender) {
                            $friendship = \App\Models\Friendship::where('user_id', $sender->id)
                                ->where('friend_id', auth()->id())
                                ->first();
                        }
                    @endphp

                    <p class="text-gray-800 dark:text-gray-200">
                        @if(isset($notification->data['url']))
                            <a href="{{ $notification->data['url'] }}" 
                               class="text-purple-600 dark:text-purple-400 hover:underline">
                                {{ $notification->data['message'] }}
                            </a>
                        @else
                            {{ $notification->data['message'] }}
                        @endif

                        @if(isset($notification->data['sender_id']) && !$sender)
                            <span class="text-gray-500 italic">(User no longer exists)</span>
                        @endif
                    </p>

                    <span class="text-xs text-gray-500">
                        {{ $notification->created_at->diffForHumans() }}
                    </span>
                </div>

                <div class="flex items-center gap-2">
                    @if($sender && $friendship && $friendship->status === 'pending')
                        <form action="{{ route('friends.accept', $friendship) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="px-3 py-1 bg-green-600 text-white rounded text-sm hover:bg-green-700 transition">
                                Accept
                            </button>
                        </form>
                    @endif

                    <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-3 py-1 bg-gray-500 text-white rounded text-sm hover:bg-gray-600 transition">
                            Remove
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-500 dark:text-gray-400">No notifications yet.</p>
        @endforelse
    </div>
</x-app-layout>
