@if(auth()->check())
@if(auth()->id() === $user->id)
<div x-data="{ open: false }" class="relative">
    <button @click="open = !open"
        class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 text-2xl leading-none">
        ⋮
    </button>

    <div x-show="open"
        @click.away="open = false"
        x-transition
        class="absolute right-0 mt-2 w-52 bg-white dark:bg-gray-800 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700 z-10">
        <a href="{{ route('profile.edit') }}"
            class="flex items-center gap-2 px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
            ✏️ Edit Profile
        </a>

        <a href="{{ route('friends.index') }}"
            class="flex items-center gap-2 px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
            👥 Manage Friends
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex items-center gap-2 w-full text-left px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-red-100 dark:hover:bg-red-700">
                🚪 Log Out
            </button>
        </form>
    </div>
</div>
@elseif(auth()->user()->can('delete', $user))
<div x-data="{ open: false, deleteUserModal: false }" class="relative">
    <button @click="open = !open"
        class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 text-2xl leading-none">
        ⋮
    </button>

    <div x-show="open" @click.away="open = false"
        class="absolute right-0 mt-2 w-32 bg-white dark:bg-gray-700 shadow rounded border dark:border-gray-600 z-10">
        <button type="button"
            @click="deleteUserModal = true; open = false"
            class="flex items-center gap-2 w-full text-left px-4 py-2 text-red-600 hover:bg-red-100 dark:hover:bg-red-700">
            🗑 Delete User
        </button>
    </div>
    <div x-show="deleteUserModal"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div @click.away="deleteUserModal = false"
            class="bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 p-6 rounded shadow w-96">
            <h2 class="text-xl font-bold mb-4 text-red-600">Delete User</h2>
            <p class="mb-4 text-gray-800 dark:text-gray-200">
                Are you sure you want to permanently delete <b>{{ $user->name }}</b>?
            </p>
            <div class="flex justify-end gap-2">
                <button type="button" @click="deleteUserModal = false"
                    class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded">
                    Cancel
                </button>
                <form action="{{ route('users.destroy', $user) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endif