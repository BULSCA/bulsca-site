<?php

namespace App\Models\Casualty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasualtyImage extends Model
{
    use HasFactory;

    protected $fillable = ['path'];
}
