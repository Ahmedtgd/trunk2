@def $gst_tax_rate= \App\Models\Globals::first()->gst_rate

<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\IdController;
// dd($product['pro']);
define('MAX_COLUMN_TEXT', 95);
define('MAX_COLUMN_TEXTB2B', 95);
$countsp = 0;
$currency_c = \App\Models\Currency::where('active', 1)->first();
if(!is_null($currency_c)){
	$currency = $currency_c->code;
} else {
	$currency = $currentCurrency;
}
if (Auth::check()) {
	$countsp =
		\App\Models\ProductDealer::where('product_id', $product['pro']->id)->
			where('dealer_id', Auth::user()->id)->
			orderBy('special_funit','asc')->
			count();

}
?>
<?php 
	$qr = DB::table('productqr')->join('qr_management','qr_management.id','=','productqr.qr_management_id')
	->where('product_id',$product['pro']->id)->orderBy('productqr.id','DESC')->first();
?>
@extends("common.default")
@section('opengraph')
<meta property="og:title" content="{{$product['pro']->name}}" />
<meta property="og:image" content="{{asset('/images/product/'.$product['pro']->id)}}/{{$product['pro']->photo_1 }}" />
<meta property="og:description" content="Please click to buy! ...{{$product['pro']->description}}" />
<meta property="og:url" content="{{url('productconsumer',$product['pro']->id)}}" />
@stop
@section("content")
<style>
	iframe {
        width: 1px;
        min-width: 100%;
        *width: 100%;
    }

	.table>tbody>tr>td,
	.table>tbody>tr>th,
	.table>tfoot>tr>td,
	.table>tfoot>tr>th,
	.table>thead>tr>td,
	.table>thead>tr>th {
		padding: 8px;
		line-height: 1.42857143;
		vertical-align: top;
		border-top: 0px solid #ddd;
	}

	.dl-horizontal dd {
		margin-left: 120px;
	}

	.icons {
		margin-top: 0px !important;
	}

/*   .panel-heading .nav li a:focus {
        background-color: #1abc9c;
        color: #fff;
   }*/
  .panel-heading ul { background: #fff; }

	.nav-tabs > li > .autolink_validation:hover {
	  background-color: transparent;
	}

    .li_same_size {
        width: 37px;
        height: 37px;
    }

	.panel-heading {
		padding: 5px 0px;
		border-bottom: 1px solid transparent;
		border-top-left-radius: 3px;
		border-top-right-radius: 3px;
	}

	#oshop {
		margin-left: 0;
		/* display: inline-block; */
	}

.btn-pink {
    padding: 5px 5px;
    font-size: 18px;
    line-height: 1.3333333;
    border-radius: 6px;
}

.add_to_cart {
	border-radius: 6px;
}
	@media only screen and (min-width: 401px) {
		.likesmedia{
			margin-right: 15px;
		}
    .table-striped > tbody > tr > td {
    
        font-size:11px;
    }
	}
	@media only screen and (max-width: 400px) {
		.breadcrumb{
			display: none;
		}
		.pqr{
			margin-top:-100px;
		}
		.pqrb2b{
			margin-top:-85px;
		}
		.table-striped > tbody > tr > td {
        font-size:11px;
        }
		.likesmedia{
			margin-right: 0px;
			margin-top: 8px;
		}
	}
	
@media (min-width: 481px) and (max-width: 767px) {
   #product_description_summernote > p > img {
    	width:100% !important;
    }
  
}

@media (min-width: 320px) and (max-width: 480px) {
   #product_description_summernote > p > img {
    	width:100% !important;
    }
  
}
	
</style>

{{-- MOBILE --}}
<div class="modal fade" id="myModalProductDesc" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 40%">
	 <div class="modal-content" >
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Product Description</h4>
         </div>     
		<div class="modal-body">
			<div id="myBody2">
				{{$product['pro']->description}}
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>

     </div>
    </div>
