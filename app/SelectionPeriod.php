<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SelectionPeriod extends Model
{
    /**
     * Tell if selection is open
     *
     * @return boolean $isOpen
     */
    public static function open($week){
    	$isOpen = true;
        //get current time
        $now = Carbon::now();
        $period = SelectionPeriod::where('week',$week)->first();
        $closed = Carbon::parse($period->closed);
        $reopen = Carbon::parse($period->reopen);
        //If between two times then selection is closed
        if($now->gt($closed) && $now->lt($reopen)){
            $isOpen = false;
        }
        return $isOpen;
    }
}
