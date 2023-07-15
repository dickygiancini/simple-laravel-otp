<?php

namespace App\Rules\Verification;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Hash;

class MatchHashedOTP implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        $hashedOTP = User::where('id', $this->userId)->value('otp');
        $lastSendOTP = Carbon::parse(User::where('id', $this->userId)->value('email_send_at'));
        $now = Carbon::now();

        if(Hash::check($value, $hashedOTP) === false) {
            $fail('The OTP provided does not match. Check your email once again for the correct OTP');
        }

        $minuteDifference = $lastSendOTP->diffInMinutes($now);

        if($minuteDifference > 60) {
            $fail('The duration for verification is expired. Please resend the OTP');
        }
    }
}
