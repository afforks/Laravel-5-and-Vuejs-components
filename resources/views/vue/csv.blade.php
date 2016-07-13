@extends('vue.layout')
@section('css')
<link rel="stylesheet" href="{{ asset('css/handsontable.full.css') }}">
@endsection
@section('content')
<pre>
	See in Vue devtools for data binding
</pre>


<h4>CSV Reader</h4>
<div class="container" style="margin-top:20px">
	<div class="row">
		<div v-if="alert" class="col-sm-4">
			<div class="alert alert-success">
			  <a href="#" class="close" @click.prevent="alert=false">&times;</a>
			  <strong>Success!</strong> Record added successfully.
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-2">
			<input type="file" v-csv-reader="data" :options="options">
		</div>
		<div class="col-sm-3">
			<button class="btn btn-info" @click="saveData">Upload</button>
		</div>
		<div class="col-sm-5">
			<table class="table table-bordered">
			<thead v-if="data.meta">
				<tr>
					<th v-for="field in data.meta.fields">@{{ field }}</th>
				</tr>
			</thead>
				<tbody>
					<tr v-for="row in data.data">
						<td v-for="col in row">@{{ col }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

</div>
<div>
	
</div>

<pre>
<h4>CSV Writer</h4>
</pre>
<div>
	<button class="btn btn-success" v-csv-writer :data="download" filename="myfile.csv">Download</button>
</div>
@endsection

@section('script')
<script type="text/javascript" src="{{asset("js/csv/papaparse.min.js")}}"></script>
<script type="text/javascript" src="{{asset("js/csv/FileSaver.min.js")}}"></script>
<script>



new Vue({
	el:'body',
	data:{
		data:{},
		options:{
			delimiter:',',
			skipEmptyLines:true,
			header:true
		},
		alert:false,
		download:{}
	},
	ready(){
		this.$http.get('api/all-items').then(function(response){
			this.download = response.data;
		}.bind(this)).catch(function(response){

		}.bind(this));
	},
	methods:{
		saveData:function()
		{
			var data={'data': this.data.data };
			this.$http.post('/save-csv',data).
			then(function(response){
				this.alert=true;
			}).
			catch(function(response){
				console.log(response);

			});
		}
	}
});
</script>
@endsection

	
