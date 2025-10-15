<x-app-layout>

    <div x-data="{
    query: '',
    results: { users: [], categories: [] },
    open: false,
    async search() {
        if (this.query.length < 2) {
            this.results = { users: [], categories: [] };
            this.open = false;
            return;
        }

        try {
            const res = await fetch(`{{ url('/api/search') }}?q=${encodeURIComponent(this.query)}`);
            const data = await res.json();
            this.results = data;
            this.open = true;
        } catch (e) {
            console.error('Search error:', e);
        }
    }
}" class="relative w-full max-w-3xl mx-auto mt-10">

        <div class="relative">
            <input type="text"
                x-model="query"
                @input.debounce.300ms="search"
                placeholder="Search users or categories..."
                class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700
                      bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100
                      focus:outline-none focus:ring-2 focus:ring-purple-500 transition">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="absolute left-3 top-3 h-5 w-5 text-gray-400"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-4.35-4.35m1.1-5.4a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z" />
            </svg>
        </div>

        <div x-show="open" @click.away="open = false"
            class="absolute mt-3 w-full bg-white dark:bg-gray-800 border border-gray-200 
                dark:border-gray-700 rounded-lg shadow-lg z-50 p-4 space-y-6">

            <template x-if="results.users.length">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-purple-600">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <h3 class="font-semibold text-gray-700 dark:text-gray-300">Profiles</h3>
                    </div>

                    <template x-for="user in results.users" :key="user.id">
                        <a :href="'/users/' + user.id"
                            class="flex items-center gap-3 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded transition">
                            <img :src="user.profile_photo ? (user.profile_photo.startsWith('http') ? user.profile_photo : '/storage/' + user.profile_photo) : '/default-avatar.png'" class="w-10 h-10 rounded-full object-cover border border-gray-300 dark:border-gray-600">
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-gray-100" x-text="user.name"></p>
                                <p class="text-sm text-gray-500 dark:text-gray-400" x-text="'@' + (user.username ?? '')"></p>
                            </div>
                        </a>
                    </template>
                </div>
            </template>

            <template x-if="results.categories.length">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                        </svg>
                        <h3 class="font-semibold text-gray-700 dark:text-gray-300">Categories</h3>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-3">
                        <template x-for="cat in results.categories" :key="cat.id">
                            <a :href="'/posts/category/' + cat.id"
                                class="block p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                <div class="flex items-center gap-2">
                                    <img :src="cat.image ? '/storage/' + cat.image : '/default-category.png'"
                                        class="w-10 h-10 rounded object-cover border border-gray-300 dark:border-gray-600">
                                    <div>
                                        <h4 class="font-medium text-gray-800 dark:text-gray-100" x-text="cat.name"></h4>
                                    </div>
                                </div>
                            </a>
                        </template>
                    </div>
                </div>
            </template>

            <template x-if="!results.users.length && !results.categories.length && query.length > 1">
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">No results found.</p>
            </template>
        </div>

        <template x-if="!open && query.length < 2">
            <p class="text-gray-500 dark:text-gray-400 text-center mt-10">Start typing to search 🔍</p>
        </template>

    </div>

</x-app-layout>