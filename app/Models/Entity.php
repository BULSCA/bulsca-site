<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Entity extends Model
{
    protected $table = 'entities';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'entity_type',
        'entity_ref_id',
        'custom_id',
        'privacy_level', // e.g., public, club_only, admins_only, private
    ];

    protected $appends = ['display_name'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($entity) {
            $entity->id = (string) Str::uuid();
            
            $prefix = match (class_basename($entity->entity_type)) {
                'User' => 'USR',
                'Organisation' => 'ORG',
                default => 'ENT'
            };

            // Optional: Append primary club ID if available
            $clubSuffix = $entity->load('parentMembership')->parentMembership?->parent?->custom_id ?? '';   

            $entity->custom_id = $prefix . '-' . strtoupper(Str::random(6));
            if ($clubSuffix) {
                $entity->custom_id .= '-' . $clubSuffix;
            }
        });
    }




    // Relationships
    public function entityable()
    {
        return $this->morphTo('entityable', 'entity_type', 'entity_ref_id');
    }

    public function childMemberships()
    {
        return $this->hasMany(Membership::class, 'parent_entity_id');
    }

    public function parentMembership()
    {
        return $this->hasOne(Membership::class, 'child_entity_id');
    }

    // Accessors
    public function getDisplayNameAttribute()
    {
        $name = $this->entityable?->name ?? 'Unknown';

        // Apply privacy rules
        $user = Auth::user();
        $isMember = $user?->entity?->isMemberOf($this);
        $isAdmin = $user?->hasRole('admin') ?? false;

        return match ($this->privacy_level) {
            'public' => $name,
            'club_only' => $isMember ? $name : $this->getInitials($name),
            'admins_only' => $isAdmin ? $name : 'Private',
            'private' => 'Private',
            default => $name,
        };
    }

    public function getInitialsAttribute()
    {
        return $this->getInitials($this->entityable?->name);
    }

    private function getInitials($name)
    {
        if (!$name) return '';
        $parts = explode(' ', $name);
        return collect($parts)->map(fn($part) => strtoupper($part[0]))->take(2)->implode('');
    }

    // Helper: Check if this entity is part of another
    public function isMemberOf($parentEntity)
    {
        return $this->memberships()
            ->where('parent_entity_id', $parentEntity->id)
            ->exists();
    }
}   