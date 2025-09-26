<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h2 class="text-3xl font-bold mb-6 text-center text-purple-600 dark:text-purple-400">
            Leaderboard
        </h2>

        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl shadow-lg overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-purple-600 text-white text-sm uppercase">
                        <th class="px-6 py-3">Rank</th>
                        <th class="px-6 py-3">User</th>
                        <th class="px-6 py-3">XP</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $user)
                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-purple-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-3 font-semibold text-purple-600 dark:text-purple-400">
                                #{{ $index + 1 }}
                            </td>
                            <td class="px-6 py-3 flex items-center gap-3">
                                <img src="{{ $user->profile_photo ? asset('storage/'.$user->profile_photo) : asset('default-avatar.png') }}"
                                    alt="{{ $user->name }}"
                                    class="w-10 h-10 rounded-full border-2 border-purple-400 object-cover">
                                <div>
                                    <p class="font-semibold">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ '@'.$user->username }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-3 font-bold text-gray-800 dark:text-gray-100">
                                {{ $user->xp }} XP
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
