/** 
	Directive for dependency (ie. country-state-city)
**/

Vue.directive('dependency',{
	params:['dependent-data','target','target-id','target-model'],
	bind: function () 
	{
		this.temp_dependent = this.params.dependentData;
  	},
  	update:function(value)
  	{
	  	this.vm[this.params.targetModel] = '';
	  	this.vm[this.params.target] = this.temp_dependent.filter(function(row){
	  		return row[this.params.targetId] == value;
	  	}.bind(this));
  	},
});

/*
Add more component
*/

var AddMore = Vue.extend({
	props:{
		min:{
			default:0
		},
		childTemplate:{
			required:true
		},
		body:{
			required:true
		},
		template:{
			required:false,
			default:undefined
		}
	},
	data:function(){
		return {index:0,total:0};
	},
	created:function()
	{
		if(this.template)
			this.$options.template = this.template;
	},
	ready:function()
	{
		if(this.min > 0)
		{
			for (var i = 0;i<this.min;i++) {
				this.add();
			}
		}
	},
	methods:{
		add:function()
		{
			this.addRow();
			this.index++;
			this.total++;
		},
		addRow:function()
		{
			var node = new AddMoreRow({template:this.childTemplate,data:function(){return {index:this.index};}.bind(this)}).$mount().$appendTo(this.body);
			node.$parent = this;
		}
	},
	events:{
		'addmore-remove':function(row)
		{
			if(this.total > this.min)
			{
				row.$remove();
				this.total--;
			}
		}
	},
	directives:{
		'add-row':{
			  bind: function () {
			  	this.el.addEventListener('click',this.add.bind(this));
			  },
			  unbind: function () {
			  	this.el.addaddListener('click',this.add.bind(this));
			  },
			  add:function(e){
			  	e.preventDefault();
			  	this.vm.add();
			  }
		}
	}	
});

var AddMoreRow = Vue.extend({
	methods:{
		remove:function(){
			this.$dispatch('addmore-remove',this);
		}
	},
	directives:{
		'remove-row':{
			  bind: function () {
			  	this.el.addEventListener('click',this.remove.bind(this));
			  },
			  unbind: function () {
			  	this.el.addRemoveListener('click',this.remove.bind(this));
			  },
			  remove:function(e){
			  	e.preventDefault();
			  	this.vm.remove();
			  }
		}
	}		
});


/*
Ajax directive
*/
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;

Vue.directive('ajax', {
	params:['form-data','success-callback','error-callback'],
  	bind: function () {
  		this.el.addEventListener('submit',this.onSubmit.bind(this));
  	},
  	unbind: function () {
  		this.el.removeEventListener('submit',this.onSubmit.bind(this));
  	},
  	onSubmit:function(e){
	  	e.preventDefault();
	  	var formData = this.params.formData? this.vm[this.params.formData]:[];
	  	this.vm.$http[this.getRequestType()](this.el.action,formData).
	  	then(this.onComplete.bind(this)).
	  	catch(this.onError.bind(this));
  	},
  	getRequestType:function(e)
	{
		var method = this.el.querySelector('input[name="_method"]');
		return (method?method.value:this.el.method).toLowerCase();
	},
  	onComplete:function(response)
  	{
	  	if(this.params.successCallback)
	  	{
	  		this.vm[this.params.successCallback](response);
	  	}
  	},
  	onError:function(response){
  		if(this.params.errorCallback)
	  	{
	  		this.vm[this.params.errorCallback](response);
	  	}
  	}
});

Vue.directive('delete',{
	params:['url','recordId','success-callback','error-callback'],
	bind:function()
	{
  		this.el.addEventListener('click',this.onClick.bind(this));
	},
	onClick:function(e)
	{
		e.preventDefault();
		swal({   title: "Are you sure?",   
				text: "You will not be able to recover this record!",   
				type: "warning",   
				showCancelButton: true,   
				confirmButtonColor: "#DD6B55",   
				closeOnConfirm: false,   
				closeOnCancel: true 
			}, function(isConfirm){   
				if (isConfirm) {     
					this.delete();   
				} 
		}.bind(this));
	},
	delete:function(){
		var url = this.params.url+'/'+this.params.recordId;
		this.vm.$http.delete(url).
		then(this.onDelete.bind(this)).
	  	catch(this.onError.bind(this));
	},
	onDelete:function(response)
	{
		if(this.params.successCallback)
		{
			this.vm[this.params.successCallback](response);	
		}
		
	},
	onError:function(response){
		if(this.params.errorCallback)
		{
			this.vm[this.params.errorCallback](response);	
		}
	}
});

