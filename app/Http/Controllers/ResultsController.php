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

class ResultsController extends Controller
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
        $racers = Race::findOrFail($id)->racers()->get();
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
}
