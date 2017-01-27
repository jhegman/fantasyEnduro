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
        return view('home')->with('user',$user);
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
