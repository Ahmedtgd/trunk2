@extends("common.default")

@section("content")
<div class="container" style="margin-top:30px;">
	@include('admin/panelHeading')
	<h2>Administration Module</h2>
	<h3>Warning! Access for Internal Authorized Personnel Only</h3>
	<br><br><br><br><br><br><br><br>
	<div class="col-md-4" style="padding-left:0;padding-right:0">
	<div class="text-center"
	style="background-color:red;color:white;font-size:20px">&nbsp;
	You&nbsp;are&nbsp;actively&nbsp;being&nbsp;monitored!
	&nbsp;</div>
	</div>
	<br><br><br><br>
	@yield("left_sidebar_scripts")
</div>
@stop
