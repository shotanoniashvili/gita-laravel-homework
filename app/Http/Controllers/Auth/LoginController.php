<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request) {
        $loggedIn = Auth::attempt($request->toArray());
        if (!$loggedIn) {
            return new BaseResource('Invalid email and/or password', false);
        }

        $user = Auth::user();

        $token = $user->createToken(md5(rand()))->plainTextToken;
        return new BaseResource('Successfully authorized', true, [
            'token' => $token,
            'user'  => $user,
        ]);
    }
}
