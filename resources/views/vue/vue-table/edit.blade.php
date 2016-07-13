
<!-- Edit View -->

<template id="edit">
  <div class="col-sm-4 col-sm-offset-4">
    <form method="post" action="item/@{{id}}" v-ajax form-data="formData" success-callback="success" error-callback="error">
      {{ method_field('PUT') }}
      <partial name="form"></partial>
      <button type="submit" class="btn btn-primary">Update</button>
      <a href="#" v-link="{ path: '/' }" class="btn btn-success">Cancel</a>
    </form>
  </div>
</template>


<script>
  Vue.component('edit',{
  data:function(){
    return {id:''};
  },
  template:'#edit',
  mixins: [CommonVarMixin,CommonResponseMixin],
  created:function()
  {
      this.id = this.$route.params.id;
      if(Store.edit)
      {
          this.setData(Store.edit);
      }
      else
      {
         this.$http.get("item/"+this.id).then(function(response){
            this.setData(response.data);
         }).catch(function(response){
            console.log(response);

         });
      }
  },
  methods:{
    setData:function(data)
    {
        this.name = data.name;
        this.price = data.price;
        this.no_of_items = data.no_of_items;
        this.discount = data.discount;
    }
  }
});
</script>