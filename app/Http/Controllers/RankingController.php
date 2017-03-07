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

class RankingController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'isVerified']);
    }

	public function ranking()
	{
		$overallRankings = User::orderBy('points','DESC')->get();
		$topMen = Racer::topMen(100);
		$topWomen = Racer::topWomen(100);

		return view('result.rankings',compact('overallRankings','topMen','topWomen'));
	}

	public function weeklyRanking($id)
	{
		$week = $id;
		if($id >= 1 && $id < 9){

		//Weekly Rank and Points
		$weekRankings = Point::where('week', $id)
		->orderBy('points', 'DESC')
		->get();

		//Top Men
		$menRace = Race::where('race_week',$id)
		->where('gender','Men')
		->first();
		
		$topMen = collect();
		$topWomen = collect();

		if($menRace != null){
		$topMen = $menRace->racers()
		->take(100)
		->get();
		}

		//Top Women
		$womenRace = Race::where('race_week',$id)
		->where('gender','Women')
		->first();
		
		if($womenRace != null){
		$topWomen = $womenRace->racers()
		->take(100)
		->get();
		}
		
		}
		else{
			abort(404);
		}

		return view('result.weekRankings',compact('weekRankings','users','topMen', 'topWomen','week'));
	}
}