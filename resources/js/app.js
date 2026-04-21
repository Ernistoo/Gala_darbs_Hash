import "./bootstrap";
import Alpine from "alpinejs";
import "cropperjs/dist/cropper.css";
import Cropper from "cropperjs";

window.Alpine = Alpine;

function initImageUpload(area) {
    const fileInput = area.querySelector('input[type="file"]');
    const dragContent = area.querySelector("#drag-content");
    const previewContainer = area.querySelector("#preview-container");
    const previewImage = area.querySelector("#preview-image");
    const removeButton = area.querySelector("#remove-image");

    if (!fileInput || !dragContent || !previewContainer) return;

    const handleFiles = (files) => {
        if (files.length === 0) return;
        const file = files[0];
        if (!file.type.match("image.*")) return;

        const reader = new FileReader();
        reader.onload = (e) => {
            previewImage.src = e.target.result;
            dragContent.classList.add("hidden");
            previewContainer.classList.remove("hidden");
        };
        reader.readAsDataURL(file);
    };

    const removeImage = () => {
        fileInput.value = "";
        previewImage.src = "";
        previewContainer.classList.add("hidden");
        dragContent.classList.remove("hidden");
    };

    ["dragenter", "dragover"].forEach((eventName) => {
        area.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            area.classList.add("border-purple-500");
        });
    });

    ["dragleave", "drop"].forEach((eventName) => {
        area.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            area.classList.remove("border-purple-500");
        });
    });

    area.addEventListener("drop", (e) => handleFiles(e.dataTransfer.files));
    fileInput.addEventListener("change", () => handleFiles(fileInput.files));
    removeButton?.addEventListener("click", removeImage);

    area.addEventListener("click", (e) => {
        if (
            e.target.closest(
                "input, button, select, textarea, a, label, #remove-image",
            )
        ) {
            return;
        }
        fileInput.click();
    });
}
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".drag-area").forEach((area) => {
        initImageUpload(area);
    });
});

Alpine.data("carousel", () => ({
    index: 0,
    items: [],
    init() {
        this.items = this.$el.querySelectorAll("div > div");
    },
    next() {
        if (this.index < this.items.length - 1) this.index++;
    },
    prev() {
        if (this.index > 0) this.index--;
    },
}));

Alpine.data("dropdown", () => ({
    open: false,
    toggle() {
        this.open = !this.open;
    },
}));

Alpine.start();

