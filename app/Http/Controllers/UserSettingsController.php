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
        $this->middleware('auth');
    }

    /**
    * Profile settings to change pic and username
    *
    */
    public function changeProfilePic(Request $request, FormBuilder $formBuilder)
    {
        if($request->hasFile('image')){
        $avatar = $request->file('image');
        
        $fileName = time(). '.' . $avatar->getClientOriginalExtension();
        Image::make($avatar)->resize(300,300)->save( public_path('/uploads/avatar/' . $fileName));

        $user = Auth::user();
        $user->avatar = $fileName;
        $user->save();
    }
        $form = $formBuilder->create(\App\Forms\ChangeUserNameForm::class, [
            'method' => 'POST',
            'url' => route('username-changed')
        ]);
        $user = Auth::user();
        $av = $request->file();
        return view('profile-settings',compact('user','form'));
    }

    /**
     * Change User Name Form
     *
     * @return \Illuminate\Http\Response
     */
    public function profileSettings(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(\App\Forms\ChangeUserNameForm::class, [
            'method' => 'POST',
            'url' => route('username-changed')
        ]);
        $user = Auth::user();
        return view('profile-settings')->with('form', $form)->with('user',$user);
    }

    /**
     * Change User Name
     *
     * @return \Illuminate\Http\Response
     */
    public function UserNameChanged(Request $request)
    {
        //Get New User Name
        $new_user_name = $request->edit_your_username;
        //Get User
        $user = Auth::user();
        //Set user name to new username
        $user->name = $new_user_name;
        $user->save();
        return view('username-changed')->with('user', $user);
    }
}
