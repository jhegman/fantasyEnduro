@extends('layouts.app')

@section('content')
<div class="container">
   	<transition name="fade">
			<div style= "position:fixed;" class="alert container set-linup-noty" :save-message="saveMessage" v-bind:class="[saveStatus ? 'alert-success' : 'alert-danger']" @click="closeNoty" v-if="showNoty" role="alert" v-cloak>@{{saveMessage}}</div>
	</transition>
   		<span>Create New League</span>
   			<span class="dropdown" v-if="seen" v-on:click="seen = !seen" v-cloak>
   				<i class="fa fa-minus-square-o" aria-hidden="true"></i>
   			</span>
   				<span class="dropdown" v-if="!seen" v-on:click="seen = !seen" v-cloak>
   					<i class="fa fa-plus-square-o" aria-hidden="true"></i>
   				</span>
   		<div class="newLeague" v-if="seen" v-cloak>
   			{!! Form::open(['url' => 'leagues/created']) !!}
            <div class="form-group {{$errors->has('new_league') ? 'has-error' : ''}}">
                {{ Form::label('new_league', 'League name:', ['class' => 'control-label']) }}
                {{ Form::text('new_league', null, ['class' => 'form-control']) }}
                @if ($errors->first('new_league'))
                    <span class="errors">{{ $errors->first('new_league') }}</span>
                @endif
            </div><!-- /.form-group -->

            <div class="form-group {{$errors->has('password') ? 'has-error' : ''}}">
                {{ Form::label('password', 'Password (optional)', ['class' => 'control-label']) }}
                {{ Form::password('password', ['class' => 'form-control']) }}
                @if ($errors->first('password'))
                    <span class="errors">{{ $errors->first('new_league') }}</span>
                @endif
            </div><!-- /.form-group -->
            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
        {!! Form::close() !!}
    	</div>
    	<h1>Leagues</h1>
    	<div id="league-sort" class="table-responsive">
    		<div class="search-wrap lineup-search">
            	<i class="fa fa-search" aria-hidden="true"></i>
            	<input class="search" type="text" placeholder="Search">
        	</div><!-- /.search-wrap -->
    			<table class="table table-hover">
					<thead>
						<tr>
							<th></th>
							<th> League Name</th>
							<th> Number of Members</th>
							<th> Password</th>
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
								<td>
									@if(($league->password != null) and (count($userInLeagueCheck) == 0))
										<input type="password" v-on:keyup="$data.password = $event.target.value">
									@endif
								</td>
							</tr>
					@endforeach
				</tbody>
				</table>
		</div>
</div>
@endsection