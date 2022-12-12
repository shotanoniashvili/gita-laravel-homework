<?php

namespace App\Services;

use App\Models\Tweets\Like;
use App\Models\Tweets\Reply;
use App\Models\Tweets\Tweet;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function userProfile(int $userId): User {
        return User::findOrFail($userId);
    }

    public function update(int $userId, array $data): User {
        $user = User::findOrFail($userId);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return $user;
    }
}
