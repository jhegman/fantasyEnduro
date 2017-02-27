<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Storage;
use Excel;
use App\Race;
use App\Racer;
use Image;
use Auth;
use Log;
use Route;
use App\MessageSeen;
use App\SuperAdminOption;
use App\Lineup;
use App\ChatMessage;
use App\Events\ChatMessageWasReceived;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $leagueMessages = [];
        $messageCount = 0;

        foreach ($user->leagues as $key => $league) {
        $unread = MessageSeen::where('user_id',$user->id)
        ->where('league_id',$league->id)
        ->first();

        $messages = ChatMessage::where('league_id', $league->id)
        ->orderBy('id','desc')
        ->take(50)
        ->get()
        ->reverse();
        
        foreach ($messages as $message) {
        if($unread!=null){
            if($unread->last_viewed < $message->created_at){
                if($message->user_id != $user->id){
                    $messageCount++;
                    }
                }
            }
        }//inner for loop
        $leagueMessages[$key] = $messageCount;
    }//outer for loop
        return view('home')->with('user',$user)->with('leagueMessages',$leagueMessages);
    }

    public function message(Request $request)
    {
        $user = Auth::user();
        $league_id = $request->league_id;

        Log::debug($request);

        $message = ChatMessage::create([
            'user_id' => $user->id,
            'message' => $request->message,
            'league_id'=>$league_id
        ]);

        event(new ChatMessageWasReceived($message, $user, $league_id));
    }
}
