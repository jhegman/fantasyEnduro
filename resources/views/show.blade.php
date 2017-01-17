@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $athlete->name }}</h1>
    <h2>{{ $athlete->gender }}</h2>
</div>
@endsection