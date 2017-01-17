@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Athletes</h1>
    <table>
	<tbody>
	@foreach ($athletes as $athlete)
	<tr>
    <td><a href="{{ url('/athletes',$athlete->id) }}">{{ $athlete->name}}</a></td>
    <td>{{ $athlete->gender }}</td>
	</tr>
	@endforeach
	</tbody>
	</table>
</div>
@endsection