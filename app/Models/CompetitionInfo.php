<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetitionInfo extends Model
{
    use HasFactory;

    protected $table = 'competition_info';

    protected $casts = [
        'timetable' => 'array'
    ];

    public function getCompetition()
    {
        return $this->hasOne(Competition::class, 'id', 'competition');
    }

    public function getTimetableTime($key)
    {
        $timestamp = $this->timetable[$key];

        if (!$timestamp) return 'N/A';

        $time = strtotime($timestamp);

        return date('d/m/Y @ h:m A');
    }
}
