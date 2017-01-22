<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Race;
use App\Racer;
use App\League;
use Auth;

class LeagueController extends Controller
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

    //Display table of leagues
    public function displayLeagues(FormBuilder $formBuilder){
    	$user = Auth::user();
        $form = $formBuilder->create(\App\Forms\CreateLeague::class, [
            'method' => 'POST',
            'url' => route('league-created')
        ]);
        $leagues = League::all();
   		return view('league.leagues',compact('leagues','form','user'));
    }

    //Display individual league pages
    public function showLeague($id){
    	$user = Auth::user();
        $league = League::findOrFail($id);
    	$users = $league->users;

        //Check if current user is in league for Leave League button
        $userInLeagueCheck = count($league->users()->where('id',$user->id)->get());

    	return view('league.showLeague',compact('league','users','userInLeagueCheck'));
    }

    //Create New League form
    public function createNewLeague(Request $request){
        $user = Auth::user();
        $newLeague = new League();
        $newLeague->name = $request->new_league;
        $newLeague->save();
        $newLeague->users()->attach($user->id);

        return view('league.league-created',compact('newLeague'));

    }

    //Allow user to join league
    public function joinLeague(Request $request){
        $user = Auth::user();
        $id = $request->league;
        $league = League::find($id);
        $userInLeagueCheck = $league->users()->where('id',$user->id)->get();
        
        //Check to see if user is already in league
        if(count($userInLeagueCheck) == 0){
        $league->users()->attach($user->id);
        $league->save();
        }
        
        if(count($userInLeagueCheck) == 0){
        return json_encode(array(
                'status'    =>  true,
                'message'   =>  'League Joined'
            ));
        }
        else{
        return json_encode(array(
                'status'    =>  false,
                'message'   =>  'Already in this league!'
            ));
        }
    }

    //Allow user to leave a league
    public function leaveLeague(Request $request){
        $user = Auth::user();
        $id = $request->league;
        $league = League::find($id);
        $league->users()->detach($user->id);
        $league->save();

        return json_encode(array(
                'status'    =>  true,
                'message'   =>  'League Left'
            ));
    }
}