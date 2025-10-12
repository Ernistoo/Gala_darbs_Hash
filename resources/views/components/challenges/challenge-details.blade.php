<div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl shadow-lg p-6 mb-6 border border-gray-200 dark:border-gray-700">
    <div class="flex items-start justify-between mb-4">
        <div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 dark:bg-purple-900/40 text-purple-800 dark:text-purple-200">
                {{ $challenge->category }}
            </span>
            <span class="ml-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-200">
                +50 XP
            </span>
        </div>
        <div class="text-sm text-gray-500 dark:text-gray-400">
            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
            </svg>
            {{ $challenge->deadline ? 'Deadline: ' . $challenge->deadline->format('M d, Y H:i') : 'No deadline' }}
        </div>
    </div>

    @if($challenge->deadline)
    <div id="countdown" class="mt-2 text-sm font-medium text-purple-600 dark:text-purple-300"></div>
    <script>
        const el = document.getElementById('countdown');
        const deadline = {
            {
                $challenge - > deadline - > timestamp
            }
        }* 1000;

        function tick() {
            const d = deadline - Date.now();
            if (d <= 0) {
                el.textContent = '⏰ Challenge ended';
                return;
            }
            const days = Math.floor(d / 86400000),
                hrs = Math.floor(d % 86400000 / 3600000),
                mins = Math.floor(d % 3600000 / 60000),
                secs = Math.floor(d % 60000 / 1000);
            el.textContent = `Ends in: ${days}d ${hrs}h ${mins}m ${secs}s`;
        }
        tick();
        setInterval(tick, 1000);
    </script>
    @endif

    <p class="text-gray-600 dark:text-gray-400 mb-6">{{ $challenge->description }}</p>

    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
        </svg>
        <span>{{ $challenge->participants_count }} people have submitted</span>
    </div>

    @if($challenge->awarded_at && $challenge->winnerSubmission)
    <div class="mt-3 inline-flex items-center px-3 py-1 rounded-full text-sm bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-200">
        🏆 Winner: {{ $challenge->winnerSubmission?->user?->name ?? 'Unknown' }} (+50 XP)
    </div>
    @endif

</div>