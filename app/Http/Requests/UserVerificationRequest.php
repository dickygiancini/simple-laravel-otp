<?php

namespace App\Http\Requests;

use App\Rules\Verification\MatchHashedOTP;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserVerificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'otp' => ['required', 'digits:6', new MatchHashedOTP($this->user()->id)]
        ];
    }

    public function messages()
    {
        return [
            'otp.required' => 'OTP Is Required',
            'otp.digits' => 'OTP Format is Invalid. Check your input and/or check your email',
        ];
    }
}
