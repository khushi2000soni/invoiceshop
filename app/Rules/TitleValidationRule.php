<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TitleValidationRule implements Rule
{
    public function passes($attribute, $value)
    {
        // No multiple spaces or all spaces are allowed
        // if (preg_match('/\s\s+/', $value)) {
        //     return false;
        // }
        if (preg_match('/\s{2,}/', $value)) {
            return false;
        }

        // Check string length (adjust the min and max values as needed)
        if (strlen($value) < 3 || strlen($value) > 255) {
            return false;
        }

        // // Only allow alphabetic characters (no numbers)
        // if (!preg_match('/^[A-Za-z\s]+$/', $value)) {
        //     return false;
        // }

        return true;
    }

    public function message()
    {
        return 'This field should not contain multiple consecutive spaces or consist of only spaces.';
    }
}
