<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="{{asset('css/lato.css')}}">
	<link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}"/>
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			{!! $campaign->template !!}
		</div>
	</div>
	
</div>
</body>
</html>