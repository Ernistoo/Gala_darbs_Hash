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
// Like/Unlike functionality
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.like-btn').forEach(btn => {
        btn.addEventListener('click', async function (e) {
            e.preventDefault();
            
            const postId = this.dataset.postId;
            const isLiked = this.dataset.liked === 'true';
            const icon = this.querySelector('.like-icon');
            const countEl = this.querySelector('.like-count');
            const token = document.querySelector('meta[name="csrf-token"]').content;

            // Disable button during request
            this.disabled = true;

            try {
                const url = isLiked 
                    ? `/posts/${postId}/unlike` 
                    : `/posts/${postId}/like`;
                
                const method = isLiked ? 'DELETE' : 'POST';

                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                if (!response.ok) {
                    console.error("Like request failed", response.status);
                    return;
                }

                const data = await response.json();

 
                this.dataset.liked = data.liked;

                if (data.liked) {
                    icon.innerHTML = `<path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"/>`;
                    icon.setAttribute('fill', 'currentColor');
                    icon.removeAttribute('stroke');
                    icon.setAttribute('viewBox', '0 0 24 24');
                    this.classList.remove('text-gray-600', 'dark:text-gray-400');
                    this.classList.add('text-red-600');
                } else {
                    icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>`;
                    icon.setAttribute('stroke', 'currentColor');
                    icon.setAttribute('fill', 'none');
                    icon.setAttribute('viewBox', '0 0 24 24');
                    this.classList.remove('text-red-600');
                    this.classList.add('text-gray-600', 'dark:text-gray-400');
                }

                countEl.textContent = data.likes_count;

            } catch (err) {
                console.error("Error while liking:", err);
            } finally {

                this.disabled = false;
            }
        });
    });
});
