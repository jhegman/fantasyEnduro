@extends('layouts.app')

@section('content')
<div class="container main-content">
    <h1>How to Play Fantasy Enduro?</h1>
    <h3>1. Objective </h3>
    <p>The objective of the game is to accrue the most points scored in the World Series Enduro events by selecting the best team of athletes for each event. The better your athletes perform, the more points your fantasy team receives..</p>
    <h3>2. Team Selection</h3>
    <p>Each player may select up to 5 different men and 5 different women for their team (10 racers total).Teams are fixed as of 12PM the night before the race. Team selection reopens after the races are scored. Open or closed team selection status is posted on this site under the set lineup page.</p>
    <h3>3. Scoring</h3>
    <p> Scoring will happen as soon as the results are posted offically on the Enduro World Series website.  Each user gets allocated points for who they picked as their 10 athletes.  A detailed list of the scoring table can be viewed <a href="{{url('scoring-tables')}}">here</a>.  User's also may get <b>bonus points</b> for guessing the top 3 racers in either the mens or womens competitions.  250 bonus points will be added to your weekend score for guessing correctly. </p>
    <h3>4. Leagues</h3>
    <p>Leagues are a fun way to keep track of how you are doing against your friends.  User's can create leagues.  Leagues are either private, meaning that only the league creator can invite people to join, or public where any other user can join.  The list of leagues can be found <a href="{{url('leagues')}}">here</a>. League members may also chat with one another by visiting the specific league's page.</p>
    <h3>5. Prizes</h3>
    <p>We are currently working on getting prizes for the overall winner. Stay tuned!</p>
</div>
@endsection
