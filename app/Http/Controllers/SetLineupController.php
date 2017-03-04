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
use Carbon\Carbon;
use App\SelectionPeriod;
use App\Lineup;
use App\ChatMessage;
use App\Events\ChatMessageWasReceived;

class SetLineupController extends Controller
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
     * [setLineup returns page where user can choose what gender to set lineup for]
     * @return view
     */
    public function setLineup()
    {
        return view('set-lineup.set-lineup');
    }

    /**
     * [setLineupMen returns page where user can set their lineup]
     * @return view
     */
    public function setLineupMen()
    {
        //get week
        $week = SuperAdminOption::where('option_name', 'week')->first()->option_value;
        //get current selection period
        $period = SelectionPeriod::where('week',$week)->first();
        //time in EST
        $closedEST = Carbon::parse($period->closed)->tz('EST')->format('l, n/j/y \\a\\t g:i A e');
        //Check if open
        $isOpen = SelectionPeriod::open($week);
        return view('set-lineup.set-lineup-men',compact('isOpen', 'closedEST'));
    }

    /**
     * [setLineupWomen returns page where user can set their lineup]
     * @return view
     */
    public function setLineupWomen()
    {
        //get week
        $week = SuperAdminOption::where('option_name', 'week')->first()->option_value;
        //get current selection period
        $period = SelectionPeriod::where('week',$week)->first();
        //time in EST
        $closedEST = Carbon::parse($period->closed)->tz('EST')->format('l, n/j/y \\a\\t g:i A e');
        //Check if open
        $isOpen = SelectionPeriod::open($week);
        return view('set-lineup.set-lineup-women',compact('isOpen', 'closedEST'));
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
        //Check to see if selection is open
        $week = SuperAdminOption::where('option_name', 'week')->first()->option_value;
        
        if(!SelectionPeriod::open($week)){
            return json_encode(array(
                'status'    =>  false,
                'message'   =>  'Selection Period Closed!'
            ));
        }
        //proceed
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

    public function getAthleteStats(Request $request)
    {
        $id = $request->id;
        $athleteObject = Racer::find($id);
        $racesWon = $athleteObject->racesWon();
        $stageWins = $athleteObject->stageWins();
        $pointsScored = $athleteObject->pointsScored();

        $returnArray = [
            'athleteObject' =>  $athleteObject,
            'racesWon'      =>  $racesWon,
            'stageWins'     =>  $stageWins,
            'pointsScored'  =>  $pointsScored
        ];

        return json_encode($returnArray);
    }
}
