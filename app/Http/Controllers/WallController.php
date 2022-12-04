<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;
use App\Models\User;
use App\Policies\WallPolicy;

class WallController extends Controller
{
    public function wall(string $username) {
        $user = User::where('username', $username)->firstOrFail();
        $canSeeWall = (new WallPolicy())->viewWall(auth('sanctum')->user(), $user);

        if (!$canSeeWall) {
            return new BaseResource('You don\'t have access to this profile');
        }

        // TODO
    }
}
