<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Storage;
use Excel;
use App\Race;
use App\Racer;
use App\User;
use App\Point;
use Image;
use Auth;
use Log;
use Route;
use App\SelectionPeriod;
use App\SuperAdminOption;
use App\Lineup;
use App\ChatMessage;
use App\Events\ChatMessageWasReceived;
use Jrean\UserVerification\Facades\UserVerification;
use App\Notifications\userRegistered;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function showUser($name)
    {
		$user = User::where('name',$name)->firstOrFail();
		$week = SuperAdminOption::where('option_name', 'week')->first()->option_value;

        //Display users athletes
        $men = [];
        $women = [];
        $userLineupsMen = User::find($user->id)
        ->lineups()
        ->where('week', $week)
        ->where('gender','Men')
        ->get();
        $userLineupsWomen = User::find($user->id)
        ->lineups()
        ->where('gender','Women')
        ->where('week', $week)->get();

        $rankings = Point::where('user_id',$user->id)->get();

        foreach ($userLineupsMen as $key=> $userLineup) {
            $men[$key] = $userLineup->racer()->first();
        }
        foreach ($userLineupsWomen as $key=> $userLineup) {
            $women[$key] = $userLineup->racer()->first();
        }

        $isOpen = SelectionPeriod::open($week);

		return view('user.showUser',compact('user','men','women','rankings','isOpen'));
	}

    public function userVerified(FormBuilder $formBuilder)
    {
        // $user = Auth::user();
        
        // //Slack Noty
        // $super = User::where('super_admin',1)->first();

        // $super->notify(new userRegistered($user));

        return view('user.user-verified');
    }

    public function resendVerification()
    {
        $user = Auth::user();
        UserVerification::send($user, 'Fantasy Enduro - Verify Your Account');

        return view('user.verification-resent');
    }
}