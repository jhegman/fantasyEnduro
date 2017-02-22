@extends('layouts.app')

@section('content')
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
                <span class="dropdown" v-if="settings[0].show" @click="expand(0)" v-cloak>
                    <i class="fa fa-minus-square-o" aria-hidden="true"></i>
                </span>
                <span class="dropdown" v-else @click="expand(0)" v-cloak>
                    <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                </span>
                <span @click="expand(0)" style="cursor: pointer;">   
                    Edit Username
                </span>
                <div v-if="settings[0].show" v-cloak>
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
            </div>
            <div class="settings-table">
                <span class="dropdown" v-if="settings[1].show" @click="expand(1)" v-cloak>
                    <i class="fa fa-minus-square-o" aria-hidden="true"></i>
                </span>
                <span class="dropdown" v-else @click="expand(1)" v-cloak>
                    <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                </span>
                <span @click="expand(1)" style="cursor: pointer;">
                    Change profile picture
                </span>
                <div v-if="settings[1].show" v-cloak>
                    {!! Form::open(['url' => 'profile-settings', 'files' => true]) !!}
                        <!-- <input type="file" name="avatar"> -->
                        {{ Form::file('image') }}
                        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="settings-table settings-last">
                <span class="dropdown" v-if="settings[2].show" @click="expand(2)" v-cloak>
                    <i class="fa fa-minus-square-o" aria-hidden="true"></i>
                </span>
                <span class="dropdown" v-else @click="expand(2)" v-cloak>
                    <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                </span>
                <span @click="expand(2)" style="cursor: pointer;">
                    Email Preferences
                </span>
                <div v-if="settings[2].show" v-cloak>
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
            </div>
        </div>
    </div>
</div>
@endsection