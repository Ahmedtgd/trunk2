@extends('common.default')
@section('extra-links')
    <link rel="stylesheet" type="text/css" href="{{asset('css/productbox.css')}}" )>
    <script type="text/javascript" src="{{asset('js/autolink.js')}}"></script>
	<style>
/*SMM*/
    .productbox{
        margin-right: 0px;
    }
    .selected{
        border: 1px green solid;
    }

	thead tr td.special_price_row {
		padding: 0px;
		font-size: 12px;
	}

/*SMM ENDS*/

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

    .cat-img {
        padding: 0px;
        min-height: 220px;
    }

    .cat-img img {
        height: 200px !important;
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
	</style>
@stop

@def $currency = \App\Models\Currency::where('active',1)->first()->code;
@section('content')

	<input type="hidden" value="{{$id}}" id="oshop_id" >
	<input type="hidden" value="{{$oshop_id}}" id="real_oshop_id" >
	<div class="container-fluid">
        <div class="alert alert-success alert-dismissible hidden cart-notification" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong class='cart-info'></strong>
        </div>
        {{-- ^ No need maybe? --}}

     <div class="row">
        <div class="col-md-12">
                <div class="row signboard">
                    @if( isset($signboard->id))
						<img style="margin-top:-6px;object-fit:none;height:200px;width:100%"
							class="width-100 img-responsive"
							src="{{ asset('images/signboard/'.
								$signboard->id .'/' .$signboard->image) }}"
							alt="{{ $merchant->oshop_name }} Signboard"/>
                    @endif
                </div>
				
                <div style="margin-top:-5px;" class="margin-top">@include('oshopnavigation')</div>
				@if( isset( $profile->vbanner->id ) )
					<div id="video" class="col-xs-12 margin-top video-banner">
						<div class="placeholder">
							<div id="block">
								<?php
								$path = explode(':', $profile->vbanner->image)[0];
								?>
								<span style="display: none"
									  class="videobanner">
									  @if($path == 'http' || $path == 'https')
										  {{$profile->vbanner->image}}
									  @else{{ asset('/images/vbanner/'.$profile->vbanner->id.'/'.
									  	$profile->vbanner->image)}}@endif
								</span>
							</div>
						</div>
					</div>
				@endif
                <?php $value = 4;$av = 12; $text = 25; $o = 3;?>
			<p  style="float:left;"><a style="color:#000; font-size: 23px;"
				href="{{route('oshop.one',[$oshop_id])}}">OFFICIAL SHOP</a>&nbsp; &nbsp;<img style="width:30px; height:20px; margin-top: -4px;"
				src="{{ asset('images/malaysia.png') }}">&nbsp; {!! Breadcrumbs::renderIfExists() !!}</p>
		</div>
		<div class="col-md-15 col-md-3" style="margin-left:5px">
			@include('leftNavbar')
		</div>
                {{-- Put products  under their section --}}
		<?php $issub = false;
			if(!is_null($subid)){
				$issub = true;
			}
		?>
        <div id="retail_product_content" class="col-md-9">
        	<div id="content-retail" class='content-tab'>
		        <div class="col-sm-12" style="margin-bottom:10px">
		            <div class="row">
		                <h2 style="margin-left:8px;margin-bottom:0;margin-top:0">O-Shop</h2>
		            </div>
					@include('product.oshop.retail')
		        </div>
			</div>

		    <div id="content-B2B" class='content-tab hidden'>
				@include('product.oshop.b2b')
		    </div>
			<div id="content-special" class='content-tab hidden'>
				@include('product.oshop.special')
			</div>			
			<div id="content-voucher" class='content-tab hidden'>
				@include('product.oshop.voucher')
			</div>
			<div id="content-hyper" class='content-tab hidden'>
		        <div class="col-sm-12" style="margin-bottom:20px">
		            <div class="row">
						@include('product.oshop.hyper')
		            </div>
		        </div>
			</div>			
			<div id="content-smm" class='content-tab hidden'>
				@include('product.oshop.smm')
			</div>			
			<div id="content-oem" class='content-tab hidden'>
		        <div class="col-sm-12" style="margin-bottom:20px">
		            <div class="row">
		                <h2 style="margin-left:9px">OEM/ODM</h2>
		            </div>
		        </div>
			</div>
		<br style="margin-bottom:20px"/>
        </div>
            {{-- V --}}
        {{-- col-md-11 --}}

    </div>
    </div>
	<div class="clearfix"></div>

