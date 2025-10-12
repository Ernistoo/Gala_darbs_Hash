<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email'])
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $name = $googleUser->getName();
        $email = $googleUser->getEmail();
        $avatar = $googleUser->getAvatar();

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'profile_photo' => $avatar,
                'password' => bcrypt(Str::random(16)),
            ]
        );

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
