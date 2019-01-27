@extends("common.default")
@section("extra-links")
<style type="text/css">
	.thead th{
		text-align: center;
	}
</style>
@stop
@section("content")

<br><br>
<div class="container"><!--Begin main cotainer-->
	<h1>Bank Payment View</h1> <br>
	@if(Session::has('error_msg'))
    <div class="alert alert-danger"></span><strong> {!! session('error_msg') !!}</strong></div><br>
	@elseif(Session::has('success_msg'))
    <div class="alert alert-success"></span><strong> {!! session('success_msg') !!}</strong></div><br>
	@endif
	{!! Form::open(array('url'=>'/paystaff')) !!}
	<div class="row">
		@if(isset($order_array))
		<div class="table-responsive col-sm-12 ">
		    <table class="table table-condensed table-bordered text-muted " id="paymentRequest">
		    	<thead>
			        <tr class="bg-success">
			            <th colspan="100" class='text-center' style='font-weight: 900; font-size: 20px; color: #fff' >Order View</th>
			        </tr>
			        <thead>
						<tr>
							<td colspan=5 class='text-center' style='background:#FFCC00; font-size: 16px; color: #222'>Order</td>
							<td colspan=3 class='text-center' style='background:#99FF99; font-size: 16px; color: #222'>Payment&nbsp;In</td>
							<td colspan=4 class='text-center' style='background:#FF99FF; font-size: 16px; color: #222'>Payment Out</td>
						</tr>
						<tr class='thead' style='color: #111'>
							<th>No</th>
							<th>Order&nbsp;ID</th>
							<th>User</th>
							<th>Merchant</th>
							<th>Product</th>
							<th>Amount</th>
							<th>Delivered</th>
							<th>Receipt</th>
							<th>OpenSupermall</th>
							<th style='width:120px'>Merchant</th>
							<th>MC</th>
						</tr>
					</thead>

					<tbody>
						<?php $i=1; ?>
						@foreach($order_array as $key=>$order)
						<?php  
							$userid = $order['userid'];
							$username = $order['username'];
							$delivery_date = $order['delivery'];
							$receipt_date = $order['receipt'];
							$amount = $order['paymentIn'];
							$osmall_commission = $order['merchant_osmall_commission'];
							$opensupermall = ($amount/100) * ($osmall_commission/100);
							$merchant = ($amount/100) - $opensupermall;
							$mc_staff_id = null;
							$rc_staff_id = null;

							if(isset($order['mc_staff_id']) and
								$order['mc_staff_id'] != null and
								$order['mc_staff_id'] > 0){
								$mc_staff_id = str_pad($order['mc_staff_id'], 5, '0', STR_PAD_LEFT);
							}else{
								$mc_staff_id = null;
							}

							if(isset($order['rc_staff_id']) and
								$order['rc_staff_id'] != null and
								$order['rc_staff_id'] > 0){
								$rc_staff_id = str_pad($order['rc_staff_id'], 5, '0', STR_PAD_LEFT);
							}else{
								$rc_staff_id = null;
							}

							if (isset($order['mc_staff_name'])) {
								$mc_staff_name = $order['mc_staff_name'];
							} else {
								$mc_staff_name = null;
							}

							if (isset($order['rc_staff_name'])) {
								$rc_staff_name = $order['rc_staff_name'];
							} else {
								$rc_staff_name = null;
							}

							$mc = $order['mc_commission'] * $opensupermall;
							$rc = $order['mc_ref_commission'] * $opensupermall;
							
						?>
						<tr>
							<td>{!! $i++ !!}</td>
							<td>
								<button data='{!! $key !!}'
									style='border-color:transparent; background: transparent'
									class="btn btn-default btn-xs arrow orderRow">
									<i class="fa fa-chevron-right"></i></button>
								{!! $key !!}
							</td>
							<td>[{!! str_pad($userid, 5, '0', STR_PAD_LEFT) !!}]&nbsp;{!! $username !!}</td>
							<td></td>
							<td></td>
							<td class='text-right'>
								@if($amount != null and $amount != '' and $amount > 0)
								{!! $currency !!}&nbsp;{!! number_format($amount/100,2) !!}
								@endif 
							</td>
							<td class='text-center'>{!! $delivery_date !!}</td>
							<td class='text-center'>{!! $receipt_date !!}</td>
							<td class='text-right'>
								@if($opensupermall != null and $opensupermall != '' and $opensupermall > 0)
								{!! $currency !!}&nbsp;{!! number_format($opensupermall,2) !!}
								@endif 
							<td>
								@if ($merchant !=null or $merchant > 0)
								<span class='pull-left'><input name='' type='checkbox' class='merchantCheck' data='{!! $key !!}'></span>
								<span class='pull-right text-right'>
									{!! $currency !!}&nbsp;{!! number_format($merchant,2) !!}
								</span>
								@endif
							</td>
							<td width=250>
								@if($mc != null and $mc != 0 and $mc_staff_id != null and $mc_staff_name != null)
								<div style='display: inline-block; width:100%'>
									<span><input type='checkbox' class='mc' data='{!! $key !!}'></span>
									<span>
									MC [{!! $mc_staff_id !!}]&nbsp;{!! $mc_staff_name !!}&nbsp;{!! $currency !!}&nbsp;{!! number_format($mc,2) !!}
									</span>
								</div>
								@endif
								@if($rc != null and $rc != 0 and $rc_staff_id != null and $rc_staff_name != null)
								<div style='display: inline-block; width:100%'>
									<span><input type='checkbox' class='rc' data='{!! $key !!}'></span>
									<span>
										Ref [{!! $rc_staff_id !!}]&nbsp;{!! $rc_staff_name !!}&nbsp;{!! $currency !!}&nbsp;{!! number_format($rc,2) !!}
									</span>
								</div>
								@endif
							</td>
						</tr>
							@if(!empty($product_array[$key]))
								<?php $p=1; ?>
								@foreach($product_array[$key] as $product)
								<?php 
									$merchant_oshop_name = $order['merchant_oshop_name'];
									$products = explode('/', $product);
									$product_id = $products[0];
									$product_name = $products[1];
									$product_amount = (float)$products[2];
									$product_osmall_commission = $products[7];
									$product_mc_commission = $products[8];
									$product_rc_commission = $products[9];
									$product_opensupermall = ($product_amount/100) * ($product_osmall_commission/100);
									$product_merchant = ($product_amount/100) - $product_opensupermall;
									$product_mc_staff_id = null;
									$product_rc_staff_id = null;
									if($products[3] != null or $products[3] > 0){
										$product_mc_staff_id = $products[3];
									}else{
										$product_mc_staff_id = null;
									}
									$product_mc_staff_name = $products[3];
									if($products[5] != null or $products[5] > 0){
										$product_rc_staff_id = $products[5];
									}else{
										$product_rc_staff_id = null;
									}
									$product_rc_staff_name = $products[6];
									$product_mc = $product_mc_commission * $product_opensupermall;
									$product_rc = $product_rc_commission * $product_opensupermall;
								?>
								<tr class="hide rowExpand-{!! $key !!}" id="demo1">
									<td></td>
									<td></td>
									<td></td>
									<td>[{!! str_pad($userid, 5, '0', STR_PAD_LEFT) !!}] &nbsp; {!! $merchant_oshop_name !!}</td>
									<td>
										{!! $product_id !!}&nbsp;{!! $product_name !!} 
									</td>
									<td class='text-right'>
										@if($product_amount != null or $product_amount != '')
											{!! $currency !!}&nbsp;{!! number_format($product_amount/100,2) !!}
										@endif
									</td>
									<td class='text-center'></td>
									<td class='text-center'></td>
									<td class='text-right'>
										@if ($product_opensupermall != null and $product_opensupermall != '')
										{!! $currency !!}&nbsp;{!! number_format($product_opensupermall,2) !!}
										@endif
									</td>
									<td>
										@if ($product_merchant != null)
											@if(\App\Models\OcbcPaymentStatus::where('porder_id',$key)
											->where('product_id',$product_id)->where('user_id', $userid)
											->where('success_indicator', 1)->first())
											<span class='pull-right text-right' style='color : darkgreen'>
												{!! $currency !!}&nbsp;{!! number_format($product_merchant,2) !!}
											</span>
											@else
											<span class='pull-left'>
												<input name='merchants[{!! $key !!}][{!! $product_id !!}][{!! $userid !!}][]' id='merchant_check-{!! $key !!}' class='merchant_check-{!! $key !!}' value='{!! $product_merchant !!}' type='checkbox'>
											</span>
											<span class='pull-right text-right'>
												{!! $currency !!}&nbsp;{!! number_format($product_merchant,2) !!}
											</span>
											@endif
										@endif
									</td>
									<td width=250>
										@if($product_mc != null and $product_mc != 0 and
											$product_mc_staff_id != null and $product_mc_staff_name != null)
											@if(\App\Models\OcbcPaymentStatus::where('porder_id',$key)
											->where('product_id',$product_id)->where('user_id', $product_mc_staff_id)
											->where('success_indicator', 1)->first())
											<div style='display: inline-block; width:100%; color:darkgreen'>
												<span>
													MC [{!! str_pad($product_mc_staff_id, 5, '0', STR_PAD_LEFT) !!}]&nbsp;{!! $product_mc_staff_name !!}&nbsp;{!! $currency !!}&nbsp;{!! number_format($product_mc,2) !!}
												</span>
											</div>
											@else
											<div style='display: inline-block; width:100%'>
												<span>
													<input name='mc[{!! $key !!}][{!! $product_id !!}][{!! $product_mc_staff_id !!}][]' id='mc-{!! $key !!}-{!! $p !!}' class='mc-{!! $key !!}' value='{!! $product_mc !!}' type='checkbox'>
												</span>
												<span>
													MC [{!! str_pad($product_mc_staff_id, 5, '0', STR_PAD_LEFT) !!}]&nbsp;{!! $product_mc_staff_name !!}&nbsp;{!! $currency !!}&nbsp;{!! number_format($product_mc,2) !!}
												</span>
											</div>
											@endif
										@endif
										@if($product_rc != null and $product_rc != 0 and 
											$product_rc_staff_id != null and $product_rc_staff_name != null)
											@if(\App\Models\OcbcPaymentStatus::where('porder_id',$key)
											->where('product_id',$product_id)->where('user_id', $product_rc_staff_id)
											->where('success_indicator', 1)->first())
											<div style='display: inline-block; width:100%; color:darkgreen'>
												<span>
												Ref [{!! str_pad($product_rc_staff_id, 5, '0', STR_PAD_LEFT) !!}]&nbsp;{!! $product_rc_staff_name !!}&nbsp;{!! $currency !!}&nbsp;{!! number_format($product_rc,2) !!}
												</span>
											</div>
											@else
											<div style='display: inline-block; width:100%'>
												<span>
													<input name='rc[{!! $key !!}][{!! $product_id !!}][{!! $product_rc_staff_id !!}][]' id='rc-{!! $key !!}-{!! $p !!}' class='rc-{!! $key !!}' value='<?php echo $product_rc; ?>' type='checkbox'>
												</span>
												<span>
												Ref [{!! str_pad($product_rc_staff_id, 5, '0', STR_PAD_LEFT) !!}]&nbsp;{!! $product_rc_staff_name !!}&nbsp;{!! $currency !!}&nbsp;{!! number_format($product_rc,2) !!}
												</span>
											</div>
											@endif
										@endif
									</td>
								</tr>
								<?php $p++; ?>
								@endforeach
							@endif
						@endforeach
					</tbody>
		    </table>
		</div>
		@endif
	</div>

	@if(isset($merchant_array) and isset($smm_product_array) and isset($smm_array))
	<div class="row">
		<div class="table-responsive col-sm-12 ">
		    <table class="table table-condensed table-bordered text-muted " id="paymentRequest">
		    	<thead>
			        <tr class="bg-success">
			            <th colspan="100" class='text-center' style='font-weight: 900; font-size: 20px; color: #fff' >Merchant View</th>
			        </tr>
			        <thead>
						<tr class='thead' style='color: #111'>
							<th>No</th>
							<th>Merchant</th>
							<th>Product</th>
							<th>Order</th>
							<th>Amount</th>
							<th>OpenSupermall</th>
							<th>Merchant</th>
							<th>MC</th>
							<th>SMM</th>
						</tr>
					</thead>

					<tbody>
						<?php $c = 1; ?>
						@foreach($merchant_array as $merchant)
						<?php  
							$merchant_id = $merchant['merchantID'];
							$merchant_name = $merchant['merchantName'];
						?>
						<tr>
							<td>{!! $c++ !!}</td>
							<td>
								<button data-smm='{!! $c !!}'
									style='border-color:transparent; background: transparent'
									class="btn btn-default btn-xs arrow orderRowSmm">
									<i class="fa fa-chevron-right"></i></button>
								[{!! str_pad($merchant_id, 5, '0', STR_PAD_LEFT) !!}]&nbsp;{!! $merchant_name !!}
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
							@if(!empty($smm_product_array))
								@foreach($smm_product_array[$merchant_id] as $smm_product)
								<?php 
									$productID = $smm_product['productID'];
									$productName = $smm_product['productName'];
									$productOrder = $smm_product['productOrder'];
									$productAmount = $smm_product['productAmount'];
									$productOpensupermall = $smm_product['productOpensupermall'];
									$productMerchantRev = $smm_product['productMerchantRev'];
									$productMC = $smm_product['mc_commission'];
									$productRC = $smm_product['mc_ref_commission'];
									$product_MC_staff_id = $smm_product['mc_staff_id'];
									$product_MC_staff_name = $smm_product['mc_staff_name'];
									$product_RC_staff_id = $smm_product['rc_staff_id'];
									$product_RC_staff_name = $smm_product['rc_staff_name'];

									if(isset($product_MC_staff_id) and
										$product_MC_staff_id != null and
										$product_MC_staff_id > 0){
										$MC_staff_id = str_pad($product_MC_staff_id, 5, '0', STR_PAD_LEFT);
									}else{
										$MC_staff_id = null;
									}

									if(isset($product_RC_staff_id) and
										$product_RC_staff_id != null and
										$product_RC_staff_id > 0){
										$RC_staff_id = str_pad($product_RC_staff_id, 5, '0', STR_PAD_LEFT);
									}else{
										$RC_staff_id = null;
									}

									if (isset($product_MC_staff_name)) {
										$MC_staff_name = $product_RC_staff_name;
									} else {
										$MC_staff_name = null;
									}

									if (isset($product_RC_staff_name)) {
										$RC_staff_name = $product_RC_staff_name;
									} else {
										$RC_staff_name = null;
									}
								?>
								<tr class="hide rowExpandSmm-{!! $c !!}" id="demo1">
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>[{!! str_pad($productID, 5, '0', STR_PAD_LEFT) !!}]&nbsp;{!! $productName !!}</td>
									<td>[{!! str_pad($productOrder, 5, '0', STR_PAD_LEFT) !!}]</td>
									<td>{!! $currency !!}&nbsp;{!! number_format($productAmount/100,2) !!}</td>
									<td>{!! $currency !!}&nbsp;{!! number_format($productOpensupermall,2) !!}</td>
									<td>{!! $currency !!}&nbsp;{!! number_format($productMerchantRev,2) !!}</td>
									<td width=250>
										@if($productMC != null and $productMC != 0 and
											$product_MC_staff_id != null and $product_MC_staff_name != null)
										<div style='display: inline-block; width:100%'>
											<span>
												MC [{!! str_pad($product_MC_staff_id, 5, '0', STR_PAD_LEFT) !!}]&nbsp;
												{!! $product_MC_staff_name !!}&nbsp;
												{!! $currency !!}&nbsp;{!! number_format($productMC,2) !!}
											</span>
										</div>
										@endif
										@if($productRC != null and $productRC != 0 and 
											$product_RC_staff_id != null and $product_RC_staff_name != null)
										<div style='display: inline-block; width:100%'>
											<span>
											Ref [{!! str_pad($product_RC_staff_id, 5, '0', STR_PAD_LEFT) !!}]&nbsp;
											{!! $product_RC_staff_name !!}&nbsp;
											{!! $currency !!}&nbsp;{!! number_format($productRC,2) !!}
											</span>
										</div>
										@endif
									</td>
									<td>
										@if(!empty($smm_array))
											<?php $j=0; ?>
											@foreach($smm_array[$merchant_id][$productID] as $smm_commission)
												<?php 
													$user_id = $smm_commission['user_id'];
													$username = $smm_commission['username'];
													$smm = $smm_commission['smm'];
												?>
												@if(\App\Models\OcbcPaymentStatus::where('porder_id',$productOrder)
													->where('product_id',$productID)->where('user_id', $user_id)
													->where('success_indicator', 1)->first())
												<div style='display: inline-block; width:100%; color:darkgreen'>
													[{!! str_pad($user_id, 5, '0', STR_PAD_LEFT) !!}]&nbsp;
													{!! $username !!}&nbsp;
													{!! $currency !!}&nbsp;{!! number_format($smm,2) !!}
													</span>
												</div>
												@else
												<div style='display: inline-block; width:100%'>
													<span>
														<input name='smm[{!! $productOrder !!}][{!! $productID !!}][{!! $user_id !!}][]' id='smm-{!! $merchant_id !!}-{!! $productID !!}' class='sc' value='{!! $smm !!}' type='checkbox'>
													</span>
													<span>
													[{!! str_pad($user_id, 5, '0', STR_PAD_LEFT) !!}]&nbsp;
													{!! $username !!}&nbsp;
													{!! $currency !!}&nbsp;{!! number_format($smm,2) !!}
													</span>
												</div>
												@endif
											@endforeach
											<?php $j++; ?>
										@endif
									</td>
								</tr>
								@endforeach
							@endif
						@endforeach
					</tbody>
		    </table>
		</div>
	</div>
	@endif

	<center>
		<button style='border-radius: 3px;padding: 5px 40px;' type='submit' class='btn btn-green btn-md'>Pay</button>
	</center>
	{!! Form::close() !!}
