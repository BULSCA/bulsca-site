<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeasonUni extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $guarded = ['id'];

    public function currentSeason() {
        return $this->hasOne(Season::class, 'id', 'season');
    }

    public function currentUni() {
        return $this->hasOne(University::class, 'id', 'uni');
    }


    public function seasonPlaces() {
        return $this->hasMany(CompetitionUniPlace::class, 'season_uni', 'id');
    }

}
