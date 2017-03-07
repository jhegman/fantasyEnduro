<?php

namespace App\Listeners;

use App\Events\ScoreRace;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Point;

class EmailScores implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ScoreRace  $event
     * @return void
     */
    public function handle(ScoreRace $event)
    {
    $race = $event->race;
    $users = User::where('subscribed', '1')->get();
    $topUsers = Point::where('week', $race->race_week)
    ->orderBy('points','DESC')
    ->take(10)
    ->get();

    foreach ($users as $user) {
        $email = $user->email;
        $rank = $user->points()->where('week',$race->race_week)->first();
        Mail::send('emails.race-scored-email', [ 'email' => $email, 'user' => $user, 'race' => $race, 'rank' => $rank, 'top10' => $topUsers], 
        function ($m) use ($email) {
                    $m->to($email)->subject('This weekend\'s races has been scored!');
                });
        }
    }
}
