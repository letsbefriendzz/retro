<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return response()->redirectTo(route('login.github'));
    }

    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleProviderCallback()
    {
        $githubUser = Socialite::driver('github')->user();

        $user = User::query()->where('email', $githubUser->getEmail())->first();

        if (!$user) {
            $user = User::query()->create([
                'name' => $githubUser->getName(),
                'nickname' => $githubUser->nickname ?: null,
                'email' => $githubUser->getEmail(),
                'github_id' => $githubUser->getId(),
                'avatar' => $githubUser->getAvatar(),
                'password' => Hash::make(Str::random()),
            ]);
        }

        Auth::login($user, true);

        return redirect('/');
    }
}
