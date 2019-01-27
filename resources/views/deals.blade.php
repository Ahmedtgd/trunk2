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
.hyper_deals_container img{
    height:150px;
}
.discount {
    font-weight: bold;
    color: #27A98A;
    font-size: 30px;
    height: 50px;
    line-height: 20px;
    position: absolute;
    top: 101px;
    left: 0px;
}

.discount span {
    font-size: 16px;
}
    </style>

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

                    <div class="clearfix"></div>

                    <p align="center"
                        style="font-size:30px;margin-bottom:0px;margin-top:-40px">Hyper Deals</p>

                    <div class="col-xs-2"></div>
                    <div class="col-xs-8"
                        style="border-bottom:1px solid #b9b9b9;margin-bottom:20px;">
                    </div>
                    <div class="col-xs-2"></div>
                    

					<div class="clearfix"></div>
					<div id="content-floor-def">
					<div class="row cat-items boxrow4 hyper_deals_container">
					

                    @foreach($products as $product)
                        @if($oproducts == 0) 
                            <div id="page{{$page}}" class="pages"
                                @if($page > 0) style="display: none;" @endif>
                        @endif
                        <div class="col-md-2 col-sm-4 col-xs-6">
                            <div class="col-xs-12 no-padding mouseover" data-tooltip="{{$product->name}}">

                                <a href="{{ route('owarehouse', [$product->subcat_id.'-'.$product->subcat_level]) }}"> 
                                <img src="{{ URL::to('/') }}//images/product/{{$product->id}}/thumb/{{$product->thumb_photo}}"
                                    alt="Missing" class="img-responsive timg" style="border-style: hidden;" />
                                    <span class="discount"><span>SAVE</span><br>{{number_format((($product->retail_price -$product->discounted_price) * 100)/$product->retail_price,0)}}</strong>%</span>
                                </a>
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
@stop

@section('scripts')
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
</script>

@stop
