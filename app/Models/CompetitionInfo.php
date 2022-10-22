<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetitionInfo extends Model
{
    use HasFactory;

    protected $table = 'competition_info';

    protected $casts = [
        'isolation_information' => 'array',
        'pool_information' => 'array'
    ];

    public function getCompetition()
    {
        return $this->hasOne(Competition::class, 'id', 'competition');
    }
}
