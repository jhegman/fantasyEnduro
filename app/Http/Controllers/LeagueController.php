<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Race;
use App\Racer;
use App\League;
use App\User;
use App\Invitation;
use App\ChatMessage;
use App\MessageSeen;
use Carbon\Carbon;
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
    	$currentUser = Auth::user();
        $league = League::findOrFail($id);
        $unread = MessageSeen::where('user_id',$currentUser->id)
        ->where('league_id',$league->id)
        ->first();

    	$users = $league->users;
        $users = $users->sortByDesc('points');
        
        foreach ($users as $key => $user) {
            $points[$key] = $user->points()->paginate(4);
        }

        $messages = ChatMessage::where('league_id', $id)
        ->orderBy('id','desc')
        ->take(50)
        ->get()
        ->reverse();

        $ids = [];
        $names = [];
        $messageCount =  0;
        foreach ($messages as $key => $message) {
            $ids[$key] = $message->user_id;
            $names[$key] = User::findOrFail($ids[$key]);
            if($unread!=null){
            if($unread->last_viewed < $message->created_at){
                if($message->user_id != $currentUser->id){
                    $messageCount++;
                }
            }
        }
    }

        //Check if current user is in league for Leave League button
        $userInLeagueCheck = count($league->users()->where('id',$currentUser->id)->get());

        //check if admin and if private league
        $leagueAdmin = false;
        if($league->admin_id == $currentUser->id && $league->private){
            $leagueAdmin = true;
        }
        
    	return view('league.showLeague',compact('league','users','userInLeagueCheck','messages','names','currentUser','points','messageCount','leagueAdmin'));
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
        if($request->private =='yes'){
            $newLeague->private = true;
        }
        $newLeague->admin_id = $user->id;
        $newLeague->save();
        $newLeague->users()->attach($user->id);
        $messageSeen = MessageSeen::create([
            'user_id' => $user->id,
            'league_id' => $newLeague->id,
            'last_viewed'=>Carbon::now()
        ]);

        return view('league.league-created',compact('newLeague'));

    }

    //Allow user to join league
    public function joinLeague(Request $request)
    {
        $user = Auth::user();
        $id = $request->league;
        $league = League::find($id);
        $userInLeagueCheck = $league->users()->where('id',$user->id)->get();
        
        //add user to league
        $league->users()->attach($user->id);
        $league->save();
        $messageSeen = MessageSeen::create([
        'user_id' => $user->id,
        'league_id' => $league->id,
        'last_viewed'=>Carbon::now()
        ]);

        
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

        //find message seen row and delete
        $deleteRow = MessageSeen::where('user_id',$user->id)
        ->where('league_id',$id)
        ->first()
        ->delete();

        //delete their invitation when they leave
        $invitation = Invitation::where('user_id',$user->id)
        ->where('league_id',$id)
        ->first();

        //remove member from league
        $league = League::find($id);
        $league->users()->detach($user->id);
        $league->save();

        //if invitation exists
        if($invitation !=null){
            $invitation->delete();
        }
        
        return json_encode(array(
                'status'    =>  true,
                'message'   =>  'League Left'
            ));
    }

    //Update MessageSent time
    public function messageSeen(Request $request){
        $user_id = Auth::user()->id;
        $league_id = $request->league_id;
        $update = MessageSeen::where('user_id',$user_id)
        ->where('league_id',$league_id)
        ->first();

        $update->last_viewed = Carbon::now();
        $update->save();

        return response()->json(['response' => 'This is post method']);

    }
}
