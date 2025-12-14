<?php

namespace App\Helpers;

use App\Models\Organisation\Organisation;

class OrganisationHelpers
{
    /**
     * Check if setting a parent would create a circular relationship
     */
    public static function wouldCreateCircularRelationship(Organisation $organisation, $proposedParentId): bool
    {
        $current = Organisation::find($proposedParentId);
        $visited = [$organisation->id];
        
        while ($current) {
            if (in_array($current->id, $visited)) {
                return true;
            }
            $visited[] = $current->id;
            $current = $current->parent;
        }
        
        return false;
    }
    
    /**
     * Get all available permissions that can be assigned to committee positions
     */
    public static function getAvailablePermissions(): array
    {
        return [
            'view_members' => 'View Members',
            'manage_members' => 'Manage Members',
            'view_finances' => 'View Finances',
            'manage_finances' => 'Manage Finances',
            'create_events' => 'Create Events',
            'manage_events' => 'Manage Events',
            'edit_organisation' => 'Edit Organisation Details',
            'view_reports' => 'View Reports',
            'manage_committee' => 'Manage Committee',
            'send_communications' => 'Send Communications',
            'manage_resources' => 'Manage Resources',
            'approve_registrations' => 'Approve Member Registrations',
        ];
    }
    
    /**
     * Get permission display names
     */
    public static function getPermissionName(string $permission): string
    {
        $permissions = self::getAvailablePermissions();
        return $permissions[$permission] ?? $permission;
    }
    
    /**
     * Check if a permission key is valid
     */
    public static function isValidPermission(string $permission): bool
    {
        return array_key_exists($permission, self::getAvailablePermissions());
    }
}