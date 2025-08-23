<?php

// In app/Rules/MinWords.php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MinWords implements Rule
{
    protected $min;

    public function __construct($min)
    {
        $this->min = $min;
    }

    public function passes($attribute, $value)
    {
        $wordCount = str_word_count(strip_tags($value));
        return $wordCount >= $this->min;
    }

    public function message()
    {
        return "The :attribute must have at least {$this->min} words.";
    }
}
