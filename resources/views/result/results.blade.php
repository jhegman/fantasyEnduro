@extends('layouts.app')

@section('content')
<div class="container main-content">
    <h1>Results</h1>
    <table>
	<tbody>
	@foreach($races as $race)
	<tr>
    <td>
    <a href="{{ url('/results',$race->id) }}">{{ $race->name }}, {{ $race->location }}</td>
    </a>
	</tr>
	@endforeach
	</tbody>
	</table>
</div>
@endsection