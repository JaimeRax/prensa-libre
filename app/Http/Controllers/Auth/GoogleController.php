<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    //
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $g = Socialite::driver('google')->user();

        $user = User::firstOrCreate(
            ['email' => $g->getEmail()],
            [
                'name' => $g->getName() ?? $g->getNickname() ?? 'Usuario',
                'password' => bcrypt(Str::random(32)),
                'google_id' => $g->getId(),
                'avatar' => $g->getAvatar(),
                'email_verified_at' => now(),
            ]
        );

        if (!$user->google_id) {
            $user->google_id = $g->getId();
            $user->avatar = $g->getAvatar();
            $user->save();
        }

        if (is_null($user->email_verified_at)) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        $user->assignRole('administrador');

        Auth::login($user, remember:true);
        return redirect()->intended('/');
    }
}
