@extends('layouts.app')

@section('content')
<div class="container main-content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                
                <div class="panel-body">
                    <div class="alert alert-success" role="alert">You are logged in!</div>
                    @if (!$user->isVerified())
                        <div class="alert alert-danger">Your Account has not been verified! Please check your email and click the link to verify your account.</div>
                        {!! Form::open(['url' => 'email-verification/resend-verification']) !!}
                            {{ Form::submit('Resend Verification', ['class' => 'btn btn-primary']) }}
                        {!! Form::close() !!}
                    @endif
                </div>
    
                <div class="panel-body">
                    Username: {{$user->name}}
                </div>
                <div class="panel-body">
                    My Leagues: 
                    @foreach ($user->leagues as $key => $league)
                        <div>
                        <a href="{{ url('/leagues')}}/{{$league->id}}">{{$league->name}}</a>
                        @if($leagueMessages[$key] > 0)
                            <span style="color:#db4437;">{{$leagueMessages[$key]}} new messages</span>
                        @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>  
</div>
@endsection
