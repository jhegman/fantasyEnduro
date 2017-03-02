@extends('layouts.app')

@section('content')
<div class="container main-content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
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
                    <div class="panel-body">
                        <form class="form-horizontal" method="post" action="/invite/{{$league->id}}">
                            {!! csrf_field() !!}
                            <label class="col-md-4 control-label">E-Mail Address</label>
                            <div class="col-md-6">
                                <input type="email" name="email">
                                @if ($errors->first('email'))
                                    <div class="errors">{{ $errors->first('email') }}</div>
                                @elseif($alreadySent)
                                    <div class="errors">Invitation already sent to this address</div>
                                @endif
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-envelope-o"></i>Invite to league
                                </button>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection