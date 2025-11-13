<?php

namespace App\Models\Committee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

}

