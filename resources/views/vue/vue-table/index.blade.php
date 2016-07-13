@extends('vue.layout')
@section('content')
<div class="container" style="margin-top:20px">
  <strong>Single Page Application</strong>
  <hr>
 <router-view></router-view>
</div>
@endsection
@section('script')
<script src="{{ asset('js/vue-table.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/vue-router.min.js') }}" type="text/javascript"></script>
@include('vue.vue-table.common')
@include('vue.vue-table.listing')
@include('vue.vue-table.form')
@include('vue.vue-table.create')
@include('vue.vue-table.edit')
@include('vue.vue-table.show')
@include('vue.vue-table.routes')
@endsection

  
