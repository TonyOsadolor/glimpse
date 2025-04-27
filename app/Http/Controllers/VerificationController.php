<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Http\Request;
use App\Traits\Response;
use Illuminate\Support\Facades\Hash;

class VerificationController extends Controller
{
    /**
     * hash('sha256', 'tony@gmail.com');
     * 
     * 
     * base_url => http://127.0.0.1:8000/email/verify/
     * id => 3/
     * email => 15dac8642c979723cadfc34d81c89fec15db8edd?
     * expiration => expires=1745717786&
     * signature => signature=35654c090a74592869a8c4954f71986a03651694ec41283118bb313088054405
     */
    /**
     * Verify Email Address
     */
    public function verify(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return Response::error(404, 'The supplied email does not exist!');
        }

        if ($user->hasVerifiedEmail()) {
            return Response::success(200, 'Email already verified');
        }

        $isCodeValid = $this->isVerificationCodeValid($request);

        if (!$isCodeValid) {
            return Response::error(400, 'Invalid code');
        }

        $user->email_verified_at = now();
        $user->save();

        return Response::success(200, "Email Successfully Verified");
    }

    /**
     * Notify a User of Unverified Email
     */
    public function notice()
    {
        return Response::error(403, "You have not verified Your Email Address");
    }

    /**
     * Check if a verification code is valid for a given email.
     *
     * @param string $code
     * @param string $email
     * @return bool
     */
    public function isVerificationCodeValid($request)
    {
        $verificationCode = VerificationCode::where('verifiable', $request->email)->first();
        $signature = $verificationCode ? $request->signature : null;

        // If Verificatioin Code Exists check if the same with the hashed code
        if ($verificationCode && Hash::check($request->code, $verificationCode->code)) {
            // verify signature
            if ($signature && $signature == $request->signature) {
                return true;
            }
            return false;
        }

        if ($verificationCode && !Hash::check($request->code, $verificationCode->code)) {
            return false;
        }

        if ($verificationCode && $verificationCode->expires_at < now()) {
            return false;
        }

        return false;
    }
}
