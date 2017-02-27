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
</div><!-- /.container -->
@if($isOpen == false)
<p>Closed!</p>
@else
<!--This is a Vue js Component. It lives in resources/assets/js/components-->
<set-lineup></set-lineup>
@endif
<modal v-if="showModal" @modal-closed="showModal = false" v-cloak>
    <div slot="body">
        <h2>How Scoring Works</h2>
        <p>Selects 5 men and 5 women each week in the order you think they will finish. After each weekend of racing the races will be scored and racers will be assigned point values as follows:</p>
        <ul>
        	<li>1st - 500</li>
        	<li>2nd - 450</li>
        	<li>3rd - 420</li>
        	<li>4th - 400</li>
        	<li>5th - 390</li>
        	<li>6th - 380</li>
        	<li>7th - 370</li>
        	<li>8th - 360</li>
        	<li>9th - 350</li>
        	<li>10th - 340</li>
        	<li>etc...</li>
        	<a href="{{ url('/scoring-tables') }}">Full list of point values</a>
        </ul>
        <h3>Bonus Points</h3>
		<p>If you guess the correct order of the podium you get <strong>250 Bonus Points</strong></p>
    </div>
</modal>
@endsection