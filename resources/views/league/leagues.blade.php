@extends('layouts.app')

@section('content')
<div class="container">
   	<transition name="fade">
			<div class="alert container set-linup-noty" :save-message="saveMessage" v-bind:class="[saveStatus ? 'alert-success' : 'alert-danger']" @click="closeNoty" v-if="showNoty" role="alert">@{{saveMessage}}</div>
	</transition>
   	{!! form($form) !!}
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
		@php
		$userInLeagueCheck = $league->users()->where('id',$user->id)->get();
		@endphp
		<tr>
    		<td>
    		@if(count($userInLeagueCheck) == 0)
    		<button class="btn-primary" @click="joinLeague({{$league->id}})" v-if="showLeagueSave[{{$league->id}}] === undefined">Join League</button>
    		<span v-if="showLeagueSave[{{$league->id}}] === true" v-cloak>Joined</span>   	
    		@else
    			<span>Joined</span>
    		@endif
    		</td>
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