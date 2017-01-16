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

            //If File alread exists apend time to end of it, else just save the file to Storage/App/races
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
        }
        return view('upload-race-complete');
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
        return view('upload-athlete')->with('form', $form);
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
            
            if (($handle = fopen(storage_path('app/athletes/' . $completeName),'r')) !== FALSE)
            {
                while (($data = fgetcsv($handle, 1000, ',')) !==FALSE)
                {
                    $athlete = new Racer();
                    $existingRacerCheck = Racer::where('name', 'LIKE', '%' . $athlete->name . '%')->first();
                    
                    if ($existingRacerCheck == null){
                    $athlete->name = $data[0] . ' ' . $data[1];
                    $athlete->gender = $data[2];
                    $athlete->save();
                    }
                    else{
                        //Do nothing
                    }
                }
                fclose($handle);
            }

            $athletes = Racer::all();
            
            
        }
        return view('upload-athlete-complete',compact('athletes'));
    }
}
