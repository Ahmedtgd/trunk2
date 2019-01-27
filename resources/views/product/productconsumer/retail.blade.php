<?php
	
	use App\Http\Controllers\SMMController;
	use App\Http\Controllers\IdController;
	$smmStatus=$product['pro']->smm_selected;
	$comm=SMMController::getCommission($product['pro']->id);
	// dump($comm);
?>
<style>
	.hidden{
		display: none;
	}
	.fa-spinner {
		font-size: 1em;
	}
	.table.noborder td {
		font-size: 10pt;
	}

	table {
		border-spacing: 0;
		border-collapse: inherit !important; 
	}	

	.btn-number2 {
		font-size: 14px;
	}	
	@media (min-width: 1200px){
		.add_cart_span{
			margin-left: 45px;
		}
	}
	@media (max-width: 1199px){
		.add_cart_span{
			margin-left: 25px;
		}
	}	
	@media (min-width: 1200px){
		.owish_span{
			margin-left: 45px;
		}
	}
	@media (max-width: 1199px){
		.owish_span{
			margin-left: 25px;
		}
	}		
	@media (min-width: 1200px){
		.smm_span{
			margin-left: 55px;
		}
	}
	@media (max-width: 1199px){
		.owish_span{
			smm_span-left: 35px;
		}
	}
	.cashback{
	       padding-top: 34px;
	}
	.cashbackinnerdiv{
    	font-size: 29px;
        font-weight: 800;
        font-family: sans-serif;
        text-align: center;
        border: 5px solid #d41660;
        border-radius: 23px;
		/* background: transparent; */
        background: #fff0f6;
        color:#d41660;
	}
