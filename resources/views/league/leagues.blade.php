@extends('layouts.app')

@section('content')
<div class="container">
    
    <h1>Leagues</h1>
    <div id="league-sort" class="table-responsive">
    <input class="search" placeholder="Search" />
    	<table class="table table-hover">
		<thead>
			<tr>
			<th> League Name</th>
			<th> Number of Members</th>
			</tr>
		</thead>
		<tbody class="list">
		@foreach($leagues as $league)
		<tr>
    		<td class="name">
    		<a href="{{ url('/leagues',$league->id) }}">{{$league->name}}</a>
    		</td>
   			 <td>
				{{count($league->users)}}
			</td>
    	</tr>
		@endforeach
		</tbody>
		</table>
	</div>
</div>
@endsection