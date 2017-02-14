@extends('layouts.app')

@section('content')
<div class="container">
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
                                        <span class="my-chats">
                                            {{$message->message}}
                                        </span>
                                        <span class="arrow-right">
                                            &#9658;
                                        </span>
                                        <span>
                                            <img src = "{{ url('/uploads/avatar',$names[$key]->avatar) }}" class="img-circle" height="32px" width="32px"/>
                                        </span>
                                    </ul>
                                @else
                                    <ul>
                                        <span>
                                            <img src = "{{ url('/uploads/avatar',$names[$key]->avatar) }}" class="img-circle" height="32px" width="32px"/>
                                        </span>
                                        <b>{{$names[$key]->name}}:</b> 
                                        <span class="others-chats">
                                        {{$message->message}}
                                        </span>
                                    </ul>
                                @endif
                            @endforeach
                                <ul v-for="post in posts" v-if="post.username == '{{Auth::user()->name}}'" v-cloak style="text-align: right;">
                                    <span class="my-chats">
                                        @{{ post.message }}</li>
                                     </span>
                                     <span class="arrow-right">
                                        &#9658;
                                    </span>
                                    <span>
                                        <img :src="'/uploads/avatar/' + post.avatar" class="img-circle" height="32px" width="32px"/>
                                    </span>
                                </ul>
                                <!-- Other users chats -->
                                <ul v-for="post in posts" v-else v-cloak>
                                    <span>
                                        <img :src="'/uploads/avatar/' + post.avatar" class="img-circle" height="32px" width="32px"/>
                                    </span>
                                    <b> @{{ post.username }}:</b> 
                                    <span class="others-chats">
                                    @{{ post.message }}</li>
                                    </span>
                                </ul>
                            </div>
                        <hr>
                        <hr>
                        <input type="text" class="form-control" placeholder="Type your message" required="required" v-model="newMsg" @keyup.enter="press({{$league->id}})">
                    </div>
                </chat>
    @endif
    </div>
    </div>
</div>
@endsection