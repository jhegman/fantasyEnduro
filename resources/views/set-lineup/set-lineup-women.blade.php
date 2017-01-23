@extends('layouts.app')

@section('content')
<div class="container">
	<input v-model="searchString" placeholder="Search">
	<transition name="fade">
		<div class="alert container set-linup-noty" :save-message="saveMessage" v-bind:class="[saveStatus ? 'alert-success' : 'alert-danger']" @click="closeNoty" v-if="showNoty" role="alert">@{{saveMessage}}</div>
	</transition>
	<div class="row">
		<div class="col-md-6">
			<h2>Available Racers</h2>
			<draggable :list="athletes" class="dragArea" :options="{group:'athletes'}">
			<div class="racer" v-for="athlete in athletes" v-if="athlete.name.toLowerCase().indexOf(searchString.toLowerCase()) > -1" v-cloak>
				<header class="racer-header">
					<div class="head-shot" v-if="athlete.photo_url" :style="{backgroundImage: 'url(' + athlete.photo_url + ')'}"></div><!-- /.head-shot -->
					<div class="head-shot" v-else style="background-image: url({{asset('img/placeholder.jpg')}})"></div><!-- /.head-shot -->
					<h4 class="racer-name">@{{athlete.name}}</h2>
				</header>
				<div class="racer-stats">
					
				</div><!-- /.racer-stats -->
			</div>
			</draggable>
		</div><!--./.col-md-6-->
		<div class="col-md-6">
			<h2>Your Lineup</h2>
			<draggable :list="yourLineup" class="dragArea" :options="yourLineupOptions">
			<div class="racer" v-for="athlete in yourLineup" v-cloak>
				<header class="racer-header">
					<div class="racer-stats">
						<div class="head-shot" v-if="athlete.photo_url" :style="{backgroundImage: 'url(' + athlete.photo_url + ')'}"></div><!-- /.head-shot -->
						<div class="head-shot" v-else style="background-image: url({{asset('img/placeholder.jpg')}})"></div><!-- /.head-shot -->
						<h4 class="racer-name">@{{athlete.name}}</h2>
					</div><!-- /.racer-stats -->
				</header>
			</div>
			</draggable>
		</div><!-- /.col-md-6 -->
	</div><!-- /.row -->
	<button class="btn-primary" @click="onSave">Save Lineup</button>
</div>
@endsection