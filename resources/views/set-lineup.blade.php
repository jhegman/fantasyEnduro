@extends('layouts.app')

@section('content')
<div class="container">
	<div id="app">
	<h2>Available Racers</h2>
	  <draggable :list="list" class="dragArea" :options="{group:'people'}">
	  <div v-for="element in list">@{{element.name}}</div>
	  </draggable>
	<h2>List 2 Draggable</h2>
	  <draggable :list="list2" class="dragArea" :options="{group:'people'}">
	  <div v-for="element in list2">@{{element.name}}</div>
	  </draggable>
	</div>
</div>
@endsection