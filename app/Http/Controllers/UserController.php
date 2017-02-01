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
use App\SuperAdminOption;
use App\Lineup;
use App\ChatMessage;
use App\Events\ChatMessageWasReceived;

class UserController extends Controller
{
	public function showUser($name){
		$user = User::where('name',$name)->first();
		$week = SuperAdminOption::where('option_name', 'week')->first()->option_value;

        //Display users athletes
        $men = [];
        $women = [];
        $userLineupsMen = User::find($user->id)
        ->getLineup()
        ->where('week', $week)
        ->where('gender','Men')
        ->get();
        $userLineupsWomen = User::find($user->id)
        ->getLineup()
        ->where('gender','Women')
        ->where('week', $week)->get();

        $rankings = Point::where('user_id',$user->id)->get();

        foreach ($userLineupsMen as $key=> $userLineup) {
            $men[$key] = $userLineup->racer()->first();
        }
        foreach ($userLineupsWomen as $key=> $userLineup) {
            $women[$key] = $userLineup->racer()->first();
        }

		return view('user.showUser',compact('user','men','women','rankings'));
	}
}