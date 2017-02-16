@extends('layouts.app')

@section('content')
<div class="cover-athlete">
    <div class="athlete-info">
        @if ($athlete->photo_url!= null)
            <img src = "{{ $athlete->photo_url }}" alt="{{ $athlete->name }}" class="img-circle" height="82px" width="82px">
        @else
            <img src = "/img/placeholder_athlete.jpg" alt="placeholder" class="img-circle" height="82px" width="82px">
        @endif
        <div class="athlete-name">
            <h1>{{$athlete->name}}</h1>
            <span>{{$athlete->bike_team}}</span>
        </div>
    </div>
</div>
<div class="container main-content">
    <div class="tabs-container">
        <ul class="tabs">
            <li class="athlete-links" v-bind:class="{ active: result }">
                <a v-on:click="result = true">Results</a>
            </li>
            <li class="athlete-links" v-bind:class="{ active: !result }">
                <a v-on:click="result = false">Stats</a>
            </li>
        </ul>
    </div>  
    <div class="row"> 
        <div v-if="!result" class="col-md-12 statistics" v-cloak>
	       <h2> Points this season: {{$points}}
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
        <div class="col-md-12" v-if="result" v-cloak>
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
        </div>
    </div>
</div>
@endsection