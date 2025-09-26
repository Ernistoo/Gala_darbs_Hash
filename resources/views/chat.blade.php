<x-app-layout>
    <div class="max-w-2xl mx-auto p-6">
        <h2 class="text-xl font-bold mb-4">Chat</h2>

        <div id="messages" class="border rounded-lg p-4 h-64 overflow-y-auto bg-white dark:bg-gray-800 mb-4">
            <p class="text-gray-400">No messages yet...</p>
        </div>

        <form id="chat-form" class="flex gap-2">
            @csrf
            <input id="message-input" name="message" type="text" placeholder="Type your message..."
                   class="flex-1 border rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-white">
            <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                Send
            </button>
        </form>
    </div>

    <script>
        const form = document.getElementById('chat-form');
        const input = document.getElementById('message-input');
        const messages = document.getElementById('messages');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const response = await fetch("{{ route('chat.send') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ message: input.value })
            });

            const data = await response.json();

            // Pievienojam jaunu ziņu chat logam
            const p = document.createElement('p');
            p.innerHTML = `<strong>${data.user}:</strong> ${data.message}`;
            messages.appendChild(p);

            input.value = '';
        });
    </script>
</x-app-layout>
