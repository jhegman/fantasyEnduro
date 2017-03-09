@extends('layouts.app')

@section('content')
<div class="main-content">
    <div class="bg-image-404 flex-center position-ref">
        <div class="cover"></div><!-- /.cover -->
        <div class="content">
            <h1>404</h1>
            <h2>Sorry, Page not found</h2>
            <a href="{{ url('/home') }}" class="btn-primary">Home</a>
        </div>
    </div>
</div>
@endsection
