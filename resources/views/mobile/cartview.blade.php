{{-- THIS IS MOBILE CART VIEW. --}}
<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\IdController;
$deliver_total = 0; 
Session::forget('smm_opengraph'); 
$max_oc=0;
if(Auth::check()){

	try {
		$max_oc=UtilityController::ocredit()['ocredit'];
		$max_oc=floor($max_oc/100);
	} catch (\Exception $e) {
		
	}
}

$subscription = false;
 if(isset($merchant_id)){
	 $subscription = true;
 }
if(isset($isstation)){
  if($isstation == 1){
	  unset($isstation);
  }
} 

?>							

@extends("common.default")
@section('content')
@def $currency = \App\Models\Currency::where('active', 1)->first()->code
@def $gst_tax_rate= \App\Models\Globals::first()->gst_rate
<div class="container">
	<style type="text/css">
		.options{
			color: #34dabb;
		}
		.vcenter {
		    display: inline-block;
		    vertical-align: middle;
		    float: none;
		}
		.grayout {
		    opacity: 0.5; /* Real browsers */
		    filter: alpha(opacity = 50); /* MSIE */
		}
		#other_banks_mobile_list{
			max-height: 200px;
			overflow-x: hidden;
			margin-top: 20px;
			list-style: none;
			border:1px solid #d3d3d3 ;
		}
		.fpx_mobile_bank_selector{
			/*padding: 5px;*/
			height: 30px;
			text-decoration: none;
			list-style: none;
			font-size: 1.2em;
			display: block;
			margin-left:-20px;

		}
		.active_method{
			/*background-color:#2bd52b;*/
			border: 2px solid #2bd52b;
		}
		.fpx_mobile_bank_selector:hover{
			background:#01b18b;
			color: white;
		}
		.fpx{
			bac40		}
    @40dia only screen and (max-width: 500px) {
	    .modal_responsive{
	        width: 100% !important;
	    }

    }
	</style>

	{{-- Hidden Inputs --}}
	<input type="hidden" name="refno" value="{{$refNo}}" id="refno">
	<input type="hidden" id="fpx_mobile_dropdown_toggler" value="0">
	{{-- Hidden Form Area for FPX --}}
	<form id="fpx_form_id" action="" method="POST">
		{{-- To be populated after pressing FPX --}}
		{{-- <input type="hidden" name="fpx_buyerBankId" value="TEST0021"> --}}
	</form>
	{{-- Row for the header --}}
	<div class="row">
		<div class="col-xs-5"><strong style="font-size: 1.5em;" class="pull-left">View Cart</strong></div>
		<div class="col-xs-2"><strong style="font-size: 1.5em;" class="pull-left">Qty.</strong></div>
		<div class="col-xs-5"></div>
	</div>
	{{-- Display the cart products --}}
	@if(Cart::totalItems() < 1)
	<span class="text-info">Your cart is empty.</span>
	@else
		@foreach($merchantsAndProducts as $key => $merchants)
			@foreach($merchants as $product)
				{{-- Php --}}
				<?php
					/*If type is return set a demo pic*/
					if ($product->mode == "rfee") {
								$src=asset('placecards/cartreturnplaceholder.png');
							}else{
								$src="images/product/".$product->parent_id."/".$product->image;
					} 
				?>
				{{-- Ends --}}
				{{-- THE <!-- --> below are IMPORTANT DO NOT REMOVE. REMOVING IT WILL BREAK THE LAYOUT  trust me! --}}
				<div class="row">
					<div class="col-xs-5  vcenter">
						<a href="{{url('productconsumer',$product->parent_id)}}" target="_blank">
							<img src="{{$src}}" class="img-rounded img-responsive">
						</a>
					</div><!--
					--><div class="col-xs-2 vcenter">

					<strong class="pull-right" style="font-size: 1.2em;">{{$product->quantity}}</strong>
					</div><!--
					--><div class="col-xs-5 vcenter"><strong style="font-size: 1.2em;">{{$currency}}&nbsp;{!! number_format((float)(($product->quantity * $product->price/100)), 2) !!}</strong></div>
				</div>
			@endforeach
			{{-- Second ForEach Loop --}}
		@endforeach
		{{-- First ForEach Loop --}}
		{{-- Showing total opencredit and grosstotal --}}
		<div class="row">
			<div class="col-xs-3">
				{{-- Offset --}}
			</div>
			{{-- Total --}}
			<div class="col-xs-5"><strong class="pull-right">Total</strong></div>
			<div class="col-xs-4"><span class="pull-right" style="">{{$currency}}&nbsp;{{number_format($grandtotal,2)}}</</span></div>
		</div>
		{{-- OpenCredit --}}
		<div class="row">
			<div class="col-xs-3">
				{{-- Offset --}}
			</div>
			{{-- Total --}}
			<div class="col-xs-5"><strong class="pull-right" style="vertical-align: center;">OpenCredit</strong></div>
			<div class="col-xs-4"><input type="text"
										name="ocredit_part" class="form-control"
										value="0" 
										id="ocredit_part" min="0" max="{{$max_oc}}"/></div>
		</div>
		{{-- Gross Total --}}
		<div class="row">
			<div class="col-xs-3">
				{{-- Offset --}}
			</div>
			{{-- Total --}}
			<div class="col-xs-5"><strong class="pull-right">Gross Total</strong></div>
			<div class="col-xs-4"><span class="pull-right">{{$currentCurrency}}&nbsp;<span class="grossTotal">{{number_format($grandtotal,2)}}</span></span></div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<button href="#" class="btn  btn-lg btn-block btn-primary pull-right confirm-onboard"
					id="checkout" type="button">
					<span class="glyphicon glyphicon-check"></span>
					Checkout</button>
			</div>
		</div>
		{{-- Space --}}
		{{-- Pills --}}
		<div class="row" style="margin-top: 10px;margin-bottom:0">
			<div class="col-xs-4 card">
				<a href="#"><img class="img-responsive text-center"
				src="{{asset('css/logos/cart_payment_card_cropped.png')}}"
				style="height:30px;width:70px;"></a>
			</div>
			<div class="col-xs-4 fpx">
				<a href="javascript:void(0)" class="mobile_click_fpx_show">
				    <img  class="img-responsive text-center"
					src="{{asset('fpxlogo/Color/Standard_color-01.png' )}}"
					style="height:30px;width:70px;" alt="FPX">
				</a>
			</div>
			<div class="col-xs-4 jompay">
				<a href="javascript:void(0)" class="mobile_click_fpx_show">
				    <img  class="img-responsive text-center"
					src="{{asset('jompay/jompay.jpg' )}}"
					style="height:30px;width:30px;" alt="FPX">
				</a>
			</div>
		</div>
		{{-- FPX HIDDEN --}}
		<span  class="" style="margin-top: 1px !important;">
		<div class="row ">
			<div class="col-xs-12">
				<ul id="other_banks_mobile_list"
				style="margin-top:10px"></ul>
			</div>
		</div>
		</span>
		<div class="row" style="margin-top: 5px;">
		
			<div class="col-xs-12" style="font-size:1.2em; font-weight:bold;">
				<p class="summary text-right">Total&nbsp;&nbsp;&nbsp;{{$currentCurrency}}&nbsp;
							<span class='totalPrice totalPrice2'>
							{!! number_format($grandtotal, 2) !!}</span></p>
						<p class="summary text-right">Surcharge&nbsp;&nbsp;&nbsp;{{$currency}}&nbsp;0.00</p>
						<p align="summary " class="text-right"
							>
							Final&nbsp;Total&nbsp;&nbsp;&nbsp;{{$currentCurrency}}&nbsp;<span class='totalPrice totalPrice2'>
							{!! number_format($grandtotal, 2) !!}</span></p>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				 <button type="button" rel_form="" id='makePayment'
						class="btn btn-danger btn-lg btn-block  pmode" style="">
						<span class="glyphicon glyphicon-ok"></span> &nbsp;Pay</button>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<p style="text-align: center;"><i><strong>*Disclaimer:</strong> Upon rounding errors, OpenSupermall and it's Merchant reserve the right to revoke the aforesaid deal or transaction.</i></p>
			</div>
		</div>

	@endif

