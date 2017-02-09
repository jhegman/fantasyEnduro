@extends('layouts.app')

@section('content')
@if($isOpen == false)
<p>Closed!</p>
@else
<!--This is a Vue js Component. It lives in resources/assets/js/components-->
<set-lineup></set-lineup>
@endif
@endsection