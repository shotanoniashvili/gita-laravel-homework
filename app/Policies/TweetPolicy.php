<?php

namespace App\Policies;

use App\Models\Tweets\Tweet;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TweetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Tweet $tweet)
    {
        return $tweet->user_id === $user->id || $tweet->user->is_public || $user->follows->where('id', $tweet->user->id)->count() > 0;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Tweet $tweet)
    {
        return $user->id === $tweet->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Tweet $tweet)
    {
        return $user->id === $tweet->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Tweet $tweet)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Tweet $tweet)
    {
        //
    }
}
