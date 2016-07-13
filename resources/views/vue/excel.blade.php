@extends('vue.layout')
@section('css')
<link rel="stylesheet" href="{{ asset('css/handsontable.full.css') }}">
@endsection
@section('content')
<pre>See in vue devtools for data binding</pre>
<h4>Excel Reader</h4>
<div class="container" style="margin-top:20px">
	<input type="file" v-excel-reader="data">
</div>
<div>
	<pre>
		@{{ $data | json}}
	</pre>
</div>
@endsection

@section('script')
<script type="text/javascript" src="{{asset("js/excel/jszip.js")}}"></script>
<script type="text/javascript" src="{{asset("js/excel/xlsx.min.js")}}"></script>
<script>
new Vue({
	el:'body',
	data:{
		data:{},
	}
});
</script>
@endsection

	
