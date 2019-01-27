@extends("common.default")

@section("content")
    <div id="loginalert" class="alert alert-danger alert-dismissible hidden alert-notification" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong class='alert_info'>Please Login to make payment. <a href="#"  data-toggle="modal" data-target="#loginModal">Login</a></strong>
    </div>
    <div id="amountalert" class="alert alert-danger alert-dismissible hidden alert-notification" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong class='alert_info'>We cannot Process your order, the amount is too short.</strong>
    </div>	
    <div id="pickalert" class="alert alert-danger alert-dismissible hidden alert-notification" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong class='alert_info'>We cannot Handle your order.</strong>
    </div>		
    <div id="main">
        <!-- rZ5ifY170H0krZwQsXa%P15S -->
        <div class="container">
            <div class="main-container">
                <div class="row payment-area">
                    <div class="col-sm-6">
                        <div class="payment-options box">
                            <strong class="heading">Chose Payment Options</strong>
                            {!! Form::open(array('url'=>'https://www.mobile88.com/ePayment/entry.asp', 'class'=>'payment-form', 'id'=>'paymentForm')) !!}
                            <!-- <form name="ePayment" method='post' action="https://www.mobile88.com/ePayment/entry.asp" class="payment-form"> -->
                                <fieldset>
                                    <div class="radiobtns clearfix">
                                        <div class="checkbox">
                                            <input type="radio" checked value='2' name="card" id="rad">
                                            <label for="rad">
                                                <span class="radlabel">Credit Card</span>
                                                <span class="icon-holder">
                                                    <img src="{{ asset('images/img2.jpg') }}" alt="">
                                                </span>
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <input type="radio" value='6'  name="card" id="rad2">
                                            <label for="rad2">
                                                <span class="radlabel">My Bank 2 U</span>
                                                <span class="icon-holder">
                                                    <img src="{{ asset('images/img3.jpg') }}" alt="">
                                                </span>
                                            </label>
                                        </div>
                                        <!-- <div class="checkbox">
                                            <input type="radio"  name="card" id="rad3">
                                            <label for="rad3">
                                                <span class="radlabel">Credit or Debit card</span>
                                                <span class="icon-holder">
                                                    <img src="{{ asset('images/img4.jpg') }}" alt="">
                                                </span>
                                            </label>
                                        </div> -->
                                    </div>
									<input type="hidden" id="globalvar"  value="{{ $globalvar }}">
									<input type="hidden" id="total"  value="{{ $total }}">
									@if(isset($address->latitude))
                                    <input type="hidden" id="latitude"  value="{{ $address->latitude }}">
                                    @endif
                                    @if(isset($address->longitude))
									<input type="hidden" id="longitude"  value="{{ $address->longitude }}">
                                    @endif
                                    <div class="form-group">
                                        <div class="clearfix">
                                            <label for="cn">Card Number</label>
                                            <span class="icon-holder"><img src="{{ asset('images/icon-card.jpg') }}" height="28" width="46" alt=""></span>
                                        </div>
                                        <input type="text" id="cn" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Name on Card</label>
                                        <input id="name" type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="ed">Expiry Date</label>
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <input id="ed" placeholder="mm" type="text" class="form-control">
                                            </div>
                                            <div class="col-xs-6">
                                                <input placeholder="yy" type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="medium">
                                            <input class="form-control" type="text">
                                        </div>
                                        <span class="cv">CVV/CVV</span>
                                    </div>
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <input type="checkbox" id="check">
                                            <label for="check">Do not save this card for future use</label>
                                        </div>
                                        @if(Auth::check())
                                        <div class='postFields'>
                                            <input type="hidden" name="MerchantCode"  value="{!! $merchantCode !!}">
                                            <input type="hidden" name="RefNo" id='refno'>
                                            <input type="hidden" name="Signature" id='signature'>
                                            <input type="hidden" name="PaymentID" id='paymentid'>
                                            <input type="hidden" name="Amount" value="{!! $total !!}">
                                            <input type="hidden" name="Currency" value="{!! $currency !!}" id='currency'>
                                            <input type="hidden" name="ProdDesc" value="Photo Print" id='prodDesc'>
                                            <input type="hidden" name="UserName" value="{!! Auth::user()->first_name !!}">
                                            <input type="hidden" name="UserEmail" value="{!! Auth::user()->email !!}">
                                            <input type="hidden" name="UserContact" value="{!! Auth::user()->mobile_no !!}">
                                            <input type="hidden" name="Remark" value="great" id='remark'>
                                            <input type="hidden" name="Lang" value="UTF-8" id='lang'>
                                            <input type="hidden" name="ResponseURL" value="{{url('storeResponse')}}" id='responseUrl'>
                                        </div>
                                        @endif
                                    </div>
                                </fieldset>

                           @if(Cart::total() > 0 and Cart::totalItems() > 0 )
								<button id='makePayment' type="submit" name='submit' class="btn btn-block pull-right btn-green">Make Payment</button>
                           @endif 
                              {!! Form::close() !!}

                            <br><br>
                        </div>
                        <p>By placing your order, you agree to OpenSupermall <a href=""  class="privacy_condtions_link">Privacy</a> and <a href="" class="privacy_condtions_link">conditions of use</a></p>
                    </div>
                    <div class="col-sm-6">
                        <div class=" box">
                            @if(Auth::check())
                                <strong class="heading">Shipping and Billing address <a id='editShipping' class="edit">edit</a></strong>
                                <div class="shipping-address">
                                    <strong class="name">{!! Auth::user()->name !!}</strong>
									@if (isset($address))
                                    <address>{!! $address->line1 !!} , {!! $address->postcode !!} </address>
									@endif
                                    <span class="tel">Mobile Number: {!! Auth::user()->mobile_no !!}</span>
                                </div>
                                <div class="hidden col-md-12 shippingTextarea" id='shippingTextarea'>
                                    <form id='addressForm'>
										@if (isset($address))
                                        <div class="form-group">
                                            <label class='sr-only'>country</label>
                                            <select  id='countrySelect' class='form-control' required name='country'>
                                                <option>{!! $user_country->country !!}</option>
                                                @foreach($countries as $country)
                                                <option value='{!! $country->code !!}'>{!! $country->name !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
										@endif
                                        <div class="form-group">
                                            <label class='sr-only'>state</label>
                                            <select disabled='true' id='stateSelect' class='form-control' required name='state'>
                                                <option>choose state</option>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class='sr-only'>city</label>
                                            <select disabled='true' id='citySelect' class='form-control' required name='city'>
                                                <option>choose city</option>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class='sr-only'>post code</label>
                                            <input required value='{!! isset($address)?$address->postcode:" " !!}'
											class='form-control' name="postcode" placeholder='enter postcode'>
                                        </div>
                                        <div class="form-group">
                                            <label class='sr-only'>address</label>
                                            <textarea required class='form-control' name="address" id="" cols="20" rows="6" placeholder='enter address'>
												@if (isset($address))
                                                {!! $address->address !!}
												@endif
                                            </textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class='sr-only'>mobile</label>
                                            <input value='{!! Auth::user()->mobile_no !!}' required class='form-control' name="mobile" placeholder='enter contact number'>
                                        </div>
                                    </form>
                                    <button id='saveAddress' type='submit' class='btn btn-primary pull-right'>Update</button>
                                </div>
                            @else
                            <strong class="heading">Delivery and Billing address</strong>
                            <div class="shipping-address">
                                <div id='alert' class="alert alert-dismissible hidden" role="alert">
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  <strong class='cart-info success-mg hidden'>
                                    Registration Successfull !!
                                    please <a href="#" data-toggle="modal" data-target="#loginModal">Login</a>
                                  </strong>
                                  <strong class='cart-info fail-mg'>
                                    Password not mathced. Try again.
                                  </strong>
                                </div>
                                {!! Form::open(array('id'=>'regForm')) !!}
                                    <div class="form-group">
                                        <label class='sr-only'>name</label>
                                        <input required class='form-control' name="first_name" placeholder='enter name'>
                                    </div>
                                    <div class="form-group">
                                        <label class='sr-only'>email</label>
                                        <input required class='form-control' type='email' name="email" placeholder='enter email'>
                                    </div>
                                    <div class="form-group">
                                        <label class='sr-only'>country</label>
                                        <select  id='countrySelect' class='form-control' required name='country'>
                                            <option>choose country</option>
                                            @foreach($countries as $country)
                                            <option value='{!! $country->code !!}'>{!! $country->name !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class='sr-only'>state</label>
                                        <select disabled='true' id='stateSelect' class='form-control' required name='state'>
                                            <option>choose state</option>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class='sr-only'>city</label>
                                        <select disabled='true' id='citySelect' class='form-control' required name='city'>
                                            <option>choose city</option>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class='sr-only'>post code</label>
                                        <input required class='form-control' name="postcode" placeholder='enter postcode'>
                                    </div>
                                    <div class="form-group">
                                        <label class='sr-only'>address</label>
                                        <textarea required class='form-control' name="address" id="" cols="20" rows="6" placeholder='enter address'></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class='sr-only'>mobile</label>
                                        <input required class='form-control' name="mobile" placeholder='enter contact number'>
                                    </div>
                                    <div class="form-group">
                                        <label class='sr-only'>password</label>
                                        <input required type='password' class='form-control' name="password" placeholder='enter password'>
                                    </div>
                                    <div class="form-group">
                                        <label class='sr-only'>confirm password</label>
                                        <input required type='password' class='form-control' name="conf_pass" placeholder='enter password again'>
                                    </div>
                                {!! Form::close() !!}
                                <button id='saveUser' type='submit' class='btn btn-primary pull-right'>Registration</button>
                            </div>
                            @endif
                        </div>
                        <div class=" box">
                            <strong class="heading">Order Summary <span class="counter">(1 Items)</span></strong>
                            <table class="summarytable">
                                <thead>
                                <tr class="text-uppercase">
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(Session::get('page') != 'owarehouse')
                                @foreach($products as $product)
                                <tr>
                                    <td>{!! $product->name !!}</td>
                                    <td>{!! $product->quantity !!}</td>
                                    <td><span class='showCurrency'></span> {!! number_format($product->price*$product->quantity,2) !!}</td>
                                </tr>
                                @endforeach
                                @else
                                @foreach($products as $product)
                                <tr>
                                    <td>{!! $product->name !!}</td>
                                    <td>{!! $product->quantity !!}</td>
                                    <td><span class='showCurrency'></span> {!! number_format($product->price*$product->quantity,2) !!}</td>
                                </tr>
                                @endforeach
                                @endif
                                </tbody>
                            </table>
                            <div class="deliveryinfo">
                                <strong class="title">Standard Delivery <a href="#" class="edit">Edit</a></strong>
                                <span class="timelimit">04 September 2015 -09 September 2015</span>
                            </div>
                        </div>
                        <span class="voucher">Do You have Voucher Code? <a href="#" class="apply">Apply here</a></span>
                        <div class="box">
                            @if(Session::get('page') != 'owarehouse')
                            <ul class="priceinfo list-unstyled">
                                <li>
                                    <span class="title">Subtotal</span>
                                    <span class="amount"><span class='showCurrency'></span> {!! number_format($total, 2) !!}</span>
                                </li>
                                <li>
                                    <span class="title">Shipping surcharges</span>
                                    <span class="amount"><span class='showCurrency'></span> 00.0</span>
                                </li>
                            </ul>
                            <div class="grand-total">
                                <div class="text-holder">
                                    <strong class="title">Total</strong>
                                    <span class="terms">(GST 6% included)</span>
                                </div>
                                <span class="final-amount"><span class='showCurrency'></span> {!! number_format($total, 2) !!}</span>
                            </div>
                            @else
                            <ul class="priceinfo list-unstyled">
                                <li>
                                    <span class="title">Subtotal</span>
                                    <span class="amount"><span class='showCurrency'></span> {!! number_format($total, 2) !!}</span>
                                </li>
                                <li>
                                    <span class="title">Shipping surcharges</span>
                                    <span class="amount"><span class='showCurrency'></span> 00.0</span>
                                </li>
                            </ul>
                            <div class="grand-total">
                                <div class="text-holder">
                                    <strong class="title">Total</strong>
                                    <span class="terms">(GST 6% included)</span>
                                </div>
                                <span class="final-amount"><span class='showCurrency'></span> {!! number_format($total, 2) !!}</span>
                            </div>
                            @endif
                        </div>
						<span class="voucher">Do You Want to Pick Up your Order? <a href="javascript:void(0)" class="apply" id="pick">Select your station</a></span>
						<p class="voucher" id="picktexth" style="display: none;">Your Selected Station: <span id="pickh"></span>. Don't want to pick up? <a href="javascript:void(0)" class="apply" id="unpick">Unselect</a></p>
						<input type="hidden" id="pick_station" value="0" />
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document" style="width: 70%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Select Station</h4>
				</div>
				<div class="modal-body">
					 <div id="map" class="row" style=" height: 400px"></div>
					 <br>
					 <h4 id="picktext">Your Selected Station: </h4>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				</form>

			</div>
		</div>
	</div>	
@stop

@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgjJ1IH8yzDhaEwNKD1RQEpSDU58V70LE"></script>
<script type="text/javascript">
    $(document).ready(function(){

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
		google.maps.event.addDomListener(window, 'load', initialize);
	
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
			
			var urlbase = $('meta[name="base_url"]').attr('content');

			$.ajax({
				type: "GET",
				url: url,
				dataType: 'json',
				success: function (data) {
					console.log(data);
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

        $('#makePayment').click(function(e){
            e.preventDefault();
            $('#spinner').removeClass('hidden');
            confirm = $('#loginConfirm').val();
            globalvar = $('#globalvar').val();
            total = $('#total').val();
            var pick_station = $('#pick_station').val();
			if(globalvar <= total){
				if (confirm == '1')
				{
					$.ajax({
					  url: target_path+'postOrder',
					  type: "post",
					  data: {
						'card':$("#paymentForm input[type='radio']:checked").val(),
						'ProdDesc':$("#prodDesc").val(),
						'Remark':$("#remark").val(),
						'pick_station':pick_station,
						'Lang':$("#lang").val(),
						'ResponseURL':$("#responseUrl").val(),
						'currency':$("#currency").val(),
					  },
					  async: false,
					  success: function(returnValue){
                        setTimeout(function () {
                            console.log(returnValue);
                            $('#spinner').addClass('hidden').fadeIn(2000);
                            $('#paymentid').val(returnValue[0]);
                            $('#refno').val(returnValue[1]);
                            $('#signature').val(returnValue[2]);
                            $('#paymentForm').attr('action', 'https://www.mobile88.com/ePayment/entry.asp');
                            // $('#paymentForm').submit();
                        }, 1000);
						return true;
					  }
					});
				}else{
					$('#loginalert').removeClass('hidden').fadeIn(3000);
				}
			} else {
				$('#amountalert').removeClass('hidden').fadeIn(3000);
			}
      });
    })
</script>
@stop
