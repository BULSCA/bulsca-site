<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetitionSignup extends Model
{
    protected $fillable = [
        'competition_id', 'user_id', 'signup_data'
    ];

    protected $casts = [
        'signup_data' => 'array'
    ];

    public function competition() {
        return $this->belongsTo(Competition::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}