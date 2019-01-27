<?php
	
	use App\Http\Controllers\IdController;
	/* Squidster: Tue Apr 11 12:57:38 MYT 2017
	 * Temporary fix! */
?>

<div
	style="padding-left:0;padding-right:0"
	class=" col-sm-12">
		<?php 
			if(!is_null($productb2b)){
				$qrb2b = DB::table('productqr')->join('qr_management','qr_management.id','=','productqr.qr_management_id')
				->where('product_id',$productb2b->id)->orderBy('productqr.id','DESC')->first();
			} else {
				$qrb2b = null;
			}
		?>	
	<div id="pinformation"
		style="margin-left:0;margin-right:0"
		class="row">
		<div
			style="padding-left:0"
			class="col-sm-5 col-xs-9 nomobile"><h1 class="mh1">Product Information</h1></div>
			<div class="col-sm-6 nomobile">
				@if(!is_null($productb2b))
					<input type="hidden" id="product_b2b_id" value="{{$productb2b->id}}">
					<?php $formatted_merchant_id_b2b = IdController::nP($productb2b->id); ?>
					<div class="pull-right"><h4 class="formattedid"> Product ID: {{$formatted_merchant_id_b2b}}&nbsp;&nbsp;</h4>
					</div>
				@else
					&nbsp;
				@endif
			</div>
		<div class="col-sm-1 col-xs-3 nomobile"
			style="padding-left:0; padding-right:0">
			<p class="pull-right">
					@if($product['liked'] == 0)
						<li class="btn btn-lg btn-pink btn-like pull-right" >
							<a href="javascript:void(0)" id="r-like" rel="nofollow"
								class="product_like" style="color:white;"
								data-item-id="{{ $product['pro']->id }}" title="Remember&nbsp;the&nbsp;products&nbsp;that&nbsp;you like!&nbsp;It's&nbsp;stored&nbsp;in&nbsp;Buyer&nbsp;Dashboard, at the [Like] tab"> 
								<span class="likes_number">{{$product['likes']}}</span> Likes <i class="fa fa-heart"></i> 
							</a>
						</li>
					@else
						<li class="btn btn-lg btn-pink btn-like pull-right" style="color: rgb(255,0,128); border-color: rgb(255,0,128); background: rgb(255,255,255);">
							<a href="javascript:void(0)" id="r-like" rel="nofollow"
								class="product_like" style="color:rgb(255,0,128);"
								data-item-id="{{ $product['pro']->id }}" title="Remember&nbsp;the&nbsp;products&nbsp;that&nbsp;you like!&nbsp;It's&nbsp;stored&nbsp;in&nbsp;Buyer&nbsp;Dashboard, at the [Like] tab"> 
								<span class="likes_number">{{$product['likes']}}</span> Likes <i class="fa fa-heart"></i> 
							</a>
						</li>						
					@endif
			</p>
		</div>
	</div>
	<div id="pinformation" class="row mobile">
		<div class="col-xs-2 mobile">
			<div class="dropdown">
				<button type="button" style="border: solid 1px #0080FF; color: #fff;" class="menu-toggle" id="first-menu">
					<img src="{{asset('images/category/menu-blue.png')}}" width="22px">
				</button>
				<div class="dropdown-content">
					@if(!is_null($oshop_id) && $issingle == 0)
						<a  class="dropdown-content_a b2blink" href="{{route('oshop.one', ['url' => $oshop_url])}}" >O-Shop</a><br>
					@endif
					<a class="dropdown-content_a retaillink"  href="javascript:void(0);" >Retail</a><br>
					<a style="color: #0080FF;" href="javascript:void(0);" >B2B</a><br>
				</div>
			</div>
		</div>
		<div class="col-xs-10 mobile">
			<p class="pull-right">
			
				@if($product['liked'] == 0)
					<li class="btn btn-lg btn-pink btn-like pull-right likesmedia">
						<a href="javascript:void(0)" id="r-like" rel="nofollow"
							class="product_like" style="color:white;"
							data-item-id="{{ $product['pro']->id }}" title="Remember&nbsp;the&nbsp;products&nbsp;that&nbsp;you like!&nbsp;It's&nbsp;stored&nbsp;in&nbsp;Buyer&nbsp;Dashboard, at the [Like] tab"> 
							<span class="likes_number">{{$product['likes']}}</span> Likes <i class="fa fa-heart"></i> 
						</a>
					</li>
				@else
					<li class="btn btn-lg btn-pink btn-like pull-right likesmedia" style="color: rgb(255,0,128); border-color: rgb(255,0,128); background: rgb(255,255,255); margin-right: 15px;">
						<a href="javascript:void(0)" id="r-like" rel="nofollow"
							class="product_like" style="color:rgb(255,0,128);"
							data-item-id="{{ $product['pro']->id }}" title="Remember&nbsp;the&nbsp;products&nbsp;that&nbsp;you like!&nbsp;It's&nbsp;stored&nbsp;in&nbsp;Buyer&nbsp;Dashboard, at the [Like] tab"> 
							<span class="likes_number">{{$product['likes']}}</span> Likes <i class="fa fa-heart"></i> 
						</a>
					</li>						
				@endif
			</p>				
		</div>
		<div class="clearfix mobile"></div>
		<div class="col-xs-12 mobile">
			@if(!is_null($productb2b))
					<?php $formatted_merchant_id_b2b = IdController::nP($productb2b->id); ?>
					<p class="formattedid"> Product ID: {{$formatted_merchant_id_b2b}}</p>
			@else
					&nbsp;
			@endif
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
					<div style="width:100px" class="col-xs-4"><b>Name</b></div>
					<div class="col-xs-8"> 
						{{$product['pro']->name ? $product['pro']->name : "-" }}</div>
					<div style="width:100px" class="col-xs-4"><b>Brand</b></div>
					<div class="col-xs-8">
						{{$product['pro']->brand ? $product['pro']->brand->name : "-" }}</div>
					<div style="width:100px" class="col-xs-4"><b>Category</b></div>
					<div class="col-xs-8">
						{{$product['pro']->category ? $product['pro']->category->description : "-" }}
					</div>
					<div style="width:100px" class="col-xs-4"><b>Sub&nbsp;Category</b></div>
					<div class="col-xs-8">
						{{$product['subcat_level1'] ? htmlentities($product['subcat_level1']->description) : "-" }}</div>
					@if(isset($product['merchant'][0]))
					<div style="width:100px" class="col-xs-4"><b>O-Shop</b></div>
					<div class="col-xs-8">
						{{ $oshopname }}
					</div>@endif
					<div style="width:100px" class="col-xs-4"><b>Description</b></div>
					<?php
						/* Processed note */
						$pfullnote = null;
						$pnote = null;
						$link = false;
						if ($product['pro']->description) {
							$elipsis = "...";
							$elipsis = "...";
							$pfullnote = $product['pro']->description;
							$pnote = substr($pfullnote,0, MAX_COLUMN_TEXT);

							if (strlen($pfullnote) > MAX_COLUMN_TEXT){
								$pnote = $pnote . $elipsis .
								" <a href='javascript:void(0)' class='myModalProductDesc'>View More</a>";
								$link = true;
							}		
						}
					?> 							
					<div class="col-xs-8"><?php echo $pnote; ?></div>
					
					<div style="width:100px" class="col-xs-4"><b>Available</b></div>
					<div class="available col-xs-8" avail={{$product['pro']->available}}>
						@if(!is_null($productb2b))
							{{$productb2b->available?$productb2b->available:"0"}}
						@endif
					</div>
					</div>
					<input type="hidden" id="delivery_price2" value="first" />
					
						<div class="col-sm-3">
							
							@if($autolink_status == 1 || $immerchant == 1 || $isadmin == 1)
							@if(!is_null($productb2b))
							@def $amountdef = \App\Models\Wholesale::where('product_id', $productb2b->id)->orderBy('funit','asc')->first();
							@if(!is_null($amountdef))
							<input type="hidden" value="{{$productb2b->free_delivery_with_purchase_qty ? $productb2b->free_delivery_with_purchase_qty : '0'}}" id="free_delivery_with_purchase_qty2" />
							<input type="hidden" value="{{$productb2b->free_delivery ? $productb2b->free_delivery : '0'}}" id="free_delivery2" />
							<input type="hidden" value="{{ number_format($deliveryb2b,2) }}" id="mydelprice2" />
							<input type="hidden" value="{{ number_format($deliveryb2b,2) }}" id="mycart_delprice2" />
							<table class="table noborder">
								<tr>
									@def $amount = 0
									@def $delivery = $productb2b->del_west_malaysia ? $productb2b->del_west_malaysia / 100 : "0.0";

									@def $amount = \App\Models\Wholesale::where('product_id', $productb2b->id)->orderBy('funit','asc')->first()->price;
									<input type="hidden" value="{{ number_format($amount,2) }}" id="myprice2" />
									<th style="padding-bottom:0;">Amount</th>
									<td style="padding-bottom:0;">{{ $currency }}</td>
									<td style="padding-bottom:0;"><span class="amt2" amount={{ $amount/100 }}>{{ number_format($amount/100,2) }}</span></td>
								</tr>
								<tr>
								
									<th style="padding-bottom:0;">Delivery</th>
									<td style="padding-bottom:0;">{{ $currency }}</td>
									<td style="padding-bottom:0;" id='deliveryPrice2'><span class="del_price2">{{ number_format($deliveryb2b,2) }}</span></td>
								</tr>
								<tr>
									<td colspan="3"><hr>
									</td>
								</tr>
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
							</table>
						@endif
						@endif
						@endif
						
						<div class="col-sm-10 icons" style="padding-left:0; " >
						@if($autolink_status == 1 || $immerchant == 1 || $isadmin == 1)
							@if(!is_null($productb2b))
						   <div class="input-group" style="width:130px;margin-bottom:6px">
								<span class="input-group-btn">
									<button type="button" class="btn btn-green btn-number2" data-action="plus">
										<span class="glyphicon glyphicon-plus"></span>
									</button>
								</span>
								<input id='quantity2' style="text-align: center; padding-left: 0px; padding-right: 0px;"
									   type="text" name="quant[3]" class="ni numberInput form-control input-number quantity2"
									   value="1" min="1" max={{ $productb2b->available ? $productb2b->available : "0"}}>
								<span class="input-group-btn">
									<button type="button" class="btn btn-green btn-number2" data-action="minus">
										<span class="glyphicon glyphicon-minus"></span>
									</button>
								</span>
							</div>
								<ul class="list-inline">
									<li class="" style="border-radius: 6px;padding-left:0">
										{!! Form::open(array('url'=>'cart/addtocart', 'id'=>'cart')) !!}
											{!! Form::hidden('quantity2', 1) !!}
											{!! Form::hidden('id', $productb2b->id) !!}
											{!! Form::hidden('price', $amount) !!}								
											<button  class='btn-subcatn cartBtn2' type='submit' style='padding-right:2px;'><i class=""><img src="../../images/shopping_cart_button.png" alt="Add to Cart" style="width:40px;height:34px;"></i></button>
											{!! Form::close() !!}
										</li>
									</ul>
								@endif
							@endif
						</div>
						@if(!is_null($qrb2b) && !is_null($productb2b))
							<img src="{{URL::to('/')}}/images/qr/product/{{$productb2b->id}}/{{$qrb2b->image_path}}.png" class="pull-right pqrb2b"  width="120px" />
						@endif
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<hr>
				<div id="wholesale">
					<div style="padding-left:0" class="col-sm-12 nomobile">
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
						<tr style="border:0"><th>Retail Price</th>
						<td class ='retail_price' rprice='{{$amount}}'>
						<span class="<?php echo $strikethrough; ?>">
							{{$retail !=0 ? $currentCurrency . " ".number_format($retail,2) : "" }}
							</span>
						</td></tr>
						<input type="hidden" id="rprice" value="{{$retail}}" />
					</table>
					<div class="tier-price col-sm-12 col-xs-12">
						@if($autolink_status == 1 || $immerchant == 1 || $isadmin == 1)
							@if(isset($productb2b))
								@def $wholesales = \App\Models\Wholesale::where('product_id', $productb2b->id)->orderBy('funit','asc')->take(4)->get()
								@def $all_wholesales2 = \App\Models\Wholesale::where('product_id', $productb2b->id)->get()
							@endif
						@if(isset($wholesales))
						<div class="row">
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
					<div>
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
				</div>
				<div class="col-sm-4 nomobile">
					<h3>Delivery Coverage</h3>
					<table class="table dcoverage">
						<tr><th>Country</th><td>{{ $product['pro']->country ? $product['pro']->country->name : "-" }}</td></tr>
						<tr><th>State</th><td>{{ $product['pro']->state ? $product['pro']->state->name : "-" }}</td></tr>
						<tr><th>City</th><td>{{ $product['pro']->city ? $product['pro']->city->name : "-" }}</td></tr>
						<tr><th>Area</th><td>{{ $product['pro']->area ? $product['pro']->area->name : "-" }}</td></tr>
					</table>
				</div>
				<div class="col-sm-4 nomobile">
				<h3>Delivery Pricing</h3>
					@if(!is_null($productb2b))
						@if($productb2b->del_option == "own")
							<p><b>Delivery Price</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$currentCurrency}} {{number_format($deliveryb2b,2)}}&nbsp;&nbsp;&nbsp;&nbsp
								@if($productb2b->flat_delivery == 1)
									<b>[Flat Price]</b>
								@else
									<b>[Price Per Unit]</b>
								@endif
							</p>
						@else
							@if($product['pro']->del_option == "system")
								<p><b>Delivery Price</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$currentCurrency}} {{number_format($deliveryb2b,2)}}</p>
							@else
								<p><b>Pick up Only Product</b></p>
							@endif
						@endif
						@if($productb2b->free_delivery_with_purchase_qty > 0 && $productb2b->free_delivery == 0)
							<b>Free Delivery</b>&nbsp;&nbsp;&nbsp;&nbsp; Buy more than {{$currentCurrency}} {{number_format($productb2b->free_delivery_with_purchase_qty/100,2,'.',',')}}
						@endif
					@else
						<p style="color: red;">Not available</p>
					@endif
				</div>

			<div class="clearfix"></div>
			<hr>
			<div id="product">
				<div style="padding-left:0" class="col-xs-12">
					<h1 class="nomobile">Product Details</h1>
					<h3 class="mobile"> Product Details</h3>
				</div>
				<div class="col-xs-12" style="min-height: 20px;">
					@if(isset($productb2b))
						{!! $productb2b->product_details ? $productb2b->product_details : "-" !!}
					@endif
				</div>
			</div>
			<div class="clearfix"></div>
			<hr class="nomobile">
			@if(!is_null($product['specificationsb2b']))
				<div id="pspecification nomobile">
					<div style="padding-left:0" class="col-xs-12 nomobile">
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
			@if(!is_null($productb2b))
				<div id="pspecification" class="nomobile">
					<div style="padding-left:0" class="col-xs-12">
						<h1>Specifications</h1>
						<div style="padding-left:0" class="col-xs-12">
							<div class="form-group">
								
								<label for="product_specification_2" class="col-sm-2 control-label">(LxWxH)</label>
								<div class="col-sm-4">
									<p>{{$productb2b->length}}x{{$productb2b->width}}x{{$productb2b->height}} cm</p>
								</div>
								<div class="clearfix"></div>
								<label for="product_specification_2" class="col-sm-2 control-label">Weight</label>
								<div class="col-sm-4">
									<p>{{$productb2b->weight}} kg</p>
								</div>
								<div class="clearfix"></div>
								<label for="product_specification_2" class="col-sm-2 control-label">Delivery&nbsp;Time</label>
								<div class="col-sm-4">
									<p>{{$productb2b->delivery_time}} to {{$productb2b->delivery_time_to}} working days</p>
								</div>
								<div class="clearfix"></div>						
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			@endif
	</div>
