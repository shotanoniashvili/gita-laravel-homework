<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaseResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Request;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function search(Request $request) {
        $users = $this->userService->search($request->search)->paginate();

        return view('search', compact('users'));
    }

    public function me(Request $request) {
        $user = $request->user();
        $user->load(['follows', 'follows']);

        return new BaseResource('', true, $user);
    }

    public function following(Request $request) {
        $follows = $request->user()->follows()->paginate();

        return new BaseResource('', true, $follows);
    }

    public function follows(Request $request) {
        $followers = $request->user()->followers()->paginate();

        return new BaseResource('', true, $followers);
    }
}
