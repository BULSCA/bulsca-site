<?php

namespace App\Models\Committee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    use HasFactory;


    protected $guarded = ['id'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'name' => 'string',
        'active' => 'boolean',
    ];

    public function roles()
    {
        return $this->belongsToMany(CommitteeRole::class, 'committee_committee_role', 'committee_id', 'committee_role_id');
    }

    public function addRole(CommitteeRole $role)
    {
        $this->roles()->syncWithoutDetaching([$role->id]);
    }
    
    public function members()
    {
        return $this->hasMany(CommitteeMember::class, 'committee_id');
    }

    static function current()
    {
        $c = Committee::where('start_date', '<', now())->orderBy('start_date', 'desc')->first(); // This will show the current committee until the next committee starts, thus a new season can be made, but not automatically shown

        if (!$c) {
            $c = Committee::orderBy('start_date', 'DESC')->first();
        }

        return $c;
    }

    public function getDateSlug()
    {
        return $this->start_date->format('Y') . "-" . $this->end_date->format('y');
    }

}