</div>
<br><br><br><br>
</div>
@stop

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){

	$('.arrow').click(function(){
		$(this).find('.fa').toggleClass('fa-chevron-down fa-chevron-right');
	})

	$(".orderRow").click(function(e) {
 		e.preventDefault();
		val = $(this).attr('data');
		if($('.rowExpand-'+val).hasClass('hide'))
		{
    		$('.rowExpand-'+val).removeClass('hide');
		}else{
			$('.rowExpand-'+val).addClass('hide');
		}
 	});

 	$(".orderRowSmm").click(function(e) {
 		e.preventDefault();
		val = $(this).attr('data-smm');
		if($('.rowExpandSmm-'+val).hasClass('hide'))
		{
    		$('.rowExpandSmm-'+val).removeClass('hide');
		}else{
			$('.rowExpandSmm-'+val).addClass('hide');
		}
 	});

	$(".merchantCheck").click(function() {
		val = $(this).attr('data');
    	$('.merchant_check-'+val).prop('checked', this.checked);
 	});

 	$(".mc").click(function() {
		val = $(this).attr('data');
    	$('.mc-'+val).prop('checked', this.checked);
 	});

	function number_format(number, decimals, dec_point, thousands_sep) {
		number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
		var n = !isFinite(+number) ? 0 : +number,
		prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
		sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
		dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
		s = '',
		toFixedFix = function(n, prec) {
			var k = Math.pow(10, prec);
			return '' + (Math.round(n * k) / k).toFixed(prec);
			};
			// Fix for IE parseFloat(0.55).toFixed(0) = 0;
			s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
			if (s[0].length > 3) {
			s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
			}
			if ((s[1] || '')
			.length < prec) {
			s[1] = s[1] || '';
			s[1] += new Array(prec - s[1].length + 1).join('0');
		}
		return s.join(dec);
	}
})
</script>
@stop
