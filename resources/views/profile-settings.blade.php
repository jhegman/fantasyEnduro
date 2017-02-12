@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class=col-md-2>
            <img src = "uploads/avatar/{{$user->avatar}}" class="img-circle" height="150px" width="150px">
        </div>
        <div class=col-md-10>
            <h1>{{$user->name}}</h1>
            {!! Form::open(['url' => 'profile-settings', 'files' => true]) !!}
                <label>Update Profile Picture</label>
                <!-- <input type="file" name="avatar"> -->
                {{ Form::file('image') }}
                {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
            {!! Form::close() !!}
        </div>
        <div class="col-md-12">
            {!! Form::open(['url' => 'change-username/complete']) !!}
                <div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
                    {{ Form::label('name', 'Edit your Username:', ['class' => 'control-label']) }}
                    {{ Form::text('name', null, ['class' => 'form-control']) }}
                    @if ($errors->first('name'))
                        <span class="errors">{{ $errors->first('name') }}</span>
                    @endif
                </div><!-- /.form-group -->
                {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
            {!! Form::close() !!}
        </div>
        <div class="col-md-12">
            <h2> Reminder Emails</h2>
            <form enctype="multipart/form-data" action="/unsubscribe" method="POST">
                <label>Subscribe to reminder emails?</label>
                {{Form::token()}}
                @if ($user->subscribed == 1)
                {{ Form::checkbox('send_emails[]', 'value', true) }}
                @else
                {{ Form::checkbox('send_emails[]', 'value', false) }}
                @endif
                <input style="display:block" value="Update" type="submit" class="btn-primary">
            </form>
        </div>
    </div>
</div>
@endsection
