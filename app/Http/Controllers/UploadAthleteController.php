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
use App\SelectionPeriod;
use App\SuperAdminOption;
use App\Lineup;
use App\ChatMessage;
use App\Events\ChatMessageWasReceived;

class UploadAthleteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('super');
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
     * Upload Times to database
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadTimes(){
        return view('upload-tools.close-lineups');
    }

    /**
     * Upload Times to database
     *
     * @return \Illuminate\Http\Response
     */
    public function storeTimes(Request $request){
            $times = Excel::load('storage/app/public/times.csv', function ($reader) {
                // Load times
            })->get();
        foreach ($times as $time) {
            $period = new SelectionPeriod;
            $period->week = $time->week;
            $period->closed = $time->close;
            $period->reopen = $time->reopen;
            $period->save();
        }
        return view('upload-tools.close-lineups');
    }
}
