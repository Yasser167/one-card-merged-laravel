<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function showResetForm()
    {
        $userId = Cookie::get('user_id');

        return view('auth.reset-password', ['userId' => $userId]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|max:6',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::where('id', $request->input('user_id'))->first();

        if (!$user) {
            Cookie::queue(Cookie::forget('user_id'));
            return redirect()->route('login');
        }

        if ($user && $user->otp === $request->input('otp')) {

            $user->otp = null;
            $user->password = Hash::make($request->input('password'));
            $user->email_verified_at = now();
            $user->save();

            Cookie::queue(Cookie::forget('user_id'));

            return redirect()->route('login')->with('success', 'تم اعادة تعيين كلمة المرور بنجاح');
        } else {
            return redirect()->back()->with('error', 'رقم التحقق غير صحيح');
        }
    }
}
