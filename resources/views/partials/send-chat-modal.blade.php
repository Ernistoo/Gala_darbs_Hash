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

<script>
    let sendItemType = null;
    let sendItemId = null;

    window.openSendChatModal = function(type, id) {
        sendItemType = type;
        sendItemId = id;
        document.getElementById('send-chat-modal').classList.remove('hidden');
        loadFriendsList();
    };

    window.closeSendChatModal = function() {
        document.getElementById('send-chat-modal').classList.add('hidden');
    };

    async function loadFriendsList() {
        const container = document.getElementById('friend-list-container');
        container.innerHTML = '<p class="text-center text-gray-500">Loading friends...</p>';

        try {
            const res = await fetch('/friends/list');
            if (!res.ok) throw new Error('Failed to fetch');
            const friends = await res.json();

            if (friends.length === 0) {
                container.innerHTML = '<p class="text-center text-gray-500">You have no friends yet.</p>';
                return;
            }

            container.innerHTML = friends.map(f => `
            <div class="flex items-center justify-between p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                <div class="flex items-center gap-3">
                    <img src="${f.avatar}" class="w-10 h-10 rounded-full object-cover">
                    <div>
                        <p class="font-medium text-gray-900 dark:text-gray-100">${f.name}</p>
                        <p class="text-sm text-gray-500">@${f.username}</p>
                    </div>
                </div>
                <button onclick="sendItemToFriend(${f.id})" class="px-3 py-1 bg-purple-600 text-white rounded-lg text-sm hover:bg-purple-700">
                    Send
                </button>
            </div>
        `).join('');
        } catch (err) {
            console.error('Failed to load friends:', err);
            container.innerHTML = '<p class="text-center text-red-500">Failed to load friends.</p>';
        }
    }

    async function sendItemToFriend(friendId) {
        try {
            const res = await fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    receiver_id: friendId,
                    message: '',
                    attachment_type: sendItemType,
                    attachment_id: sendItemId
                })
            });
            const data = await res.json();
            if (data.status === 'sent') {
                alert('Sent successfully!');
                closeSendChatModal();
            } else {
                alert('Failed to send.');
            }
        } catch (err) {
            console.error('Send error:', err);
            alert('Failed to send.');
        }
    }
</script>