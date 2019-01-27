<?php
	define('MAX_COLUMN_TEXTSP', 95);
?>

<div
	style="padding-left:0;padding-right:0"
	class="col-sm-offset-1 col-sm-11">
	<div id="pinformation"
		style="margin-left:0;margin-right:0"
		class="row">
		<div
			style="padding-left:0"
			class="col-sm-6"><h1>Product Information</h1></div>
		<div class="col-sm-1 col-sm-offset-5"
			style="padding-left:0; padding-right:0">
			<p class="pull-right">
				<li class="btn btn-lg btn-pink">
					<a href="javascript:void(0)"  id="r-like" rel="nofollow"
						class="product_like" style="color:white;"
						data-item-id="{{ $product['pro']->id }}">
						Like <i class="fa fa-heart"></i>
					</a>
				</li>
			</p>
		</div>
	</div>
	<div id="pinformation" class="row">
			{{-- Form::Open() --}}
				<div id="pinformation">
					<div style="padding-left:15px"
						class="col-sm-5">
						<div class="thumbnail">
							<img src="{{asset('/')}}images/product/{{$product['pro']->id}}/{{$product['pro']->photo_1}}"
								title="product-image"
								class="img-responsive">
						</div>
					</div>
					<div class="col-sm-4" style='padding-right:0;padding-left:0'>
					<dl class="dl-horizontal text-muted">
						<dt style="width:100px">Name</dt>
						<dd>{{ $product['pro']->name ? $product['pro']->name : "-" }}</dd>
						<dt style="width:100px">Brand</dt>
						<dd>{{ $product['pro']->brand ? $product['pro']->brand->name : "-" }}</dd>
						<dt style="width:100px">Category</dt>
						<dd>{{ $product['pro']->category ? $product['pro']->category->description : "-" }}</dd>
						<dt style="width:100px">Sub Category</dt>
						<dd>{{ $product['subcat_level1'] ? htmlentities($product['subcat_level1']->description) : "-" }}</dd>
						@if(isset($product['merchant'][0]))
						<dt style="width:100px">O-Shop</dt>
						<dd>{{ $product['merchant'] ? $product['merchant'][0]->oshop_name : "" }}</dd>@endif
						<dt style="width:100px">Short<br>Description</dt>	
					
						<?php
							/* Processed note */
							$pfullnote = null;
							$pnote = null;
							$link = false;
							if ($product['pro']->description) {
								$elipsis = "...";
								$elipsis = "...";
								$pfullnote = $product['pro']->description;
								$pnote = substr($pfullnote,0, MAX_COLUMN_TEXTSP);

								if (strlen($pfullnote) > MAX_COLUMN_TEXTSP){
									$pnote = $pnote . $elipsis .
									" <a href='javascript:void(0)' id='product_descspecial'>View More</a>";
									$link = true;
								}		
							}
						?> 							
						<dd><?php echo $pnote; ?></dd>
						</dd>
						<dt style="width:100px">Available<dt>
						<dd class="available" avail={{$product['pro']->available}}>
							{{$product['pro']->available?$product['pro']->available:"0"}}
						</dd>
						</dl>
					</div>
						<div class="col-sm-3">
							<?php $countsp = 0; ?>
							@if(($autolink_status == 1 || $immerchant == 1))
							<?php $countsp = \App\Models\ProductDealer::where('product_id', $product['pro']->id)->where('dealer_id', Auth::user()->id)->orderBy('special_funit','asc')->count();?> 	
							@if($countsp > 0)
							<?php $firstvalue = \App\Models\ProductDealer::where('product_id', $product['pro']->id)->where('dealer_id', Auth::user()->id)->orderBy('special_funit','asc')->first();?> 
							<table class="table noborder">
								<tr>
									@def $amount = $firstvalue->special_price;
									@def $delivery = $product['pro']->del_west_malaysia ? $product['pro']->del_west_malaysia / 100 : "0.0";
									
									<th>Amount</th>
									<td>{{ $currency }}</td>
									@if(!empty($discount_detail))
									<td>{{$discount_detail['discounted_price_dis']}}</td>
									@else
									<td><span class="amt3" amount={{ $amount/100 }}>{{ number_format($amount/100,2) }}</span></td>
									@endif
								</tr>
								<tr>
								
									<th>Delivery</th>
									<td>{{ $currency }}</td>
									<td id='deliveryPrice3'><span class="delprice3">{{ number_format($p->trueDelivery($delivery),2) }}</span></td>
								</tr>
								<tr>
									<td colspan="3"><hr>
									</td>
								</tr>
								<tr>
									<th>&nbsp</th>
									<td>{{ $currency }}</td>
									<td id='hidden-total-price3' class='hidden'>
										{{ $amount + $p->trueDelivery($delivery) }}</td>
									<td id='total-price3'><span class="total3">{{ number_format(($amount/100) + $p->trueDelivery($delivery),2) }}</span></td>
								</tr>
							</table>
						@endif
						@endif
						<div class="col-sm-10 icons" style="padding-left:0; " >
						@if(($autolink_status == 1 || $immerchant == 1) && $countsp > 0)
						   <div class="input-group" style="width:130px; margin-bottom: 6px;">
								<span class="input-group-btn">
									<button type="button" class="up btn btn-info btn-number3" data-type="plus" data-field="quant[4]">
										<span class="glyphicon glyphicon-plus"></span>
									</button>
								</span>
								<input id='quantity3' style="text-align: center; padding-left: 0px; padding-right: 0px;"
									   type="text" name="quant[4]" class="ni numberInput form-control input-number quantity3"
									   value="1" min="1" max={{ $product['pro']->available ? $product['pro']->available - 1 : "0"}}>
								<span class="input-group-btn">
									<button type="button" class="down btn btn-info btn-number3"  data-type="minus" data-field="quant[4]">
										<span class="glyphicon glyphicon-minus"></span>
									</button>
								</span>
							</div>
								<ul class="list-inline">
									<li class="" style="border-radius: 6px;padding-left:0">
										{!! Form::open(array('url'=>'cart/addtocart', 'id'=>'cart')) !!}
										{!! Form::hidden('quantity', 1) !!}
										{!! Form::hidden('id', $product['pro']->id) !!}
										@if(!empty($discount_detail))
										{!! Form::hidden('price', $discount_detail["discounted_price_dis"]) !!}
										@else
										{!! Form::hidden('price', $amount) !!}
										@endif									
										<button  class='btn-subcatn cartBtn3' type='submit' style='padding-right:2px;'><i class=""><img src="../../images/shopping_cart_button.png" alt="Add to Cart" style="width:40px;height:34px;"></i></button>
										{!! Form::close() !!}
									</li>
								</ul>
							@endif
						</div>
						</div>
					</div>
					<input type="hidden" id="delivery_price3" value="first" />
					<div class="clearfix"></div>
				</div>
				<hr>
				<div id="wholesale">
					<div style="padding-left:0" class="col-sm-12">
						<h1>Business To Business</h1>
					</div>
					<div class="col-sm-4">
					<table class=" table" style="border: 0px;">
						<!--
						<tr><th>Retail Price</th>
						<td class ='retail_price' rprice='{{$retail}}'>
						<span class="rprice">{{$retail != 0 ? "MYR ".number_format($retail,2) : "" }}</span>
						<strong class="pull-right text-danger">{{ $save > 0 ? 'Save '.number_format($save,2).'%' : "" }}</strong> </td></tr>
						<tr><th>Original Price</th><td>
						<span class="strikethrough">{{$original !=0 ? "MYR ".number_format($original,2) : "" }}</span> </td></tr>
						<tr><th>Available</th><td>
						<span class="available" avail={{$product['pro']->available}}>{{ $product['pro']->available ? $product['pro']->available - 1 : "0"}}</span></td></tr>
						-->
						<tr><th>Retail Price</th>
						<td class ='retail_price' rprice='{{$amount}}'>
						<span class="<?php echo $strikethrough; ?>">
							{{$retail !=0 ? $currentCurrency . " ".number_format($retail,2) : "" }}
							</span>
						</td></tr>
						<input type="hidden" id="rprice" value="{{$retail}}" />
					</table>
					<div class="tier-price col-sm-12 col-xs-12">
						@if(($autolink_status == 1 || $immerchant == 1))
								@def $wholesales = \App\Models\ProductDealer::where('product_id', $product['pro']->id)->where('dealer_id', Auth::user()->id)->orderBy('special_funit','asc')->take(4)->get()
								@def $all_wholesales2 = \App\Models\ProductDealer::where('product_id', $product['pro']->id)->where('dealer_id', Auth::user()->id)->orderBy('special_funit','asc')->get()
						@if(isset($wholesales) && $countsp > 0)
						<div class="row">
							<div class="table-responsive" style="border:0px">
								<table class="priceTable table">
									<thead>
										<tr>
											<th class='text-left'>Business To Business</th>
											<th class='text-right'></th>
										</tr>
										<tr>
											<th class='text-left'>Tier</th>
											<th class='text-right'>Price/Unit</th>
										</tr>
									</thead>
									<tbody>
										@def $wholesalescount = count($wholesales)
										@def $all_wholesalescount = count($all_wholesales2)
										@def $counter = 1;
										@foreach($wholesales as $wholesale)
										<tr>
											<td class='text-left'>
												@if($wholesalescount == $all_wholesalescount && $counter == $all_wholesalescount)
													<span> > {{ $wholesale->special_funit }} </span>	
												@else 
													<span> {{ $wholesale->special_funit }} </span> -
													<span> {{ $wholesale->special_unit }} </span>
												@endif
											</td>
											<td class='text-right'>
												<span> {{ $currency }} </span>
												<span> {{ number_format($wholesale->special_price/100,2) }} </span>
											</td>
										</tr>
										<?php $counter++; ?>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
						@else
						<div class="row">
					        <div id='alert' class="cart-alert alert alert-warning" role="alert" style="border-color: red;">
					        <strong><h4><a href="#">
								<b style="color: red;">
									B2B prices are not available for this product
								</b></a></h4>
							</strong>
					        </div>
						</div>
						@endif
						@else
							<div class="row">
						        <div id='alert' class="cart-alert alert alert-warning" role="alert" style="border-color: red;">
						        <strong><h4><a href="#">
									<b style="color: red;">
										@if($autolink_requested == 0)
											Please Autolink to this merchant to view B2B prices!
										@else
											Please wait for merchant's Autolink approval!
										@endif
									</b></a></h4>
								</strong>
						        </div>
							</div>
						@endif
					</div>
					<br>
					<div>
						@if(($autolink_status == 1 || $immerchant == 1) && $countsp > 0) 
							<a title="Price List" tabindex="0"  data-toggle="popover" data-trigger="focus" data-container="body" data-placement="top" type="button" data-html="true"  id="abc">See full price list</a>
						@endif
					</div>
					{{-- popover view --}}
					<div class="hide" id="price-abc">
						@if(($autolink_status == 1 || $immerchant == 1) && $countsp > 0)
							@def $all_wholesales = \App\Models\ProductDealer::where('product_id', $product['pro']->id)->where('dealer_id', Auth::user()->id)->orderBy('special_funit','asc')->get()					
						@if(isset($all_wholesales))
							<div class="row">
								<div class="table-responsive" style="border:0px">
									<table class="priceTable table">
										<thead>
											<tr>
												<th class='text-left'>Tier</th>
												<th class='text-right'>Price/Unit</th>
											</tr>
										</thead>
										<tbody>
											@def $all_wholesalescounter = count($all_wholesales);
											@def $counter = 1;
											@foreach($all_wholesales as $wholesale)
											<tr>
												<td class='text-left'>
													@if($all_wholesalescounter == $counter)
														<span> > {{ $wholesale->special_funit }} </span>
														<input type="hidden" id="special_funit{{$counter}}" value="{{ $wholesale->special_funit }}" />
														<input type="hidden" id="special_unit{{$counter}}" value="100000000" />
														<input type="hidden" id="special_wprice{{$counter}}" value="{{ $wholesale->special_price/100 }}" />													
													@else
														<span> {{ $wholesale->special_funit }} </span> -
														<span> {{ $wholesale->special_unit }} </span>
														<input type="hidden" id="special_funit{{$counter}}" value="{{ $wholesale->special_funit }}" />
														<input type="hidden" id="special_unit{{$counter}}" value="{{ $wholesale->special_unit }}" />
														<input type="hidden" id="special_wprice{{$counter}}" value="{{ $wholesale->special_price/100 }}" />
													@endif
												</td>
												<td class='text-right'>
													<span> {{ $currency }} </span>
													<span> {{ number_format($wholesale->special_price/100,2) }} </span>
												</td>
											</tr>
											
											<?php $counter++; ?>
											@endforeach
											<input type="hidden" id="counter" value="{{ $counter }}" />
										</tbody>
									</table>
								</div>
							</div>
						@endif
						@endif
					</div>
					</div>
				</div>
				<div class="col-sm-4">
					<h3>Delivery Coverage</h3>
					<table class="table dcoverage">
						<tr><th>Country</th><td>{{ $product['pro']->country ? $product['pro']->country->name : "-" }}</td></tr>
						<tr><th>State</th><td>{{ $product['pro']->state ? $product['pro']->state->name : "-" }}</td></tr>
						<tr><th>City</th><td>{{ $product['pro']->city ? $product['pro']->city->name : "-" }}</td></tr>
						<tr><th>Area</th><td>{{ $product['pro']->area ? $product['pro']->area->name : "-" }}</td></tr>
					</table>
				</div>
				<div class="col-sm-4">
					<h3>Delivery Pricing</h3>
						@if($product['pro']->del_option == "own")
							<table class="table dpricing noborder">
								<tr class='price3' price={{$p->trueDelivery($product['pro']->del_worldwide/100)}} order="last">
								<th>World Wide</th>
								<td>{{ $product['pro']->del_worldwide ? $currentCurrency ' '.number_format($p->trueDelivery($product['pro']->del_worldwide)/100,2) : "0.0" }}</td>
								</tr>
								<tr class="active price3 addactive" price={{$p->trueDelivery($delivery)}} order="first">
								<th>West Malaysia</th><td>{{ $delivery == 0.0 ? $delivery : $currentCurrency  . ' '.number_format($p->trueDelivery($delivery),2) }}</td></tr>
								<tr order="second" class='price3' price={{$p->trueDelivery($product['pro']->del_sabah_labuan)/100}}><th>Sabah/Labuan</th><td>{{ $p->trueDelivery($product['pro']->del_sabah_labuan) ? $currentCurrency . ' '.number_format($p->trueDelivery($product['pro']->del_sabah_labuan/100),2) : "0.0" }}</td></tr>
								<tr order="third" class='price3' price={{ $p->trueDelivery($product['pro']->del_sarawak) /100}}><th>Sarawak</th><td>{{ $product['pro']->del_sarawak ? $currentCurrency . ' '.number_format($p->trueDelivery($product['pro']->del_sarawak)/100,2) : "0.0" }}</td></tr>
							</table>
						@else
							@if($product['pro']->del_option == "system")
								<p><b>Delivery Price</b>&nbsp;&nbsp;&nbsp;&nbsp;{{number_format($p->trueDelivery($delivery),2)}}</p>
							@else
								<p><b>Pick up Only Product</b></p>
							@endif
						@endif
				</div>

			<div class="clearfix"></div>
			<hr>

			<div id="product">
				<div style="padding-left:0" class="col-xs-12">
					<h1>Product Details</h1>
				</div>
				<div class="col-xs-12" style="min-height: 20px;">
					@if(isset($productb2b))
						{!! $productb2b->product_details ? $productb2b->product_details : "-" !!}
					@endif
				</div>
			</div>
			<div class="clearfix"></div>
			<hr>
			@if(!is_null($product['specificationsb2b']))
				<div id="pspecification">
					<div style="padding-left:0" class="col-xs-12">
						<h1>Specifications</h1>
						<div style="padding-left:0"
							class="col-xs-12 col-sm-offset-1">
							<div class="form-group">
								@foreach($product['specificationsb2b'] as $specs)
								<label for="product_specification_2"
								class="col-sm-3 control-label">{
									{$specs['description']}}</label>
								<div class="col-sm-4">
									<p>{{$specs['value']}}</p>
								</div>
								<div class="clearfix"></div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			@endif
	</div>
