<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function googleRedirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function googleCallback($provider)
    {
        try {
            $account = Socialite::driver($provider)->user();

            $user = User::where('google_id', $account->getId())
                ->orWhere('email', $account->getEmail())
                ->first();

            if (!$user) {
                return redirect('/login')->with('error', 'Akun tidak ditemukan');
            }

            $user->update([
                'name' => $account->getName(),
                'email' => $account->getEmail(),
                'google_id' => $account->getId()
            ]);

            auth('web')->login($user);
            session()->regenerate();

            return redirect('/');
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }
}
