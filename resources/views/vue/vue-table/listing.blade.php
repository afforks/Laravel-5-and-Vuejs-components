<!-- Index-->
<template id="index">
<div class="col-sm-offset-9 pull-right">
  <a href="#" v-link="{ path: '/create' }" class="btn btn-primary"> <i class="glyphicon glyphicon-plus"></i> </a>
</div>
<div class="row" style="margin-top:20px;margin-left:20px">
 <div class="row">
      <div class="col-md-5">
          <div class="form-inline form-group" >
              <label>Search:</label>
              <input v-model="searchFor" class="form-control" @keyup.enter="setFilter">
              <button class="btn btn-primary" @click="setFilter">Go</button>
              <button class="btn btn-default" @click="resetFilter">Reset</button>
          </div>
      </div>
      <div class="col-md-7">
          <div class="dropdown form-inline pull-right">
             
              <label>Per Page:</label>
              <select class="form-control" v-model="perPage">
                  <option value=10>10</option>
                  <option value=15>15</option>
                  <option value=20>20</option>
                  <option value=25>25</option>
              </select>
              
          </div>
      </div>
  </div>
  <div class="row">
    <div class="col-sm-2">
        <input v-model="search.name.value" class="form-control"  placeholder="Name">
    </div>
     <div class="col-sm-2">
        <input v-model="search.price.value" class="form-control"  placeholder="Price">
    </div>
    <div class="col-sm-2">
        <input v-model="search.no_of_items.value" class="form-control"  placeholder="Qty">
    </div>
    <div class="cols-m-2">
      <button class="btn btn-info" @click="setMultipleFilter" >Search</button>
      <button class="btn btn-default" @click="resetMultipleFilter" >Cancel</button>
    </div>
  </div>

  <div class="clearfix"></div>
  <br>
   <div class="table-responsive">
            <vuetable v-ref:vuetable
                api-url="/api/items"
                pagination-path=""
                :fields="fields"
                :sort-order="sortOrder"
                table-class="table table-bordered table-striped table-hover"
                ascending-icon="glyphicon glyphicon-chevron-up"
                descending-icon="glyphicon glyphicon-chevron-down"
                :item-actions="itemActions"
                :append-params="moreParams"
                :per-page="perPage" 
            ></vuetable>
        </div>
</div>
</template>


<script>
var tableColumns = [
    {
        name: 'name',
        sortField: 'name',
    },
    {
        name: 'price',
        sortField: 'price',
    },
    {
        name: 'no_of_items',
        sortField: 'no_of_items',
    },
    {
        name: 'discount',
        sortField: 'discount',
    },
    {
        name: 'total',
        sortField: 'total',
        titleClass: 'text-center',
        dataClass: 'text-center',
    },
    {
        name: '__actions',
        dataClass: 'text-center',
    }
];
Vue.component('index',{
    template: '#index',
    data: function(){return {
        searchFor: '',
        fields: tableColumns,
        sortOrder: {
            field: 'name',
            direction: 'asc'
        },
        search:{
            name:{
                op:'like',
                value:'',
                column:'name'
            },
            price:{
                op:'like',
                value:'',
                column:'price'
            },
            no_of_items:{
                op:'=',
                value:'',
                column:'no_of_items'
            }
        },
        perPage: 10,
        itemActions: [
            { name: 'view-item', label: '', icon: 'glyphicon glyphicon-zoom-in', class: 'btn btn-info', extra: {'title': 'View', 'data-toggle':"tooltip", 'data-placement': "left"} },
            { name: 'edit-item', label: '', icon: 'glyphicon glyphicon-pencil', class: 'btn btn-warning', extra: {title: 'Edit', 'data-toggle':"tooltip", 'data-placement': "top"} },
            { name: 'delete-item', label: '', icon: 'glyphicon glyphicon-remove', class: 'btn btn-danger', extra: {title: 'Delete', 'data-toggle':"tooltip", 'data-placement': "right" } }
        ],
        moreParams: [],
      }
    },
    watch: {
        'perPage': function(val, oldVal) {
            this.$broadcast('vuetable:refresh')
        },
    },
    methods: {
        setMultipleFilter:function(){
            this.moreParams = [
              'filters['+this.search.name.column+'][value]='+this.search.name.value+'&filters['+this.search.name.column+'][type]='+this.search.name.op+'&filters['+this.search.price.column+'][value]='+this.search.price.value+'&filters['+this.search.price.column+'][type]='+this.search.price.op +  '&filters['+this.search.no_of_items.column+'][value]='+this.search.no_of_items.value+'&filters['+this.search.no_of_items.column+'][type]='+this.search.no_of_items.op 
            ]
            this.$nextTick(function() {
                  this.$broadcast('vuetable:refresh')
            })
        },
        resetMultipleFilter: function() {
            this.moreParams = [];
            for(prop in this.search)
            {
              this.search[prop].value = '';
            }
            this.$nextTick(function() {
                this.$broadcast('vuetable:refresh')
            })
        },
        setFilter: function() {
            this.moreParams = [
                'filter=' + this.searchFor
            ];
            this.$nextTick(function() {
                this.$broadcast('vuetable:refresh')
            })
        },
        resetFilter: function() {
            this.searchFor = ''
            this.setFilter()
        },
        paginationConfig: function(componentName) {
          this.$broadcast('vuetable-pagination:set-options', {
              wrapperClass: 'pagination',
              icons: { first: '', prev: '', next: '', last: ''},
              activeClass: 'active',
              linkClass: 'btn btn-default',
              pageClass: 'btn btn-default'
          });
        },
        handleDeletion:function(data)
        {
            swal({   title: "Are you sure?",   
                text: "You will not be able to recover this record!",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                closeOnConfirm: false,   
                closeOnCancel: true 
              }, function(isConfirm){   
                if (isConfirm) {     
                  this.delete(data);   
                } 
            }.bind(this));
            
        },
        delete:function(data)
        {
            this.$http.delete("item/"+data.id).then(function(response){
                this.$nextTick(function() {
                    this.$broadcast('vuetable:refresh')
                });
                this.deleted(response);
            }).catch(function(response){
              this.errorWhenDelete(response);
            });
        },
        deleted:function(response)
        {
            swal({   
            title: "Deleted",   
            text: "Your record has been deleted.",   
            timer: 1000,
            type:"success",   
            showConfirmButton: false 
          });
        },
        errorWhenDelete:function(response)
        {
            swal({   
            title: "Error",   
            text: "Something went wrong",   
            type:"error",   
            showConfirmButton: true 
          });
        },
    },
    events: {
        'vuetable:row-changed': function(data) {
            
        },
        'vuetable:row-clicked': function(data, event) {
           
        },
        'vuetable:action': function(action, data) {
            if (action == 'view-item') {
                Store.show = data;
                router.go({ name: 'item.show', params: { id: data.id }})
            } else if (action == 'edit-item') {
                Store.edit = data;
                router.go({ name: 'item.edit', params: { id: data.id }})
            } else if (action == 'delete-item') {
                this.handleDeletion(data);
            }
        },
        'vuetable:load-success': function(response) {
            
        },
        'vuetable:load-error': function(response) {
            if (response.status == 400) {
                sweetAlert('Something\'s Wrong!', response.data.message, 'error')
            } else {
                sweetAlert('Oops', E_SERVER_ERROR, 'error')
            }
        },
    }
})
</script>