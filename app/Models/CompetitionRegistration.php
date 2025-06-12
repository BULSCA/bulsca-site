<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetitionRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'food_preference',
        'has_dietary_requirements',
        'dietary_requirements',
    ];
}
