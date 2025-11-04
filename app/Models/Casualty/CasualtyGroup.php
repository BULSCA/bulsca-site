<?php

namespace App\Models\Casualty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasualtyGroup extends Model
{
    use HasFactory;

    public function getCasualties()
    {
        return $this->hasMany(Casualty::class, 'group');
    }
}
