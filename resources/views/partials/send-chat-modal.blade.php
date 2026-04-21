<div id="send-chat-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeSendChatModal()"></div>
        <div class="relative bg-white dark:bg-gray-800 rounded-lg w-full max-w-md">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Send in Chat</h3>
                <button onclick="closeSendChatModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-4 max-h-96 overflow-y-auto" id="friend-list-container">
                <p class="text-center text-gray-500">Loading friends...</p>
            </div>
        </div>
    </div>
</div>

