@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    	<div class="col-md-12">
    		<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
    			<circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
    			<path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
    		</svg>
    		<h2 class="changed">League Created</h2>
    		<h2 class="newUser">Your New League: {{$newLeague->name}}</h2>
    		@if ($newLeague->password != null)
            <h2 class="newUser">League Password: {{decrypt($newLeague->password)}}</h2>
            @endif
    		<a class="btn-primary btn-home" href="{{url('/leagues')}}"> Back to leagues page</a>
    	</div>
    </div>
</div>
@endsection