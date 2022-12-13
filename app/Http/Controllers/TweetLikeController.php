<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use App\Http\Requests\TweetRequest;
use App\Models\Tweets\Tweet;
use App\Models\User;
use App\Services\TweetService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ViewErrorBag;

class TweetLikeController extends Controller
{
    public function __construct(private TweetService $tweetService)
    {
    }

    public function like(Request $request, int $tweetId) {
        try {
            $this->tweetService->like($request->user()->id, $tweetId);

            notify()->success(__('tweets.like.success'));

            return redirect()->back();
        } catch (Exception $e) {
            Log::error(__('tweets.like.error') . PHP_EOL . $e->getMessage(), $e->getTrace());

            notify()->error(__('tweets.like.error'));

            return redirect()->back();
        }
    }

    public function unlike(Request $request, int $tweetId) {
        try {
            $this->tweetService->unlike($request->user()->id, $tweetId);

            notify()->success(__('tweets.unlike.success'));

            return redirect()->back();
        } catch (Exception $e) {
            Log::error(__('tweets.unlike.error') . PHP_EOL . $e->getMessage(), $e->getTrace());

            notify()->error(__('tweets.unlike.error'));

            return redirect()->back();
        }
    }
}
