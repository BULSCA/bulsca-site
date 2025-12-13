<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'address', 'owner_entity_id'];

    public function ownerEntity()
    {
        return $this->belongsTo(Entity::class, 'owner_entity_id');
    }

    public function entity()
    {
        return $this->morphOne(Entity::class, 'entityable', 'entity_type', 'entity_ref_id');
    }

    // Helper: Check if user is admin
    public function hasAdmin($user)
    {
        return $this->ownerEntity->entityable->is($user) ||
               $user->entity?->memberships?->where('parent_entity_id', $this->entity->id)
                                           ->where('role', 'admin')
                                           ->exists();
    }
}   