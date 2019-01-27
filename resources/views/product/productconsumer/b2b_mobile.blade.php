<?php 
use App\Http\Controllers\IdController;
?>
<div class="container mobile p_b2b p_mobile_view" style="display: none;">
@if(!is_null($productb2b))
<div class="row">
	<div class="col-xs-12" style="">
		<img src="{{asset('/')}}images/product/{{$product['pro']->id}}/{{$product['pro']->photo_1}}"
					title="product-image"
					class="img-responsive" style="margin-bottom: 5px;">
		{{-- AutoLink Button --}}
	
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<h2>{{$product['pro']->name ? $product['pro']->name : "-" }}</h2>
	</div>
</div>
<div class="row" style="font-size: 1.2em;font-weight: bold;">
	<div class="col-xs-6 pull-left">
		<span>Business To Business</span>
	</div>
	<div class="tier-price col-sm-12 col-xs-12">
		@if($autolink_status == 1 || $immerchant == 1 || $isadmin == 1)
			@if(isset($productb2b))
				@def $wholesales = \App\Models\Wholesale::where('product_id', $productb2b->id)->orderBy('funit','asc')->take(4)->get()
				@def $all_wholesales2 = \App\Models\Wholesale::where('product_id', $productb2b->id)->get()
			@endif
		@if(isset($wholesales))
			<div class="table-responsive" style="border:0px">
				<table class="priceTable table">
					<thead>
						@if(isset($product['pro']->special_funit) && isset($product['pro']->special_unit) && isset($product['pro']->special_price))
							<tr  style='color: #F54400'>
								<th class='text-left special_price_row'>
									{{-- <span> {{ $product['pro']->special_funit }} </span> -
									<span> {{ $product['pro']->special_unit }} </span> --}}
									Special Price
								</th>
								<th class='text-right special_price_row'>
									<span> {{ $currency }} </span>
									<span> {{ number_format($product['pro']->special_price/100,2) }} </span>
								</th>
							</tr>
						@endif
						<tr>
							<th class='text-left'>Wholesale Price</th>
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
									<span> > {{ $wholesale->funit }} </span>	
								@else 
									<span> {{ $wholesale->funit }} </span> -
									<span> {{ $wholesale->unit }} </span>
								@endif
							</td>
							<td class='text-right'>
								<span> {{ $currency }} </span>
								<span> {{ number_format($wholesale->price/100,2) }} </span>
							</td>
						</tr>
						<?php $counter++; ?>
						@endforeach
					</tbody>
				</table>
			</div>
		@else
		<div class="row">
			<div id='alert' class="cart-alert alert alert-warning" role="alert" style="border-color: red;">
			<strong><h4><a href="#">
				<b style="color: red;">
					  This product is not available for B2B
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
						@if(!isset($productb2b))
							This product is not available for B2B
						@else	
							@if($autolink_requested == 0)
								Please Autolink to this merchant to view B2B prices!
							@else
								Please wait for merchant's Autolink approval!
							@endif
						@endif
					</b></a></h4>
				</strong>
				</div>
			</div>
		@endif
	</div>
	<br>
	<div class='col-xs-12'>
		@if($autolink_status == 1 || $immerchant == 1 || $isadmin == 1)
			@if(isset($productb2b))
				<a title="Price List" tabindex="0"  data-toggle="popover" data-trigger="focus" data-container="body" data-placement="top" type="button" data-html="true"  id="{{ $product['pro']->id }}">See full price list</a>
			@endif
		@endif
	</div>
	{{-- popover view --}}
	<div class="hide" id="price-{{ $product['pro']->id }}">
		@if($autolink_status == 1 || $immerchant == 1 || $isadmin == 1)
		@if(isset($productb2b))
			@def $all_wholesales = \App\Models\Wholesale::where('product_id', $productb2b->id)->orderBy('funit','asc')->get()
		@endif							
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
							@if(isset($product['pro']->special_funit) && isset($product['pro']->special_unit) && isset($product['pro']->special_price))
								<tr  style='color: #F54400'>
									<td class='text-left'>
										<span> {{ $product['pro']->special_funit }} </span> -
										<span> {{ $product['pro']->special_unit }} </span>
									</td>
									<td class='text-right'>
										<span> {{ $currency }} </span>
										<span> {{ number_format($product['pro']->special_price/100,2) }} </span>
									</td>
								</tr>
							@endif
							@def $all_wholesalescounter = count($all_wholesales);
							@def $counter = 1;
							@foreach($all_wholesales as $wholesale)
							{{-- start: all data for calculation --}}
							<p  class=' price-info-{{ $product["pro"]->id }}'
								special-funit='{{ isset($product["pro"]->special_funit) ? $product["pro"]->special_funit : 0 }}'
								special-unit='{{ isset($product["pro"]->special_unit) ? $product["pro"]->special_unit : 0 }}'
								special-price='{{ isset($product["pro"]->special_price) ? $product["pro"]->special_price : 0 }}'
								from-unit='{{ $wholesale->funit }}'
								to-unit='{{ $wholesale->unit }}'
								price='{{ $wholesale->price }}'>
							</p>
							{{-- end --}}
							<tr>
								<td class='text-left'>
									@if($all_wholesalescounter == $counter)
										<span> > {{ $wholesale->funit }} </span>
										<input type="hidden" id="funit{{$counter}}" value="{{ $wholesale->funit }}" />
										<input type="hidden" id="unit{{$counter}}" value="100000000" />
										<input type="hidden" id="wprice{{$counter}}" value="{{ $wholesale->price/100 }}" />													
									@else
										<span> {{ $wholesale->funit }} </span> -
										<span> {{ $wholesale->unit }} </span>
										<input type="hidden" id="funit{{$counter}}" value="{{ $wholesale->funit }}" />
										<input type="hidden" id="unit{{$counter}}" value="{{ $wholesale->unit }}" />
										<input type="hidden" id="wprice{{$counter}}" value="{{ $wholesale->price/100 }}" />
									@endif
								</td>
								<td class='text-right'>
									<span> {{ $currency }} </span>
									<span> {{ number_format($wholesale->price/100,2) }} </span>
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
<div class="row" style="font-size: 1.2em;font-weight: bold;">
	<div class="col-xs-6 pull-left">
		<span>Available</span>
	</div>
	<div class="col-xs-6 pull-right">
		{{$productb2b->available?$productb2b->available:"0"}}
	</div>
