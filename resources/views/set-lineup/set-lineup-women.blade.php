@extends('layouts.app')

@section('content')
<div class="container set-lineup-header">
	<div class="row">
		<div class="col-md-6">
			<h3 class="closes">Closes: {{ $closedEST }}</h3>
		</div><!-- /.col-md-6 -->
		<div class="col-md-6 how-scoring-works">
			<button class="btn-primary" @click="showModal = true">How Scoring Works?</button>
		</div><!-- /.col-md-6 -->
	</div><!-- /.row -->
    <div class="panel panel-default short-instructions">
        <div class="panel-body">
            <p>Use the plus/minus buttons or drag and drop to set your lineup. Drag and drop to set the order you think the racers will finish. Bonus points are rewarded for guessing the podium!</p>
        </div>
    </div>
</div><!-- /.container -->
@if($isOpen == false)
<p>Closed!</p>
@else
<!--This is a Vue js Component. It lives in resources/assets/js/components-->
<set-lineup></set-lineup>
@endif
<modal v-if="showModal" @modal-closed="showModal = false" v-cloak>
    <div class="how-scoring-works-wrap" slot="body">
        <h2>How Scoring Works</h2>
        <p>Selects 5 men and 5 women each week in the order you think they will finish. After each weekend of racing the races will be scored and racers will be assigned point values as follows:</p>
        <ul>
        	<li>1st - 400</li>
        	<li>2nd - 350</li>
        	<li>3rd - 320</li>
        	<li>4th - 300</li>
        	<li>5th - 290</li>
        	<li>6th - 280</li>
        	<li>7th - 270</li>
        	<li>8th - 260</li>
        	<li>9th - 250</li>
        	<li>10th - 240</li>
        	<li>etc...</li>
        	<a href="{{ url('/scoring-tables') }}">Full list of point values</a>
        </ul>
        <h3>Bonus Points</h3>
		<p>If you guess the correct order of the podium you get <strong>200 Bonus Points</strong></p>
    </div>
</modal>
@endsection