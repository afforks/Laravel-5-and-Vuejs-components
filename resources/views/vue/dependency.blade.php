@extends('vue.layout')

@section('content')
<div class="container" style="margin-top:20px;">
<!--
	Directive: v-dependency
	syntax: v-dependency ="model"
	params:
		1) dependent-data : data to be filtered (binding)
		2) target : name of target data variable 
		3) target-id : column name to be filtered
		4) target-model : target model name for reset
-->
<div class="row">
	<div class="col-sm-3">
		<select name="country" class="form-control" v-model="country" v-dependency="country" :dependent-data="states" target="states" target-id="country_id" target-model="state">
			<option value="">--Select Country --</option>
			<option :value="list.id" v-for="list in countries">@{{ list.name }}</option>
		</select>
	</div>
	<div class="col-sm-3">
		<select name="state" class="form-control" v-model="state" v-dependency="state" :dependent-data="cities" target="cities" target-id="state_id" target-model="city">
			<option value="">--Select state --</option>
			<option :value="list.id" v-for="list in states ">@{{ list.name }}</option>
		</select>
	</div>
	<div class="col-sm-3">
		<select name="city" class="form-control" v-model="city">
			<option value="">--Select City --</option>
			<option :value="list.id" v-for="list in cities ">@{{ list.name }}</option>
		</select>
	</div>
</div>
</div>
@endsection

@section('script')

<script>
new Vue({
  el: 'body',
  data:{
  	countries:{!! $countries !!},
  	states:{!! $states !!},
  	cities:{!! $cities !!},
  	country:'',
  	state:'',
  	city:'',
  },
});

</script>
@endsection