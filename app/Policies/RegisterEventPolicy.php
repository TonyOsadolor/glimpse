<?php

namespace App\Policies;

use App\Models\RegisterEvent;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RegisterEventPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, RegisterEvent $registerEvent): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->role === 'participant'
            ? Response::allow()
            : Response::deny('Sorry, You are not a Participant!');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RegisterEvent $registerEvent): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RegisterEvent $registerEvent): Response
    {
        return $user->id === $registerEvent->user_id
            ? Response::allow()
            : Response::deny('Sorry, Resource not Found!');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RegisterEvent $registerEvent): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RegisterEvent $registerEvent): bool
    {
        return false;
    }
}
