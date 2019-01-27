<?php
use App\Http\Controllers\UtilityController;
use App\Classes;
?>
<h2>Sales Delivery</h2>
	<br>
	<table class="table table-bordered " id="shippings_details_table">
		<thead>
			<tr style="background-color:rgb(64,49,82); color: white;">
				<th class="text-center no-sort">No.</th>
				<th class="text-center">Order&nbsp;ID</th>
				<th>Merchant&nbsp;ID</th>
				<th class="text-center">External&nbsp;Delivery&nbsp;ID</th>
				<th class="text-center">Delivery&nbsp;Company</th>
				<th class="text-center">Status</th>
				<th class="text-center">Days&nbsp;Since&nbsp;Ordered</th>
				<th style="background-color:rgb(41,135,177); color: white;">Date&nbsp;Received</th>
				<th style="background-color:rgb(41,135,177); color: white;">Due&nbsp;Date</th>
			</tr>
		</thead>
		<?php $i=1;?>
		<tbody>
			@if(isset($shippingsales))
				@foreach($shippingsales as $shs)
					<tr>
						<td style="text-align: center;">{{$i}}</td>
						<td style="text-align: center;"><a href="{{route('Receipt', ['id' => $shs['id']])}}" class="uniqporder" id="uniqporder" data="{{$shs['id']}}">{{UtilityController::s_id($shs['id'])}}</a>
						</td>
						<td style="text-align: center;"><a href="{{route('merchantPopup', ['id' => $shs['merchant_id']])}}" class="uniqporder" id="uniqporder" data="{{$shs['merchant_id']}}">
						{{UtilityController::s_id($shs['merchant_id'])}}</a>
						</td>
						<td style="text-align: center;">{{UtilityController::s_id($shs['shipping_id'])}}</td>
						<td style="text-align: center;">{{$shs['shipping_company']}}</td>
						<td style="text-align: center;">{{$shs['payment_status']}}</td>
						<td style="text-align: center;">
						<?php
						$date=date_create($shs['created_at']);
						echo date_format($date,"Y-m-d h:i:s");
						?>
						</td>
						<td style="text-align: center;">
						<?php
						$date=date_create($shs['created_at']);
						echo date_format($date,"Y-m-d h:i:s");
						?>
						</td>
						<td style="text-align: center;">                                                       <?php
						$date=date_create($shs['created_at']);
						echo date_format($date,"Y-m-d h:i:s");
						?>
						</td>
					</tr>
					<?php $i++; ?>
				@endforeach
			@endif
		</tbody>
											</table>