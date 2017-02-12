@extends('layouts.app')

@section('content')
<h2> Load Times into database</h2>
@if($full == true)
<h2>Times already entered</h2>
@else
<form enctype="multipart/form-data" action="/close-lineups" method="POST">
{{Form::token()}}
<input type="submit" class="btn-primary">
</form>
@endif
@endsection