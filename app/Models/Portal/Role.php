<?php

namespace App\Models\Portal;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'portal_roles';
    protected $fillable = ['organisation_id', 'name', 'permissions', 'protected'];
    protected $casts = ['permissions' => 'array', 'protected' => 'boolean'];
    public function appointments() { return $this->hasMany(Appointment::class); }
}
