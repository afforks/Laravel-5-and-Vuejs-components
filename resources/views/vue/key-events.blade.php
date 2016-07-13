@extends('vue.layout')
@section('css')
<style>
   .button
   {
      display: inline-block;
       color: #aaa;
       font: bold 9pt arial;
       text-decoration: none;
       text-align: center;
       width: 70px;
       height: 41px;
       margin: 5px;
       background: #eff0f2;
       -moz-border-radius: 4px;
       border-radius: 4px;
       border-top: 1px solid #f5f5f5;
       -webkit-box-shadow: inset 0 0 25px #e8e8e8, 0 1px 0 #c3c3c3, 0 2px 0 #c9c9c9, 0 2px 3px #333;
       -moz-box-shadow: inset 0 0 25px #e8e8e8, 0 1px 0 #c3c3c3, 0 2px 0 #c9c9c9, 0 2px 3px #333;
       box-shadow: inset 0 0 25px #e8e8e8, 0 1px 0 #c3c3c3, 0 2px 0 #c9c9c9, 0 2px 3px #333;
       text-shadow: 0px 1px 0px #f5f5f5;
   }
   span.key {
    display: block;
    margin: 13px 0 0;
    text-transform: uppercase;
   }
</style>
@endsection

@section('content')
<div class="container" v-if="currentView == 'home'" style="margin-top:20px" v-key-events key="?" callback="showHelp">
   <p>
      <strong> press shift + ? for help</strong>
   </p>
</div>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Help</h4>
      </div>
      <div class="modal-body">
        <p><a class="button"> <span class="key"> ctrl + o </span></a> <label for="">Open Form</label></p>
        <p><a class="button"> <span class="key"> ctrl + s </span></a> <label for="">Save Form</label></p>
        <p><a class="button"> <span class="key"> Esc </span></a> <label for="">Close</label></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div v-if="currentView == 'create'">
<div class="row" style="margin-top:20px;margin-left:20px">
   <div class="col-sm-4 col-sm-offset-4">
      <form  method="post" action="{{ route('item.post') }}">
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
         <button type="button" class="btn btn-primary">Save</button>
         <a href="#" @click.prevent="cancelClick" class="btn btn-success">Cancel</a>
      </form>
   </div>
</div>
</div>


@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<script src="{{ asset('js/mousetrap.min.js') }}"></script>
<script>
/**
 * make directive or bind in vm hook methods i.e. created , ready etc.
 * dependent on mousetrap library
 * for more api: https://craig.is/killing/mice
 */
      Vue.directive('key-events',{
         acceptStatement: true,
         params:['key','callback'],
         bind:function()
         {
           Mousetrap.bind([this.params.key],this.bindKey.bind(this) );
         },
         unbind:function(){
           Mousetrap.unbind(this.params.key,this.bindKey.bind(this) );
         },
         bindKey:function(e)
         {
            this.vm[this.params.callback](e);
         }
      });

   new Vue({
      el:'body',
      data:{
         currentView:'home',
         name:'',
         price:0,
         no_of_items:0,
         discount:0,
         errors:
         {
            name:'',
            price:'',
            no_of_items:'',
            discount:''
         },
      },
      ready:function()
      {
          Mousetrap.bind("ctrl+o",this.open.bind(this) );
          Mousetrap.bind("ctrl+s",this.submit.bind(this) );
          Mousetrap.bind("esc",this.cancel.bind(this) );
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
      },
   },
    methods:{
         showHelp(){
            $('#myModal').modal('show');
         },
         error:function(response)
         {
            for(var prop in response.data)
            {
               this.errors[prop] = response.data[prop][0];
            }
         },
         submit:function(e)
         {
              e.preventDefault();
              this.$http.post("{{ route('item.post') }}",this.formData).
              then(this.onComplete).
              catch(this.error);
         },
          open:function(e)
         {
            e.preventDefault();
            this.removeErrorMessages();

            this.currentView = 'create'
         },
         cancelClick:function()
         {
             this.currentView = 'home'

         },
         onComplete:function(response)
         {
            // console.log(response);
            swal('Record added successfully');
            this.resetForm();
            this.currentView = 'home';
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
        cancel:function()
        {
          $('#myModal').modal('hide');
          this.currentView = "home";
        }
    }
   });
</script>
@endsection

	
