<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;


    protected $guarded = ['id'];

    protected $casts = [
        'from' => 'date',
        'to' => 'date'
    ];

    public function competitions() {
        return $this->hasMany(LeagueCompetition::class, 'season');
    }

    public function unis() {
        return $this->hasManyThrough(University::class, SeasonUni::class, 'season', 'id', 'id', 'uni');
    }
}
