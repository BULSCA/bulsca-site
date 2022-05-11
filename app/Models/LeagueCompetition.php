<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeagueCompetition extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'when' => 'datetime'
    ];

    public function hostUni() {
        return $this->hasOne(University::class, 'id', 'host');
    }

    public function currentSeason() {
        return $this->hasOne(Season::class, 'id', 'season');
    }


    
}
