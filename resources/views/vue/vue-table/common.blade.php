<script>
var Store={}; //store pattern
var CommonVarMixin = {
  data:function()
    {
      return {
        name:'',
        price:0,
        no_of_items:0,
        discount:0,
      };
    },
    computed:{
      total:function()
      {
        return (this.price * this.no_of_items) - this.discount;
      },
    }
};

var CommonResponseMixin = {
    data:function(){
      return {
        errors:
          {
            name:'',
            price:'',
            no_of_items:'',
            discount:''
          },
      }
    },
    computed:{
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
  methods:
  {
    error:function(response)
    {
      for(var prop in response.data)
      {
        this.errors[prop] = response.data[prop][0];
      }
    },
    success:function(response)
    {
      router.go('/');
    },
  }
} 
</script>