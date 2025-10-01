<x-app-layout>
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
                    <p class="text-gray-800 dark:text-gray-200">
                        {{ $notification->data['message'] }}
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    {{-- Ja friend request --}}
                    @if(Str::contains($notification->data['message'], 'sent you a friend request'))
                        @php
                            $sender = \App\Models\User::where('name', explode(' sent', $notification->data['message'])[0])->first();
                            $friendship = \App\Models\Friendship::where('user_id', $sender->id)
                                ->where('friend_id', auth()->id())
                                ->first();
                        @endphp

                        @if($friendship && $friendship->status === 'pending')
                            <form action="{{ route('friends.accept', $friendship) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="px-3 py-1 bg-green-600 text-white rounded text-sm hover:bg-green-700 transition">
                                    Accept
                                </button>
                            </form>
                        @endif
                    @endif

                    {{-- Dzēst atsevišķu notifikāciju --}}
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
