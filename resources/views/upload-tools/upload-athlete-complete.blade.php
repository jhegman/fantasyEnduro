@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Athlete Upload Complete</h1>
    <table>
	<tbody>
	@foreach ($athletes as $athlete)
	<tr>
    <td>{{ $athlete->name}}</td>
    <td>{{ $athlete->gender }}</td>
	</tr>
	@endforeach
	</tbody>
	</table>
</div>
@endsection