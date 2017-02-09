@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-4">
			<h2> Top Players </h2>
				<div class="rider-container">
					<div class="rankings-top">
						<div class="rank-top">
							RK
						</div>
						<div class="rider-top">
							Player
						</div>
					</div>
					@foreach($overallRankings as $key => $overallRanking)
						@if($key == 0)
							<div class="rankings-first">
						@else
							<div class="rankings">
						@endif
								<div class="rank">
									{{$key+1}}
								</div>
								<div class="rider">
									<span>
										<img src = "{{ url('/uploads/avatar',$overallRanking->avatar) }}" class="img-circle" height="20px" width="20px">
									</span>
									<a href="{{ url('/user',$overallRanking->name) }}">{{$overallRanking->name}}</a> 
									<span class="score">
										Score: {{$overallRanking->points}}
									</span>
								</div>
							</div>
					@endforeach
				</div>
		</div>
		<!-- TOP MALE RACERS -->
		<div class="col-md-4">
			<h2> Top Male Racers </h2>
				<div class="rider-container">
					<div class="rankings-top">
						<div class="rank-top">
							RK
						</div>
						<div class="rider-top">
							Rider
						</div>
					</div>
					@foreach($topMen as $key => $men)
						@if($key == 0)
							<div class="rankings-first">
						@else
							<div class="rankings">
						@endif
								<div class="rank">
									{{$key+1}}
								</div>
								<div class="rider">
									<span>
										@if($men->photo_url!= null)
										<img src = "{{ $men->photo_url }}" class="img-circle" height="20px" width="20px">
										@else
										<img src = "/img/placeholder_athlete.jpg" class="img-circle" height="20px" width="20px">
										@endif
									</span>
									<a href="{{ url('/athletes',$men->id) }}">{{$men->name}}</a> 
									<span class="score">
										Score: {{$men->points}}
									</span>
								</div>
							</div>
					@endforeach
				</div>
		</div>
		<!-- TOP FEMALE RACERS -->
		<div class="col-md-4">
			<h2> Top Female Racers </h2>
				<div class="rider-container">
					<div class="rankings-top">
						<div class="rank-top">
							RK
						</div>
						<div class="rider-top">
							Rider
						</div>
					</div>
					@foreach($topWomen as $key => $women)
						@if($key == 0)
							<div class="rankings-first">
						@else
							<div class="rankings">
						@endif
								<div class="rank">
									{{$key+1}}
								</div>
								<div class="rider">
									<span>
										@if($women->photo_url!= null)
										<img src = "{{ $women->photo_url }}" class="img-circle" height="20px" width="20px">
										@else
										<img src = "/img/placeholder_athlete.jpg" class="img-circle" height="20px" width="20px">
										@endif
									</span>
									<a href="{{ url('/athletes',$women->id) }}">{{$women->name}}</a> 
									<span class="score">
										Score: {{$women->points}}
									</span>
								</div>
							</div>
					@endforeach
				</div>
		</div>
	</div>
</div>
@endsection