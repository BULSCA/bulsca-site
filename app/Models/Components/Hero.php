<?php

namespace App\Models\Components;

use Carbon\CarbonInterface;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    use HasFactory;

    protected $casts = [
        'enabled' => 'boolean',
        'valid_from' => 'datetime',
        'valid_to' => 'datetime',
    ];

    protected $fillable = [
        'name',
        'height',
        'bg_type',
        'bg_value',
        'header_layout',
        'header_title',
        'header_subtitle',
        'header_logo',
        'content',
        'activation_type',
        'valid_from',
        'valid_to',
        'enabled',
    ];
}
