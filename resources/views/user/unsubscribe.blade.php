@extends('layouts.app')

@section('content')
<div class="container main-content">
    <div class="row check-mark-done">
    	<div class="col-md-12">
    		<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
    			<circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
    			<path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
    		</svg>
    		<h2 class="changed">Your email settings have been updated!</h2>
            @if(Auth::user()->subscribed == 1)
                <h2 class="newUser"> You are now subscribed to email reminders</h2>
            @else
                <h2 class="newUser"> You will now no longer recieve emails from Fantasy Enduro</h2>
            @endif
    		<a class="btn-primary btn-home" href="{{url('/home')}}"> Home</a>
    	</div>
    </div>
</div>
@endsection