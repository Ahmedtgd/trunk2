@if(!Auth::check())
	<div id='alert' class="cart-alert alert alert-warning" role="alert" style="border-color: red;">
	  <strong><h4><a href="{{ route('buyerreg') }}"><b style="color: red;">Please SignUp and Autolink to our merchants to view B2B prices!</b></a></h4></strong>
	</div>
@endif
<!-- Test Comment -->
@if($isadmin == 0)
	@if($autolink_status == 0)
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
	@endif
@endif

<div class="col-sm-12 nomobile" style="margin-bottom:20px">
	<div class="row nomobile">
		<h2 style="margin-left:7px;margin-bottom:0">Business To Business</h2>
	</div>
</div>
{{-- Products --}}
<?php $page_b2b = 0; ?>
<?php $oproducts_b2b = 0; ?>
<div class="row">
	<div class="clearfix mobile"></div>
	<div class="col-sm-12">
		@if(isset($categoriesb2b))
		<?php $k=0; ?>
			@foreach($categoriesb2b as $category)
				<?php $products =  $b2bcategoriesp[$k];?>
				@if(sizeof($products)>0)
					@foreach($products as $product)
					@if($oproducts_b2b == 0) <div id="page_b2b{{$page_b2b}}" class="pages_b2b" @if($page_b2b > 0) style="display: none;" @endif> @endif
						<div class="p-box col-sm-4 col-md-3 col-xs-6" style="padding-right:2px; margin-bottom:30px">
							<div class="p-box-content">
								<div class="cat-img">
									@if(Auth::check())
										<a href="{{ route('productb2b', $product->id) }}">
										  <img class="img-responsive" alt="Missing"
											src="{{ asset('images/product') }}/{{ $product->id }}/thumb/{{ $product->thumb_photo }}">
										</a>
									@else
										<a href="javascript:void(0)" data-toggle="modal" data-target="#loginModal" class="b2b_validation" role="button">
										  <img class="img-responsive" alt="Missing"
											src="{{ asset('images/product') }}/{{ $product->id }}/thumb/{{ $product->thumb_photo }}">
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
										@if($autolink_status == 1|| $isadmin == 1)
										<div class="tier-price col-sm-12 col-xs-12">
											@def $wholesales = \App\Models\Wholesale::where('product_id', $product->sid)->orderBy('funit','asc')->take(4)->get()
											@def $all_wholesales2 = \App\Models\Wholesale::where('product_id', $product->sid)->get()
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
											@def $all_wholesales = \App\Models\Wholesale::where('product_id', $product->sid)->orderBy('funit','asc')->get()
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
																			<span> > {{ $wholesale->funit }} </span>
																			<input type="hidden" id="funit{{$counter}}-{{$product->id}}" value="{{ $wholesale->funit }}" />
																			<input type="hidden" id="unit{{$counter}}-{{$product->id}}" value="100000000" />
																			<input type="hidden" id="wprice{{$counter}}-{{$product->id}}" value="{{ $wholesale->price/100 }}" />													
																		@else
																			<span> {{ $wholesale->funit }} </span> -
																			<span> {{ $wholesale->unit }} </span>
																			<input type="hidden" id="funit{{$counter}}-{{$product->id}}" value="{{ $wholesale->funit }}" />
																			<input type="hidden" id="unit{{$counter}}-{{$product->id}}" value="{{ $wholesale->unit }}" />
																			<input type="hidden" id="wprice{{$counter}}-{{$product->id}}" value="{{ $wholesale->price/100 }}" />
																		@endif
																	</td>
																	<td class='text-right'>
																		<span> {{ $currency }} </span>
																		<span> {{ number_format($wholesale->price/100,2) }} </span>
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
					<?php $oproducts_b2b++; ?>
					@if($oproducts_b2b >=12 )
						<?php $oproducts_b2b = 0; ?>
						<?php $page_b2b++; ?>
						</div>
					@endif
					@endforeach
				@endif
				<?php $k++; ?>
			@endforeach
		@endif
 @if($oproducts_b2b > 0 )
		</div>
 @endif
 <div class="clearfix"> </div>
<center >
	@if($page_b2b > 0 )
		<ul class="pagination">
			<li><a href="javascript:void(0)" class="first_page_b2b fontsize nomobile"><<</a></li>
			<li><a href="javascript:void(0)" class="prev_page_b2b fontsize nomobile">< Prev</a></li>
			<li><a href="javascript:void(0)" class="prev_page_b2b fontsize mobile"><</a></li>
			<li><span  class="last_ellipsis_b2b fontsize" style="display: none;">...</span><li>
			@for($pp = 0; $pp <= $page_b2b; $pp++)
				@if($pp > 5 && $pp == $page_b2b)
					<li><span  class="ellipsis_b2b fontsize">...</span><li>
				@endif
					<li><a href="javascript:void(0)" id="apage_b2b{{ $pp }}" rel="{{$pp}}" class="fontsize apage_b2b @if($pp == 0) selecteda @endif" @if($pp >= 5 && $pp != $page_b2b ) style="display: none;" @endif>{{$pp + 1}}</a></li>						
			@endfor
			<li><a href="javascript:void(0)" class="next_page_b2b fontsize nomobile"> Next ></a></li>
			<li><a href="javascript:void(0)" class="next_page_b2b fontsize mobile">></a></li>
			<li><a href="javascript:void(0)" class="last_page_b2b fontsize nomobile">>></a></li>
		</ul>

		<input type="hidden" value="{{$page_b2b}}" id="page_count_b2b" />
		<input type="hidden" value="0" id="current_page_b2b" />
	@endif	
</center>	
	</div>
</div>
