<form action="{{ route('comments.store', $post) }}" method="POST" class="mb-6 relative" id="main-comment-form">
    @csrf
    <div class="flex gap-3">
        <img src="{{ userAvatar(auth()->user()->profile_photo) }}" class="w-10 h-10 rounded-full object-cover" alt="{{ auth()->user()->name }}">
        <div class="flex-1">
            <textarea name="content" id="comment-textarea"
                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-3 
           bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 
           focus:outline-none focus:ring-2 focus:ring-purple-500 transition"
                rows="2"
                placeholder="Write a comment..."
                autocomplete="off"></textarea>

            <div id="mention-dropdown"
                class="absolute left-0 mt-1 w-64 bg-white dark:bg-gray-700 border border-gray-300 
            dark:border-gray-600 rounded-lg shadow-lg hidden z-50"></div>

            <button type="submit"
                class="mt-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white 
                           rounded-lg text-sm transition">
                Post Comment
            </button>
        </div>
    </div>
</form>