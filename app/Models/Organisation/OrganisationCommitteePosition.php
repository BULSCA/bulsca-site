<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganisationCommitteePosition extends Model
{
    protected $fillable = ['organisation_id', 'title', 'description', 'permissions'];
    
    protected $casts = [
        'permissions' => 'array',
    ];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'organisation_committee_members')
            ->withPivot('appointed_at')
            ->withTimestamps();
    }

    // Helper: Assign user to this position
    public function assignUser(User $user)
    {
        $this->members()->attach($user->id, [
            'appointed_at' => now(),
        ]);
    }

    // Helper: Check if position has permission
    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->permissions);
    }
}