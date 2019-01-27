<style>
.product-photo3 {
    min-height: 200px;
    text-align: center;
    color: #fff;
}
</style>
<div class="modal_loading"></div>
<div class="row">
    <div class="col-sm-12" style="margin-bottom:20px">
        {!!Form::open(array('route'=>'create_new_voucher_v2.post','id'=>'formVoucherv2','class'=>'form-horizontal form-wrp','files'=>true))!!}
            <div id="pinformation" class="">
                <div class="col-sm-12"><h1>Add Voucher V2</h1>
                    <div hidden="" class="col-md-5 alert alert-danger" id="errors_voucherv2">There are some errors on
                        page
                    </div>
                    <div hidden="" class="col-md-5 alert alert-success" id="success_voucherv2">Voucher Added
                        Successfully
                    </div>
                </div>
                <div class="col-sm-4 thumbnail" id='thumbnail'>
                    <div class="product-photo">
                        <img class="img-responsive"  id="imagePreviewVoucherv2"
						style="object-fit:cover;object-position:center top" src="#" alt="" />
                        <div class="inputBtnSection">
                            {!! Form::text('voucher_photo_txtv2',null,['class'=>'disableInputField text-center','id'=>'uploadFilev2','placeholder'=>'Add Voucher Photo','disabled'=>'disabled']) !!}
                            <label class="fileUpload">
                                {!! Form::file('voucher_photov2',['class'=>'upload','id'=>'uploadBtnVoucherv2', 'required']) !!}
                                <span class="uploadBtn badge"><i class="fa fa-lg fa-upload"></i> </span>
                            </label>
                        </div>
                    </div>
                </div> {{-- End of thumbnail --}}					
                <div class="col-sm-8">				
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Name</label>
                        <div class="col-sm-9">
                            <input type="text" name="productNamev2" id="productNamev2" class="form-control">
                            <span class=" text-danger" id="errors_voucher_productv2"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Brand</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="Brandv2" id="Brandv2">
                                <option value="" selected disabled>select one</option>
                                @foreach($getBrand as $Brand)
                                    <option value="{{$Brand->id}}">{{$Brand->name}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="errors_voucher_brandv2"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Category</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="categoryIdv2" id="categoryIdv2">
                                <option selected value="" disabled>select one</option>
                                @foreach($getCategory as $category)
                                    <option value="{{$category->id}}">{{$category->description}}</option>
                                @endforeach
                            </select>
                            <span class=" text-danger" id="errors_voucher_categoryv2"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Sub Category</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="subCategoryIdv2" id="subCategoryIdv2">
                                <option value=""></option>
                            </select>
                            <span class="text-danger" id="errors_voucher_sub_categoryv2"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('O-Shop', 'O-Shop', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-9">
                            {!! Form::text('OShopname',$oshop, array('class' => 'form-control','readonly'))!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('short_descriptionv2', 'Description', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-9">
                            {!! Form::textarea('short_descriptionv2', null, array('class' => 'form-control', 'rows' => '4','id'=>'short_descriptionv2', 'required'))!!}
                        </div>
                    </div>

                </div>
			
			<div class="clearfix"></div>
            <hr>
                <div class="col-sm-8">
					 <div class="form-group">
						<div class="product-photo2">
							<img class="img-responsive"  id="imagePreviewVouchercoverv2"
							style="object-fit:cover;object-position:center top" src="#" alt="" />
							<div class="inputBtnSection">
								{!! Form::text('voucher_photo_txtcoverv2',null,['class'=>'disableInputField text-center','id'=>'uploadFilecoverv2','placeholder'=>'Add Voucher Cover Photo','disabled'=>'disabled']) !!}
								<label class="fileUpload">
									{!! Form::file('voucher_photocoverv2',['class'=>'upload','id'=>'uploadBtnVouchercoverv2', 'required']) !!}
									<span class="uploadBtn badge"><i class="fa fa-lg fa-upload"></i> </span>
								</label>
							</div>
						</div>	
					</div>
				
				</div>
				<div class="col-sm-4">
                    <div class="product-photo3">
                        <img style="height: 200px;"  id="imagePreviewVoucherv22"
						style="object-fit:cover;object-position:center top" src="#" alt="" />
                    </div>					
				</div>
				
				<div class="col-sm-6">
					<div class="form-group">
						{!! Form::label('shop_size', 'Retail Price', array('class' => 'col-sm-4 control-label')) !!}
						<div class="col-sm-6">
							<div class="input-group">
								<span class="input-group-btn">
									<button type="button" class="btn btn-info btn-sm btn-number" data-type="plus" id="plusretailv2" data-field="">
									  <span class="glyphicon glyphicon-plus"></span>
									</button>
								</span>
									<input style="text-align: center; padding-left: 0px; padding-right: 0px;height:30px;width:60px"
									type="text" name="retailv2" class="form-control input-number" id="retailv2"
									value="1">
								<span class="input-group-btn" style="float:left">
									<button type="button" class="btn btn-info btn-sm btn-number"  data-type="minus" id="minusretailv2" data-field="">
									  <span class="glyphicon glyphicon-minus"></span>
									</button>
								</span>							
							</div>
						</div>
					</div>
					<div class="form-group">
						{!! Form::label('biz_name', 'Discounted Price', array('class' => 'col-sm-4 control-label')) !!}
						<div class="col-sm-6">
							<div class="input-group">
								<span class="input-group-btn">
									<button type="button" class="btn btn-info btn-sm btn-number" data-type="plus" id="plusdiscountedv2" data-field="">
									  <span class="glyphicon glyphicon-plus"></span>
									</button>
								</span>
									<input style="text-align: center; padding-left: 0px; padding-right: 0px;height:30px;width:60px"
									type="text" name="discountedv2" class="form-control input-number" id="discountedv2"
									value="0">
								<span class="input-group-btn" style="float:left">
									<button type="button" class="btn btn-info btn-sm btn-number"  data-type="minus" id="minusdiscountedv2" data-field="">
									  <span class="glyphicon glyphicon-minus"></span>
									</button>
								</span>								
							</div>
						</div>
					</div>								
					<div class="form-group">
						{!! Form::label('biz_name', 'Validity', array('class' => 'col-sm-4 control-label')) !!}
						<div class="col-sm-6">
							<div class="input-group">
								<span class="input-group-btn">
									<button type="button" class="btn btn-info btn-sm btn-number" data-type="plus" id="plusvalidityv2" data-field="">
									  <span class="glyphicon glyphicon-plus"></span>
									</button>
								</span>
									<input style="text-align: center; padding-left: 0px; padding-right: 0px;height:30px;width:60px"
									type="text" name="validityv2" class="form-control input-number" id="validityv2"
									value="1">
								<span class="input-group-btn" style="float:left">
									<button type="button" class="btn btn-info btn-sm btn-number"  data-type="minus" id="minusvalidityv2" data-field="">
									  <span class="glyphicon glyphicon-minus"></span>
									</button>
								</span>	
								<span style="float:left;  margin-left:40px; margin-top:8px;">
									year
								</span>
							</div>
						</div>
					</div>		
					<div class="form-group">
						{!! Form::label('biz_name', 'Quantity/Voucher', array('class' => 'col-sm-4 control-label')) !!}
						<div class="col-sm-6">
							<div class="input-group">
								<span class="input-group-btn">
									<button type="button" class="btn btn-info btn-sm btn-number" data-type="plus" id="plusvoucherv2" data-field="">
									  <span class="glyphicon glyphicon-plus"></span>
									</button>
								</span>
									<input style="text-align: center; padding-left: 0px; padding-right: 0px;height:30px;width:60px"
									type="text" name="voucherv2" class="form-control input-number" id="voucherv2"
									value="1">
								<span class="input-group-btn" style="float:left">
									<button type="button" class="btn btn-info btn-sm btn-number"  data-type="minus" id="minusvoucherv2" data-field="">
									  <span class="glyphicon glyphicon-minus"></span>
									</button>
								</span>		
								<span style="float:left;  margin-left:40px; margin-top:8px;">
									unit
								</span>								
							</div>
						</div>
					</div>		
					<div class="form-group">
						{!! Form::label('biz_name', 'Quantity', array('class' => 'col-sm-4 control-label')) !!}
						<div class="col-sm-6">
							<div class="input-group">
								<span class="input-group-btn">
									<button type="button" class="btn btn-info btn-sm btn-number" data-type="plus" id="plusqtyv2" data-field="">
									  <span class="glyphicon glyphicon-plus"></span>
									</button>
								</span>
									<input style="text-align: center; padding-left: 0px; padding-right: 0px;height:30px;width:60px"
									type="text" name="qtyv2" class="form-control input-number" id="qtyv2"
									value="1">
								<span class="input-group-btn" style="float:left">
									<button type="button" class="btn btn-info btn-sm btn-number"  data-type="minus" id="minusqtyv2" data-field="">
									  <span class="glyphicon glyphicon-minus"></span>
									</button>
								</span>							
							</div>
						</div>
					</div>						
				</div>
				<div class="col-sm-6">
					&nbsp;
				</div>
				<div class="clearfix"></div>
				<!--- address start-->
				<div class="col-sm-6">
					<h3>Locations</h3>
					@if(is_null($outlets))
						<p style="color:red;">No outlets found</p>
					@else
						@foreach($outlets as $outlet)
							<div class="input-group">
								<input type="checkbox" class="markerclick2" rel="{{$outlet->spid}}" id="{{$outlet->spid}}" value="{{$outlet->spid}}" name="outletsv2[]"> {{$outlet->biz_name}}
							</div>
							<p style="display:none;" id="addressm2_{{$outlet->spid}}">
								@if(!is_null($outlet->postcode) && $outlet->postcode != ""){{$outlet->postcode}} @endif
								@if(!is_null($outlet->city_name) && $outlet->city_name != "")@if(!is_null($outlet->postcode) && $outlet->postcode != "") , @endif{{$outlet->city_name}} @endif
							</p>							
						@endforeach
					@endif
				</div>				
				<div class="col-sm-6">
					<div id="map-containerv2" class="custom-container pull-right" style="width:575px; height:435px;">
                              <div id="map-canvasv2" style="width:540px; height:400px;">
                              </div>
                     </div>
				</div>
	<!--- address end-->
            
				
				<div class="clearfix"></div>
                <hr>	

				<div id="product" class="row">
					<div class="col-xs-12">
						<h2>Voucher Details</h2>
					</div>
					<div class="clearfix"></div>
					<div class="col-sm-12">
						{!! Form::textarea('voucher_detailsv2', null, array('class' => 'form-control','id'=>'info-detailsv2'))!!}
					</div>
					<div class="clearfix"> </div>
				</div>	
				<div class="clearfix"></div>
                <div class="row">
					@if(is_null($outlets))
						<p style="color:red;" class="text-right">Can't add voucher</p>
					@else
						<div class="col-sm-12 text-right"><input type="submit" class="btn btn-green" value="Submit"></div>
					@endif
                </div>
       </div>
	   {!!Form::close()!!}
   </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
		var mapv2;
		$(".markerclick2").click(function (e) {
			var addressid = $(this).attr('rel');
			console.log(addressid);
			var address = $("#addressm2_" + addressid).text();
			console.log(address);
			var geocoder = new google.maps.Geocoder();
			geocoder.geocode({'address': address}, function (data, status) {
				if (status == "OK") {
					var suggestion = data[0];
					var location = suggestion.geometry.location;
					console.debug(location);
					var latLng = new google.maps.LatLng(location.lat(), location.lng());
					marker = new google.maps.Marker({
						position: latLng,
						map: mapv2
					});	
					mapv2.setCenter(latLng);
				} else{
					//console.log(status);
				}
			});			

		});	
		
		var map_container2 = $("#map-containerv2");
		var map_canvas2 = $("#map-canvasv2");

		function initialize2() {

			var mapOptions = {
				zoom: 12,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				center: new google.maps.LatLng(0, 0)
			};

			infowindow = new google.maps.InfoWindow({
				content: ""
			});

			mapv2 = new google.maps.Map(document.getElementById('map-canvasv2'), mapOptions);

			infowindow.open(mapv2);
		}

		
		google.maps.event.addDomListener(window, 'load', initialize2);
        $('#uploadBtnVoucherv2').on("change", function () {
                id=$(this).attr('id');
                var files=""
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function () { // set image data as background of div

                        $("#imagePreviewVoucherv2").attr("src",this.result);
                        $("#imagePreviewVoucherv22").attr("src",this.result);
                        //$("#imagePreviewVoucher").css("background-repeat", "round");
                    }
                }
            });
			
        $('#uploadBtnVouchercoverv2').on("change", function () {
                id=$(this).attr('id');
                var files=""
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function () { // set image data as background of div

                        $("#imagePreviewVouchercoverv2").attr("src",this.result);
                        //$("#imagePreviewVoucher").css("background-repeat", "round");
                    }
                }
            });			
	
        $("#categoryIdv2").on('change', function (e) {

            var categoryId = $('select[name=categoryIdv2]').val();
            var loader = $('.loader');
            var batchOption = $('#subCategoryIdv2');
            $.ajax({
                url: 'selectCategoryWiseSubCategory/' + categoryId,
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    loader.show();
                },
                success: function (data) {
                    batchOption.empty();
                    batchOption.append('<option value="" selected disabled>Please select</option>');
                    $.each(data, function (index, value) {
                        batchOption.append('<option value="' + value.id + '">' + value.description + '</option>');
                    });
                    loader.hide();
                },
                error: function (data) {
                    alert('error occurred! Please Check');
                    loader.hide();
                }
            });

        });	
	
		$("#minusretailv2").click(function (e) {
			var val = $("#retailv2").val();
			var newval = parseInt(val) - 1;
			if(newval == 0){
				$("#retailv2").val(val);
			} else {
				$("#retailv2").val(newval);
			}
		});
		
		$("#plusretailv2").click(function (e) {
			var val = $("#retailv2").val();
			var newval = parseInt(val) + 1;
			$("#retailv2").val(newval);
		});	
		$('#retailv2').number(true, 2);
		$("#minusdiscountedv2").click(function (e) {
			var val = $("#discountedv2").val();
			var newval = parseInt(val) - 1;
			if(newval == 0){
				$("#discountedv2").val(val);
			} else {
				$("#discountedv2").val(newval);
			}
		});

		$("#plusdiscountedv2").click(function (e) {
			var val = $("#discountedv2").val();
			var newval = parseInt(val) + 1;
			$("#discountedv2").val(newval);
		});	
		$('#discountedv2').number(true, 2);
		$("#minusvalidityv2").click(function (e) {
			var val = $("#validityv2").val();
			var newval = parseInt(val) - 1;
			if(newval == 0){
				$("#validityv2").val(val);
			} else {
				$("#validityv2").val(newval);
			}
		});

		$("#plusvalidityv2").click(function (e) {
			var val = $("#validityv2").val();
			var newval = parseInt(val) + 1;
			$("#validityv2").val(newval);
		});	

		$("#minusvoucherv2").click(function (e) {
			var val = $("#voucherv2").val();
			var newval = parseInt(val) - 1;
			if(newval == 0){
				$("#voucherv2").val(val);
			} else {
				$("#voucherv2").val(newval);
			}
		});

		$("#plusvoucherv2").click(function (e) {
			var val = $("#voucherv2").val();
			var newval = parseInt(val) + 1;
			$("#voucherv2").val(newval);
		});	

		$("#minusqtyv2").click(function (e) {
			var val = $("#qtyv2").val();
			var newval = parseInt(val) - 1;
			if(newval == 0){
				$("#qtyv2").val(val);
			} else {
				$("#qtyv2").val(newval);
			}
		});

		$("#plusqtyv2").click(function (e) {
			var val = $("#qtyv2").val();
			var newval = parseInt(val) + 1;
			$("#qtyv2").val(newval);
		});			
	
        $("#formVoucherv2").submit(function (e) {

            $("body").addClass("loading");

            $("#errors_voucherv2").hide();
            $("#success_voucherv2").hide();
            $("#errors_voucher_productv2").html('');
            $("#errors_voucher_brandv2").html('');
            $("#errors_voucher_timeslotv2").html('');
            $("#errors_voucher_categoryv2").html('');
            $("#errors_voucher_sub_categoryv2").html('');
            $("#errors_voucher_retail_pricev2").html('');
            $("#errors_voucher_addressv2").html('');
            $("#error_zipv2").html('');
            $("#error_cityv2").html('');
            $("#error_statev2").html('');


            e.preventDefault();
            var form = $('#formVoucherv2')[0]; // You need to use standart javascript object here
            var formData = new FormData(form);
			console.log(formData);
            $.ajax({
                url: $('#formVoucherv2').attr('action'),
                data: formData,
                type: "POST",
                datatype: "JSON",
                // THIS MUST BE DONE FOR FILE UPLOADING
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response);
                    $('#productNamev2').val('');
                    $('select').val('');
                    $("#success_voucherv2").show();
                    $("#errors_voucherv2").hide();
                    $("body").removeClass("loading");
					window.scrollTo(0, document.body.scrollHeight);
                },
                error: function (response) {
					console.log(response);
                    $("body").removeClass("loading");
                    $("#success_voucherv2").hide();
                    $("#errors_voucherv2").show();
                    /*if (response.responseJSON.productName !="") {
                     $("#errors_voucher").html('<p>Product name is required</p>');
                     }*/
                    $("#errors_voucher_product").html(response.responseJSON.productName);
                    $("#errors_voucher_brandv2").html(response.responseJSON.Brand);
                    $("#errors_voucher_categoryv2").html(response.responseJSON.categoryId);
                    $("#errors_voucher_sub_categoryv2").html(response.responseJSON.subCategoryId);
                    $("#errors_voucher_retail_pricev2").html(response.responseJSON.retail_price);
                    $("#errors_voucher_addressv2").html(response.responseJSON.address);
                    $("#errors_voucher_timeslotv2").html(response.responseJSON.timeslot);
					$("#error_statev2").html(response.responseJSON.state);
					$("#error_cityv2").html(response.responseJSON.city);
					$("#error_zipv2").html(response.responseJSON.zip_code);
					window.scrollTo(0, document.body.scrollHeight);
					//$("#error_country").html(response.responseJSON.country);


                }

            })

        });    
	
	$('#info-detailsv2').summernote({
        toolbar: [
        // [groupName, [list of button]]
            ['insert', ['picture','table','hr']],
            ['style', ['fontname','fontsize','color','bold','italic',
                'underline','strikethrough','superscript','subscript','clear']],
            ['para', ['style','ul','ol','paragraph','height']],
            ['misc', ['fullscreen','codeview','undo','redo','help']],
            ],
        height: 300,     // set editor height
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: true,     // set focus to editable area after initializing summernote
        airMode: false,
    });		
	
    $('#states_v').on('change', function () {
                var val = $(this).val();
                if (val != "") {
                    var text = $('#states_v option:selected').text();
                    $('#states_v_p').html(text);
                    $.ajax({
                        type: "post",
                        url: JS_BASE_URL + '/city',
                        data: {id: val},
                        cache: false,
                        success: function (responseData, textStatus, jqXHR) {
                            if (responseData != "") {
                                $('#cities_voucher').html(responseData);

                            }
                            else {
                                $('#cities_voucher').empty();
                                $('#select2-cities_voucher-container').empty();
                             document.getElementById('cities_voucher').disabled = true;
                            }
                             document.getElementById('areas_voucher').disabled = true;   
                            document.getElementById('cities_voucher').disabled = false;
                        },
                        error: function (responseData, textStatus, errorThrown) {
                            alert(errorThrown);
                        }
                    });
                }
                else {
                    $('#select2-cities_voucher-container').empty();
                    $('#cities_voucher').html('<option value="" selected>Choose Option</option>');
                }
            });
			$('#cities_voucher').on('change', function () {
                var val = $(this).val();
                if (val != "") {
                    var text = $('#cities_voucher option:selected').text();
                    $('#cities_voucher_p').html(text);
                    $.ajax({
                        type: "post",
                        url: JS_BASE_URL + '/area',
                        data: {id: val},
                        cache: false,
                        success: function (responseData, textStatus, jqXHR) {
                            if (responseData != "") {
                                $('#areas_voucher').html(responseData);
                                document.getElementById('areas_voucher').disabled = false;
                            }
                            else {
                                $('#areas_voucher').empty();
                                $('#select2-areas_voucher-container').empty();
                                document.getElementById('areas_voucher').disabled = false;
                            }
                        },
                        error: function (responseData, textStatus, errorThrown) {
                            alert(errorThrown);
                        }
                    });
                }
                else {
                    $('#select2-areas_voucher-container').empty();
                    $('#areas_voucher').html('<option value="" selected>Choose Option</option>');
                }
            });
 });			
</script>
