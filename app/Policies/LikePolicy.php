<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LikePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any likes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
      return true;
    }

    /**
     * Determine whether the user can view the like.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
      return true;
    }

    /**
     * Determine whether the user can like.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      return true;
    }

    /**
     * Determine whether the user can update the like.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
      return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the like.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the like.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function restore(User $user)
    {
      return false;
    }

    /**
     * Determine whether the user can permanently delete the like.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function forceDelete(User $user)
    {
      return false;
    }
}
