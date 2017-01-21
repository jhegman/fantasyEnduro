@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User Name Changed!</h1>
    <h2>Your New UserName: {{$user->username}}</h2>
</div>
@endsection