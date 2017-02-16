@extends('layouts.app')

@section('content')
<div id="container" class="container main-content">
        <transition name="fade">
			<div class="alert container set-linup-noty" :save-message="saveMessage" v-bind:class="[saveStatus ? 'alert-success' : 'alert-danger']" @click="closeNoty" v-if="showNoty" role="alert" v-cloak>@{{saveMessage}}</div>
	   </transition>
    <div class="row">   
        <div class="col-md-6">
            <a href="{{ url('/leagues')}}"> Back to Leagues Page</a>
                <h1>{{ $league->name }}</h1>
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
        <div class="col-md-6">
        @if($userInLeagueCheck > 0)
            <button class="btn-primary" @click="leaveLeague({{$league->id}})" v-if="showLeagueLeft[{{$league->id}}] === undefined">Leave league</button>
    		  <span v-if="showLeagueLeft[{{$league->id}}] === true" v-cloak>
    		      <a href="{{ url('/leagues')}}"> Back to Leagues Page</a>
    		  </span>    

                <chat inline-template>
                    <div>
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
            </div>
        </chat>
    @endif
    </div>
    </div>
</div>
@endsection