</div>
{{--MOBILE ENDS  --}}
<div class="alert alert-success alert-dismissible hidden cart-notification" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong class='cart-info'></strong>
</div>
<div class="container hidden-xs"><!--Begin main cotainer-->
	<input type="hidden" value="{{$product['pro']->id}}" id="mycurrent_productid" />
	<input type="hidden" value="{{$del_option}}" id="del_type" />
	<input type="hidden" value="{{$del_b2b_option}}" id="del_type2" />

	<div class="row">
		<div class="col-sm-12">
		{!! Breadcrumbs::renderIfExists() !!}
			<div class="panel-heading nomobile" style="font-size: 18px;">
				 <!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
                    {{--Paul on 06 April 2017 at 6:30 OM--}}
					@if(!is_null($oshop_id) && $issingle == 0)
						<li role="presentation"><a style="color: #000; font-size:18px;margin-left: 0px; margin-top: 12px;padding-left: 10px; padding-right: 10px; margin-right: 0px;" id="oshop" href="{{route('oshop.one', ['url' => $oshop_url])}}" aria-controls="profile">O-Shop</a></li>
					@else
						<li role="presentation"></li>
					@endif
					<li role="presentation" id="retaila"><a style="color: #000; font-size:18px;margin-left: 0px; margin-top: 12px;padding-left: 15px; padding-right: 15px; margin-right: 0px;" href="#retail" aria-controls="home" role="tab" data-toggle="tab">Retail</a></li>
					<li role="presentation" id="b2ba">
						@if(!is_null($productb2b) || $countsp > 0)
							<a style="color: #000; font-size:18px;margin-left: 0px; margin-right: 0px; margin-top: 12px;padding-left: 20px; padding-right: 20px;" href="#b2b" aria-controls="profile" role="tab" data-toggle="tab">B2B
							</a>
						@else
							<p
								style="color: #666; font-size:18px;margin-left:0;margin-right:0;margin-top: 12px;padding-left: 20px; 	padding-right: 20px; padding-top: 10px; padding-botton: 10px;" title="No B2B Product defined" class="autoclass"
								href="javascript:void(0);">B2B
							</p>
						@endif
					</li>
				<!--	<li role="presentation" id="vouchera">
						@if(!true)
							<a style="color: #000; font-size:18px;margin-left: 0px; margin-right: 0px; margin-top: 12px; padding-left: 10px; padding-right: 10px;" href="#voucher" aria-controls="messages" role="tab" data-toggle="tab">Voucher</a>
						@else
							<p
								style="color: #666; font-size:18px;margin-left:0;margin-right:0;margin-top: 12px;padding-left: 20px; 	padding-right: 20px; padding-top: 10px; padding-botton: 10px;" title="No Voucher Product defined" class="autoclass"
								href="javascript:void(0);">Voucher
							</p>
						@endif	
					</li> -->
                        {{--Paul Modification Ends Here--}}
				
					<li role="presentation" id="hypera">
						@if(!is_null($hyper))
							<a style="color: #000; font-size:18px;margin-left:0px; margin-right: 0px;margin-top: 12px;" href="#hyper" aria-controls="settings" role="tab" data-toggle="tab">Hyper</a>
						@else
							<p
								style="color: #666; font-size:18px;margin-left:0;margin-right:0;margin-top: 12px;padding-left: 20px; 	padding-right: 20px; padding-top: 10px; padding-botton: 10px;" title="No Hyper Product defined" class="autoclass"
								href="javascript:void(0);">Hyper
							</p>
						@endif		
					</li>
					{{--
					<li role="presentation" id="smma">
						@if(!true)
							<a style="color: #000; font-size:18px;margin-left: 0px; margin-right: 0px;" href="#smm" aria-controls="settings" role="tab" data-toggle="tab">SMM</a>
						@else
							<p
								style="color: #666; font-size:18px;margin-left:0;margin-right:0;margin-top: 3px;padding-left: 20px; 	padding-right: 20px; padding-top: 10px; padding-botton: 10px;" title="No SMM Product defined" class="autoclass"
								href="javascript:void(0);">SMM
							</p>
						@endif							
					</li>
					--}}

					<li class="pull-right">
							<p class="pull-right">
						@if(Auth::check() && $canautolink)
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
										class="btn btn-success btn-lg autoclass cancel_autolink
										"
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
							@if($canautolink)						
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
						@endif
						</p>
					</li>						
				</ul>
			</div>
		</div>

								<input type="hidden" name="parent_id" value="{{$product['pro']->parent_id}}" id="product_parent_id">
	</div>
	<?php
	$amount = $product['pro']->discounted_price ? $product['pro']->discounted_price / 100 : 0;
	if ($amount == "0") {
		$amount = $product['pro']->retail_price ? $product['pro']->retail_price / 100 : 0;
	}
	$showGST=0;
	// $amount= $p->init($pid,'price')/100;
	$p= new PriceController;
	$gst=$p->init($pid,'gst')/100;
	$x= new PriceController;
	if($product['pro']->free_delivery == 1){
		$delivery=0;
	} else {
		$delivery=$delivery_pricec/100;
	}
	$deliveryb2b=0;
	$flatb2b=0;
	$productb2bid=0;
	if(!is_null($productb2b)){
		$flatb2b=$productb2b->flat_delivery;
		$productb2bid=$productb2b->id;
		if($productb2b->free_delivery == 1){
			$deliveryb2b=0;
		} else {
			$deliveryb2b=$delivery_pricecb2b/100;
		}
	}
	
	$y= new PriceController;
	$gstExists=$y->init($pid,'gstExists');
	if ($gstExists>0) {
		$showGST=1;
	}
	?>
	<input type="hidden" value="{{$product['pro']->flat_delivery}}" id="flat_del">
	<input type="hidden" value="{{$flatb2b}}" id="flat_del2">
	<input type="hidden" value="{{$delivery}}" id="init_del">
	<input type="hidden" value="{{$deliveryb2b}}" id="init_del2">
	<input type="hidden" value="{{$productb2bid}}" id="mycurrent_productid2" />
	<?php
	$strikethrough = "";
	$disvisible = "none;";
	$save = 0;
	$retail = ($product['pro']->retail_price) / 100;
	$original = ($product['pro']->discounted_price) / 100;
	if ($original < $retail && $original > 0) {
		$save = 100 * (($retail - $original ) / $retail);
		$disvisible = "visible;";
		$strikethrough = "strikethrough";
	}
	if (!empty($discount_detail)) {
		$save = 100 * (($retail - $original ) / $retail);
		$disvisible = "visible;";
		$strikethrough = "strikethrough";
	}
	?>
	<!-- Tab panes -->
	<div class="mobile">
		<div id="retailmob">
			@include('product.productconsumer.retail')
		</div>
		<div id="b2bmob" style="display: none;">
			@include('product.productconsumer.b2b')
		</div>
	</div>
	<div class="tab-content nomobile">
		<div role="tabpanel" class="tab-pane" id="retail">
			@include('product.productconsumer.retail')
		</div>

		<div role="tabpanel" class="tab-pane" id="b2b">
			@if($countsp > 0)
				@include('product.productconsumer.special')
			@else
				@include('product.productconsumer.b2b')
			@endif
			
		</div>
		<div role="tabpanel" class="tab-pane" id="special">
			
		</div>
		<div role="tabpanel" class="tab-pane" id="voucher">
			@include('product.productconsumer.voucher')
		</div>
		<div role="tabpanel" class="tab-pane" id="hyper">
			@include('product.productconsumer.hyper')
		</div>
		<div role="tabpanel" class="tab-pane" id="smm">
			@include('product.productconsumer.smm')
		</div>
		<div role="tabpanel" class="tab-pane" id="oem">
			@include('product.productconsumer.oem')
		</div>
	</div>
	<div class="clearfix"></div>
	<br><br>
	<div style="padding-left:0" class="col-sm-12">
			<div id="commentss">
			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs" role="tablist" style="background: #e7e7e7;" >
				<li role="presentation" class="active"><a href="#comments" aria-controls="comments" role="tab" data-toggle="tab" style="color: #000; font-size:18px;margin-left:0;margin-right:0">Comments</a></li>
				{{--
				<li role="presentation"><a href="#sellerinfo" aria-controls="sellerinfo" role="tab" data-toggle="tab" style="color: #000; font-size:18px;margin-left:0;margin-right:0">Seller Info</a></li>
				--}}
				<li role="presentation"><a href="#sellerpolicy" aria-controls="sellerpolicy" role="tab" data-toggle="tab" style="color: #000; font-size:18px;margin-left:0;margin-right:0">Seller Policy</a></li>
				{{--<li role="presentation"><a href="#osmallpolicy" aria-controls="osmallpolicy" role="tab" data-toggle="tab" style="color: #000; font-size:18px;margin-left:0;margin-right:0">OpenSupermall Policy</a></li>--}}
			  </ul>

			  <!-- Tab panes -->
			  <div class="tab-content">
                  {{--  Paul on 06 April 2017 for Comments Box at 9 PM--}}
				<div role="tabpanel" class="tab-pane active" id="comments">
					<div class="col-sm-12" style="margin-bottom:20px">
						<div class="row">
							<h2 style="margin-left:9px">Comments</h2>
							@if(isset($product['havorder']))
								@if($product['havorder'])
									<div class="col-sm-12">
										{{--<div class="col-sm-7">--}}
											@if(!is_null($product['current_user']->photo_1))
												<?php $img_pic = "images/users/" . $product['current_user']->user_id . "/" . $product['current_user']->photo_1; ?>
												<?php $isimg_pic = "1"; ?>
												{{--<div class="imagePreview" id="imagePreview1"--}}
													{{--style="height: 30px; width: 30px; float: left;--}}
													{{--background-size:cover;--}}
													{{--background-position: center top; vertical-align: center;--}}
													{{--background-image: url('{{asset($img_pic)}}');">--}}
												{{--</div>--}}
											@else
												<?php $img_pic = "#ddd"; ?>
												<?php $isimg_pic = "0"; ?>
												{{--<div class="imagePreview" id="imagePreview1"--}}
													{{--style="height: 30px; width: 30px; float: left;--}}
													{{--background-size:cover;--}}
													{{--background-position: center top;--}}
													{{--background-color: #ddd;">--}}
												{{--</div>--}}
											@endif

											{{--&nbsp;&nbsp;&nbsp;{{$product['current_user']->first_name}} {{$product['current_user']->last_name}}--}}
										{{--</div>--}}
										{{--<div class="col-sm-4">--}}
											{{--<p class="pull-right">{{UtilityController::s_datenh(date('Y-m-d H:i:s'))}}</p>--}}
										{{--</div>--}}
										{{--<div class="col-sm-1">--}}
											{{--&nbsp;--}}
										{{--</div>--}}
										{{--<div class="col-sm-11" style="margin-top:15px;">--}}
											{{--<textarea rows="3" style="width: 100%;" id="current_comment" placeholder="Please, comment here..."></textarea>--}}
										{{--</div>--}}
										{{--<div class="col-sm-1">--}}
											{{--&nbsp;--}}
										{{--</div>--}}
										<div class="col-sm-11" style="margin-top:15px;">
											{{--@if(Auth::check())--}}
												{{--@if(!Auth::user()->hasRole('adm'))--}}
													{{--<p align="right"><button type="button" id="add_comment" class="btn btn-primary">Comment</button></p>--}}
												{{--@endif--}}
											{{--@endif--}}
											<input type="hidden" value="{{$product['current_user']->user_id}}" id="current_userid" />
											<input type="hidden" value="{{$product['pro']->id}}" id="current_productid" />
											<input type="hidden" value="{{$img_pic}}" id="current_photo_1" />
											<input type="hidden" value="{{$isimg_pic}}" id="current_photois" />
											<input type="hidden" value="{{$product['current_user']->first_name}}" id="current_first_name" />
											<input type="hidden" value="{{$product['current_user']->last_name}}" id="current_last_name" />
											<input type="hidden" value="{{UtilityController::s_datenh(date('Y-m-d H:i:s'))}}" id="current_date" />
										</div>
										<div class="col-sm-1">
											&nbsp;
										</div>
									</div>
								@endif
							@endif
							<div class="col-sm-12" id="show_comments" style="border: solid #ddd 1px; margin-top:15px; padding-top: 15px;">
								<?php
									$comi = 0;
									$comic = 0;
									$cantcomments = 0;
								?>
								@if(isset($product['comments']))
									@foreach($product['comments'] as $comment)
										@if($comi == 0)
											<div
												id="block-{{$comic}}"
												@if($comic > 0)
													style="display: none;"
												@endif
											>
										@endif
										<div class="col-sm-7">
											@if(!is_null($comment->photo_1))
												<?php $img_pic = "images/users/" . $comment->user_id . "/" . $comment->photo_1; ?>
												<div class="imagePreview" id="imagePreview1"
													style="height: 30px; width: 30px; float: left;
													background-size:cover;
													background-position: center top; vertical-align: center;
													background-image: url('{{asset($img_pic)}}');">
												</div>
											@else
												<div class="imagePreview" id="imagePreview1"
													style="height: 30px; width: 30px; float: left;
													background-size:cover;
													background-position: center top;
													background-color: #ddd;">
												</div>
											@endif
											&nbsp;&nbsp;&nbsp;{{$comment->first_name}} {{$comment->last_name}}
										</div>
										<div class="col-sm-4">
											<p class="pull-right">{{UtilityController::s_datenh($comment->created_at)}}</p>
										</div>
										<div class="col-sm-1">
											&nbsp;
										</div>
										<div class="col-sm-11" style="border: solid #ddd 1px; padding: 15px; margin-top: 15px; margin-bottom: 15px;">
											&nbsp;&nbsp;&nbsp; {{$comment->comment}}
										</div>
										<div class="col-sm-1">
											&nbsp;
										</div>
										@if($comi == 4)
											</div>
											<?php $comi = 0; ?>
											<?php $comic++; ?>
										@else
											<?php $comi++; ?>
										@endif
										<?php $cantcomments++; ?>
									@endforeach
									@if($comi != 0)
										</div>
									@endif
									@if($comic > 0)
										<div class="col-sm-12">
											<a href="javascript:void(0)" class="more_comments">More Comments...</a>
											<input type="hidden" value="0" id="current_block" />
										</div>
									@endif
									@if($cantcomments == 0)
										<div class="col-sm-12">
											<p>No comments...</p>
										</div>
									@endif
								@endif
							</div>
						</div>
					</div>
				</div>
				
				<div role="tabpanel" class="tab-pane" id="sellerinfo">
					<div class="col-sm-12" style="margin-bottom:20px">
						<div class="row">
							<h2 style="margin-left:9px">Seller Information</h2>
							<div class="col-sm-6 col-xs-12 table-responsive">
								<table class="table pseller">
									<?php
										$citym = null;
										if(!is_null($product['merchant'][0]->address)){
											$citym = DB::table('city')->where('id',$product['merchant'][0]->address->city_id)->first();
										}				
									?>
									<tr><td>Seller Name</td><td>{{ $product['merchant'][0]->company_name }}</td></tr>
											<tr><td>Ship form Address</td><td>
											{{ $product['merchant'][0]->address ?
												strip_tags($product['merchant'][0]->address->line_1.'<br>'.
												$product['merchant'][0]->address->line_2.'<br>'.
												$product['merchant'][0]->address->line_3.'<br>'.
												$product['merchant'][0]->address->line_4.'<br>'.
												$product['merchant'][0]->address->postcode)
											:
												"-"
											}}
											@if(!is_null($citym))
												, {{strip_tags($citym->name)}}
											@endif												
										</td></tr>
									<tr><td>Return / Exchange Address:</td><td>
											{{ $product['merchant'][0]->address ?
												strip_tags($product['merchant'][0]->address->line_1.'<br>'.
												$product['merchant'][0]->address->line_2.'<br>'.
												$product['merchant'][0]->address->line_3.'<br>'.
												$product['merchant'][0]->address->line_4.'<br>'.
												$product['merchant'][0]->address->postcode)
											:
												"-"
											}}
											@if(!is_null($citym))
												, {{strip_tags($citym->name)}}
											@endif												
											</td></tr>
								</table>
							</div>							
						</div>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="sellerpolicy">
					<div class="col-sm-12" style="margin-bottom:20px">
						<div class="row">
							<h2 style="margin-left:9px">Seller Policy</h2>
							<div class="col-xs-12">
								{!! $product['merchant'] ? $product['merchant'][0]->return_policy : "" !!}
							</div>
						</div>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="osmallpolicy">
					<div class="col-sm-12" style="margin-bottom:20px">
						<div class="row">
							<h2 style="margin-left:9px">OpenSupermall Policy</h2>
								<div class="thumbnail">
									<div class="row">
										<div class="col-sm-12">
											<h3 class="page-header" style="margin-top:20px">Cancellation</h3>
											<ol>
												<li>Request for cancellation can be made after payment for the product is completed.</li>
												<li>Request for cancellation will only be approved if the product has not been shipped by the Merchant and the Buyer shall be entitled to refund</li>
												<li>Request for cancellation will be rejected in the event that the Merchant has shipped the product.</li>
											</ol>

										</div>
										<div class="col-sm-12">
											<h3 class="page-header" style="margin-top:20px">Return &amp; Exchange</h3>
											<ol>
												<li>Request for return of the product purchased can be upon the product is delivered.</li>
												<li>In the event that the product delivered is flawed, the Buyer shall return the product to the Merchant at the Buyer's own cost.</li>
												<li>Upon receiving the Merchant's confirmation on the approvalfor the request for return, payment shall than be refunded to the Buyer.</li>
												<li>In the event that wrong product is delivered, the Buyer may return the wrong product to Merchant at the Buyer's own cost and upon receiving the Merchant's confirmation and approval for the request, a new product shall be re-dilivered to the Buyer.</li>
											</ol>

										</div>
										<div class="col-sm-12">
											<h3 class="page-header" style="margin-top:20px">Terms &amp; Conditions</h3>

											<ol>
												<li>Request for return and/or refund shall be made within 7 days from the date of the delivery of the product</li>
												<li>The Buyer shall not be entitled to refund and/or exchange if:
													<ol type="a">
														<li>The product requested for refund and/or exchange is used, destroyed and/or damaged.</li>
														<li>The tag attached to the product is removed and/or tempered with.</li>
														<li>The seal and/or package of the product is removed and/or opened.</li>
														<li>The material(s) of the package product is lost.</li>
														<li>The components of the product including product's accessory and/or free gifts which comes with the products have been  used, destroyed, damaged and/or lost.</li>
														<li>The product value is decreased and/or damaged due to, including but not limited to, any reason stated in (a) to (c) stated above and/or due to the delay by the Buyer in returning the product.</li>
														<li>The product is custom made and/or is customized product.</li>
														<li>The proof of purchase of product is not provided by the Buyer.</li>
														<li>The Buyer failed to follow guidelines, manuals, instructions and/or recommendations provided by the products and/or the Vendor Merchant. </li>
														<li>The product is of e-voucher type of product which is sent to the Buyers email directly and immidiately. It is the buyer own responsibility to ensure the email address inserted and key is correct and accurate. OR</li>
														<li>The product is of credit top-up type of product including but not limited to prepaid mobile air time, prepaid internet services, prepaid online content which is sent to Buyer's account direclty and immidiately. It is Buyer's own responsibility to ensure the account number(such as mobile telephone number, prepaid internet account number) inserted the key in is correct and accurate.</li>
													</ol>
												</li>
												<li>All shipping cost and expenses paid are non-refundable and the Buyer shall bear for all the cost for the return and/or exchange of the product.</li>
												<li>In the event of any refund and/or return is approved it is subject to deduction of shipping costs, taxes and/or any changes impossed by the online payment gateway and/or financial instructions.</li>
											</ol>

										</div>
										

									</div>
								</div>							
						</div>
					</div>
				</div>
				</div>
			  </div>

			</div>	
	</div>
	@include('modals.smm')
	@include('modals.openwish')
@if(Session::has('smm_opengraph'))
<?php
$user=Session::get('smm_opengraph_user');
?>

<!-- Modal -->
<div id="smm_inform_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">SMM</h4>
      </div>
      <div class="modal-body">
        <div class="row">
        	<div class="col-sm-6">
        		<img src="{{asset('images/users/'.$user->id.'/'.$user->photo_1)}}" style="object-fit: contain;" width="100%" height="100%">
        	</div>
        	<div class="col-sm-6"><h3>{{$user->name}} recommends this fantastic product. Pay via OpenCredit points or by credit or debit cards.</h3></div>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		// $('#smm_inform_modal').modal('show');
	});
	
</script>
<?php
 // Session::forget('smm_opengraph');
 // Session::forget('smm_opengraph_user');
?>
@endif
	
@stop
@section('scripts')
<script type="text/javascript">
 $(document).ready(function(){
	 
	$('.autoclass').tooltip();
	$('.autolink_btn').on('click',function(){
		var autolink_user_id = $("#autolink_user_id").val();
		var autolink_merchant_id = $("#autolink_merchant_id").val();
		$.ajax({
			type: "post",
			url:  JS_BASE_URL + '/request_autolink',
			data: {autolink_user_id: autolink_user_id,autolink_merchant_id: autolink_merchant_id},
			cache: false,
			success: function (responseData, textStatus, jqXHR) {
				console.log(responseData);
				if(responseData.status == "success"){
					//$("#autolink_btn").attr('style','background:#fff;color:rgb(0,99,98);right:0;margin-top:4px; right: 0px; margin-top: 4px; padding-bottom: 7px; padding-top: 7px;');
					toastr.info("Please wait for Merchant AutoLink approval!");				
					$(".cancel_autolink").show();
					$(".autolink_btn").hide();					
				} else {
					toastr.info("There was an unexpected error, please, try again later");
				}
			
			},
			error: function (responseData, textStatus, errorThrown) {
				alert(errorThrown);
			}
		});
	});		

	$('.cancel_autolink').on('click',function(){
		var autolink_user_id = $("#autolink_user_id").val();
		var autolink_merchant_id = $("#autolink_merchant_id").val();
		$.ajax({
			type: "post",
			url:  JS_BASE_URL + '/cancel_autolink',
			data: {autolink_user_id: autolink_user_id,autolink_merchant_id: autolink_merchant_id},
			cache: false,
			success: function (responseData, textStatus, jqXHR) {
				console.log(responseData);
				if(responseData.status == "success"){
					toastr.info("Autolink successfully cancelled!");							
					$(".cancel_autolink").hide();
					$(".autolink_btn").show();
				} else {
					toastr.info("There was an unexpected error, please, try again later");
				}
			
			},
			error: function (responseData, textStatus, errorThrown) {
				alert(errorThrown);
			}
		});
	});			

	$('.autolink_merchant').on('click',function(){
		window.location.href = JS_BASE_URL + '/merchant/dashboard';
	});	 

	var pathname = window.location.pathname;
	var arrpath = pathname.split("/");
	if(arrpath[1]=="productconsumer"){
		$("#retaila").addClass("active");
		$("#retail").addClass("active");
	} else if(arrpath[1]=="productb2b"){
		$("#b2ba").addClass("active");
		$("#b2b").addClass("active");
	}

	$('#hypera').click(function(){
		$("#commentss").hide();
	});
	
	$('#smma').click(function(){
		$("#commentss").hide();
	});	
	
	$('#vouchera').click(function(){
		$("#commentss").show();
	});
	
	$('#retaila').click(function(){
		$("#commentss").show();
	});	
	
	$('#b2ba').click(function(){
		$("#commentss").show();
	});	
	
	
    $('#add_comment').click(function(){
		var current_userid = $("#current_userid").val();
		var current_comment = $("textarea#current_comment").val();
		var current_productid = $("#mycurrent_productid").val();
		console.log(current_comment);
        $.ajax({
			url: JS_BASE_URL + '/products/add_comment',
			type: 'POST',
			data: {	user_id: current_userid, 
					comment: current_comment, 
					product_id:current_productid
				},
			success:function(response){
				$("textarea#current_comment").val("");
				toastr.info("Thank you for your comment!");
				var current_date = $("#current_date").val();
				var current_first_name = $("#current_first_name").val();
				var current_last_name = $("#current_last_name").val();
				var current_photo_1 = $("#current_photo_1").val();
				var current_photois = $("#current_photois").val();
				if(current_photois == "0"){
					current_bg = 'background-color: #ddd';
				} else {
					current_bg = 'background-image: url(\''+JS_BASE_URL + '/' + current_photo_1 + '\');"';
				}
				$("#show_comments").prepend('<div class="col-sm-7"><div class="imagePreview" id="imagePreview1" style="height: 30px; width: 30px; float: left; background-size:cover; background-position: center top; vertical-align: center; '+current_bg+';"></div>	&nbsp;&nbsp;&nbsp;'+current_first_name+' '+current_last_name+'</div><div class="col-sm-4"><p class="pull-right">'+current_date+'</p></div><div class="col-sm-1">&nbsp;</div><div class="col-sm-11" style="border: solid #ddd 1px; padding: 15px; margin-top: 15px; margin-bottom: 15px;">&nbsp;&nbsp;&nbsp; '+current_comment+'</div><div class="col-sm-1">&nbsp;</div>');
			}
        });		
	});	
	
    $('.more_comments').click(function(){
		var block = parseInt($("#current_block").val());
		block++;
		$("#block-" + block).show();
		$("#current_block").val(block);
	});
	
    // $('#blast').click(function(){
    //     // alert(product_id);
    //     var dt=$(this);
    //     dt.children('i').removeClass('hidden');
    //     var product_id="{{$product['pro']->id}}";
    //     $.ajax({
    //             url: JS_BASE_URL + '/smedia/marketer',
    //             type: 'GET',
    //             data: {product_id: product_id},
    //             success:function(response){
    //                 if (response==-1) {
    //                  var newresponse= "You have not registered for SMM services. <br>Would you like to register now? <br><button type='button' id='smmyes' class='btn btn-success'>Yes</button> <button class='btn' id='smmno'>No </button>";
    //                         toastr.info(newresponse);
    //                         	$('#smmno').click(function(){
    //                         		dt.children('i').addClass('hidden');
    //                         		toastr.clear();
    //                         	});
    //                             $('#smmyes').click(function(){
    //                                 // alert("Yeyy you clocled");
    //                                 newwindow = window.open("{{URL::route('fbtoken')}}", 'Link Token', 'height=400,width=auto');
    //                                 if (window.focus) {
    //                                     newwindow.focus()
    //                                 }
    //                                 dt.children('i').addClass('hidden');
    //                                 return false;
    //                                 });

    //                 }
    //                 else{
    //                     toastr.info(response);
    //                     dt.children('i').addClass('hidden');
    //                 };

    //             }
    //     });
    // });
 });
</script>
@include('product.productconsumer.retail_mobile')
@include('product.productconsumer.b2b_mobile')
@include('product.productconsumer.hyper_mobile')
<script type="text/javascript">
function calculate_priceb2b(pid, qty,type, flat_del){
	if(type == "system"){
		var returnval = 0;
		$.ajax({
			type: "post",
			url:  JS_BASE_URL + '/product/get_delpricebyid',
			data: {pid: pid, qty: qty},
			cache: false,
			async: false,
			success: function (responseData, textStatus, jqXHR) {
				returnval = parseFloat(responseData);
			},
			error: function (responseData, textStatus, errorThrown) {
				//alert(errorThrown);
			}
		});	
	} else {
		var init_del = parseFloat($("#init_del2").val());
		if(parseInt(flat_del) == 1){
			var returnval = init_del;
		} else {
			var returnval = init_del * qty;
		}
	}
	return returnval;	
}
function calculate_price(pid, qty,type, flat_del){
	if(type == "system"){
		var returnval = 0;
		$.ajax({
			type: "post",
			url:  JS_BASE_URL + '/product/get_delpricebyid',
			data: {pid: pid, qty: qty},
			cache: false,
			async: false,
			success: function (responseData, textStatus, jqXHR) {
				returnval = parseFloat(responseData);
			},
			error: function (responseData, textStatus, errorThrown) {
				//alert(errorThrown);
			}
		});	
	} else {
		var init_del = parseFloat($("#init_del").val());
		if(parseInt(flat_del) == 1){
			var returnval = init_del;
		} else {
			var returnval = init_del * qty;
		}
	}
	return returnval;
}
var max = parseInt($('.quantity').attr("max"));
$(document).ready(function() {
	var del_price_init = parseFloat($('#mydelprice').val());
	$("#delivery_price").val(del_price_init);

$( ".btn-number" ).click(function() {
	qty = $('.quantity').val();
	
	var can = true;
	if($(this).attr("data-action") == "plus"){
		qty = parseInt(qty) + 1;
		if(qty >max){
			can = false;
		}
	} else {
		qty = parseInt(qty) - 1;
		if(qty <=0){
			can = false;
		}
	}
	if(can){
	var product_id=$('#product_b2c_id').val();
	var url="{{url('product/price')}}";
	$.ajax({
		type:'POST',
		url:url,
		data:{product_id:product_id,quantity:qty},
		success:function(r){
			if (r.status=="success") {
				// Update
				$('.quantity').val(qty);
				$('.amt').text(r.price);
				$('.del_price').text(r.delivery);
				$('.total').text(r.total);

			}else{
				toastr.warning(r.long_message);
			}
		},
		error:function(){
			toastr.warning('Cannot connect to server.Please try again.')
		}
	});



	 }
});


	var del_price_init2 = parseFloat($('#mydelprice2').val());
	$("#delivery_price2").val(del_price_init2);
	var max2 = parseInt($('.quantity2').attr("max"));
$( ".btn-number2" ).click(function() {
	qty = $('.quantity2').val();
	
	var can = true;
	if($(this).attr("data-action") == "plus"){
		qty = parseInt(qty) + 1;
		if(qty >max2){
			can = false;
		}
	} else {
		qty = parseInt(qty) - 1;
		if(qty <=0){
			can = false;
		}
	}
	if(can){
	var product_id=$('#product_b2b_id').val();
	var url="{{url('product/price/b2b')}}";
	$.ajax({
		type:'POST',
		url:url,
		data:{product_id:product_id,quantity:qty},
		success:function(r){
			if (r.status=="success") {
				// Update
				$('.quantity2').val(qty);
				$('.amt2').text(r.price);
				$('.del_price2').text(r.delivery);
				$('.total2').text(r.total);

			}else{
				toastr.warning(r.long_message);
			}
		},
		error:function(){
			toastr.warning('Cannot connect to server.Please try again.')
		}
	});



	 }
});


	$( ".price" ).on('click',function() {
		amount = ($('.amt').text());
		amount = (accounting.unformat(amount));
	   $('.price').removeClass("active");
		$(this).addClass('active');
		price = ($(this).attr('price'));
		price = accounting.unformat(price);
		var order=$(this).attr('order');
		$("#delivery_price").val(order);
		total = (parseFloat(amount) + parseFloat(price));
		$('.del_price').html(accounting.formatMoney(price,""));
		$('.total').html(accounting.formatMoney(total,""));
	});
	
	$( ".price2" ).on('click',function() {
		amount = ($('.amt2').text());
		amount = (accounting.unformat(amount));
	   $('.price2').removeClass("active");
		$(this).addClass('active');
		price = ($(this).attr('price'));
		price = accounting.unformat(price);
		var order=$(this).attr('order');
		$("#delivery_price2").val(order);
		total = (parseFloat(amount) + parseFloat(price));
		$('.delprice2').html(accounting.formatMoney(price,""));
		$('.total2').html(accounting.formatMoney(total,""));
	});	
	
	$( ".price3" ).on('click',function() {
		amount = ($('.amt3').text());
		amount = (accounting.unformat(amount));
	   $('.price3').removeClass("active");
		$(this).addClass('active');
		price = ($(this).attr('price'));
		price = accounting.unformat(price);
		var order=$(this).attr('order');
		$("#delivery_price3").val(order);
		total = (parseFloat(amount) + parseFloat(price));
		$('.delprice3').html(accounting.formatMoney(price,""));
		$('.total3').html(accounting.formatMoney(total,""));
	});		

/*	$( ".price" ).hover(function() {
		amount = parseFloat($('.amt').text()).toFixed(2);
	   $('.addactive').removeClass("active");
		$(this).addClass('active');
		price = parseFloat($(this).attr('price')).toFixed(2);
		total = (parseFloat(amount) + parseFloat(price)).toFixed(2);
		$('.del_price').html(price);
		$('.total').html(total);
	},
  function () {
		$(this).removeClass("active");
		$('.addactive').addClass('active');
		price = parseFloat($('.addactive').attr('price')).toFixed(2);
		total = (parseFloat(amount) + parseFloat(price)).toFixed(2);
		$('.del_price').html(price);
		$('.total').html(total);
	}); */


    currency = $('#currency option:selected').text();
    $('.showCurrency').text(currency);

    $('#currency').on('change', function(){
        currency = $('#currency option:selected').text();
        $('.showCurrency').text(currency);
    })

        function number_format(number, decimals, dec_point, thousands_sep)
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
      
        url=JS_BASE_URL+'/cart/addtocart';
        $('.add_to_cart').click(function (e) {
        
            e.preventDefault();
            $('#loginModal').modal('hide');
            var dt= $(this);
			$(".add_cart_span").html("Adding...");
            // dt.children('i').removeClass('hidden');
            var price = $(this).siblings('input[name=price]').val();
			var delivery_price = $("#mycart_delprice").val();
			var product_parent_id=$('#product_parent_id').val();
			// alert(product_parent_id);
			console.log("Price: " + price);
            $.ajax({
                url: url,
                type: "post",
                data: {
                    'quantity': $(".quantity").val(),
                    'delivery_price': delivery_price * 100,
                    'id': $(this).siblings('input[name=id]').val(),
                    'price': price,
                    'page': $("#cartpage").val(),
                    'parent_id':product_parent_id
                },
                success: function (data) {
				//	toastr.info("Product successfully added to cart");
					console.log(data);
                    dt.children('i').addClass('hidden');
                    $('.alert').removeClass('hidden').fadeIn(3000).delay(5000).fadeOut(5000);
                    $('.cart-info').text(data[1] + ' ' + currency +
					number_format(price / 100, 2) +
					" Successfully added to the cart");

                    if (data[0] < 1) {
                        $('.cart-link').text('Cart is empty');
                        $('.badges').text('0');
                        $('.badges').hide();
						$('.badgesmobile').text('0');
                        $('.badgesmobile').hide();
                    } else {
						$('.cart-link').text('View Cart');
						$('.badges').text(data[0]);
						$('.badges').show();
						$('.badgesmobile').text(data[0]);
                        $('.badgesmobile').show();
					}
					$(".add_cart_span").html("Add Cart");
				},
				error: function (error) {
					$(".add_cart_span").html("Add Cart");
				}
			});
		});
    });

    function activaTab(tab) {
        $('.nav-tabs a[href="#' + tab + '"]').tab('show');
    }
    ;
</script>

@if(!empty($discount_detail) && $discount_detail['item_in_cart']==true)

<script type="text/javascript">
   /* $('.add_to_cart').attr('disabled', true);
    $('#retail_add_to_cart').css('background-color', 'grey');
    $('#retail_add_to_cart').css('cursor', 'no-drop');
    $('.add_to_cart').css('cursor', 'no-drop');
    $('#discountLimitNotification').show();*/
</script>
@endif

@if(isset($_GET['tab']))

<script type="text/javascript">
    tagID = "{{$_GET['tab']}}";
    activaTab(tagID);
</script>
@endif
@stop
