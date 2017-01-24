<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Storage;
use Excel;
use App\Race;
use App\Racer;
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

    /**
     * Change User Name Form
     *
     * @return \Illuminate\Http\Response
     */
    public function changeUserName(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(\App\Forms\ChangeUserNameForm::class, [
            'method' => 'POST',
            'url' => route('username-changed')
        ]);
        $user = Auth::user();
        return view('change-username')->with('form', $form)->with('user',$user);
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

    /**
     * Upload Race
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadRace(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(\App\Forms\UploadForm::class, [
            'method' => 'POST',
            'url' => route('upload-race-complete')
        ]);
        return view('upload-tools.upload-race')->with('form', $form);
    }

    /**
     * Upload Race Completed/Process Race
     *
     * @return \Illuminate\Http\Response
     */
    public function storeRace(Request $request)
    {
        if ($request->hasFile('race_upload') && $request->file('race_upload')->isValid()) {
            $fileName = $request->file('race_upload')->getClientOriginalName();
            $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $fileName);
            $fileExtension = substr(strrchr($fileName, '.'), 1);

            //If File already exists apend time to end of it, else just save the file to Storage/App/races
            if (Storage::disk('local')->exists('races/' . $fileName)) {
                $completeName = $withoutExt . time() . '.' . $fileExtension;
                $path = $request->file('race_upload')->storeAs('races', $completeName, 'local');
            } else {
                $completeName = $fileName;
                $path = $request->file('race_upload')->storeAs('races', $fileName, 'local');
            }
            $results = Excel::load('storage/app/races/' . $completeName, function ($reader) {
                // Getting all results
            })->get();

            //Create New Race
            $race = new Race;
            $race->name = $request->race_name;
            $race->location = $request->race_location;
            $race->gender = $request->gender;
            $race->save();
            //Loop through uploaded results
            foreach ($results as $key => $result) {
                $racerName = $result->name;
                //Remove whitespace from front and back of string
                $racerName = trim($racerName);
                //Remove any weird charcters from front and back
                $racerName = trim($racerName, "\xA0\xC2");
                $existingRacerCheck = Racer::where('name', 'LIKE', '%' . $racerName . '%')->first();
                //If Racer doesn't already exist in the database add them, else add results to race_racers table
                if ($existingRacerCheck == null) {
                    $racer = new Racer;
                    $racer->name = $result->name;
                    $racer->gender = $request->gender;
                    $racer->save();
                    $racer->getRacersRace()->attach($race->id, [
                        'overall_place' =>  intval(trim($result->overall_place, '()')),
                        'stage_1_time'  =>  $result->stage_1_time,
                        'stage_1_place' =>  intval(trim($result->stage_1_place, '()')),
                        'stage_2_time'  =>  $result->stage_2_time,
                        'stage_2_place' =>  intval(trim($result->stage_2_place, '()')),
                        'stage_3_time'  =>  $result->stage_3_time,
                        'stage_3_place' =>  intval(trim($result->stage_3_place, '()')),
                        'stage_4_time'  =>  $result->stage_4_time,
                        'stage_4_place' =>  intval(trim($result->stage_4_place, '()')),
                        'stage_5_time'  =>  $result->stage_5_time,
                        'stage_5_place' =>  intval(trim($result->stage_5_place, '()')),
                        'stage_6_time'  =>  $result->stage_6_time,
                        'stage_6_place' =>  intval(trim($result->stage_6_place, '()')),
                    ]);
                } else {
                    $existingRacerCheck->getRacersRace()->attach($race->id, [
                        'overall_place' =>  intval(trim($result->overall_place, '()')),
                        'stage_1_time'  =>  $result->stage_1_time,
                        'stage_1_place' =>  intval(trim($result->stage_1_place, '()')),
                        'stage_2_time'  =>  $result->stage_2_time,
                        'stage_2_place' =>  intval(trim($result->stage_2_place, '()')),
                        'stage_3_time'  =>  $result->stage_3_time,
                        'stage_3_place' =>  intval(trim($result->stage_3_place, '()')),
                        'stage_4_time'  =>  $result->stage_4_time,
                        'stage_4_place' =>  intval(trim($result->stage_4_place, '()')),
                        'stage_5_time'  =>  $result->stage_5_time,
                        'stage_5_place' =>  intval(trim($result->stage_5_place, '()')),
                        'stage_6_time'  =>  $result->stage_6_time,
                        'stage_6_place' =>  intval(trim($result->stage_6_place, '()')),
                    ]);
                }
            }
        }
        return view('upload-tools.upload-race-complete');
    }

    /**
     * Upload Athletes
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadAthlete(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(\App\Forms\UploadFormAthlete::class, [
            'method' => 'POST',
            'url' => route('upload-athlete-complete')
        ]);
        return view('upload-tools.upload-athlete')->with('form', $form);
    }

     /**
     * Upload Race Completed/Process Race
     *
     * @return \Illuminate\Http\Response
     */
    public function storeAthlete(Request $request)
    {
        if ($request->hasFile('race_upload') && $request->file('race_upload')->isValid()) {
            $fileName = $request->file('race_upload')->getClientOriginalName();
            $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $fileName);
            $fileExtension = substr(strrchr($fileName, '.'), 1);

            //If File alread exists apend time to end of it, else just save the file to Storage/App/races
            if (Storage::disk('local')->exists('athletes/' . $fileName)) {
                $completeName = $withoutExt . time() . '.' . $fileExtension;
                $path = $request->file('race_upload')->storeAs('athletes', $completeName, 'local');
            } else {
                $completeName = $fileName;
                $path = $request->file('race_upload')->storeAs('athletes', $fileName, 'local');
            }
            
            if (($handle = fopen(storage_path('app/athletes/' . $completeName), 'r')) !== false) {
                while (($data = fgetcsv($handle, 1000, ',')) !==false) {
                    $athlete = new Racer();
                    $athleteName = $data[1] . ' ' . $data[0];
                    //Remove whitespace from front and back of string
                    $athleteName = trim($athleteName);
                    //Remove any weird charcters from front and back
                    $athleteName = trim($athleteName, "\xA0\xC2");
                    //Remove U21 or Master from the gender
                    $gender = str_replace(array(' U21', ' Master'), '', $data[2]);
                    $existingRacerCheck = Racer::where('name', 'LIKE', '%' . $athleteName . '%')->first();
                    
                    if ($existingRacerCheck == null) {
                        $athlete->name = $athleteName;
                        $athlete->gender = $gender;
                        if ($data[3]!=" ") {
                            $athlete->bike_team = $data[3];
                        }
                        if ($data[4]!=" ") {
                            $athlete->photo_url = $data[4];
                        }
                        $athlete->save();
                    } else {
                        //Do nothing
                    }
                }
                fclose($handle);
            }

            $athletes = Racer::all();
        }
        return view('upload-tools.upload-athlete-complete', compact('athletes'));
    }

    /**
     * [setLineupMen returns page where user can set their lineup]
     * @return view
     */
    public function setLineupMen()
    {
        return view('set-lineup.set-lineup-men');
    }

    /**
     * [setLineupWomen returns page where user can set their lineup]
     * @return view
     */
    public function setLineupWomen()
    {
        return view('set-lineup.set-lineup-women');
    }

    /**
     * AJAX function to get users lineup
     * @param  Request $request [description]
     * @return [ARRAY] [
     *         athletes => Array of all the athletes minus the ones in your lineup
     *         yourLineup => Array of all the races in current users lineup
     * ]
     */
    public function getUsersLineup(Request $request)
    {
        $path = $request->path;
        $currentUser = Auth::id();
        $week = SuperAdminOption::where('option_name', 'week')->first()->option_value;
        $returnArray = array();
        $yourLineupRacers = array();
        //Men's lineup
        if ($path == '/set-lineup/men') {
            $yourLineup = Lineup::where('gender', 'Men')
            ->where('user_id', $currentUser)
            ->where('week', $week)
            ->get();
            $yourLineupRacerIDs = array();
            //Create array of id's from your lineup
            foreach ($yourLineup as $lineup) {
                $yourLineupRacerIDs[] = $lineup->racer()->first()->id;
            }
            $athletes = Racer::where('gender', 'Men')
            ->whereNotIn('id', $yourLineupRacerIDs)
            ->orderBy('name', 'ASC')->get();
        } elseif ($path == '/set-lineup/women') {
            $yourLineup = Lineup::where('gender', 'Women')
            ->where('user_id', $currentUser)
            ->where('week', $week)
            ->get();
            $yourLineupRacerIDs = array();
            //Create array of id's from your lineup
            foreach ($yourLineup as $lineup) {
                $yourLineupRacerIDs[] = $lineup->racer()->first()->id;
            }
            $athletes = Racer::where('gender', 'Women')
            ->whereNotIn('id', $yourLineupRacerIDs)
            ->orderBy('name', 'ASC')->get();
        }
        foreach ($yourLineup as $yourLineupRacer) {
            $yourLineupRacers[] = $yourLineupRacer->racer()->first();
        }

        $returnArray['athletes'] = $athletes;
        $returnArray['yourLineup'] = $yourLineupRacers;
        return json_encode($returnArray);
    }

    //Display Page With All results
    public function results()
    {
        $races = Race::all();
        return view('result.results', compact('races'));
    }

    //Display Individual Results
    public function showResults($id)
    {
        //Get All Racers in Race
        $racers = Race::findOrFail($id)->getRaceRacers()->get();
        $race = Race::findOrFail($id);
        
        //Check first racer to tell how many stages there were
        //Probably cleaner way to check this
        $numStages = 8;
        if (empty($racers[0]->pivot->stage_7_time) == 1) {
            $numStages = 7;
        }
        if (empty($racers[0]->pivot->stage_6_time) == 1) {
            $numStages = 6;
        }
        
        return view('result.showResults', compact('racers', 'numStages', 'race'));
    }

    /**
     * AJAX function for saving your lineup
     * @param  Request $request
     * @return [ARRAY] [
     *         status => Status of save
     *         message => Message for notificaiton
     * ]
     */
    public function saveUsersLineup(Request $request)
    {
        $lineup = $request->lineup;
        $path = $request->path;
        if ($path == '/set-lineup/men') {
            $gender = 'Men';
        } else {
            $gender = 'Women';
        }
        $currentUser = Auth::id();
        $week = SuperAdminOption::where('option_name', 'week')->first()->option_value;

        for ($i=0; $i < 5; $i++) {
            $lineupRecord = Lineup::where('week', $week)
            ->where('user_id', $currentUser)
            ->where('lineup_position', $i + 1)
            ->where('gender', $gender)
            ->first();
            if ($lineupRecord != null) {
                if (array_key_exists($i, $lineup)) {
                    $lineupRecord->racer_id = $lineup[$i]['id'];
                    $lineupRecord->save();
                } else {
                    $lineupRecord->delete();
                }
            } elseif (array_key_exists($i, $lineup)) {
                $newRecord = new Lineup;
                $newRecord->user_id = $currentUser;
                $newRecord->week = $week;
                $newRecord->racer_id = $lineup[$i]['id'];
                $newRecord->lineup_position = $i + 1;
                $newRecord->gender = $gender;
                $newRecord->save();
            }
        }

        if (count($lineup) <= 5) {
            return json_encode(array(
                'status'    =>  true,
                'message'   =>  'Lineup Saved Succesfully'
            ));
        } else {
            return json_encode(array(
                'status'    =>  false,
                'message'   =>  'Limit of 5 racers in your lineup. Only first 5 saved'
            ));
        }
    }
}
