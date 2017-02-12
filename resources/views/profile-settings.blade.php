@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class=col-md-2>
            <img src = "uploads/avatar/{{$user->avatar}}" class="img-circle" height="150px" width="150px">
        </div>
        <div class=col-md-10>
            <h1>{{$user->name}}</h1>
            <form enctype="multipart/form-data" action="/profile-settings" method="POST">
                <label>Update Profile Picture</label>
                    <!-- <input type="file" name="avatar"> -->
                    {{Form::file('image')}}
                    {{Form::token()}}
                    <input type="submit" class="btn-primary">
            </form>
        </div>
        <div class="col-md-12">
                {!! form($form) !!}
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
