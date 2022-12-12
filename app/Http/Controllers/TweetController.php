<?php

namespace App\Http\Controllers;

use App\Http\Requests\TweetRequest;
use App\Models\User;

class TweetController extends Controller
{
    public function profile(string $username) {
        $authUser = auth()->user();
        $user = User::where('username', $username)->firstOrFail();

        // TODO
    }

    public function index() {
        // TODO

        return view('home');
    }

    public function show(int $tweetId) {
        // TODO
    }

    public function store(TweetRequest $request) {
        // TODO
    }

    public function update(TweetRequest $request, int $tweetId) {
        // TODO
    }

    public function destroy(int $tweetId) {
        // TODO
    }
}
