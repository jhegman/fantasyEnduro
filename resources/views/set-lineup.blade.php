@extends('layouts.app')

@section('content')
<div class="container">
	<div id="app">
	<div class="row">
		<div class="col-md-6">
			<h2>Available Racers</h2>
			  <draggable :list="list" class="dragArea" :options="{group:'people'}">
			  <div v-for="element in list">@{{element.name}}</div>
			  </draggable>
		</div><!-- /.col-md-6 -->
		<div class="col-md-6">
			<h2>Your Lineup</h2>
			  <draggable :list="list2" class="dragArea" :options="{group:'people'}">
			  <div v-for="element in list2">@{{element.name}}</div>
			  </draggable>
		</div><!-- /.col-md-6 -->
	</div><!-- /.row -->
</div>
@endsection