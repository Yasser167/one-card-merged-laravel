<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class AccountVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $otp = mt_rand(10000, 99999);

        $this->user->otp = $otp;

        $this->user->save();

        return $this->subject('رمز التحقق الخاص بك')
            ->view('emails.verify-email')
            ->with([
                'user' => $this->user,
                'verificationUrl' => $otp,
            ]);
    }
}
