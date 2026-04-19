<div id="chat-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4">
        <!-- Backdrop with blur -->
        <div class="fixed inset-0 bg-gray-900/50 dark:bg-black/70 backdrop-blur-sm transition-opacity" onclick="closeChatModal()"></div>

        <!-- Modal panel - larger and more refined -->
        <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-3xl h-[80vh] max-h-[700px] flex flex-col overflow-hidden border border-gray-200 dark:border-gray-700 transform transition-all">

            <!-- Header -->
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 backdrop-blur-sm">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <img id="chat-friend-avatar" src="" class="w-11 h-11 rounded-full object-cover ring-2 ring-purple-500/20" alt="">
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white dark:border-gray-800"></span>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100" id="chat-friend-name"></h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Active now</p>
                    </div>
                </div>
                <button onclick="closeChatModal()" class="p-2 rounded-full text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Messages Container - flex-1 to fill space -->
            <div id="chat-messages" class="flex-1 overflow-y-auto p-5 space-y-4 scroll-smooth bg-gradient-to-b from-gray-50/50 to-white dark:from-gray-900/50 dark:to-gray-800">
                <div class="text-center text-gray-400 dark:text-gray-500 py-8">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    Loading conversation...
                </div>
            </div>

            <!-- Image Preview (appears above input) -->
            <div id="image-preview" class="hidden px-5 py-3 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-start gap-3">
                    <div class="relative">
                        <img id="image-preview-img" src="" class="max-h-24 rounded-lg shadow-sm">
                        <button type="button" id="remove-image-preview" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center shadow-md hover:bg-red-600 transition-colors">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Image ready to send</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Click the ✕ to remove</p>
                    </div>
                </div>
            </div>

            <!-- Input Area -->
            <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                <!-- Image upload button (hidden input + icon) -->
                <div class="flex items-center gap-2 mb-3">
                    <input type="file" id="chat-image-input" accept="image/*" class="hidden">
                    <button type="button" id="attach-image-btn" class="p-2 text-gray-500 hover:text-purple-600 dark:text-gray-400 dark:hover:text-purple-400 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </button>
                </div>

                <!-- Message input row -->
                <div class="flex gap-3">
                    <input type="text" id="chat-message-input" placeholder="Type a message..."
                        class="flex-1 rounded-full border-0 bg-gray-100 dark:bg-gray-700 px-5 py-3 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:outline-none transition-shadow">
                    <button id="send-message-btn"
                        class="px-5 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white rounded-full font-medium shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all transform active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>