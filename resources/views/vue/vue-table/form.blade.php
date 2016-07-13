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

<script>
  Vue.partial('form', '#form');
</script>

