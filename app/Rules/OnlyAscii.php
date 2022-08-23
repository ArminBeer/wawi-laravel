<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class OnlyAscii implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(preg_match('/[^\x20-\x7e]/', $value) || preg_match('/([%\$#~\*]+)/', $value))
            return false;
        else
            return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Bitte keine Umlaute oder Sonderzeichen verwenden!';
    }
}
