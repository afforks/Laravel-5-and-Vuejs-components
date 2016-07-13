@extends('vue.layout')
@section('content')
<!--
	Properties: 
			template : parent template (Generally headings and add button)
			child-template : child template (what to be cloned every time when click on add button)
			body : where to add child-template
			min: minimun child-template rows on creation and delete
	Directives:
		v-add-row : Put it on add button to add new child template
		v-remove-row: Put it on remove button to remove selected row (child template)
	Other :
		index : use index key in form controls (starting with 0)
				i.e. <input type="text" name="item[@{{ index }}][name]"/>
				which results in <input type="text" name="item[0][name]"/>

	Example:
	Javascript:
		var component1 = AddMore.extend({});
		var component2 =  AddMore.extend({template: '#addmore'});
		new Vue({
			el:'body',
			components:{ //register component in vue instance
				'add-more':component1,
				'add-more-other': component2
			}
		});

	HTML:
		<add-more min="1" template="#addmore" child-template="#add-more-row" body="#rows"></add-more>
		<add-more-other min="1" child-template="#component-row" body="#body"></add-more-other>
-->


<div class="container">
	<div class="row">
		<add-more min="2"  child-template="#add-more-row" body="#rows"></add-more>
		<test min="1" template="#addmore1" child-template="#add-more-row1" body="#body"></test>
	</div>
	<div class="row">
	</div>
</div>

@include('vue.template')
@endsection
@section('script')
<script>
var component =  AddMore.extend({template: '#addmore'});
var component2 = AddMore.extend({});

new Vue({
	el:'body',
	components:{
		'add-more':component,
		'test':component2
	}
});
</script>
@endsection