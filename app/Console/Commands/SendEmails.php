<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\SetLineup;
use App\User;
use Carbon\Carbon;
use App\SelectionPeriod;
use App\Lineup;
use App\SuperAdminOption;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends email to users who have not set their lineup';

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
        //Check todays date
        $send = false;
        $today = Carbon::today();
        $emailDates = SelectionPeriod::all();
        $week = SuperAdminOption::where('option_name', 'week')->first()->option_value;
        
        //compare todays date to dates that emails should be sent
        foreach ($emailDates as $emailDate) {
            if(Carbon::parse($emailDate->send_email) == $today){
                $send = true;
            }
        }

        if($send == true){
        $users = User::all();
        foreach ($users as $key => $user) {
            //check if their lineup is full and if they are subscribed to emails
            if(count($user->getLineup()->where('week', $week)->get()) < 10
                && $user->subscribed == 1){
            \Mail::to($user)->send(new SetLineup);
            }
        }
    }

    }
}
