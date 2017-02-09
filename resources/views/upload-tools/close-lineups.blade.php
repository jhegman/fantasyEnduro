@extends('layouts.app')

@section('content')
<h2> Load Times into database</h2>
<form enctype="multipart/form-data" action="/close-lineups" method="POST">
{{Form::token()}}
<input type="submit" class="btn-primary">
</form>
@endsection