</div>
<div class="modal fade" id="onboardModal" role="dialog"
	style="background-color:white; opacity: 0.93; filter: alpha(opacity=93)">
	<div class="modal-dialog " role="document">

		<div class="modal-body" id="onboardModalBody">
		{{-- Content goes here. --}}
		</div>

	</div>
</div>
@stop
@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4nEeGNWNQvpMt-eEud4CENM34fI99jAU "></script>

<script type="text/javascript">
	$('.mobile_click_fpx_show').click(function(){
		var $info_toggler=$('#fpx_mobile_dropdown_toggler').val();
		if ($info_toggler==0) {
		$('.fpx_mobile_dropdown').show(300);
		// $('.mobile_arrow').removeClass('fa-angle-down');
		
		// $('.mobile_arrow').addClass('fa-angle-up');
		$('#fpx_mobile_dropdown_toggler').val(1);
		}else{
		$('.fpx_mobile_dropdown').hide(100);
		// $('.mobile_arrow').addClass('fa-angle-down');
		
	
		// $('.mobile_arrow').removeClass('fa-angle-up');
		$('#fpx_mobile_dropdown_toggler').val(0);
		}
	});

function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function string_to_int(argument) {
	res=argument.split(".");
}
$(function() {
	

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
	$('#ocredit_part').number(true, 2);
    $('.ni').on('change', function(){
    	item = $(this).attr('data-dir');
    	rel = $(this).attr('rel');
    	val = $('.numberInput-'+item).val();
    	if (val != null)
    	{
	    	$('.numberInput-'+item).val(parseFloat(val));
	    	totalquantity = $('.numberInput-'+item).val();
	    		calculateSum(item, totalquantity,rel);
    	}
    })

	$(document).delegate( '#redirectstation', "click",function (event) {
		var station_id= $('#station_ids').val();

		var url = JS_BASE_URL + '/redirectstation/'+ station_id;

		$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			success: function (data) {
		
				window.location.replace(JS_BASE_URL + "/edit_station");
		  	}
		});
	});	
	
    $('.up').click(function(){
    	item = $(this).attr('data-dir');
    	rel = $(this).attr('rel');
    	var available=$(this).attr('data-available');
    	val = $('.numberInput-'+item).val();
    
    	if (parseInt(val) < parseInt(available)) {
	    	$('.numberInput-'+item).val(parseFloat(val)+1);
	    	totalquantity = $('.numberInput-'+item).val();
			calculateSum(item, totalquantity,rel);
    	}else{
    		toastr.warning("You have reached the maximum available quantity for this product.");
    	}
    })

    $('.down').click(function(){
    	item = $(this).attr('data-dir');
    	rel = $(this).attr('rel');
    	val = $('.numberInput-'+item).val();
    	newval = parseFloat(val)-1;

    	if ( newval < 1) {
    		$('.numberInput-'+item).val('1');
    	} else {
			$('.numberInput-'+item).val(parseFloat(val)-1);
    	}
    	totalquantity = $('.numberInput-'+item).val();
		calculateSum(item, totalquantity,rel);
    })

    function calculateSum(item, quantity,rel,verbose = 1) {
	    var controllerPath = JS_BASE_URL+"/cartSum";
        $.ajax({
			type: "POST",
			url: controllerPath,
			data: { id : item, quantity : quantity }, // serializes the form's elements.
			success: function(data) {
			$.ajax({
				type:'GET',
				url:JS_BASE_URL+"/cart/total/items",
				success:function(r){
					$('.badges').text(r);
				}
			});


			// Update the delivery.
			$.each(data.delivery,function(index,value){
				var content="<table class='table-noborder table table-striped'>";
				console.log(value);
				for (var i = value.length - 1; i >= 0; i--) {
					content+="<tr><td>"+value[i][0]+
						"&nbsp;</td><td>{{$currentCurrency}}&nbsp;"+value[i][1]+"</td></tr>";
				}
				content+="</table>";
				$('#popoverData_'+index).attr("data-content",content);
			});


			// Notify
			$.each(data.notify,function(index,value){
				toastr.warning("Only "+value+" of product "+index+" left. Please reduce the quantity.");
			});

	           	// Change Cart Status
	           	$('.totalPrice').text(number_format(data.total,2));
	           	$('.grossTotal').text(number_format(data.total,2));
	           	$('#Total').val(parseFloat(data.total));
	           	$.each(data.status,function(index,value){
	           		// console.log(index);
	           		var subTotal=number_format(data.status[index].total,2);
	           		var delivery=number_format(data.status[index].delivery,2);
	           		$('#subTotal-'+index).text(subTotal);
	           		$('#totalDeliveryForMerchant-'+index).text(delivery);
	           		$.each(data.status[index].products,function(i,v){
	           			$('.eachPriceShow-'+i).text(number_format(data.status[index].products[i],2));

	           		});

	           	});
	           	$('.showSpecialMessage').each(function(a,b){
	           		$(b).text("");
	           	});
	           	if (verbose == 1) {
		           	$.each(data.adjustments,function(a,b){
		           		// $('#showSpecialMessage-'+a).text("Adjustment of MYR "+data.adjustments[a]+" applied.");
		           	});
		           	toastr.info("Cart successfully updated");
	           	}

	           	
				var ocredit_part=$('#ocredit_part').val();
				if (ocredit_part<0) {ocredit_part=Math.abs(ocredit_part);}
				if (ocredit_part=='NaN') {ocredit_part=0;}
			}
		});



	}
	calculateSum(0,0,0,0);
		var map;
		
		function initialize() {
				var lati = $("#latitude").val();
				var longi = $("#longitude").val();
			  var mapProp = {
				center:new google.maps.LatLng(lati,longi),
				zoom:13,
				mapTypeId:google.maps.MapTypeId.ROADMAP
			  };
			  map=new google.maps.Map(document.getElementById("map"),mapProp);
		}
		// The line below is important. dont delete even though its
		// google.maps.event.addDomListener(window, 'load', initialize);
	
        currency = $('#currency option:selected').text();
        $('.showCurrency').text(currency);

        $('#currency').on('change', function(){
            currency = $('#currency option:selected').text();
            $('.showCurrency').text(currency);
        })

        path = window.location.href;
        var target_path;
        target_path = '{{url("/")}}/';
        $('.select2-container').attr('style','width:100% !important');

        $('#countrySelect').on('change',function(){
            country_code = $(this).val();
            url = target_path+'getState';
            $.post(url, {country_code:country_code}, function(data){
                $('#stateSelect').prop('disabled', false);
                $.each(data, function(key, element) {
                $('#stateSelect').append("<option value='" + key+"'>" + element + "</option>");
                });
            });
        })
        $('#ocredit_part').change(function(){
		// Update grossTotal
		var total=$('#Total').val();
		var oc= $('#ocredit_part').attr('max');
		epsilon=0.01;
		var ocredit_part=$(this).val();
		if (ocredit_part<0) {ocredit_part=Math.abs(ocredit_part);}
		if (ocredit_part=='NaN') {ocredit_part=0;}
		var max = $('#ocredit_part').attr('max');
		@if(Auth::check())
		var message="You don't have enough OpenCredit!";
		@else
		var message="Please login to use OpenCredits";
		@endif
	
		if (parseFloat(ocredit_part)>parseFloat(max) && ocredit_part!=0) {
			toastr.info(message);
		}	
		// console.log(parseFloat(total));
		// console.log(parseFloat(ocredit_part));
		total=parseFloat(total).toFixed(2);
		ocredit_part=parseFloat(ocredit_part).toFixed(2);
		// console.log(total+"|"+ocredit_part);
		var grossTotal=parseFloat(total)- parseFloat(ocredit_part);
		// console.log(grossTotal);
		grossTotal=number_format(grossTotal,2);
		// console.log(grossTotal);
		$('.grossTotal').text(grossTotal);

	});
        $('#stateSelect').on('change',function(){
            state_code = $(this).val();
            url = target_path+'getCity';
            $.post(url, {state_code:state_code}, function(data){
                $('#citySelect').prop('disabled', false);
                $.each(data, function(key, element) {
                $('#citySelect').append("<option value='" + key+"'>" + element + "</option>");
                });
            });
        });

		function addMarkerWithWindow(data, coordinate, map, id) {
			var infowindow = new google.maps.InfoWindow({
				content: data.company_name + '<br>' + data.line1 + '<br>' + data.line2 + '<br>' + data.line3 + '<br>' + data.line4
			});

			var marker = new google.maps.Marker({
				map: map,
				position: coordinate			
			});

			google.maps.event.addListener(marker, 'click', function (e) {
				infowindow.open(map, marker);
				$("#pick_station").val(id);
				$("#stationpicked").val(id);
				$("#picktext").html("Your Selected Station: <b>" + data.company_name + "</b>");
				$("#picktexth").show();
				$("#pickh").html(data.company_name);
				//alert("id" + id);
			});
		}

		$('#unpick').on('click',function(){
			$("#pick_station").val(0);
			$("#picktext").html("Your Selected Station: ");
			$("#picktexth").hide();
			$("#pickh").html("");			
		});

		
        $('#pick').on('click',function(){
			var url = "{{url('payment/get_stations')}}";
			// alert("yey");
			
			var urlbase = $('meta[name="base_url"]').attr('content');

			$.ajax({
				type: "GET",
				url: url,
				dataType: 'json',
				success: function (data) {
				
					if(data.length > 0){
						$("#myModal").modal("show");
						for(i=0;i<data.length;i++){
							var latlng = new google.maps.LatLng(data[i].latitude, data[i].longitude);
							addMarkerWithWindow(data[i],latlng,map, data[i].id);
							/*var marker = new google.maps.Marker({
									position: latlng,
									title: data[i].company_name,
									draggable: true,
									map: map
							});	*/						
						}
					} else {
						$('#pickalert').removeClass('hidden').fadeIn(3000);
					}
				}
			});           
        });

        $('#saveUser').click(function(e) {
            e.preventDefault();
            var controllerPath = target_path+"saveUser";
            $.ajax({
               type: "POST",
               url: controllerPath,
               data: $("#regForm").serialize(),
               success: function(data)
               {
                   if(data=='success')
                   {
                        $('#alert, .success-mg').removeClass('hidden').show().addClass('alert-success');
                        $('.fail-mg').hide();
                   }else if(data=='fail'){
                        $('#alert, .fail-mg').removeClass('hidden').show().addClass('alert-danger');
                        $('.success-mg').hide();
                   }else {
                        $('#alert, .fail-mg').removeClass('hidden').show().addClass('alert-danger').text(data);
                        $('.success-mg').hide();
                   }
               }
             });
        });

        $('#saveAddress').click(function(e) {
            e.preventDefault();
            var controllerPath = target_path+"saveAddress";
            $.ajax({
               type: "POST",
               url: controllerPath,
               data: $("#addressForm").serialize(), // serializes the form's elements.
               success: function(data)
               {
                   alert(data); // show response from the php script.
               }
             });
        });

        $('#editShipping').click(function(e){
            e.preventDefault();
            if($('#shippingTextarea').hasClass('hidden')){
                $('#shippingTextarea').removeClass('hidden').show();
                $('.shipping-address').hide();
                $(this).text('cancel edit');
            }else{
                $('#shippingTextarea').addClass('hidden').hide();
                $('.shipping-address').show();
                $(this).text('edit');
            }
        })
        // This code should deal with form 
        // $('#paymentForm').submit(function(e) {
        // 	// alert("	w");
        // 	e.preventDefault();
        // });
        // Ends

        $('.confirm-onboard').click(function(e){
            e.preventDefault();
            $(this).prop('disabled',true);
            // Check for onboarding required
	
            var url=JS_BASE_URL+"/onboarding/required";
            var onboarding_url=JS_BASE_URL+"/onboarding/init";
            var type="GET";
            $.ajax({
            	url:url,
            	type:type,
            	success:function(r){
            		if (r==1) {
            			$('#onboardModal').modal('show').find('.modal-body').load(onboarding_url);
            		}
            		if (r==2) {
            			var address_modal=JS_BASE_URL+"/cart/new/address";
        	$('#onboardModal').modal('show').find('.modal-body').load(address_modal);
            		}
            		if (r==-1) {
            			var ocredit_part=$('#ocredit_part').val();
            			var ref_no= $('#refno').val();
            			var address_id=$('#address_id').val();
            			if (!ocredit_part) {ocredit_part=0;}
            			var checkout_url=JS_BASE_URL+"/pay/"+ref_no+"/by/ocredit/"+ocredit_part+"/aid/"+address_id;
            			$.ajax({
            				url:checkout_url,
            				type:type,
            				success:function(r){
            					if (r.status=="success") {
            						if (r.short_message==0 || r.short_message==3) {
            							toastr.info('Your order has been paid via OpenCredit. Redirecting');
            							window.location.href=r.redirect;
            							$('.totalPrice2').text(0);
            						}
            						if (r.short_message==1 || r.short_message==-3 || r.short_message==-2 || r.short_message==-11) {
            						
            							$('#checkout').attr('disabled',true);
            							$('.pmode :input').attr('disabled',false);
            							$('.pmode').removeClass('grayout');
            							$('#ocredit_part').attr('disabled',true);
            							$('.totalPrice2').text(r.amount_due);


            							/*New Sorting for Bank. bank_kv is sorted*/
            							fpx_bank="";
            							for (code in r.fpx_bank_kv){
            								if (r.fpx_bank[code] != "undefined") {
            									name=r.fpx_bank_kv[code];
            									val=code;
												bank="<li><a href='javascript:voidd(0);' class='fpx_mobile_bank_selector' value='"+code+"'>"+name;
            									switch (r.fpx_bank[code]) {
													case 'A':
            										fpx_bank+=bank+"</a></li>";
													break;
            										case 'B':
            										fpx_bank+=bank+" (Offline)</li>";
													break;

												}
            								}  
            								else{
            									// console.log("Missing Bank: "+code)
            								}          								
            							} 
            							if (r.fpx_bank.length!=0) {
            								$('.fpx').addClass('active_method');
            								$('.jompay').addClass('grayout');
            								$('.card').addClass('grayout');
            								$('#other_banks_mobile_list').append(fpx_bank);

            							}else{
            								$('.fpx').addClass('grayout');
            								$('#bank_error_fpx').text("Payment by Internet Banking is not available. Please use other methods.");
            								$('.payment-errors').show();
            							}
            							

            							
            							 if (r.short_message==1) {
            							
            							// Enable Payment
            								toastr.info('OpenCredit deducted. Pay remainder via other payment methods');
            							}

            							if (r.short_message==-3) {
            								toastr.info("Checkout done. Please pay"	);
            								$('.pmode').focus();
            							}
            						}
            					}
            					if (r.status=="failure") {
            						if (r.short_message == -9) {
            							$.each(r.long_message,function(index,value){
						           		toastr.warning("Only "+value+" of product "+index+" left. Please reduce the quantity.",{timeOut: 5000});
						           		});
            						}
            						if (r.short_message == -5) {
            							toastr.warning(r.long_message);
            								$('#checkout').attr('disabled',false);

            						}
            						if (r.short_message==-1 || r.short_message==-2) {
            							toastr.warning(r.long_message);
            							     $('.pmode :input').attr('disabled',false)
											$('.pmode').removeClass('grayout');
											$('#checkout').attr('disabled',true);
											$('#ocredit_part').attr('disabled',true);
											$('.totalPrice2').text(r.amount_due);
											// $('#makePayment').attr('disabled',false);
            						}
            						if (r.short_message==-4) {
            							toastr.warning(r.long_message);
            						}

            					}
            				}
            			});
            			// location.reload();

            			// $('#paymentForm').submit();

            		}
            	}
            });
      });	
        // CHange Address
        $('#editShipping').click(function(){
        	var address_modal=JS_BASE_URL+"/cart/new/address";
        	$('#onboardModal').modal('show').find('.modal-body').load(address_modal);
        });
	});
