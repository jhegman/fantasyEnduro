@extends('layouts.app')

@section('content')
<div class="container">
    <h1>League Created</h1>
    <h2>Your New League: {{$newLeague->name}}</h2>
	@if ($newLeague->password !=null)	
    <h2>League Password: {{decrypt($newLeague->password)}}</h2>
    @endif
    <a href="{{ url('/leagues')}}"> Back to Leagues Page</a>
</div>
@endsection