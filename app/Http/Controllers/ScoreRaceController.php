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
use App\Point;
use App\SuperAdminOption;
use App\Lineup;
use App\ChatMessage;
use App\Events\ChatMessageWasReceived;

class ScoreRaceController extends Controller
{
	public function score(){
		$points = Point::all();
		return view('upload-tools.score-race',compact('points'));
	}

	public function scoreRace(Request $request){
		//Get all users
		$users = User::all();
		$week = $request->week;

		foreach ($users as $user) {
			$userLineups = User::find($user->id)->getLineup()->where('week', $week)->get();
			$points = 0;
			foreach ($userLineups as $userLineup) {
				$result = Racer::find($userLineup->racer()->first()->id)
				->getRacersRace()
				->where('week', $week)
				->first();
				
				if($result != null){
				$points += $result->pivot->points;
				}
				
			}
			$point = new Point;
			$point->week = $week;
			$point->user_id = $user->id;
			$point->points = $points;
			$point->save();
		}
		$points = Point::all();
		return view('upload-tools.score-race',compact('points'));
	}
}
