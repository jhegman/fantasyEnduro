@extends('layouts.app')

@section('content')
<div class="container main-content">
    @if(Session::has('flash_message'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                &times;
            </button>
            {{Session::get('flash_message')}}
        </div>
    @endif
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default short-instructions">
                <div class="panel-body">
                    <b> Invite other users to join your private league.  Invited users will
                    recieve an email where they can accept your invite.</b>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading clearfix">Pending invitations</div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>E-Mail</th>
                                <th>Status</th>
                                <th>Resend</th>
                            </tr>
                            </thead>
                            @foreach($invitations as $invi)
                                <tr>
                                    <td>{{$invi->email}}</td>
                                    <td>{{App\Invitation::status($invi->code,$invi->email)}}</td>
                                    <td>
                                        @if(App\Invitation::status($invi->code,$invi->email) == 'expired')
                                            <a href="{{route('resend', [$league->id,$invi->id])}}" class="btn btn-sm btn-default">
                                            <i class="fa fa-envelope-o"></i> Resend invite
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading clearfix">Invite members to {{$league->name}}</div>
                    <div id="user-sort" class="panel-body">
                        <div class="search-wrap lineup-search">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            <input v-model="userSearch" class="search" type="text" placeholder="Search"@input="userLiveSearch({{$league->id}})">
                        </div><!-- /.search-wrap -->
                        <div class="overflow-invite">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Send</th>
                                </tr>
                                </thead>
                                <tbody class="list" v-show="userSearch == '' ">
                                @foreach($users as $user)
                                    <tr>
                                        <td class="name">{{$user->name}}</td>
                                        <td>
                                            <form class="form-horizontal" method="post" action="/invite/{{$league->id}}">
                                                {!! csrf_field() !!}
                                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                                <button type="submit" class="btn btn-sm btn-default">
                                                    <i class="fa fa-btn fa-envelope-o"></i>Invite to league
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tbody v-if="userSearch != '' " v-cloak>
                                    <tr v-for="user in users">
                                        <td class="name">@{{user.name}}</td>
                                        <td>
                                            <form class="form-horizontal" method="post" action="/invite/{{$league->id}}">
                                                {!! csrf_field() !!}
                                                <input type="hidden" name="user_id" :value="user.id">
                                                <button type="submit" class="btn btn-sm btn-default">
                                                    <i class="fa fa-btn fa-envelope-o"></i>Invite to league
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            {{$users->links()}}
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection