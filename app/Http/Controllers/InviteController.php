<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invitation;
use Illuminate\Support\Facades\Mail;
use App\League;
use Auth;
use App\MessageSeen;
use Carbon\Carbon;

class InviteController extends Controller
{
    /**
     * Show the invite page for leagues
     *
     * @return \Illuminate\Http\Response
     */
    public function showInvite($id){
    	$alreadySent = false;
    	$league = League::findOrFail($id);
    	$invitations = Invitation::where('league_id',$league->id)->get();
    	return view('Invite.showInvite',compact('invitations','league','alreadySent'));
    }


    /**
     * Post route to add users to the league
     *
     * @return \Illuminate\Http\Response
     */
    public function addEmails($id, Request $request){
    	$this->validate($request, [
            'email' => 'required|email'

            ]);

    	$email = $request->email;
    	$league = League::findOrFail($id);
    	
    	//for checking if invitation already exists
    	$alreadySent = false;
    	//Check if invitation already exists
    	if(Invitation::generate($email,"2 day",True,$id)){
    		$temp = Invitation::where('email','=',$email)
            ->where('league_id', $id)
            ->first();
            Mail::send('Invite.invite-email', [ 'email' => $email, 'invite' => $temp, 'league' => $league], function ($m) use ($email) {
                    $m->to($email)->subject('Invitation to join league on Fantasy Enduro');
                });
    	}else{
			$alreadySent = true;
    	}
    	$invitations = Invitation::where('league_id',$league->id)->get();
    	return view('Invite.showInvite',compact('invitations','league','alreadySent'));
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
        if(Invitation::status($invi->code,$invi->email) == 'expired'){
        Mail::send('Invite.invite-email', [ 'email' => $email, 'invite' => $invitation, 'league' => $league], function ($m) use ($email) {
                    $m->to($email)->subject('Invitation to join league on Fantasy Enduro');
                });
        //Set invitation to unexpire in 2 days
        Invitation::unexpire($invitation->code,$invitation->email,"2 day");
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

        $invite->user_id = $user->id;
        $invite->save();

        $league = League::find($invite->league_id);

        Invitation::used($code,$invite->email);
        Invitation::unexpire($code,$invite->email,$invite->expiration);

        //Add user to the league
        $league->users()->attach($user->id);
        $league->save();

        //create a message seen for them
        $messageSeen = MessageSeen::create([
            'user_id' => $user->id,
            'league_id' => $league->id,
            'last_viewed'=>Carbon::now()
        ]);

        return view('Invite.accept',compact('league'));
    }
}
