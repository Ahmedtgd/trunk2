@extends("common.default")
@section('extra-links')
<?php 
use App\Http\Controllers\UtilityController;
$currency=UtilityController::currency();
?>
		<?php
function convertNumberToWord($num = false)
{
    $num = str_replace(array(',', ' '), '' , trim($num));
    if(! $num) {
        return false;
    }
    $num = (int) $num;
    $words = array();
    $list1 = array('', 'First', 'Second', 'Third', 'Fourth', 'Fifth', 'Sixth', 'Seventh', 'Eighth', 'Ninth', 'Tenth', 'Eleventh',
        'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
    );
    $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
    $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
        'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
        'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
    );
    $num_length = strlen($num);
    $levels = (int) (($num_length + 2) / 3);
    $max_length = $levels * 3;
    $num = substr('00' . $num, -$max_length);
    $num_levels = str_split($num, 3);
    for ($i = 0; $i < count($num_levels); $i++) {
        $levels--;
        $hundreds = (int) ($num_levels[$i] / 100);
        $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ( $hundreds == 1 ? '' : 's' ) . ' ' : '');
        $tens = (int) ($num_levels[$i] % 100);
        $singles = '';
        if ( $tens < 20 ) {
            $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
        } else {
            $tens = (int)($tens / 10);
            $tens = ' ' . $list2[$tens] . ' ';
            $singles = (int) ($num_levels[$i] % 10);
            $singles = ' ' . $list1[$singles] . ' ';
        }
        $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
    } //end for loop
    $commas = count($words);
    if ($commas > 1) {
        $commas = $commas - 1;
    }
    return implode(' ', $words);
}
		?>
