@extends('layouts.app')

@section('content')
<div id="league-sort" class="container">
    <h1>{{ $league->name }}</h1>
    <table>
	<tbody>
	@foreach($users as $user)
	<tr>
    <td>
    {{$user->username}}
    </td>
	</tr>
	@endforeach
	</tbody>
	</table>
</div>
@endsection