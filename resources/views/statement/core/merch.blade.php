<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
$counter=1;
$firstcycle=$cycle[0];
$secondcycle=$cycle[1];
$firstcyclepenalty=$cycle[2];
$secondcyclepenalty=$cycle[3];
$extraData=$cycle[4];
$month=$extraData[0];
$year=$extraData[1];
$firstcycleTotal=0;
$secondcycleTotal=0;
$rawMonth=$extraData[2];
// dump($month);
$fDebit=0;
$sDebit=0;
$glob=DB::table('global')->first();
$admin_fee=$glob->order_administration_fee;
$log_comm=$glob->logistic_commission;
$gate_comm=$glob->payment_gateway_commission;
$currency=$currentCurrency;
$carryOver=0;
$footcounter=1;
$footernotes=[];
?>
<style type="text/css">
	.money{
		text-align: right;
	}
	 .table td { 
     border-top: none !important; 
 }
 .hline{
 	border:3px solid  #b0b0b0;
 }

	 thead {
            display: table-header-group;
        }
        tfoot {
            display: table-row-group;
        }
        tr {
            page-break-inside: avoid;
        }

</style>
<div class="container">
		@if(isset($hideButton))
			<div class="row">
			
				<div class="col-xs-4  logo-holder">
	                    <a href="{{route('home')}}"><img src="{{asset('images/category/OpenSupermall Official Logo PNG.png')}}" class="img-responsive" alt="Logo"></a>
	            </div>
			
				
				<div class="col-xs-3"></div>
				<?php $merchant=$extraData[3];
					$merchant_address=$extraData[4];
				?>
				
				<div class="col-xs-5">
					<span>{{$merchant->company_name}}
					@for ($i=1; $i < 4; $i++)
							@if($merchant_address['line'.$i]!="")
								<br>{{$merchant_address['line'.$i]}}
							@endif
						@endfor
						<br>Malaysia, {{$merchant_address['postcode']}}
						<br>
					</span>
				</div>
			</div>
		@endif
		@if(isset($merchant_id))
			<input type="hidden" value="{{$merchant_id}}" id="merchant_id" />
		@endif
		<br>
		<div class="row">
			<div class="col-xs-12">
				{{-- Area where statement goes --}}
				<div id="hContainer">
					<div class="col-xs-8">
						<h3>STATEMENT: {{strtoupper($month)}} {{$year}}</h3>
					</div>
					@if(isset($hideButton))
					@else
						<div class="col-xs-2">
							@if(Auth::user()->hasRole('adm'))
								@if($rawMonth == date('m'))
									<a href="javascript:void(0)" class="btn btn-primary btn-info pull-right" style="background: rgb(39,169,138);" id="adjustment">Adjustment</a>
								@endif
							@endif
							&nbsp;
						</div>	
						<div class="col-xs-2">
						@if($type == "rc")
							<a href="{{url('pdf/m/'.$rawMonth."/".$year."/".$merchant_id.'/rc')}}" class="btn btn-primary btn-info pull-right" id="downloader"><span class="glyphicon 	glyphicon-download-alt"></span> Download</a>
						@else
							<a href="{{url('pdf/m/'.$rawMonth."/".$year."/".$merchant_id)}}" class="btn btn-primary btn-info pull-right" id="downloader"><span class="glyphicon glyphicon-download-alt"></span> Download</a>
						@endif
						</div>
						
					@endif
				</div>
				<div class="clearfix"></div>
				<table class="table tblbg" cellspacing="100%;">
					<thead>
						<tr>
					
							<th>Completed&nbsp;Date</th>
							<th>Order&nbsp;ID</th>
							<th>Description</th>
							<th style="text-align: center; min-width: 150px;">Debit</th>
							<th style="text-align: center;">Credit</th>
							<th style="text-align: center;">Balance</th>
						</tr>
					</thead>
					<tbody>
						@if(isset($cycle[0]) and !is_null($cycle[0]) and sizeof($cycle[0])>0)
							<span class="page">
							@foreach($firstcycle as $fc)
							@if($fc->oid != null)
								<?php $bypass=0;$orderTotal=0;$delivery=0;?>
								<tr>
									<td>{{UtilityController::s_date($fc->completed_at)}}</td>
									<td>
										@if($type == "rc")
											<a href="{{route('deliverorder', ['id' => $fc->oid])}}" target="_blank">{{IdController::nO($fc->oid)}}</a>
										@else
											<a href="{{route('deliverorder', ['id' => $fc->oid])}}" target="_blank">{{IdController::nO($fc->oid)}}</a>
										@endif
									</td>
									<td>Sales</td>
									<?php $carryOver+=$fc->price ;
									$orderTotal+=$fc->price ;?>
									@if($fc->status =="unpaid")
									<td class="money"></td>
									@else
									@endif
									<td class="money">{{$currency}}&nbsp;{{number_format(($fc->price)/100,2)}}</td>
								</tr>
									<td></td>
									<td></td>
									<td>
									OpenSupermall&nbsp;Commission
									<br>
									Payment&nbsp;Gateway
									<br>Logistic/Delivery
									<br>Administrative&nbsp;Fee
									</td>
									
									<td class="money">
										{{$currency}}&nbsp;{{number_format($fc->osmall_commission/100,2)}}<br>
										{{$currency}}&nbsp;{{number_format($fc->pgfee/100,2)}}<br>
										{{$currency}}&nbsp;{{number_format(($fc->delivery+$fc->rdelivery)/100,2)}}<br>
										{{$currency}}&nbsp;{{number_format($fc->oafee/100,2)}}</td>
									<td></td>
									<td class="money">
										<?php $carryOver -=$fc->pgfee;
										$orderTotal -=$fc->pgfee;
										 $carryOver -= ($fc->delivery+$fc->rdelivery) ;
										 $orderTotal -= ($fc->delivery+$fc->rdelivery) ;
										 ?>
										<br>
										<?php $carryOver -=$fc->oafee;
										$orderTotal -=$fc->oafee;
												$carryOver-=$fc->osmall_commission;
										$orderTotal-=$fc->osmall_commission;
										?>
										<br>
										<br>{{$currency}}&nbsp;{{number_format(($orderTotal)/100,2)}}
									</td>
									<tr class="hline"></tr>
							@endif
							<?php $counter++;?>
							@endforeach
							@endif
							@if(isset($cycle[2]) and !is_null($cycle[2]) and sizeof($cycle[2])>0)
								<span class="pagefp">
									@foreach($firstcyclepenalty as $fcp)
										<tr>
											<td>{{UtilityController::s_date($fcp->created_at)}}</td>
											<td>
												
											</td>
											<td>
												{{$fcp->description}} ({{$footcounter}})*
											</td>
											<td>
												
											</td>
											<td>
												
											</td>
											<td class="money">
												{{$currentCurrency}} {{number_format($fcp->price/100,2,'.','')}}
											</td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr class="hline"></tr>
										<?php 
											$footernotes[$footcounter] = $fcp->footer_note;
											$footcounter++; 	
											$carryOver-=$fc->price ;
										?>
									@endforeach
								</span>
							@endif		
							@if((isset($cycle[2]) and !is_null($cycle[2]) and sizeof($cycle[2])>0) || (isset($cycle[0]) and !is_null($cycle[0]) and sizeof($cycle[0])>0))
								<tr style="background-color: #54a6c4;color: white;">
									{{-- <th></th> --}}
									<th></th>
									<th></th>
									<th></th>
									<th class="text-right">1-15&nbsp;{{strtoupper(substr($month,0,3))}}{{$year}}</th>
									<th class="text-right">Outstanding&nbsp;Balance</th>
									<th class="money">{{$currency}}&nbsp;{{number_format($carryOver/100,2)}}</th>
								</tr>
							@endif
							</span>
					</tbody>
					
					<tbody>
						@if(isset($cycle[1]) and !is_null($cycle[1]) and sizeof($cycle[1])>0)
							
								<span class="pagesp">
								@foreach($secondcycle as $fc)
								@if($fc->oid != null)
									<?php $bypass=0;$orderTotal=0;$delivery=0;?>
									<tr>
										<td>{{UtilityController::s_date($fc->completed_at)}}</td>
										<td>
											@if($type == "rc")
												<a href="{{route('Receipt', ['id' => $fc->oid])}}" target="_blank">{{IdController::nO($fc->oid)}}</a>
											@else
												<a href="{{route('deliverorder', ['id' => $fc->oid])}}" target="_blank">{{IdController::nO($fc->oid)}}</a>
											@endif
										</td>
										<td>Sales</td>
										<?php $carryOver+=$fc->price ;
											$orderTotal+=$fc->price;
										?>
										@if($fc->status =="unpaid")
										<td class="money"></td>
										@else
										@endif
												<td class="money">{{$currency}}&nbsp;{{number_format(($fc->price)/100,2)}}
										</td>
									</tr>
										<td></td>
										<td></td>
										<td>
										OpenSupermall&nbsp;Commission
										<br>
										Payment&nbsp;Gateway
										<br>Logistic/Delivery
										<br>Administrative&nbsp;Fee
										</td>
										
										<td class="money">
									
											{{$currency}}&nbsp;{{number_format($fc->osmall_commission/100,2)}}
											<br>{{$currency}}&nbsp;{{number_format($fc->pgfee/100,2)}}
											<br>{{$currency}}&nbsp;{{number_format(($fc->delivery+$fc->rdelivery)/100,2)}}
											<br>{{$currency}}&nbsp;{{number_format($fc->oafee/100,2)}}
										</td>
										<td></td>
										<td class="money">
											<?php $carryOver -=$fc->pgfee;
											$orderTotal-=$fc->pgfee;
											
											 $carryOver -= ($fc->delivery+$fc->rdelivery) ;
											 $orderTotal-=($fc->delivery+$fc->rdelivery);
											 ?>
											<br>
											<?php $carryOver -=$fc->oafee;
												$carryOver-=$fc->osmall_commission;
												$orderTotal -=$fc->oafee;
												$orderTotal-=$fc->osmall_commission;
											?>
											<br>
											<br>{{$currency}}&nbsp;{{number_format(($orderTotal)/100,2)}}
										</td>
										<tr class="hline"></tr>
								@endif
								<?php $counter++;?>
								@endforeach
							</span>
						@endif
						@if(isset($cycle[3]) and !is_null($cycle[3]) and sizeof($cycle[3])>0)
							
								<span class="page">
								@foreach($secondcyclepenalty as $fcp)
									<tr>
										<td>{{UtilityController::s_date($fcp->created_at)}}</td>
										<td>
											
										</td>
										<td>
											{{$fcp->description}} ({{$footcounter}})*
										</td>
										<td>
											
										</td>
										<td>
											
										</td>
										<td class="money">
											{{$currentCurrency}} {{number_format($fcp->price/100,2,'.','')}}
										</td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<tr class="hline"></tr>
									<?php 
										$footernotes[$footcounter] = $fcp->footer_note;
										$footcounter++; 
										$carryOver-=$fc->price ;
									?>
								@endforeach
								</span>
							@endif
							@if((isset($cycle[1]) and !is_null($cycle[1]) and sizeof($cycle[1])>0) || (isset($cycle[3]) and !is_null($cycle[3]) and sizeof($cycle[3])>0))
								<tr style="background-color: #54a6c4;color: white;">
								{{-- <th></th> --}}
								<th></th>
								<th></th>
								<th></th>
								<th class="text-right">16-31&nbsp;{{strtoupper(substr($month,0,3))}}{{$year}}</th>
								<th class="text-right">Outstanding&nbsp;Balance</th>
								<th class="money">{{$currency}}&nbsp;{{number_format($carryOver/100,2)}}</th>
							@endif
						
					</tbody>
					<hr>
				</table>
				<?php $ii = 1; ?>
				@foreach($footernotes as $foot)
					*({{$ii}}) {{$foot}}
					<br>
					<?php $ii++; ?>
				@endforeach
			</div>
		</div>
	</div>
	<div class="modal fade" id="myModalAdjustment" role="dialog" aria-labelledby="myModalRemarks">
		<div class="modal-dialog" role="remarks" style="width: 50%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
						aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" align="center" id="myModalLabel">New Adjustment</h4>
				</div>
				<div class="modal-body">
					<div class="row" style="padding: 15px;">
						<div class="col-md-12" style="">			
							<div class="col-md-2" style="">
								<p><b>{{$currentCurrency}}</b></p>
							</div>
							<div class="col-md-2" style="">
								<input type="text" class="form-control" value="0" id="price_ad" />
							</div>
							<div class="clearfix"> </div><br>
							<div class="col-md-2" style="">
								<p><b>Description</b></p>	
							</div>
							
							<div class="col-md-8" style="">
								<input type="text" class="form-control" value="" id="description" placeholder="Short description here..." />
							</div>
							<div class="clearfix"> </div><br>
							<div class="col-md-2" style="">
								<p><b>Footer Note</b></p>	
							</div>
							
							<div class="col-md-8" style="">
								<input type="text" class="form-control" value="" id="footer" placeholder="Footer here..." />
							</div>
							<div class="clearfix"></div><br>
							<div class="col-md-12" style="">
								<a href="javascript:void(0);" class="btn btn-primary add_adj pull-right">Add</a>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				
			</div>
		</div>		
	</div>		
	<script>
		$(document).ready(function () {
			$('.adjustmentprice').number(true, 2, '.', '');
			$('#price_ad').number(true, 2, '.', '');
			$('#adjustment').click(function(e){
				
			   e.preventDefault(); 
				$("#myModalAdjustment").modal('show');
		   });
		   
		   $('.add_adj').click(function(e){
				var adjustment = parseFloat($("#price_ad").val());
				var description = $("#description").val();
				var footer = $("#footer").val();
				var merchant_id = $("#merchant_id").val();
				console.log(adjustment);
				if(adjustment <=0){
					toastr.error("Price cannot be less than 0");
				} else {
					$.ajax({
						type: "POST",
						data: { 
							adjustment:adjustment, 
							description:description, 
							footer:footer, 
							merchant_id:merchant_id 
						},
						url: JS_BASE_URL+"/statement/add_adjustment",
						beforeSend: function(){},
						success: function(response){
							toastr.info("Adjustment Successfully saved!");
							location.reload();
						}
					});
			    }
			});
		});
	</script>
