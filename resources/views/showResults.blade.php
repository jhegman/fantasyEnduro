@extends('layouts.app')

@section('content')
<div class="container">
<h1>{{$race->name}} , {{$race->location}}</h1>
<div class="table-responsive">
<table class="table table-hover">
<tbody>
<tr>
<td>Name</td>
<td>Overall Place</td>
@for ($i = 1; $i< $numStages; $i++)
<td>Stage {{$i}} Time</td>
<td>Stage {{$i}} Place</td>
@endfor
</tr>
@foreach($racers as $racer)
<tr>
<td><a href="http://fantasyenduro.dev/athletes/{{$racer->id}}">{{ $racer->name }}</td></a>
<td>{{ $racer->pivot->overall_place }}</td>
<td>{{ $racer->pivot->stage_1_time }}</td> 
<td>{{ $racer->pivot->stage_1_place }}</td>
<td>{{ $racer->pivot->stage_2_time }}</td> 
<td>{{ $racer->pivot->stage_2_place }}</td> 
<td>{{ $racer->pivot->stage_3_time }}</td> 
<td>{{ $racer->pivot->stage_3_place }}</td> 
<td>{{ $racer->pivot->stage_4_time }}</td> 
<td>{{ $racer->pivot->stage_4_place }}</td>
<td>{{ $racer->pivot->stage_5_time }}</td> 
<td>{{ $racer->pivot->stage_5_place }}</td>
<td>{{ $racer->pivot->stage_6_time }}</td> 
<td>{{ $racer->pivot->stage_6_place }}</td>
@if( $racer->pivot->stage_7_time != null)
<td>{{ $racer->pivot->stage_7_time }}</td> 
<td>{{ $racer->pivot->stage_7_place }}</td>       
@endif
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
@endsection