<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * @throws Exception
     */
    public function register(RegisterRequest $request) {
        DB::beginTransaction();
        try {
            $user = new User($request->except(['password']));
            $user->password = Hash::make($request->get('password'));
            $user->is_public = (bool)$request->get('is_public');
            $user->save();

            event(new Registered($user));

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

//        return new BaseResource('You have successfully registered, please check your email for account confirmation');
        // TODO response type
    }

    public function verify(EmailVerificationRequest $request) {
        $request->fulfill();

//        return new BaseResource('You have successfully verified your account');
        // TODO response type
    }

    public function resendVerification(RegisterRequest $request) {
        $request->user()->sendEmailVerificationNotification();

//        return new BaseResource('Verification email is been successfully sent to your email');
        // TODO response type
    }
}
