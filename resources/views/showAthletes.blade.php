@extends('layouts.app')

@section('content')
<div class="container">
    <div class=col-md-2>
    @if ($athlete->photo_url!= null)
    <img src = "{{ $athlete->photo_url }}" alt="{{ $athlete->name }}" class="img-circle">
    @else
    <img src = "/img/placeholder_athlete.jpg" alt="placeholder" class="img-circle">
    @endif
    </div>

    <div class=col-md-4>
    <h1>{{ $athlete->name }}</h1>
    <h2>{{ $athlete->gender }}</h2>
    
    @if ($athlete->bike_team!= null)
    <h2>{{ $athlete->bike_team }}</h2>
    @endif
    </div>
    
    <div class="col-md-4">
	   <h2>Race Wins: {{ $racesWon }}</h2>
       @if ($racesWon > 0)
       @foreach ($athleteData as $win)
       <p><a href="{{ url('/results')}}/{{$win->id}}">{{ $win->name }}, {{ $win->location }}</a></p>
       @endforeach
       @endif

       <h2>Stage Wins: {{ $stageWins }}</h2>
    </div>
    
</div>
@endsection