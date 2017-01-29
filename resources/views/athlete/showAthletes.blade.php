@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-2">
            @if ($athlete->photo_url!= null)
                <img src = "{{ $athlete->photo_url }}" alt="{{ $athlete->name }}" class="img-circle">
            @else
                <img src = "/img/placeholder_athlete.jpg" alt="placeholder" class="img-circle">
            @endif
        </div>
        <div class="col-md-4">
            <h1>{{ $athlete->name }}</h1>
            <h2>{{ $athlete->gender }}</h2>
            @if ($athlete->bike_team!= null)
                <h2>{{ $athlete->bike_team }}</h2>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button class="button-results" v-on:click="result = true">Results</button>
            <button class="button-results" v-on:click="result = !result">Statistics</button>
        </div>
    </div>
    <div class="row"> 
        <div v-if="!result" class="col-md-6 statistics" v-cloak>
	       <h2>Race Wins: {{ $racesWon }}</h2>
            @if ($racesWon > 0)
                @foreach ($athleteData as $win)
                    <p>
                        <a href="{{ url('/results')}}/{{$win->id}}">{{ $win->name }}, {{ $win->location }}</a>
                    </p>
                @endforeach
            @endif
            <h2>Stage Wins: {{ $stageWins }}</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6" v-if="result" v-cloak>
           <table class="table race-results">
                <thead>
                    <tr>
                        <th> Race</th>
                        <th> Rank</th>
                        <th> Race Points</th>
                    </tr>
                </thead>
            <tbody>
            @foreach ($result as $race)
                <tr>
                    <td>
                        <a href="{{ url('/results')}}/{{$race->id}}">{{$race->name}},{{$race->location}}</a>
                    </td>
                    <td>
                        {{$race->pivot->overall_place}}
                    </td>
                    <td>
                        {{$race->pivot->points}}
                    </td>
                <tr>
            @endforeach
            </tbody>
            </table> 
           </ul>
        </div>
    </div>
</div>
@endsection