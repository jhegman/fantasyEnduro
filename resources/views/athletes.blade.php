@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Athletes</h1>
    	<!-- Men's Table -->
    	<div class="col-md-6">
    		<div class="table-responsive">
    		<h2>Men</h2>
    		<table class="table table-hover">
				<tbody>
					@foreach ($athletes as $athlete)
					@if ($athlete->gender == 'Men')
						<tr>
    						<td><a href="{{ url('/athletes',$athlete->id) }}">{{ $athlete->name}}</a></td>
   				 			<td>{{ $athlete->gender }}</td>
						</tr>
					@endif
					@endforeach
				</tbody>
			</table>
			</div>
		</div>
 		
 		<!-- Women's Table -->   	
    	<div class="col-md-6">
    		<div class="table-responsive">
    		<h2>Women</h2>
    		<table class="table table-hover">
			<tbody>
				@foreach ($athletes as $athlete)
				@if ($athlete->gender == 'Women')
					<tr>
    				<td><a href="{{ url('/athletes',$athlete->id) }}">{{ $athlete->name}}</a></td>
   				 	<td>{{ $athlete->gender }}</td>
					</tr>
				@endif
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection