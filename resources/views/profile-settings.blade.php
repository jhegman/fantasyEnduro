@extends('layouts.app')

@section('content')
@if ($errors->first('name'))
    @php
        $errorCheckName = 'true';
        $errorCheckPic = 'false';
    @endphp
@elseif ($errors->first('image'))
    @php
        $errorCheckName = 'false';
        $errorCheckPic = 'true';
    @endphp
@else
    @php
        $errorCheckName = 'false';
        $errorCheckPic = 'false';
    @endphp
@endif
<div class="container main-content">
    <div class="row">
        <div class=col-md-2>
            <div class="card-wrap">
                <div class="profile_pic-wrap" style="background-image: url('uploads/avatar/{{$user->avatar}}')">
                </div>
                <div class="info-wrap">
                    <h1 class="user-name">{{$user->name}}</h1>
                </div>
            </div>
        </div>
        <div class=col-md-10>
            <div class="settings-table settings-first">
                <accordion :errors="{{ $errorCheckName }}">
                    <span slot="title">Edit Username</span>
                    <div slot="form" v-cloak>
                        {!! Form::open(['url' => 'change-username/complete']) !!}
                            <div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
                                {{ Form::label('name', 'Edit your Username:', ['class' => 'control-label']) }}
                                {{ Form::text('name', null, ['class' => 'form-control']) }}
                                @if ($errors->first('name'))
                                    <span class="errors">{{ $errors->first('name') }}</span>
                                @endif
                            </div><!-- /.form-group -->
                            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
                        {!! Form::close() !!}
                    </div>
                </accordion>
            </div>
            <div class="settings-table">
                <accordion :errors="{{ $errorCheckPic }}">
                    <span slot="title">Change profile picture</span>
                    <div slot="form" v-cloak>
                        {!! Form::open(['url' => 'change-picture', 'files' => true]) !!}
                            <div class="form-group">
                                <!-- <input type="file" name="avatar"> -->
                                {{ Form::file('image') }}
                            </div>
                            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
                            @if ($errors->first('image'))
                                    <span class="errors">{{ $errors->first('image') }}</span>
                            @endif
                        {!! Form::close() !!}
                    </div>
                </accordion>
            </div>
            <div class="settings-table settings-last">
                <accordion>
                    <span slot="title">Email Preferences</span>
                    <div slot="form" v-cloak>
                        <form enctype="multipart/form-data" action="/unsubscribe" method="POST">
                            <label>Subscribe to reminder emails?</label>
                                {{Form::token()}}
                            @if ($user->subscribed == 1)
                                <input type="checkbox" name="send_emails" value="1" checked>
                            @else
                                <input type="checkbox" name="send_emails" value="0">
                            @endif
                                <input style="display:block" value="Update" type="submit" class="btn-primary">
                        </form>
                    </div>
                </accordion>
            </div>
        </div>
    </div>
</div>
@endsection