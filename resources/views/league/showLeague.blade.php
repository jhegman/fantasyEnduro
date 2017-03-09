@extends('layouts.app')

@section('content')
        <transition name="fade">
            <div class="alert container set-linup-noty" :save-message="saveMessage" v-bind:class="[saveStatus ? 'alert-success' : 'alert-danger']" @click="closeNoty" v-if="showNoty" role="alert" v-cloak>@{{saveMessage}}</div>
       </transition>
<div class="cover-athlete" style="background-image: url(../img/league-cover.jpg)">
    @if($userInLeagueCheck > 0)
        @if($leagueAdmin)
            <a class="btn-primary leave" href="{{url('/invite',$league->id)}}"> Invite Members!</a>
        @else
            <button class="btn-primary leave" @click="leaveLeague({{$league->id}})" v-if="showLeagueLeft[{{$league->id}}] === undefined">Leave league</button>
            <span v-if="showLeagueLeft[{{$league->id}}] === true" v-cloak>
            <a class="leave" href="{{ url('/leagues')}}"> Back to Leagues Page</a>
            </span>
        @endif
    @endif
    <div class="go-back">
        <i class="fa fa-arrow-left" aria-hidden="true"></i>
        <a href="{{ url('/leagues')}}"> Back to Leagues Page</a>
    </div>
    @if($userInLeagueCheck > 0)
        <div id="clear-noty" @click="updateLastSeen({{$league->id}})" class="chat-wrap">
            <img class="chat-img" @click="show = !show" src="../img/chat.svg"/>
                @if($messageCount > 0)
                    <div id="notify" @click="show = !show" class="notify-style">
                        {{$messageCount}}
                    </div>
                @else
                    <div id="notify" @click="show = !show">
                        
                    </div>
                @endif
        </div>
    @endif
        <h1 class="league-name">{{ $league->name }}</h1>
</div>
<div class="container main-content">
    <div class="row">
        <div class="col-md-12">
            @if(count($users) > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                       <thead>
                            <tr>
                                <th> User </th>
                                <th> Overall Score </th>
                                @if($points[0]->currentPage() == 1)
                                    @for($i = 1;$i < 5;$i++)
                                        <th> Week {{$i}} Score</th>
                                        <th> Week {{$i}} Rank</th>
                                    @endfor
                                @else
                                    @for($i = 4;$i < 9;$i++)
                                        <th> Week {{$i}} Score</th>
                                        <th> Week {{$i}} Rank</th>
                                    @endfor
                                @endif
                            </tr>
                        </thead>
                       <tbody>
                       @foreach($users as $key=> $user)
                           <tr>
                                <td>
                                    <a href="{{ url('/user',$user->name) }}">
                                        <span class="li-image" style="background-image: url({{ url('/uploads/avatar',$user->avatar) }})"> 
                                        </span>
                                        {{$user->name}}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{url('/rankings')}}">
                                        {{$user->points}}
                                    </a>
                                </td>
                                @foreach($points[$key] as $point)
                                    <td>
                                        <a href="{{url('/rankings',$point->week)}}">
                                            {{$point->points}}
                                        </a>
                                    </td>
                                    <td>
                                        {{$point->rank}}
                                    </td>
                                @endforeach
                             </tr>
                       @endforeach
                       </tbody>
                    </table>
                </div>
                {{$points[0]->links()}}
            @endif
        </div>
    </div>
        @if($userInLeagueCheck > 0)    
                <div class="chat-off-canvas" v-bind:class="{ visible: show }" v-cloak>
                <img src="../img/cancel.svg" class="cancel" @click="show = false">
                <chat inline-template :league-id="{{$league->id}}">
                    <div><!-- start of chat area-->
                        <h3>Messages</h3>
                            <div id="chatArea">
                                @foreach ($messages as $key=>$message)
                                    @if(Auth::user()->name === $names[$key]->name)
                                        <ul style="text-align: right;">
                                            <li class="my-chats">
                                                {{$message->message}}
                                            </li><li class="arrow-right">
                                                &#9658;
                                            </li><li class="li-image" style="background-image: url({{ url('/uploads/avatar',$names[$key]->avatar) }})">
                                            </li>
                                        </ul>
                                    @else
                                        <ul>
                                            <a href="{{url('/user',$names[$key]->name)}}">
                                                <span class="li-image" style="background-image: url({{ url('/uploads/avatar',$names[$key]->avatar) }})"> 
                                                </span>
                                            </a>
                                                <b>{{$names[$key]->name}}:</b> 
                                            <span class="others-chats">
                                                {{$message->message}}
                                            </span>
                                        </ul>
                                    @endif
                                @endforeach
                                    <ul v-for="post in posts">
                                        <div class="message-wrap" v-if="post.username == '{{Auth::user()->name}}'" style="text-align: right;" v-cloak>
                                            <li class="my-chats">
                                                @{{ post.message }}
                                             </li><li class="arrow-right">
                                                &#9658;
                                            </li><li class="li-image" :style="{ backgroundImage: 'url('+'/uploads/avatar/' + post.avatar + ')' }">
                                            </li>
                                        </div>
                                    <!-- Other users chats -->
                                        <div class="message-wrap" v-else v-cloak>
                                            <a :href="'/user/' + post.username">
                                                <span class="li-image" :style="{ backgroundImage: 'url('+'/uploads/avatar/' + post.avatar + ')' }">
                                                </span>
                                            </a>
                                                <b> @{{ post.username }}:</b> 
                                            <span class="others-chats">
                                                @{{ post.message }}</li>
                                            </span>
                                        </div>
                                    </ul>
                            </div>
                            <div>
                                <hr>
                            </div>
                <div id="input-wrap" class="input-wrap">
                    <i class="fa fa-arrow-circle-up" aria-hidden="true" v-if="isMobile" @click="press({{$league->id}})" v-cloak></i>
                    <textarea id="chat-input" class="form-control" placeholder="Type your message" required="required" v-model="newMsg" @keyup.enter="press({{$league->id}})"></textarea>
                </div><!-- /.input-wrap -->
            </div> <!-- end of chat off canvas-->
        </chat>
        </div>
    @endif
</div>
@endsection