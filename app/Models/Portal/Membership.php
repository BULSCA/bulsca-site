<?php

namespace App\Models\Portal;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $table = 'portal_memberships';
    protected $fillable = ['organisation_id', 'user_id', 'active'];
    protected $casts = ['active' => 'boolean'];
    protected $attributes = ['active' => true];
    public function user() { return $this->belongsTo(User::class); }
    public function organisation() { return $this->belongsTo(Organisation::class); }
    public function appointments() { return $this->hasMany(Appointment::class); }
}
