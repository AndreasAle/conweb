<?php

namespace App\Http\Controllers;

use App\Mail\OfferingLetterMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleController extends Controller
{
    public function redirect()
    {
        if (! config('services.google.client_id')) {
            return redirect()->route('login')->withErrors(['email' => 'Login Google belum dikonfigurasi. Silakan gunakan email & password.']);
        }

        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $g = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            return redirect()->route('login')->withErrors(['email' => 'Gagal login dengan Google, silakan coba lagi.']);
        }

        $user = User::where('google_id', $g->getId())
            ->orWhere('email', $g->getEmail())
            ->first();

        $isNew = false;

        if (! $user) {
            $user = User::create([
                'name' => $g->getName() ?: 'Pengguna Google',
                'email' => $g->getEmail(),
                'google_id' => $g->getId(),
                'avatar' => $g->getAvatar(),
                'email_verified_at' => now(), // email Google sudah terverifikasi
            ]);
            $isNew = true;
        } else {
            $user->forceFill([
                'google_id' => $g->getId(),
                'avatar' => $user->avatar ?: $g->getAvatar(),
                'email_verified_at' => $user->email_verified_at ?: now(),
            ])->save();
        }

        Auth::login($user, true);

        if ($isNew && ! $user->offer_sent_at) {
            Mail::to($user->email)->send(new OfferingLetterMail($user->name));
            $user->forceFill(['offer_sent_at' => now()])->save();
        }

        return redirect()->intended(route('account.index'));
    }
}
