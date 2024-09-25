<?php

namespace App\Rules;

use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Contracts\Validation\ValidationRule;

class Timestamp implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string = null): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_numeric($value)) {
            $fail($attribute . ' is not a valid timestamp');
        }
        try {
            $d = Carbon::createFromTimestamp($value);
            if ($d === false) {
                $fail($attribute . ' is not a valid timestamp');
            }
        } catch (\Exception $e) {
            $fail($attribute . ' is not a valid timestamp');
        }
    }
}
