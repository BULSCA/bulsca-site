<?php

namespace App\Models\Committee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\University;

class CommitteeMember extends Model
{
    use HasFactory;


    protected $guarded = ['id'];

    protected $casts = [
        'committee_id' => 'integer',
        'role_id' => 'integer',
        'affiliated_uni_id' => 'integer',
        'name' => 'string',
    ];
    
    public function committee()
    {
        return $this->belongsTo(Committee::class, 'committee_id');
    }

    public function role()
    {
        return $this->belongsTo(CommitteeRole::class, 'role_id');
    }

    public function affiliatedUniversity()
    {
        return $this->BelongsTo(University::class, 'affiliated_uni_id');
    }

}


