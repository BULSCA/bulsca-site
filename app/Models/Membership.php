<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = ['parent_entity_id', 'child_entity_id', 'role'];

    public function parent()
    {
        return $this->belongsTo(Entity::class, 'parent_entity_id');
    }

    public function child()
    {
        return $this->belongsTo(Entity::class, 'child_entity_id');
    }

    // Scope: Only active memberships
    public function scopeActive($query)
    {
        return $query->whereNull('ended_at');
    }
}   