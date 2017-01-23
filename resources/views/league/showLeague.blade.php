@extends('layouts.app')

@section('content')
<div class="container">
    <transition name="fade">
			<div class="alert container set-linup-noty" :save-message="saveMessage" v-bind:class="[saveStatus ? 'alert-success' : 'alert-danger']" @click="closeNoty" v-if="showNoty" role="alert">@{{saveMessage}}</div>
	</transition>
    <h1>{{ $league->name }}</h1>
    <table>
	<tbody>
	@foreach($users as $user)
	<tr>
    <td>
    {{$user->name}}
    </td>
	</tr>
	@endforeach
	</tbody>
	</table>
@if($userInLeagueCheck > 0)
<button class="btn-primary" @click="leaveLeague({{$league->id}})" v-if="showLeagueSave[{{$league->id}}] === undefined">Leave league</button>
    		<span v-if="showLeagueSave[{{$league->id}}] === true" v-cloak>
    		<a href="{{ url('/leagues')}}"> Back to Leagues Page</a>
    		</span>    
@endif
</div>
@endsection