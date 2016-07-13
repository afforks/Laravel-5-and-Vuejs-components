@extends('vue.layout')

@section('content')
<div class="fluid-container" style="margin-top:20px;margin-left:20px">
<div class="table-responsive">
<table class="table table-bordered">
	<thead>
		<tr>
			<th>Url</th>
			<th>Method</th>
			<th>User</th>
			<th>Trace</th>
		</tr>
	</thead>
	<tbody>
		<tr v-for="exception in exceptions">
			<td>@{{ exception.url }}</td>
			<td>@{{ exception.method }}</td>
			<td>@{{ exception.user?exception.user.name: 'N/A' }}</td>
			<td>
				<trace :exception="exception"></trace>
			</td>
		</tr>
	</tbody>
</table>
<pagination url="/api/exceptions"></pagination>
</div>
</div>

<template id="trace">
	<button class="btn btn-success" @click="toggle">@{{label}}</button>
	<div v-if="show">
		<p><strong>File:</strong> @{{exception.file}} </p>
		<p><strong>Line:</strong> @{{exception.line}} </p>
		<p><strong>Class:</strong> @{{exception.class}} </p>
		<p><strong>Message:</strong> @{{exception.message}} </p>
		<p><strong>Data:</strong> @{{exception.data}} </p>
		<p><strong>Trace:</strong> @{{exception.trace}} </p>
	</div>
</template>

<template id="pagination-template">
	<ul class="pagination" v-if="last_page > 1">
		<li :class="{ 'disabled' : current_page == 1}">
		  	<a href="#"  @click.prevent="fetchItems(--current_page)">
		  		<span aria-hidden="true">&laquo;</span>
		  	</a>
		</li>
		<li class="disabled" v-if="(offset * 2) < current_page || from > 1"><a>...</a></li>
		<li v-for="page in pages" :class="{'active': page== current_page }">
		  		<a href="#"  @click.prevent="fetchItems(page)">@{{ page }}</a>
		</li>
		<li class="disabled" v-if="to < last_page"><a>...</a></li>
		<li :class="{ 'disabled' : current_page == last_page}">
		  	<a href="#"  @click.prevent="fetchItems(++current_page)"> <span aria-hidden="true">&raquo;</span></a>
		</li>
	</ul>
</template>
@endsection


@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript">
	Vue.component('trace',{
		template:'#trace',
		props:['exception'],
		data:function(){
			return {show : false,label:'Show'};
		},
		methods:{
			toggle:function()
			{
				this.show = !this.show;
				this.label = this.show ? 'Hide' : 'Show';
			}
		}
	});

	new Vue({
		el:'body',
		data:{
			exceptions:''
		},
		events:{
			'populate-data':function(data)
			{
				this.exceptions = data;
			}
		}
	});
</script>
@endsection
	
