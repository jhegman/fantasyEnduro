@extends('layouts.app')

@section('content')
<div class="container main-content" v-on:onload="seen = true">
   	<transition name="fade">
			<div style= "position:fixed;" class="alert container set-linup-noty" :save-message="saveMessage" v-bind:class="[saveStatus ? 'alert-success' : 'alert-danger']" @click="closeNoty" v-if="showNoty" role="alert" v-cloak>@{{saveMessage}}</div>
	</transition>
        @if ($errors->any())
            @php
                $errorCheck = 'true';
            @endphp
        @else 
            @php
                $errorCheck = 'false';
            @endphp
        @endif
        <accordion :errors="{{ $errorCheck }}">
            <span slot="title">Create New League</span>
            <div slot="form" v-cloak>
                {!! Form::open(['url' => 'leagues/created']) !!}
                    <div class="form-group {{$errors->has('new_league') ? 'has-error' : ''}}">
                        {{ Form::label('new_league', 'League name:', ['class' => 'control-label']) }}
                        {{ Form::text('new_league', null, ['class' => 'form-control']) }}
                        @if ($errors->first('new_league'))
                            <span class="errors">{{ $errors->first('new_league') }}</span>
                        @endif
                    </div><!-- /.form-group -->

                    <div class="form-group {{$errors->has('password') ? 'has-error' : ''}}">
                        <label>Private League?</label>
                        {{ Form::checkbox('private', 'yes') }}
                        <span class="errors"> If the league is private then only the creator of the league can add users to their league.</span>
                    </div><!-- /.form-group -->
                    {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
                {!! Form::close() !!}
            </div>
        </accordion>
        <div class="row">
            <div class="col-md-12" class="table-responsive">
                <h1> My Leagues </h1>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th> League Name </th>
                                <th> Number of Members </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($myLeagues as $myLeague)
                                <tr>
                                    <td> 
                                        @if($myLeague->private)
                                            <i class="fa fa-lock" aria-hidden="true"></i>
                                        @endif
                                        <a href="{{ url('/leagues',$myLeague->id) }}">{{$myLeague->name}}
                                        </a>
                                    </td>
                                    <td> {{count($myLeague->users)}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
    	<h1>Public Leagues</h1>
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