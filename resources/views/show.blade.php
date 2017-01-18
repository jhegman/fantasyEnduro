@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $athlete->name }}</h1>
    <h2>{{ $athlete->gender }}</h2>
    
    @if ($athlete->bike_team!= null)
    <h2>{{ $athlete->bike_team }}</h2>
    @endif
    
    @if ($athlete->photo_url!= null)
    <img src = "{{ $athlete->photo_url }}" alt="{{ $athlete->name }}">
    @endif
	
	<p>Races Won: {{ $racesWon }}</p>
	<p>Stage Wins: {{ $stageWins }}</p>
</div>
@endsection