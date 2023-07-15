<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Hash;

class MatchPIN implements ValidationRule
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
        $hashedpin = User::where('id', $this->userId)->value('pin');
        if(Hash::check($value, $hashedpin) === false) {
            $fail('PIN is Incorrect');
        }
    }
}
