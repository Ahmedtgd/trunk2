<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Classes;
?>                                
<div class="  ">
   <h2>OpenWish</h2>
	<br>
	<table class="table table-bordered text-muted counter_table" id="open_wish_table">
		<thead>
		<tr class="bg-yellow" style="color:#303030">
			<th class="text-center"
				colspan="5">Product Details</th>
			<th class="text-center" colspan="2">Time Details</th>
			<th class="text-center" colspan="5">Payment Details</th>
		</tr>
		<tr class="bg-yellow" style="color:#303030">
			<th class="textCenter">No</th>
			<th class="textCenter">OpenWish&nbsp;ID</th>
			<th class="textCenter">Product&nbsp;ID</th>
			<th class="textCenter">Date&nbsp;Started</th>
			<th class="textRight">Price</th>
			<th class="textCenter">Time</th>
			<th class="textCenter">Time&nbsp;Left</th>
			<th class="textRight">Pledge</th>
			<th class="textRight">Balance</th>
			<th class="textCenter">Status</th>
			<th class="ttextRight">Merchant&nbsp;Help</th>
			<th></th>
		</tr>
		</thead>
		<tbody>
			@if(isset($openwish))
				<?php $i=1; ?>
				@foreach($openwish as $o)
					<?php $product_id = $o->product_id;
							$ow_id = $o->id;
							$price=$o->retail_price;
							if ($o->discounted_price!=0 and $o->discounted_price< $price) {
								$price = $o->discounted_price;
							}
					?>
					<tr>
						<td class="textCenter"></td>
						<td class="textCenter">{{UtilityController::s_id($o->id)}}</td>
						<td class="textCenter">{{IdController::nP($o->product_id)}}</td>
						<td class="textCenter">{{UtilityController::s_date($o->created_at)}}</td>
						<td class="textRight">{{$currency_code .' '.number_format(($price / 100) , 2,'.',',')}}</td>
						<td class="textCenter">{{$o->duration}} Days</td>
						{{-- Time Left --}}
						<?php
						$current_date = Carbon::now();
						$created_at = \Carbon\Carbon::parse($o->created_at);
						$days_left = abs($current_date->day - $created_at->day + $o->duration)."d ";
						$hour_left = abs($current_date->hour - $created_at->hour)."h ";
						$minute_left = abs($current_date->minute - $created_at->minute)."m ";
						$help = abs($price / 100 - $o->pledged_amt / 100);
						?>
						<td class="textCenter">{{$days_left.$hour_left.$minute_left}}</td>
						<td class="textRight">{{$currency_code .' '.number_format(($o->pledged_amt / 100) , 2,'.',',')}}</td>
						<td class="textRight">{{$currency_code .' '.number_format((($price-$o->pledged_amt) / 100) , 2,'.',',')}}</td>
						<td class="textCenter">{{ucfirst($o->status)}}</td>
						<td class="textRight">{{$currency_code.' '.number_format($help, 2,'.',',')}}</td>
						<td class="textCenter">
							<a onclick="addToCart({{$product_id}}{{','}}{{$help}} {{','}}{{$ow_id}})"><span class="badge badge-help" style="background: #00FF01;">Pay</span></a>
							{{--<a onclick="$(this).parent().parent().remove();" class="pull-right"><i class="glyphicon glyphicon-remove text-danger"></i></a>--}}
						</td>
					</tr>
						<?php $i++;?>
				@endforeach

			@endif
		</tbody>
	</table>
</div>
