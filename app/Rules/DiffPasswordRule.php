<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class DiffPasswordRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

     protected $currentPassword;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }

    public function __construct($currentPassword)
    {
        $this->currentPassword = $currentPassword;
    }

    public function passes($attribute, $value)
    {
        return !Hash::check($value, $this->currentPassword);
    }

    public function message()
    {
        return 'The new password must be different from the current password.';
    }
}
