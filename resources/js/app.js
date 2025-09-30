import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();


document.addEventListener("DOMContentLoaded", () => {
    const themeToggleBtn = document.getElementById("theme-toggle");
    const darkIcon = document.getElementById("theme-toggle-dark-icon");
    const lightIcon = document.getElementById("theme-toggle-light-icon");

    if (themeToggleBtn && darkIcon && lightIcon) {
        
        if (
            localStorage.getItem("color-theme") === "dark" ||
            (!("color-theme" in localStorage) &&
                window.matchMedia("(prefers-color-scheme: dark)").matches)
        ) {
            document.documentElement.classList.add("dark");
            lightIcon.classList.remove("hidden");
            darkIcon.classList.add("hidden");
        } else {
            document.documentElement.classList.remove("dark");
            darkIcon.classList.remove("hidden");
            lightIcon.classList.add("hidden");
        }

        
        themeToggleBtn.addEventListener("click", () => {
            darkIcon.classList.toggle("hidden");
            lightIcon.classList.toggle("hidden");

            if (document.documentElement.classList.contains("dark")) {
                document.documentElement.classList.remove("dark");
                localStorage.setItem("color-theme", "light");
            } else {
                document.documentElement.classList.add("dark");
                localStorage.setItem("color-theme", "dark");
            }
        });
    }
});


document.addEventListener("DOMContentLoaded", () => {
    const dragArea = document.getElementById('drag-area');
    const fileInput = document.getElementById('file-input');
    const dragContent = document.getElementById('drag-content');
    const previewContainer = document.getElementById('preview-container');
    const previewImage = document.getElementById('preview-image');
    const removeButton = document.getElementById('remove-image');

    if (dragArea && fileInput) {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dragArea.addEventListener(eventName, e => {
                e.preventDefault();
                e.stopPropagation();
            });
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            dragArea.addEventListener(eventName, () => dragArea.classList.add('active'));
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dragArea.addEventListener(eventName, () => dragArea.classList.remove('active'));
        });

        dragArea.addEventListener('drop', e => handleFiles(e.dataTransfer.files));
        dragArea.addEventListener('click', () => fileInput.click());
        fileInput.addEventListener('change', () => handleFiles(fileInput.files));
        removeButton?.addEventListener('click', removeImage);

        function handleFiles(files) {
            if (files.length > 0) {
                const file = files[0];
                if (file.type.match('image.*')) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        previewImage.src = e.target.result;
                        dragContent.classList.add('hidden');
                        previewContainer.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            }
        }

        function removeImage() {
            fileInput.value = '';
            previewImage.src = '';
            dragContent.classList.remove('hidden');
            previewContainer.classList.add('hidden');
        }
    }
});


Alpine.data('carousel', () => ({
    index: 0,
    items: [],
    init() {
        this.items = this.$el.querySelectorAll('div > div');
    },
    next() {
        if (this.index < this.items.length - 1) this.index++
    },
    prev() {
        if (this.index > 0) this.index--
    }
}));

Alpine.data('dropdown', () => ({
    open: false,
    toggle() { this.open = !this.open }
}));


document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.upvote-btn').forEach(btn => {
        btn.addEventListener('click', async function () {
            const submissionId = this.dataset.submissionId;
            const icon = this.querySelector('.upvote-icon');
            const countEl = this.nextElementSibling;
            const token = document.querySelector('meta[name="csrf-token"]').content;

            try {
                const response = await fetch(`/submissions/${submissionId}/vote`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                });

                if (!response.ok) {
                    console.error("Upvote request failed", response.status);
                    return;
                }

                const data = await response.json();

                if (data.status === 'upvoted') {
                    icon.classList.add('text-green-500');
                } else {
                    icon.classList.remove('text-green-500');
                }

                countEl.textContent = data.votes_count;

               
                icon.classList.add('animate-upvote');
                setTimeout(() => icon.classList.remove('animate-upvote'), 500);
            } catch (err) {
                console.error("Error while voting:", err);
            }
        });
    });
});
