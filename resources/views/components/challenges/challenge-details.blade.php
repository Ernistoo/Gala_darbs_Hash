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
    <div id="countdown" 
         class="mt-2 text-sm font-medium text-purple-600 dark:text-purple-300"
         data-deadline="{{ $challenge->deadline->timestamp }}">
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const el = document.getElementById('countdown');
            if (!el) return;

            const deadline = parseInt(el.dataset.deadline) * 1000;

            function tick() {
                const diff = deadline - Date.now();
                if (diff <= 0) {
                    el.textContent = '⏰ Challenge ended';
                    return;
                }
                const days = Math.floor(diff / 86400000);
                const hrs = Math.floor((diff % 86400000) / 3600000);
                const mins = Math.floor((diff % 3600000) / 60000);
                const secs = Math.floor((diff % 60000) / 1000);

                el.textContent = `⏳ Ends in: ${days}d ${hrs}h ${mins}m ${secs}s`;
            }

            tick();
            setInterval(tick, 1000);
        });
    </script>
@endif


</div>