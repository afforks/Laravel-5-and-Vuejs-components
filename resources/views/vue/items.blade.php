@extends('vue.layout')
@section('content')
<!-- 
Directive : 
1) v-ajax
	i.e. v-ajax form-data="formData" success-callback="createSuccess" error-callback="error"
		param :
		1) form-data ="value"
				value: name of variable on vm which contains all model
		2) success-callback = "method name"
				method name: name of the method for handling success callback on vm
		3) error-callback="method name"
				method name: name of a method for handling error callback on vm
2) v-delete 
	ie. v-delete url="/item" :record-id="item.id" success-callback="deleted" error-callback="errorDelete"
		param:
		1) url = "base-url"
		2) record-id = "record id"
		3) success-callback = "success callback"
		4) error-callback = "Error Callback"
-->
<div class="row" style="margin-top:20px;margin-left:20px">
	<div class="col-sm-4 col-sm-offset-4" >
		<div :class="{ 'alert':true,'alert-success':type == 'success','alert-danger': type == 'error' }" role="alert" v-show="isAlert">
		  	<button type="button" class="close" @click="isAlert = false" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  	<strong>@{{ type | capitalize}} !</strong> @{{msg}}
		</div>
	</div>
</div>

<!-- Index View -->

<div v-if="currentView == 'index'">
<div class="col-sm-offset-9">
	<a href="#" @click.prevent="createClick" class="btn btn-primary"> <i class="glyphicon glyphicon-plus"></i> </a>
</div>
<div class="clearfix"></div>
<br>
<div class="col-sm-10 col-sm-offset-1">
<table class="table table-bordered">
<thead>
	<tr>
		<td>
			<input type="text" class="form-control" v-search="search.name" column="name" :value="search.name" control="text" v-model="search.name" placeholder="Name">
		</td>
		<td>
			<input type="text" class="form-control" v-search="search.price" column="price" :value="search.price" control="text" v-model="search.price" placeholder="Price">
		</td>
		<td>
			<input type="text" class="form-control" v-search="search.no_of_items" column="no_of_items" :value="search.no_of_items" control="text" v-model="search.no_of_items" placeholder="Quantity">
		</td>
		<td>
			<input type="text" class="form-control" v-search="search.discount" column="discount" :value="search.discount" v-model="search.discount" control="text" placeholder="Discount">
		</td>
		<td>
			<select v-search="search.total" column="total" :value="search.total"  control="select" v-model="search.total" class="form-control">
				<option value="">--Select--</option>
				<option value="110">110</option>
				<option value="73835">73835</option>
			</select>
		</td>
		<td></td>
	</tr>
	<tr>
		<th>Item name <a  href="#" v-sort column="name" sort="asc"><span class="glyphicon glyphicon-arrow-up"></span></a> <a href="#" v-sort column="name" sort="desc"><span class="glyphicon glyphicon-arrow-down"></span></a></th>
		<th>Price <a  href="#" v-sort column="price" sort="asc"><span class="glyphicon glyphicon-arrow-up"></span></a> <a href="#" v-sort column="name" sort="desc"><span class="glyphicon glyphicon-arrow-down"></span></a></th>
		<th>Qty<a  href="#" v-sort column="no_of_items" sort="asc"><span class="glyphicon glyphicon-arrow-up"></span></a> <a href="#" v-sort column="no_of_items" sort="desc"><span class="glyphicon glyphicon-arrow-down"></span></a></th>
		<th>Discount <a  href="#" v-sort column="discount" sort="asc"><span class="glyphicon glyphicon-arrow-up"></span></a> <a href="#" v-sort column="discount" sort="desc"><span class="glyphicon glyphicon-arrow-down"></span></a></th>
		<th>Total <a  href="#" v-sort column="total" sort="asc"><span class="glyphicon glyphicon-arrow-up"></span></a> <a href="#" v-sort column="total" sort="desc"><span class="glyphicon glyphicon-arrow-down"></span></a></th>
		<th>Action</th>
	</tr>
</thead>
<tbody>
	<tr v-for="item in items">
		<td>@{{ item.name}}</td>
		<td>@{{ item.price}}</td>
		<td>@{{ item.no_of_items}}</td>
		<td>@{{ item.discount}}</td>
		<td>@{{ item.total}}</td>
		<td>
			<a href="#" class="btn btn-info"  @click.prevent="editClick(item.id)"> <i class="glyphicon glyphicon-edit"></i></a>
			<a href="#" class="btn btn-danger"  v-delete url="/item" :record-id="item.id" success-callback="deleted" error-callback="errorDelete"> <i class="glyphicon glyphicon-remove"></i> </a>
			&nbsp;&nbsp;
		</td>
	</tr>
</tbody>
</table>

	<pagination url="items"></pagination>

</div>
</div>

<!-- Create View -->

<div v-if="currentView == 'create'">
<div class="row" style="margin-top:20px;margin-left:20px">
	<div class="col-sm-4 col-sm-offset-4">
		<form  method="post" action="{{ route('item.post') }}" v-ajax form-data="formData" success-callback="createSuccess" error-callback="error">
			<partial name="form"></partial>
			<button type="submit" class="btn btn-primary">Save</button>
			<a href="#" @click.prevent="cancelClick" class="btn btn-success">Cancel</a>
		</form>
	</div>
</div>
</div>

<!-- Edit View -->

<div class="row" v-if="currentView == 'edit'">
	<div class="col-sm-4 col-sm-offset-4">
		<form method="post" action="item/@{{id}}" v-ajax form-data="formData" success-callback="updateSuccess" error-callback="error">
			{{ method_field('PUT') }}
			<partial name="form"></partial>
			<button type="submit" class="btn btn-primary">Update</button>
			<a href="#" @click.prevent="cancelClick" class="btn btn-success">Cancel</a>
		</form>
	</div>
