<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\AggregatedWeeklyInformationNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class AggregateWeeklyInformation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:aggregated-weekly-information';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate aggregated information notification for active users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach (User::all() as $user) {
            // TODO get new followers count

            $newFollowers = 0;
            $newFollowing = 0;
            Notification::send($user, new AggregatedWeeklyInformationNotification($newFollowing, $newFollowers));
        }

        return Command::SUCCESS;
    }
}
