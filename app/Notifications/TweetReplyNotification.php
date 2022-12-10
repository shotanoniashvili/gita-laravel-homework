<?php

namespace App\Notifications;

use App\Models\Tweets\Reply;
use App\Models\Tweets\Tweet;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TweetReplyNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(private Tweet $tweet, private Reply $like)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     *
     * @param $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'url' => route('tweets.show', $this->tweet->id),
            'title' => 'Your tweet has new reply',
            'text' => '' // TODO
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
