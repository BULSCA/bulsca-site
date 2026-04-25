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
            $phone = phone($this->contact_organiser_phone, 'GB')->formatInternational();
        } catch (Exception $e) {
            return 'N/A';
        }
        return $phone;
    }

    public function emergPhone()
    {

        $phone = "";
        try {
            $phone = phone($this->contact_emergency_phone, 'GB')->formatInternational();
        } catch (Exception $e) {
            return 'N/A';
        }
        return $phone;
    }

    public function getOldLocation()
    {
        try {
            $location = $this->general_location; // Access as property, not method
        } catch (Exception $e) {
            return null;
        }
        \Log::info("Retrieved old location: " . json_encode($location ? $location : 'null'));
        return $location;
    }
    
    public function primaryLocation()
    {
        return $this->belongsTo(Location::class, 'primary_location_id');
    }
    
    public function locations()
    {
        return $this->morphMany(Location::class, 'locatable');
    }


    public function getLocationAttribute()
    {
        try {
            $location = $this->primaryLocation;
        } catch (Exception $e) {
            $location = null;
        }

        if ($location === null) {
            $location = $this->getOldLocation();
        }

        if ($location) {
            if (is_object($location)) {
                \Log::info("Retrieved location: " . json_encode($location->toArray()));
            } else {
                \Log::info("Retrieved location: " . $location);
            }
        }

        return $location;
    }
}
