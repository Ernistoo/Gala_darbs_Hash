<div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
    <h3 class="text-lg font-semibold mb-4">Submit Your Entry</h3>

    <form action="{{ route('submissions.store', $challenge) }}" method="POST" enctype="multipart/form-data" id="submission-form">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Upload your image
            </label>

            <x-challenges.upload />

        </div>

        <button type="submit" class="w-full px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition">
            {{ __('Submit Entry') }}
            <svg class="w-5 h-5 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
            </svg>
        </button>
    </form>
</div>
