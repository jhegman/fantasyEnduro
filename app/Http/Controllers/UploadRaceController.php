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

class UploadRaceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['super', 'auth']);
    }

    /**
     * Upload Race
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadRace()
    {
        return view('upload-tools.upload-race');
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

            //
            if($request->gender == 'Men'){
            $pointslist = Excel::load('public/points_ews_men.csv', function ($reader) {
                // Load mens points list
            })->get();
            }
            
            else{
            $pointslist = Excel::load('public/points_ews_women.csv', function ($reader) {
                // Load womens points list
            })->get();   
            
            }   

            //Create New Race
            $race = new Race;
            $race->name = $request->race_name;
            $race->location = $request->race_location;
            $race->gender = $request->gender;
            $race->race_week = $request->week;
            $race->save();
            //Loop through uploaded results
            foreach ($results as $key => $result) {
                $racerName = $result->name;
                //Remove whitespace from front and back of string
                $racerName = trim($racerName);
                //Remove any weird charcters from front and back
                $racerName = trim($racerName, "\xA0\xC2");
                $existingRacerCheck = Racer::where('name', 'LIKE', '%' . $racerName . '%')->first();
                
                //Build Result Array
                $resultArray = [];
                $resultArray['overall_place'] = intval(trim($result->overall_place, '()'));
                $resultArray['week'] = $request->week;
                $resultArray['points'] = intval($pointslist[intval($result->overall_place)-1]->points);
                for ($i=1; $i < $request->number_stages + 1; $i++) { 
                    $resultArray['stage_' . $i . '_time'] = $result->{'stage_' . $i . '_time'};
                    $resultArray['stage_' . $i . '_place'] = intval(trim($result->{'stage_' . $i . '_place'}, '()'));
                }

                //If Racer doesn't already exist in the database add them, else add results to race_racers table
                if ($existingRacerCheck == null) {
                    $racer = new Racer;
                    $racer->name = $result->name;
                    $racer->gender = $request->gender;
                    $racer->points = intval($pointslist[intval($result->overall_place)-1]->points);
                    $racer->save();
                    $racer->races()->attach($race->id, $resultArray);
                    
                } else {
                    $existingRacerCheck->races()->attach($race->id, $resultArray);
                    $existingRacerCheck->points = intval($pointslist[intval($result->overall_place)-1]->points) + $existingRacerCheck->points;
                    $existingRacerCheck->save();
                }
            }
        }
        return view('upload-tools.upload-race-complete');
    }

}
