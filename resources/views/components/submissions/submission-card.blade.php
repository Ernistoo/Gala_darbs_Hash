<div class="break-inside-avoid bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-lg overflow-hidden transition transform hover:-translate-y-1 relative mb-4">

    <img src="{{ asset('storage/' . $submission->image) }}" alt="submission" class="w-full object-cover rounded-t-xl">

    <div class="p-4">
        <div class="flex items-center justify-between mb-2">

            <a href="{{ userAvatar($user->profile_photo) }}" class="flex items-center gap-2">
                <img src="{{ $submission->user->profile_photo ? asset('storage/' . $submission->user->profile_photo) : asset('default-avatar.png') }}"
                    class="w-8 h-8 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ $submission->user->name }}
                </span>
            </a>


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


        @if($submission->title ?? false)
        <h4 class="font-semibold text-gray-800 dark:text-gray-200 text-sm line-clamp-2">
            {{ $submission->title }}
        </h4>
        @endif
    </div>
</div>