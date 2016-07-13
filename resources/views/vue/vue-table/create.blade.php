
<!-- Create -->

<template id="create">
<div class="row" style="margin-top:20px;margin-left:20px">
  <div class="col-sm-4 col-sm-offset-4">
    <form  method="post" action="{{ route('item.post') }}" v-ajax form-data="formData" success-callback="success" error-callback="error">
      <partial name="form"></partial>
      <button type="submit" class="btn btn-primary">Save</button>
      <a href="#"  class="btn btn-success" v-link="{ path: '/' }">Cancel</a>
    </form>
  </div>
</div>
</template>

<script type="text/javascript">
Vue.component('create',{
	template:'#create',
	mixins: [CommonVarMixin,CommonResponseMixin]
});
</script>