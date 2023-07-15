<?php

namespace App\Http\Requests;

use App\Rules\MatchPIN;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RequestBudgetRequest extends FormRequest
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
            'balance' => ['required', 'string', 'max:19'],
            'pin' => ['required', 'digits:6', new MatchPIN($this->user()->id)]
        ];
    }
}
