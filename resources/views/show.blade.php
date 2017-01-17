@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $athlete->name }}</h1>
    <h2>{{ $athlete->gender }}</h2>
    @if ($athlete->bike_team!=" ")
    <h2>{{ $athlete->bike_team }}</h2>
    @endif
</div>
@endsection