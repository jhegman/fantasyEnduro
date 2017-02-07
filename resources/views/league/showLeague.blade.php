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
                                <ul>
                                    <span>
                                    <img src = "{{ url('/uploads/avatar',$names[$key]->avatar) }}" class="img-circle" height="32px" width="32px"/>
                                    </span>
                                    <b>{{$names[$key]->name}}:</b> 
                                    <span>{{$message->message}}</span>
                                </ul>
                            @endforeach
                                <ul v-for="post in posts" v-cloak>
                                    <span>
                                        <img :src="'/uploads/avatar/' + post.avatar" class="img-circle" height="32px" width="32px"/>
                                    </span>
                                        <b> @{{ post.username }}:</b> @{{ post.message }}</li>
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