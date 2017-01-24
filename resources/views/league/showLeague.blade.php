@extends('layouts.app')

@section('content')
<div class="container">
    <transition name="fade">
			<div class="alert container set-linup-noty" :save-message="saveMessage" v-bind:class="[saveStatus ? 'alert-success' : 'alert-danger']" @click="closeNoty" v-if="showNoty" role="alert" v-cloak>@{{saveMessage}}</div>
	</transition>
    <a href="{{ url('/leagues')}}"> Back to Leagues Page</a>
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
<button class="btn-primary" @click="leaveLeague({{$league->id}})" v-if="showLeagueLeft[{{$league->id}}] === undefined">Leave league</button>
    		<span v-if="showLeagueLeft[{{$league->id}}] === true" v-cloak>
    		<a href="{{ url('/leagues')}}"> Back to Leagues Page</a>
    		</span>    
@endif
@if ($userInLeagueCheck > 0)
<chat :league-id="{{$league->id}}" inline-template>
        <div>
            <hr>

            <h2>Write something to your league</h2>
            <input type="text" class="form-control" placeholder="something" required="required" v-model="newMsg" @keyup.enter="press({{$league->id}})">

            <hr>
            <h3>Messages</h3>

            <ul v-for="post in posts" v-cloak>
            <b>@{{ post.username }} says:</b> @{{ post.message }}</li>
            </ul>
        </div>
</chat>
@endif
</div>
@endsection