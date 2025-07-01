<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Mail\AccountVerification;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required']);

        // Check if the input is an email or phone number
        $input = $request->input('email');
        $user = User::where('email', $input)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'لم يتم العثور على المستخدم.');
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

        // Update the user's updated_at timestamp
        $user->touch();

        try {
            Mail::to($user->email)->send(new AccountVerification($user));
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'error' => 'فشل في إرسال البريد الإلكتروني: ' . $e->getMessage(),
                'user_id' => $request->user_id,
            ]);
        }


        Cookie::queue('user_id', $user->id, 1440);

        return redirect()->route('password.reset')->with(['success' => 'تم ارسال رمز التحقق.']);
    }
}
