@extends('vue.layout')

@section('content')
<div class="container" style="margin-top:20px">
<multiselect :selected.sync="selected" :options="options">
</multiselect>
<ul>
	<li v-for="opt in options">@{{ opt }}</li>
</ul>
</div>
<template id="multiselect">
	select
</template>
@endsection
@section('script')
	<script src="{{ asset('js/multi-select/vue-multiselect.js') }}"></script>
	<script>
		new Vue({
			el:'body',
			data:{
				options:{!! $cities !!},
				selected:0
			},
			components:
			{
				'multiselect': VueMultiselect
			}
		});
	</script>
@endsection
	
