@extends('layouts.app')

@section('content')
<div class="container">
    <div class="alert alert-success" role="alert">
        Account Verified! 
    </div>
    <div class="links">
        <a href="/athletes">Athletes</a>
        <a href="/set-lineup">Set Lineup</a>
        <a href="/leagues">Leagues</a>
        <a href="/results">Results</a>
        <a href="/rankings">Rankings</a>
    </div>
</div>
@endsection