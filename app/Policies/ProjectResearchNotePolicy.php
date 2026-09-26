<?php

namespace App\Policies;

use App\Models\ProjectResearchNote;
use App\Models\User;

class ProjectResearchNotePolicy
{
    /**
     * Runs before every ability check. If this returns true, that ability is immediately allowed.
     * If it returns null, Laravel falls through to the specific method below.
     */
    public function before(User $user, string $ability): ?bool
    {
        return $user->type === 'employee' ? true : null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProjectResearchNote $projectResearchNote): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProjectResearchNote $projectResearchNote): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProjectResearchNote $projectResearchNote): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProjectResearchNote $projectResearchNote): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProjectResearchNote $projectResearchNote): bool
    {
        return false;
    }
}