</div>

<!-- Form Partial -->

<template id="form">
	{{csrf_field()}}
	<div class="form-group">
		<label for="exampleInputEmail1">Item Name</label>
		<input type="text" class="form-control" placeholder="Item name" name="name" v-model="name">
		<label for="" v-if="errors.name" class="text-danger">@{{ errors.name }}</label>
	</div>
	<div class="form-group">
		<label for="exampleInputPassword1">Price</label>
		<input type="text" class="form-control"  placeholder="Price" name="price" v-model="price">
		<label for="" v-if="errors.price" class="text-danger">@{{ errors.price }}</label>

	</div>
	<div class="form-group">
		<label for="exampleInputFile">No. Of Items</label>
		<input type="text" name="no_of_items"  class="form-control" v-model="no_of_items">
		<label for="" v-if="errors.no_of_items" class="text-danger">@{{ errors.no_of_items }}</label>

	</div>
	<div class="form-group">
		<label for="exampleInputFile">Discount</label>
		<input type="text" name="discount"  class="form-control" v-model="discount">
		<label for="" v-if="errors.discount" class="text-danger">@{{ errors.discount }}</label>

	</div>
	<div class="form-group">
		<label for="exampleInputFile">Total</label>
		<input type="text" name="total"  class="form-control" readonly="readonly" v-model="total">
	</div>
</template>


<!-- Pagination template-->
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
<script>

Vue.partial('form', '#form');

new Vue({
	el:'body',
	data:{
		name:'',
		price:0,
		no_of_items:0,
		discount:0,
		isAlert:false,
		type:'',
		msg:'',
		id:'',
		errors:
		{
			name:'',
			price:'',
			no_of_items:'',
			discount:''
		},
		search:
		{
			name:'',
			price:'',
			no_of_items:'',
			discount:'',
			total:''
		},
		items:[],
		currentView:'index',
		sort:'',
		column:'',
	},
	computed:{
		total:function()
		{
			return (this.price * this.no_of_items) - this.discount;
		},
		formData:function()
		{
			return {
				name:this.name,
				price:this.price,
				no_of_items:this.no_of_items,
				discount:this.discount,
				total:this.total
			};
		}
	},
	events:{
		'populate-data':function(data)
		{
			this.items = data;
		},
		'sort-event':function(data)
		{
			this.$broadcast('sort-index',data);
		},
		'search-event':function(data)
		{
			this.$broadcast('search-index',data);
		}
	},
	methods:{
		createSuccess:function(response)
		{
			this.addItem(response.data.item);
			this.success(response);
		},
		success:function(response)
	  	{
	  		this.setAlert('success',response.data.message);
		  	this.resetForm();
		  	this.removeErrorMessages();
		  	this.currentView = 'index';
	  	},
	  	updateSuccess:function(response)
	  	{
	  		this.updateItem(response.data.item);
			this.success(response);
	  	},
	  	updateItem:function(item)
	  	{
	  		for(var i=0;i<this.items.length;i++)
	  		{
	  			if(item.id == this.items[i].id)
	  			{
	  				this.items[i].name = item.name;
	  				this.items[i].price = item.price;
	  				this.items[i].no_of_items = item.no_of_items;
	  				this.items[i].discount = item.discount;
	  				this.items[i].total = item.total;
	  				break;
	  			}
	  		}
	  	},
	  	addItem:function(item)
	  	{
	  		this.items.unshift(item);
	  	},
	  	error:function(response)
	  	{
	  		this.setAlert('error','Error in form processing....');
	  		for(var prop in response.data)
		  	{
		  		this.errors[prop] = response.data[prop][0];
		  	}
	  	},
	  	resetForm:function()
	  	{
	  		this.name='';
		  	this.price=0;
		  	this.no_of_items=0;
		  	this.discount=0;
		  	this.total=0;
		 },
		removeErrorMessages:function(){
	  		for(var error in this.errors)
	  		{
	  			this.errors[error] = '';
	  		}
  		},
  		deleted:function(response)
  		{
  			this.items = this.items.filter(function(item){
  				return item.id != response.data.item.id;
  			});
  			swal({   
				title: "Deleted",   
				text: "Your record has been deleted.",   
				timer: 1000,
				type:"success",   
				showConfirmButton: false 
			});
  		},
  		errorDelete:function(response)
  		{
  			swal({   
				title: "Error",   
				text: "Something went wrong",   
				type:"error",   
				showConfirmButton: true 
			});
  		},
  		editClick:function(id)
  		{
  			this.currentView ='edit'; 
  			this.id =id;
  			this.fillDataForEdit(id);
  			this.removeErrorMessages();
		},
		fillDataForEdit:function(id)
		{
			for(var i=0;i<this.items.length;i++)
			{
				if(this.items[i].id == id)
				{
					this.name = this.items[i].name;
					this.price = this.items[i].price;
					this.no_of_items = this.items[i].no_of_items;
					this.discount = this.items[i].discount;
					this.total = this.items[i].total;
					break;
				}
			}
		},
		setAlert:function(type,msg)
		{
		  	this.isAlert = true;
			this.type=type;
	  		this.msg = msg;
		},
		cancelClick:function()
		{
			this.currentView='index';
			this.isAlert = false;
		  	this.resetForm();
		},
		createClick:function()
		{
			this.currentView='create';
			this.removeErrorMessages();
		}
	}
});
</script>
@endsection