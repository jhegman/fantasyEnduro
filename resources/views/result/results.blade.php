@extends('layouts.app')

@section('content')
<div class="container main-content">
    <h1>Results</h1>
    <div class="flex-row">
    	@foreach($races as $race)
    		<a href="{{ url('/results',$race->id) }}" class="card col-md-4 col-sm-6 col-xs-12">
    			<div class="card-wrap">
    				<div class="card-title">
    					<h3>{{ $race->name }}, {{ $race->location }}</h3>
    				</div><!-- /.card-title -->
    				<div class="card-content">
    					@php
    						$racers = $race->racers()->get();
    					@endphp
    					@if (count($racers) !== 0)
    						<ul class="top-three">
    							@for ($i = 0; $i < 3; $i++)
    								<li>
    									@if ($racers[$i]->photo_url !== null)
    										<div class="head-shot" style="background-image: url({{$racers[$i]->photo_url}})"></div><!-- /.headshot -->
    									@else
    										<div class="head-shot" style="background-image: url({{asset('img/placeholder_athlete.jpg')}})"></div><!-- /.headshot -->
    									@endif
    									<span class="racer-name">{{$racers[$i]->name}}</span>
    								</li>
    							@endfor
    						</ul>
    					@endif
    				</div><!-- /.card-content -->
    				<span class="card-btn btn-primary">Full Results</span><!-- /.card-bton -->
    			</div><!-- /.card-wrap -->
    		</a><!-- /.card -->
    	@endforeach
    </div><!-- /.flex-row -->
</div>
@endsection