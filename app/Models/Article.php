<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function getSlug()
    {
        $title = Str::replace(' ', '-', Str::lower($this->title));
        return "{$title}.{$this->id}";
    }

    public function getDateAuthorString()
    {

        $timePrefix = $this->created_at->lessThan($this->updated_at) ? 'Updated' : 'Published';

        $author = $this->author ? $this->author : 'BULSCA';

        return "{$timePrefix} on {$this->updated_at->format('d/m/Y')} by {$author}";
    }

    public function getViews()
    {
        if ($this->views < 1000) return $this->views;
        return $this->number_shorten($this->views, 1);
    }

    private function number_shorten($number, $precision = 3, $divisors = null)
    {

        // Setup default $divisors if not provided
        if (!isset($divisors)) {
            $divisors = array(
                pow(1000, 0) => '', // 1000^0 == 1
                pow(1000, 1) => 'k', // Thousand
                pow(1000, 2) => 'M', // Million
                pow(1000, 3) => 'B', // Billion
                pow(1000, 4) => 'T', // Trillion
                pow(1000, 5) => 'Qa', // Quadrillion
                pow(1000, 6) => 'Qi', // Quintillion
            );
        }

        // Loop through each $divisor and find the
        // lowest amount that matches
        foreach ($divisors as $divisor => $shorthand) {
            if (abs($number) < ($divisor * 1000)) {
                // We found a match!
                break;
            }
        }

        // We found our match, or there were no matches.
        // Either way, use the last defined value for $divisor.
        return number_format($number / $divisor, $precision) . $shorthand;
    }
}
