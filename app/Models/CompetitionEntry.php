<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetitionEntry extends Model
{
    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }
}
