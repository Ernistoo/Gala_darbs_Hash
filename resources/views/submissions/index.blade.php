<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <h2 class="text-2xl font-bold mb-6">Iesniegumi uzdevumam: {{ $challenge->title }}</h2>

        <!-- Filter dropdown -->
        <div class="mb-6">
            <form method="GET" action="{{ route('submissions.index', $challenge) }}">
                <select
                    name="sort"
                    onchange="this.form.submit()"
                    class="bg-transparent dark:bg-black border-2 border-purple-500 
           text-gray-900 dark:text-gray-200
           rounded-lg px-3 py-2 w-auto min-w-[180px]
           focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-purple-500
           transition-colors duration-300 ease-in-out">

                    <option value="" class="text-gray-900 dark:text-gray-200">Default</option>
                    <option value="most_voted"
                        class="text-gray-900 dark:text-gray-200"
                        {{ request('sort') == 'most_voted' ? 'selected' : '' }}>
                        Visvairāk balsu
                    </option>
                    <option value="least_voted"
                        class="text-gray-900 dark:text-gray-200"
                        {{ request('sort') == 'least_voted' ? 'selected' : '' }}>
                        Vismazāk balsu
                    </option>
                    <option value="latest"
                        class="text-gray-900 dark:text-gray-200"
                        {{ request('sort') == 'latest' ? 'selected' : '' }}>
                        Jaunākie
                    </option>
                </select>

            </form>
        </div>

        @if($submissions->count())
        <div class="columns-2 sm:columns-3 md:columns-4 lg:columns-5 gap-4 space-y-4">
            @foreach($submissions as $submission)
            <div class="break-inside-avoid bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-lg overflow-hidden transition transform hover:-translate-y-1 relative mb-4">

                <!-- Submission Image -->
                <img src="{{ asset('storage/' . $submission->image) }}" alt="submission" class="w-full object-cover rounded-t-xl">

                <div class="p-4">
                    <!-- Author + Upvote -->
                    <div class="flex items-center justify-between mb-2">
                        <!-- Profile clickable -->
                        <a href="{{ route('users.show', $submission->user) }}" class="flex items-center gap-2">
                            <img src="{{ $submission->user->profile_photo ? asset('storage/' . $submission->user->profile_photo) : asset('default-avatar.png') }}"
                                class="w-8 h-8 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ $submission->user->name }}
                            </span>
                        </a>

                        <!-- Upvote -->
                        <div class="flex items-center gap-1">
                            <button type="button"
                                class="upvote-btn focus:outline-none"
                                data-submission-id="{{ $submission->id }}">
                                <img src="{{ asset('images/upvote.svg') }}"
                                    alt="Upvote"
                                    class="w-6 h-6 upvote-icon {{ $submission->hasUpvoted(auth()->user()) ? 'text-green-500' : '' }}">
                            </button>
                            <span class="text-sm text-gray-700 dark:text-gray-300 upvote-count">
                                {{ $submission->votes()->count() }}
                            </span>
                        </div>
                    </div>

                    <!-- Optional Caption / Title -->
                    @if($submission->title ?? false)
                    <h4 class="font-semibold text-gray-800 dark:text-gray-200 text-sm line-clamp-2">
                        {{ $submission->title }}
                    </h4>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500 dark:text-gray-400">Vēl nav iesniegumu.</p>
        @endif
    </div>

    <!-- AJAX Upvote Script -->
    <script>
        document.querySelectorAll('.upvote-btn').forEach(btn => {
            btn.addEventListener('click', async function() {
                const submissionId = this.dataset.submissionId;
                const icon = this.querySelector('.upvote-icon');
                const countEl = this.nextElementSibling;

                const token = document.querySelector('meta[name="csrf-token"]').content;

                const response = await fetch(`/submissions/${submissionId}/vote`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                });

                const data = await response.json();

                if (data.status === 'upvoted') {
                    icon.classList.add('text-green-500');
                } else {
                    icon.classList.remove('text-green-500');
                }

                countEl.textContent = data.votes_count;

                // Animācija
                icon.classList.add('animate-upvote');
                setTimeout(() => icon.classList.remove('animate-upvote'), 500);
            });
        });
    </script>

    <style>
        @keyframes upvote {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-6px) scale(1.2);
            }

            100% {
                transform: translateY(0);
            }
        }

        .animate-upvote {
            animation: upvote 0.5s ease-in-out;
        }
    </style>
</x-app-layout>