@extends('layouts.app')

@section('content')
<div class="container main-content">
    {!! Form::open(['method' => 'POST', 'route' => 'upload-race-complete', 'files' => true, 'class' => 'form-horizontal']) !!}
    	<div class="form-group{{ $errors->has('race_upload') ? ' has-error' : '' }}">
    	    {!! Form::label('race_upload', 'Race CSV') !!}
    	    {!! Form::file('race_upload', ['required' => 'required']) !!}
    	    <small class="text-danger">{{ $errors->first('race_upload') }}</small>
    	</div>
    	<div class="form-group{{ $errors->has('race_name') ? ' has-error' : '' }}">
    	    {!! Form::label('race_name', 'Race Name') !!}
    	    {!! Form::text('race_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
    	    <small class="text-danger">{{ $errors->first('race_name') }}</small>
    	</div>
    	<div class="form-group{{ $errors->has('race_location') ? ' has-error' : '' }}">
    	    {!! Form::label('race_location', 'Race Location') !!}
    	    {!! Form::text('race_location', null, ['class' => 'form-control', 'required' => 'required']) !!}
    	    <small class="text-danger">{{ $errors->first('race_location') }}</small>
    	</div>
    	<div class="form-group{{ $errors->has('week') ? ' has-error' : '' }}">
    	    {!! Form::label('week', 'Week') !!}
    	    {!! Form::number('week', null, ['class' => 'form-control', 'required' => 'required']) !!}
    	    <small class="text-danger">{{ $errors->first('week') }}</small>
    	</div>
    	<div class="form-group{{ $errors->has('number_stages') ? ' has-error' : '' }}">
    	    {!! Form::label('number_stages', 'Number of Stages') !!}
    	    {!! Form::number('number_stages', 7, ['class' => 'form-control', 'required' => 'required']) !!}
    	    <small class="text-danger">{{ $errors->first('number_stages') }}</small>
    	</div>
    	<div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
    	    {!! Form::label('gender', 'Gender') !!}
    	    {!! Form::select('gender', ['Men' => 'Male', 'Women' => 'Female'], null, ['placeholder'=>'=== Select Gender ===', 'id' => 'gender', 'class' => 'form-control', 'required' => 'required']) !!}
    	    <small class="text-danger">{{ $errors->first('gender') }}</small>
    	</div>
    	<div class="form-group">
    		{!! Form::submit('Submit', ['class' => 'btn-primary']) !!}
    	</div><!-- /.form-group -->
    {!! Form::close() !!}
</div>
@endsection
