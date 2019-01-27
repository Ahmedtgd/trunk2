@extends("common.default")

@section("content")

    <div class="alert alert-success alert-dismissible hidden cart-notification" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong class='cart-info'></strong>
    </div>

    <section class="">
        <div class="container"><!--Begin main cotainer-->
            <div class="row">
                <div data-spy="scroll" style="display: none;" class="static-tab">
                    <div class="text-center tab-arrow">
                        <span class="fa fa-sort"></span>
                    </div>
                    <ul class="nav nav-pills nav-stacked">
                        <li role="presentation" class="active floor-navigation"><a href="#pinformation">Information</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#delivery">Delivery</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#wholesale">WholeSale</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#product">Product</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#pspecification">Specification</a></li>
						{{--
                        <li role="presentation" class="floor-navigation"><a href="#seller">Seller</a></li>
						--}}
                        <li role="presentation" class="floor-navigation"><a href="#policy">Policy</a></li>
                        <li role="presentation" class="floor-navigation"><a href="#return">Return</a></li>
                    </ul>
                </div>
                <div class="col-sm-11 col-sm-offset-1">
                    <hr>

                    <form class="form-horizontal">
                        <div id="pinformation" class="row">
                            <div class="col-sm-12"><h1>Product Information</h1></div>
                            <div class="col-sm-3">
                            <div class="thumbnail">
                                <img src="{{asset('/')}}images/product/{{$product['pro']->id}}/{{$product['pro']->photo_1}}" title="product-image" class="img-responsive">
                            </div>
                            </div>

                            <div class="col-sm-9">
                               <dl class="dl-horizontal text-muted">
                                 
                                    <dt>Name</dt><dd>{{ $product['pro']->name ? $product['pro']->name : "-" }}</dd>
                                    <dt>Brand:</dt><dd>{{ $product['pro']->brand ? $product['pro']->brand->name : "-" }}</dd>
                                    <dt>Category:</dt><dd>{{ $product['pro']->category ? $product['pro']->category->description : "-" }}</dd>
                                    <dt>Sub Category</dt><dd>{{ $product['sub_product'] ? $product['sub_product']->description : "-" }}</dd>
                                    <dt>O-Shop</dt><dd>{{ $product['merchant'] ? $product['merchant'][0]->oshop_name : "" }}</dd>
                                    <dt>Short Description</dt><dd>{{ $product['pro']->product_details ? $product['pro']->product_details : "-" }}
                                    </dd>
                                </dl>
                                <div class="row">
                                <div class="col-sm-4 margin-top">
                                    <table class="table noborder">
                                        <?php
										 $retail = $product['pro']->retail_price ? ($product['pro']->retail_price)/100 : "0.0";
                                      //  $original = $product['pro']->original_price ? $product['pro']->original_price : "0.0"; 
                                        $delivery = $product['pro']->del_west_malaysia ? ($product['pro']->del_west_malaysia)/100 : "0.0";
                                        ?>
                                        <tr><th>Amount</th><td>{{$currentCurrency}}</td><td><span class="amt" amount={{ $retail }}>{{ number_format($retail,2, '.', '') }}</span></td></tr>
                                        <tr><th>Delivery</th><td>{{ $currentCurrency}}</td><td><span class="del_price">{{ number_format($delivery,2, '.', '') }}</span></td></tr>
                                        <tr><td colspan="3"><hr></td></tr>
                                        <tr><th>&nbsp</th><td>{{ $currentCurrency}}</td><td><span class="total">{{ number_format(($retail+$delivery),2, '.', '') }}</span></td></tr>
                                    </table>
                                </div>
                                <div class="col-sm-3 col-sm-offset-5 icons">
                                    <ul class="list-inline pull-right">
                                        <li class="btn btn-green btn-lg">
                                            {!! Form::open(array('url'=>'cart/addtocart', 'id'=>'cart')) !!}
                                            
                                            {!! Form::hidden('quantity', 1) !!}
                                            {!! Form::hidden('id', $product['pro']->id) !!}
                                            {!! Form::hidden('price', $product['pro']->retail_price) !!}
                                            <button class='cartBtn btn-link' type='submit' style='padding: 0px;font-size: 15px;color: rgb(255, 255, 255);'><i class="fa fa-lg fa-plus"></i></button>
                                            {!! Form::close() !!}
                                        </li>
                                        <li class="btn btn-lg btn-pink">
                                            <a href="javascript:void(0)" rel="nofollow" class="add-to-wishlist" style="color:white;" data-item-id="{{ $product['pro']->id }}">
                                                <i class="fa fa-heart"></i>
                                            </a>
                                        </li>
                                        <li class="btn btn-lg btn-darkgreen"><i class="fa fa-lg fa-shopping-cart"></i></li>
                                    </ul>
                                </div>
                            </div>
                            </div>

                            <div class="clearfix"></div>

                        </div>
                        <hr>
                        <div id="delivery">

                            <div class="col-sm-2">
                                <label class="">Delivery Pricing</label>
                            </div>


                            <div class="col-sm-4">

                                <table class="table dpricing noborder">
                                    <tr class='price' price={{$product['pro']->del_worldwide/100}}><th>World Wide</th><td>{{ $product['pro']->del_worldwide ?  $currentCurrency.' '.number_format(($product['pro']->del_worldwide/100),2, '.', '') : "" }}</td></tr>
                                    <tr class="active price addactive" price={{$delivery}}><th>West Malaysia</th><td>{{ $delivery == 0.0 ? $delivery : $currentCurrency.' '.number_format($delivery,2, '.', '') }}</td></tr>
                                    <tr class='price' price={{$product['pro']->del_sabah_labuan/100}}><th>Sabah/Labuan</th><td>{{ $product['pro']->del_sabah_labuan ? $currentCurrency.' '.number_format(($product['pro']->del_sabah_labuan/100),2) : "" }}</td></tr>
                                    <tr class='price' price={{ $product['pro']->del_sarawak/100 }}><th>Sarawak</th><td>{{ $product['pro']->del_sarawak ? $currentCurrency.' '.number_format(($product['pro']->del_sarawak)/100,2, '.', '') : "" }}</td></tr>
                                </table>

                            </div>
                            <div class="col-sm-3 col-sm-offset-3">
                                <h3>Delivery Coverage</h3>
                                <table class="table dcoverage">
                                    <tr><th>Country</th><td>{{ $product['pro']->country ? $product['pro']->country->name : "-" }}</td></tr>
                                    <tr><th>State</th><td>{{ $product['pro']->state ? $product['pro']->state->name : "-" }}</td></tr>
                                    <tr><th>City</th><td>{{ $product['pro']->city ? $product['pro']->city->name : "-" }}</td></tr>
                                </table>

                            </div>
                            <div class="clearfix"> </div>
                            <hr>
                         <div class="col-sm-12">
                                <h1>Retail</h1>
                            </div>

                            <div class="col-sm-5 fprice retail">
                                <?php
                                    $retail = $product['pro']->retail_price ? $product['pro']->retail_price/100 : 0;
                                    $original = $product['pro']->original_price ? $product['pro']->original_price/100 : 0;
                                    $diff = $original - $retail;
									$save = $diff > 0 ? ((100 * intval($diff != 0 ? $diff : 1 )) / intval($original != 0 ? $original : 1 )) : 0.0; 
								?>
								<script>
								var original_price = {{$original}};
								</script>
						
                                <table class=" table">
                                    <tr><th>Retail Price</th><td class ='retail_price' rprice='{{$retail}}'><span class="rprice">{{$retail != 0 ? $currentCurrency." ".number_format($retail,2, '.', '') : "" }}</span><strong class="pull-right text-danger">{{ $save > 0 ? 'Save '.number_format($save,2).'%' : "" }}</strong> </td></tr>
                                    <tr><th>Original Price</th><td><span class="strikethrough">{{$original !=0 ? $currentCurrency." ".number_format($original,2, '.', '') : "" }}</span> </td></tr>
                                    <tr><th>Available</th><td><span class="available" avail={{$product['pro']->available}}>{{ $product['pro']->available ? $product['pro']->available - 1 : "0"}}</span></td></tr>
                                    <tr><th>Quantity</th><td> 
                                          <div class="input-group col-sm-6">
                                          <span class="input-group-btn">
                                              <button type="button" class="btn btn-green btn-number" data-type="plus" data-field="quant[2]">
                                                  <span class="glyphicon glyphicon-plus"></span>
                                              </button>
                                          </span>
                                          <input type="text" name="quant[2]" class="form-control input-number quantity" value="1" min="1" max={{ $product['pro']->available ? $product['pro']->available - 1 : "0"}}>
                                          <span class="input-group-btn">
                                              <button type="button" class="btn btn-green btn-number"  data-type="minus" data-field="quant[2]">
                                                  <span class="glyphicon glyphicon-minus"></span>
                                              </button>
                                          </span>
                                          </div>

                                        </td></tr>
                                </table>

                            </div>

                            <div class="clearfix"> </div>
                        </div>
                        <hr>
                        <div id="wholesale">

                            <div class="col-xs-12">
                                <h1>Business to Business</h1>
                            </div>
                            <div class="col-sm-6">
                                <h3>Wholesale Price</h3>
                            </div>
                          
                            <div class="clearfix"> </div>
