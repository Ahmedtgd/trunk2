<?php 
use App\Http\Controllers\IdController;
$marr = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
?>
<style>
	.statement{
		background: #e6e6e6;
		width: 100%;
		padding: 10px;
		margin: 0 auto;
		border: 2px solid #e6e6e6;
		border-radius: 25px;
	}
	.ym{background: #c6c6c6;width: 100%;margin: 0 auto;padding: 5px;border-radius: 25px;}
	button{font-family: sans-serif;border: none;width: 45px;}
	.btn-enable{background: lightblue;}
	.btn-disable{background: #4d4d4d;color:white;}

</style>


<div class="statement" style="">
	<h2 style="font-family: sans-serif">{{$title}}</h2>
	<span>{{$name or ''}}</span><br>
	{{$company or ''}}<br>
	{{ $s->line1 or '' }}<br>
	{{ $s->line2 or '' }}<br>
	{{ $s->line3 or '' }}<br>
	{{ $s->line4  or '' }}<br>
	<div class="ym">
		{{--*/ $y = 1; $index = 0;/*--}}

		<?php if((is_null($myreturn)) || ($current_year == 0)){ $carbon = new Carbon();?>
			<div style="margin: 5px;">
				<span style="font-family: sans-serif;font-size: large;">
				{{date('Y')}}{{':'}}</span>
				@for($i = 1; $i <= 12; $i++)
					<button class="btn-disable btn btn-sm primary-btn" disabled>
						{{$marr[$i-1]}} 
					</button>
				@endfor
			</div>
		<?php } ?>
			
		@foreach($myreturn as $returned)
			<?php 
			$created_at = new Carbon\Carbon($returned->created_at); $carbon = new Carbon(); $m = $years[$created_at->year]; // dump($m[0]); // sort($m); // $month = $m[0];
			$index = 0; 
			?>
			@if($y != $created_at->year)
				<div style="margin: 5px;">
					<span style="font-family: sans-serif;font-size: large;">{{$created_at->year}}{{':'}}</span>
					@for($i = 1; $i <= 12; $i++)
						@if(in_array($i , $m) )
							<button class="btn-enable btn btn-sm primary-btn"
									onclick="statement({{$id}}{{','}}{{$created_at->year}}{{','}}{{$i}});">
								{{$marr[$i-1]}} 
							</button>
							<?php //if($index < count($m) - 1) $month = $m[++$index]; ?>
						@else
							<button class="btn-disable btn btn-sm primary-btn" disabled>
								{{$marr[$i-1]}} 
							</button>
						@endif
					@endfor
				</div>
			@endif
			<?php  $y = $created_at->year; ?>
		@endforeach
	</div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document" style="">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" id="myModalLabel1">Merchant</h2>
			</div>
			<div class="modal-body" id="modalbody" style="background:#F2F2F2;">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="stModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document" style="width:80%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" id="myModalLabel2">Station</h2>
			</div>
			<div class="modal-body" id="stmodalbody">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" style="min-width: 60px;">Close</button>
			</div>
		</div>
	</div>
</div>
<br>
<br>
<script src="{{url('js/jquery.dataTables.min.js')}}"></script>
<script>

	function statement(id,year,month) {
		var mid=$('#merchandID').val();
		var url="{{url()}}"+"/m/"+month+"/"+year+"/"+mid;
		window.open(url);
	}
	
	function statementrc(id,year,month) {
		//get the merchant data from the backend and render on the modal
		console.log(month);
		var mid=$('#merchandID').val();
		$("#h" + year + "-" + month).hide();
		$("#i" + year + "-" + month).show();
		$.ajax({
			type: "POST",
			url: JS_BASE_URL+"/statement/merchantdetailrc",
			data: { mid:mid,id:id,year:year,month:month },
			beforeSend: function(){},
			success: function(response){
				$('#stmodalbody').html(response);
				$('#stModal').modal('toggle');
				$("#h" + year + "-" + month).show();
				$("#i" + year + "-" + month).hide();
			}
		});
	}
	
	function statementgst(id,year,month) {
		//get the merchant data from the backend and render on the modal
		console.log(month);
		var mid=$('#merchandID').val();
		$("#hgst" + year + "-" + month).hide();
		$("#igst" + year + "-" + month).show();
		$.ajax({
			type: "POST",
			url: JS_BASE_URL+"/statement/merchantdetailgst",
			data: { mid:mid,id:id,year:year,month:month },
			beforeSend: function(){},
			success: function(response){
				$('#stmodalbody').html(response);
				$('#stModal').modal('toggle');
				$("#hgst" + year + "-" + month).show();
				$("#igst" + year + "-" + month).hide();
			}
		});
	}	

	function statementr(id,year,month) {
		//get the merchant data from the backend and render on the modal
		console.log(month);
		var mid=$('#merchandID').val();
		$("#t" + year + "-" + month).hide();
		$("#r" + year + "-" + month).show();
		console.log("mid: "+ mid);
		console.log("id: "+ id);
		console.log("year: "+ year);
		console.log("month: "+ month);

		$.ajax({
			type: "POST",
			url: JS_BASE_URL+"/statement/trackingreport",
			data: { mid:mid,id:id,year:year,month:month },
			beforeSend: function(){},
			success: function(response){
				$('#trmodalbody').html(response);
				$('#trModal').modal('toggle');
				$("#t" + year + "-" + month).show();
				$("#r" + year + "-" + month).hide();
			}
		});
	}
	
	function statementsm(id,year,month) {
		//get the merchant data from the backend and render on the modal
		console.log(month);
		var mid=$('#merchandID').val();
		$("#smt" + year + "-" + month).hide();
		$("#smr" + year + "-" + month).show();
		console.log("mid: "+ mid);
		console.log("id: "+ id);
		console.log("year: "+ year);
		console.log("month: "+ month);

		$.ajax({
			type: "POST",
			url: JS_BASE_URL+"/statement/salesmemo",
			data: { mid:mid,id:id,year:year,month:month },
			beforeSend: function(){},
			success: function(response){
				$('#smmodalbody').html(response);
				$('#smModal').modal('toggle');
				$("#smt" + year + "-" + month).show();
				$("#smr" + year + "-" + month).hide();
			}
		});
	}	
</script>

<div class="statement" style="">
	<h2 style="font-family: sans-serif">{{$titlerec}}</h2>
	<span>{{$namerec or ''}}</span><br>
	{{$companyrec or ''}}<br>
	{{ $srec->line1 or '' }}<br>
	{{ $srec->line2 or '' }}<br>
	{{ $srec->line3 or '' }}<br>
	{{ $srec->line4  or '' }}<br>
	<div class="ym">
		{{--*/ $y = 1; $index = 0;/*--}}

		<?php if((is_null($myreturnrec)) || ($current_yearrec == 0)){ $carbon = new Carbon();?>
			<div style="margin: 5px;">
					<span style="font-family: sans-serif;font-size: large;">{{date('Y')}}{{':'}}</span>
					@for($i = 1; $i <= 12; $i++)
							<button class="btn-disable btn btn-sm primary-btn" disabled>
								{{$marr[$i-1]}}
							</button>
					@endfor
			</div>
		<?php } ?>
		<input type="hidden" id="merchandID" value="{{$merchant_id}}">
		<input type="hidden" id="stationID" value="{{$station_id}}">
		@foreach($myreturnrec as $returned)
			<?php $created_at = new Carbon\Carbon($returned->created_at); $carbon = new Carbon();
			try {
				$m = $years[$created_at->year]; 
			} catch (\Exception $e) {
				$m=[1,2];
			}
			

			sort($m);$month = $m[0]; $index = 0;
			?>
			@if($y != $created_at->year)
				<div style="margin: 5px;">
					<span style="font-family: sans-serif;font-size: large;">{{$created_at->year}}{{':'}}</span>
					@for($i = 1; $i <= 12; $i++)
						@if($i === $month )
							<button class="btn-enable btn btn-sm primary-btn"
									onclick="statementrc({{$id}}{{','}}{{$created_at->year}}{{','}}{{$i}});">
								<span id="h{{$created_at->year}}-{{$i}}">{{$marr[$i-1]}} </span>
								<span style="display: none;" id="i{{$created_at->year}}-{{$i}}">...</span>
							</button>
							{{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
						@else
							<button class="btn-disable btn btn-sm primary-btn" disabled>
								<span id="h{{$created_at->year}}-{{$i}}">{{$marr[$i-1]}} </span>
								<span style="display: none;" id="i{{$created_at->year}}-{{$i}}">...</span>
							</button>
						@endif
					@endfor
				</div>
			@endif
			{{--*/ $y = $created_at->year; /*--}}
		@endforeach
	</div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document" style="">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" id="myModalLabel1">Merchant</h2>
			</div>
			<div class="modal-body" id="modalbody" style="background:#F2F2F2;">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="stModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document" style="width:80%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" id="myModalLabel2">Sales Memo</h2>
			</div>
			<div class="modal-body" id="stmodalbody">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" style="min-width: 60px;">Close</button>
			</div>
		</div>
	</div>
</div>

<br>
<br>

<!-- Tracking Report Document Type  Start-->

<div class="statement" style="">
	<h2 style="font-family: sans-serif">{{$titletr}}</h2>
	<span>{{$nametr or ''}}</span><br>
	{{$companytr or ''}}<br>
	{{ $str->line1 or '' }}<br>
	{{ $str->line2 or '' }}<br>
	{{ $str->line3 or '' }}<br>
	{{ $str->line4  or '' }}<br>
	<div class="ym">
		{{--*/ $y = 1; $index = 0;/*--}}

	
		<?php if((is_null($myreturntr)) || ($current_yeartr == 0)){ $carbon = new Carbon();?>
			<div style="margin: 5px;">
					<span style="font-family: sans-serif;font-size: large;">{{date('Y')}}{{':'}}</span>
					@for($i = 1; $i <= 12; $i++)
							<button class="btn-disable btn btn-sm primary-btn" disabled>
								{{$marr[$i-1]}}
							</button>
					@endfor
			</div>
		<?php } ?>			 
	
		@foreach($myreturntr as $returned)
			<?php 

			$created_at = new Carbon\Carbon($returned->created_at);
			$carbon = new Carbon();
			// dump($returned->created_at);
			// dump($yearstr);
			try {
				$m = $yearstr[$created_at->year]; 
			} catch (\Exception $e) {
				// dump($e->getMessage());
				$m=[1];
			}
			

			sort($m);
			$month = $m[0];
			$index = 0;
			?>
			@if($y != $created_at->year)
				<div style="margin: 5px;">
					<span style="font-family: sans-serif;font-size: large;">{{$created_at->year}}{{':'}}</span>
					@for($i = 1; $i <= 12; $i++)
						@if($i === $month )
							<button class="btn-enable btn btn-sm primary-btn"
									onclick="statementr({{$id}}{{','}}{{$created_at->year}}{{','}}{{$i}});">
								<span id="t{{$created_at->year}}-{{$i}}">{{$marr[$i-1]}}</span>
								<span style="display: none;" id="r{{$created_at->year}}-{{$i}}">...</span>
							</button>
							{{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
						@else
							<button class="btn-disable btn btn-sm primary-btn" disabled>
								<span id="t{{$created_at->year}}-{{$i}}">{{$marr[$i-1]}}</span>
								<span style="display: none;" id="r{{$created_at->year}}-{{$i}}">...</span>
							</button>
						@endif
					@endfor
				</div>
			@endif
			{{--*/ $y = $created_at->year; /*--}}
		@endforeach
	</div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document" style="">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" id="myModalLabel1">Merchant</h2>
			</div>
			<div class="modal-body" id="modalbody" style="background:#F2F2F2;">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="trModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document" style="width:50%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" id="trModalLabel2">Station</h2>
			</div>
			<div class="modal-body" id="trmodalbody">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" style="min-width: 60px;">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Tracking Report Document Type End -->
<br>
<br>
<!-- Sales Memo -->
<div class="statement" style="">
	<h2 style="font-family: sans-serif">{{$titlesm}}</h2>
	<span>{{$namesm or ''}}</span><br>
	{{$companysm or ''}}<br>
	{{ $ssm->line1 or '' }}<br>
	{{ $ssm->line2 or '' }}<br>
	{{ $ssm->line3 or '' }}<br>
	{{ $ssm->line4  or '' }}<br>
	<div class="ym">
		{{--THE CODE BELOW IS NOT A COMMENT --}}
		{{--*/ $y = 1; $index = 0;/*--}}

	
		<?php if((is_null($myreturnsm)) || ($current_yearsm == 0)){ $carbon = new Carbon();?>
			<div style="margin: 5px;">
					<span style="font-family: sans-serif;font-size: large;">{{date('Y')}}{{':'}}</span>
					@for($i = 1; $i <= 12; $i++)
							<button class="btn-disable btn btn-sm primary-btn" disabled>
								{{$marr[$i-1]}}
							</button>
					@endfor
			</div>
		<?php } ?>		
		@foreach($myreturnsm as $returned)
			<?php $created_at = new Carbon\Carbon($returned->created_at); $carbon = new Carbon();
			try {
				$m = $yearssm[$created_at->year]; 
			} catch (\Exception $e) {
				$m=[1];
			}
			

			sort($m);$month = $m[0]; $index = 0;
			
			// dump($created_at->year);
			?>
			@if($y != $created_at->year)
				<div style="margin: 5px;">
					<span style="font-family: sans-serif;font-size: large;">{{$created_at->year}}{{':'}}</span>
					@for($i = 1; $i <= 12; $i++)
						@if($i === $month )
							<button class="btn-enable btn btn-sm primary-btn"
									onclick="statementsm({{$id}}{{','}}{{$created_at->year}}{{','}}{{$i}});">
								<span id="smt{{$created_at->year}}-{{$i}}">{{$marr[$i-1]}}</span>
								<span style="display: none;" id="smr{{$created_at->year}}-{{$i}}">...</span>
							</button>
							{{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
						@else
							<button class="btn-disable btn btn-sm primary-btn" disabled>
								<span id="smt{{$created_at->year}}-{{$i}}">{{$marr[$i-1]}}</span>
								<span style="display: none;" id="smr{{$created_at->year}}-{{$i}}">...</span>
							</button>
						@endif
					@endfor
				</div>
			@endif
			{{--*/ $y = $created_at->year; /*--}}
		@endforeach
	</div>
</div>
<!-- Sales Memo End -->
<div class="modal fade" id="smModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document" style="width:50%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" id="smModalLabel2">Sales Memo</h2>
			</div>
			<div class="modal-body" id="smmodalbody">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" style="min-width: 60px;">Close</button>
			</div>
		</div>
	</div>
</div>
<br>
<div class="statement" style="">
	<h2 style="font-family: sans-serif">GST Report</h2>
	<span>{{$namerec or ''}}</span><br>
	{{$companyrec or ''}}<br>
	{{ $srec->line1 or '' }}<br>
	{{ $srec->line2 or '' }}<br>
	{{ $srec->line3 or '' }}<br>
	{{ $srec->line4  or '' }}<br>
	<div class="ym">
		{{--*/ $y = 1; $index = 0;/*--}}

		<?php if((is_null($myreturnrec)) || ($current_yearrec == 0)){ $carbon = new Carbon();?>
			<div style="margin: 5px;">
					<span style="font-family: sans-serif;font-size: large;">{{date('Y')}}{{':'}}</span>
					@for($i = 1; $i <= 12; $i++)
							<button class="btn-disable btn btn-sm primary-btn" disabled>
								{{$marr[$i-1]}}
							</button>
					@endfor
			</div>
		<?php } ?>
		@foreach($myreturnrec as $returned)
			<?php $created_at = new Carbon\Carbon($returned->created_at); $carbon = new Carbon();
			try {
				$m = $years[$created_at->year]; 
			} catch (\Exception $e) {
				$m=[1,2];
			}
			

			sort($m);$month = $m[0]; $index = 0;
			?>
			@if($y != $created_at->year)
				<div style="margin: 5px;">
					<span style="font-family: sans-serif;font-size: large;">{{$created_at->year}}{{':'}}</span>
					@for($i = 1; $i <= 12; $i++)
						@if($i === $month )
							<button class="btn-enable btn btn-sm primary-btn"
									onclick="statementgst({{$id}}{{','}}{{$created_at->year}}{{','}}{{$i}});">
								<span id="hgst{{$created_at->year}}-{{$i}}">{{$marr[$i-1]}}</span>
								<span style="display: none;" id="igst{{$created_at->year}}-{{$i}}">...</span>
							</button>
							{{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
						@else
							<button class="btn-disable btn btn-sm primary-btn" disabled>
								<span id="hgst{{$created_at->year}}-{{$i}}">{{$marr[$i-1]}}</span>
								<span style="display: none;" id="igst{{$created_at->year}}-{{$i}}">...</span>
							</button>
						@endif
					@endfor
				</div>
			@endif
			{{--*/ $y = $created_at->year; /*--}}
		@endforeach
	</div>
</div>
