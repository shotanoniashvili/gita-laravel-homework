<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\BaseResource;
use Faker\Provider\Base;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request) {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        $loggedIn = Auth::attempt([
            'email',
            'password',
        ]);

        if (!$loggedIn) {
            return new BaseResource(__('auth.failed'), false);
        }

        $user = Auth::user();
        $token = $user->createToken(md5(rand()))->plainTextToken;
        return new BaseResource('', true, [
                'token' => $token,
                'user'  => $user,
            ]);
    }
}