<hr>
							<div class="fprice avg-price col-sm-8">
                            <div class="col-sm-6">
                                <label>Resellers</label>
                                <p>{{ $product['merchant'][0]->company_name }}</p>

                                <table class="table swholesale noborder">
                                    <tr><th>Unit</th><th>Price</th></tr>
                                    @if($product['pro']->Wholesale)
                                        @foreach($product['pro']->Wholesale as $wholesale )
                                            <tr class="wprice"><td class="wprice-unit">{{ $wholesale->unit ? $wholesale->unit : '0' }}</td><td class="wprice-mvr" wprice_mvr={{ $wholesale->price ? $wholesale->price/100 : '' }}>{{$currentCurrency}} {{ $wholesale->price ? $wholesale->price/100 : '' }}</td></tr>                                        
                                        @endforeach
                                    @endif
                                </table>

                            </div>
							<?php
							$save_wholesale = count($product['pro']->Wholesale) ? (($original-$product['pro']->Wholesale[0]->price)/($original!=0 ? $original : 1))*100 .'%'  : ""  ;
							$save_wholesale = $save_wholesale > 0 ? 'Save'.$save_wholesale : "";
							?>
                            <div class="col-sm-6">
                                <h3>Average Price</h3>
                                <table class="table dcoverage">
                                    <tr><th>{{$currentCurrency}} <span class="wmvr">{{ count($product['pro']->Wholesale) ? number_format(($product['pro']->Wholesale[0]->price/100)/($product['pro']->Wholesale[0]->unit),2, '.', '') : "" }}</span></th><td><strong class="text-danger"><span class="save_wholesale">{{ $save_wholesale }}</span></strong> </td></tr>
                                    <tr><th>Quantity</th><td>

                                            <div class="input-group  col-sm-7">
                                          <span class="input-group-btn">
                                              <button type="button" class="btn btn-green btn-number who_btn" data-type="plus" data-field="quant[1]">
                                                  <span class="glyphicon glyphicon-plus"></span>
                                              </button>
                                          </span>
                                                <input type="text" name="quant[1]" class="form-control input-number who_quantity" value="1" min="1" max="100">
                                          <span class="input-group-btn">
                                              <button type="button" class="btn btn-green btn-number who_btn"  data-type="minus" data-field="quant[1]">
                                                  <span class="glyphicon glyphicon-minus"></span>
                                              </button>
                                          </span>
                                            </div>

                                        </td></tr>
                                    <tr><th></th></tr>
                                </table>

                            </div>
							</div>
                            <div class="col-sm-4">
                                <h3>Delivery Coverage</h3>
                                <table class="table dcoverage">
                                    <tr><th>Country</th><td>{{ $product['pro']->country ? $product['pro']->country->name : "-" }}</td></tr>
                                    <tr><th>State</th><td>{{ $product['pro']->state ? $product['pro']->state->name : "-" }}</td></tr>
                                    <tr><th>City</th><td>{{ $product['pro']->city ? $product['pro']->city->name : "-" }}</td></tr>
                                </table>
                            </div>
                            <div class="clearfix"> </div>

                            <div class="col-sm-6">
                                <h3>Special Price</h3>
                            </div>
                            <div class="clearfix"> </div>
                            <hr>

						<div class="fprice col-sm-8">
                            <div class="col-sm-6 sprice-top">
                                <table class="table swholesale noborder">
                                    <tr><th>Unit</th><th>Price</th></tr>
                                    @if($product['pro']->productdealer)
                                        @foreach($product['pro']->productdealer as $productdealer )
                                            <tr class="sprice"><td class="sprice-unit">{{ $productdealer->special_unit ? $productdealer->special_unit : '0' }}</td><td class="sprice-mvr" sprice_mvr={{ $productdealer->special_price ? $productdealer->special_price/100 : '' }}>{{$currentCurrency}} {{ $productdealer->special_price ? $productdealer->special_price/100 : '' }}</td></tr>                                        
                                        @endforeach
                                    @endif
                                </table>
                            </div>
							<?php
							$save_special = count($product['pro']->productdealer) ? (($original - ($product['pro']->productdealer[0]->special_price/100))/($original!=0 ? $original : 1))*100 .'%' : "" ;
							$save_special = $save_special > 0 ? 'Save'.$save_special : "";
							?>
                            <div class="col-sm-6">
                                <h3>Average Price</h3>
                                <table class="table dcoverage">
                                    <tr><th>{{$currentCurrency}} <span class="smvr">{{ count($product['pro']->productdealer) ? number_format(($product['pro']->productdealer[0]->special_price/100)/($product['pro']->productdealer[0]->special_unit),2, '.', '') : "" }}</span></th><td><strong class="text-danger"><span class="save_special">{{ $save_special}}</span></strong> </td></tr>
                                    <tr><th>Quantity</th><td>
                                            <div class="input-group  col-sm-7">
                                          <span class="input-group-btn">
                                              <button type="button" class="btn btn-green btn-number spc_btn" data-type="plus" data-field="quant[3]">
                                                  <span class="glyphicon glyphicon-plus"></span>
                                              </button>
                                          </span>
                                                <input type="text" name="quant[3]" class="form-control input-number spc_quantity" value="1" min="1" max="100">
                                          <span class="input-group-btn">
                                              <button type="button" class="btn btn-green btn-number spc_btn"  data-type="minus" data-field="quant[3]">
                                                  <span class="glyphicon glyphicon-minus"></span>
                                              </button>
                                          </span>
                                            </div>
                                        </td></tr>
                                    <tr><th></th></tr>
                                </table>
                            </div>
						</div>
                            <div class="col-sm-4">
                                <h3>Delivery Coverage</h3>
                                <table class="table dcoverage">
                                    <tr><th>Country</th><td>{{ $product['pro']->country ? $product['pro']->country->name : "-" }}</td></tr>
                                    <tr><th>State</th><td>{{ $product['pro']->state ? $product['pro']->state->name : "-" }}</td></tr>
                                    <tr><th>City</th><td>{{ $product['pro']->city ? $product['pro']->city->name : "-" }}</td></tr>
                                </table>

                            </div>
                            <div class="clearfix"> </div>

                        </div>
                        <hr>
                        <div id="product">
                            <div class="col-xs-12">
                                <a class="btn btn-green col-sm-3" href="#"> Product Details</a>
                            </div>
                            <div class="col-xs-12" style="min-height: 20px;">
                                {{ $product['pro']->product_details ? $product['pro']->product_details : "" }}
