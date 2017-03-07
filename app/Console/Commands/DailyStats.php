<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\League;
use App\ChatMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class DailyStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stats:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily stats to super admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $yesterday = Carbon::yesterday();
        $superAdmin = User::where('super_admin',1)->get();
        $newUsers = count(User::whereDate('created_at','=', $yesterday)->get());
        $newLeagues = count(League::whereDate('created_at','=', $yesterday)->get());
        $newMessages = count(ChatMessage::whereDate('created_at', '=', $yesterday)->get());

        foreach ($superAdmin as $super) {
            $email = $super->email;
            Mail::send('emails.daily-stats', [ 'email' => $email, 'newUsers' => $newUsers, 'newLeagues' => $newLeagues, 'newMessages' => $newMessages], 
                function ($m) use ($email, $yesterday) {
                    $m->to($email)->subject('Stats for '. $yesterday->toFormattedDateString());
                });
        }
    }
}
