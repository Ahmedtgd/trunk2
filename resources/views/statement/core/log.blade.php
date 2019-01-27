<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
$counter=1;
$firstcycle=$cycle[0];
$secondcycle=$cycle[1];
$extraData=$cycle[2];
$month=$extraData[0];
$year=$extraData[1];
$firstcycleTotal=0;
$secondcycleTotal=0;
$rawMonth=$extraData[2];
// dump($month);
$fDebit=0;
$sDebit=0;
$currency=$currentCurrency;
$carryOver=0;
?>
<style type="text/css">
	.money{
		text-align: right;
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
		<div class="row">
			<div class="col-xs-12">
				{{-- Area where statement goes --}}
				<div id="hContainer">
					<h3>STATEMENT: {{strtoupper($month)}} {{$year}}</h3>
					@if(isset($hideButton))@else<a href="{{url('pdf/l/'.$rawMonth."/".$year)}}" class="btn btn-primary btn-info pull-right" id="downloader"><span class="glyphicon glyphicon-download-alt"></span> Download</a>@endif
				</div>
				<table class="table tblbg" cellspacing="100%;">
					<thead>
						<tr>
					
							<th>Completed&nbsp;Date</th>
							<th>Delivery&nbsp;ID</th>
							<th>Description</th>
							<th style="text-align: right; min-width: 150px;">Debit</th>
							<th style="text-align: right;">Credit</th>
							<th style="text-align: right;">Balance</th>
						</tr>
					</thead>
					<tbody>
						@if(isset($cycle[0]) and !is_null($cycle[0]) and sizeof($cycle[0])>0)
							
								<span class="page">
								@foreach($firstcycle as $fc)
								@if($fc->did != null)
									<?php $bypass=0;$orderTotal=0;$delivery=0;?>
									<tr>
										<td>{{UtilityController::s_date($fc->completed_at)}}</td>
										<td><a href="{{route('deliverorder', ['id' => $fc->poid])}}" target="_blank">{{IdController::nDel($fc->did)}}</a></td>
										<td>Sales</td>
										<?php $carryOver+=$fc->price ;?>
										@if($fc->status =="unpaid")
										<td class="money"></td>
										@else
										@endif
												<td class="money">{{$currency}}&nbsp;{{number_format(($carryOver)/100,2)}}
										</td>
									</tr>
										<td></td>
										<td></td>
										<td>
										Logistic&nbsp;Commission
										
								
										<br>Administrative&nbsp;Fee
										</td>
										
										<td class="money">
									
											{{$currency}}&nbsp;{{number_format($fc->logistic_commission/100,2)}}
											
										
											<br>{{$currency}}&nbsp;{{number_format($fc->dafee/100,2)}}
										</td>
										<td></td>
										<td class="money">
										
											<?php $carryOver -=$fc->dafee;
													$carryOver-=$fc->logistic_commission;
											?>
											<br>
											<br>{{$currency}}&nbsp;{{number_format(($carryOver)/100,2)}}
										</td>
								@endif
								<?php $counter++;?>
								@endforeach
							<tr style="background-color: #54a6c4;color: white;">
							{{-- <th></th> --}}
							<th></th>
							<th></th>
							<th></th>
							<th>1-15&nbsp;{{strtoupper(substr($month,0,3))}}{{$year}}</th>
							<th>Outstanding&nbsp;Balance</th>
							<th class="money">{{$currency}}&nbsp;{{number_format($carryOver/100,2)}}</th>
						</tr>
							</span>
						@endif
						
			
					</tbody>
				
					<tbody>
						@if(isset($cycle[1]) and !is_null($cycle[1]) and sizeof($cycle[1])>0)
							
								<span class="page">
								@foreach($secondcycle as $fc)
								@if($fc->did != null)
									<?php $bypass=0;$orderTotal=0;$delivery=0;?>
									<tr>
										<td>{{UtilityController::s_date($fc->completed_at)}}</td>
										<td><a href="{{route('deliverorder', ['id' => $fc->poid])}}" target="_blank">{{IdController::nDel($fc->did)}}</a></td>
										<td>Sales</td>
										<?php $carryOver+=$fc->price ;?>
										@if($fc->status =="unpaid")
										<td class="money"></td>
										@else
										@endif
												<td class="money">{{$currency}}&nbsp;{{number_format(($carryOver)/100,2)}}
										</td>
									</tr>
										<td></td>
										<td></td>
										<td>
										Logistic&nbsp;Commission
										<br>Administrative&nbsp;Fee
										</td>
										
										<td class="money">
									
											{{$currency}}&nbsp;{{number_format($fc->logistic_commission/100,2)}}
											
											
											<br>{{$currency}}&nbsp;{{number_format($fc->dafee/100,2)}}
										</td>
										<td></td>
										<td class="money">
											
											<?php $carryOver -=$fc->dafee;
													$carryOver-=$fc->logistic_commission;
											?>
											<br>
											<br>{{$currency}}&nbsp;{{number_format(($carryOver)/100,2)}}
										</td>
								@endif
								<?php $counter++;?>
								@endforeach
							<tr style="background-color: #54a6c4;color: white;">
							{{-- <th></th> --}}
							<th></th>
							<th></th>
							<th></th>
							<th>16-31&nbsp;{{strtoupper(substr($month,0,3))}}{{$year}}</th>
							<th>Outstanding&nbsp;Balance</th>
							<th class="money">{{$currency}}&nbsp;{{number_format($carryOver/100,2)}}</th>
						</tr>
							</span>
						@endif
						
			
					</tbody>
				</table>
			</div>
		</div>
	</div>
<script type="text/javascript">
	$(document).ready(function(){
		// $url=window.location.href;
		// $url=$('#downloader').attr('href');
		// window.open($url);
	});
</script>