<script type="text/javascript">
    $(document).ready(function(){
        var product_id=-1;
        $('body').click(function(evt){
            if ($(evt.target).hasClass('added')) {
                $('.productbox').removeClass('selected');

                var pid= $(evt.target).attr('data-pid');
                window.product_id=pid;
                var cls=".productbox_"+pid;
                $(cls).toggleClass('selected');
                $('#blast').prop('disabled',false);
                // if ($(evt.target).hasClass('selected')) {
                //     var product_id= $('.productbox').attr('data-pid');
                //     alert(product_id);
                // };

            }
            else{
                $('.productbox').removeClass('selected');
                 $('#blast').prop('disabled',true);
            }
        });

    });
</script>
{{-- AJAC CALL FOR SMM SAVE --}}
 <script type="text/javascript">
 $(document).ready(function(){
    $('#blast').click(function(){
        // alert(product_id);
        $.ajax({
                url: JS_BASE_URL + '/smedia/marketer',
                type: 'GET',
                data: {product_id: product_id},
                success:function(response){
                    toastr.info(response);
                }
        });
    });

 /*   $('.b2b_validation').click(function(){
        // alert(product_id);
		$("#modal_autolink_message").show();
		setTimeout(function () {
			$('#modal_autolink_message').hide();
		}, 10000);
    });	*/

    $('.autolink_validation').click(function(){
		$("#modal_autolink_message").show();
		setTimeout(function () {
			$('#modal_autolink_message').hide();
		}, 20000);
    });
 });
</script>
@if($autolink_status==0)
<script type="text/javascript">
	$(document).ready(function(){
		$('#b2bref').click(function(){
			// alert('u');
			toastr.info("Please click on the Autolink button to get linked with the merchant and receive special prices");
		});
	});
