@extends('layouts.app')

<!-- Main Content -->
@section('content')
<div class="container main-content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default not-valid-user">
                <div class="panel-heading">{!! trans('laravel-user-verification::user-verification.verification_error_header') !!}</div>
                <div class="panel-body">
                    <span class="help-block">
                        <strong>Your Account has not been verified! Please check your email and click the link to verify your account.</strong>
                    </span>
                    <div class="resend form-group">
                        {!! Form::open(['url' => 'email-verification/resend-verification']) !!}
                            {{ Form::submit('Resend Verification', ['class' => 'btn btn-primary']) }}
                        {!! Form::close() !!}
                    </div><!-- /.resend -->
                    <div class="form-group ">
                        <a href="{{url('/')}}" class="btn btn-primary">
                            {!! trans('laravel-user-verification::user-verification.verification_error_back_button') !!}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
