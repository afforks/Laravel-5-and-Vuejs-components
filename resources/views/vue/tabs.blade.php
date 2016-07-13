@extends('vue.layout')

@section('content')
<div class="container" style="margin-top:20px">
<ul class="nav nav-tabs">
  <li :class="{ 'active': tab == 'home' }"><a href="#" v-link="{ path: '/' }" @click="tab='home'">Home</a></li>
  <li :class="{ 'active': tab == 'country' }"><a href="#" v-link="{ path: '/countries' }" @click="tab='country'">Country</a></li>
  <li :class="{ 'active': tab == 'state' }"><a href="#" v-link="{ path: '/states' }" @click="tab='state'">State</a></li>
  <li :class="{ 'active': tab == 'city' }"><a href="#" v-link="{ path: '/cities' }" @click="tab='city'">City</a></li>
  <li :class="{ 'active': tab == 'item' }"><a href="#" v-link="{ path: '/items' }" @click="tab='item'">Item</a></li>
</ul>
<router-view></router-view>
</div>

<!-- Templates -->

<template id="demo">
	<table class="table table-bordered">
		<thead>
			<th>Sr no</th>
			<th>Name</th>
		</thead>
		<tbody>
			<tr v-for="(key,row) in list">
				<td>@{{ key + 1 }}</td>
				<td >@{{ row.name }}</td>
			</tr>
		</tbody>
	</table>
</template>


<template id="item">
	<table class="table table-bordered">
<thead>
	
	<tr>
		<th>Item name </th>
		<th>Price </th>
		<th>Qty</th>
		<th>Discount </th>
		<th>Total</th>
	</tr>
</thead>
<tbody>
	<tr v-for="item in items">
		<td>@{{ item.name}}</td>
		<td>@{{ item.price}}</td>
		<td>@{{ item.no_of_items}}</td>
		<td>@{{ item.discount}}</td>
		<td>@{{ item.total}}</td>
	</tr>
</tbody>
</table>

<pagination url="items"></pagination>
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
<script src="{{ asset('js/vue-router.min.js') }}" type="text/javascript"></script>

<script>
Vue.component('home',{
	template:'<div><h4>Welcome !</h4> </div>',
});

Vue.component('country',{
	template:'#demo',
	ready()
	{
		this.fetchCountries();
	},
	data:function(){
		return { list:''};
	},
	methods:{
		fetchCountries:function(){
			this.$http.get('api/countries').
		  	then(function(response){
		  		this.list =  response.data;
		  		
		  	}.bind(this)).
		  	catch(function(response){
		  		this.list = [];
		  	});
		}
	}
});

Vue.component('state',{
	template:'#demo',
	ready()
	{
		this.fetchStates();
	},
	data:function(){
		return { list:''};
	},
	methods:{
		fetchStates:function(){
			this.$http.get('api/states').
		  	then(function(response){
		  		this.list =  response.data;
		  	}.bind(this)).
		  	catch(function(response){
		  		this.list = [];
		  	});
		}
	}
});


Vue.component('city',{
	template:'#demo',
	ready()
	{
		this.fetchStates();
	},
	data:function(){
		return { list:''};
	},
	methods:{
		fetchStates:function(){
			this.$http.get('api/cities').
		  	then(function(response){
		  		this.list =  response.data;
		  	}.bind(this)).
		  	catch(function(response){
		  		this.list = [];
		  	});
		}
	}
});

Vue.component('item',{
	template:'#item',
	data:function(){
		return {
			items:'',

		};
	},
	events:{
		'populate-data':function(data){
			this.items = data;
		},
	}
});



var App = Vue.extend({
	data:function()
	{
		return {tab:'home'};
	}
});
var router = new VueRouter();

router.map({
	'/':{
		component: Vue.component('home')
	},
	'/countries':{
		component: Vue.component('country')
	},
	'/states':{
		component: Vue.component('state')
	},
	'/cities':{
		component: Vue.component('city')
	},
	'/items':{
		component: Vue.component('item')
	}
});

router.start(App,'body');

</script>
@endsection

	
