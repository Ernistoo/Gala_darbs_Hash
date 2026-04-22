<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6 w-full">
    <div class="flex items-start gap-4">
        <img src="{{ userAvatar($user->profile_photo) }}"
            class="w-20 h-20 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600 shrink-0" />

        <div class="min-w-0">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 flex flex-wrap items-center gap-x-2 gap-y-1">
                <span class="truncate">{{ $user->name }}</span>
                @if(auth()->check() && auth()->id() !== $user->id)
                    @php $areFriends = auth()->user()->allFriends()->contains('id', $user->id); @endphp
                    @if($areFriends)
                        <span class="text-sm font-normal text-green-600 dark:text-green-400 whitespace-nowrap">~ Friends</span>
                    @endif
                @endif
            </h2>
            <p class="text-gray-500 dark:text-gray-400 truncate">{{ '@' . $user->username }}</p>

            <div class="mt-2">
                <x-profile.friend-button :user="$user" />
            </div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 lg:gap-6 w-full lg:w-auto">
        <div class="w-full sm:w-56">
            <x-profile.xp-bar :user="$user" />
        </div>
        <div class="shrink-0">
            <x-profile.actions :user="$user" />
        </div>
    </div>
</div>