</div>
{{-- SPACE FOR BOX --}}
<div class="row">
	<div class="col-xs-12">
	@if($autolink_status == 1 || $immerchant == 1 || $isadmin == 1)
	@def $amountdef = \App\Models\Wholesale::where('product_id', $productb2b->id)->orderBy('funit','asc')->first();
	@if(!is_null($amountdef))	
		<table class="table noborder">
		<input type="hidden" value="{{$productb2b->free_delivery_with_purchase_qty ? $productb2b->free_delivery_with_purchase_qty : '0'}}" id="free_delivery_with_purchase_qty2" />
		<input type="hidden" value="{{$productb2b->free_delivery ? $productb2b->free_delivery : '0'}}" id="free_delivery2" />
		<input type="hidden" value="{{ number_format($deliveryb2b,2) }}" id="mydelprice2" />
		<input type="hidden" value="{{ number_format($deliveryb2b,2) }}" id="mycart_delprice2" />
		@def $amount = 0
		@def $delivery = $productb2b->del_west_malaysia ? $productb2b->del_west_malaysia / 100 : "0.0";

		@def $amount = \App\Models\Wholesale::where('product_id', $productb2b->id)->orderBy('funit','asc')->first()->price;
		<tr><th style="padding-bottom:0">Amount</th>
			<td style="padding-bottom:0">{{ $currency }}</td>
			<td style="padding-bottom:0;"><span class="amt2" amount={{ $amount/100 }}>{{ number_format($amount/100,2) }}</span></td>
		</tr>
		<tr>
			<th style="padding-bottom:0">Delivery</th>
			<td style="padding-bottom:0">{{ $currency }}</td>
			<td style="padding-bottom:0">
			<span class="del_price2">
			{{ number_format($deliveryb2b,2) }}
				</span>
			</td>
		</tr>
		<tr><td colspan="3"><hr></td></tr>
		<tr>
			<th style="padding-bottom:0;padding-top:0">Total</th>
			<td style="padding-bottom:0;padding-top:0">{{ $currency }}</td>
			<td style="padding-bottom:0;padding-top:0" id='hidden-total-price' class='hidden'>
				{{ $amount + $deliveryb2b }}</td>
			<td style="padding-bottom:0;padding-top:0" id='total-price'><span class="total2">{{ number_format(($amount/100) +$deliveryb2b,2) }}</span></td>
		</tr>
		@if($showGST==1)
		<tr>
			<th style="padding-bottom:8;padding-top:0">(Incl. {{$gst_tax_rate}}% SST)</th>
			
		</tr>
		<tr>
		
		</tr>
		@endif
		
	</table><!-- AutoLink validation was removed -->	
	@endif
	@endif
	</div>
