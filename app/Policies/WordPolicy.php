<?php

namespace App\Policies;

use App\User;
use App\Word;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class WordPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any words.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the word.
     *
     * @param  \App\User  $user
     * @param  \App\Word  $word
     * @return mixed
     */
    public function view(User $user, Word $word)
    {
        return true;
    }

    /**
     * Determine whether the user can create words.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the word.
     *
     * @param  \App\User  $user
     * @param  \App\Word  $word
     * @return mixed
     */
    public function update(User $user, Word $word)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the word.
     *
     * @param  \App\User  $user
     * @param  \App\Word  $word
     * @return mixed
     */
    public function delete(User $user, Word $word)
    {
        return $user->isAdmin() || $word->user_id == $user->id;
    }

    /**
     * Determine whether the user can restore the word.
     *
     * @param  \App\User  $user
     * @param  \App\Word  $word
     * @return mixed
     */
    public function restore(User $user, Word $word)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the word.
     *
     * @param  \App\User  $user
     * @param  \App\Word  $word
     * @return mixed
     */
    public function forceDelete(User $user, Word $word)
    {
        return false;
    }

    /**
     * Determine whether the user view his list of words.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewOwn(User $user)
    {
        return Auth::check();
    }
}
