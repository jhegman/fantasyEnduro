@extends('layouts.app')

@section('content')
<div class="container main-content">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autofocus oninput="this.setAttribute('value', this.value);">
                                <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                                <label for="name" class="control-label">Team Name</label>
                            </div><!-- /.col-md-12 -->
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" oninput="this.setAttribute('value', this.value);">
                                <i class="fa fa-at" aria-hidden="true"></i>
                                <label for="email" class="control-label">E-Mail Address</label>
                            </div><!-- /.col-md-12 -->
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control" name="password" required oninput="this.setAttribute('value', this.value);" value="">
                                <i class="fa fa-lock" aria-hidden="true"></i>
                                <label for="password" class="control-label">Password</label>
                            </div><!-- /.col-md-12 -->
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required oninput="this.setAttribute('value', this.value);" value="">
                                <i class="fa fa-lock" aria-hidden="true"></i>
                                <label for="password-confirm" class="control-label">Confirm Password</label>
                            </div><!-- /.col-md-12 -->
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
