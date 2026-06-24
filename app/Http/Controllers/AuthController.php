<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerificationMail;
use App\Mail\OfferingLetterMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt(['email' => $data['email'], 'password' => $data['password']], $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        if (! Auth::user()->isVerified()) {
            return redirect()->route('verify.show');
        }

        return redirect()->intended(route('account.index'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:160|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => $data['password'],
        ]);

        Auth::login($user);
        $this->sendVerificationCode($user);

        return redirect()->route('verify.show')->with('status', 'Kode verifikasi sudah dikirim ke emailmu.');
    }

    public function showVerify()
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }
        if ($user->isVerified()) {
            return redirect()->route('account.index');
        }

        return view('auth.verify', ['email' => $user->email]);
    }

    public function verify(Request $request)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        $data = $request->validate([
            'code' => 'required|string|size:6',
        ]);

        if (! $user->verificationCodeValid($data['code'])) {
            return back()->withErrors(['code' => 'Kode salah atau sudah kedaluwarsa. Coba kirim ulang.']);
        }

        $user->markVerified();
        $this->sendOfferingLetter($user);

        return redirect()->intended(route('account.index'))->with('status', 'Email berhasil diverifikasi! Selamat datang di ConWeb.');
    }

    public function resend(Request $request)
    {
        $user = Auth::user();
        if (! $user || $user->isVerified()) {
            return redirect()->route('account.index');
        }

        $this->sendVerificationCode($user);

        return back()->with('status', 'Kode verifikasi baru sudah dikirim.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    protected function sendVerificationCode(User $user): void
    {
        $code = $user->generateVerificationCode();
        Mail::to($user->email)->send(new EmailVerificationMail($user->name, $code));
    }

    protected function sendOfferingLetter(User $user): void
    {
        if ($user->offer_sent_at) {
            return;
        }
        Mail::to($user->email)->send(new OfferingLetterMail($user->name));
        $user->forceFill(['offer_sent_at' => now()])->save();
    }
}
