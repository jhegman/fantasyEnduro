@extends('layouts.app')

@section('content')
<div class="container main-content" v-on:onload="seen = true">
    <noty></noty>
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
            	<input v-model="leagueSearch" class="search" type="text" placeholder="Search" @input="leagueLiveSearch">
        	</div><!-- /.search-wrap -->
    			<table class="table table-hover" v-show="leagueSearch == '' ">
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
							$userInLeagueCheck = ($league->users()->where('id',$user->id)->first() != null ? 'true' : 'false');
						@endphp
						<tr is="league" :user-in-league="{{ $userInLeagueCheck }}" :league-count="{{count($league->users)}}" :league-id="{{$league->id}}" v-cloak>
                            <td slot="league-name">
                                <a href="{{ url('/leagues',$league->id) }}">{{$league->name}}</a>
                            </td>
                        </tr>
					@endforeach
				</tbody>
				</table>
                {{$leagues->links()}}
                <table class="table table-hover" v-if="leagueSearch != '' " v-cloak>
                    <thead>
                        <tr>
                            <th></th>
                            <th> League Name</th>
                            <th> Number of Members</th>
                        </tr>
                    </thead>
                <tbody class="list">
                    <tr v-for="league in leagues" is="league" :user-in-league="league.userInLeague" :league-count="league.leagueCount" :league-id="league.league.id">
                        <td slot="league-name">
                            <a :href="'/leagues/' + league.league.id">@{{league.league.name}}</a>
                        </td>
                    </tr>
                </tbody>
                </table>
		</div>
</div>
@endsection