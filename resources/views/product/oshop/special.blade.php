@if(!Auth::check())
	<div id='alert' class="cart-alert alert alert-warning" role="alert" style="border-color: red;">
	  <strong><h4><a href="{{ route('buyerreg') }}"><b style="color: red;">Please SignUp and Autolink to our merchants to view Special prices!</b></a></h4></strong>
	</div>
@endif
<!-- Test Comment -->
@if($autolink_status == 0)
	<div id='alert' class="cart-alert alert alert-warning" role="alert" style="border-color: red;">
	<strong><h4><a href="#">
		<b style="color: red;">
			@if($autolink_requested == 0)
				Please Autolink to this merchant to view Special prices!
			@else
				Please wait for merchant's Autolink approval!
			@endif
		</b></a></h4>
	</strong>
	</div>
@endif

<div class="col-sm-12" style="margin-bottom:20px">
	<div class="row">
		<h2 style="margin-left:7px;margin-bottom:0">Special Price</h2>
	</div>
</div>
{{-- Products --}}
<div class="row">
	<div class="col-sm-12">
	@if(!is_null($specialproducts))
	@foreach($specialproducts as $product)
		<div class="p-box col-sm-4 col-md-3" style="padding-right:2px; margin-bottom:30px">
			<div class="p-box-content">
				<div class="cat-img">
					@if(Auth::check())
						<a href="{{ route('productb2b', $product->id) }}">
						  <img class="img-responsive" alt="Missing"
							src="{{ asset('images/product') }}/{{ $product->id }}/{{ $product->photo_1 }}">
						</a>
					@else
						<a href="javascript:void(0)" data-toggle="modal" data-target="#loginModal" class="b2b_validation" role="button">
						  <img class="img-responsive" alt="Missing"
							src="{{ asset('images/product') }}/{{ $product->id }}/{{ $product->photo_1 }}">
						</a>
					@endif
				</div>
				<div class='product-info'>
					<div class="product-name col-sm-12 col-xs-12">
						<div class="row">
							<div class="col-sm-9 col-xs-9" style="padding-left: 0;">
							 <div data-tooltip="{{ucfirst($product->name)}}"
								class="mouseover producttitle">
								 <div class="gradientEllipsis inside" >
									@if(is_null($product->name) || $product->name == "")
										&nbsp;
									@else
									 {{ucfirst($product->name)}}
									 <div class="dimmer"></div>
									@endif
								 </div>
							 </div>
							</div>
							<div class="col-sm-3 col-xs-3">
								<div class="row">
									<span data='{{ $product->id }}'
										class="hide wholesale-price wholesale-price-{{ $product->id }}">
									</span>
								</div>
							</div>
						 </div>
					</div>
					@if(Auth::check())										
						@if($autolink_status == 1)
						<div class="tier-price col-sm-12 col-xs-12">
							@def $wholesales = \App\Models\ProductDealer::where('product_id', $product->id)->where('dealer_id', Auth::user()->id)->orderBy('special_funit','asc')->take(4)->get()
							@def $all_wholesales2 = \App\Models\ProductDealer::where('product_id', $product->id)->where('dealer_id', Auth::user()->id)->get()
							@if(isset($wholesales))
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
							</div>
							
						<br>
						<div>
							<a title="Price List" tabindex="0"  data-toggle="popover" data-trigger="focus" data-container="body" data-placement="top" type="button" data-html="true"  id="{{ $product->id }}">See full price list</a>
						</div>
						
						@endif
					@endif
					
						{{-- popover view --}}
						<div class="hide" id="price-{{ $product->id }}">
							@def $all_wholesales = \App\Models\ProductDealer::where('product_id', $product->id)->where('dealer_id', Auth::user()->id)->orderBy('special_funit','asc')->get()
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
															<input type="hidden" id="funit{{$counter}}-{{$product->id}}" value="{{ $wholesale->special_funit }}" />
															<input type="hidden" id="unit{{$counter}}-{{$product->id}}" value="100000000" />
															<input type="hidden" id="wprice{{$counter}}-{{$product->id}}" value="{{ $wholesale->special_price/100 }}" />													
														@else
															<span> {{ $wholesale->special_funit }} </span> -
															<span> {{ $wholesale->special_unit }} </span>
															<input type="hidden" id="funit{{$counter}}-{{$product->id}}" value="{{ $wholesale->special_funit }}" />
															<input type="hidden" id="unit{{$counter}}-{{$product->id}}" value="{{ $wholesale->special_unit }}" />
															<input type="hidden" id="wprice{{$counter}}-{{$product->id}}" value="{{ $wholesale->special_price/100 }}" />
														@endif
													</td>
													<td class='text-right'>
														<span> {{ $currency }} </span>
														<span> {{ number_format($wholesale->special_price/100,2) }} </span>
													</td>
												</tr>
												<?php $counter++; ?>
												@endforeach
												<input type="hidden" id="counter-{{$product->id}}" value="{{ $counter }}" />
												<input type="hidden" id="rprice-{{$product->id}}" value="{{ $product->retail_price }}" />
											</tbody>
										</table>
									</div>
								</div>
							@endif
						</div>
					@endif
				</div>
			</div>
		</div>
	@endforeach
	@endif
	</div>
</div>