/**
Pagination component
Parameters :
	url => index page url
	offset => how many link display both side
Events: 
	populate-data => vm have to catch event to populate data

Template:
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
**/
Vue.component('pagination',{
	template:'#pagination-template',
	props:{
		url:{
			required:true
		},
		offset:{
			default:4
		},
	},
	data:function(){
		return {current_page:1,last_page:0,to:0,from:0,sort:'',column:'',value:'',op:''};
	},
	computed:{
		 pages: function(){
            var from = this.current_page - this.offset;
            if(from < 1) {
                from = 1;
            }
            this.from = from;
            var to = from + (this.offset * 2);
            if(to >= this.last_page) {
                to = this.last_page;
            }
            var pages = [];
            while (from <=to) {
                pages.push(from);
                from++;
            }
            this.to = to;
            return pages;
        }
	},
	created:function()
	{
		this.sendRequest(this.current_page);
	},
	methods:{
		fetchItems:function(page)
  		{
			if(page > 0 && this.current_page <= this.last_page)
				this.sendRequest(page);
			else
			{
				if(page<=0)
					this.current_page = 1;
				else
					this.current_page = this.last_page;
			}
  		},
  		setter:function(response)
  		{
  			this.current_page = response.data.current_page;
	  		this.last_page = response.data.last_page;
	  		this.$dispatch('populate-data', response.data.data);
  		},
  		sendRequest:function(page)
  		{
  			var data={page:page,sort:this.sort,column:this.column,value:this.value,op:this.op};
  			this.$http.get(this.url,data).
			  	then(function(response){
			  		this.setter(response);
			  	}.bind(this)).
			  	catch(function(response){
			  		this.$dispatch('populate-data', []);
			  	});
  		}
	},
	events:
	{
		'sort-index':function(data)
		{
			this.sort = data.sort;
			this.column = data.column;
			this.sendRequest(1);
		},
		'search-index':function(data)
		{
			this.value = data.value;
			this.column = data.column;
			this.op = data.op;
			this.sendRequest(1);
		}
	}
});

/* Sort directive 
params:
	column : column name
	sort : asc|desc
Event:
	Dispatches event on vm: sort-event

Note: Coupled with pagination

*/

Vue.directive('sort',{
	params:['column','sort'],
	bind: function () 
	{
  		this.el.addEventListener('click',this.onClick.bind(this));
  	},
  	unbind:function(){
  		this.el.removeEventListener('click',this.onClick.bind(this));
  	},
  	onClick:function(e){
  		e.preventDefault();
  		var data = {
  			column:this.params.column,
  			sort:this.params.sort
  		};
  		this.vm.$dispatch('sort-event',data);
  	}
});

/**
Search directive:
Param: 
	1) Column: column name to filter
	2) value: value of filter
	3) control: i.e. textbox or select
Events:
	1) search-event : Dispatches event on vm, (Pagination component)
Note: Coupled with pagination
**/


Vue.directive('search',{
	params:['column','value','control'],
  	update:function(nv,ov)
  	{
  		var type=this.params.control;
  		if(type == "text")
  			this.fireEvent("like");
  		else if(type == "select")
  			this.fireEvent("=");
  	},
  	fireEvent:function(op)
  	{
  		var data = {
  			column:this.params.column,
  			value:this.params.value,
  			op:op
  		};
  		this.vm.$dispatch('search-event',data);
  	}
});

/**
select 2 directive
params:
	select2-options : object of select 2 options
**/

Vue.directive('select2', {
  twoWay:true,
  params: ['select2-options'],
  bind: function () {
    var self = this
    $(this.el)
      .select2(this.params.select2Options)
      .on('change', function () {
        self.set($(self.el).val())
      })
  },
  update: function (value) {
  	
    $(this.el).val(value).trigger('change')
  },
  unbind: function () {
    $(this.el).off().select2('destroy')
  }
});

