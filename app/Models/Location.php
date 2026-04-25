<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name',
        'lat',
        'long',
        'address',
        'postcode',
        'country',
    ];

    public function locatable()
    {
        return $this->morphTo();
    }
}