<?php if($link){?>
<div class="modal fade" id="myModalb2b" role="dialog" aria-labelledby="myModalLabel">
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
		$(document).delegate( '#product_descb2b', "click",function (event) {
			$('#myModalb2b').modal('show'); 
		});
	});
</script>	
<script type="text/javascript">
	var gotin = 0;
	$(document).ready(function(){
	        function number_format2(number, decimals, dec_point, thousands_sep)
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
			url=JS_BASE_URL+'/cart/addtocart';	
			$('.cartBtn2').click(function (e) {
				e.preventDefault();
				console.log("pass");
				var price = 0;
				var amount = 0;
				/*retail_price = parseFloat($('.retail_price').attr('rprice'));*/
				var counter = $("#counter").val();
				var qty = $(".quantity2").val();
				var delivery_price = $("#mycart_delprice2").val();
				for (var i = 1; i <= parseInt(counter); i++) {
					var funit = $("#funit" + i).val();
					var unit = $("#unit" + i).val();
					//var price = $("#wprice" + i).val();
					if(parseInt(qty) >= parseInt(funit) && parseInt(qty) <= parseInt(unit)){
						//console.log(amount);
						price = $("#wprice" + i).val();
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
						'quantity': $(".quantity2").val(),
						'delivery_price': delivery_price * 100,
						'id': $(this).siblings('input[name=id]').val(),
						'price': parseFloat(price) * 100,
						'page': 'b2b'
					},
					success: function (data) {
								/*$('#retail_add_to_cart').css('background-color', 'grey');
								$('#retail_add_to_cart').css('cursor', 'no-drop');
								$('.cartBtn2').css('cursor', 'no-drop');
								$('.cartBtn2').attr('disabled', true);
								$('#discountLimitNotification').show();*/
								$('.alert').removeClass('hidden').fadeIn(3000).delay(5000).fadeOut(5000);
								$('.cart-info').text(data[1] + ' ' +
								number_format2(parseFloat(price) * 100 / 100, 2) + " Successfully added to the cart");

								if (data[0] < 1)
								{
									$('.cart-link').text('Cart is empty');
									$('.badges').text('0');
									$('.badges').hide();
								}
								else {
									$('.cart-link').text('View Cart');
									$('.badges').text(data[0]);
									$('.badges').show();
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
		
	
		
	});
</script>
