<?php

namespace App\Models;

use Exception;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetitionInfo extends Model
{
    use HasFactory;

    protected $table = 'competition_info';

    protected $guarded = [];

    protected $casts = [
        'timetable' => 'array'
    ];

    protected $attributes = [
        'teams_limit' => 0
    ];

    public function getCompetition()
    {
        return $this->hasOne(Competition::class, 'id', 'competition');
    }

    public function getTimetableTime($key)
    {

        if ($this->timetable === null) {
            return null;
        }

        $timestamp = $this->timetable[$key];

        if (!$timestamp) return 'N/A';



        return $timestamp;
    }

    public function orgPhone()
    {
        $phone = "";
        try {
            $phone = PhoneNumber::make($this->contact_organiser_phone, 'GB')->formatInternational();;
        } catch (Exception $e) {
            return 'N/A';
        }
        return $phone;
    }

    public function emergPhone()
    {

        $phone = "";
        try {
            $phone = PhoneNumber::make($this->contact_emergency_phone, 'GB')->formatInternational();
        } catch (Exception $e) {
            return 'N/A';
        }
        return $phone;
    }
}