/** 
CSV Reader:
params: accepts optional "options" object. (for more options consult doc of papa parse : http://papaparse.com/)
Note: It supports two way binding so pass a model to set parsed value
i.e. v-csv-reader="dataOfCsv" 
**/

Vue.directive('csv-reader',{
	twoWay:true,
	params:['options'],
	bind:function(){
		this.el.addEventListener('change', this.handleFile.bind(this), false);
	},
	unbind:function(){
		this.el.removeEventListener('change', this.handleFile.bind(this), false);
	},
	handleFile:function()
	{
		var self = this;
		if(!this.params.options)
		{
			this.params.options={};
		}
		this.params.options.complete = function(results)
		{
			self.set(results);
		}
		Papa.parse(this.el.files[0], this.params.options);
	}
});

/** 
CSV Writer:
params: 
1) data : data to be unparsed
2) Options : optional options, for more consult papa parse
3) filename: name of file when download
dependency: papaparse and FileSaver.js
**/

Vue.directive('csv-writer',{
	params:['data','options','filename'],
	bind:function(){
		this.el.addEventListener('click', this.writeFile.bind(this), false);
	},
	unbind:function(){
		this.el.removeEventListener('click', this.writeFile.bind(this), false);
	},
	writeFile:function()
	{
		var output='';
		if(!this.params.options)
		{
			this.params.options={};
		}
		if(this.params.data)
		{
			output = Papa.unparse(this.params.data,this.params.options);
		}
		var blob = new Blob([output], {type: "text/csv;charset=utf-8"});
		saveAs(blob, this.params.filename);
	}
});

/**
File upload directive :
params:
	1) field : name of file which will be sent in backend
	2) url: file storing logic url

returns : response 

Note: Two way binding so pass model where to store response
**/
Vue.directive('file-upload',{
	twoWay:true,
	params:['field','url'],
	bind:function()
	{
		this.el.addEventListener('change',this.onChange.bind(this));
	},
	unbind:function(){
		this.el.removeEventListener('change',this.onChange.bind(this));
	},
	onChange:function(e)
	{
		e.preventDefault();
		var formData = new FormData();
		if(this.el.multiple)
		{
			var files = e.target.files;
			for(var i=0;i<files.length;i++)
			{
				formData.append(this.params.field+"["+i+"]",files[i]);
			}
		}
		else
		{
			var files = e.target.files[0];
			formData.append(this.params.field,files);
		}
		this.vm.$http.post(this.params.url,formData).
		then(this.onSubmit.bind(this)).
	  	catch(this.onError.bind(this));
	},
	onSubmit:function(response)
	{
		this.set(response);
	},
	onError:function(response)
	{
		this.set(response);
	}
});


/**
Excel Reader: SheetJS/js-xlsx dependency
For excel file reading.
Note: Pass model to set value
i.e. v-excel-reader="data"
dependency : jszip.js and xlsx.js
**/
Vue.directive('excel-reader',{
	twoWay:true,
	bind:function(){
		this.el.addEventListener('change', this.handleFile.bind(this), false);
	},
	unbind:function(){
		this.el.removeEventListener('change', this.handleFile.bind(this), false);
	},
	fixdata:function(data) {
		var o = "", l = 0, w = 10240;
		for(; l<data.byteLength/w; ++l) o+=String.fromCharCode.apply(null,new Uint8Array(data.slice(l*w,l*w+w)));
		o+=String.fromCharCode.apply(null, new Uint8Array(data.slice(l*w)));
		return o;
	},
	handleFile:function(e) {
		var X = XLSX;
		var files = e.target.files;
		var f = files[0];
		var reader = new FileReader();
		var name = f.name;
		reader.onload = function(e) {
			var data = e.target.result;
			var arr = this.fixdata(data);
			wb = X.read(btoa(arr), {type: 'base64'});
			this.process_wb(wb);
		}.bind(this);
		reader.readAsArrayBuffer(f);
		
	},
	to_array:function(workbook) {
	    var result = {};
	    workbook.SheetNames.forEach(function(sheetName) {
	        var roa = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
	        if(roa.length > 0){
	            result[sheetName] = roa;
	        }
	    });
	    return result;
	},
	process_wb:function(wb) {
		output = this.to_array(wb);
		this.set(output);
	}
});