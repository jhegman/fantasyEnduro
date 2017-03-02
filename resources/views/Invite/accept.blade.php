@extends('layouts.app')

@section('content')
<div class="container main-content">
    <h1> You are now part of league: {{$league->name}} ! </h1>
    <h2>
    	<a href="{{url('/leagues',$league->id)}}">Click here to view your new league</a>
    </h2>
</div>
@endsection