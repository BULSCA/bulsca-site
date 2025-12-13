<?php

namespace App\Models\Organisation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use App\Models\User;
use App\Models\Competition;

class Organisation extends Model
{
    protected $fillable = [
        'name', 
        'short_name',
        'type', 
        'parent_id', 
        'description',
        'website',
        'email',
        'phone',
        'address',
        'city',
        'county',
        'postcode',
        'country',
        'logo'
    ];

    // ==================== RELATIONSHIPS ====================
    
    // Hierarchical relationships
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Organisation::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Organisation::class, 'parent_id');
    }

    // Managers (owners/admins) - NOT members
    public function managers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'organisation_managers')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function owners(): BelongsToMany
    {
        return $this->managers()->wherePivot('role', 'owner');
    }

    public function admins(): BelongsToMany
    {
        return $this->managers()->wherePivot('role', 'admin');
    }

    // Committee positions (custom roles)
    public function committeePositions(): HasMany
    {
        return $this->hasMany(OrganisationCommitteePosition::class);
    }

    // All users with committee positions - use attribute accessor instead
    public function getCommitteeMembersAttribute()
    {
        return User::whereHas('committeePositions', function($query) {
            $query->where('organisation_id', $this->id);
        })->get();
    }

    // Regular members (NOT including committee or managers)
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'organisation_members')
            ->withPivot(['status', 'joined_at'])
            ->withTimestamps();
    }

    public function activeMembers(): BelongsToMany
    {
        return $this->members()->wherePivot('status', 'active');
    }

    // Competitions hosted/organized by this organisation
    public function competitions(): HasMany
    {
        return $this->hasMany(Competition::class);
    }

    // ==================== HELPER METHODS ====================

    // Get count of committee members
    public function getCommitteeMembersCountAttribute(): int
    {
        return User::whereHas('committeePositions', function($query) {
            $query->where('organisation_id', $this->id);
        })->count();
    }

    // Get total member count (excluding managers/committee)
    public function getMemberCount(): int
    {
        return $this->members()->where('status', 'active')->count();
    }

    // Check if user is a manager (owner OR admin)
    public function isManager(User $user): bool
    {
        return $this->managers()->where('user_id', $user->id)->exists();
    }

    // Check if user is specifically an owner
    public function isOwner(User $user): bool
    {
        return $this->managers()
            ->where('user_id', $user->id)
            ->wherePivot('role', 'owner')
            ->exists();
    }

    // Check if user is specifically an admin
    public function isAdmin(User $user): bool
    {
        return $this->managers()
            ->where('user_id', $user->id)
            ->wherePivot('role', 'admin')
            ->exists();
    }

    // Check if user is a regular member
    public function isMember(User $user): bool
    {
        return $this->members()->where('user_id', $user->id)->exists();
    }

    // Check if user is on any committee
    public function isOnCommittee(User $user): bool
    {
        return $this->committeePositions()
            ->whereHas('members', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->exists();
    }

    // Check if user has a specific committee permission
    public function userHasCommitteePermission(User $user, string $permission): bool
    {
        // Get all committee positions this user holds in this organisation
        $positions = $this->committeePositions()
            ->whereHas('members', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get();

        foreach ($positions as $position) {
            if (in_array($permission, $position->permissions ?? [])) {
                return true;
            }
        }

        return false;
    }

    // Check if user has any permission (manager or committee)
    public function userHasPermission(User $user, string $permission): bool
    {
        // Owners and admins have all permissions
        if ($this->isManager($user)) {
            return true;
        }

        // Check committee positions
        return $this->userHasCommitteePermission($user, $permission);
    }

    // Get all permissions for a user
    public function getUserPermissions(User $user): array
    {
        // Managers have all permissions
        if ($this->isManager($user)) {
            return array_keys(\App\Helpers\OrganisationHelpers::getAvailablePermissions());
        }

        // Get committee permissions
        $permissions = [];
        $positions = $this->committeePositions()
            ->whereHas('members', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get();

        foreach ($positions as $position) {
            $permissions = array_merge($permissions, $position->permissions ?? []);
        }

        return array_unique($permissions);
    }

    // Helper: Create a committee position
    public function createCommitteePosition(string $title, array $permissions, ?string $description = null): OrganisationCommitteePosition
    {
        return $this->committeePositions()->create([
            'title' => $title,
            'permissions' => $permissions,
            'description' => $description,
        ]);
    }
}