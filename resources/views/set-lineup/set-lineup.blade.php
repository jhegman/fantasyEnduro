@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<a href="/set-lineup/men" class="lineup-cta men-lineup col-md-6">
			<span class="cta-image"></span>
			<div class="cover"></div><!-- /.cover -->
			<h2 class="cta-title">Set Men's Lineup</h2>
		</a>
		<a href="/set-lineup/women" class="lineup-cta women-lineup col-md-6">
			<span class="cta-image"></span>
			<div class="cover"></div><!-- /.cover -->
			<h2 class="cta-title">Set Women's Lineup</h2>
		</a>
	</div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection