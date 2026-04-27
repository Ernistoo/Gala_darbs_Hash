import "./bootstrap";
import Alpine from "alpinejs";
import "cropperjs/dist/cropper.css";
import Cropper from "cropperjs";

window.Alpine = Alpine;

// Drag and drop image upload
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

// Theme toggle
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

// Upvotes
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

// Likes
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

// Cropper.js
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

// Mentions
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

// CHAT FUNCTIONALITY

const currentUserId = document.querySelector('meta[name="user-id"]')?.content;
let currentFriendId = null;
let pendingImageFile = null;

// ---------- Lightbox ----------
window.openLightbox = function (type, url) {
    const modal = document.getElementById("lightbox-modal");
    const img = document.getElementById("lightbox-image");
    const video = document.getElementById("lightbox-video");
    const youtube = document.getElementById("lightbox-youtube");

    if (!modal) return;

    img.classList.add("hidden");
    video.classList.add("hidden");
    youtube.classList.add("hidden");

    if (type === "image") {
        img.src = url;
        img.classList.remove("hidden");
    } else if (type === "video") {
        video.src = url;
        video.classList.remove("hidden");
    } else if (type === "youtube") {
        let videoId = url;
        const match = url.match(
            /(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/,
        );
        if (match) videoId = match[1];
        youtube.src = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
        youtube.classList.remove("hidden");
    }

    modal.classList.remove("hidden");
    document.body.style.overflow = "hidden";
};

window.closeLightbox = function () {
    const modal = document.getElementById("lightbox-modal");
    if (!modal) return;
    modal.classList.add("hidden");
    document.body.style.overflow = "";
    const video = document.getElementById("lightbox-video");
    const youtube = document.getElementById("lightbox-youtube");
    if (video) video.pause();
    if (youtube) youtube.src = "";
};

document.addEventListener("lightbox", (e) => {
    if (e.detail) openLightbox(e.detail.type, e.detail.url);
});

// ---------- Modal Open/Close ----------
window.openChatModal = function (friendId, friendName, friendAvatar) {
    currentFriendId = friendId;
    const nameEl = document.getElementById("chat-friend-name");
    const avatarEl = document.getElementById("chat-friend-avatar");
    if (nameEl) nameEl.textContent = friendName;
    if (avatarEl) avatarEl.src = friendAvatar;
    document.getElementById("chat-modal")?.classList.remove("hidden");
    document.getElementById("chat-message-input")?.focus();

    const friendRow = document.querySelector(`[data-friend-id="${friendId}"]`);
    if (friendRow) {
        const dot = friendRow.querySelector(".unread-dot");
        if (dot) dot.remove();
    }

    pendingImageFile = null;
    document.getElementById("image-preview")?.classList.add("hidden");
    const imageInput = document.getElementById("chat-image-input");
    if (imageInput) imageInput.value = "";

    loadMessages(friendId);
};

window.closeChatModal = function () {
    document.getElementById("chat-modal")?.classList.add("hidden");
    currentFriendId = null;
    pendingImageFile = null;
    document.getElementById("image-preview")?.classList.add("hidden");
};

// ---------- Load Conversation ----------
async function loadMessages(friendId) {
    const container = document.getElementById("chat-messages");
    if (!container) return;
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
            data.messages.forEach((msg) =>
                appendMessage(msg, msg.is_mine),
            );
        }
        scrollToBottom();
    } catch (error) {
        console.error("Failed to load messages:", error);
        container.innerHTML =
            '<div class="text-center text-red-500 py-8">Failed to load messages</div>';
    }
}

// ---------- Append Message ----------
function appendMessage(message, isMine) {
    const container = document.getElementById("chat-messages");
    if (!container) return;
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
               <img src="${message.attachment_data.url}" class="rounded-lg max-w-[200px] max-h-24 object-cover shadow-sm">
            </a>
        `;
    }

    // Shared post (with video thumbnail support)
    if (message.attachment_type === "post" && message.attachment_data) {
        const att = message.attachment_data;
        const thumbnailUrl =
            att.video_thumbnail || att.image || "/images/placeholder.png";
        const isVideo = !!att.video_thumbnail;

        content += `
            <a href="${att.url}" target="_blank" class="block mt-2 group">
                <div class="rounded-xl overflow-hidden border-2 ${
                    isMine
                        ? "border-purple-400/50"
                        : "border-gray-200 dark:border-gray-600"
                } shadow-md transition-transform group-hover:scale-[1.02] max-w-[200px]">
                    <div class="relative">
                        <img src="${thumbnailUrl}" class="w-full h-24 object-cover" onerror="this.src='/images/placeholder.png'">
                        ${
                            isVideo
                                ? `
                            <div class="absolute inset-0 flex items-center justify-center bg-black/30">
                                <div class="w-8 h-8 bg-black/60 backdrop-blur-sm rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                    </svg>
                                </div>
                            </div>
                        `
                                : ""
                        }
                    </div>
                    <div class="p-2 ${
                        isMine
                            ? "bg-purple-800/50"
                            : "bg-gray-50 dark:bg-gray-800"
                    }">
                        <p class="font-semibold text-xs truncate ${
                            isMine
                                ? "text-white"
                                : "text-gray-900 dark:text-gray-100"
                        }">${escapeHtml(att.title || "Post")}</p>
                        <p class="text-[10px] ${
                            isMine
                                ? "text-purple-200"
                                : "text-gray-500 dark:text-gray-400"
                        } mt-0.5">Tap to view</p>
                    </div>
                </div>
            </a>
        `;
    }

    content += `<span class="text-xs ${
        isMine
            ? "text-purple-200"
            : "text-gray-400 dark:text-gray-500"
    } block mt-1.5 text-right">${message.created_at}</span>`;

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
    if (container) container.scrollTop = container.scrollHeight;
}

