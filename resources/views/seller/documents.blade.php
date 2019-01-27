@extends("common.default")
<?php
use App\Http\Controllers\IdController;
$marr = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
$mode=Session::get("mode");
if (empty($mode)) {
	# code...
	$mode="osm";
}
?>
@section("content")
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
.table{
	width: 100% !important;
}
.purchase{
	background: #e6e6e6;
	width: 100%;
	padding: 10px;
	margin: 0 auto;
	border: 2px solid #e6e6e6;
	border-radius: 25px;
}	

</style>
<script type="text/javascript">
	var JS_BASE_URL="{{url()}}"
</script>
@include('common.sellermenu')
<section class="">
	<div class="container"><!--Begin main cotainer-->
		<div class="alert alert-success alert-dismissible hidden cart-notification" role="alert" id="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong class='cart-info'></strong>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-12"><h2>Documents</h2></div>

			<div class="col-sm-12">
			@if($mode=="osm" || empty($mode))
				@if(Auth::user()->hasAccess('statement'))	
				<div class="statement" style="">
					<h3 style="font-family: sans-serif">{{$title}}</h3>
					{{-- <span>{{$name or ''}}</span><br> --}}
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
								<?php if($index < count($m) - 1) $month = $m[++$index]; ?>
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
						@endif
					@endif
					<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document" style="">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h3 class="modal-title" id="myModalLabel1">Merchant</h3>
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
									<h3 class="modal-title" id="myModalLabel2">Station</h3>
								</div>
								<div class="modal-body" id="stmodalbody">

								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal" style="min-width: 60px;">Close</button>
								</div>
							</div>
						</div>
					</div>
					{{-- Saleslog Modal --}}
					<div class="modal fade" id="salesLogModal" role="dialog" data-backdrop="static" data-keyboard="false">
				    <div class="modal-dialog ">
				        <!-- Modal content-->
				        <div class="modal-content modal-content-sku">
				            <div
								style="background-color:#21023f;color:white"
								class="modal-header">
				                <h3 id="salesLogtitle"></h3>
				                <button type="button" class="close"
									style="color:white;position:relative;top:6px"
									data-dismiss="modal">&times;</button>
				            </div>
				            <!-- Temporarily disable the modal due to UGLY ERROR -->
				            <div id="salesLogbody" class="modal-body">
				            	<table class="table" id="saleslogdoctable">
				            		<thead>
				            			<tr>
				            				<th>No.</th>
				            				<th>Day</th>
				            			</tr>
				            		</thead>
				            		<tbody id="saleslogdoctablebody"></tbody>
				            	</table>
				            </div>
				        </div>
				    </div>
				</div>
					{{-- ENds --}}
					<!-- These 2 brs are for non-MPS -->
					@if($mode=="osm" || empty($mode))
					<br>
					<br>
					@endif
					<script src="{{url('js/jquery.dataTables.min.js')}}"></script>
					<script>
					oposterminallisttable=$("#oposterminallisttable").DataTable();
						function statement(id,year,month) {
							var mid=$('#merchandID').val();
							var url="{{url()}}"+"/m/"+month+"/"+year+"/"+mid;
							window.open(url);
						}
						function pad (str, max=5) {
							  str = str.toString();
							  return str.length < max ? pad("0" + str, max) : str;
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
								success:function(response){
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
						function show_saleslog(year,month){
							oposterminallisttable.destroy();
							$(".modal").modal("hide");
							$("#oposterminallisttabletbody").empty();
							var tr="";
							url="{{url('opossum/support/terminals',$selluser->id)}}"
							$.ajax({
								url,
								success:function(r){

									if (r.status=="success") {
										rows=r.data;
										no=1;
										for (var i = rows.length - 1; i >= 0; i--) {
											row=rows[i];
											console.log(row)
											tr+=`
												<tr>
												<td class="text-center">`+no+`</td>
												<td class="text-center">`+row.location+`</td>
												<td class="text-center"><a 
												target="_blank"
												href="${JS_BASE_URL}/saleslog/view/${row.terminal_id}/${year}/${month}">`+pad(row.terminal_id)+`</a></td>

												</tr>

											`;
											no++;
										}
									}
									$("#oposterminallisttabletbody").append(tr);
									oposterminallisttable=$("#oposterminallisttable").DataTable();
								}
							})

							$("#oposumreceipt").modal("show")
						}
						function statemenop(id,year,month){
							oposterminallisttable.destroy();
							$(".modal").modal("hide");
							$("#oposterminallisttabletbody").empty();
							var tr="";
							url="{{url('opossum/support/terminals',$selluser->id)}}";
							$.ajax({
								url,
								success:function(r){

									if (r.status=="success") {
										rows=r.data;
										no=1;
										for (var i = rows.length - 1; i >= 0; i--) {
											row=rows[i];
											console.log(row)
											tr+=`
												<tr>
												<td class="text-center">`+no+`</td>
												<td class="text-center">`+row.location+`</td>
												<td class="text-center" onclick="statemenop_actual(
													${id},
													${year},
													`+month+`,
													`+row.terminal_id+`
													)"><a href="javascript:void(0);">`+pad(row.terminal_id)+`</a></td>

												</tr>

											`;
											no++;
										}
									}
									$("#oposterminallisttabletbody").append(tr);
									oposterminallisttable=$("#oposterminallisttable").DataTable();
								}
							})

							$("#oposumreceipt").modal("show")
						}
						function statemenop_actual(id,year,month,terminal_id=0) {
							var URL="{{url()}}"
							$(".modal").modal("hide");
                            var mid=$('#merchandID').val();
							const url = URL+"/statement/trackingop/?mid="+mid+'&&id='+id+'&&year='+year+'&&month='+month+'&&terminal_id='+terminal_id;
							window.open(url);

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
					@if($mode=="osm" || empty($mode))
					<div class="statement" style="">
						<h3 style="font-family: sans-serif">{{$titlerec}}</h3>
{{-- 						<span>{{$namerec or ''}}</span><br>
 --}}						{{$companyrec or ''}}<br>
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
				@endif
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document" style="">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h3 class="modal-title" id="myModalLabel1">Merchant</h3>
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
								<h3 class="modal-title" id="myModalLabel2">Sales Memo</h3>
							</div>
							<div class="modal-body" id="stmodalbody">

							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal" style="min-width: 60px;">Close</button>
							</div>
						</div>
					</div>
				</div>

				@if($mode=="osm" || empty($mode))
				<br>
				<br>
				{{-- OPOSSUM --}}
					@if(Auth::user()->hasAccess('recopossum'))
					<div class="statement" style="">
					<h3 style="font-family: sans-serif">
					Receipt Issued (OPOSsum)
					</h3>
				{{-- <span>{{$nameop or ''}}</span><br> --}}
					{{$companytr or ''}}<br>
					{{ $str->line1 or '' }}<br>
					{{ $str->line2 or '' }}<br>
					{{ $str->line3 or '' }}<br>
					{{ $str->line4  or '' }}<br>
					<div class="ym">
					{{--*/ $y = 1; $index = 0;/*--}}
					
					<?php 
					$rendered_year=array();
					
					if((is_null($myreturnop)) || ($current_yearop == 0)){ $carbon = new Carbon();
						
						?>
						<div style="margin: 5px;">
							<span style="font-family: sans-serif;font-size: large;">{{date('Y')}}{{':'}}</span>
							@for($i = 1; $i <= 12; $i++)
							<button class="btn-disable btn btn-sm primary-btn" disabled>
								{{$marr[$i-1]}}
							</button>
							@endfor
						</div>
						<?php } ?>			 
						
						@foreach($myreturnop as $returned)
						<?php 

						$created_at = new Carbon\Carbon($returned->created_at);
						$carbon = new Carbon();
								// dump($returned->created_at);
								

						try {
							
							$m=array_unique($yearsop[$created_at->year]);

							sort($m);
							
						} catch (\Exception $e) {
									//dump($e->getMessage());
							$m=[];
						}
						
						Log::debug($returned);
						Log::debug($m);
						$month = $m[$index];
						/* BUSTED */
						
						?>
						@if($y != $created_at->year)
						<?php
						array_push($rendered_year,$created_at->year);
						
						?>
						<div style="margin: 5px;">
							<span style="font-family: sans-serif;font-size: large;">{{$created_at->year}}{{':'}}</span>
							@for($i = 1; $i <= 12; $i++)
							@if($i === $month )
							<button class="btn-enable btn btn-sm primary-btn"
							onclick="statemenop({{$returned->terminal_id}}{{','}}{{$created_at->year}}{{','}}{{$i}});">
							<span id="op{{$created_at->year}}-{{$i}}">{{$marr[$i-1]}}</span>
							<span style="display: none;" id="opr{{$created_at->year}}-{{$i}}">...</span>
						</button>
						{{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
						@else
						<button class="btn-disable btn btn-sm primary-btn" disabled>
							<span id="t{{$created_at->year}}-{{$i}}">{{$marr[$i-1]}}</span>
							<span style="display: none;" id="op{{$created_at->year}}-{{$i}}">...</span>
						</button>
						@endif
						@endfor
					</div>

					@endif
					{{--*/ $y = $created_at->year; /*--}}
					@endforeach
				</div>
			</div>
			<br>
			<br>
				@endif
				{{-- Access if/else ends ^ --}}
			<!-- Tracking Report Document Type  Start-->
			@if(Auth::user()->hasAccess('treport'))
			<div class="statement" style="">
				<h3 style="font-family: sans-serif">{{$titletr}}</h3>
			{{-- 	<span>{{$nametr or ''}}</span><br> --}}
				{{$companytr or ''}}<br>
				{{ $str->line1 or '' }}<br>
				{{ $str->line2 or '' }}<br>
				{{ $str->line3 or '' }}<br>
				{{ $str->line4  or '' }}<br>
				<div class="ym">
					{{--*/ $y = 1; $index = 0;/*--}}
					
					<?php 
					$rendered_year=array();
					
					if((is_null($myreturntr)) || ($current_yeartr == 0)){ $carbon = new Carbon();
						
						?>
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
							
							$m=array_unique($yearstr[$created_at->year]);
							sort($m);

							
						} catch (\Exception $e) {
									//dump($e->getMessage());
							$m=[];
						}

						$month = $m[$index];
						
						?>
						@if($y != $created_at->year)
						<?php
						array_push($rendered_year,$created_at->year);
						
						?>
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
				@endif
			@endif
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document" style="">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span></button>
								<h3 class="modal-title" id="myModalLabel1">Merchant</h3>
							</div>
							<div class="modal-body" id="modalbody" style="background:#F2F2F2;">

							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
				{{-- OPOSSUM MODAL --}}
				<div class="modal fade" id="opModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document" style="width:50%">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close"
									data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<h3 class="modal-title" id="opModalLabel2">
									Receipt List</h3>
								</div>
								<div class="modal-body" id="opmodalbody">
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal" style="min-width: 60px;">Close</button>
								</div>
							</div>
						</div>
					</div>
				{{-- ENDS --}}
				<div class="modal fade" id="trModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document" style="width:50%">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span></button>
									<h3 class="modal-title" id="trModalLabel2">Station</h3>
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
					@if($mode=="osm" || empty($mode))
						@if(Auth::user()->hasAccess('salesmemo'))
					<br>
					<br>
					<!-- Sales Memo -->
					<div class="statement" style="">
						<h3 style="font-family: sans-serif">{{$titlesm}}</h3>
						{{-- <span>{{$namesm or ''}}</span><br> --}}
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
								
								$m=array_unique($yearstr[$created_at->year]);
								sort($m);

								
								
							} catch (\Exception $e) {

//									dump($e->getMessage());
								$m=[];
							}
							
							$month = $m[$index];

							
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
					@endif
				@endif
				<div class="modal fade" id="smModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document" style="width:50%">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close"
								style="margin-top:0;padding-top:10px"
								data-dismiss="modal"
								aria-label="Close">
								<span aria-hidden="true">&times;
								</span></button>

								<h3 class="modal-title"
								id="smModalLabel2">Sales Memo 

									{{-- ------- START STATS Table ---------> --}}
									<span style="font-size:14px !important;"
										class="pull-right">
									<table>
									<tr>
									<td class="text-right">Monthly:</td>
									<td class="text-center">
										&nbsp;{{$currentCurrency}}&nbsp;</td>
									<td class="text-right">
									<span id="smmonthly">0</span></td>
									</tr>
									<tr>
									<td class="text-right">Today:</td>
									<td class="text-center">
										&nbsp;{{$currentCurrency}}&nbsp;</td>
									<td style="text-align:right">
									<span id="smdaily">0</span></td>
									</tr>
									</table>
									</span>
									{{-- ------- END STATS Table ---------> --}}

									</h3>
								</div>
								<div class="modal-body" id="smmodalbody">

								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal" style="min-width: 60px;">Close</button>
								</div>
							</div>
						</div>
					</div>
					<br><br>


 					@if(Auth::user()->hasAccess('purorderi'))
					<div class="purchase" style="">
						<h3 style="font-family: sans-serif">Purchase Order Issued</h3>
						{{-- <span>{{$name or ''}}</span><br> --}}
						{{$company or ''}}<br>
						{{ $s->line1 or '' }}<br>
						{{ $s->line2 or '' }}<br>
						{{ $s->line3 or '' }}<br>
						{{ $s->line4  or '' }}<br>
						<div class="ym">
							{{--*/ $y = 1; $index = 0;/*--}}

							<?php if((is_null($myreturnsto)) || ($current_yearsto == 0)){ $carbon = new Carbon();?>
								<div style="margin: 5px;">
									<span style="font-family: sans-serif;font-size: large;">
										{{date('Y')}}{{':'}}</span>
									@for($i = 0,$carbon->month = 1; $i < 12; $i++)
										<button class="btn-disable btn btn-sm primary-btn" disabled>
											{{$carbon->format('M')}}
										</button>
										<?php  $carbon->month = ++$carbon->month; ?>
									@endfor
								</div>
							<?php } ?>
							 
							@foreach($myreturnsto as $returned)
								{{--*/ $created_at = new Carbon\Carbon($returned->created_at); $carbon = new Carbon();
								$m = $yearssto[$created_at->year]; sort($m);
								$month = $m[0]; $index = 0;/*--}}

								@if($y != $created_at->year)
									<div style="margin: 5px;">
										<span style="font-family: sans-serif;font-size: large;">{{$created_at->year}}{{':'}}</span>
										@for($i = 0,$carbon->month = 1; $i < 12; $i++)

											@if(in_array($carbon->month, $m) )
												<button class="btn-enable btn btn-sm primary-btn" 
														onclick="invoicepurchase2({{$id}}{{','}}{{$created_at->year}}{{','}}{{$carbon->month}});">
													<span id="hmer2{{$created_at->year}}-{{$carbon->month}}">{{$carbon->format('M')}}</span>
													<span style="display: none;" id="imer2{{$created_at->year}}-{{$carbon->month}}">...</span>
													
												</button>
												{{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
											@else
												<button class="btn-disable btn btn-sm primary-btn {{$i}}" disabled>
													{{$carbon->format('M')}}
												</button>
											@endif
											<?php  $carbon->month = ++$carbon->month; ?>
										@endfor
									</div>
								@endif
								{{--*/ $y = $created_at->year; /*--}}
								<?php $i++;?>
							@endforeach
						</div>
					</div>	
					<br>
					<br>

					@endif      

					
					<?php $e=1;?>
					@if(Auth::user()->hasAccess('purorder'))
					<div class="purchase" style="">
						<h3 style="font-family: sans-serif">Purchase Order Received</h3>
							{{-- <span>{{$name or ''}}</span><br> --}}
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
									@for($i = 0,$carbon->month = 1; $i < 12; $i++)
										<button class="btn-disable btn btn-sm primary-btn" disabled>
											{{$carbon->format('M')}}
										</button>
										<?php  $carbon->month = ++$carbon->month; ?>
									@endfor
								</div>
							<?php } ?>
							 
							@foreach($myreturn as $returned)
								{{--*/ $created_at = new Carbon\Carbon($returned->created_at); $carbon = new Carbon();
								$m = $years[$created_at->year]; sort($m);
								$month = $m[0]; $index = 0;/*--}}

								@if($y != $created_at->year)
									<div style="margin: 5px;">
										<span style="font-family: sans-serif;font-size: large;">{{$created_at->year}}{{':'}}</span>
										@for($i = 0,$carbon->month = 1; $i < 12; $i++)
											@if(in_array($carbon->month, $m) )
												<button class="btn-enable btn btn-sm primary-btn" 
														onclick="invoicepurchase({{$id}}{{','}}{{$created_at->year}}{{','}}{{$carbon->month}});">
													<span id="hmer{{$created_at->year}}-{{$carbon->month}}">{{$carbon->format('M')}}</span>
													<span style="display: none;" id="imer{{$created_at->year}}-{{$carbon->month}}">...</span>
													
												</button>
												{{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
											@else
												<button class="btn-disable btn btn-sm primary-btn {{$i}}" disabled>
													{{$carbon->format('M')}}
												</button>
											@endif
											<?php  $carbon->month = ++$carbon->month; ?>
										@endfor
									</div>
								@endif
								{{--*/ $y = $created_at->year; /*--}}
								<?php $i++;?>
							@endforeach
						</div>
					</div>	
					<br>
					<br>
					@endif




					<!-- Credit Note Issued -->
					<div class="creditnote purchase" style="">
						<h3 style="font-family: sans-serif">Credit Note Issued</h3>
						{{-- <span>{{$name or ''}}</span><br> --}}
						{{$company or ''}}<br>
						{{ $s->line1 or '' }}<br>
						{{ $s->line2 or '' }}<br>
						{{ $s->line3 or '' }}<br>
						{{ $s->line4  or '' }}<br>
						<div class="ym">
							{{--*/ $y = 1; $index = 0;/*--}}

							<?php if((count($creditnote)==0)){ $carbon = new Carbon();?>
							<div style="margin: 5px;">
								<span style="font-family: sans-serif;font-size: large;">
								{{date('Y')}}{{':'}}</span>
								@for($i = 0,$carbon->month = 1; $i < 12; $i++)
								<button class="btn-disable btn btn-sm primary-btn" disabled>
									{{$carbon->format('M')}}
								</button>
								<?php  $carbon->month = ++$carbon->month; ?>
								@endfor
							</div>
							<?php } ?>
							
							@foreach($creditnote as $returned)
								{{--*/ 

									$created_at = new Carbon\Carbon($returned->created_at); 
									$carbon = new Carbon();
									$index = 0;

									/*--}}

									@if($y != $created_at->year)
									
									<div style="margin: 5px;">
										<span style="font-family: sans-serif;font-size: large;">{{$created_at->year}}{{':'}}</span>
										@for($i = 0,$carbon->month = 1; $i < 12; $i++)
										@if(in_array($carbon->month, $creditnoteyearmonth[$created_at->year]) )
										<button class="btn-enable btn btn-sm primary-btn" onclick="creditnote({{$id}}{{','}}{{$created_at->year}}{{','}}{{$carbon->month}});">
											<span id="hmer2{{$created_at->year}}-{{$carbon->month}}">{{$carbon->format('M')}}</span>
											<span style="display: none;" id="imer2{{$created_at->year}}-{{$carbon->month}}">...</span>
											
										</button>
										{{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
										@else
										<button class="btn-disable btn btn-sm primary-btn {{$i}}" disabled>
											{{$carbon->format('M')}}
										</button>
										@endif
										<?php  $carbon->month = ++$carbon->month; ?>
										@endfor
									</div>
									@endif
									{{--*/ $y = $created_at->year; /*--}}
									<?php $i++;?>
									@endforeach
								</div>
							</div>
							<br>
							<br>
							<!-- Credit Note Issued -->


							<!-- Credit Note Received -->
							<div class="creditnote purchase" style="">
								<h3 style="font-family: sans-serif">Credit Note Received</h3>
								{{-- <span>{{$name or ''}}</span><br> --}}
								{{$company or ''}}<br>
								{{ $s->line1 or '' }}<br>
								{{ $s->line2 or '' }}<br>
								{{ $s->line3 or '' }}<br>
								{{ $s->line4  or '' }}<br>
								<div class="ym">
									{{--*/ $y = 1; $index = 0;/*--}}

									<?php if((count($creditnotedeal)==0)){ $carbon = new Carbon();?>
									<div style="margin: 5px;">
										<span style="font-family: sans-serif;font-size: large;">
										{{date('Y')}}{{':'}}</span>
										@for($i = 0,$carbon->month = 1; $i < 12; $i++)
										<button class="btn-disable btn btn-sm primary-btn" disabled>
											{{$carbon->format('M')}}
										</button>
										<?php  $carbon->month = ++$carbon->month; ?>
										@endfor
									</div>
									<?php } ?>
									
									@foreach($creditnotedeal as $returned)
								{{--*/ 

									$created_at = new Carbon\Carbon($returned->created_at); 
									$carbon = new Carbon();
									$index = 0;

									/*--}}

									@if($y != $created_atdeal->year)
									
									<div style="margin: 5px;">
										<span style="font-family: sans-serif;font-size: large;">{{$created_atdeal->year}}{{':'}}</span>
										@for($i = 0,$carbon->month = 1; $i < 12; $i++)
										@if(in_array($carbon->month, $creditnoteyearmonthdeal[$created_atdeal->year]) )
										<button class="btn-enable btn btn-sm primary-btn" onclick="credit_note_dealer({{$id}}{{','}}{{$created_atdeal->year}}{{','}}{{$carbon->month}});">
											<span id="hmer2{{$created_atdeal->year}}-{{$carbon->month}}">{{$carbon->format('M')}}</span>
											<span style="display: none;" id="imer2{{$created_atdeal->year}}-{{$carbon->month}}">...</span>
											
										</button>
										{{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
										@else
										<button class="btn-disable btn btn-sm primary-btn {{$i}}" disabled>
											{{$carbon->format('M')}}
										</button>
										@endif
										<?php  $carbon->month = ++$carbon->month; ?>
										@endfor
									</div>
									@endif
									{{--*/ $y = $created_at->year; /*--}}
									<?php $i++;?>
									@endforeach
								</div>
							</div>
							<br>
							<br>
							<!-- Credit Note Received -->

							<!-- Debit Note Issued by dave -->
							@if(!(Auth::user()->hasRole('dlr')))		
							<div class="returnofgoods purchase" style="">
								<h3 style="font-family: sans-serif">Debit Note Issued</h3>
								{{-- <span>{{$name or ''}}</span><br> --}}
								{{$company or ''}}<br>
								{{ $s->line1 or '' }}<br>
								{{ $s->line2 or '' }}<br>
								{{ $s->line3 or '' }}<br>
								{{ $s->line4  or '' }}<br>
								<div class="ym">
                            {{--*/ $y = 1; $index = 0;/*--}}

                            <?php if((is_null($querydebit)) || ($current_year == 0)){ $carbon = new Carbon();?>
                                <div style="margin: 5px;">
                                    <span style="font-family: sans-serif;font-size: large;">
                                        {{date('Y')}}{{':'}}</span>
                                    @for($i = 0,$carbon->month = 1; $i < 12; $i++)
                                        <button class="btn-disable btn btn-sm primary-btn" disabled>
                                            {{$carbon->format('M')}}
                                        </button>
                                        <?php  $carbon->month = ++$carbon->month; ?>
                                    @endfor
                                </div>
                            <?php } ?>
                            
                            @foreach($querydebit as $returned)
                                {{--*/ $created_at = new Carbon\Carbon($returned->created_at); $carbon = new Carbon();
                                $m = $years[$created_at->year]; sort($m);
                                $month = $m[0]; $index = 0;/*--}}
                                @if($y != $created_at->year)
                                
                                    <div style="margin: 5px;">
                                        <span style="font-family: sans-serif;font-size: large;">{{$created_at->year}}{{':'}}</span>
                                        @for($i = 0,$carbon->month = 1; $i < 12; $i++)
                                        
                                            @if(in_array($carbon->month, $m) )
                                                <button class="btn-enable btn btn-sm primary-btn"
                                                        onclick="debitnotestatement({{$id}}{{','}}{{$created_at->year}}{{','}}{{$carbon->month}});">
                                                    <span id="hsto{{$created_at->year}}-{{$carbon->month}}">{{$carbon->format('M')}}</span>
                                                    <span style="display: none;" id="isto{{$created_at->year}}-{{$carbon->month}}">...</span>
                                                    
                                                </button>
                                                {{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
                                            @else
                                                <button class="btn-disable btn btn-sm primary-btn {{$i}}" disabled>
                                                    {{$carbon->format('M')}}
                                                </button>
                                            @endif
                                            <?php  $carbon->month = ++$carbon->month; ?>
                                        @endfor
                                    </div>
                                @endif
                                {{--*/ $y = $created_at->year; /*--}}
                                <?php $i++;?>
                            @endforeach
                        </div>
						</div>
					<br><br>
					@endif
					<!-- Debit Note Issued -->

					<!--  Debit Note Received by dave -->
					
				<!-- Debit Note Recieved -->
				
						<div class="returnofgoods purchase" style="">
								<h3 style="font-family: sans-serif">Debit Note Received</h3>
								{{-- <span>{{$name or ''}}</span><br> --}}
								{{$company or ''}}<br>
								{{ $s->line1 or '' }}<br>
								{{ $s->line2 or '' }}<br>
								{{ $s->line3 or '' }}<br>
								{{ $s->line4  or '' }}<br>
								<div class="ym">
                            {{--*/ $y = 1; $index = 0;/*--}}

                            <?php if((is_null($querydebitr)) || ($current_year == 0)){ $carbon = new Carbon();?>
                                <div style="margin: 5px;">
                                    <span style="font-family: sans-serif;font-size: large;">
                                        {{date('Y')}}{{':'}}</span>
                                    @for($i = 0,$carbon->month = 1; $i < 12; $i++)
                                        <button class="btn-disable btn btn-sm primary-btn" disabled>
                                            {{$carbon->format('M')}}
                                        </button>
                                        <?php  $carbon->month = ++$carbon->month; ?>
                                    @endfor
                                </div>
                            <?php } ?>
                            
                            @foreach($querydebitr as $returned)
                                {{--*/ $created_at = new Carbon\Carbon($returned->created_at); $carbon = new Carbon();
                                $m = $years[$created_at->year]; sort($m);
                                $month = $m[0]; $index = 0;/*--}}
                                @if($y != $created_at->year)
                                
                                    <div style="margin: 5px;">
                                        <span style="font-family: sans-serif;font-size: large;">{{$created_at->year}}{{':'}}</span>
                                        @for($i = 0,$carbon->month = 1; $i < 12; $i++)
                                        
                                            @if(in_array($carbon->month, $m) )
											@if(Auth::user()->hasRole('dlr'))
                                                <button class="btn-enable btn btn-sm primary-btn"
                                                        onclick="debitnotestatement2({{$id}}{{','}}{{$created_at->year}}{{','}}{{$carbon->month}});">
											@else
												<button class="btn-disable btn btn-sm primary-btn"
                                                        disabled>
											@endif
                                                    <span id="hsto1{{$created_at->year}}-{{$carbon->month}}">{{$carbon->format('M')}}</span>
                                                    <span style="display: none;" id="isto1{{$created_at->year}}-{{$carbon->month}}">...</span>
                                                    
                                                </button>
                                                {{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
                                            @else
                                                <button class="btn-disable btn btn-sm primary-btn {{$i}}" disabled>
                                                    {{$carbon->format('M')}}
                                                </button>
                                            @endif
                                            <?php  $carbon->month = ++$carbon->month; ?>
                                        @endfor
                                    </div>
                                @endif
                                {{--*/ $y = $created_at->year; /*--}}
                                <?php $i++;?>
                            @endforeach
							
                        </div>
						</div>
					<br><br>
					
					<!--   Debit Note Received by dave-->
					
					
					<!-- Debit Note Received -->
			<!--		<div class="returnofgoods purchase" style="">
						<h3 style="font-family: sans-serif">Debit Note Received</h3>
						{{-- <span>{{$name or ''}}</span><br> --}}
						{{$company or ''}}<br>
						{{ $s->line1 or '' }}<br>
						{{ $s->line2 or '' }}<br>
						{{ $s->line3 or '' }}<br>
						{{ $s->line4  or '' }}<br>
						<div class="ym">
							{{--*/ $y = 1; $index = 0;/*--}}

							<?//php if((count($queryreturnofgood)==0)){ $carbon = new Carbon();?>
							<div style="margin: 5px;">
								<span style="font-family: sans-serif;font-size: large;">
								{{date('Y')}}{{':'}}</span>
								@for($i = 0,$carbon->month = 1; $i < 12; $i++)
								<button class="btn-disable btn btn-sm primary-btn" disabled>
									{{$carbon->format('M')}}
								</button>
								<?//php  $carbon->month = ++$carbon->month; ?>
								@endfor
							</div>
							<?//php } ?>
							
							@foreach($queryreturnofgood as $returned)
								{{--*/ 

									$created_at = new Carbon\Carbon($returned->created_at); 
									$carbon = new Carbon();
									$index = 0;

									/*--}}

									@if($y != $created_at->year)
									
									<div style="margin: 5px;">
										<span style="font-family: sans-serif;font-size: large;">{{$created_at->year}}{{':'}}</span>
										@for($i = 0,$carbon->month = 1; $i < 12; $i++)
										@if(in_array($carbon->month, $arrayyearmonth[$created_at->year]) )
										<button class="btn-enable btn btn-sm primary-btn" 
										onclick="returnofgoods({{$id}}{{','}}{{$created_at->year}}{{','}}{{$carbon->month}});">
										<span id="hrog2{{$created_at->year}}-{{$carbon->month}}">{{$carbon->format('M')}}</span>
										<span style="display: none;" id="irog2{{$created_at->year}}-{{$carbon->month}}">...</span>
									</i>
								</button>
								{{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
								@else
								<button class="btn-disable btn btn-sm primary-btn {{$i}}" disabled>
									{{$carbon->format('M')}}
								</button>
								@endif
								<?//php  $carbon->month = ++$carbon->month; ?>
								@endfor
							</div>
							@endif
							{{--*/ $y = $created_at->year; /*--}}
							
							@endforeach
						</div>
					</div>
					<br><br>
					-->
					<!-- Debit Note Received -->


					<!-- Delivery Order Issued -->
					<div class="do purchase" style="">
						<h3 style="font-family: sans-serif">Delivery Order Issued</h3>
						{{-- <span>{{$name or ''}}</span><br> --}}
						{{$company or ''}}<br>
						{{ $s->line1 or '' }}<br>
						{{ $s->line2 or '' }}<br>
						{{ $s->line3 or '' }}<br>
						{{ $s->line4  or '' }}<br>
						<div class="ym">
							{{--*/ $y = 1; $index = 0;/*--}}

							<?php if((count($querydo)==0)){ $carbon = new Carbon();?>
							<div style="margin: 5px;">
								<span style="font-family: sans-serif;font-size: large;">
								{{date('Y')}}{{':'}}</span>
								@for($i = 0,$carbon->month = 1; $i < 12; $i++)
								<button class="btn-disable btn btn-sm primary-btn" disabled>
									{{$carbon->format('M')}}
								</button>
								<?php  $carbon->month = ++$carbon->month; ?>
								@endfor
							</div>
							<?php } ?>
							
							@foreach($querydo as $returned)
								{{--*/ 

									$created_at = new Carbon\Carbon($returned->created_at); 
									$carbon = new Carbon();
									$index = 0;

									/*--}}

									@if($y != $created_at->year)   
									
									<div style="margin: 5px;">
										<span style="font-family: sans-serif;font-size: large;">{{$created_at->year}}{{':'}}</span>
										@for($i = 0,$carbon->month = 1; $i < 12; $i++)
										@if(in_array($carbon->month, $yearmonthdo[$created_at->year]) )
										<button class="btn-enable btn btn-sm primary-btn"
										onclick="doissued({{$id}}{{','}}{{$created_at->year}}{{','}}{{$carbon->month}});">
										<span id="hmer2{{$created_at->year}}-{{$carbon->month}}">{{$carbon->format('M')}}</span>
										<span style="display: none;" id="imer2{{$created_at->year}}-{{$carbon->month}}">...</span>
									</i>
								</button>
								{{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
								@else
								<button class="btn-disable btn btn-sm primary-btn {{$i}}" disabled>
									{{$carbon->format('M')}}
								</button>
								@endif
								<?php  $carbon->month = ++$carbon->month; ?>
								@endfor
							</div>
							@endif 
							{{--*/ $y = $created_at->year; /*--}}
							<?php $i++;?>
							@endforeach
						</div>
					</div>
					<!-- Delivery Order Issued -->
					<br>
					<br>


					<!-- Delivery Order Received -->
					<div class="do purchase" style="">
						<h3 style="font-family: sans-serif">Delivery Order Received</h3>
						{{-- <span>{{$name or ''}}</span><br> --}}
						{{$company or ''}}<br>
						{{ $s->line1 or '' }}<br>
						{{ $s->line2 or '' }}<br>
						{{ $s->line3 or '' }}<br>
						{{ $s->line4  or '' }}<br>
						<div class="ym">
							{{--*/ $y = 1; $index = 0;/*--}}

							<?php if((count($doreceived)==0)){ $carbon = new Carbon();?>
							<div style="margin: 5px;">
								<span style="font-family: sans-serif;font-size: large;">
								{{date('Y')}}{{':'}}</span>
								@for($i = 0,$carbon->month = 1; $i < 12; $i++)
								<button class="btn-disable btn btn-sm primary-btn" disabled>
									{{$carbon->format('M')}}
								</button>
								<?php  $carbon->month = ++$carbon->month; ?>
								@endfor
							</div>
							<?php } ?>
							
							@foreach($doreceived as $returned)
								{{--*/ 

									$created_at = new Carbon\Carbon($returned->created_at); 
									$carbon = new Carbon();
									$index = 0;

									/*--}}

									@if($y != $new_date->year)
									
									<div style="margin: 5px;">
										<span style="font-family: sans-serif;font-size: large;">{{$new_date->year}}{{':'}}</span>
										@for($i = 0,$carbon->month = 1; $i < 12; $i++)
										@if(in_array($carbon->month, $yearmonthdor[$new_date->year]) )
										<button class="btn-enable btn btn-sm primary-btn" 
										onclick="doreceived({{$id}}{{','}}{{$new_date->year}}{{','}}{{$carbon->month}});">
										<span id="hmer2{{$new_date->year}}-{{$carbon->month}}">{{$carbon->format('M')}}</span>
										<span style="display: none;" id="imer2{{$new_date->year}}-{{$carbon->month}}">...</span>
									</i>
								</button>
								{{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
								@else
								<button class="btn-disable btn btn-sm primary-btn {{$i}}" disabled>
									{{$carbon->format('M')}}
								</button>
								@endif
								<?php  $carbon->month = ++$carbon->month; ?>
								@endfor
							</div>
							@endif 
							{{--*/ $y = $created_at->year; /*--}}
							<?php $i++;?>
							@endforeach
						</div>
					</div>           

					<br><br>
					<!-- Sales Order -->
					<div class="salesorder purchase" style="">
						<h3 style="font-family: sans-serif">Sales Order (Gator)</h3>
					{{-- 	<span>{{$company_details->oshop_name or ''}}</span><br> --}}
						{{$company or ''}}<br>
						{{ $s->line1 or '' }}<br>
						{{ $s->line2 or '' }}<br>
						{{ $s->line3 or '' }}<br>
						{{ $s->line4  or '' }}<br>
						<div class="ym">
							{{--*/ $y = 1; $index = 0;/*--}}

							<?php if((count($querysalesorder)==0)){ $carbon = new Carbon();?>
							<div style="margin: 5px;">
								<span style="font-family: sans-serif;font-size: large;">
								{{date('Y')}}{{':'}}</span>
								@for($i = 0,$carbon->month = 1; $i < 12; $i++)
								<button class="btn-disable btn btn-sm primary-btn" disabled>
									{{$carbon->format('M')}}
								</button>
								<?php  $carbon->month = ++$carbon->month; ?>
								@endfor
							</div>
							<?php } ?>

							@foreach($querysalesorder as $returned)

								@if($y != $created_at_so->year)
									
									<div style="margin: 5px;">
										<span style="font-family: sans-serif;font-size: large;">{{$created_at_so->year}}{{':'}}</span>
										@for($i = 0,$carbon->month = 1; $i < 12; $i++)
										@if(in_array($carbon->month, $salesorderyearmonth[$created_at_so->year]))
										<button class="btn-enable btn btn-sm primary-btn"
										onclick="salesorder({{$id}}{{','}}{{$created_at_so->year}}{{','}}{{$carbon->month}},'{{$carbon->format('F')}}')">
										<span id="so2{{$created_at_so->year}}-{{$carbon->month}}">{{$carbon->format('M')}}</span>
										<span style="display: none;" id="so{{$created_at_so->year}}-{{$carbon->month}}">...</span>
									</i>
								</button>
								{{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
								@else
								<button class="btn-disable btn btn-sm primary-btn {{$i}}" disabled>
									{{$carbon->format('M')}}
								</button>
								@endif
								<?php  $carbon->month = ++$carbon->month; ?>
								@endfor
							</div>
							@endif
							{{--*/ $y = $created_at->year; /*--}}
							
							@endforeach
						</div>
					</div>
					<br><br>
                    <div class="statement" style="">
                        <h3 style="font-family: sans-serif">Invoice Issued (Gator)</h3>
                            {{--<span>{{$name or ''}}</span><br>--}}
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
                                    @for($i = 0,$carbon->month = 1; $i < 12; $i++)
                                        <button class="btn-disable btn btn-sm primary-btn" disabled>
                                            {{$carbon->format('M')}}
                                        </button>
                                        <?php  $carbon->month = ++$carbon->month; ?>
                                    @endfor
                                </div>
                            <?php } ?>
                            
                            @foreach($myreturn as $returned)
                                {{--*/ $created_at = new Carbon\Carbon($returned->created_at); $carbon = new Carbon();
                                $m = $years[$created_at->year]; sort($m);
                                $month = $m[0]; $index = 0;/*--}}
                                @if($y != $created_at->year)
                                
                                    <div style="margin: 5px;">
                                        <span style="font-family: sans-serif;font-size: large;">{{$created_at->year}}{{':'}}</span>
                                        @for($i = 0,$carbon->month = 1; $i < 12; $i++)
                                        
                                            @if(in_array($carbon->month, $m) )
                                                <button class="btn-enable btn btn-sm primary-btn"
                                                        onclick="invoicestatement({{$id}}{{','}}{{$created_at->year}}{{','}}{{$carbon->month}});">
                                                    <span id="hsto{{$created_at->year}}-{{$carbon->month}}">{{$carbon->format('M')}}</span>
                                                    <span style="display: none;" id="isto{{$created_at->year}}-{{$carbon->month}}">...</span>
                                                    
                                                </button>
                                                {{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
                                            @else
                                                <button class="btn-disable btn btn-sm primary-btn {{$i}}" disabled>
                                                    {{$carbon->format('M')}}
                                                </button>
                                            @endif
                                            <?php  $carbon->month = ++$carbon->month; ?>
                                        @endfor
                                    </div>
                                @endif
                                {{--*/ $y = $created_at->year; /*--}}
                                <?php $i++;?>
                            @endforeach
                        </div>
                    </div>    
					<br>

 					@if(Auth::user()->hasAccess('invoice'))
					<br>
					<div class="statement" style="">
						<h3 style="font-family: sans-serif">Invoice Received (Gator)</h3>
						{{-- <span>{{$name or ''}}</span><br> --}}
						{{$company or ''}}<br>
						{{ $s->line1 or '' }}<br>
						{{ $s->line2 or '' }}<br>
						{{ $s->line3 or '' }}<br>
						{{ $s->line4  or '' }}<br>
						<div class="ym">
							{{--*/ $y = 1; $index = 0;/*--}}

							<?php if((is_null($myreturnsto)) || ($current_yearsto == 0)){ $carbon = new Carbon();?>
								<div style="margin: 5px;">
									<span style="font-family: sans-serif;font-size: large;">
										{{date('Y')}}{{':'}}</span>
									@for($i = 0,$carbon->month = 1; $i < 12; $i++)
										<button class="btn-disable btn btn-sm primary-btn" disabled>
											{{$carbon->format('M')}}
										</button>
										<?php  $carbon->month = ++$carbon->month; ?>
									@endfor
								</div>
							<?php } ?>
							@foreach($myreturnsto as $returned)
								{{--*/ $created_at = new Carbon\Carbon($returned->created_at); $carbon = new Carbon();
								$m = $yearssto[$created_at->year]; sort($m);
								$month = $m[0]; $index = 0;/*--}}
								@if($y != $created_at->year)
									<div style="margin: 5px;">
										<span style="font-family: sans-serif;font-size: large;">{{$created_at->year}}{{':'}}</span>
										@for($i = 0,$carbon->month = 1; $i < 12; $i++)
											@if(in_array($carbon->month, $m) )
												<button class="btn-enable btn btn-sm primary-btn" 
														onclick="invoicestatement2({{$id}}{{','}}{{$created_at->year}}{{','}}{{$carbon->month}});">
													<span id="hsto2{{$created_at->year}}-{{$carbon->month}}">{{$carbon->format('M')}}</span>
													<span style="display: none;" id="isto2{{$created_at->year}}-{{$carbon->month}}">...</span>
													
												</button>
												{{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
											@else
												<button class="btn-disable btn btn-sm primary-btn {{$i}}" disabled>
													{{$carbon->format('M')}}
												</button>
											@endif
											<?php  $carbon->month = ++$carbon->month; ?>
										@endfor
									</div>
								@endif
								{{--*/ $y = $created_at->year; /*--}}
								<?php $i++;?>
							@endforeach
						</div>
					</div>	
					@endif
 

                    @if($mode=="osm" || empty($mode))
					<br><br>

					<!-- Wastage Form -->
					<div class="salesorder purchase" style="">
						<h3 style="font-family: sans-serif">Wastage Form</h3>
						{{-- <span>{{$name or ''}}</span><br> --}} 
						{{$company or ''}}<br>
						{{ $s->line1 or '' }}<br>
						{{ $s->line2 or '' }}<br>
						{{ $s->line3 or '' }}<br>
						{{ $s->line4  or '' }}<br>
						<div class="ym">
							{{--*/ $y = 1; $index = 0;/*--}}

							<?php if((count($queryStockReport)==0)){ $carbon = new Carbon();?>
							<div style="margin: 5px;">
								<span style="font-family: sans-serif;font-size: large;">
								{{date('Y')}}{{':'}}</span>
								@for($i = 0,$carbon->month = 1; $i < 12; $i++)
								<button class="btn-disable btn btn-sm primary-btn" disabled>
									{{$carbon->format('M')}}
								</button>
								<?php  $carbon->month = ++$carbon->month; ?>
								@endfor
							</div>
							<?php } ?>
							
							@foreach($queryStockReport as $returned)
								{{--*/

									$created_at = new Carbon\Carbon($returned->created_at); 
									$carbon = new Carbon();
									$index = 0;

									/*--}}

									@if($y != $created_at->year)
									
									<div style="margin: 5px;">
										<span style="font-family: sans-serif;font-size: large;">{{$created_at->year}}{{':'}}</span>
										@for($i = 0,$carbon->month = 1; $i < 12; $i++)
										@if(in_array($carbon->month, $stockreportyearmonth[$created_at->year]) )
										<button id="wastageform" class="btn-enable btn btn-sm primary-btn"month='{{$carbon->month}}' year='{{$carbon->year}}'href="{{url("/wastageform/$carbon->year/$carbon->month")}}" >
										<span id="so2{{$created_at->year}}-{{$carbon->month}}">{{$carbon->format('M')}}</span>
										<span style="display: none;" id="so{{$created_at->year}}-{{$carbon->month}}">...</span>
									</i>
                                                                                </button>
								{{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
								@else
								<button class="btn-disable btn btn-sm primary-btn {{$i}}" disabled>
									{{$carbon->format('M')}}
								</button>
								@endif
								<?php  $carbon->month = ++$carbon->month; ?>
								@endfor
							</div>
							@endif
							{{--*/ $y = $created_at->year; /*--}}
							
							@endforeach
						</div>
					</div>
					@endif


                    @if($mode=="osm" || empty($mode))
					<br><br>

					<!-- Commission -->
					<div class="salesorder purchase" style="">
						<h3 style="font-family: sans-serif">Commission</h3>
						{{-- <span>{{$name or ''}}</span><br> --}} 
						{{$company or ''}}<br>
						{{ $s->line1 or '' }}<br>
						{{ $s->line2 or '' }}<br>
						{{ $s->line3 or '' }}<br>
						{{ $s->line4  or '' }}<br>
						<div class="ym">
							{{--*/ $y = 1; $index = 0;/*--}}

							<?php if((count($queryStockReport)==0)){ $carbon = new Carbon();?>
							<div style="margin: 5px;">
								<span style="font-family: sans-serif;font-size: large;">
								{{date('Y')}}{{':'}}</span>
								@for($i = 0,$carbon->month = 1; $i < 12; $i++)
								<button class="btn-disable btn btn-sm primary-btn" disabled>
									{{$carbon->format('M')}}
								</button>
								<?php  $carbon->month = ++$carbon->month; ?>
								@endfor
							</div>
							<?php } ?>
							
							@foreach($queryStockReport as $returned)
								{{--*/

									$created_at = new Carbon\Carbon($returned->created_at); 
									$carbon = new Carbon();
									$index = 0;

									/*--}}

									@if($y != $created_at->year)
									
									<div style="margin: 5px;">
										<span style="font-family: sans-serif;font-size: large;">{{$created_at->year}}{{':'}}</span>
										@for($i = 0,$carbon->month = 1; $i < 12; $i++)
										@if(in_array($carbon->month, $stockreportyearmonth[$created_at->year]) )
										<button id="wastageform" class="btn-enable btn btn-sm primary-btn"month='{{$carbon->month}}' year='{{$carbon->year}}'href="{{url("/wastageform/$carbon->year/$carbon->month")}}" >
										<span id="so2{{$created_at->year}}-{{$carbon->month}}">{{$carbon->format('M')}}</span>
										<span style="display: none;" id="so{{$created_at->year}}-{{$carbon->month}}">...</span>
									</i>
                                                                                </button>
								{{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
								@else
								<button class="btn-disable btn btn-sm primary-btn {{$i}}" disabled>
									{{$carbon->format('M')}}
								</button>
								@endif
								<?php  $carbon->month = ++$carbon->month; ?>
								@endfor
							</div>
							@endif
							{{--*/ $y = $created_at->year; /*--}}
							
							@endforeach
						</div>
					</div>
					@endif



                    @if($mode=="osm" || empty($mode))
					<br><br>

					<!-- Quotation -->
					<div class="salesorder purchase" style="">
						<h3 style="font-family: sans-serif">Quotation</h3>
						{{-- <span>{{$name or ''}}</span><br> --}} 
						{{$company or ''}}<br>
						{{ $s->line1 or '' }}<br>
						{{ $s->line2 or '' }}<br>
						{{ $s->line3 or '' }}<br>
						{{ $s->line4  or '' }}<br>
						<div class="ym">
							{{--*/ $y = 1; $index = 0;/*--}}

							<?php if((count($queryStockReport)==0)){ $carbon = new Carbon();?>
							<div style="margin: 5px;">
								<span style="font-family: sans-serif;font-size: large;">
								{{date('Y')}}{{':'}}</span>
								@for($i = 0,$carbon->month = 1; $i < 12; $i++)
								<button class="btn-disable btn btn-sm primary-btn" disabled>
									{{$carbon->format('M')}}
								</button>
								<?php  $carbon->month = ++$carbon->month; ?>
								@endfor
							</div>
							<?php } ?>
							
							@foreach($queryStockReport as $returned)
								{{--*/

									$created_at = new Carbon\Carbon($returned->created_at); 
									$carbon = new Carbon();
									$index = 0;

									/*--}}

									@if($y != $created_at->year)
									
									<div style="margin: 5px;">
										<span style="font-family: sans-serif;font-size: large;">{{$created_at->year}}{{':'}}</span>
										@for($i = 0,$carbon->month = 1; $i < 12; $i++)
										@if(in_array($carbon->month, $stockreportyearmonth[$created_at->year]) )
										<button id="wastageform" class="btn-enable btn btn-sm primary-btn"month='{{$carbon->month}}' year='{{$carbon->year}}'href="{{url("/wastageform/$carbon->year/$carbon->month")}}" >
										<span id="so2{{$created_at->year}}-{{$carbon->month}}">{{$carbon->format('M')}}</span>
										<span style="display: none;" id="so{{$created_at->year}}-{{$carbon->month}}">...</span>
									</i>
                                                                                </button>
								{{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
								@else
								<button class="btn-disable btn btn-sm primary-btn {{$i}}" disabled>
									{{$carbon->format('M')}}
								</button>
								@endif
								<?php  $carbon->month = ++$carbon->month; ?>
								@endfor
							</div>
							@endif
							{{--*/ $y = $created_at->year; /*--}}
							
							@endforeach
						</div>
					</div>
					@endif
 


                    @if($mode=="osm" || empty($mode))
					<br><br>

					<!-- Consignment Note -->
					<div class="salesorder purchase" style="">
						<h3 style="font-family: sans-serif">Consignment Note</h3>
						{{-- <span>{{$name or ''}}</span><br> --}} 
						{{$company or ''}}<br>
						{{ $s->line1 or '' }}<br>
						{{ $s->line2 or '' }}<br>
						{{ $s->line3 or '' }}<br>
						{{ $s->line4  or '' }}<br>
						<div class="ym">
							{{--*/ $y = 1; $index = 0;/*--}}

							<?php if((count($queryStockReport)==0)){ $carbon = new Carbon();?>
							<div style="margin: 5px;">
								<span style="font-family: sans-serif;font-size: large;">
								{{date('Y')}}{{':'}}</span>
								@for($i = 0,$carbon->month = 1; $i < 12; $i++)
								<button class="btn-disable btn btn-sm primary-btn" disabled>
									{{$carbon->format('M')}}
								</button>
								<?php  $carbon->month = ++$carbon->month; ?>
								@endfor
							</div>
							<?php } ?>
							
							@foreach($queryStockReport as $returned)
								{{--*/

									$created_at = new Carbon\Carbon($returned->created_at); 
									$carbon = new Carbon();
									$index = 0;

									/*--}}

									@if($y != $created_at->year)
									
									<div style="margin: 5px;">
										<span style="font-family: sans-serif;font-size: large;">{{$created_at->year}}{{':'}}</span>
										@for($i = 0,$carbon->month = 1; $i < 12; $i++)
										@if(in_array($carbon->month, $stockreportyearmonth[$created_at->year]) )
										<button id="wastageform" class="btn-enable btn btn-sm primary-btn"month='{{$carbon->month}}' year='{{$carbon->year}}'href="{{url("/wastageform/$carbon->year/$carbon->month")}}" >
										<span id="so2{{$created_at->year}}-{{$carbon->month}}">{{$carbon->format('M')}}</span>
										<span style="display: none;" id="so{{$created_at->year}}-{{$carbon->month}}">...</span>
									</i>
                                                                                </button>
								{{--*/ if($index < count($m) - 1)$month = $m[++$index]; /*--}}
								@else
								<button class="btn-disable btn btn-sm primary-btn {{$i}}" disabled>
									{{$carbon->format('M')}}
								</button>
								@endif
								<?php  $carbon->month = ++$carbon->month; ?>
								@endfor
							</div>
							@endif
							{{--*/ $y = $created_at->year; /*--}}
							
							@endforeach
						</div>
					</div>
					@endif

					<!-- return of goods -->
					<input type="hidden" value="{{$e}}" id="nume" /> 
					<input type="hidden" value="{{$selluser->id}}" id="lpeid" />  
					<input type="hidden" value="{{$selluser->id}}" id="selluserid" />  

					<!-- Sales order -->
					<div class="modal fade" id="salesordermodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div id="salesordermodalbody" class="modal-dialog" role="document" style="width:950px;">
							
						</div>
					</div>


					
					<div class="modal fade" id="purchmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document" style="width:950px;">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h3 class="modal-title" id="myModalLabel2">Purchase Order Received</h3>
								</div>
								<div class="modal-body" id="purchmodalbody">

								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal" style="min-width: 60px;">Close</button>
								</div>
							</div>
						</div>
					</div>	

					<!-- Credit note -->
					<div class="modal fade" id="creditnote" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document" style="width:950px;">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h3 class="modal-title" id="myModalLabel2">Credit Note Issued</h3>
								</div>
								<div class="modal-body" id="creditnotebody">

								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal" style="min-width: 60px;">Close</button>
								</div>
							</div>
						</div>
					</div>	
					<!-- Credit note end -->


					<!-- Return of goods -->
					
					<div class="modal fade" id="returnofgoods" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document" style="width:950px;">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h3 class="modal-title" id="myModalLabel2">Return Of Goods</h3>
								</div>
								<div class="modal-body" id="returnofgoodsnotebody">

								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal" style="min-width: 60px;">Close</button>
								</div>
							</div>
						</div>
					</div>	
					<!-- End Return of goods -->

					<!-- Delivery Order Issued -->
					<div class="modal fade" id="deliveryorder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document" style="width:950px;">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h3 class="modal-title" id="myModalLabel2">Delivery Order Issued</h3>
								</div>
								<div class="modal-body" id="deliveryordernotebody">

								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal" style="min-width: 60px;">Close</button>
								</div>
							</div>
						</div>
					</div>	
					<!-- End Delivery order Issued -->
					<!-- Delivery Order Received -->
					<div class="modal fade" id="deliveryorderReceived" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document" style="width:950px;">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h3 class="modal-title" id="myModalLabel2">Delivery Order Received</h3>
								</div>
								<div class="modal-body" id="deliveryorderReceivednotebody">

								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal" style="min-width: 60px;">Close</button>
								</div>
							</div>
						</div>
					</div>	
					<!-- End Delivery order Received -->

				<!-- Oposum tax invoice!-->
				<div class="modal fade" id="oposumreceipt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document" style="width:500px;">
						<div class="modal-content">
							<div class="modal-header">
								
								<h3>
								OPOSsum Terminal List
								<small class="pull-right">
									<button type="button" class="close"
									data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</small>
								</h3>
							</div>
							<div class="modal-body" id="oposumreceiptbody">
							<table class="table " id="oposterminallisttable">
								<thead>
									<tr class="bg-opossum">
										<th class="text-center">No.</th>
										<th class="text-center">Location</th>
										<th class="text-center">Terminal</th>
									</tr>
								</thead>
								<tbody id="oposterminallisttabletbody">
									
								</tbody>
							</table>	
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal" style="min-width: 60px;">Close</button>
							</div>
						</div>
					</div>
				</div>
				<!-- End oposum tax invoice -->

				<div class="modal fade" id="receiptsmodal" role="dialog">
					<div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
							<div id="style"></div>
							<div style="padding:0" class="modal-body">
								<div style="padding-left:5px" class="">
										<div id="invoice-container"></div>

								</div>
							</div>
						</div>
					</div>
				</div>
                                
                                 
				<!-- Receipt model end -->
				<!--wastage form list of reports available--> 
				<div class="modal fade" id="wastageformmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document" style="width:500px;">
						<div class="modal-content">
							<div class="modal-header">
								
								<h3>
								Wastage Form List
								<small class="pull-right">
									<button type="button" class="close"
									data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</small>
								</h3>
							</div>
							<div class="modal-body" id="oposumreceiptbody">
                                                            
							<h3 id='wastagedate'></h3>
							<table class="table " id="wastageformtable">
								<thead>
									<tr style='background:darkolivegreen; color:white;'>
										<th class="text-center">No.</th>
										<th class="text-center">Date</th>
										<th class="text-center">Wastage ID</th>
                                        <th>Location</th>
									</tr>
								</thead>
								<tbody id="wastageformlist">
									
								</tbody>
								<tfoot id='footer'></tfoot>
							</table>	
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal" style="min-width: 60px;">Close</button>
							</div>
						</div>
					</div>
				</div>

<script>
                
function getMonthInString(mon){
	
	var months=[
	"Jan",
	"Feb",
	"Mar",
	"Apr",
	"May",
	"Jun",
	"Jul",
	"Aug",
	"Sep",
	"Oct",
	"Nov",
	"Dec"
	];
	return months[mon];
}

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [day,getMonthInString(month-1),year].join(' ');
}


$(function(){              
	$("body #wastageform").on("click",function(){
            var month=$(this).attr("month");
            var year=$(this).attr("year");
                    $("#wastageformmodal").modal("show");
                    $("#wastageformmodal #footer").html("<tr><td colspan='3'>"+
                    "loading...</td></tr>");
                    
                    console.log()
                        $("#wastagedate").html(getMonthInString(month-1)+" "+year);
                    
                    $("#wastageformlist").html("");
                    
                           $.ajax({
                          url:"{{url('/seller/getwastformreportbymonthyear')}}",
                          data:{
                          year:year,
                    month:month
                          },
                    success:function(data){
                    if(data.status==200){
                   
                  var i=1;
                    var location;
                    $.each(data.data,function(index,value){
                    location='';
                    if(value.location!==null){
                    location=value.location;
                    }
                    
                    
                    $("#wastageformlist").append(`
                    <tr><td class="text-center">${i++}</td>
                     <td class="text-center">${formatDate(value.created_at)}</td>
                       <td class="text-center"><a target='_blank' href='/wastageform/${value.id}'>${value.id}</a></td>
                        <td>${location}</td>
                    `);
                            
                    })
                           $('#wastageformtable').DataTable();
                            $("#wastageformmodal #footer").html("");
                    }else{
                    console.log(data);
                    }
                    }
                           
                           
                          })

})
})
                </script>
                                <script type="text/javascript">


						function invoicestatement(id,year,month) {
								//get the merchant data from the backend and render on the modal
								console.log($("#selluserid").val());
								$("#hsto" + year + "-" + month).hide();
								$("#isto" + year + "-" + month).show();
								$.ajax({
									type: "POST",
									url: JS_BASE_URL+"/invoicestatement/merchantdetail",
									data: { id:id,year:year,month:month,user_id:$("#selluserid").val() },
									beforeSend: function(){},
									success: function(response){
										$('#invmodalbody2').html(response);
										// $('#setmonthyearInvoice').html()
										$('#invmodal2').modal('toggle');
										$("#hsto" + year + "-" + month).show();
										$("#isto" + year + "-" + month).hide();
									}
								});
							}
//--------------------------debit note issued changed by dave------------------//

						function debitnotestatement(id,year,month) {
								console.log($("#selluserid").val());
								$("#hsto" + year + "-" + month).hide();
								$("#isto" + year + "-" + month).show();
								$.ajax({
									type: "POST",
									url: JS_BASE_URL+"/debitnotestatement/merchantdetail",
									data: { id:id,year:year,month:month,user_id:$("#selluserid").val() },
									beforeSend: function(){},
									success: function(response){
										
										$('#dnimodalbody').html(response);
										$('#dnimodal').modal('toggle');
										$("#hsto" + year + "-" + month).show();
										$("#isto" + year + "-" + month).hide();
									}
								});
							}
//--------------------------changed by dave------------------//
//--------------------------debit note Received changed by dave------------------//

						function debitnotestatement2(id,year,month) {
								console.log($("#selluserid").val());
								$("#hsto1" + year + "-" + month).hide();
								$("#isto1" + year + "-" + month).show();
								$.ajax({
									type: "POST",
									url: JS_BASE_URL+"/debitnotestatement/debitnotereceived",
									data: { id:id,year:year,month:month,user_id:$("#selluserid").val() },
									beforeSend: function(){},
									success: function(response){
										
										$('#dnrmodalbody').html(response);
										$('#dnrmodal').modal('toggle');
										$("#hsto1" + year + "-" + month).show();
										$("#isto1" + year + "-" + month).hide();
									}
								});
							}
//--------------------------changed by dave------------------//

							function invoicepurchase(id,year,month) {
								//get the merchant data from the backend and render on the modal
								console.log($("#selluserid").val());
								$("#hmer" + year + "-" + month).hide();
								$("#imer" + year + "-" + month).show();
								$.ajax({
									type: "POST",
									url: JS_BASE_URL+"/invoicepurchase/merchantdetail",
									data: { id:id,year:year,month:month,user_id:$("#selluserid").val() },
									beforeSend: function(){},
									success: function(response){
										$('#purchmodalbody').html(response);
										$('#purchmodal').modal('toggle');
										$("#hmer" + year + "-" + month).show();
										$("#imer" + year + "-" + month).hide();
									}
								});
							}
							
							function firstToUpperCase( str ) {
								return str.substr(0, 1).toUpperCase() + str.substr(1);
							}

							function validateEmail(email) {
								var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
								return re.test(email);
							}
							
							
							
							$(document).ready(function(){
								var emp_table = $('#documents-table').DataTable({
									"order": [],
									"columns": [
									{ "width": "20px", "orderable": false },
									{ "width": "120px" },
									{ "width": "120px" },
									{ "width": "120px" },
									{ "width": "120px" },
									{ "width": "120px" },
									{ "width": "120px" },
									]
								});		

								$(document).delegate( '.memberchek', "click",function (event) {
									if($(this).prop('checked')){
										$('.memberchek').prop('checked',false);
										$(this).prop('checked',true);
									}
								});				
								
								$(document).delegate( '.view-employee-modal', "click",function (event) {
							//	$('.view-employee-modal').click(function(){

								var user_id=$(this).attr('data-id');
								var check_url=JS_BASE_URL+"/admin/popup/lx/check/user/"+user_id;
								$.ajax({
									url:check_url,
									type:'GET',
									success:function (r) {
										console.log(r);

										if (r.status=="success") {
											var url=JS_BASE_URL+"/admin/popup/user/"+user_id;
											var w=window.open(url,"_blank");
											w.focus();
										}
										if (r.status=="failure") {
											var msg="<div class=' alert alert-danger'>"+r.long_message+"</div>";
											$('#employee-error-messages').html(msg);
										}
									}
								});
							});		
							});
						</script>		
						<br>
                <div class="modal fade" id="invmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document" style="width:950px;">
                        <div class="modal-content">
                            <div class="modal-header bg-gator">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h3 class="modal-title" id="myModalLabel2">Invoice Received</h3>
                            </div>
                            <div class="modal-body" id="invmodalbody">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal" style="min-width: 60px;">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="invmodal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document" style="width:950px;">
								<div class="modal-content">
									<div class="modal-header bg-gator">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h3 class="modal-title" id="myModalLabel2">Invoice Issued</h3>
									</div>
									<div class="modal-body" id="invmodalbody2">

									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal" style="min-width: 60px;">Close</button>
									</div>
								</div>
							</div>
						</div>
						<!--debitnote issued modal by dave -->	
						<div class="modal fade" id="dnimodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document" style="width:950px;">
								<div class="modal-content">
									<div class="modal-header bg-ageing">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h3 class="modal-title" id="myModalLabel2">Debit Note Issued</h3>
									</div>
									<div class="modal-body" id="dnimodalbody">

									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal" style="min-width: 60px;">Close</button>
									</div>
								</div>
							</div>
						</div>	

						<!--debitnote received modal popup by dave -->	

						<div class="modal fade" id="viewDebitNoteModal" role="dialog">
							<div style="width: 80%;"  class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close"  id="dnrmodalclose" style="position:relative;top:-6px" data-dismiss="modal">&times;</button>
								</div>
								<div class="modal-body" style="padding-top:0 !important">
									<div id="debitnoteview"></div>
								</div>
								<div class="modal-footer">
								</div>
							</div>
						</div>
						</div>

						<!--debitnote issued modal popup by dave -->	

						<div class="modal fade" id="viewDebitNoteissuedModal" role="dialog">
							<div style="width: 80%;"  class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" style="position:relative;top:-6px" data-dismiss="modal">&times;</button>
								</div>
								<div class="modal-body" style="padding-top:0 !important">
									<div id="debitnoteviewissued"></div>
								</div>
								<div class="modal-footer">
								</div>
							</div>
						</div>
						</div>


						<!--debitnote received modal by dave -->	
						<div class="modal fade" id="dnrmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document" style="width:950px;">
								<div class="modal-content">
									<div class="modal-header bg-ageing">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h3 class="modal-title" id="myModalLabel2">Debit Note received</h3>
									</div>
									<div class="modal-body" id="dnrmodalbody">

									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal" style="min-width: 60px;">Close</button>
									</div>
								</div>
							</div>
						</div>	


						<div class="modal fade" id="purchmodal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document" style="width:950px;">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h3 class="modal-title" id="myModalLabel2">Purchase Orders</h3>
									</div>
									<div class="modal-body" id="purchmodalbody2">

									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal" style="min-width: 60px;">Close</button>
									</div>
								</div>
							</div>
						</div>	
						<script type="text/javascript" src="http://www.openmalldev.com/js/qr.js"></script>
						<script type="text/javascript">

					//js for popup added by dave

						$(document).on('click', '.view_debit_notes1', function(e){
							
							e.preventDefault();
							url = $(this).attr('href');
							$.ajax({
								type: "GET",
								url: url,
								success: function( data ) {
									
									$('#viewDebitNoteissuedModal').modal('show');
									$("#debitnoteviewissued").html(data);
								}
							});
						});

						$(document).on('click', '.view_debit_notes', function(e){
							debugger;
							e.preventDefault();
							url = $(this).attr('href');
							$.ajax({
								type: "GET",
								url: url,
								success: function( data ) {
									$('#dnrmodal').modal('hide');
									
									$('#viewDebitNoteModal').modal('show');
									$("#debitnoteview").html(data);
									
								}
							});
						});

$('#dnrmodalclose').click(function(){
	$('#dnrmodal').modal('show');

});

							function invoicestatement2(id,year,month) {
							//get the merchant data from the backend and render on the modal
							console.log($("#selluserid").val());
							$("#hsto2" + year + "-" + month).hide();
							$("#isto2" + year + "-" + month).show();
							$.ajax({
								type: "POST",
								url: JS_BASE_URL+"/invoicestatement/stationdetail",
								data: { id:id,year:year,month:month,user_id:$("#selluserid").val() },
								beforeSend: function(){},
								success: function(response){
									$('#invmodalbody').html(response);
									$('#invmodal').modal('toggle');
									$("#hsto2" + year + "-" + month).show();
									$("#isto2" + year + "-" + month).hide();
								}
							});
						}
						
						function salesorder(id,year,month,cmonth) {
							//get the merchant data from the backend and render on the modal
							if (month <10) {
								var index = '0'+month+'-'+year;
							} else{
								var index = month+'-'+year;
							}

							console.log($("#selluserid").val());
							$("#so2" + year + "-" + month).hide();
							$("#so" + year + "-" + month).show();
							$.ajax({
								type: "POST",
								url: JS_BASE_URL+"/gator/salesorder",
								data: { id:id,year:year,month:month,user_id:$("#selluserid").val() },
								beforeSend: function(){},
								success: function(response){
									$('#salesordermodalbody').html(response);
									$('#setmonthyear').html(cmonth+" "+year);
									
									$('#salesordermodal').modal('toggle');
									$("#so2" + year + "-" + month).show();
									$("#so" + year + "-" + month).hide();
								}
							});
						}
						

						function invoicepurchase2(id,year,month) {
							//get the merchant data from the backend and render on the modal
							console.log($("#selluserid").val());
							$("#hmer2" + year + "-" + month).hide();
							$("#imer2" + year + "-" + month).show();
							$.ajax({
								type: "POST",
								url: JS_BASE_URL+"/invoicepurchase/stationdetail",
								data: { id:id,year:year,month:month,user_id:$("#selluserid").val() },
								beforeSend: function(){},
								success: function(response){
									$('#purchmodalbody').html(response);
									$('#purchmodal').modal('toggle');
									$("#hmer2" + year + "-" + month).show();
									$("#imer2" + year + "-" + month).hide();
								}
							});
						}

						/*Credit Note*/

						function creditnote(id,year,month) {
							//get the merchant data from the backend and render on the modal
							console.log($("#selluserid").val());
							$("#hmer2" + year + "-" + month).hide();
							$("#imer2" + year + "-" + month).show();
							console.log(id);

							$.ajax({
								type: "POST",
								url: JS_BASE_URL+"/creditnote/stationdetail",
								data: { id:id,year:year,month:month,user_id:$("#selluserid").val() },
								beforeSend: function(){},
								success: function(response){
									
									
									$('#creditnote').modal('toggle');
									$("#hmer2" + year + "-" + month).show();
									$("#imer2" + year + "-" + month).hide();
									$('#creditnotebody').html(response);
								}
							});
						}

							function credit_note_dealer(id,year,month) {
								//get the merchant data from the backend and render on the modal
								console.log($("#selluserid").val());
								$("#hmer2" + year + "-" + month).hide();
								$("#imer2" + year + "-" + month).show();
								console.log(id);

								$.ajax({
									type: "POST",
									url: JS_BASE_URL+"/creditnote/stationdetaildealer",
									data: { id:id,year:year,month:month,user_id:$("#selluserid").val() },
									beforeSend: function(){},
									success: function(response){


										$('#creditnote').modal('toggle');
										$("#hmer2" + year + "-" + month).show();
										$("#imer2" + year + "-" + month).hide();
										$('#creditnotebody').html(response);
									}
								});
							}
						/*End Credit note*/



						/*Return of goods*/
						function returnofgoods(id,year,month) {
							//get the merchant data from the backend and render on the modal
							console.log($("#selluserid").val());
							$("#hrog2" + year + "-" + month).hide();
							$("#irog2" + year + "-" + month).show();
							

							$.ajax({
								type: "POST",
								url: JS_BASE_URL+"/returnofgoods/stationdetail",
								data: { id:id,year:year,month:month,user_id:$("#selluserid").val() },
								beforeSend: function(){},
								success: function(response){
									
									
									$('#returnofgoods').modal('toggle');
									$("#hrog2" + year + "-" + month).show();
									$("#irog2" + year + "-" + month).hide();
									$('#returnofgoodsnotebody').html(response);
								}
							});
						}
						/*End return of goods*/


						/*DO*/
						function doissued(id,year,month) {
							//get the merchant data from the backend and render on the modal
							console.log($("#selluserid").val());
							$("#hmer2" + year + "-" + month).hide();
							$("#imer2" + year + "-" + month).show();
							

							$.ajax({
								type: "POST",
								url: JS_BASE_URL+"/deliveryorder/document",
								data: { id:id,year:year,month:month,user_id:$("#selluserid").val() },
								beforeSend: function(){},
								success: function(response){
									
									
									$('#deliveryorder').modal('toggle');
									$("#hmer2" + year + "-" + month).show();
									$("#imer2" + year + "-" + month).hide();
									$('#deliveryordernotebody').html(response);
								}
							});
						}

						function doreceived(id,year,month) {

							//get the merchant data from the backend and render on the modal

							$("#hmer2" + year + "-" + month).hide();
							$("#imer2" + year + "-" + month).show();
							

							$.ajax({
								type: "POST",
								url: JS_BASE_URL+"/deliveryorderreceived/document",
								data: { id:id,year:year,month:month,user_id:$("#selluserid").val() },
								beforeSend: function(){},
								success: function(response){
									
									
									$('#deliveryorderReceived').modal('toggle');
									$("#hmer2" + year + "-" + month).show();
									$("#imer2" + year + "-" + month).hide();
									$('#deliveryorderReceivednotebody').html(response);
								}
							});
						}
						/*End DO*/


							/*Tax Invoice*/
                            function opos_taxinvoice(id,year,month) {

                                //get the merchant data from the backend and render on the modal
                                console.log($("#selluserid").val());
                                $("#hmer2" + year + "-" + month).hide();
                                $("#imer2" + year + "-" + month).show();


                                $.ajax({
                                    type: "POST",
                                    url: JS_BASE_URL+"/opos_tax_invoice/document",
                                    data: { id:id,year:year,month:month,user_id:$("#selluserid").val() },
                                    beforeSend: function(){},
                                    success: function(response){


                                        $('#oposumreceipt').modal('toggle');
                                        $("#hmer2" + year + "-" + month).show();
                                        $("#imer2" + year + "-" + month).hide();
                                        $('#oposumreceiptbody').html(response);
                                    }
                                });
                            }
							/*End Tax Invoice*/
							$.ajax({
								url:"{{url('saleslog/active/months/2018')}}",
								type:"GET",
								success:function(r){
									if (r.status=="success") {
										data=r.data
									for (var i = data.length - 1; i >= 0; i--) {
										d=data[i]
										$(".sl2018"+d).prop('disabled',false).addClass("btn-enable").removeClass("btn-disable").attr('month',d).addClass("show_saleslog")
									}
									}
								},
								error:function(){}
							})

							$("body").on("click",".show_saleslog",function(){
								
							
								year="2018"
								month=$(this).attr('month')
								$.ajax({
								type: "POST",
								url: "{{URL('/saleslog/active/days')}}",
								data: {month,year},
								success: function(response) {
									slrows="";
									x=1;
									data=response.data
									for (var i = data.length - 1; i >= 0; i--) {
										d=data[i]
										
										slrows+=`
										<tr>
										<td>${x}</td>
										<td><a class="show_saleslog_day" day="${d.day}"
										month="${d.month}" year="${d.year}"
										>
										${d.day}${d.month_name}${d.year}
										</a></td>
										</tr>

										`;
									x++;
									}
									//console.log(slrows)
									$("#saleslogdoctablebody").empty();
									$("#saleslogdoctablebody").html(slrows);
									$("#saleslogdoctable").DataTable();
									$("#salesLogModal").modal("show");
									}
								});
							})
					</script>					
					<br><br>

				</div>
			</div>
		</div>
	</section>
	@stop
