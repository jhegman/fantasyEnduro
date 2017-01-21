@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Your current user name: {{$user->username}}</h2>
    {!! form($form) !!}
</div>
@endsection