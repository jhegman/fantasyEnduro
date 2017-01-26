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
            <h2>Your current user name: {{$user->name}}</h2>
                {!! form($form) !!}
        </div>
    </div>
</div>
@endsection
