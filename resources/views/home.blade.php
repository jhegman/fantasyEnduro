@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                
                <div class="panel-body">
                    You are logged in!
                </div>
    
                <div class="panel-body">
                    Username: {{$user->name}}
                </div>
                <div class="panel-body">
                    My Leagues: 
                    @foreach ($user->leagues as $league)
                        <p>
                        <a href="{{ url('/leagues')}}/{{$league->id}}">{{$league->name}}</a>
                        </p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="panel-body">  
        <chat inline-template>
        <div>
            You are logged in!

            <hr>

            <h2>Write something to all users</h2>
            <input type="text" class="form-control" placeholder="something" required="required" v-model="newMsg" @keyup.enter="press">

            <hr>
            <h3>Messages</h3>

            <ul v-for="post in posts">
            <b>@{{ post.username }} says:</b> @{{ post.message }}</li>
            </ul>
        </div>

        </chat>
    </div><!-- panel-body -->  
</div>
@endsection
