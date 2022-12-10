<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Policies\WallPolicy;
use Illuminate\Support\Facades\Request;

class WallController extends Controller
{
    public function myFeed() {
        return view('home');
    }

    public function wall(Request $request, string $username) {
        $user = User::where('username', $username)->firstOrFail();
        $canSeeWall = (new WallPolicy())->viewWall(auth()->user(), $user);

        if (!$canSeeWall) {
            return abort(403, 'You don\'t have access to this wall');
        }

        // TODO
    }
}
