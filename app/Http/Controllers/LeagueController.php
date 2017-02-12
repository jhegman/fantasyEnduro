<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Race;
use App\Racer;
use App\League;
use App\User;
use App\ChatMessage;
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
        $this->middleware(['auth', 'isVerified']);
    }

    //Display table of leagues
    public function displayLeagues(){
    	$user = Auth::user();
        $leagues = League::all();
   		return view('league.leagues',compact('leagues','user'));
    }

    //Display individual league pages
    public function showLeague($id){
    	$user = Auth::user();
        $league = League::findOrFail($id);
    	$users = $league->users;
        $users = $users->sortByDesc('points');

        $messages = ChatMessage::where('league_id', $id)
        ->orderBy('id','desc')
        ->take(50)
        ->get()
        ->reverse();

        $ids = [];
        $names = [];
        foreach ($messages as $key => $message) {
            $ids[$key] = $message->user_id;
            $names[$key] = User::findOrFail($ids[$key]);
        }
        //Check if current user is in league for Leave League button
        $userInLeagueCheck = count($league->users()->where('id',$user->id)->get());

    	return view('league.showLeague',compact('league','users','userInLeagueCheck','messages','names'));
    }

    //Create New League form
    public function createNewLeague(Request $request)
    {
        $this->validate($request, [
            'new_league' => 'required|min:3|unique:leagues,name',
        ]);
        $user = Auth::user();
        $newLeague = new League();
        $newLeague->name = $request->new_league;
        $password = $request->password;
        if($password != ""){
            $newLeague->password = encrypt($password);
        }
        $newLeague->save();
        $newLeague->users()->attach($user->id);

        return view('league.league-created',compact('newLeague'));

    }

    //Allow user to join league
    public function joinLeague(Request $request)
    {
        $user = Auth::user();
        $id = $request->league;
        $password = $request->password;
        $league = League::find($id);
        $userInLeagueCheck = $league->users()->where('id',$user->id)->get();
        
        //If there is no league password, skip password verification
        if($league->password == null){
            $league->users()->attach($user->id);
            $league->save();
        }

        //Password verification
        else{
        //If password is incorrect
        if ($password != decrypt($league->password)){
        return json_encode(array(
                'status'    =>  false,
                'message'   =>  'Incorrect Password!'
            ));
        }
        
            //If not in league and password is correct, add to league
            if(count($userInLeagueCheck) == 0 && $password == decrypt($league->password)){
            $league->users()->attach($user->id);
            $league->save();
            }
        }
        
        if(count($userInLeagueCheck) == 0){
        return json_encode(array(
                'status'    =>  true,
                'message'   =>  'League Joined',
                'leagueSave'=> true
            ));
        }
        else{
        return json_encode(array(
                'status'    =>  false,
                'message'   =>  'Already in this league!',
                'leagueSave'=>true
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