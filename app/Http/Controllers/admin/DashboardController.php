<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\AccountVerification;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $storesCount = Store::all()->count();

        return view('dashboard.index', compact('storesCount'));
    }


    public function settings()
    {
        $user = Auth::user();

        $sessions = DB::table('sessions')
            ->where('user_id', $user->id)
            ->get();

        foreach ($sessions as $session) {
            $session->last_activity = Carbon::parse($session->last_activity)->diffForHumans();
            $userAgent = new Agent();
            $userAgent->setUserAgent($session->user_agent);
            $session->user_agent = $userAgent;
        }

        return view('dashboard.settings', ['user' => $user, 'sessions' => $sessions,]);
    }

    public function deleteOtherSessions()
    {
        $user = Auth::user();

        DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('id', '<>', session()->getId())
            ->delete();

        return redirect()->back()->with('success', 'لقد تم حذف الجلسات بنجاح.');
    }

    public function accountUpdate(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255|unique:users,email,' . $user->id,
        ]);


        if ($request->filled('email') && $user->email !== $request->input('email')) {
            $user->email = $request->input('email');
            $user->email_verified_at = null;

            try {
                Mail::to($user->email)->send(new AccountVerification($user));
            } catch (\Exception $e) {
                return redirect()->back()->with([
                    'error' => 'فشل في إرسال البريد الإلكتروني: ' . $e->getMessage(),
                    'user_id' => $request->user_id,
                ]);
            }
        }

        $user->name = $request->input('name');

        $user->save();

        return redirect()->back()->with('success', 'تم تحديث الحساب بنجاح.');
    }

    public function accountPasswordUpdate(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'كلمة المرور المقدمة لا تتطابق مع سجلاتنا.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'تم تحديث كلمة السر بنجاح.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function indexLogout()
    {
        abort(404);
    }
}
