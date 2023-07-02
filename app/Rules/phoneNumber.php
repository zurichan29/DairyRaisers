<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;
// use Illuminate\Contracts\Validation\Rule;

class phoneNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        function passes($attribute, $value)
        {
            return strlen($value) === 10 && substr($value, 0, 1) === '9';
        }
    }
    public function passes($attribute, $value)
    {
        return strlen($value) === 10 && substr($value, 0, 1) === '9';
    }

    public function message()
    {
        return 'The :attribute must be a valid phone number with 10 characters and starting with 9.';
    }
}
