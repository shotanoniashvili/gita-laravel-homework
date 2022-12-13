<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\User;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function profile(string $username) {
        $user = User::where('username', $username)->firstOrFail();

        $this->authorize('view', $user);

        $tweets = $user->tweets()->paginate();

        return view('user-profile', compact('user', 'tweets'));
    }

    public function search(Request $request) {
        $users = $this->userService->search($request->get('search'), auth()->user()?->id)
            ->with(['tweets', 'follows'])
            ->paginate();

        return view('search', compact('users'));
    }

    public function follow(Request $request, int $id) {
        try {
            $this->userService->follow($request->user()->id, $id);

            notify()->success(__('users.follow.success'));

            return redirect()->back();
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            notify()->error(__('users.follow.error'));

            return redirect()->back();
        }
    }

    public function unfollow(Request $request, int $id) {
        try {
            $this->userService->unfollow($request->user()->id, $id);

            notify()->success(__('users.unfollow.success'));

            return redirect()->route('home');
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            notify()->error(__('users.unfollow.error'));

            return redirect()->back();
        }
    }

    public function connections(Request $request) {
        $user = $request->user();

        $users = $this->userService->connections($user->id)->latest()->paginate();

        return view('my-connections', compact('users'));
    }

    public function me(Request $request) {
        $user = $request->user();
        $tweets = $user->tweets()->paginate();

        return view('user-profile', compact('user', 'tweets'));
    }

    public function editProfile(Request $request) {
        $user = $request->user();

        return view('edit-profile', compact('user'));
    }

    public function updateProfile(ProfileRequest $request) {
        $user = $request->user();

        try {
            $this->userService->update($user->id, $request->validated());

            notify()->success(__('users.update.success'));

            return redirect()->back();
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            notify()->error(__('users.update.error'));

            return redirect()->back();
        }
    }
}
