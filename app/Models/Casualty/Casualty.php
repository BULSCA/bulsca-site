<?php

namespace App\Models\Casualty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Casualty\CasualtyGroup;

class Casualty extends Model
{
    use HasFactory;

    public function getCasualtyGroup() {
        return $this->belongsTo(CasualtyGroup::class, 'group');
    }
}
