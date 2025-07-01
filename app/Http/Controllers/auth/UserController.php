<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Mail\AccountVerification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.signup');
    }

    public function loginUser(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (!Auth::attempt($credentials, $remember)) {
            return redirect()->route('login')->withInput()->with('error', 'بيانات غير صحيحة');
        }

        $email = $request->input('email');

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('login')->withInput()->with('error', 'لم يتم العثور على المستخدم.');
        }

        if (!$user->hasVerifiedEmail()) {


            try {
                Mail::to($user->email)->send(new AccountVerification($user));
            } catch (\Exception $e) {
                return redirect()->back()->with([
                    'error' => 'فشل في إرسال البريد الإلكتروني: ' . $e->getMessage(),
                    'user_id' => $request->user_id,
                ]);
            }


            Cookie::queue('user_id', $user->id, 1440);

            return redirect()->route('getVerifyEmail.notice')->with(['success' => 'تم ارسال رمز التحقق التحقق.',]);
        }

        if (Auth::attempt($credentials, $remember)) {
            return redirect()->route('index.dashboard')->with('success', 'تم تسجيل الدخول بنجاح.');
        }
    }

    public function getVerifyEmail()
    {
        $userId = Cookie::get('user_id');

        return view('auth.verify-email', ['userId' => $userId]);
    }

    public function resendVerifyEmail(Request $request)
    {
        $user = User::find($request->user_id);

        // Check if the user exists
        if (!$user) {
            return redirect()->back()->with('error', 'لم يتم العثور على المستخدم');
        }

        // Check recent resend attempts within the resend interval
        $recentResend = User::where('id', $user->id)
            ->where('updated_at', '>=', Carbon::now()->subMinutes(3))
            ->first();

        if ($recentResend) {
            $nextAllowedResendTime = Carbon::parse($recentResend->updated_at)->addMinutes(3);
            $remainingTime = Carbon::now()->diffInSeconds($nextAllowedResendTime);

            return redirect()->back()->with([
                'error' => 'انتظر من فضلك ' . gmdate("i:s", $remainingTime) . ' قبل إعادة الارسال',
                'user_id' => $request->user_id,
            ]);
        }

        // Send the verification email
        try {
            Mail::to($user->email)->send(new AccountVerification($user));
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'error' => 'فشل في إرسال البريد الإلكتروني: ' . $e->getMessage(),
                'user_id' => $request->user_id,
            ]);
        }

        // Update the user's updated_at timestamp
        $user->touch();

        Cookie::queue('user_id', $user->id, 1440);

        return redirect()->back()->with(['success' => 'تم ارسال رمز التحقق.']);
    }

    public function verificationVerify(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|max:6',
        ]);

        $user = User::where('id', $request->input('user_id'))->first();

        if (!$user) {
            Cookie::queue(Cookie::forget('user_id'));
            return redirect()->route('login');
        }

        if ($user->hasVerifiedEmail()) {
            Cookie::queue(Cookie::forget('user_id'));
            Auth::login($user);
            return redirect()->route('index.dashboard')->with('success', 'تم التحقق وتسجيل الدخول بنجاح.');
        }

        if ($user && $user->otp === $request->input('otp')) {

            $user->otp = null;
            $user->email_verified_at = now();
            $user->save();

            Auth::login($user);

            Cookie::queue(Cookie::forget('user_id'));

            return redirect()->route('index.dashboard')->with('success', 'تم التحقق وتسجيل الدخول بنجاح.');
        } else {
            return redirect()->back()->with('error', 'رقم التحقق غير صحيح');
        }
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);


        $data = $request->all();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        try {
            Mail::to($user->email)->send(new AccountVerification($user));
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'error' => 'فشل في إرسال البريد الإلكتروني: ' . $e->getMessage(),
                'user_id' => $request->user_id,
            ]);
        }


        Cookie::queue('user_id', $user->id, 1440);

        return redirect()->route('getVerifyEmail.notice')->with(['success' => 'تم ارسال رمز التحقق الخاص بك']);
    }
}