</div>
{{-- ENDS --}}
<div class="row">
	<div class="col-xs-12">
		<div class="input-group" style="margin-bottom:2px; @if(!empty($discount_detail)) display: none; @endif">
								<span class="input-group-btn">
									<button @if(!empty($discount_detail)) disabled="" @endif type="button" class="btn btn-green btn-number2" 
									data-action="plus" style="height: 50px;width: 75px;">
											 <span class="glyphicon glyphicon-plus"></span>
									</button>
								</span>
								<input @if(!empty($discount_detail)) readonly="" @endif style="text-align: center; padding-left: 0px; padding-right: 0px;width:100%; height: 50px;font-size: 2em;"
										type="text" name="quant[3]" class="form-control input-number quantity2"
										value="1" min="1" max={{ $productb2b->available ? $productb2b->available : "0"}}>
										<span class="input-group-btn">
									<button @if(!empty($discount_detail)) disabled="" @endif type="button" class="btn btn-green btn-number2 btn-lg" 
									data-action="minus" style="height: 50px;width: 75px;">
											 <span class="glyphicon glyphicon-minus"></span>
									</button>
								</span>
							</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		{!! Form::hidden('quantity', 1) !!}
										{!! Form::hidden('id', $productb2b->id) !!}
		<button  class='btn  btn-block cartBtn2' title="Adds a product into your Shopping Cart" type='submit'  style="font-size: 1.2em;background-color:#28A98A;color: white;">
			<img src="{{asset('images/shopping_cart_button.png')}}" alt="Add to Cart" style="width:50px;height:50px;">
		Add Cart</button>
		</form>
</div>
</div>
<hr>
{{-- Description --}}
<div class="row">
	<div class="col-xs-12">
		<h3>Product Description</h3>
	</div>
	<div class="col-xs-12">
		<table class="table table-striped">
		<tr>
			<th>
				Product&nbsp;ID
			</th>
			<td>
				{{IdController::nP($product['pro']->id)}}
			</td>
		</tr>
		<tr>
			<th>
				Name
			</th>
			<td>
				{{$product['pro']->name ? $product['pro']->name : "-" }}
			</td>
		</tr>
		<tr>
			<th>
				Brand
			</th>
			<td>
				{{$product['pro']->brand ? $product['pro']->brand->name : "-" }}
			</td>
		</tr>
		<tr>
			<th>
				Category
			</th>
			<td>
				{{$product['pro']->category ? $product['pro']->category->description : "-" }}
			</td>
		</tr>
		<tr>
			<th>
				Sub Category
			</th>
			<td>
				{{$product['subcat_level1'] ? htmlentities($product['subcat_level1']->description) : "-" }}
			</td>
		</tr>
		<tr>
			<th>
				O-Shop
			</th>
			<td>
				@if(!is_null($oshop_id) && $issingle == 0)
					<a href="{{route('oshop.one', ['url' => $oshop_url])}}" >{{ $oshopname }}</a>
				@else
					{{ $oshopname }}
				@endif
			</td>
		</tr>
		<tr>
			<th>
				Description
			</th>
			<td>
				{{$product['pro']->description}}
			</td>
		</tr>
		</table>
	</div>	
</div>
<hr>
<div class="row">
	<div class="col-xs-12">
		<h3>Product Details</h3>
	</div>
	<div class="col-xs-12"
		style=" min-height: 20px;" id="product_description_summernote">
		<iframe width="100%" style="border: none; min-height: 300px;" src="{{URL::to('/')}}/mobile/productdetails/{{$product['pro']->productdetail_id}}"></iframe>
	</div>	
</div>
@endif
</div>

<script type="text/javascript">
	$(document).ready(function(){
		
	});
</script>
