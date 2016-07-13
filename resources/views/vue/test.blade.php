@extends('vue.layout')

@section('content')

<hello-world template="#tmpl1"></hello-world>	
<hello-world template="#tmpl1"></hello-world>
<test template="#tmpl2"> </test>	

<template id="tmpl1">
	<table>
		<tr>
			<td>
				laura
			</td>
		</tr>
	</table>
</template>


<template id="tmpl2">
	<p>Hello World 2</p>
</template>

@endsection

@section('script')

<script>
var HelloWorld = Vue.extend({
	props:['template'],
	created(){
		this.$options.template = this.template;
	},
});
var test = HelloWorld;
var test1 = HelloWorld.extend({template:'#tmpl2'});
new Vue({
  el: 'body',
  components:{
  	'test' : test,
  	'hello-world' : test1
  }
});

</script>
@endsection