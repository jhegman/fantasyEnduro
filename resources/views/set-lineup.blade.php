@extends('layouts.app')

@section('content')
<div class="container">
	<div id="app">
	<div class="row">
		<div class="col-md-6">
			<h2>Available Racers</h2>
			<draggable :list="list" class="dragArea" :options="{group:'people'}">
			<div class="racer" v-for="element in list">
				<header class="racer-header">
					<div class="head-shot" v-if="element.photo_url" :style="{backgroundImage: 'url(' + element.photo_url + ')'}"></div><!-- /.head-shot -->
					<div class="head-shot" v-else style="background-image: url({{asset('img/placeholder.jpg')}})"></div><!-- /.head-shot -->
					<h4 class="racer-name">@{{element.name}}</h2>
				</header>
				<div class="racer-stats">
					
				</div><!-- /.racer-stats -->
			</div>
			</draggable>
		</div><!-- /.col-md-6 -->
		<div class="col-md-6">
			<h2>Your Lineup</h2>
			<draggable :list="list2" class="dragArea" :options="{group:'people'}">
			<div class="racer" v-for="element in list2">
				<header class="racer-header">
					<div class="racer-stats">
						<div class="head-shot" v-if="element.photo_url" :style="{backgroundImage: 'url(' + element.photo_url + ')'}"></div><!-- /.head-shot -->
						<div class="head-shot" v-else style="background-image: url({{asset('img/placeholder.jpg')}})"></div><!-- /.head-shot -->
						<h4 class="racer-name">@{{element.name}}</h2>
					</div><!-- /.racer-stats -->
				</header>
			</div>
			</draggable>
		</div><!-- /.col-md-6 -->
	</div><!-- /.row -->
</div>
@endsection