// ---------- Send Message ----------
async function sendMessage() {
    const input = document.getElementById("chat-message-input");
    const message = input?.value.trim();

    if ((!message && !pendingImageFile) || !currentFriendId) return;

    if (input) input.disabled = true;
    const sendBtn = document.getElementById("send-message-btn");
    if (sendBtn) sendBtn.disabled = true;

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
                )?.content,
                Accept: "application/json",
            },
            body: formData,
        });

        const data = await response.json();
        if (data.status === "sent") {
            appendMessage(data.message, true);
            if (input) input.value = "";
            pendingImageFile = null;
            document.getElementById("image-preview")?.classList.add("hidden");
            const imageInput = document.getElementById("chat-image-input");
            if (imageInput) imageInput.value = "";
        }
    } catch (error) {
        console.error("Failed to send message:", error);
        alert("Failed to send message. Please try again.");
    } finally {
        if (input) input.disabled = false;
        if (sendBtn) sendBtn.disabled = false;
        input?.focus();
    }
}

// ---------- Toast Notification ----------
function showMessageToast(msg) {
    const avatar = msg.sender.avatar_url || "/images/placeholder.png";

    const toast = document.createElement("div");
    toast.className =
        "fixed bottom-4 right-4 bg-white dark:bg-gray-800 border border-purple-500 rounded-lg shadow-lg p-4 flex items-center gap-3 z-50 transition-opacity";
    toast.innerHTML = `
        <img src="${avatar}"
             class="w-10 h-10 rounded-full border-2 border-purple-500 object-cover">
        <div>
            <p class="font-semibold text-gray-900 dark:text-gray-100">${escapeHtml(msg.sender.name)}</p>
            <p class="text-sm text-gray-600 dark:text-gray-400">${escapeHtml(msg.message)}</p>
        </div>
        <button class="ml-4 text-gray-400 hover:text-gray-600" onclick="this.parentElement.remove()">✕</button>
    `;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 5000);
}

// ---------- Global echo listener, event listeners ----------
document.addEventListener("DOMContentLoaded", function () {
    // Global Echo listener for private messages
    if (window.Echo && currentUserId) {
        window.Echo.private(`user.${currentUserId}`).listen(
            "MessageSent",
            (e) => {
                const msg = e.message;
                const senderId = Number(msg.sender_id);
                const receiverId = Number(msg.receiver_id);
                const myId = Number(currentUserId);
        
                if (senderId === myId) return;
        
                if (
                    currentFriendId &&
                    (senderId === Number(currentFriendId) || receiverId === Number(currentFriendId))
                ) {
                    appendMessage(msg, false);
                }
                else if (receiverId === myId) {
                    showMessageToast(msg);
                }
        
                if (receiverId === myId && Number(currentFriendId) !== senderId) {
                    const friendRow = document.querySelector(
                        `[data-friend-id="${senderId}"]`,
                    );
                    if (friendRow) {
                        const avatarLink = friendRow.querySelector('a[href*="users"]');
                        if (avatarLink && !avatarLink.querySelector(".unread-dot")) {
                            avatarLink.style.position = "relative";
                            const dot = document.createElement("span");
                            dot.className =
                                "unread-dot absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full border-2 border-white dark:border-gray-800";
                            avatarLink.appendChild(dot);
                        }
                    }
                }
            },
        );
    }

    // Send message button
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

    // Image attachment handling
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
                    const previewImg =
                        document.getElementById("image-preview-img");
                    const previewContainer =
                        document.getElementById("image-preview");
                    if (previewImg && previewContainer) {
                        previewImg.src = ev.target.result;
                        previewContainer.classList.remove("hidden");
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }

    const removePreviewBtn = document.getElementById("remove-image-preview");
    if (removePreviewBtn) {
        removePreviewBtn.addEventListener("click", function () {
            pendingImageFile = null;
            document.getElementById("image-preview")?.classList.add("hidden");
            const imgInput = document.getElementById("chat-image-input");
            if (imgInput) imgInput.value = "";
        });
    }

    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
            closeLightbox();
        }
    });

    // Countdown timer
    const countdownEl = document.getElementById("countdown");
    if (countdownEl) {
        const deadline = parseInt(countdownEl.dataset.deadline) * 1000;
        function tick() {
            const diff = deadline - Date.now();
            if (diff <= 0) {
                countdownEl.textContent = "⏰ Challenge ended";
                return;
            }
            const days = Math.floor(diff / 86400000);
            const hrs = Math.floor((diff % 86400000) / 3600000);
            const mins = Math.floor((diff % 3600000) / 60000);
            const secs = Math.floor((diff % 60000) / 1000);
            countdownEl.textContent = `⏳ Ends in: ${days}d ${hrs}h ${mins}m ${secs}s`;
        }
        tick();
        setInterval(tick, 1000);
    }

    let sendItemType = null;
    let sendItemId = null;

    window.openSendChatModal = function (type, id) {
        sendItemType = type;
        sendItemId = id;
        document.getElementById("send-chat-modal")?.classList.remove("hidden");
        loadFriendsList();
    };

    window.closeSendChatModal = function () {
        document.getElementById("send-chat-modal")?.classList.add("hidden");
    };

    async function loadFriendsList() {
        const container = document.getElementById("friend-list-container");
        if (!container) return;
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
                    <button onclick="window.sendItemToFriend(${f.id})" class="px-3 py-1 bg-purple-600 text-white rounded-lg text-sm hover:bg-purple-700">
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

    window.sendItemToFriend = async function (friendId) {
        try {
            const res = await fetch("/chat/send", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    )?.content,
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
    };
});