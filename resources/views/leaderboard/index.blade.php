<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <div class="text-center mb-8">
            <h2 class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                🏆 Leaderboard
            </h2>

        </div>

        @if(count($users) >= 3)
        <div class="grid grid-cols-3 gap-4 mb-8 mt-20">
            <div class="pt-6">
                <div class="bg-gradient-to-b from-gray-300 to-gray-200 dark:from-gray-600 dark:to-gray-700 rounded-2xl p-4 text-center shadow-lg transform hover:-translate-y-1 transition">
                    <div class="relative -mt-10 mb-3">
                        <img src="{{ userAvatar($users[1]->profile_photo) }}"
                            class="w-20 h-20 rounded-full border-4 border-gray-300 dark:border-gray-500 object-cover mx-auto">
                        <span class="absolute -top-2 left-1/2 -translate-x-1/2 text-3xl">🥈</span>
                    </div>
                    <p class="font-bold text-lg truncate">{{ $users[1]->name }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Level {{ $users[1]->level ?? 1 }}</p>
                    <p class="text-xl font-bold text-gray-800 dark:text-gray-200">{{ $users[1]->xp }} XP</p>
                </div>
            </div>

            <div>
                <div class="bg-gradient-to-b from-yellow-300 to-yellow-200 dark:from-yellow-600 dark:to-yellow-700 rounded-2xl p-4 text-center shadow-xl transform hover:-translate-y-1 transition scale-105">
                    <div class="relative -mt-12 mb-3">
                        <img src="{{ userAvatar($users[0]->profile_photo) }}"
                            class="w-24 h-24 rounded-full border-4 border-yellow-400 object-cover mx-auto">
                        <span class="absolute -top-4 left-1/2 -translate-x-1/2 text-4xl">👑</span>
                    </div>
                    <p class="font-bold text-xl truncate">{{ $users[0]->name }}</p>
                    <p class="text-sm text-gray-700 dark:text-gray-300 mb-2">Level {{ $users[0]->level ?? 1 }}</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $users[0]->xp }} XP</p>
                </div>
            </div>

            <div class="pt-6">
                <div class="bg-gradient-to-b from-orange-300 to-orange-200 dark:from-orange-700 dark:to-orange-800 rounded-2xl p-4 text-center shadow-lg transform hover:-translate-y-1 transition">
                    <div class="relative -mt-10 mb-3">
                        <img src="{{ userAvatar($users[2]->profile_photo) }}"
                            class="w-20 h-20 rounded-full border-4 border-orange-400 object-cover mx-auto">
                        <span class="absolute -top-2 left-1/2 -translate-x-1/2 text-3xl">🥉</span>
                    </div>
                    <p class="font-bold text-lg truncate">{{ $users[2]->name }}</p>
                    <p class="text-sm text-gray-700 dark:text-gray-300 mb-2">Level {{ $users[2]->level ?? 1 }}</p>
                    <p class="text-xl font-bold text-gray-800 dark:text-gray-200">{{ $users[2]->xp }} XP</p>
                </div>
            </div>
        </div>
        @endif

        <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-md rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="font-semibold text-gray-800 dark:text-gray-200">📋 Full Rankings</h3>
            </div>

            <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($users as $index => $user)
    @php $rank = $index + 1; @endphp
    <div class="flex items-center justify-between px-4 sm:px-6 py-4 hover:bg-purple-50 dark:hover:bg-gray-700/50 transition {{ $user->id === auth()->id() ? 'bg-purple-100 dark:bg-purple-900/30 border-l-4 border-l-purple-500' : '' }}">
        <div class="flex items-center gap-3 min-w-0 flex-1">
            <div class="w-6 text-center shrink-0">
                @if($rank === 1)
                    <span class="text-lg">🥇</span>
                @elseif($rank === 2)
                    <span class="text-lg">🥈</span>
                @elseif($rank === 3)
                    <span class="text-lg">🥉</span>
                @else
                    <span class="font-bold text-gray-500 dark:text-gray-400">#{{ $rank }}</span>
                @endif
            </div>

            <a href="{{ route('users.show', $user) }}" class="flex items-center gap-3 min-w-0 group">
                <div class="relative shrink-0">
                    <img src="{{ userAvatar($user->profile_photo) }}"
                         alt="{{ $user->name }}"
                         class="w-10 h-10 sm:w-11 sm:h-11 rounded-full border-2 {{ $rank <= 3 ? 'border-purple-400' : 'border-gray-300 dark:border-gray-600' }} object-cover group-hover:border-purple-500 transition">
                    @if($user->id === auth()->id())
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white dark:border-gray-800"></span>
                    @endif
                </div>
                <div class="min-w-0">
                    <p class="font-semibold text-sm sm:text-base text-gray-800 dark:text-gray-200 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition truncate">
                        {{ $user->name }}
                        @if($user->id === auth()->id())
                            <span class="ml-1 text-xs bg-purple-600 text-white px-1.5 py-0.5 rounded-full">You</span>
                        @endif
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ '@'.$user->username }}</p>
                </div>
            </a>
        </div>

        <div class="flex items-center gap-4 sm:gap-6 shrink-0">
            <div class="text-right">
                <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">Level</p>
                <p class="font-semibold text-sm sm:text-base text-purple-600 dark:text-purple-400">{{ $user->level ?? 1 }}</p>
            </div>
            <div class="text-right min-w-[60px] sm:min-w-[80px]">
                <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">XP</p>
                <p class="font-bold text-sm sm:text-base text-gray-800 dark:text-gray-100">{{ number_format($user->xp) }}</p>
            </div>
        </div>
    </div>
@endforeach
            </div>
        </div>

        @if($users instanceof \Illuminate\Pagination\LengthAwarePaginator && $users->hasPages())
        <div class="mt-8">
            {{ $users->links() }}
        </div>
        @endif

        <div class="mt-8 grid grid-cols-3 gap-4">
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-4 text-white text-center shadow-lg">
                <p class="text-3xl font-bold">{{ $users->first()?->xp ?? 0 }}</p>
                <p class="text-sm opacity-90">Highest XP</p>
            </div>
            <div class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl p-4 text-white text-center shadow-lg">
                <p class="text-3xl font-bold">{{ $totalUsers ?? count($users) }}</p>
                <p class="text-sm opacity-90">Total People</p>
            </div>
            <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl p-4 text-white text-center shadow-lg">
                <p class="text-3xl font-bold">{{ $userRank ?? '#' }}</p>
                <p class="text-sm opacity-90">Your Rank</p>
            </div>
        </div>
    </div>
</x-app-layout>