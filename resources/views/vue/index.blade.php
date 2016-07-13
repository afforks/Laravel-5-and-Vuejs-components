@extends('vue.layout')

@section('content')
<div class="container" style="margin-top:20px">
<ul class = "list-group">
   <li class = "list-group-item"><a href="{{ url('/add-more')}}" title="">Add More</a></li>
   <li class = "list-group-item"><a href="{{ url('/dependency')}}" title="">Country - State - City</a></li>
   <li class = "list-group-item"><a href="{{ url('/item')}}" title="">Form (Experimental)</a></li>
   <li class = "list-group-item"><a href="{{ url('/select2')}}" title="">Select 2</a></li>
   <li class = "list-group-item"><a href="{{ url('/csv')}}" title="">CSV Reading & Writing</a></li>
   <li class = "list-group-item"><a href="{{ url('/excel')}}" title="">Excel Reading (Extra) </a></li>
   <li class = "list-group-item"><a href="{{ url('/lern')}}" title="">LERN (Bug notification)</a></li>
   <li class = "list-group-item"><a href="{{ url('/tabs')}}" title="">Tabular form (Vue - router) </a></li>
   <li class = "list-group-item"><a href="{{ url('/images')}}" title="">Image Uploading </a></li>
   <li class = "list-group-item"><a href="{{ url('/vue-table')}}" title="">Vue table </a></li>
   <li class = "list-group-item"><a href="{{ url('/error-page')}}" title="">Error Page </a></li>
   <li class = "list-group-item"><a href="{{ url('/key-events')}}" title="">Key Events </a></li>
</ul>
</div>
@endsection

	
