<?php

namespace App\Jobs;

use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use App\Models\VerificationCode;
use App\Enums\VerificationTypeEnum;
use Illuminate\Support\Facades\Hash;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Notifications\VerifyEmailNotification;
use App\Notifications\ResetPasswordNotification;

class SendVerificationCodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $verificationType;

    public function __construct(string $email, string $verificationType)
    {
        $this->email = $email;
        $this->verificationType = $verificationType;
    }

    public function handle()
    {
        $code = random_int(1000, 9999);
        $user = $this->getUserDetails($this->email);

        if (!$user) return;

        $name = $user->role == RoleEnum::PARTICIPANT ? $user->first_name: $user->company_name;

        VerificationCode::where('verifiable', $this->email)->delete();

        $hashedCode = Hash::make($code);
        $signature = Str::random(10);
        $data = [
            'code' => $hashedCode,
            'verifiable' => $this->email,
            'expires_at' => now()->addHour(),
            'firstname' => $name,
            'signature' => $signature,
        ];

        $verification = VerificationCode::create($data);

        $mail = [
            'email' => $user->email,
            'code' => $code,
            'name' => $user->role == RoleEnum::PARTICIPANT ? $user->first_name: $user->profile->company_name,
            'signature' => $signature,
            'user' => $user,
            'verification' => $verification,
        ];

        if ($this->verificationType == VerificationTypeEnum::EMAIL) {
            $mail['subject'] = "Hello {$name}! Verify Email Address";
            $mail['message'] = 'Your verification code: ';
            Notification::route('mail', $this->email)->notify(new VerifyEmailNotification($mail));
        }

        if ($this->verificationType == VerificationTypeEnum::PASSWORD) {
            $mail['subject'] = 'Password Reset Code';
            $mail['message'] = 'Your password reset code: ';
            Notification::route('mail', $this->email)->notify(new ResetPasswordNotification($mail));
        }
    }

    /**
     * Get the Users Details
     */
    private function getUserDetails($email)
    {
        return User::where('email', $email)->first();
    }
}