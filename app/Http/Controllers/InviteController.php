<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invitation;
use Illuminate\Support\Facades\Mail;
use App\League;
use Auth;
use App\MessageSeen;
use Carbon\Carbon;
use App\User;

class InviteController extends Controller
{
    /**
     * Show the invite page for leagues
     *
     * @return \Illuminate\Http\Response
     */
    public function showInvite($id){
        $league = League::findOrFail($id);
        //Get all users that dont have invite and aren't league admin
        $users = User::where('id','!=',$league->admin_id)
        ->whereDoesntHave('invitations',function ($query) use ($league) {
            $query->where('league_id',$league->id);
        })->get();
        //All invitations
    	$invitations = Invitation::where('league_id',$league->id)->get();
    	return view('Invite.showInvite',compact('invitations','league','users','alreadySent'));
    }


    /**
     * Post route to add users to the league
     *
     * @return \Illuminate\Http\Response
     */
    public function addEmails($id, Request $request){
    
        $user = User::find($request->user_id);
    	$email = $user->email;
    	$league = League::findOrFail($id);
    	
    	//Check if invitation already exists
    	if(Invitation::generate($email,"1 day",True,$id)){
    		$temp = Invitation::where('email','=',$email)
            ->where('league_id', $id)
            ->first();
            Mail::send('Invite.invite-email', [ 'email' => $email, 'invite' => $temp, 'league' => $league], function ($m) use ($email) {
                    $m->to($email)->subject('Invitation to join league on Fantasy Enduro');
                });
            //assign user to invitation
            $temp->user_id = $user->id;
            $temp->save();
    	}
    	
        return redirect(route('invite', $league->id));
    }

    /**
     * Post route to resend email if the invitation has expired
     *
     * @return \Illuminate\Http\Response
     */
    public function resend($id,$invite){
        $invitation = Invitation::findOrFail($invite);
        $league = League::findOrFail($invitation->league_id);
        $email = $invitation->email;

        //only send if their invite has expired
        if(Invitation::status($invitation->code,$invitation->email) == 'expired'){
        Mail::send('Invite.invite-email', [ 'email' => $email, 'invite' => $invitation, 'league' => $league], function ($m) use ($email) {
                    $m->to($email)->subject('Invitation to join league on Fantasy Enduro');
                });
        //Set invitation to unexpire in 2 days
        Invitation::unexpire($invitation->code,$invitation->email,"1 day");
        }
        return redirect(route('invite', $league->id));
    }



    /**
     * Route to accept the league invitation
     *
     * @return \Illuminate\Http\Response
     */
    public function accept($code){
        $user = Auth::user();
        //Find invitation, make sure that it hasnt been used
        $invite = Invitation::where('code',$code)
        ->where('used',0)
        ->firstOrFail();

        $league = League::find($invite->league_id);

        Invitation::used($code,$invite->email);
        Invitation::unexpire($code,$invite->email,$invite->expiration);

        //Check if user is already in the league
        $userInLeagueCheck = count($league->users()->where('id',$user->id)->get());
        
        //if they arent in the league, add them
        if($userInLeagueCheck == 0){
        $league->users()->attach($user->id);
        $league->save();

        //create a message seen for them
        $messageSeen = MessageSeen::create([
            'user_id' => $user->id,
            'league_id' => $league->id,
            'last_viewed'=>Carbon::now()
        ]);
    }

        return view('Invite.accept',compact('league'));
    }
}
