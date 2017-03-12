<?php

namespace App\Http\Middleware;

use Closure;
use App\League;

class CheckLeagueAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        //get league id
        $league_id = $request->route('id');
        $league = League::findOrFail($league_id);
        if($league->admin_id != $user->id || !$league->private){
            abort(404);
        }
        return $next($request);
    }
}