document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("theme-toggle");
    const darkIcon = document.getElementById("theme-toggle-dark-icon");
    const lightIcon = document.getElementById("theme-toggle-light-icon");

    if (!btn || !darkIcon || !lightIcon) return;

    const isDark =
        localStorage.getItem("color-theme") === "dark" ||
        (!("color-theme" in localStorage) &&
            window.matchMedia("(prefers-color-scheme: dark)").matches);

    document.documentElement.classList.toggle("dark", isDark);
    darkIcon.classList.toggle("hidden", isDark);
    lightIcon.classList.toggle("hidden", !isDark);

    btn.addEventListener("click", () => {
        const darkMode = document.documentElement.classList.toggle("dark");
        localStorage.setItem("color-theme", darkMode ? "dark" : "light");
        darkIcon.classList.toggle("hidden");
        lightIcon.classList.toggle("hidden");
    });
});

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".upvote-btn").forEach((btn) => {
        btn.addEventListener("click", async function () {
            const submissionId = this.dataset.submissionId;
            const icon = this.querySelector(".upvote-icon");
            const countEl = this.nextElementSibling;
            const token = document.querySelector(
                'meta[name="csrf-token"]',
            ).content;

            try {
                const res = await fetch(`/submissions/${submissionId}/vote`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": token,
                        Accept: "application/json",
                        "Content-Type": "application/json",
                    },
                });
                if (!res.ok) return;
                const data = await res.json();

                icon.classList.toggle(
                    "text-green-500",
                    data.status === "upvoted",
                );
                countEl.textContent = data.votes_count;
            } catch (err) {
                console.error(err);
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".like-btn").forEach((btn) => {
        btn.addEventListener("click", async function (e) {
            e.preventDefault();

            const postId = this.dataset.postId;
            const isLiked = this.dataset.liked === "true";
            const icon = this.querySelector(".like-icon");
            const countEl = this.querySelector(".like-count");
            const token = document.querySelector(
                'meta[name="csrf-token"]',
            ).content;

            this.disabled = true;
            try {
                const res = await fetch(
                    isLiked
                        ? `/posts/${postId}/unlike`
                        : `/posts/${postId}/like`,
                    {
                        method: isLiked ? "DELETE" : "POST",
                        headers: {
                            "X-CSRF-TOKEN": token,
                            Accept: "application/json",
                        },
                    },
                );
                if (!res.ok) return;
                const data = await res.json();

                this.dataset.liked = data.liked;
                countEl.textContent = data.likes_count;
                icon.classList.toggle("text-red-600", data.liked);
            } catch (err) {
                console.error("Like error:", err);
            } finally {
                this.disabled = false;
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("profile_photo");
    const preview = document.getElementById("profile-photo-preview");
    const hiddenInput = document.getElementById("profile_photo_cropped");
    const modal = document.getElementById("cropper-modal");
    const cropperImage = document.getElementById("cropper-image");
    const selectBtn = document.getElementById("select-photo-btn");
    const closeBtn = document.getElementById("close-cropper");
    const cropBtn = document.getElementById("crop-image-btn");

    let cropper;
    if (!input) return;

    selectBtn?.addEventListener("click", () => input.click());
    input.addEventListener("change", (e) => {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (ev) => {
            cropperImage.src = ev.target.result;
            modal.classList.remove("hidden");
            cropper && cropper.destroy();
            cropper = new Cropper(cropperImage, {
                aspectRatio: 1,
                viewMode: 1,
                autoCropArea: 1,
            });
        };
        reader.readAsDataURL(file);
    });
    closeBtn?.addEventListener("click", () => {
        modal.classList.add("hidden");
        cropper?.destroy();
    });
    cropBtn?.addEventListener("click", () => {
        if (!cropper) return;
        const canvas = cropper.getCroppedCanvas({ width: 400, height: 400 });
        preview.src = canvas.toDataURL("image/png");
        hiddenInput.value = canvas.toDataURL("image/png");
        modal.classList.add("hidden");
        cropper.destroy();
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const textarea = document.querySelector('textarea[name="content"]');
    const dropdown = document.getElementById("mention-dropdown");
    if (!textarea || !dropdown) return;

    textarea.addEventListener("keyup", async (e) => {
        const text = textarea.value;
        const cursor = textarea.selectionStart;
        const match = text.substring(0, cursor).match(/@(\w*)$/);
        if (!match) return dropdown.classList.add("hidden");

        const query = match[1];
        if (!query) return dropdown.classList.add("hidden");

        try {
            const res = await fetch(
                `/mentions/search?q=${encodeURIComponent(query)}`,
            );
            const users = await res.json();
            dropdown.innerHTML = "";
            users.forEach((u) => {
                const el = document.createElement("div");
                el.className =
                    "mention-item px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer flex items-center gap-2";
                el.innerHTML = `<img src="${u.profile_photo ? "/storage/" + u.profile_photo : "/default-avatar.png"}" class="w-6 h-6 rounded-full"><span>@${u.username}</span>`;
                el.addEventListener("click", () => {
                    textarea.value =
                        text
                            .substring(0, cursor)
                            .replace(/@\w*$/, `@${u.username} `) +
                        text.substring(cursor);
                    dropdown.classList.add("hidden");
                });
                dropdown.appendChild(el);
            });
            dropdown.classList.toggle("hidden", users.length === 0);
        } catch (err) {
            console.error(err);
        }
    });
});

const currentUserId = document.querySelector('meta[name="user-id"]')?.content;
let currentFriendId = null;
let pendingImageFile = null;

window.openChatModal = function (friendId, friendName, friendAvatar) {
    currentFriendId = friendId;
    document.getElementById("chat-friend-name").textContent = friendName;
    document.getElementById("chat-friend-avatar").src = friendAvatar;
    document.getElementById("chat-modal").classList.remove("hidden");
    document.getElementById("chat-message-input").focus();

    pendingImageFile = null;
    document.getElementById("image-preview").classList.add("hidden");
    document.getElementById("chat-image-input").value = "";

    loadMessages(friendId);

    if (window.Echo && currentUserId) {
        window.Echo.private(`user.${currentUserId}`).listen(
            "MessageSent",
            (e) => {
                const msg = e.message;
                if (
                    msg.receiver_id == currentUserId &&
                    currentFriendId != msg.sender_id
                ) {
                    showMessageToast(msg);
                }
                if (
                    msg.sender_id == currentFriendId ||
                    msg.receiver_id == currentFriendId
                ) {
                    appendMessage(msg, msg.sender_id == currentUserId);
                }
            },
        );
    }
};

window.closeChatModal = function () {
    document.getElementById("chat-modal").classList.add("hidden");
    currentFriendId = null;
    pendingImageFile = null;
    document.getElementById("image-preview").classList.add("hidden");
};

async function loadMessages(friendId) {
    const container = document.getElementById("chat-messages");
    container.innerHTML =
        '<div class="text-center text-gray-500 dark:text-gray-400 py-8">Loading...</div>';
    try {
        const response = await fetch(`/chat/${friendId}`);
        const data = await response.json();
        container.innerHTML = "";
        if (data.messages.length === 0) {
            container.innerHTML =
                '<div class="text-center text-gray-500 dark:text-gray-400 py-8">No messages yet. Say hello!</div>';
        } else {
            data.messages.forEach((msg) => appendMessage(msg, msg.is_mine));
        }
        scrollToBottom();
    } catch (error) {
        console.error("Failed to load messages:", error);
        container.innerHTML =
            '<div class="text-center text-red-500 py-8">Failed to load messages</div>';
    }
}

function appendMessage(message, isMine) {
    const container = document.getElementById("chat-messages");
    // Remove placeholder
    if (
        container.children.length === 1 &&
        container.children[0].classList.contains("text-center")
    ) {
        container.innerHTML = "";
    }

    const messageDiv = document.createElement("div");
    messageDiv.className = `flex ${isMine ? "justify-end" : "justify-start"} animate-fade-in-up`;

    const bubble = document.createElement("div");
    bubble.className = `max-w-[75%] px-4 py-3 rounded-2xl shadow-sm ${
        isMine
            ? "bg-gradient-to-br from-purple-600 to-purple-700 text-white rounded-br-md"
            : "bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-bl-md border border-gray-200 dark:border-gray-600"
    }`;

    let content = "";

    if (message.message) {
        content += `<p class="text-sm leading-relaxed break-words">${escapeHtml(message.message)}</p>`;
    }

    if (message.attachment_type === "image" && message.attachment_data) {
        content += `
            <a href="${message.attachment_data.url}" target="_blank" class="block mt-2">
                <img src="${message.attachment_data.url}" class="rounded-lg max-w-full max-h-64 object-cover shadow-sm">
            </a>
        `;
    }

    if (message.attachment_type === "post" && message.attachment_data) {
        const att = message.attachment_data;
        content += `
            <a href="${att.url}" target="_blank" class="block mt-2 group">
                <div class="rounded-xl overflow-hidden border-2 ${isMine ? "border-purple-400/50" : "border-gray-200 dark:border-gray-600"} shadow-md transition-transform group-hover:scale-[1.02]">
                    <img src="${att.image || "/images/placeholder.png"}" class="w-full h-36 object-cover">
                    <div class="p-3 ${isMine ? "bg-purple-800/50" : "bg-gray-50 dark:bg-gray-800"}">
                        <p class="font-semibold text-sm truncate ${isMine ? "text-white" : "text-gray-900 dark:text-gray-100"}">${att.title}</p>
                        <p class="text-xs ${isMine ? "text-purple-200" : "text-gray-500 dark:text-gray-400"} mt-1">Tap to view post</p>
                    </div>
                </div>
            </a>
        `;
    }

    content += `<span class="text-xs ${isMine ? "text-purple-200" : "text-gray-400 dark:text-gray-500"} block mt-1.5 text-right">${message.created_at}</span>`;

    bubble.innerHTML = content;
    messageDiv.appendChild(bubble);
    container.appendChild(messageDiv);
    scrollToBottom();
}

function escapeHtml(text) {
    const div = document.createElement("div");
    div.textContent = text;
    return div.innerHTML;
}

function scrollToBottom() {
    const container = document.getElementById("chat-messages");
    container.scrollTop = container.scrollHeight;
}

async function sendMessage() {
    const input = document.getElementById("chat-message-input");
    const message = input.value.trim();

    if ((!message && !pendingImageFile) || !currentFriendId) return;

    input.disabled = true;
    document.getElementById("send-message-btn").disabled = true;

    const formData = new FormData();
    formData.append("receiver_id", currentFriendId);
    formData.append("message", message || "");
    if (pendingImageFile) {
        formData.append("attachment", pendingImageFile);
    }

    try {
        const response = await fetch("/chat/send", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
                Accept: "application/json",
            },
            body: formData,
        });

        const data = await response.json();
        if (data.status === "sent") {
            appendMessage(data.message, true);
            input.value = "";
            pendingImageFile = null;
            document.getElementById("image-preview").classList.add("hidden");
            document.getElementById("chat-image-input").value = "";
        }
    } catch (error) {
        console.error("Failed to send message:", error);
        alert("Failed to send message. Please try again.");
    } finally {
        input.disabled = false;
        document.getElementById("send-message-btn").disabled = false;
        input.focus();
    }
}

function showMessageToast(message) {
    const toast = document.createElement("div");
    toast.className =
        "fixed bottom-4 right-4 bg-white dark:bg-gray-800 border border-purple-500 rounded-lg shadow-lg p-4 flex items-center gap-3 z-50 transition-opacity";
    toast.innerHTML = `
        <img src="${message.sender.profile_photo ? "/storage/" + message.sender.profile_photo : "/default-avatar.png"}" 
             class="w-10 h-10 rounded-full border-2 border-purple-500">
        <div>
            <p class="font-semibold text-gray-900 dark:text-gray-100">${message.sender.name}</p>
            <p class="text-sm text-gray-600 dark:text-gray-400">${escapeHtml(message.message)}</p>
        </div>
        <button class="ml-4 text-gray-400 hover:text-gray-600" onclick="this.parentElement.remove()">✕</button>
    `;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 5000);
}

document.addEventListener("DOMContentLoaded", function () {
    // Send message
    const sendBtn = document.getElementById("send-message-btn");
    if (sendBtn) sendBtn.addEventListener("click", sendMessage);

    const msgInput = document.getElementById("chat-message-input");
    if (msgInput) {
        msgInput.addEventListener("keypress", function (e) {
            if (e.key === "Enter") {
                e.preventDefault();
                sendMessage();
            }
        });
    }

    const modal = document.getElementById("chat-modal");
    if (modal) {
        modal.addEventListener("click", function (e) {
            if (e.target === modal) closeChatModal();
        });
    }

    document.addEventListener("click", function (e) {
        const chatBtn = e.target.closest(".chat-btn");
        if (chatBtn) {
            const friendId = chatBtn.dataset.chatFriendId;
            const friendName = chatBtn.dataset.chatFriendName;
            const friendAvatar = chatBtn.dataset.chatFriendAvatar;
            if (friendId)
                window.openChatModal(friendId, friendName, friendAvatar);
        }
    });

    const imageInput = document.getElementById("chat-image-input");
    const attachImageBtn = document.getElementById("attach-image-btn");
    if (attachImageBtn && imageInput) {
        attachImageBtn.addEventListener("click", () => imageInput.click());
        imageInput.addEventListener("change", function (e) {
            const file = e.target.files[0];
            if (file) {
                pendingImageFile = file;
                const reader = new FileReader();
                reader.onload = (ev) => {
                    document.getElementById("image-preview-img").src =
                        ev.target.result;
                    document
                        .getElementById("image-preview")
                        .classList.remove("hidden");
                };
                reader.readAsDataURL(file);
            }
        });
    }

    const removePreviewBtn = document.getElementById("remove-image-preview");
    if (removePreviewBtn) {
        removePreviewBtn.addEventListener("click", function () {
            pendingImageFile = null;
            document.getElementById("image-preview").classList.add("hidden");
            document.getElementById("chat-image-input").value = "";
        });
    }
    window.openLightbox = function (imageSrc) {
        const modal = document.getElementById("lightbox-modal");
        const img = document.getElementById("lightbox-image");
        img.src = imageSrc;
        modal.classList.remove("hidden");
        document.body.style.overflow = "hidden";
    };

    window.closeLightbox = function () {
        const modal = document.getElementById("lightbox-modal");
        modal.classList.add("hidden");
        document.body.style.overflow = "";
    };

    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
            closeLightbox();
        }
    });

    document.addEventListener("DOMContentLoaded", () => {
        const el = document.getElementById("countdown");
        if (!el) return;

        const deadline = parseInt(el.dataset.deadline) * 1000;

        function tick() {
            const diff = deadline - Date.now();
            if (diff <= 0) {
                el.textContent = "⏰ Challenge ended";
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

    let sendItemType = null;
    let sendItemId = null;

    window.openSendChatModal = function (type, id) {
        sendItemType = type;
        sendItemId = id;
        document.getElementById("send-chat-modal").classList.remove("hidden");
        loadFriendsList();
    };

    window.closeSendChatModal = function () {
        document.getElementById("send-chat-modal").classList.add("hidden");
    };

    async function loadFriendsList() {
        const container = document.getElementById("friend-list-container");
        container.innerHTML =
            '<p class="text-center text-gray-500">Loading friends...</p>';

        try {
            const res = await fetch("/friends/list");
            if (!res.ok) throw new Error("Failed to fetch");
            const friends = await res.json();

            if (friends.length === 0) {
                container.innerHTML =
                    '<p class="text-center text-gray-500">You have no friends yet.</p>';
                return;
            }

            container.innerHTML = friends
                .map(
                    (f) => `
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
        `,
                )
                .join("");
        } catch (err) {
            console.error("Failed to load friends:", err);
            container.innerHTML =
                '<p class="text-center text-red-500">Failed to load friends.</p>';
        }
    }

    async function sendItemToFriend(friendId) {
        try {
            const res = await fetch("/chat/send", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                    Accept: "application/json",
                },
                body: JSON.stringify({
                    receiver_id: friendId,
                    message: "",
                    attachment_type: sendItemType,
                    attachment_id: sendItemId,
                }),
            });
            const data = await res.json();
            if (data.status === "sent") {
                alert("Sent successfully!");
                closeSendChatModal();
            } else {
                alert("Failed to send.");
            }
        } catch (err) {
            console.error("Send error:", err);
            alert("Failed to send.");
        }
    }
});
