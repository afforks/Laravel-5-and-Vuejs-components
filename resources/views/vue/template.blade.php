<template id="addmore">
<table class="table table-bordered table-striped">
<thead>
	<tr>
		<th>Add more demo</th>
		<th><a href="#"  title="Add New" v-add-row> Add </a></th>
	</tr>
</thead>
	<tbody id="rows">

	</tbody>
</table>
</template>

<template id="add-more-row">
<tr>
	<td>
		<div class="col-sm-4">
			<div class="form-group">
				<input type="text" class="form-control" name="items[@{{ index }}][name]" placeholder="Name">
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<input type="text" class="form-control" name="items[@{{ index }}][age]" placeholder="Age">
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<input type="text" class="form-control" name="items[@{{ index }}][other]" placeholder="Other">
			</div>
		</div>
	</td>
	<td>
		<a href="#" v-remove-row> Remove </a>
	</td>
</tr>
</template>


<template id="addmore1">
<div class="row">
	<div class="col-sm-3">
		<h4>Add more demo <a href="#" class="btn btn-success" v-add-row > <i class="glyphicon glyphicon-plus"></i> </a></h4>
	</div>
</div>
<div id="body">
	
</div>
</template>

<template id="add-more-row1">
<div class="col-sm-3">
	<form role="form">
	  <div class="form-group">
	    <label for="email">Email address:</label>
	    <input type="email" class="form-control" id="email" name="items[@{{ index }}][email]">
	  </div>
	  <div class="form-group">
	    <label for="pwd">Password:</label>
	    <input type="password" class="form-control" id="pwd" name="items[@{{ index }}][password]">
	  </div>
	  <div class="checkbox">
	    <label><input type="checkbox" name="items[@{{ index }}][remember]"> Remember me</label>
	  </div>
	  <button type="submit" class="btn btn-default">Submit</button>
	  <button type="button" class="btn btn-danger" v-remove-row> X </button>
	</form>
</div>
</template>