<link rel="stylesheet" type="text/css" href="{{asset('css/productbox.css')}}")>
{{--
<script type="text/javascript">


$(document).ready(function(){

    $('#autolink').click(function() {

       var response = '';
        $.ajax({ type: "GET",
                 url: "{{$id}}/autolink",
                 async: false,
                 success : function(text)
                 {
                     response = text;
                 }
        });
        if (response['status']=="success") {

             $('#autolink').prop('disabled', true);
             $("#autolink").html('Requested');
        }
        else  if (response['status']=='failure' && response['code']=='unli'){
            $('#autolink').prop('disabled', true);
             $("#autolink").html('Please signup');
        }
         else  if (response['status']=='failure' && response['code']=='uara'){
            $('#autolink').prop('disabled', true);
             $("#autolink").html('Already Requested');
        }
    });
});

</script>
--}}
@stop
@section("content")

    <style type="text/css">
	
		.discription {
			position: relative;line-height: 1.5em; height: 3em;overflow: hidden;
			color: #666;
			text-overflow: ellipsis;
			width: 100%;

		}
	
		.col-xs-15,
		.col-sm-15,
		.col-md-15,
		.col-lg-15 {
			position: relative;
			min-height: 1px;
			padding-right: 10px;
			padding-left: 10px;
		}

		.col-xs-15 {
			width: 20%;
			float: left;
		}	
        {{-- start --}}
        hr{
            border-top-color: #5F6879;
            margin-top: 0px;

        }

        .priceTable thead tr th,
        .priceTable tbody tr td {
            padding: 0px;
            border: 0px;
            font-size: 12px;
        }

        .priceTable thead tr th {
            padding-bottom: 5px;
        }

        .list-inline{
            margin-top: 10px;
        }

		.showAlert{
            padding: 2px 5px;
            font-size: 12px;
            border-radius: 20px;
        }

        .product-name{
            font-weight: bold;
            @if(Auth::check())
                border-bottom: 1px solid #ccc;
            padding-bottom: 7px;
            padding-top: 7px;
            @else
                padding-top: 9px;
        @endif
    }

        .qty-area{
            padding-top: 7px;
            padding-bottom: 7px;
            border-bottom: 1px solid #ccc;
        }

        .tier-price {
            padding-top: 4px;
            padding-bottom: 0px;
            height: 100px;
            overflow: hidden;
        }

        .tier-price div p {
            padding-bottom: 0px;
            margin-bottom: 2px;
            font-size: 12px;
            font-weight: bold;
        }

        .productName{
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .product-price {
            font-weight: bold;
            padding-top: 10px;
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .popover {
            width: 16%;
        }

        @media (max-width: 321px) {
            .popover {
                width: 70%;
            }
        }

        .popover-content {
            padding: 9px 25px;
        }

        .popover-title {
            padding: 9px 10px;
        }


        .list-inline li {
            width: 30px;
            height: 30px;
            border-radius: 2px;
            text-align: center;
            padding-top: 2px;
        }
        .save {
            background: red;
            color: #fff;
            padding-left: 7px;
            border-radius: 20px;
            padding-right: 7px;
            padding-bottom: 3px;
        }

        .p-box-content {
            padding: 0px 8px 0px 8px;
        }

        button.btn-xs{
            padding: 4px 5px !important;
        }

	{{-- stop --}}
		.col-xs-15,
        .col-sm-15,
        .col-md-15,
        .col-lg-15 {
            position: relative;
            min-height: 1px;
            padding-right: 10px;
            padding-left: 10px;
        }

        .col-xs-15 {
            width: 20%;
            float: left;
        }
        @media (min-width: 768px) {
            .col-sm-15 {
                width: 20%;
                float: left;
            }
        }
        @media (min-width: 992px) {
            .col-md-15 {
                width: 20%;
                float: left;
            }
        }
        @media (min-width: 1200px) {
            .col-lg-15 {
                width: 20%;
                float: left;
            }
        }
        .btn-subcat{
            border: none;
            background: #fff;
            padding-left: 0px;
        }

        .fa-li {
            position: static;
        }
        .img{
          width: 100%;
          height:210px;
          object-fit: cover;
        }
        .category_image_container{
            height:420px;
            border:1px solid #c0c0c0;
            margin-bottom: 10px;
        }
    </style>

    <div class="alert alert-success alert-dismissible hidden cart-notification" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong class='cart-info'></strong>
    </div>
    @if($type == "oshop")
        <section class="categorylist">

        @if( isset($signboard->id))
            <img style="height: 200px;width:100%" class="width-100 img-responsive" src="{{ asset('images/signboard/'.$signboard->id .'/' .$signboard->image) }}" alt="{{ $merchant->oshop_name }} Signboard" />
        @endif

        <div class="container">

			<div class="margin-top">@include('oshopnavigation')</div>

            <div class="row">
                <div data-spy="scroll" class="static-tab" style="display: none;">
                    <div class="text-center tab-arrow">
                        <span class="fa fa-sort"></span>
                    </div>

                    <ul class="nav nav-pills nav-stacked">
                        @foreach($section_names as $name)
                            <li><a href="">{{$name}} </a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-2">
                    @if( isset( $bunting->id ) )
                        <img style="height: 400px;width:100%" class="img-responsive" src="{{ asset('images/bunting/'.$profile->bunting->id . '/' .$profile->bunting->image) }}" alt="{{ $merchant->oshop_name }} Bunting" />
                    @endif


                </div>

                <div class="col-sm-10">

                    <div class="row cat-items">

                       {{--  @foreach($merchant_cat as $category)
                            @foreach($merchant->categories as $cat)
                                @if($category == $cat->id)
                                    <div class="col-md-12 floor-board nopadding">
                                        <div class="col-xs-12 col-md-4">
                                            <h3>{{ $cat->description }}</h3>
                                        </div>
                                    </div>

                                @endif
                            @endforeach --}}
                            @foreach ($section_names as $name)
                            <div class="col-md-12 floor-board nopadding">
                                <div class="col-xs-12 col-md-4">
                                    <h3>{{$name}}</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-2">
                                    <div style="color:white; margin-right:0px; margin-top:20px;" class="pull-right">
                                        3 results &nbsp; &nbsp; Sort By:&nbsp; &nbsp;
                                        <select style="width:150px;color:black">
                                            <option>Price:low to high</option>
                                            <option>Price: High to low</option>
                                        </select><span class="caret"></span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            {{-- Products --}}
                            @foreach($products as $product)
                                <div class="p-box col-md-3 col-sm-4"
                                style="padding-right:2px;">
                                    <div class="cat-img">
                                        <a href="{{ route('productconsumer', $product['product']['id']) }}">
                                              <img class="img-responsive" alt="Missing"
											  	style="object-fit:contain;"
                                                src="/images/product/{{$product['product']['id']}}/thumb/{{$product['product']['thumb_photo']}}">
                                        </a>
                                    </div>
                                    {{-- img ends --}}
                                    <h5 class="pull-left">
                                        {{ucfirst($product['product']['name'])}}
                                    </h5>
                                    <br>
                                               @if ($product['product']['discounted_price'] == 0)
                                        @if ($product['product']['original_price'] != 0)
                                            <strong class="pull-right margin-top">
                                                MYR{{number_format($product['product']['original_price']/100,2)}}</strong><br/>
                                        @endif
                                    @else
                                        <strike style="color:red" class="pull-right margin-top">
                                            <strong style="color:black" class="margin-top">
                                                MYR{{number_format($product['product']['original_price']/100,2)}}</strong><br/>
                                        </strike>
                                        <strong style="color:red;font-size:130%;
                                            position:absolute;margin-top:25px;right:0px"
                                                class="pull-right;">
                                            MYR{{number_format($product['product']['discounted_price']/100,2)}}</strong><br/>
                                        <strong style="color:red;font-size:130%;
                                            position:absolute;margin-top:45px;right:0px"
                                                class="pull-right;">
                                            Save {{number_format((($product['product']['original_price'] -
                                            $product['product']['discounted_price'])/$product['product']['original_price'])*100,0)}}%</strong>

                                    @endif
                                     <div class="clearfix"> </div>
                                </div>
                            @endforeach
                            {{-- Products --}}
                          {{--   @foreach($products as $product)
                                @if($category == $product->category_id) --}}
                                        {{-- <div class="p-box col-md-3 col-sm-4" style="padding-right: 2px;">
                                    <div class="cat-img">
                                        <a href="{{ route('productconsumer', $product['id']) }}">
                                           <img class="img-responsive" alt="Missing"
											src="/images/product/{{$product['id']}}/{{$product['photo_1']}}">
                                        </a>
                                    </div>
                                            <h5 class="pull-left">{{$product['name']}}</h5><br/>
                                    @if ($product['retail_price'] == 0)
                                        @if ($product['original_price'] != 0)
                                            <strong class="pull-right margin-top">
                                                MYR{{number_format($product['original_price']/100,2)}}</strong><br/>
                                        @endif
                                    @else
                                        <strike style="color:red" class="pull-right margin-top">
                                            <strong style="color:black" class="margin-top">
                                                MYR{{number_format($product['original_price']/100,2)}}</strong><br/>
                                        </strike>
                                        <strong style="color:red;font-size:130%;
                                            position:absolute;margin-top:25px;right:0px"
                                                class="pull-right;">
                                            MYR{{number_format($product['retail_price']/100,2)}}</strong><br/>
                                        <strong style="color:red;font-size:130%;
                                            position:absolute;margin-top:45px;right:0px"
                                                class="pull-right;">
                                            Save {{number_format((($product['original_price'] -
											$product['retail_price'])/$product['original_price'])*100)}}%</strong>

                                    @endif --}}
                                {{--     <div class="clearfix"> </div>
                                    <ul class="pull-left list-inline">
                                         <li class="btn-green">
                                            {!! Form::open(array('url'=>'cart/addtocart')) !!}

                                            {!! Form::hidden('quantity', 1) !!}
                                            {!! Form::hidden('id', $product->id) !!}
                                            {!! Form::hidden('price', $product->retail_price) !!}
                                            <button class='btn-link cartBtn' type='submit' style='padding: 0px;font-size: 15px;color: rgb(255, 255, 255);'><i class="fa fa-plus"></i></button>
                                            {!! Form::close() !!}
                                        </li>
                                        <li class="btn-pink">
                                            <a href="javascript:void(0)" rel="nofollow" class="add-to-wishlist" style="color:white;" data-item-id="{{ $product['id'] }}">
                                                <i class="fa fa-heart"></i>
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="clearfix"> </div> --}}
                                </div>
                                {{-- @endif --}}
                            {{-- @endforeach --}}
                        {{-- @endforeach --}}
                        @if( isset( $profile->vbanner->id ) )
                            <div  id="video" class="col-xs-12 margin-top video-banner">
                                <div class="placeholder">
                                    <div id="block">
                                        <?php
                                        $path = explode(':',$profile->vbanner->image)[0];
                                        ?>
                                        <span style="display: none" class="videobanner">@if($path == 'http' || $path == 'https'){{$profile->vbanner->image}}@else{{ asset('/images/vbanner/'.$profile->vbanner->id.'/'.$profile->vbanner->image)}}@endif</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <br/>
                        <br/>
                    </div>
                </div>
            </div>
        </div><!-- End Container -->

    </section>

	<!-- Currently in use -->
    @elseif($type == "brand")
    <?php $value=3;
                        $av=10;
                        $text=35;
                        $o=4;
                     ?>
        <section class="categorylist">
            <div class="container"><!--Begin main cotainer-->
                <div class="row">
                    <div data-spy="scroll" style="display: none;" class="static-tab">
                        <div class="text-center tab-arrow">
                            <span class="fa fa-sort"></span>
                        </div>
                        <ul class="nav nav-pills nav-stacked">
                            <li class="floor-navigation" role="presentation"><a href="#ab">A-B</a></li>
                            <li class="floor-navigation" role="presentation"><a href="#ab">C-D</a></li>

                        </ul>
                    </div>
                    <div class="col-sm-11 col-sm-offset-1">
						{!! Breadcrumbs::renderIfExists() !!}
                        <div class="col-xs-4 pull-right margin-top box-green nomobile">
                            <div class="col-xs-6">
                                <div class="row text-right" style="margin-top:5px">
                                    <label> Sort By: &nbsp;</label>
                                </div>
                            </div>
                            <div class="col-xs-6" style="padding-right:0px;">
                                <div class="row">
                                    <select class="selectpicker" id="brand_sort" data-style="btn-green" data-live-search="true">
                                        <option value="1"> Price Low to High</option>
                                        <option value="2"> Price High to Low</option>
                                        <option value="3"> Relevance</option>
                                        <option value="4"> Discount</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr class="nomobile">
                        <input type="hidden" id="brand_id" value="{{$brandDetails->id}}" />
                        <h1 class="nomobile">{{$brandDetails->name}}</h1>
                        <div class="clearfix"></div>
                        <div class="row cat-items" id="brand_products">
                            @foreach($brandDetails->products as $product)
                            {{-- Code STARTS --}}
                            <div class="col-md-3 col-sm-4 col-xs-6 column productbox">
                            <a href="{{ route('productconsumer', $product['id']) }}">
                            <div class="cat-img">
                            <img src="{{ URL::to('/') }}/images/product/{{$product->id}}/thumb/{{$product->thumb_photo}}" class="img simg img-responsive full-width"></a>
                            </div>
                               <div data-tooltip="{{$product->name}}"  class="mouseover producttitle">
                                    <div class="gradientEllipsis inside" >
                                        {{ucfirst($product->name)}}
                                        <div class="dimmer"></div>
                                    </div>
                                </div>

                            <div class="productprice" style="padding-top: 0;">

                            <div class="pricetext" style="font-size:1em">
                                            @if (($product->discounted_price == $product->retail_price) || ($product->discounted_price == 0))
                                                @if ($product->retail_price > 0)
                                                    <br/><strong style="font-size:1em;">
                                                        MYR&nbsp;{{number_format($product->retail_price/100,2)}}</strong>
												@else
													&nbsp;
												@endif
												<br/>
												<span>&nbsp;</span>
                                            @else
                                                    <br/><strong style="color:black; font-size:1em;">MYR</strong><strike style="color:red"><span style="color:#333;">
                                                    <strong style="color:black; font-size:1em;">
                                                        {{number_format($product->retail_price/100,2)}}</strong></span>
                                                </strike>

                                                <strong style="color:red;font-size:1em;">
                                                    {{number_format($product->discounted_price/100,2)}}</strong>
												<br/>
                                                <strong style="color:white;background:red; font-size:1em;"
                                                        class="pull-right badgenew">
												
                                                    Save {{number_format((($product->retail_price - $product->discounted_price)/$product->retail_price)*100,0)."%"}}
                                                    </strong><br/>

                                            @endif
                                        </div>
                            </div>
                        </div>
                                                    {{-- Product dimension --}}


                            @endforeach
                            {{-- MYCODE ENDS --}}
            </div><!--End main cotainer-->
                <div class="row" id="brand_fa" style="display: none;">
                    <p align="center">
                        <i class="fa-li fa fa-spinner fa-spin fa-4x fa-fw">
                        </i>
                    </p>
                </div>
        </section>

    @elseif($type =="floor")
		<?php $k=0; ?>
		<?php $kw=0; ?>
		<?php $page = 0; ?>
		<?php $oproducts = 0; ?>
        <section class="categorylist">
            <div class="container"
				id="content-floor"
				style="min-height: 380px;">

				<!--Begin main container-->
                <div class="row">
                    <div class="col-sm-12">
					<div class="col-xs-12" id="ahr">
							{!! Breadcrumbs::renderIfExists() !!}
					</div>
					<div class="col-xs-12 nomobile" id="ahr">
						@include('floorleftNavbar')
					</div>
						
					<div class="clearfix"></div>
					<img src="{{url('/')}}/images/category/logo/{{$category_logo}}"
						alt="{{$category_logo}}" class="mobile"
						style="width:30px; margin-top: 10px;">

					<p align="center"
						style="font-size:30px;margin-bottom:0px;margin-top:-40px">{{$category_name}}</p>

					<p align="center"
						style="font-size: 15px;  margin-bottom: 0px;">
						{{convertNumberToWord($category_floor)}}Floor</p>

					<div class="col-xs-2"></div>
					<div class="col-xs-8"
						style="border-bottom:1px solid #b9b9b9;margin-bottom:20px;">
					</div>
					<div class="col-xs-2"></div>
					<div class="clearfix"></div>

                    {{-- Category Image Banner --}}
					{{--
					@include("category_advert")
					--}}
                    {{-- Category Image Banner end --}}

                    <div class="clearfix"></div>

					<div id="content-floor-def">
					<div class="row cat-items boxrow4">
					@foreach($products as $product)
						@if($oproducts == 0) 
							<div id="page{{$page}}" class="pages"
								@if($page > 0) style="display: none;" @endif>
						@endif
						<div class="col-md-2 col-sm-4 col-xs-6">
							<div class="col-xs-12 no-padding">
								<?php
									$raw_orip = $product->retail_price;
									$raw_retp = $product->discounted_price;
								
									($raw_orip > 0) ? $orip = $raw_orip/100 : $orip = 0;
									($raw_retp > 0) ? $retp = $raw_retp/100 : $retp = 0;
								?>

								@if ($retp > 0)
									<span class="badge dispprice"
									style="padding: 6px 12px !important;">
									{!! $currency !!}&nbsp;{{number_format($retp,2)}}</span>
								@else
									@if ($orip > 0)
										<span class="badge dispprice"
										style="padding: 6px 12px !important;">
										{!! $currency !!}&nbsp;{{number_format($orip,2)}}</span>
									@endif
								@endif
								@if ($orip > $retp && $retp != 0)
									<span class="badge-cutoff"><strong>
									@if ($orip > 0)
									{{--*/
										$res = number_format((($orip - $retp) / $orip) * 100);
										if ($res < 0) $res = 0;
									/*--}}  
									@else
									{{--*/ $res = 0; /*--}}  
									@endif
									<span>{{$res}}</span>%</strong><br>off</span>
								@endif

								<a href="{{ route('productconsumer', [$product->id]) }}"> 
								<img src="{{ URL::to('/') }}//images/product/{{$product->id}}/thumb/{{$product->thumb_photo}}"
									alt="Missing" class="img-responsive timg" style="border-style: hidden;" />
								</a>
						</div>
						<?php $pdesc = str_replace('"','&quot;',$product->name); ?>
						<div data-tooltip="{{$pdesc}}" class="mouseover producttitle col-xs-12">
							<div class="discription inside" style="">
							{{ $product->name}}
							
							</div>
						</div>	
					</div>  
					<?php $oproducts++; ?>
					@if($oproducts >=18 )
						<?php $oproducts = 0; ?>
						<?php $page++; ?>
						</div>
					@endif
					<?php $kw++; ?>
					@if($kw == 6)
						<div class="clearfix"> </div>
						<?php $kw=0; ?>	
					@endif								
					@endforeach

						 </div>
						 <div class="clearfix"> </div>
						<center >
							@if($page > 0 )
								<ul class="pagination">
									<li><a href="javascript:void(0)" class="first_page fontsize nomobile"><<</a></li>
									<li><a href="javascript:void(0)" class="prev_page fontsize nomobile">< Prev</a></li>
									<li><a href="javascript:void(0)" class="prev_page fontsize mobile"><</a></li>
									<li><span  class="last_ellipsis fontsize" style="display: none;">...</span><li>
									@for($pp = 0; $pp <= $page; $pp++)
										@if($pp > 5 && $pp == $page)
											<li><span  class="ellipsis fontsize">...</span></li>
										@endif
											<li><a href="javascript:void(0)" id="apage{{ $pp }}" rel="{{$pp}}" class="fontsize apage @if($pp == 0) selecteda @endif" @if($pp >= 5 && $pp != $page ) style="display: none;" @endif>{{$pp + 1}}</a></li>						
									@endfor
									<li><a href="javascript:void(0)" class="next_page fontsize nomobile"> Next ></a></li>
									<li><a href="javascript:void(0)" class="next_page fontsize mobile">></a></li>
									<li><a href="javascript:void(0)" class="last_page fontsize nomobile">>></a></li>
								</ul>

								<input type="hidden" value="{{$page}}" id="page_count" />
								<input type="hidden" value="0" id="current_page" />
							@endif
						</center>
						@if(sizeof($products)==0)
							<h3>Empty Floor</h3>
						@endif
						</div>
                    </div>
                </div>
            </div><!--End main cotainer-->
        </section>
		<style>
			@media only screen and (max-width: 400px) {
				.breadcrumb{
					display: none !important;
				}
			}
		</style>
	<!-- Category -->
    @else
		<style>
			@media only screen and (max-width: 400px) {
				.breadcrumb{
					display: none !important;
				}
				
				.notopmobile{
					margin-top: 5px !important;
				}
			}
			
		</style>
		<?php $k=0; ?>
		<?php $kw=0; ?>
		<?php $page = 0; ?>
		<?php $oproducts = 0; ?>		
        <section class="categorylist">
            <div class="container"><!--Begin main cotainer-->
                <div class="row notopmobile" style="margin-top: 50px;">
                    <div data-spy="scroll" style="display: none;" class="static-tab">
                        <div class="text-center tab-arrow">
                            <span class="fa fa-sort"></span>
                        </div>
                        <ul class="nav nav-pills nav-stacked">
                            <li class="floor-navigation" role="presentation"><a href="#ab">A-B</a></li>
                            <li class="floor-navigation" role="presentation"><a href="#ab">C-D</a></li>

                        </ul>
                    </div>
                    <div class="col-sm-12">
					{!! Breadcrumbs::renderIfExists() !!}
                        <input type="hidden" id="category_id" value="{{$catDetails->id}}" />
                        <input type="hidden" id="subcat_id" value="{{$subcat_id}}" />
                        <h1 class="nomobile">{{$catDetails->description}}</h1>
                        <h2 class="nomobile">{{$subCatDesc}}</h2>
						<p align="center" style="font-size: 20px;">{{$subCatDesc}}</p>
                        <div class="clearfix"></div>
                        <div class="row cat-items boxrow4">

                            @foreach($catDetails->products as $product)
							@if($oproducts == 0) 
								<div id="page{{$page}}" class="pages" @if($page > 0) style="display: none;" @endif> @endif
                                <div class="col-md-2 col-sm-4 col-xs-6">
									<div class="col-xs-12 no-padding">
										<?php
											$raw_orip = $product->retail_price;
											$raw_retp = $product->discounted_price;
										
											($raw_orip > 0) ? $orip = $raw_orip/100 : $orip = 0;
											($raw_retp > 0) ? $retp = $raw_retp/100 : $retp = 0;
										?>

										@if ($retp > 0)
											<span class="badge dispprice" style="padding: 6px 12px !important;">{!! $currency !!}&nbsp;{{number_format($retp,2)}}</span>
										@else
											@if ($orip > 0)
												<span class="badge dispprice" style="padding: 6px 12px !important;">{!! $currency !!}&nbsp;{{number_format($orip,2)}}</span>
											@endif
										@endif
										@if ($orip > $retp && $retp != 0)
											<span class="badge-cutoff"><strong>
											@if ($orip > 0)
											{{--*/
												$res = number_format((($orip - $retp) / $orip) * 100);
												if ($res < 0) $res = 0;
											/*--}}  
											@else
											{{--*/ $res = 0; /*--}}  
											@endif
											<span>{{$res}}</span>%</strong><br>off</span>
										@endif

										<a href="{{ route('productconsumer', [$product->id]) }}"> 
										<img src="{{ URL::to('/') }}//images/product/{{$product->id}}/thumb/{{$product->thumb_photo}}"
											alt="Missing" class="img-responsive timg" style="border-style: hidden;" />
										</a>
								</div>
								<?php $pdesc = str_replace('"','&quot;',$product->name); ?>
								<div data-tooltip="{{$pdesc}}" class="mouseover producttitle col-xs-12">
									<div class="discription inside" style="">
									{{ $product->name}}
									
									</div>
								</div>
                                </div>
								<?php $oproducts++; ?>
								@if($oproducts >=18 )
									<?php $oproducts = 0; ?>
									<?php $page++; ?>
									</div>
								@endif
								<?php $kw++; ?>
								@if($kw == 6)
									<div class="clearfix"> </div>
									<?php $kw=0; ?>	
								@endif	
                            @endforeach


                            <div class="clearfix"></div>

                        </div>
						 <div class="clearfix"> </div>
						<center >
							@if($page > 0 )
								<ul class="pagination">
									<li><a href="javascript:void(0)" class="first_page fontsize nomobile"><<</a></li>
									<li><a href="javascript:void(0)" class="prev_page fontsize nomobile">< Prev</a></li>
									<li><a href="javascript:void(0)" class="prev_page fontsize mobile"><</a></li>
									<li><span  class="last_ellipsis fontsize" style="display: none;">...</span><li>
									@for($pp = 0; $pp <= $page; $pp++)
										@if($pp > 5 && $pp == $page)
											<li><span  class="ellipsis fontsize">...</span></li>
										@endif
											<li><a href="javascript:void(0)" id="apage{{ $pp }}" rel="{{$pp}}" class="fontsize apage @if($pp == 0) selecteda @endif" @if($pp >= 5 && $pp != $page ) style="display: none;" @endif>{{$pp + 1}}</a></li>						
									@endfor
									<li><a href="javascript:void(0)" class="next_page fontsize nomobile"> Next ></a></li>
									<li><a href="javascript:void(0)" class="next_page fontsize mobile">></a></li>
									<li><a href="javascript:void(0)" class="last_page fontsize nomobile">>></a></li>
								</ul>

								<input type="hidden" value="{{$page}}" id="page_count" />
								<input type="hidden" value="0" id="current_page" />
							@endif
						</center>						
                        <div class="row" id="category_fa" style="display: none;">
                                <p align="center">
                                    <i class="fa-li fa fa-spinner fa-spin fa-4x fa-fw">
                                    </i>
                                </p>
                        </div>


                    </div>
                </div>
            </div><!--End main cotainer-->
        </section>
    @endif
    <!--O-Shop-->
@stop

@section('scripts')
	{{--
    <script>
        var x = new EmbedJS({
            element: document.getElementById('block'),
            googleAuthKey : 'AIzaSyCqFouT8h5DKAbxlrTZmjXEmNBjC69f0ts',
            videoDetails       : false,
        });
        x.render();
    </script>
	--}}
<script type="text/javascript">
$(document).ready(function(){

    $('#category_sort').change(function(e){
        var url = JS_BASE_URL + '/category_sort';
        var sort = $(this).val();
        var category_id = $("#category_id").val();
        var subcat_id = $("#subcat_id").val();
        $('#category_products').hide();
        $('#category_fa').show();
        $.ajax({
            url: url,
            type: "get",
            data: {
                'sort':sort,
                'category_id':category_id,
                'subcat_id': subcat_id
            },
            success: function(data){
                $('#category_products').html(data);
                $('#category_products').show();
                $('#category_fa').hide();
            }
        });
    });

    $('#brand_sort').change(function(e){
        var url = JS_BASE_URL + '/brand_sort';
        var sort = $(this).val();
        var brand_id = $("#brand_id").val();
        $('#brand_products').hide();
        $('#brand_fa').show();
        $.ajax({
            url: url,
            type: "get",
            data: {
                'sort':sort,
                'brand_id':brand_id
            },
            success: function(data){
                $('#brand_products').html(data);
                $('#brand_products').show();
                $('#brand_fa').hide();
            }
        });
    });

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

   path = window.location.href;
   var url;
//   if(path.contains('public'))
   if(path.indexOf('public')>0)
   {
        url = '/OpenSupermall/public/cart/addtocart';
   }
   else {
        url = '/cart/addtocart';
   }
  $('.cartBtn').click(function(e){
    e.preventDefault();
    var price = $(this).siblings('input[name=price]').val();
    $.ajax({
      url: url,
      type: "post",
      data: {
        'quantity':$(this).siblings('input[name=quantity]').val(),
        'id': $(this).siblings('input[name=id]').val(),
        'price': price
      },
      success: function(data){
        $('.alert').removeClass('hidden').fadeIn(3000).delay(5000).fadeOut(5000);
        $('.cart-info').text(data[1]+' '+currency+
			number_format(price/100,2)+" Successfully added to the cart");

        if(data[0] < 1) {
            $('.cart-link').text('Cart is empty');
            $('.badge').text('0');
        } else {
            $('.cart-link').text('View Cart');
            $('.badge').text(data[0]);
        }
      }
    });
  });
});
function addToWishList(product_id){}
  {{--//  console.log(product_id);--}}
    {{--jQuery.ajax({--}}
        {{--type: "GET",--}}
        {{--url: "{{ url('add_to_wish_list_new')}}",--}}
        {{--data: {itemId:product_id },--}}
        {{--beforeSend: function(){},--}}
        {{--success: function(response){--}}
            {{--console.log(response);--}}
            {{--if(response.search("OpenWish") != -1)--}}
            {{--{--}}
                {{--toastr.info(response);--}}
            {{--}--}}
            {{--else{--}}
                {{--window.location.replace('http://beta.opensupermall.com/fb/login');--}}
            {{--}--}}
        {{--}--}}
    {{--});--}}
{{--}--}}
</script>

@stop
