@extends('common.default')
@section('content')
<div class="row">
	<div class="col-xs-5">

		<fieldset>
			<legend>New Target</legend>
			<label for="target">Route</label>
		<select name="target" id="uri">
			<option selected>Chose a Route</option>
			@foreach($routes as $r)
			<option value="{{$r->getPath()}}">{{$r->getPath()}}</option>
			@endforeach
		</select>
		<label for="identifier">Identifier</label>
		<input type="text" name="identifier" class="form-control" id="identifier" placeholder="eg: lpage">
		<label for="desc">Description</label>
		<input type="" name="desc" class="form-control" id="desc" placeholder="eg: Landing Page">
		<span style="position: relative; color: black; display:none; font-size: 24px; font-weight: bold; margin-top: 12px; margin-left: 40px;" class="all-filter-fa" ><i class="fa-li fa fa-spinner fa-spin fa fa-fw" ></i></span><button class="btn btn-primary pull-right" id="addtarget" >ADD</button>
		</fieldset>

	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#addtarget').click(function(){
				var url=JS_BASE_URL+"/admin/general/set/target";
				$.ajax({
				url:url,
				type:'POST',
				data:{
					uri:$('#uri').val(),
					desc:$('#desc').val(),
					identifier:$('#identifier').val()
				},
				sucess:function(r){
					if (r.status=="success") {
						toastr.success(r.long_message);
					}
				},
				error:function(){}
			});
			});
			

		});

	</script>
</div>
@stop