</style>
<div class="row">
	<div class="col-sm-12">
	<div
		style="padding-left:0;padding-right:0"
		class=" col-sm-12">

		<input type="hidden" id="product_b2c_id" value="{{$product['pro']->id}}">
	<form class="form-horizontal" style="margin-bottom:0;margin-top:0">
		<div id="pinformation nomobile"
			style="margin-left:0;margin-right:0"
			class="row">
			<div style="padding-left:0"
				class="col-sm-5 col-xs-9 nomobile"><h1 class="mh1">Product Information</h1></div>
				<div class="col-sm-6 nomobile" style="vertical-align:middle" >
			
				<?php $formatted_merchant_id = IdController::nP($product['pro']->id); ?>
				<div class="pull-right "><h4 class="formattedid"> Product ID: {{$formatted_merchant_id}}&nbsp;&nbsp;</h4>
				</div>
			</div>

			<div class="col-sm-1 col-xs-3 nomobile" style="padding-left:0; padding-right:0">
				<p class="pull-right">
				
					@if($product['liked'] == 0)
						<li class="btn btn-lg btn-pink btn-like pull-right likesmedia" style="margin-right:0">
							<a href="javascript:void(0)" id="r-like" rel="nofollow"
								class="product_like" style="color:white;"
								data-item-id="{{ $product['pro']->id }}" title="Remember&nbsp;the&nbsp;products&nbsp;that&nbsp;you like!&nbsp;It's&nbsp;stored&nbsp;in&nbsp;Buyer&nbsp;Dashboard, at the [Like] tab"> 
								<span class="likes_number">{{$product['likes']}}</span> Likes <i class="fa fa-heart"></i> 
							</a>
						</li>
					@else
						<li class="btn btn-lg btn-pink btn-like pull-right likesmedia" style="color: rgb(255,0,128); border-color: rgb(255,0,128); background: rgb(255,255,255);margin-right:0">
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
						<a style="color: #0080FF;" href="javascript:void(0);" >Retail</a><br>
						@if(!is_null($productb2b) || $countsp > 0)
							<a class="dropdown-content_a b2blink"  href="javascript:void(0);" >B2B</a><br>
						@else
							<a style="color: #BBB;"  href="javascript:void(0);" >B2B</a><br>
						@endif
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
			<div class="col-xs-9 mobile">
				<p class="formattedid"> Product ID:</p>
				<p class="formattedid">  {{$formatted_merchant_id}}</p>
			</div>
			<div class="col-xs-3">
				<p class="pull-right">
						@if(Auth::check())
							@if($autolink_status == 0  && $immerchant != $merchant_id)
								@if($autolink_requested == 0)
									<button type="button"
										data-button="{{$merchant_id}}"
										class="btn btn-success btn-lg autoclass autolink_btn"
										id="autolink_btn"
										style="background:rgb(0,99,98);color:#fff;right:0;margin-top:10px; right: 0px; padding-bottom: 7px; padding-top: 7px;" title="Press to get B2B and Special pricing">
										<span><img height="27" width="27"
											src="/images/bike-chain.png">&nbsp;</span>
										AutoLink
									</button>
									<button type="button"
										data-button="{{$merchant_id}}"
										class="btn btn-success btn-lg autoclass cancel_autolink"
										id="cancel_autolink"
										style="background:#fff;color:rgb(0,99,98);right:0;margin-top:10px; right: 0px; padding-bottom: 7px; padding-top: 7px; display: none;" title="You have an outstanding AutoLink Request">
										<span><img height="27" width="27"
											src="/images/bike-chain-rev.png">&nbsp;</span>
										AutoLink
									</button>&nbsp;							
									&nbsp;
								@else
									<button type="button"
										data-button="{{$merchant_id}}"
										class="btn btn-success btn-lg autoclass cancel_autolink"
										id="cancel_autolink"
										style="background:#fff;color:rgb(0,99,98);right:0;margin-top:10px; right: 0px; padding-bottom: 7px; padding-top: 7px;" title="You have an outstanding AutoLink Request">
										<span><img height="27" width="27"
											src="/images/bike-chain-rev.png">&nbsp;</span>
										AutoLink
									</button>
									<button type="button"
										data-button="{{$merchant_id}}"
										class="btn btn-success btn-lg autoclass autolink_btn"
										id="autolink_btn"
										style="background:rgb(0,99,98);color:#fff;right:0;margin-top:10px; right: 0px; padding-bottom: 7px; padding-top: 7px; display: none;" title="Press to get B2B and Special pricing">
										<span><img height="27" width="27"
											src="/images/bike-chain.png">&nbsp;</span>
										AutoLink
									</button>						
									&nbsp;							
								@endif
								<input type="hidden" id="autolink_user_id" value="{{Auth::user()->id}}" />
								<input type="hidden" id="autolink_merchant_id" value="{{$merchant_id}}" />
							@else
								@if($immerchant == $merchant_id)
									<button type="button"
										disabled
										data-button="{{$merchant_id}}"
										class="btn btn-success btn-lg badge1 autolink_merchant"
										id="autolink_merchant"
										style="background:#fff;color:rgb(0,99,98);right:0;margin-top:4px; right: 0px; margin-top: 4px; padding-bottom: 7px; padding-top: 7px;"
										title="Warning: A merchant cannot AutoLink with yourself"
										@if($badge_num > 0)
											data-badge="{{$badge_num}}"
										@endif
										>
										<span><img height="27" width="27"
											src="/images/bike-chain.png">&nbsp;</span>
										AutoLink
									</button>&nbsp;								
								@else	
									<button type="button"
										data-button="{{$merchant_id}}"
										class="btn btn-success btn-lg autoclass cancel_autolink"
										id="cancel_autolink"
										style="background:#fff;color:rgb(0,99,98);right:0;margin-top:4px; right: 0px; margin-top: 4px; padding-bottom: 7px; padding-top: 7px;" title="You are Autolinked">
										<span><img height="27" width="27"
											src="/images/bike-chain-rev.png">&nbsp;</span>
										AutoLink
									</button>
									<button type="button"
										data-button="{{$merchant_id}}"
										class="btn btn-success btn-lg autoclass autolink_btn"
										id="autolink_btn"
										style="background:rgb(0,99,98);color:#fff;right:0;margin-top:4px; right: 0px; margin-top: 4px; padding-bottom: 7px; padding-top: 7px; display: none;" title="Press to get B2B and Special pricing">
										<span><img height="27" width="27"
											src="/images/bike-chain.png">&nbsp;</span>
										AutoLink
									</button>						
									&nbsp;	
									<input type="hidden" id="autolink_user_id" value="{{Auth::user()->id}}" />
									<input type="hidden" id="autolink_merchant_id" value="{{$merchant_id}}" />						
								@endif					
							@endif
							
						@else				
							<a href="javascript:void(0)" data-toggle="modal" data-target="#loginModal" class="autolink_validation" style="padding: 0px;">
								<button type="button"
									class="btn btn-success btn-lg autoclass autolink"
									id="autolink"
									style="background:rgb(0,99,98);color:#fff;right:0;margin-top:4px; right: 0px; margin-top: 4px; padding-bottom: 7px; padding-top: 7px;" title="Press to get B2B and Special pricing">
									<span><img height="27" width="27"
										src="/images/bike-chain.png">&nbsp;</span>
									AutoLink
								</button>&nbsp;
							</a>
						@endif
						</p>
			</div>
		</div>
		<div id="pinformation" class="row">
			<div style="padding-left:15px"
				class="col-sm-5">
			<div class="thumbnail">
				<img src="{{asset('/')}}images/product/{{$product['pro']->id}}/{{$product['pro']->photo_1}}"
					title="product-image"
					class="img-responsive">
			</div>
			</div>

			<div class="col-sm-4 col-xs-12" style='padding-right:0;padding-left:0'>
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
					@if (!empty($oshopname))
						{{ $oshopname }}
					@else
						&nbsp;&nbsp;
					@endif
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
								" <a href='javascript:void(0)' class='product_description_view'>View More</a>";
								$link = true;
							}		
						}
					?> 							
					<div class="col-xs-8"><?php echo $pnote; ?></div>
					
					<div style="width:100px" class="col-xs-4"><b>Available</b></div>
					<div class="available col-xs-8" avail={{$product['pro']->available}}>
						{{$product['pro']->available?$product['pro']->available:"0"}}
					</div>

					{{-- Only display cashback if we have a non-zero total of
					   merchant and platform casback --}}
					@if (($product['pro']->cashback +
						  $product['pro']->pcashback) > 0)
 					{{--
					Log::debug('$product["pro"]->cashback='.
						$product['pro']->cashback)
					Log::debug('$product["pro"]->pcashback='.
						$product['pro']->pcashback)
					--}}
					<div class="col-xs-12 cashback">
    					<div style="width:300px;height:100px;text-align:center"
							class="col-xs-8 col-xs-offset-1 cashbackinnerdiv">
							<div style="margin-top:24px">
    						Cashback {{$product['pro']->cashback +
							$product['pro']->pcashback}}%
							</div>
    					</div>
					</div>
					@endif
			</div>
					<div class="col-sm-3">
						<table class="table noborder">
							<input type="hidden" value="{{$product['pro']->free_delivery_with_purchase_amt ? $product['pro']->free_delivery_with_purchase_amt : '0'}}" id="free_delivery_with_purchase_qty" />
							<input type="hidden" value="{{$product['pro']->free_delivery ? $product['pro']->free_delivery : '0'}}" id="free_delivery" />
							<input type="hidden" value="{{ number_format($delivery,2) }}" id="mydelprice" />
							<input type="hidden" value="{{ number_format($delivery,2) }}" id="mycart_delprice" />
							<tr><th style="padding-bottom:0">Amount</th>
								<td style="padding-bottom:0">{{ $currency }}</td>
								@if(!empty($discount_detail))
								<td style="padding-bottom:0">
									<span class="amt"
									amount={{$discount_detail['discounted_price_dis']}}>
									{{$discount_detail['discounted_price_dis']}}</span>


								</td>
								@else
								<td style="padding-bottom:0">
									<span class="amt" amount={{ $amount }}>
									{{ number_format($amount,2) }}
									</span>
								</td>
								@endif
							</tr>
							<tr>
								<th style="padding-bottom:0">Delivery</th>
								<td style="padding-bottom:0">{{ $currency }}</td>
								<td style="padding-bottom:0">
								<span class="del_price">
								{{ number_format($delivery,2) }}
									</span>
								</td>
							</tr>
							<tr><td colspan="3"><hr></td></tr>
							<tr>
								<th style="padding-bottom:0;padding-top:0">Total</th>
								<td style="padding-bottom:0;padding-top:0">{{$currency}}</td>
								<td style="padding-bottom:0;padding-top:0">
									@if(!empty($discount_detail))
									<span class="total">
										{{ number_format($discount_detail['discounted_price_dis']+$delivery,2) }}
									</span>
									@else
									<span class="total">
										{{ number_format($amount+$delivery,2) }}
									</span>
									@endif

								</td>
							</tr>
							@if($showGST==1)
							<tr>
								<th style="padding-bottom:8;padding-top:0">(Incl. {{$gst_tax_rate}}% SST)</th>
								
							</tr>
							<tr>
							
							</tr>
							@endif
						</table><!-- Autolink validation was removed -->						
						<div class="col-sm-12 icons" style="padding-left:0;padding-right:0" >
					
							<div class="input-group" style="width:130px;margin-bottom:6px; @if(!empty($discount_detail)) display: none; @endif">
								<span class="input-group-btn">
									<button @if(!empty($discount_detail)) disabled="" @endif type="button" class="btn btn-green btn-number" data-action="plus">
											 <span class="glyphicon glyphicon-plus"></span>
									</button>
								</span>
								<input @if(!empty($discount_detail)) readonly="" @endif style="text-align: center; padding-left: 0px; padding-right: 0px;width:100%; "
										type="text" name="quant[2]" class="form-control input-number quantity"
										value="1" min="1" max={{ $product['pro']->available ? $product['pro']->available : "0"}}>
										<span class="input-group-btn">
									<button @if(!empty($discount_detail)) disabled="" @endif type="button" class="btn btn-green btn-number" data-action="minus">
											 <span class="glyphicon glyphicon-minus"></span>
									</button>
								</span>
							</div>
							@if($isadmin==1)	
								<div class="col-sm-12" style="padding-left:0;padding-right:0" >	
									<a href="{{route('albumtabbed', ['id' => $product['pro']->parent_id])}}" class="btn btn-info">Edit</a>
									@if(!is_null($qr))
									<img src="{{URL::to('/')}}/images/qr/product/{{$product['pro']->id}}/{{$qr->image_path}}.png" style="margin-top: -55px;margin-right:-15px" class="pull-right"  width="120px" />
								@endif
								</div>	
							@else
								@if(!is_null($qr))
									<img src="{{URL::to('/')}}/images/qr/product/{{$product['pro']->id}}/{{$qr->image_path}}.png" style="margin-top: -55px;margin-right:-15px" class="pull-right pqr"  width="120px" />
								@endif
							@endif								
									<div class="" id="retail_add_to_cart" style='border-radius: 6px;padding-left:0px;padding-right:0px; @if($discount_detail["item_in_cart"]) display: none; @endif'>
										{!! Form::open(array('url'=>'cart/addtocart', 'id'=>'cart')) !!}

										{!! Form::hidden('quantity', 1) !!}
										{!! Form::hidden('id', $product['pro']->id) !!}
										@if(!empty($discount_detail))
											{!! Form::hidden('price', $discount_detail["discounted_price_dis"] * 100) !!}
											<input type="hidden" id="cartpage" value="productconsumerdisc" />  
										@else
											{!! Form::hidden('price', $amount * 100) !!}
											<input type="hidden" id="cartpage" value="" /> 
										@endif
										<input type="hidden" id="delivery_price" value="first" />
										<input type="hidden" id="delivery_price2" value="first" />
									
										
										<button  class='btn-subcatn cartBtn add_to_cart btn-block btn text-right' title="Adds a product into your Shopping Cart"
										type='submit' style="font-size: 1.2em;background-color:#28A98A;color: white; text-align: left;" id="cart">
											<img src="{{asset('images/shopping_cart_button.png')}}" alt="Add to Cart" style="width:40px;height:34px;"> 
											<span class="add_cart_span" style="margin-top">Add Cart</span>
										</button>
										

										{!! Form::close() !!}

									</div>
									@if($button_status)
									<div class="" style="padding-right:0;padding-left:0px;@if(!empty($discount_detail)) display: none; @endif">
										<button type="button" id="r-owish" title="Post to your socialmedia on your OpenWishes" 
										class="btn-subcatn show_openwish_modal btn-block btn" 
										style="font-size: 1.2em;background-color:#D6E940;color: white; margin-top: 5px; border-radius: 6px;text-align: left;" 
										data-item-id="{{ $product['pro']->id }}" data-item-type="new">
											<img src="{{asset('images/openwish_button.png')}}" class="" alt="Open Wish" style="width:40px;height:34px;"> 
											<span class="owish_span" style="margin-top">OpenWish</span>
										</button> 
									</div>
									@endif
									<div class="" style="padding-right:0;padding-left: 0px;margin-left:0px!important; @if(!empty($discount_detail)) display: none; @endif">
									@if($smmStatus == true and $comm>0)
										<button type="button" title="Spread the word on socialmedia about great products!" 
									class="btn-subcatn blast-none btn-block btn" 
									style="font-size: 1.2em;background-color:#1498EA;color: white; margin-top: 5px; border-radius: 6px; text-align: left;"  
									data-pid="{{$product['pro']->id}}"  >
									<img src="{{asset('images/smm_button.png')}}" alt="SMM" style="width:40px;height:34px;"> 
									<span class="smm_span" style="margin-top">SMM</span>
										
									</button>
									@else

									<button type="button" title="This product is not available for SMM" 
									class="disabled btn-subcatn btn btn-block" disabled="disabled" 
									style="font-size: 1.2em;background-color:#1498EA;color: white; margin-top: 5px; border-radius: 6px;text-align: left;" >
									<img src="{{asset('images/smm_button.png')}}" alt="SMM" style="width:40px;height:34px;"> 
									<span class="smm_span" style="margin-top">SMM</span>
									</button>
									@endif
									</div>
									<div>
										<i class='fa  fa-spinner  hidden fa-spin ' id="bspin"></i>
									</div>
						</div>	
							<div class="clearfix"></div>
							@if(!isset($productb2b))	
								<div class="col-sm-12 nomobile" style="padding-left:0;padding-right:0;margin-top:10px" >	
										<p style="color:red;">This product is not available for B2B</p>

								</div>	
							@endif

								
						
						<div class="clearfix"></div>
					</div>
				</div>
				<hr>
				@if($retail==0)
					<div id='alert_rprice' class="cart-alert alert alert-warning" role="alert" style="border-color: red;">
						<strong><h4><a href="#">
							<b style="color: red;">
								This product is NOT available in RETAIL
							</b></a></h4>
						</strong>
					</div>					
				@else
					<div
						style="padding-left:0"
						class="col-sm-12" id="myretail">
						<h1 class="nomobile">Retail</h1>
					</div>

					<div style="padding-left:0" class="col-sm-4">

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
							<tr>
							<th style="width:90px;border:0">Retail Price</th>
								<td style="border:0"
								class ='retail_price' rprice='{{$amount}}'>
									<span class="<?php echo $strikethrough; ?>">
										{{$retail !=0 ? $currentCurrency . " ".number_format($retail,2) : "" }}
									</span>
									@if(!empty($discount_detail))
									<tr id="discounted" style="border:0;display: <?php echo $disvisible; ?>">
									<th style="border:0">Discounted Price</th>
									<td style="border:0">
									<span>
										{{$discount_detail['discount_detail'] != null ? $currentCurrency ." ".$discount_detail['discounted_price_dis'] : "" }}<br>
									</span>
									<strong class="text-danger">
										{{ $discount_detail['discount_percentage_dis'] > 0 ? 'Save '.$discount_detail["discount_percentage_dis"].'%' : "" }}
									</strong>
									</td>
									</tr>
									<tr>
										<th>(Incl. SST)</th>
									</tr>
									@else
									<tr id="discounted" style="display:
									<?php echo $disvisible; ?>">
									<th style="border:0">Discounted Price<br>
									(Incl. SST)</th>
									<td style="border:0">
									<span>
										{{$original != 0 ? $currentCurrency . " " . number_format($original,2) : "" }}<br>
									</span>
									<strong class="text-danger">
										{{ $save > 0 ? 'Save '.number_format($save,2).'%' : "" }}
									</strong>
								</td>
							</tr>
							
							@endif
							</td></tr>
						</table>

						</div>
						<div class="col-sm-4 nomobile">
							<h3>Delivery Coverage</h3>
							<table style="border:0"  class="table dcoverage">
								<tr><th>Country</th><td>
								{{ $product['pro']->country ? $product['pro']->country->name : "-" }}</td></tr>
								<tr><th>State</th><td>
								{{ $product['pro']->state ? $product['pro']->state->name : "-" }}</td></tr>
								<tr><th>City</th><td>
								{{ $product['pro']->city ? $product['pro']->city->name : "-" }}</td></tr>
								<tr><th>Area</th><td>
								{{ $product['pro']->area ? $product['pro']->area->name : "-" }}</td></tr>
							</table>
						</div>
						{{-- $p->trueDelivery() --}}

						<div class="col-sm-4 nomobile">
						<h3>Delivery Pricing</h3>
							@if($product['pro']->del_option == "own")
								<p><b>Delivery Price</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$currentCurrency}} {{number_format($delivery,2)}}&nbsp;&nbsp;&nbsp;&nbsp
									@if($product['pro']->flat_delivery == 1)
										<b>[Flat Price]</b>
									@else
										<b>[Price Per Unit]</b>
									@endif
								</p>
							@else
								@if($product['pro']->del_option == "system")
									<p><b>Delivery Price</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$currentCurrency}} {{number_format($delivery,2)}}</p>
								@else
									<p><b>Pick up Only Product</b></p>
								@endif
							@endif
							@if($product['pro']->free_delivery_with_purchase_qty > 0 && $product['pro']->free_delivery == 0)
								<b>Free Delivery</b>&nbsp;&nbsp;&nbsp;&nbsp; Buy more than {{$currentCurrency}} {{number_format($product['pro']->free_delivery_with_purchase_qty/100,2,'.',',')}}
							@endif
						</div>
						
						<div id="retailss" class="mobile">
						  <!-- Nav tabs -->
						  <ul class="nav nav-tabs" role="tablist" >
							<li role="presentation" class="active"><a href="#specs" aria-controls="specs" role="tab" data-toggle="tab" style="color: #000; font-size:18px;margin-left:0;margin-right:0">Specifications</a></li>
							<li role="presentation"><a href="#delcov" aria-controls="delcov" role="tab" data-toggle="tab" style="color: #000; font-size:18px;margin-left:0;margin-right:0">Delivery Coverage</a></li>
						  </ul>
						  <div class="tab-content">
							<div role="tabpanel" class="tab-pane" id="delcov">
								<div class="col-sm-12" style="margin-bottom:20px">
									<div class="row">
										<h3>Delivery Coverage</h3>
										<table class="table">
											<tr><th>Country</th><td>{{ $product['pro']->country ? $product['pro']->country->name : "-" }}</td></tr>
											<tr><th>State</th><td>{{ $product['pro']->state ? $product['pro']->state->name : "-" }}</td></tr>
											<tr><th>City</th><td>{{ $product['pro']->city ? $product['pro']->city->name : "-" }}</td></tr>
											<tr><th>Area</th><td>{{ $product['pro']->area ? $product['pro']->area->name : "-" }}</td></tr>
										</table>
										@if($product['pro']->del_option == "own")
											<p><b>Delivery Pricing</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$currentCurrency}} {{number_format($delivery,2)}}</p>
										@else
											@if($product['pro']->del_option == "system")
												<p><b>Delivery Pricing</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$currentCurrency}} {{number_format($delivery,2)}}</p>
											@else
												<p><b>Pick up Only Product</b></p>
											@endif
										@endif
									</div>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane active" id="specs">
								<div class="col-sm-12" style="margin-bottom:20px">
									<div class="row">
										<h3>Specifications</h3>
									<div style="padding-left:0" class="col-xs-12">
										<div class="form-group">
											@if(!is_null($product['subcat_level2']))
											<label for="product_specification_2" class="col-sm-1 control-label">Product</label>
											<div class="col-sm-4">
												<p>{{$product['subcat_level2']->description}}</p>
											</div>
											<div class="clearfix"></div>
											@endif
											@if(!is_null($product['subcat_level3']))
											<label for="product_specification_2" class="col-sm-1 control-label">SubProduct</label>
											<div class="col-sm-4">
												<p>{{$product['subcat_level3']->description}}</p>
											</div>
											<div class="clearfix"></div>
											@endif
											<style>
												.wColorPicker-button {
													position: relative;
													border-radius: 5px;
													border: solid #CACACA 1px;
													padding: 1px;
													cursor: pointer;
													width: 75px !important;
													height: 25px !important;
													margin-top: -4px !important;
												}
												.wColorPicker-button-color {
													position: relative;
													border-radius: 5px;
													height: 20px !important;
												}
											</style>
											@if(!is_null($product['colors']))
												<label for="product_specification_2" class="col-sm-1 control-label">Colour</label>
												<?php $colors = $product['colors'];
													$cc=0;							
												?>
												@foreach($colors as $colordef)
													@if($cc > 0)
														<div class="col-sm-1 mt">
															&nbsp;
														</div>
													@endif
													<div class="col-sm-1 mt"
														style="margin-bottom: 5px;">
														<div class="wColorPicker-button">
															<div class="wColorPicker-button-color" style="background-color: {{$colordef->hex}}; height: 4px;"></div> 
														</div>
													</div>	
													<div class="col-sm-1 mt">
														<span style="float:left;">{{$colordef->description}}</span>
													</div>	
														
													<div class="clearfix"></div>
													<?php $cc++;?>
												@endforeach
												<div class="clearfix"></div>
											@endif
											
											<label for="product_specification_2" class="col-sm-1 control-label">(LxWxH)</label>
											<div class="col-sm-4">
												<p>{{$product['pro']->length}}x{{$product['pro']->width}}x{{$product['pro']->height}} cm</p>
											</div>
											<div class="clearfix"></div>
											<label for="product_specification_2" class="col-sm-1 control-label">Weight</label>
											<div class="col-sm-4">
												<p>{{$product['pro']->weight}} kg</p>
											</div>
											<div class="clearfix"></div>	
											<label for="product_specification_2" class="col-sm-1 control-label">Delivery Time</label>
											<div class="col-sm-4">
												<p>{{$product['pro']->delivery_time}} to {{$product['pro']->delivery_time_to}} working days</p>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>										
									</div>
								</div>
						   </div>
						</div>
						</div>

					@endif
		<div class="clearfix"></div>
		<hr>

		<div id="product">
			<div style="padding-left:0" class="col-xs-12">
				<h1 class="nomobile"> Product Details</h1>
				<h3 class="mobile"> Product Details</h3>
			</div>
			<div class="col-xs-12"
				style="padding-left:0; min-height: 20px;" id="product_description_summernote">
				{!! $product['pro']->product_details ? $product['pro']->product_details : "-" !!}
			</div>
		</div>
		<div class="clearfix"></div>
		<hr class="nomobile">
		<div id="pspecification" class="nomobile">
			<div style="padding-left:0" class="col-xs-12">
				<h1>Specifications</h1>
				<div style="padding-left:0" class="col-xs-12">
					<div class="form-group">
						@if(!is_null($product['subcat_level2']))
						<label for="product_specification_2" class="col-sm-2 control-label">Product</label>
						<div class="col-sm-4">
							<p>{{$product['subcat_level2']->description}}</p>
						</div>
						<div class="clearfix"></div>
						@endif
						@if(!is_null($product['subcat_level3']))
						<label for="product_specification_2" class="col-sm-2 control-label">SubProduct</label>
						<div class="col-sm-4">
							<p>{{$product['subcat_level3']->description}}</p>
						</div>
						<div class="clearfix"></div>
						@endif
						<style>
							.wColorPicker-button {
								position: relative;
								border-radius: 5px;
								border: solid #CACACA 1px;
								padding: 1px;
								cursor: pointer;
								width: 75px !important;
								height: 25px !important;
								margin-top: -4px !important;
							}
							.wColorPicker-button-color {
								position: relative;
								border-radius: 5px;
								height: 20px !important;
							}
						</style>
						@if(!is_null($product['colors']))
							<label for="product_specification_2" class="col-sm-2 control-label">Colour</label>
							<?php $colors = $product['colors'];
								$cc=0;							
							?>
							@foreach($colors as $colordef)
								@if($cc > 0)
									<div class="col-sm-1 mt">
										&nbsp;
									</div>
								@endif
								<div class="col-sm-1 mt"
									style="margin-bottom: 5px;">
									<div class="wColorPicker-button">
										<div class="wColorPicker-button-color" style="background-color: {{$colordef->hex}}; height: 4px;"></div> 
									</div>
								</div>	
								<div class="col-sm-1 mt">
									<span style="float:left;">{{$colordef->description}}</span>
								</div>	
									
								<div class="clearfix"></div>
								<?php $cc++;?>
							@endforeach
							<div class="clearfix"></div>
						@endif
						
						<label for="product_specification_2" class="col-sm-2 control-label">(LxWxH)</label>
						<div class="col-sm-4">
							<p>{{$product['pro']->length}}x{{$product['pro']->width}}x{{$product['pro']->height}} cm</p>
						</div>
						<div class="clearfix"></div>
						<label for="product_specification_2" class="col-sm-2 control-label">Weight</label>
						<div class="col-sm-4">
							<p>{{$product['pro']->weight}} kg</p>
						</div>
						<div class="clearfix"></div>
						<label for="product_specification_2" class="col-sm-2 control-label">Delivery&nbsp;Time</label>
						<div class="col-sm-4">
							<p>{{$product['pro']->delivery_time}} to {{$product['pro']->delivery_time_to}} working days</p>
						</div>
						<div class="clearfix"></div>						
					</div>
				</div>
			</div>

		</div>
		<div class="clearfix"></div>
		</div>
	</form>

</div>
</div>
		


<script>
	$(document).ready(function () {
		$(document).delegate( '.b2blink', "click",function (event) {
			$("#retailmob").hide();
			$("#b2bmob").show();
		});
		$(document).delegate( '.retaillink', "click",function (event) {
			$("#retailmob").show();
			$("#b2bmob").hide();
		});		
		$(document).delegate( '.product_description_view', "click",function (event) {
			console.log("VIEWWWW");
			$('#myModalProductDesc').modal('show'); 
		});
	});
</script>

