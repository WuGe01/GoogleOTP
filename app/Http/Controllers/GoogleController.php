<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Google2FA;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    public function show()
    {
        $user = Auth::guard('web')->user();

        $QRImage = Google2FA::getQRCodeInline(
            config('app.name'),
            $user->email,
            $user->google2fa_secret
        );

        return view('auth.setup2fa', ['user' => $user, 'QRImage' => $QRImage]);
    }

    public function verifyShow()
    {

        return view('google2fa.index');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'one_time_password' => ['required', 'numeric'],
        ]);

        $user = auth()->user();

        if (empty($user->google2fa_secret)) {
            return redirect()->back()->withErrors(['message' => 'No 2FA secret key is set for this user.']);
        }
    
        $valid = Google2FA::verifyKey($user->google2fa_secret, $request->one_time_password);
    
        if ($valid) {
            session(['2fa' => true]);
            return redirect("home");
        } else {
            return redirect()->back()->withErrors(['one_time_password' => 'The provided OTP is invalid.']);
        }
    }
}
