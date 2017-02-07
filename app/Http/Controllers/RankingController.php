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
	public function ranking(){
		$overallRankings = User::orderBy('points','DESC')->get();
		$topMen = Racer::where('gender', 'Men')
		->orderBy('points', 'DESC')
		->take(10)
		->get();

		$topWomen = Racer::where('gender', 'Women')
		->orderBy('points', 'DESC')
		->take(10)
		->get();

		return view('result.rankings',compact('overallRankings','topMen','topWomen'));
	}
}