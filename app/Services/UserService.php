<?php

namespace App\Services;

use App\Models\Tweets\Like;
use App\Models\Tweets\Reply;
use App\Models\Tweets\Tweet;
use App\Models\User;
use App\Notifications\AggregatedWeeklyInformationNotification;
use App\Notifications\UserFollowNotification;
use App\Notifications\UserUnfollowNotification;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class UserService
{
    public function userProfile(int $userId): User {
        return User::findOrFail($userId);
    }

    public function update(int $userId, array $data): User {
        $user = User::findOrFail($userId);

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return $user;
    }

    public function search(string $keyword = null, int $userId = null): Builder {
        $query = User::query();

        if ($userId) {
            $query->where(function ($query) use ($userId) {
                $query->where('id', '!=', $userId);
            });
        }

        if ($keyword) {
            $query->where(function($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('username', 'like', '%' . $keyword . '%');
            });
        }

        return $query;
    }

    public function follow(int $userId, int $followUserId) {
        $user = User::findOrFail($userId);

        $followedUser = User::findOrFail($followUserId);

        Notification::send($followedUser, new UserFollowNotification($user));

        return $user->follows()->attach($followUserId);
    }

    public function unfollow(int $userId, int $followUserId) {
        $user = User::findOrFail($userId);

        $unfollowedUser = User::findOrFail($followUserId);

        Notification::send($unfollowedUser, new UserUnfollowNotification($user));

        return $user->follows()->detach($followUserId);
    }

    public function connections(int $userId) {
        return User::whereHas('followers', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->orWhereHas('follows', function($query) use ($userId) {
            $query->where('follows_user_id', $userId);
        });
    }
}
