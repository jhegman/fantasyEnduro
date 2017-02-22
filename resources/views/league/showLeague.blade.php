@extends('layouts.app')

@section('content')
<div id="container" class="container main-content">
        <transition name="fade">
            <div class="alert container set-linup-noty" :save-message="saveMessage" v-bind:class="[saveStatus ? 'alert-success' : 'alert-danger']" @click="closeNoty" v-if="showNoty" role="alert" v-cloak>@{{saveMessage}}</div>
       </transition>
    <div class="row">   
        <div class="col-md-12">
            <svg @click="show = !show" id="clear-noty" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M22 3v13h-11.643l-4.357 3.105v-3.105h-4v-13h20zm2-2h-24v16.981h4v5.019l7-5.019h13v-16.981z"/></svg>
            <div id="notify">

            </div>
            <a href="{{ url('/leagues')}}"> Back to Leagues Page</a>
                <h1>{{ $league->name }}</h1>
                @if($userInLeagueCheck > 0)
                    <button class="btn-primary" @click="leaveLeague({{$league->id}})" v-if="showLeagueLeft[{{$league->id}}] === undefined">Leave league</button>
                    <span v-if="showLeagueLeft[{{$league->id}}] === true" v-cloak>
                        <a href="{{ url('/leagues')}}"> Back to Leagues Page</a>
                    </span>
                @endif
                    <table>
                       <tbody>
                       @foreach($users as $user)
                           <tr>
                                <td>
                                    <a href="{{ url('/user',$user->name) }}">{{$user->name}}</a>
                                </td>
                                <td>
                                    Score: {{$user->points}}
                                </td>
                           </tr>
                       @endforeach
                       </tbody>
                    </table>
        </div>
    </div>
        @if($userInLeagueCheck > 0)    
                <chat inline-template v-bind:class="{ visible: show }" v-cloak>
                    <div class="chat-off-canvas"><!-- start of chat area-->
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
                                            <span class="li-image" style="background-image: url({{ url('/uploads/avatar',$names[$key]->avatar) }})"> 
                                            </span>
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
                                            <span class="li-image" :style="{ backgroundImage: 'url('+'/uploads/avatar/' + post.avatar + ')' }">
                                            </span>
                                                <b> @{{ post.username }}:</b> 
                                            <span class="others-chats">
                                                @{{ post.message }}</li>
                                            </span>
                                        </div>
                                    </ul>
                            </div>
                        <hr>
                        <hr>
                <div id="input-wrap" class="input-wrap">
                    <i id="emoji-icon" class="fa fa-smile-o choose-emoji-btn" aria-hidden="true"></i>
                    <input type="text" id="chat-input" class="form-control" placeholder="Type your message" required="required" v-model="newMsg" @keyup.enter="press({{$league->id}})">
                </div><!-- /.input-wrap -->
            </div> <!-- end of chat off canvas-->
        </chat>
    @endif
</div>
@endsection