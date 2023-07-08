<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AuthRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }

    public function passes($attribute, $value)
    {
        // Regular expression patterns for email and phone number validation
        $emailPattern = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';
        $phonePattern = '/^\+[0-9]{9}$/';

        // Check if the input matches either email or phone number format
        return preg_match($emailPattern, $value) || preg_match($phonePattern, $value);
    }

    public function message()
    {
        return 'Invalid input format.';
    }
}