</script>
@endif
    <script>
        var x = new EmbedJS({
            element: document.getElementById('block'),
            googleAuthKey : 'AIzaSyCqFouT8h5DKAbxlrTZmjXEmNBjC69f0ts',
            videoDetails       : false,
        });
        x.render();
    </script>

    {{-- B2B section :: wahid --}}
    <script type="text/javascript">
	    $(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip();
			$("[data-toggle=popover]").popover({
				html: true,
				content: function() {
					id = $(this).attr('id');
					return $('#price-'+id).html();
				}
			});

	        $('.showAlert').click(function(){
	            $("#alert").removeClass('hidden');
	        })


	        currency = "{{ $currency }}";

	        var url = "{{ route('postAddToCart') }}";

	        $('#content-B2B .b2bcartBtn').click(function(e){
	        e.preventDefault();
	        var id = $(this).attr('data');
	        var quantity = $('.numberInput-'+id).val();
	        var totalPrice = parseInt($('#total-price-'+id).text());
	        var actualTotalPrice = parseInt($('#hidden-total-price-'+id).text());
	        var price = (actualTotalPrice/quantity);
	        $.ajax({
	          url: url,
	          type: "post",
	          data: {
	            'quantity': quantity,
	            'id': id,
	            'price': price
	          },
	          success: function(data){
	            $('.alert').removeClass('hidden').fadeIn(2000).delay(7000).fadeOut(2000);
	            $('.cart-info').text(data[1]+
				' ( '+ $currency + ' ' + formatPrice(actualTotalPrice)+ ') '+
				" Successfully added to the cart");
	            if(data[0] < 1)
	            {
	                $('.cart-link').text('Cart is empty');
	                $('.badge').text('0');
	            }
	            else {

	                $('.cart-link').text('View Cart');
	                $('.badge').text(data[0]);
	            }
	          }
	        });
	        });

	        $('.wholesale-price').each(function(){
	            id = $(this).attr('data');
	            var PRICE;
	            specialMinUnit = parseInt($('.price-info-'+id).first().attr('special-funit'));
	            minUnit = parseInt($('.price-info-'+id).first().attr('from-unit'));

	            specialPrice = parseInt($('.price-info-'+id).first().attr('special-price'));
	            wholesalePrice = parseInt($('.price-info-'+id).first().attr('price'));

	            if( specialMinUnit > 0){
	                if( specialMinUnit <= minUnit ){
	                    PRICE = specialMinUnit * specialPrice;
	                }else {
	                    PRICE = minUnit * wholesalePrice;
	                }
	            }  else{
	                PRICE = minUnit * wholesalePrice;
	            }

	            showPrice = formatPrice(PRICE);
	            $('#hidden-total-price-'+id).text(PRICE);
	            $('#total-price-'+id).text(showPrice);
	        })

	        $('.ni').on('change', function(){
	            id = $(this).attr('data-dir');
	            val = parseInt($('.numberInput-'+id).val());
	            if(val){
	                setPriceOnQtyChange(id, val);
	            }else{
	                $('.numberInput-'+id).val(1);
	            }
	        })

	        $('.up').click(function(){
	            id = $(this).attr('data-dir');
	            val = parseInt($('.numberInput-'+id).val())+1;
	            setPriceOnQtyChange(id, val);
	        })

	        $('.down').click(function(){
	            id = $(this).attr('data-dir');
	            val = parseInt($('.numberInput-'+id).val())-1;
	            setPriceOnQtyChange(id, val);
	        })

	        function setPriceOnQtyChange(id, val){
	            var MIN_UNIT = 1; // lowest value of unit available
	            var MAX_UNIT = getMaxUnit(id); // highest value of unit available
	            if(val != null && val >= MIN_UNIT && val <= MAX_UNIT)
	            {
	                setPrice(id, val);
	            }
	            else if(val < MIN_UNIT){
	                setMinPrice(id);
	            }
	            else if (val > MAX_UNIT) {
	                setMaxPrice(id);
	            }
	        }

	        function setMinPrice(id){
	            qty = 1
	            $('.numberInput-'+id).val(qty);
	            price = $('.price-info-'+id).first().attr('price');
	            if(price != 0){
	                showPrice = formatPrice(price);
	                $('#total-price-'+id).text(showPrice);
	            }
	        }

	        function setMaxPrice(id){
	            qty = $('.price-info-'+id).last().attr('to-unit');
	            price = $('.price-info-'+id).last().attr('price');
	            $('.numberInput-'+id).val(qty);
	            if(price != 0){
	                totalPrice = calculateTotalPrice(price, qty);
	                $('#hidden-total-price-'+id).text(totalPrice);
	                $('#total-price-'+id).text(formatPrice(totalPrice));
	            }
	        }

	        function setPrice(id,qty){
	            $('.numberInput-'+id).val(qty);
	            price = getPrice(id, qty);
	            if(price != 0){
	                totalPrice = calculateTotalPrice(price, qty);
	                $('#hidden-total-price-'+id).text(totalPrice);
	                $('#total-price-'+id).text(formatPrice(totalPrice));
	            }
	        }


	        function getMaxUnit(id){
	            maxUnit = $('.price-info-'+id).last().attr('to-unit');
	            return maxUnit;
	        }

	        function getPrice(id, qty){
	            var price;
	            var specialMaxUnit = $('.price-info-'+id).attr('special-unit');
	            var specialMinUnit = $('.price-info-'+id).attr('special-funit');
	            var specialPrice = $('.price-info-'+id).attr('special-price');
	            if( specialMinUnit <= qty && qty <= specialMaxUnit ){
	                price = specialPrice;
	            }else{
	                $('.price-info-'+id).each(function(){
	                    var maxUnit = $(this).attr('to-unit');
	                    var minUnit = $(this).attr('from-unit');
	                    var wholesaleprice = $(this).attr('price');
	                    if( minUnit <= qty && qty <= maxUnit){
	                        price = wholesaleprice;
	                        return false;
	                    }else{
	                        return true;
	                    }
	                })
	            }

	            return price;
	        }

	        function formatPrice(price){
	            price = number_format((price/100),2);
	            return price;
	        }

	        function calculateTotalPrice(price, qty){
	            tp = price * qty;
	            return tp;
	        }

	        function number_format(number, decimals, dec_point, thousands_sep) {
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
	    });
    </script>

