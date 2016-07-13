<!-- Show-->
<template id="show">
  <div class="row center-block">
      <table class="table table-bordered">
        <tbody>
          <tr>
            <th>Name</th>
            <td>@{{ name }}</td>
          </tr>
          <tr>
            <th>Price</th>
            <td>@{{ price }}</td>
          </tr>
          <tr>
            <th>Qty</th>
            <td>@{{ no_of_items}}</td>
          </tr>
          <tr>
            <th>Discount</th>
            <td>@{{ discount }}</td>
          </tr>
          <tr>
            <th>Total</th>
            <td>@{{ total}}</td>
          </tr>
        </tbody>
      </table>
  </div>
  <div class="row">
    <div class="col-sm-4 col-sm-offset-4">
      <button class="btn btn-primary" v-link="{path:'/'}"> Back </button>
    </div>
  </div>
</template>

<script>
Vue.component('show',{
  template:'#show',
  mixins: [CommonVarMixin],
  created:function()
  {
      var id = this.$route.params.id;
      if(Store.show)
      {
          this.setData(Store.show);
      }
      else
      {
         this.$http.get("item/"+id).then(function(response){
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
})
</script>
