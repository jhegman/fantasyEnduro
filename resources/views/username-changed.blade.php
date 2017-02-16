@extends('layouts.app')

@section('content')
<div class="container main-content">
    <div class="row">
    	<div class="col-md-12">
    		<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
    			<circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
    			<path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
    		</svg>
    		<h2 class="changed">User Name Changed!</h2>
    		<h2 class="newUser">Your New Username: {{$user->name}}</h2>
    		<a class="btn-primary btn-home" href="{{url('/home')}}"> Home</a>
    	</div>
    </div>
</div>
@endsection