</script>
{{-- Code to check if Onboard required --}}
<!-- Code to ajax post the onboarding form-->
<script type="text/javascript">
  $(document).ready(function(){
  	$('.popoverData').popover({
  		html:true
  	});
  	$('#onboard').click(function(){
  		    var url="{{url()}}"+"/onboarding/save";
    var type="POST";
    $.ajax({
      url:url,
      type:type,
      success:function (response) {
          if (response.status=="success") {
              
          }
      }
    });
  	});

  });
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#other_banks_mobile').change(function(){
			$('input').removeAttr('checked');
				// $('input #paymentid').val()=$('input[name=payment_id]').val();
			// Refresh the jQuery UI buttonset.                  
			// $( "inp" ).buttonset('refresh');
		});
		// Keep changing value
		$('input[name=payment_id]').change(function(){
					var payment_id=$('input.pid').val();
					// $('input#paymentid').attr('value',payment_id);
	
		});

	});
	// Init disable all
	$('.pmode :input').attr('disabled',true)
	$('.pmode').addClass('grayout');
	$('.pmode').attr('disabled',true).addClass('grayout');
	$('#makePayment').attr('disabled',true);
	// OCredit UI
	$('.pid').change(function() {
		// body...
		$('#makePayment').attr('disabled',false);
	});
