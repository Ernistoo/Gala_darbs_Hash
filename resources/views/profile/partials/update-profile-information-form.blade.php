<header class="mb-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
        {{ __('Profile Information') }}
    </h2>

    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
        {{ __("Update your account's profile information and email address.") }}
    </p>
</header>

<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
    @csrf
    @method('patch')

    <!-- Name Field -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-800 dark:text-gray-200 mb-2">
            {{ __('Name') }}
        </label>
        <input id="name" name="name" type="text"
            class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg input-focus focus:outline-none focus:ring-2 focus:ring-purple-500 text-gray-900 dark:text-gray-100 transition"
            value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
        @error('name')
        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Email Field -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-800 dark:text-gray-200 mb-2">
            {{ __('Email') }}
        </label>
        <input id="email" name="email" type="email"
            class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg input-focus focus:outline-none focus:ring-2 focus:ring-purple-500 text-gray-900 dark:text-gray-100 transition"
            value="{{ old('email', $user->email) }}" required autocomplete="username" />
        @error('email')
        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <div class="mt-3 p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
            <p class="text-sm text-yellow-800 dark:text-yellow-200">
                {{ __('Your email address is unverified.') }}
                <button form="send-verification"
                    class="ml-1 underline text-yellow-700 dark:text-yellow-300 hover:text-yellow-900 dark:hover:text-yellow-100 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    {{ __('Click here to re-send the verification email.') }}
                </button>
            </p>

            @if (session('status') === 'verification-link-sent')
            <p class="mt-2 text-sm text-green-600 dark:text-green-400">
                {{ __('A new verification link has been sent to your email address.') }}
            </p>
            @endif
        </div>
        @endif
    </div>

    <!-- Username Field -->
    <div>
        <label for="username" class="block text-sm font-medium text-gray-800 dark:text-gray-200 mb-2">
            {{ __('Username') }}
        </label>
        <input id="username" name="username" type="text"
            class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg input-focus focus:outline-none focus:ring-2 focus:ring-purple-500 text-gray-900 dark:text-gray-100 transition"
            value="{{ old('username', $user->username) }}" required autofocus />
        @error('username')
        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Bio Field -->
    <div>
        <label for="bio" class="block text-sm font-medium text-gray-800 dark:text-gray-200 mb-2">
            {{ __('Bio') }}
        </label>
        <textarea id="bio" name="bio"
            class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg input-focus focus:outline-none focus:ring-2 focus:ring-purple-500 text-gray-900 dark:text-gray-100 transition"
            rows="3">{{ old('bio', $user->bio) }}</textarea>
        @error('bio')
        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Profile Photo Field -->
    <div>
        <label for="profile_photo" class="block text-sm font-medium text-gray-800 dark:text-gray-200 mb-2">
            {{ __('Profile Photo') }}
        </label>

        <div class="flex items-center gap-4">
            @if ($user->profile_photo)
            <img src="{{ asset('storage/' . $user->profile_photo) }}" class="w-20 h-20 rounded-full object-cover border-2 border-white dark:border-gray-700 shadow-md" />
            @else
            <div class="w-20 h-20 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center border-2 border-white dark:border-gray-700">
                <svg class="w-10 h-10 text-gray-400" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10zm0 2c-6.627 0-12 5.373-12 12h24c0-6.627-5.373-12-12-12z" />
                </svg>
            </div>
            @endif

            <div class="flex-1">
                <div class="flex items-center justify-center w-full">
                    <label for="profile_photo" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-purple-500 dark:hover:border-purple-400 transition bg-white dark:bg-gray-700">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-3 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="mb-1 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF (MAX. 5MB)</p>
                        </div>
                        <input id="profile_photo" name="profile_photo" type="file" class="hidden" />
                    </label>
                </div>
            </div>
        </div>

        @error('profile_photo')
        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Save Button -->
    <div class="flex items-center gap-4 pt-4">
        <button type="submit"
            class="px-5 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition">
            {{ __('Save Changes') }}
        </button>

        @if (session('status') === 'profile-updated')
        <p x-data="{ show: true }" x-show="show" x-transition
            x-init="setTimeout(() => show = false, 2000)"
            class="text-sm text-green-600 dark:text-green-400 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ __('Saved successfully!') }}
        </p>
        @endif
    </div>
</form>

<!-- Log Out Button -->
<div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
            class="flex items-center justify-center w-full px-4 py-3 rounded-lg text-sm font-medium 
                       text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 
                       border border-red-200 dark:border-red-800 transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            {{ __('Log Out') }}
        </button>
    </form>
</div>


<style>
    .input-focus:focus {
        box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.2);
    }

    .dark .input-focus:focus {
        box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.4);
    }
</style>

<script>
    // Update file upload label when a file is selected
    document.getElementById('profile_photo').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        const label = document.querySelector('label[for="profile_photo"]');

        if (fileName) {
            label.querySelector('p:first-child').innerHTML = `<span class="font-semibold">${fileName}</span>`;
        }
    });
</script>