<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public $email;
    public $userType;

    public function __construct($code, $email, $userType = 'customer')
    {
        $this->code = $code;
        $this->email = $email;
        $this->userType = $userType;
    }

    public function build()
    {
        $subject = $this->userType === 'admin' ? 'Mã khôi phục mật khẩu Admin' : 'Mã khôi phục mật khẩu';
        
        return $this->subject($subject)
                    ->view('emails.reset-password-code')
                    ->with([
                        'code' => $this->code,
                        'email' => $this->email,
                        'userType' => $this->userType
                    ]);
    }
}