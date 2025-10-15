import "./bootstrap";
import Alpine from "alpinejs";
import "cropperjs/dist/cropper.css";
import Cropper from "cropperjs";

window.Alpine = Alpine;

//drag n drop
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
    area.addEventListener("click", () => fileInput.click());
    fileInput.addEventListener("change", () => handleFiles(fileInput.files));
    removeButton?.addEventListener("click", removeImage);
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

//themes
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

//upvotes
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".upvote-btn").forEach((btn) => {
        btn.addEventListener("click", async function () {
            const submissionId = this.dataset.submissionId;
            const icon = this.querySelector(".upvote-icon");
            const countEl = this.nextElementSibling;
            const token = document.querySelector('meta[name="csrf-token"]').content;

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

                icon.classList.toggle("text-green-500", data.status === "upvoted");
                countEl.textContent = data.votes_count;
            } catch (err) {
                console.error(err);
            }
        });
    });
});

//likes
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".like-btn").forEach((btn) => {
        btn.addEventListener("click", async function (e) {
            e.preventDefault();

            const postId = this.dataset.postId;
            const isLiked = this.dataset.liked === "true";
            const icon = this.querySelector(".like-icon");
            const countEl = this.querySelector(".like-count");
            const token = document.querySelector('meta[name="csrf-token"]').content;

            this.disabled = true;
            try {
                const res = await fetch(
                    isLiked ? `/posts/${postId}/unlike` : `/posts/${postId}/like`,
                    {
                        method: isLiked ? "DELETE" : "POST",
                        headers: {
                            "X-CSRF-TOKEN": token,
                            Accept: "application/json",
                        },
                    }
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

//cropper.js
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

//mentions
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
            const res = await fetch(`/mentions/search?q=${encodeURIComponent(query)}`);
            const users = await res.json();
            dropdown.innerHTML = "";
            users.forEach((u) => {
                const el = document.createElement("div");
                el.className =
                    "mention-item px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer flex items-center gap-2";
                el.innerHTML = `<img src="${u.profile_photo ? "/storage/" + u.profile_photo : "/default-avatar.png"}" class="w-6 h-6 rounded-full"><span>@${u.username}</span>`;
                el.addEventListener("click", () => {
                    textarea.value =
                        text.substring(0, cursor).replace(/@\w*$/, `@${u.username} `) +
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
