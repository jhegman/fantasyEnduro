@extends('layouts.app')

@section('content')
<div class="container main-content">
    <h3>Questions, comments, site issues? Drop us a line!</h3>
    {!! Form::open(['method' => 'POST', 'route' => 'contact-submitted']) !!}
    
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('name') }}</small>
        </div>
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            {!! Form::label('email', 'Email') !!}
            {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'eg: foo@bar.com']) !!}
            <small class="text-danger">{{ $errors->first('email') }}</small>
        </div>
        <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
            {!! Form::label('subject', 'Subject') !!}
            {!! Form::text('subject', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('subject') }}</small>
        </div>
        <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
            {!! Form::label('message', 'Message') !!}
            {!! Form::textarea('message', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('message') }}</small>
        </div>
    
        <div class="btn-group">
            {!! Form::submit("Send", ['class' => 'btn btn-primary']) !!}
        </div>
    
    {!! Form::close() !!}
</div>
@endsection