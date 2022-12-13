<?php

namespace App\View\Components;

use App\Models\Tweets\Tweet;
use Illuminate\View\Component;

class TweetListItemComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public Tweet $tweet, public int $showReplies = 0)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tweet-list-item-component');
    }
}
