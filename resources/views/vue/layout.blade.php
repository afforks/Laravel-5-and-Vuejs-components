<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css')}}">
	<meta name="csrf-token" content="{{ csrf_token()}}">
	@yield('css')
</head>
<body>
@yield('content')
<script src="{{ asset('js/vue.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/vue-resource.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/main.js') }}" type="text/javascript"></script>
@yield('script')
</body>
</html>