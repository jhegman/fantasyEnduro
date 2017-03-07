<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\SuperAdminOption;
use App\SelectionPeriod;
use Carbon\Carbon;

class SetLineup extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $week = SuperAdminOption::where('option_name', 'week')->first()->option_value;
        $period = SelectionPeriod::where('week',$week)->first();
        $period = Carbon::parse($period->closed)->toDayDateTimeString();
        return $this->view('emails.set-lineup-email',compact('period'));
    }
}