if ($('input:radio.pid').is(':checked')) {
	$('.none').attr('selected',true);
}
$("#other_banks_mobile").select2({
  minimumResultsForSearch: Infinity
});

// $('.fpx_mobile_bank_selector').click(function(){
$('body').on('click','.fpx_mobile_bank_selector',function(){
	
	$('#makePayment').attr('disabled',true);
	$('input:radio.pid').attr('checked',false);
	var bank=$(this).attr('value');
	var data={
		'bank':bank,
		'refno':$('#refno').val().toString()
	};
	var url="{{url('fpx/checksum')}}";
	$.ajax({
		url:url,
		type:'POST',
		data:data,
		success:function(r){
			if (r.status=="success") {
				// Fill in FPX.
				var fpx_html="";
            							
				$("#fpx_form_id").attr('action',r.fpx_post_url);
				for (key in r.fpx_form) {
					fpx_html+="<input type='hidden' name='"+key+"' value='"+r.fpx_form[key]+"' >";
				};
				// console.log(r.fpx_form.fpx_txnAmount);
				if (r.fpx_form.fpx_txnAmount>30000 || r.fpx_form.fpx_txnAmount <1) {
					$('#fpx_error_message_amount').css('visibility','visible');
				}
				else{
					$('#fpx_form_id').append(fpx_html);
					$('#fpx_error_message_amount').css('visibility','hidden');
					$('#makePayment').attr('disabled',false);
				}
				
			}
		}
	});
});
</script>
<script type="text/javascript">
							$("#makePayment").click(function(){

								var form=$(this).attr('rel_form');
								var form="fpx_form_id";
								if (form=="" || form =="undefined") {
									toastr.info("Please choose a payment method");
								}

								$('#'+form).submit();
							});
						</script>
	
@stop
