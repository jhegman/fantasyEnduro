<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Storage;
use Excel;
use App\Race;
use App\Racer;

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
        return view('home');
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
        return view('upload-race')->with('form', $form);
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
            $race->save();
            //Loop through uploaded results
            foreach ($results as $key => $result) {
                $existingRacerCheck = Racer::where('name', 'LIKE', '%' . $result->athlete . '%')->first();
                //If Racer doesn't already exist in the database add them, else add results to race_racers table
                if ($existingRacerCheck == null) {
                    $racer = new Racer;
                    $racer->name = $result->athlete;
                    $racer->gender = 'male';
                    $racer->save();
                    $racer->getRacersRace()->attach($race->id, [
                        'overall_place' =>  intval(trim($result->final_rank, '()')),
                        'stage_1_time'  =>  $result->stage_1,
                        'stage_1_place' =>  intval(trim($result->stage_1_rank, '()')),
                        'stage_2_time'  =>  $result->stage_2,
                        'stage_2_place' =>  intval(trim($result->stage_2_rank, '()')),
                        'stage_3_time'  =>  $result->stage_3,
                        'stage_3_place' =>  intval(trim($result->stage_3_rank, '()')),
                        'stage_4_time'  =>  $result->stage_4,
                        'stage_4_place' =>  intval(trim($result->stage_4_rank, '()')),
                        'stage_5_time'  =>  $result->stage_5,
                        'stage_5_place' =>  intval(trim($result->stage_5_rank, '()')),
                        'stage_6_time'  =>  $result->stage_6,
                        'stage_6_place' =>  intval(trim($result->stage_6_rank, '()')),
                    ]);
                } else {
                    $existingRacerCheck->getRacersRace()->attach($race->id, [
                        'overall_place' =>  intval(trim($result->final_rank, '()')),
                        'stage_1_time'  =>  $result->stage_1,
                        'stage_1_place' =>  intval(trim($result->stage_1_rank, '()')),
                        'stage_2_time'  =>  $result->stage_2,
                        'stage_2_place' =>  intval(trim($result->stage_2_rank, '()')),
                        'stage_3_time'  =>  $result->stage_3,
                        'stage_3_place' =>  intval(trim($result->stage_3_rank, '()')),
                        'stage_4_time'  =>  $result->stage_4,
                        'stage_4_place' =>  intval(trim($result->stage_4_rank, '()')),
                        'stage_5_time'  =>  $result->stage_5,
                        'stage_5_place' =>  intval(trim($result->stage_5_rank, '()')),
                        'stage_6_time'  =>  $result->stage_6,
                        'stage_6_place' =>  intval(trim($result->stage_6_rank, '()')),
                    ]);
                }
            }
        }
        return view('upload-race-complete');
    }
}