<!--                                <h4 class="text-info"><a> Health, Safety & Environment</a></h4>
<p> Health & Safety </p>
                                <img src="images/ProductpageConsumer.png" title="banner" class="img-responsive banner">
                                <p>A merchant consultant helps merchants to get on board our system as quickly as possible, from the aspect of products registration all the way to pricing. Our Knowledgeable merchant consultants will provide friendly and dependable service each step of the way. </p>
                                <p>A merchant consultant helps merchants to get on board our system as quickly as possible, from the aspect of products registration all the way to pricing. Our Knowledgeable merchant consultants will provide friendly and dependable service each step of the way. </p>-->

                            </div>

                        </div>
                        <div id="pspecification">
                            <div class="col-xs-12">
                                <h1>Product Specification</h1>
                            </div>

                            <div class="col-sm-6 col-sm-offset-1 col-xs-12 table-responsive">
                                <table class="table pspecs">
								     @if($product['specification'])
                                        @foreach($product['specification'] as $specification )
                                    <tr><td>{{$specification->description}}</td><td>{{$specification->value}}</td></tr>
                                     @endforeach
                                    @endif
                                </table>
                            </div>

                            </div>
                        <div id="seller">
                            <div class="col-xs-12">
                                <h1>Seller Information</h1>
                            </div>

                            <div class="col-sm-6 col-sm-offset-1 col-xs-12 table-responsive">
                                <table class="table pseller">
                                    <tr><td>Seller Name</td><td>{{ $product['merchant'][0]->company_name }}</td></tr>
                                            <tr><td>Ship form Address</td><td>
                                            {{ $product['merchant'][0]->address ?
                                                $product['merchant'][0]->address->line_1.'<br>'.
                                                $product['merchant'][0]->address->line_2.'<br>'.
                                                $product['merchant'][0]->address->line_3.'<br>'.
                                                $product['merchant'][0]->address->line_4.'<br>'.
                                                $product['merchant'][0]->address->city_id.' '.$product['merchant'][0]->address->postcode  
                                            :
                                                "-"  
                                            }}
                                        </td></tr>
                                    <tr><td>Return / Exchange Address:</td><td>
                                            {{ $product['merchant'][0]->address ?
                                                $product['merchant'][0]->address->line_1.'<br>'.
                                                $product['merchant'][0]->address->line_2.'<br>'.
                                                $product['merchant'][0]->address->line_3.'<br>'.
                                                $product['merchant'][0]->address->line_4.'<br>'.
                                                $product['merchant'][0]->address->city_id.' '.$product['merchant'][0]->address->postcode  
                                            :
                                                "-"  
                                            }}
                                            </td></tr>
                                </table>
                            </div>

                            </div>
                        <div id="policy">
                            <div class="col-xs-12">
                                <h1>Seller Policy</h1>
                            </div>

                            <div class="col-xs-12">
                                <a class="btn btn-green col-sm-3" href="#"> Product Details</a>
                            </div>

                            <div class="col-xs-12">
                                <p>You are only entitled to a refund if you return it within three or four weeks, other wise you can get a repair or replacement</p>
                                <p>Must display on receipt or signs in store and online</p>

                            </div>
                            </div>
                        <div id="return">
                            <div class="col-xs-12">

                                <h1>OpenSupermall</h1>
                                <h3>Notice on Return</h3>


                            </div>
                            <div class="col-xs-12">
                                <a class="btn btn-green col-sm-3" href="#"> Return / Exchange Policy</a>

                            </div>
                            <div class="col-xs-12">
                                <div class="thumbnail">
                                    {{ $product['merchant'] ? $product['merchant'][0]->return_policy : "" }}
                                </div>
                                </div>
                            </div>
                        </div>

                    </form>


                </div>
            </div>
        </div><!--End main cotainer-->
    </section>
