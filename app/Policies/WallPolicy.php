<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class WallPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param User|null $user
     * @param \App\Models\User $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewWall(?User $user, User $model)
    {
        if ($user?->id === $model->id) {
            return true;
        }

        if ($model->is_public) {
            return true;
        }

        if ($user?->followings->where('id', $model->id)->count() > 0) {
            return true;
        }

        return false;
    }
}
