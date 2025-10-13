<div class="flex items-center justify-between mb-6 w-full">
    <div class="flex items-center gap-4">
        <img src="{{ userAvatar($user->profile_photo) }}"
            class="w-20 h-20 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600" />

        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                {{ $user->name }}
                @if(auth()->check() && auth()->id() !== $user->id)
                @php $areFriends = auth()->user()->allFriends()->contains('id', $user->id); @endphp
                @if($areFriends)
                <span class="text-sm font-normal text-green-600 dark:text-green-400">~ Friends</span>
                @endif
                @endif
            </h2>
            <p class="text-gray-500 dark:text-gray-400">{{ '@' . $user->username }}</p>

            <x-profile.friend-button :user="$user" />
        </div>
    </div>

    <div class="flex items-center gap-4">
        <div class="w-56">
            <x-profile.xp-bar :user="$user" />
        </div>
        <x-profile.actions :user="$user" />
    </div>
</div>