<script type="text/javascript">
$(document).ready(function() {
		$('.btn-number2').click(function (e) {
			e.preventDefault();
			console.log("pass");
			fieldName = $(this).attr('data-field');
			type = $(this).attr('data-type');
			pid = $(this).attr('data-dir');
			var input = $("#numberInput-"+pid);
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
			
			/*qty = $('.quantity2').val();
			fre_qty = $('#free_delivery_with_purchase_qty').val();
			del_price = $('#mydelprice2').val();
			fre_qty = parseInt(fre_qty);
			var amount = 0;
			/*retail_price = parseFloat($('.retail_price').attr('rprice'));
			var counter = $("#counter").val();
			
			for (var i = 1; i <= parseInt(counter); i++) {
				var funit = $("#funit" + i).val();
				var unit = $("#unit" + i).val();
				var price = $("#wprice" + i).val();
				if(parseInt(qty) >= parseInt(funit) && parseInt(qty) <= parseInt(unit)){
					//console.log(amount);
					amount = parseFloat(price * qty).toFixed(2);
				}	
			}		 
			$('.amt2').html(accounting.formatMoney(amount,""));
				if(fre_qty==0){
					price = $('.del_price').html();
				} else {
					if(qty < fre_qty){
						$('.delprice2').html(del_price);
						price = $('.delprice2').html();
					} else {
						price = "0.0";
						$('.delprice2').html("0.00");
					}
				}
				total = (parseFloat(amount)+parseFloat(price)).toFixed(2);
				//console.log(total);
				$('.total2').html(accounting.formatMoney(total,""));	*/		
		});	

    $( ".price" ).on('click',function() {
		amount = ($('.amt').text());
		amount = (accounting.unformat(amount));
		$('.price').removeClass("active");
		$(this).addClass('active');
		price  = ($(this).attr('price'));
		price  = accounting.unformat(price);
		total  = (parseFloat(amount) + parseFloat(price));
		$('.del_price').html(accounting.formatMoney(price,""));
		$('.total').html(accounting.formatMoney(total,""));
    });

    currency = "{{ $currency }}";

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
	if(path.includes('public'))
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
        $('.cart-info').text(data[1]+' ('+number_format(price/100,2)+' '+ currency+ ') '+" Successfully added to the cart");
        if(data[0] < 1)
        {
            $('.cart-link').text('Cart is empty');
            $('.badge').text('0');
        }
        else {

            $('.cart-link').text('View Cart');
            $('.badge').text(data[0]);
        }
      }
    });
  });	
	
	$('.cartBtn2').click(function(e){
		e.preventDefault();
		var price = 0;
		var amount = 0;
		var pid = $(this).siblings('input[name=id]').val();
		/*retail_price = parseFloat($('.retail_price').attr('rprice'));*/
		var counter = $("#counter-" + pid).val();
		var qty = $(".numberInput-"+pid).val();
		for (var i = 1; i <= parseInt(counter); i++) {
			var funit = $("#funit" + i + "-" + pid).val();
			var unit = $("#unit" + i + "-" + pid).val();
			//var price = $("#wprice" + i).val();
			if(parseInt(qty) >= parseInt(funit) && parseInt(qty) <= parseInt(unit)){
				//console.log(amount);
				price = $("#wprice" + i + "-" + pid).val();
			}	
		}				
		//var price = $(this).siblings('input[name=price]').val();
		if(price == 0){
			price = $("#rprice" + pid).val();
		}		
		/*console.log(price);
		console.log($(this).siblings('input[name=id]').val());
		console.log(qty);*/
		$.ajax({
			url: url,
			type: "post",
			data: {
				'quantity':$(".numberInput-"+pid).val(),
				'id': $(this).siblings('input[name=id]').val(),
				'price': price
			},
			success: function(data){
				$('.alert').removeClass('hidden').fadeIn(2000).delay(7000).fadeOut(2000);
				$('.cart-info').text(data[1]+' ('+ currency + ' ' + number_format(price/100,2)+ ') '+" Successfully added to the cart");
				if(data[0] < 1)
				{
				    $('.cart-link').text('Cart is empty');
				    $('.badge').text('0');
				}
				else {
				    $('.cart-link').text('View Cart');
				    $('.badge').text(data[0]);
				}
			}
		});
	});

	$('.all-filter').click(function(e){
		e.preventDefault();
		$(".all-filter-fa").show();
		var merchant_id = $('#oshop_id').val();
		var oshop_id = $('#real_oshop_id').val();
		var tab_product = $('#tab-list li.active').attr('rel');
		var url = '/oshop/all_query';

		$.ajax({
			url: url,
			type: "post",
			data: {
				'mid':merchant_id,
				'id':oshop_id,
				'tab_product': tab_product
			},
			success: function(data){
				//console.log(data);
				$(".all-filter-fa").hide();
				$('#content-'+tab_product).html(data);
			}
		});
	});

	$('.category-filter').click(function(e){
		e.preventDefault();
		var oshop_id = $('#real_oshop_id').val();
		var category_id = $(this).attr('rel');
		$(".category-filter-fa-" + category_id).show();
		var tab_product = $('#tab-list li.active').attr('rel');
		var url = '/oshop/category_query';

		$.ajax({
			url: url,
			type: "post",
			data: {
				'id':oshop_id,
				'category_id':category_id,
				'tab_product': tab_product
			},
			success: function(data){
				//console.log(data);
				$(".category-filter-fa-" + category_id).hide();
				$('#content-'+tab_product).html(data);
			}
		});
	});

	$('.subcat-filter').click(function(e){
		e.preventDefault();
		var oshop_id = $('#real_oshop_id').val();
		var sub_category_id = $(this).attr('rel');
		$(".subcat-filter-fa-" + sub_category_id).show();
		var tab_product = $('#tab-list li.active').attr('rel');
		var url = '/oshop/sub_category_query';

		$.ajax({
			url: url,
			type: "post",
			data: {
				'id':oshop_id,
				'sub_category_id':sub_category_id,
				'tab_product': tab_product
			},
			success: function(data){
				$(".subcat-filter-fa-" + sub_category_id).hide();
				$('#content-'+tab_product).html(data);
			}
		});
	});
		
	$('.subcatlevel-filter').click(function(e){
		e.preventDefault();
		var oshop_id = $('#real_oshop_id').val();
		var subcatlevel_id = $(this).attr('rel');
		$(".subcatlevel-filter-fa-" + subcatlevel_id).show();
		var tab_product = $('#tab-list li.active').attr('rel');
		var url = '/oshop/subcatlevel2_query';

		$.ajax({
			url: url,
			type: "post",
			data: {
				'id':oshop_id,
				'subcatlevel_id':subcatlevel_id,
				'tab_product': tab_product
			},
			success: function(data){
				//console.log(data);
				$(".subcatlevel-filter-fa-" + subcatlevel_id).hide();
				$('#content-'+tab_product).html(data);
			}
		});
	});	
	
	$('.subcatlevel3-filter').click(function(e){
		e.preventDefault();
		var oshop_id = $('#real_oshop_id').val();
		var subcatlevel_id = $(this).attr('rel');
		$(".subcatlevel3-filter-fa-" + subcatlevel_id).show();
		var tab_product = $('#tab-list li.active').attr('rel');
		var url = '/oshop/subcatlevel3_query';

		$.ajax({
			url: url,
			type: "post",
			data: {
				'id':oshop_id,
				'subcatlevel_id':subcatlevel_id,
				'tab_product': tab_product
			},
			success: function(data){
				//console.log(data);
				$(".subcatlevel3-filter-fa-" + subcatlevel_id).hide();
				$('#content-'+tab_product).html(data);
			}
		});
	});	
	
	$('.brand-filter').click(function(e){
		e.preventDefault();
		var oshop_id = $('#real_oshop_id').val();
		var brand_id = $(this).attr('rel');
		$(".brand-filter-fa-" + brand_id).show();
		var tab_product = $('#tab-list li.active').attr('rel');
		var url = '/oshop/brand_query';

		$.ajax({
			url: url,
			type: "post",
			data: {
				'id':oshop_id,
				'brand_id':brand_id,
				'tab_product': tab_product
			},
			success: function(data){
				//console.log(data);
				$(".brand-filter-fa-" + brand_id).hide();
				$('#content-'+tab_product).html(data);
			}
		});
	});	
	
	$('.color-filter').click(function(e){
		e.preventDefault();
		var oshop_id = $('#real_oshop_id').val();
		var color_id = $(this).attr('rel');
		$(".color-filter-fa").show();
		var tab_product = $('#tab-list li.active').attr('rel');
		var url = '/oshop/color_query';

		$.ajax({
			url: url,
			type: "post",
			data: {
				'id':oshop_id,
				'color_id':color_id,
				'tab_product': tab_product
			},
			success: function(data){
				//console.log(data);
				$(".color-filter-fa").hide();
				$('#content-'+tab_product).html(data);
			}
		});
	});	
})
</script>
@stop
