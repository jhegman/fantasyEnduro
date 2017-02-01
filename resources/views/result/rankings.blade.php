@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<ul>
				@foreach($overallRankings as $key => $overallRanking)
					<li>
					{{$key+1}}. <a href="{{ url('/user',$overallRanking->name) }}">{{$overallRanking->name}}</a> Score: {{$overallRanking->points}}
					</li>
				@endforeach
			</ul>
		</div>
	</div>
</div>
@endsection