<?php if($link){?>
<div class="modal fade" id="myModalspecial" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 40%">
        <div class="modal-content" style='max-height: 500px;'>
            <div class="modal-body">
                <h3 id="modal-Tittle2">Product Description</h3>
                <div id="myBody2">
					{{$pfullnote}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>		
<?php }?>	
<script>
	$(document).ready(function () {
		$(document).delegate( '#product_descspecial', "click",function (event) {
			$('#myModalspecial').modal('show'); 
		});
	});
</script>	
<script type="text/javascript">
	$(document).ready(function(){
	        function number_format3(number, decimals, dec_point, thousands_sep)
			{
				number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
				var n = !isFinite(+number) ? 0 : +number,
						prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
						sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
						dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
						s = '',
						toFixedFix = function (n, prec) {
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
			path = window.location.href;
			var url;
			if (path.includes('public'))
			{
				url = '/openSupermall/public/cart/addtocart';
			}
			else {
				url = '/cart/addtocart';
			}		

			$('.cartBtn3').click(function (e) {
				e.preventDefault();
			//	console.log("pass");
				var price = 0;
				var amount = 0;
				/*retail_price = parseFloat($('.retail_price').attr('rprice'));*/
				var counter = $("#counter").val();
				
				for (var i = 1; i <= parseInt(counter); i++) {
					var funit = $("#special_funit" + i).val();
					var unit = $("#special_unit" + i).val();
					//var price = $("#wprice" + i).val();
					if(parseInt(qty) >= parseInt(funit) && parseInt(qty) <= parseInt(unit)){
						//console.log(amount);
						price = $("#special_wprice" + i).val();
					}	
				}				
				//var price = $(this).siblings('input[name=price]').val();
				if(price == 0){
					price = $("#rprice").val();
				}
				$.ajax({
					url: url,
					type: "post",
					data: {
						'quantity': $(".quantity3").val(),
						'delivery_price': 0,
						'id': $(this).siblings('input[name=id]').val(),
						'price': price,
						'page': ''
					},
					success: function (data) {
						/*$('#retail_add_to_cart').css('background-color', 'grey');
						$('#retail_add_to_cart').css('cursor', 'no-drop');
						$('.cartBtn2').css('cursor', 'no-drop');
						$('.cartBtn2').attr('disabled', true);
						$('#discountLimitNotification').show();*/
						$('.alert').removeClass('hidden').fadeIn(3000).delay(5000).fadeOut(5000);
						$('.cart-info').text(data[1] + ' ' + currency+
							number_format2(price / 100, 2) +
							" Successfully added to the cart");

						if (data[0] < 1) {
							$('.cart-link').text('Cart is empty');
							$('.badge').text('0');
						} else {
							$('.cart-link').text('View Cart');
							$('.badge').text(data[0]);
						}
					}
				});
			});	

		$('[data-toggle="tooltip"]').tooltip();
		$("[data-toggle=popover]").popover({
			html: true,
			content: function() {
				id = $(this).attr('id');
				return $('#price-'+id).html();
			}
		});
		
		//plugin bootstrap minus and plus
		$('.btn-number3').click(function (e) {
			e.preventDefault();
			fieldName = $(this).attr('data-field');
			type = $(this).attr('data-type');
			var input = $("input[name='" + fieldName + "']");
			var currentVal = parseInt(input.val());
			
			if (!isNaN(currentVal)) {
				if (type == 'minus') {
					if (currentVal > input.attr('min')) {
						input.val(currentVal - 1).change();
					}
					if (parseInt(input.val()) == input.attr('min')) {

						$(this).attr('disabled', true);
					}

				} else if (type == 'plus') {

					if (currentVal < input.attr('max')) {
						input.val(currentVal + 1).change();
					}
					if (parseInt(input.val()) == input.attr('max')) {
						$(this).attr('disabled', true);
					}

				}
			} else {
				input.val(0);
			}
			
			qty = $('.quantity3').val();
			fre_qty = $('#free_delivery_with_purchase_qty').val();
			del_price = 0;
			fre_qty = parseInt(fre_qty);
			var amount = 0;
			/*retail_price = parseFloat($('.retail_price').attr('rprice'));*/
			var counter = $("#counter").val();
			
			for (var i = 1; i <= parseInt(counter); i++) {
				var funit = $("#special_funit" + i).val();
				var unit = $("#special_unit" + i).val();
				var price = $("#special_wprice" + i).val();
				if(parseInt(qty) >= parseInt(funit) && parseInt(qty) <= parseInt(unit)){
					//console.log(amount);
					amount = parseFloat(price * qty).toFixed(2);
				}	
			}		 
			$('.amt3').html(accounting.formatMoney(amount,""));
				if(fre_qty==0){
					price = $('.delprice3').html();
				} else {
					if(qty < fre_qty){
						$('.delprice3').html(del_price);
						price = $('.delprice3').html();
					} else {
						price = "0.0";
						$('.delprice3').html("0.00");
					}
				}
				total = (parseFloat(amount)+parseFloat(price)).toFixed(2);
				//console.log(total);
				$('.total3').html(accounting.formatMoney(total,""));			
			});		
	});
</script>
