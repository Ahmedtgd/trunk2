@extends('common.default')
@section('content')

<div class="container" style="width:100%">
  <div class="row" style="margin-bottom:10px;">
    <div class="col-sm-12">
    	<br><br>
        <div class="text-justify">
			<div class="alert alert-danger"></span><strong>Exception : Something went wrong with your database</strong></div>
			<br>
			@if(Session::has('exception_msg'))
			<div class='well'>
				{!! session('exception_msg') !!}
			</div>
			@endif
        </div>
    </div>
  </div>
</div>
<br><br>
@stop
