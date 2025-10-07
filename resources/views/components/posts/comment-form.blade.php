<form action="{{ route('comments.store', $post) }}" method="POST" class="mb-6 relative">
    @csrf
    <div class="flex gap-3">
        <img src="{{ auth()->user()->profile_photo ? asset('storage/'.auth()->user()->profile_photo) : asset('default-avatar.png') }}"
             class="w-10 h-10 rounded-full object-cover">

        <div class="flex-1">
            <textarea id="comment-textarea"
                      name="content"
                      class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-3 
                             bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 
                             focus:outline-none focus:ring-2 focus:ring-purple-500 transition"
                      rows="2"
                      placeholder="Write a comment... use @username to mention someone"
                      autocomplete="off"></textarea>

            <div id="mention-dropdown" 
                 class="absolute left-14 mt-1 w-64 bg-white dark:bg-gray-700 border border-gray-300 
                        dark:border-gray-600 rounded-lg shadow-lg hidden z-50">   
            </div>

            <button type="submit"
                    class="mt-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white 
                           rounded-lg text-sm transition">
                Post Comment
            </button>
        </div>
    </div>
</form>
