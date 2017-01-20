@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Athletes</h1>
    	<!-- Men's Table -->
    	<div class="col-md-6">
    		<div id="men-sort" class="table-responsive">
    		<h2>Men</h2>
    		<!-- class="search" automagically makes an input a search field. -->
  			<input class="search" placeholder="Search" />
			<!-- class="sort" automagically makes an element a sort buttons. The date-sort value decides what to sort by. -->
  			<button class="sort" data-sort="name">
    			Sort
  			</button>
    		<table class="table table-hover">
				<thead>
						<tr>
						<th> Name </th>
						<th> Gender </th>
						</tr>
				</thead>
				<tbody class="list">	
					@foreach ($athletes as $athlete)
					@if ($athlete->gender == 'Men')
						<tr>
    						<td class="name"><a href="{{ url('/athletes',$athlete->id) }}">{{ $athlete->name}}</a></td>
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
    		<div id="women-sort" class="table-responsive">
    		<h2>Women</h2>
    		<!-- class="search" automagically makes an input a search field. -->
  			<input class="search" placeholder="Search" />
			<!-- class="sort" automagically makes an element a sort buttons. The date-sort value decides what to sort by. -->
  			<button class="sort" data-sort="name">
    			Sort
  			</button>
    		<table class="table table-hover">
			<thead>
						<tr>
						<th> Name </th>
						<th> Gender </th>
						</tr>
			</thead>
			<tbody class="list">
				@foreach ($athletes as $athlete)
				@if ($athlete->gender == 'Women')
					<tr>
    				<td class="name"><a href="{{ url('/athletes',$athlete->id) }}">{{ $athlete->name}}</a></td>
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