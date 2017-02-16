@extends('layouts.app')

@section('content')
<div class="container main-content">
    <h1>Athletes</h1>
    	<!-- Men's Table -->
    	<div class="col-md-6">
    		<div id="men-sort" class="table-responsive">
    		    <h2>Men</h2>
    		    <div class="search-wrap lineup-search">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    <input class="search" type="text" v-model="searchString" placeholder="Search">
                </div><!-- /.search-wrap -->
    		<table class="table table-hover">
				<thead>
						<tr>
						    <th> Name </th>
						    <th> Gender </th>
						</tr>
				</thead>
				<tbody class="list">	
					@foreach ($athletes as $athlete)
					@if ($athlete->gender == 'Men')
						<tr>
    						<td class="name">
    						    @if ($athlete->photo_url != null)	
    						        <img src="{{$athlete->photo_url}}" class="img-circle" height="50px" width="50px">
    						    @else
    						        <img src = "/img/placeholder_athlete.jpg" alt="placeholder" class="img-circle" height="50px" width="50px">
    						    @endif
    						    <a href="{{ url('/athletes',$athlete->id) }}">{{ $athlete->name}}
    						    </a>
    						</td>
   				 			<td>{{ $athlete->gender }}
                            </td>
						</tr>
					@endif
					@endforeach
				</tbody>
			</table>
			</div>
		</div>
 		
 		<!-- Women's Table -->   	
    	<div class="col-md-6">
    		<div id="women-sort" class="table-responsive">
    		<h2>Women</h2>
    		<div class="search-wrap lineup-search">
                <i class="fa fa-search" aria-hidden="true"></i>
                <input class="search" type="text" v-model="searchString" placeholder="Search">
            </div><!-- /.search-wrap -->
    		<table class="table table-hover">
			<thead>
			    <tr>
				<th> Name</th>
				<th> Gender </th>
				</tr>
			</thead>
			<tbody class="list">
				@foreach ($athletes as $athlete)
				@if ($athlete->gender == 'Women')
					<tr>
    				    <td class="name">
    				        @if ($athlete->photo_url != null)	
    				            <img src="{{$athlete->photo_url}}" class="img-circle" height="50px" width="50px">
    				        @else
    				            <img src = "/img/placeholder_athlete.jpg" alt="placeholder" class="img-circle" height="50px" width="50px">
    				        @endif
    				        <a href="{{ url('/athletes',$athlete->id) }}">{{ $athlete->name}}</a>
    				    </td>
   				 	    <td>
                        {{ $athlete->gender }}
                        </td>
					</tr>
				@endif
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection