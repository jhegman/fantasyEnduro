<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Storage;
use Excel;
use App\Race;
use App\Racer;
use App\User;
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
		$lineupMen = Lineup::where('gender', 'Men')
            ->where('user_id', $user->id)
            ->where('week', $week)
            ->get();
		$lineupWomen = Lineup::where('gender', 'Women')
            ->where('user_id', $user->id)
            ->where('week', $week)
            ->get();
        $men = [];
        $women = [];
        
        foreach ($lineupMen as $key => $racer) {
        	$racer = Racer::find($racer->racer_id);
        	$men[$key] = $racer;
        }

        foreach ($lineupWomen as $key => $racer) {
        	$racer = Racer::find($racer->racer_id);
        	$women[$key] = $racer;
        }
		return view('user.showUser',compact('user','men','women'));
	}
}