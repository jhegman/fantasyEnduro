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

class UserSettingsController extends Controller
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

    /**
       * Profile settings to change pic and username
       *
       *@return \Illuminate\Http\Response
    */
    public function profileSettings(Request $request, FormBuilder $formBuilder)
    {

        if ($request->hasFile('image')){

            $this->validate($request, [
            'image' =>'mimes:jpeg,jpg,png,gif',

            ]);

            $avatar = $request->file('image');
            
            $fileName = time(). '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300,300)->save( public_path('uploads/avatar/' . $fileName));

            $user = Auth::user();
            $user->avatar = $fileName;
            $user->save();
        }
        $user = Auth::user();
        return view('profile-settings')->with('user',$user);
    }

    /**
     * Change User Name
     *
     * @return \Illuminate\Http\Response
     */
    public function UserNameChanged(Request $request)
    {
        //validate name
        $this->validate($request, [
            'name' =>'unique:users|min:3|required|regex:/(^[A-Za-z0-9 ]+$)+/',

            ]);
        //Get New User Name
        $new_user_name = $request->name;
        //Get User
        $user = Auth::user();
        //Set user name to new username
        $user->name = $new_user_name;
        $user->save();
        return view('username-changed')->with('user', $user);
    }

    public function unsubscribe(Request $request){

        $user = Auth::user();
        $checked = $request->send_emails;
        if($checked != null){
            $user->subscribed = true;
            $user->save();
        }
        else{
            $user->subscribed = false;
            $user->save();
        }

        return view('user.unsubscribe');
    }
}
