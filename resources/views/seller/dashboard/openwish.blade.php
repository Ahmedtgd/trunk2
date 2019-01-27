<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Classes;

$is_hybrid=False;
if (Auth::user()->hasRole('sto')) {
	$is_hybrid=True;
}
?>          
<script type="text/javascript">
	        function number_format(number, decimals, dec_point, thousands_sep)
        {
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
		function addToCartow(product_id ,exta,owid){
		var code = "{{$currentCurrency}}";
		jQuery.ajax({
			type: "POST",
			url: "{{ url('buyer/openwishProduct')}}",
			data: { product_id:product_id , owid:owid},

			success: function(response){
				console.log(response);

				$('.cart-link').text('View Cart');
				$('.badge-cart').text('1');
				$('.alert').removeClass('hidden').fadeIn(3000).delay(5000).fadeOut(5000);
				$('.cart-info').text(response.product_name + ' ' +
				code + number_format(response.price , 2) +
				" Successfully added to the cart");
			}
		});
}

</script>                      
<div class=" col-sm-12 ">
   <h2>OpenWish</h2>
	<br>
	<table  class="table table-bordered" id="open_wish_table" width="100%">
		<thead>
		<tr class="bg-yellow" style="color:#303030">
			<th class="textCenter">No</th>
			<th class="textCenter">OpenWish&nbsp;ID</th>
			<th class="textCenter">Product&nbsp;ID</th>
			<th class="textCenter">Date&nbsp;Started</th>
		
			<th class="textRight">Balance</th>
			<th class="textCenter">Status</th>
			<th class="textCenter">Station&nbsp;Help</th>
			
			
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
						<?php
						$current_date = Carbon::now();
						$leftTime=UtilityController::getOpenWishLeftDuration($o->created_at);
						$created_at = \Carbon\Carbon::parse($o->created_at);
						$days_left = abs($current_date->day - $created_at->day + $o->duration)."d ";
						$hour_left = abs($current_date->hour - $created_at->hour)."h ";
						$minute_left = abs($current_date->minute - $created_at->minute)."m ";
						$help = abs($price / 100 - $o->pledged_amt / 100);
						?>
					<tr>
						<td class="textCenter">{{$i}}</td>
						

						<td class="owID" value={{$o->id}} rel="{{(!empty($o->id)) ? IdController::nOw($o->id) : null}}"><a class="owpDetails">{{(!empty($o->id)) ? IdController::nOw($o->id) : null}}</a></td>

						<td class=""><a target="_blank" href="{{ route('productconsumer', $o->product_id)}}"> {{IdController::nP($o->product_id)}}</a></td>
						<td class="textCenter ">
						<a href="javascript:void(0);" class="duedate"
						rel-time="{{$o->duration}} Days" rel-timeleft="{{$leftTime}}"
						>
						
						{{UtilityController::s_date($o->created_at)}}
						</a>
						</td>
				
						
						
						<td class="textRight">
						<a href="javascript:void(0);" class="balance" rel-price="{{$currency_code .' '.number_format(($price / 100) , 2,'.',',')}}" rel-bought="{{$currency_code .' '.number_format(($o->pledged_amt / 100) , 2,'.',',')}}"  >
						{{$currency_code .' '.number_format((($price-$o->pledged_amt) / 100) , 2,'.',',')}}</a>
						</td>
						<td class="textCenter">{{ucfirst($o->status)}}</td>
						
						<td class="textCenter">
							@if($o->status == "active")
								@if($is_hybrid)
								<a onclick="addToCartow({{$product_id}}{{','}}{{$help}} {{','}}{{$ow_id}})" class="btn btn-default " style="width: 150px; background-color: red;color: white;">Pay</a>
								@else
								<button  class="btn btn-disabled " style="width: 150px;" title=" Please apply station account for this function." disabled="disabled">Pay</button>
								@endif
							@endif
							{{--<a onclick="$(this).parent().parent().remove();" class="pull-right"><i class="glyphicon glyphicon-remove text-danger"></i></a>--}}
						</td>
					</tr>
						<?php $i++;?>
				@endforeach

			@endif
		</tbody>
	</table>
</div>
{{-- Modal --}}
<div id="owModal" class="modal fade" role="dialog">
<div class="modal-dialog">

<!-- Modal content-->
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
   
  </div>
  <div class="modal-body">
    <table class="table">
        <thead>
            <tr style="color: black; background-color: #d7e748;" id="owModalTHeader"></tr>
        </thead>
        <tbody>
            <tr id="owModalTBody"></tr>
        </tbody>
    </table>
  </div>
  <div class="modal-footer">
    <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
  </div>
</div>

</div>
</div>
{{-- Scripts --}}
<script type="text/javascript">
	$(document).ready(function(){
		$('.duedate').click(function(){
                $('#owModal').find('#owModalTHeader').empty();
                $('#owModal').find('#owModalTBody').empty();
                var time=$(this).attr('rel-time');
                var timeleft=$(this).attr('rel-timeleft');
                var header="<th>Time</th><th>Time Left</th>";
                var body="<td>"+time+"</td><td>"+timeleft+"</td>";
                $('#owModal').find('#owModalTHeader').append(header);
                $('#owModal').find('#owModalTBody').append(body);
                $('#owModal').modal('show');
            });
            $('.balance').click(function(){
                $('#owModal').find('#owModalTHeader').empty();
                $('#owModal').find('#owModalTBody').empty();
                var price=$(this).attr('rel-price');
                var bought=$(this).attr('rel-bought');
                var header="<th>Price</th><th>Bought</th>";
                var body="<td>"+price+"</td><td>"+bought+"</td>";
                $('#owModal').find('#owModalTHeader').append(header);
                $('#owModal').find('#owModalTBody').append(body);
                $('#owModal').modal('show');
            });
	});
</script>
