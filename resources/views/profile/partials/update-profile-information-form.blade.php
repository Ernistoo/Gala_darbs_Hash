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

    <div>
    <label for="profile_photo" class="block text-sm font-medium text-gray-800 dark:text-gray-200 mb-2">
        {{ __('Profile Photo') }}
    </label>

    <div class="flex items-center gap-4">
        <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-gray-300 dark:border-gray-600">
            <img id="profile-photo-preview" 
                 src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('default-avatar.png') }}" 
                 class="w-full h-full object-cover" />
        </div>

        <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="hidden">

        <button type="button" id="select-photo-btn"
                class="px-3 py-2 bg-gray-200 dark:bg-gray-600 rounded-lg text-sm">
            Upload & Crop
        </button>

        <input type="hidden" name="profile_photo_cropped" id="profile_photo_cropped">
    </div>
</div>

<div id="cropper-modal" class="hidden fixed inset-0 z-50 bg-black/70 flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-lg max-w-lg w-full">
        <div class="flex justify-between items-center mb-2">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Crop your photo</h3>
            <button id="close-cropper" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>
        <div class="w-full">
            <img id="cropper-image" class="max-h-96 w-full object-contain">
        </div>
        <div class="mt-4 flex justify-end gap-2">
            <button id="crop-image-btn" 
                    class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg">
                Crop & Save
            </button>
        </div>
    </div>
</div>


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
    document.getElementById('profile_photo').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        const label = document.querySelector('label[for="profile_photo"]');

        if (fileName) {
            label.querySelector('p:first-child').innerHTML = `<span class="font-semibold">${fileName}</span>`;
        }
    });
</script>