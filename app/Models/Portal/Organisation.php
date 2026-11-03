<?php

namespace App\Models\Portal;

use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    protected $table = 'portal_organisations';
    protected $fillable = ['name', 'slug', 'kind', 'parent_id', 'university_id', 'active', 'primary_colour', 'secondary_colour', 'logo_path'];
    protected $casts = ['active' => 'boolean'];
    protected $attributes = ['active' => true];
    public function memberships() { return $this->hasMany(Membership::class); }
    public function committees() { return $this->hasMany(Committee::class); }
    public function roles() { return $this->hasMany(Role::class); }
}
