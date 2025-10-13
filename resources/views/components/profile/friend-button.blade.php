@if(auth()->check() && auth()->id() !== $user->id)
@php
$alreadyFriend = auth()->user()->allFriends()->contains('id', $user->id);
$pending = \App\Models\Friendship::where(function($q) use ($user) {
$q->where('user_id', auth()->id())->where('friend_id', $user->id);
})->orWhere(function($q) use ($user) {
$q->where('user_id', $user->id)->where('friend_id', auth()->id());
})->where('status', 'pending')->exists();
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