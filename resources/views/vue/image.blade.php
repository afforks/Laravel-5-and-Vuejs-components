@extends('vue.layout')

@section('content')
<div class="container" style="margin-top:20px">
	<h4>Single File</h4>
	<input type="file"  v-file-upload="upload" field="image" url="/images">
</div>
<div class="container" style="margin-top:20px">
	<h4>Multiple File</h4>
	<input type="file"  multiple="multiple" v-file-upload="upload" field="images" url="/multi-images">
</div>
<div>
	<pre>
		@{{ upload | json}}
	</pre>
</div>
@endsection

@section('script')
<script>


new Vue({
	el:'body',
	data:
	{
		upload:{}
	}
});
</script>
@endsection

	
