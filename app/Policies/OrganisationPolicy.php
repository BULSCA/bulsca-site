<?php

namespace App\Policies;

use App\Models\Organisation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganisationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view any organisations.
     */
    public function viewAny(?User $user): bool
    {
        return true; // Public viewing
    }

    /**
     * Determine if the user can view the organisation.
     */
    public function view(?User $user, Organisation $organisation): bool
    {
        return true; // Public viewing
    }

    /**
     * Determine if the user can create organisations.
     */
    public function create(User $user): bool
    {
        // Only super admins or users with specific permission
        return $user->hasRole('super_admin') || $user->hasPermissionTo('create_organisations');
    }

    /**
     * Determine if the user can update the organisation.
     */
    public function update(User $user, Organisation $organisation): bool
    {
        // Owners, admins, or committee with edit permission
        if ($organisation->isOwner($user) || $organisation->isAdmin($user)) {
            return true;
        }
        
        return $organisation->userHasCommitteePermission($user, 'edit_organisation');
    }

    /**
     * Determine if the user can delete the organisation.
     */
    public function delete(User $user, Organisation $organisation): bool
    {
        // Only owners can delete
        return $organisation->isOwner($user);
    }

    /**
     * Determine if the user can manage managers (owners/admins).
     */
    public function manageManagers(User $user, Organisation $organisation): bool
    {
        // Only owners can manage managers
        return $organisation->isOwner($user);
    }

    /**
     * Determine if the user can manage committee positions and assignments.
     */
    public function manageCommittee(User $user, Organisation $organisation): bool
    {
        // Owners, admins, or committee with manage_committee permission
        if ($organisation->isOwner($user) || $organisation->isAdmin($user)) {
            return true;
        }
        
        return $organisation->userHasCommitteePermission($user, 'manage_committee');
    }

    /**
     * Determine if the user can view members.
     */
    public function viewMembers(User $user, Organisation $organisation): bool
    {
        // Managers, committee, or members themselves
        if ($organisation->isManager($user)) {
            return true;
        }
        
        if ($organisation->userHasCommitteePermission($user, 'view_members')) {
            return true;
        }
        
        // Members can view other members
        return $organisation->isMember($user);
    }

    /**
     * Determine if the user can manage members.
     */
    public function manageMembers(User $user, Organisation $organisation): bool
    {
        // Owners, admins, or committee with manage_members permission
        if ($organisation->isOwner($user) || $organisation->isAdmin($user)) {
            return true;
        }
        
        return $organisation->userHasCommitteePermission($user, 'manage_members');
    }
}