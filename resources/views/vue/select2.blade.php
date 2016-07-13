@extends('vue.layout')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
@endsection
@section('content')
<div class="container" style="margin-top:20px">
<h4>Single select</h4>
<select name="" id="select2" v-select2="single">
	<option :value="key" v-for="(key,city) in cities">@{{ city }}</option>
</select>
<h4>Multi select</h4>
<select name="" id="select2"  multiple="" v-select2="multi">
	<option :value="key" v-for="(key,city) in cities">@{{ city }}</option>
</select>

<h4>With options</h4>
<select name="" id="select2"  multiple="" v-select2="selected" :select2-options="select2Options">
	<option :value="key" v-for="(key,city) in cities">@{{ city }}</option>
</select>

<h4>Custom (Image)</h4>
<select name="" id="select2" v-select2="image" :select2-options="imageOptions">
</select>
<pre>Note: using data property in select2 set text property </pre>

</div>
@endsection
@section('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-rc1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>

new Vue({
	el:'body',
	data:{
		selected:'',
		single:'',
		multi:[],
		image:'',
		select2Options:
		{
			tags: true,
			placeholder:'Select'
		},
		imageOptions:
		{
			placeholder:'Select',
			width:"100%",
			data:{!! $states !!},
			templateResult: function (state) {
			  var $state = $(
			    '<span><img src="https://placeholdit.imgix.net/~text?txtsize=10&txt=40%C3%9740&w=40&h=40" /> ' + state.text + '</span>'
			  );
			  return $state;
			}
		},
		cities:{!! $cities !!},
	}
});
</script>
@endsection

	
