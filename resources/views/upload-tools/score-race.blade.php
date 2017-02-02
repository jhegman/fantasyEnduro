@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class=col-md-12>
            <h1>Allocate points to users</h1>
            <form enctype="multipart/form-data" action="/score-race" method="POST">
                <label>Enter Week</label>
                    {{Form::text('week')}}
                <label>Enter Men's Race ID</label>
                    {{Form::text('race_id_men')}}
                <label>Enter Women's Race ID</label>
                    {{Form::text('race_id_women')}}
                    {{Form::token()}}
                    <input type="submit" class="btn-primary">
            </form>
            <ul>
                @foreach ($points as $point)
                    <li>User ID: {{$point->user_id}}, Week: {{$point->week}}, Points: {{$point->points}}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
