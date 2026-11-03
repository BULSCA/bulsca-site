<?php

namespace App\Models\Portal;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'portal_appointments';
    protected $fillable = ['organisation_id', 'membership_id', 'committee_id', 'role_id', 'revoked_at'];
    protected $casts = ['revoked_at' => 'datetime'];
    public function role() { return $this->belongsTo(Role::class); }
    public function membership() { return $this->belongsTo(Membership::class); }
    public function committee() { return $this->belongsTo(Committee::class); }
}
