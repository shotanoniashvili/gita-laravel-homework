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

class TweetReplyController extends Controller
{
    public function __construct(private TweetService $tweetService)
    {
    }

    public function reply(ReplyRequest $request, int $tweetId) {
        try {
            $data = [
                'user_id' => $request->user()->id,
                'content' => $request->get('content_' . $tweetId)
            ];

            $this->tweetService->createReply($tweetId, $data);

            notify()->success(__('tweets.replies.success'));

            return redirect()->route('tweets.show', $tweetId);
        } catch (Exception $e) {
            Log::error(__('tweets.replies.error') . PHP_EOL . $e->getMessage(), $e->getTrace());

            notify()->error(__('tweets.replies.error'));

            return redirect()->route('tweets.show', $tweetId);
        }
    }
}
