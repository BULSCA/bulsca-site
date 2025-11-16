<?php

namespace App\Models\Committee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Committee\Committee;

class CommitteeRole extends Model
{
    use HasFactory;


    protected $guarded = ['id'];

    protected $casts = [
        'user_id' => 'integer',
        'label' => 'string',
        'order' => 'integer',
        'active' => 'boolean',
    ];
    
    public function committees()
    {
        return $this->belongsToMany(Committee::class, 'committee_committee_role', 'committee_role_id', 'committee_id');
    }

    public function members()
    {
        return $this->hasMany(CommitteeMember::class, 'role_id');
    }

    public function currentMember()
    {
        if (!$this->active) {
            return null;
        }
    
        $committee = Committee::current();
        if (!$committee) {
            return null;
        }
    
        return $this->members()
            ->where('committee_id', $committee->id)
            ->latest()
            ->first();
    }

    public function currentMemberName()
    {
        $member = $this->currentMember();
        return $member ? $member->name : '(unfilled)';
    }

}

