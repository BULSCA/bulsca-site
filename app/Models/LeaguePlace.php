<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaguePlace extends Model
{
    use HasFactory;

    protected $fillable = ['uni', 'comp', 'league', 'pos'];
}
