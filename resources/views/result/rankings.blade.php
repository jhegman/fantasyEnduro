@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-4">
			<h2> Top Players </h2>
			<ul class="overflow">
				@foreach($overallRankings as $key => $overallRanking)
					<li>
					{{$key+1}}. <a href="{{ url('/user',$overallRanking->name) }}">{{$overallRanking->name}}</a> Score: {{$overallRanking->points}}
					</li>
				@endforeach
			</ul>
		</div>
		<div class="col-md-4">
			<h2> Top Male Racers </h2>
			<ul class="overflow">
				@foreach($topMen as $key => $men)
					<li>
					{{$key+1}}. <a href="{{ url('/athletes',$men->id) }}">{{$men->name}}</a> Score: {{$men->points}}
					</li>
				@endforeach
			</ul>
		</div>
		<div class="col-md-4">
			<h2> Top Female Racers </h2>
			<ul class="overflow">
				@foreach($topWomen as $key => $women)
					<li>
					{{$key+1}}. <a href="{{ url('/athletes',$women->id) }}">{{$women->name}}</a> Score: {{$women->points}}
					</li>
				@endforeach
			</ul>
		</div>
	</div>
</div>
@endsection