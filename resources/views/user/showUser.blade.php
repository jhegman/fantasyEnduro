@extends('layouts.app')

@section('content')
<div class="container main-content">
    <div class="row">
        <div class="col-md-12">
            <div class="card-wrap card-wrap-user">
                <div class="profile_pic-wrap user-profile-pic" style="background-image: url({{ url('/uploads/avatar',$user->avatar) }})">
                </div>
                 <div class="info-wrap">
                    <h1 class="user-name user-name-user">{{ $user->name }}</h1>
                    @if (Auth::user()->name == $user->name)
                        <ul class="lineups">
                            <li>
                                <a href="{{url('/set-lineup/men')}}">
                                    Set your men's team
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/set-lineup/women')}}">
                                    Set your women's team
                                </a>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>   
    @if(!$isOpen || (Auth::user()->name == $user->name))
    <div class="row">
        <div class="col-md-6">
            <h2> Men's Lineup</h2>
                <table class="table table-hover">
                    <tbody>
                        @if(count($men > 0))
                            @foreach($men as $man)
                                <tr>
                                    <td>
                                        @if ($man->photo_url != null)   
                                            <img src="{{$man->photo_url}}" class="img-circle" height="50px" width="50px">
                                        @else
                                            <img src = "/img/placeholder_athlete.jpg" alt="placeholder" class="img-circle" height="50px" width="50px">
                                        @endif
                                            <a href="{{ url('/athletes',$man->id) }}">{{ $man->name}}
                                            </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
        </div>
    
        <div class="col-md-6">
            <h2> Women's Lineup</h2>
                <table class="table table-hover">
                    <tbody>
                        @if(count($women > 0))
                            @foreach($women as $woman)
                                <tr>
                                    <td>
                                        @if ($woman->photo_url != null)   
                                            <img src="{{$woman->photo_url}}" class="img-circle" height="50px" width="50px">
                                        @else
                                            <img src = "/img/placeholder_athlete.jpg" alt="placeholder" class="img-circle" height="50px" width="50px">
                                        @endif
                                            <a href="{{ url('/athletes',$woman->id) }}">{{ $woman->name}}
                                            </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
        </div>
    </div>
    @else
        <h1> User's team is hidden while the selection period is open </h1>
    @endif
    <div class="row">
        <div class="col-md-12">
            <h1>Rankings</h1>
                @foreach($rankings as $ranking)
                    <div>
                        Week: {{$ranking->week}} | Score: {{$ranking->points}} | Rank: {{$ranking->rank}}/{{count(Auth::user()::all())}}
                    </div>
                @endforeach
        </div>
    </div>
</div>
@endsection