<?php

namespace App\Models\Portal;

use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    protected $table = 'portal_committees';
    protected $fillable = ['organisation_id', 'name', 'starts_on', 'ends_on'];
    protected $casts = ['starts_on' => 'date:Y-m-d', 'ends_on' => 'date:Y-m-d'];
    public function appointments() { return $this->hasMany(Appointment::class); }
}