@stop
@section('scripts')
<script type="text/javascript">
$(document).ready(function() {
$('.wprice:first').addClass('active');
$( ".btn-number" ).click(function() {
	qty = $('.quantity').val();
	retail_price = parseFloat($('.retail_price').attr('rprice'));
	amount = parseFloat(retail_price * qty).toFixed(2);
	$('.amt').html(accounting.formatMoney(amount,""));
		price = $('.del_price').html();
		total = (parseFloat(amount)+parseFloat(price)).toFixed(2);
		$('.total').html(accounting.formatMoney(total,""));
		available = parseInt($('.available').attr('avail'));
		available = available - qty;
		$('.available').html(available);
	});
	
	$( ".spc_btn" ).click(function() {
	qty = $('.spc_quantity').val();
	mvr = parseFloat($('.smvr').html());
	amount = parseFloat(mvr * qty).toFixed(2);
	$('.amt').html(accounting.formatMoney(amount,""));
		price = $('.del_price').html();
		total = (parseFloat(amount)+parseFloat(price)).toFixed(2);
		$('.del_price').html(accounting.formatMoney(price,""));
		$('.total').html(accounting.formatMoney(total,""));
	});
	
	$( ".who_btn" ).click(function() {
	qty = $('.who_quantity').val();
	mvr = parseFloat($('.wmvr').html());
	amount = parseFloat(mvr * qty).toFixed(2);
	$('.amt').html(accounting.formatMoney(amount,""));
		price = $('.del_price').html();
		total = (parseFloat(amount)+parseFloat(price)).toFixed(2);
		$('.del_price').html(accounting.formatMoney(price,""));
		$('.total').html(accounting.formatMoney(total,""));
	});
	
	$('.fprice').click(function(){
	$('.fprice').removeClass('retail');
	$(this).addClass('retail');
	});
	
	$('.wprice').click(function(){
			var ele = $(this);
			$('.wprice').removeClass('active');
			$(this).addClass('active');
			var unit = parseFloat($(this).find('.wprice-unit').html());
			var price = parseFloat($(this).find('.wprice-mvr').attr('wprice_mvr'));
			var final_wprice = !isNaN(price/unit) ? (price/unit).toFixed(2) : 0;
			$('.wmvr').html(accounting.formatMoney(final_wprice,""));
			if(original_price != 0){
			var save_wholesale = (((original_price - final_wprice)/original_price)*100).toFixed(2);
			$('.save_wholesale').html(save_wholesale > 0 ? 'Save ' + save_wholesale + '%' : "");
			}
	});
	
		$('.sprice').click(function(){
			var ele = $(this);
			$('.sprice').removeClass('active');
			$(this).addClass('active');
			var unit = parseFloat($(this).find('.sprice-unit').html());
			var price = parseFloat($(this).find('.sprice-mvr').attr('sprice_mvr'));
			var final_wprice = !isNaN(price/unit) ? (price/unit).toFixed(2) : 0;
			$('.smvr').html(accounting.formatMoney(final_wprice,""));
			if(original_price != 0){
			var save_special = (((original_price - final_wprice)/original_price)*100).toFixed(2);
			$('.save_special').html(save_special >0 ? 'Save '+ save_special + '%' : "");
			}
	});
	
/*	$( ".price" ).on('mouseenter',(function() {
		amount = parseFloat($('.amt').text()).toFixed(2);
	   $('.price').removeClass("active");
		$(this).addClass('active');
		price = parseFloat($(this).attr('price')).toFixed(2);
		total = (parseFloat(amount) + parseFloat(price)).toFixed(2);
		$('.del_price').html(price);
		$('.total').html(total);
	},
  function () {
		$('.price').removeClass("active");
		$('.addactive').addClass('active');
		price = parseFloat($('.addactive').attr('price')).toFixed(2);
		total = (parseFloat(amount) + parseFloat(price)).toFixed(2);
		$('.del_price').html(price);
		$('.total').html(total);

	}); */
	$( ".price" ).on('click',function() {
		amount = ($('.amt').text());
		amount = (accounting.unformat(amount));
	   $('.price').removeClass("active");
		$(this).addClass('active');
		price = ($(this).attr('price'));
		price = accounting.unformat(price);
		total = (parseFloat(amount) + parseFloat(price));
		$('.del_price').html(accounting.formatMoney(price,""));
		$('.total').html(accounting.formatMoney(total,""));
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
   if(path.contains('public'))
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
        $('.cart-info').text(data[1]+' '+ currency+
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
</script>
@stop
