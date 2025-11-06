<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetitionUniPlace extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $guarded = ['id'];

    public function getUni()
    {
        return $this->hasOne(SeasonUni::class, 'uni', 'season_uni');
    }

    public function getComp()
    {
        return $this->hasOne(Competition::class, 'id', 'league_comp');
    }
}
