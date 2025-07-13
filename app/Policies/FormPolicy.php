<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Form;
use Illuminate\Auth\Access\HandlesAuthorization;

class FormPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user has admin-level access
     */
    private function isAdmin(User $user): bool
    {
        // Multiple ways to check admin status
        return $user->hasRole('admin') || 
               $user->hasPermissionTo('manage_forms') || 
               $user->is_admin === true;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        // Admin can always view all forms
        if ($this->isAdmin($user)) {
            return true;
        }

        // Check for view permissions
        return $user->can('view_forms');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Form $form)
    {
        // Admin can always view
        if ($this->isAdmin($user)) {
            return true;
        }

        // Form creator can view
        if ($form->user_id === $user->id) {
            return true;
        }

        // Check for specific view permissions
        return $user->can('view_forms') || 
               $user->can("view_form_{$form->id}");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        // Admin can always create
        if ($this->isAdmin($user)) {
            return true;
        }

        // Check for create permissions
        return $user->can('create_forms');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Form $form)
    {
        // Admin can always update
        if ($this->isAdmin($user)) {
            return true;
        }

        // Form creator can update
        if ($form->user_id === $user->id) {
            return true;
        }

        // Check for specific update permissions
        return $user->can('update_forms') || 
               $user->can("update_form_{$form->id}");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Form $form)
    {
        // Admin can always delete
        if ($this->isAdmin($user)) {
            return true;
        }

        // Form creator can delete their own draft forms
        if ($form->user_id === $user->id && $form->status === 'draft') {
            return true;
        }

        // Check for delete permissions
        return $user->can('delete_forms') || 
               $user->can("delete_form_{$form->id}");
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Form $form)
    {
        // Only admins can restore
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Form $form)
    {
        // Only admins can force delete
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can submit a response to the form.
     */
    public function submitResponse(User $user, Form $form)
    {
        // Check form status
        if ($form->status !== 'active') {
            return false;
        }

        // Admin can always submit
        if ($this->isAdmin($user)) {
            return true;
        }

        // Check if form requires user response
        if ($form->is_user_response_required) {
            return $user->can('submit_forms') || 
                   $user->can("submit_form_{$form->id}");
        }

        // Default to allowing response submission
        return true;
    }
}
