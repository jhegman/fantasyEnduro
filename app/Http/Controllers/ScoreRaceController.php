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
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['super', 'auth']);
    }
    
	public function score(){
		$points = Point::all();
		return view('upload-tools.score-race',compact('points'));
	}

	public function scoreRace(Request $request){
		//Get all users
		$users = User::all();
		$week = $request->week;
		$race_id_men = $request->race_id_men;
		$race_id_women = $request->race_id_women;
		//Empty arrays to compare 
		$top3MenCheck=[];
		$top3WomenCheck=[];
		//Get top 3 men racer id
		$top3Men = Race::findOrFail($race_id_men)->racers()->take(3)->get();
		foreach ($top3Men as $key => $value) {
			$top3MenCheck[$key] = $value->id;
		}
		//Get top 3 women racer id
		$top3Women = Race::findOrFail($race_id_women)->racers()->take(3)->get();
		foreach ($top3Women as $key => $value) {
			$top3WomenCheck[$key] = $value->id;
		}

		foreach ($users as $user) {
			$userLineups = User::find($user->id)->lineups()->where('week', $week)->get();
			$bonusCheckerMen = [];
			$bonusCheckerWomen = [];
			$tmpMen = $userLineups->where('gender','Men')->take(3);
			$tmpWomen = $userLineups->where('gender','Women')->take(3);
			//top 3 of each lineup into bonuschecker array
			foreach ($tmpMen as $key => $value) {
				$bonusCheckerMen[$key] = $value->racer()->first()->id;
			}
			foreach ($tmpWomen as $key => $value) {
				$bonusCheckerWomen[$key] = $value->racer()->first()->id;
			}
			
			$points = 0;
			foreach ($userLineups as $userLineup) {
				$result = Racer::find($userLineup->racer()->first()->id)
				->races()
				->where('week', $week)
				->first();

				if($result != null){
				$points += $result->pivot->points;
				}
				
			}
			//If arrays the same, give them bonus
			$bonusCheckerWomen = array_values($bonusCheckerWomen); // reset index
			if($bonusCheckerMen == $top3MenCheck){
				$points += 250;
			}
			if($bonusCheckerWomen == $top3WomenCheck){
				$points += 200;
			}
			$point = new Point;
			$point->week = $week;
			$point->user_id = $user->id;
			$point->points = $points;
			$point->save();
			$userCulmulativePoints = $user->points;
			//Add points to users points column
			$user->points = $userCulmulativePoints + $points;
			$user->save();
		}
		//get all user results
		$rankings = Point::where('week',$week)
		->orderBy('points','DESC')
		->get();

		//loop through and set each users rank
		foreach ($rankings as $key => $ranking) {
			$ranking->rank = $key+1;
			$ranking->save();
		}

		$points = Point::all();
		return view('upload-tools.score-race',compact('points'));

	}
}
