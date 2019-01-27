<?php
use App\Classes;
define('MAX_COLUMN_TEXT', 20);
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
$global_system_vars=DB::table('global')->first();
?>
@extends("common.default")

@section("content")
<style type="text/css">
    .overlay{
        background-color: rgba(1, 1, 1, 0.7);
        bottom: 0;
        left: 0;
        position: fixed;
        right: 0;
        top: 0;
        z-index: 1001;
    }
    .overlay p{
        color: white;
        font-size: 72px;
        font-weight: bold;
        margin: 300px 0 0 55%;
    }
    .action_buttons{
        display: flex;
    }
    .role_status_button{
        margin: 10px 0 0 10px;
        width: 85px;
    }
</style>
<?php $i=1; ?>
        {{--Model Start--}}
        <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <p>...</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        {{--Model End--}}
<div class="overlay" style="display:none;">
    <p><span style="position: relative;" class="all-filter-fa"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span></p>
</div>
<div style="display: none;" class="removeable alert">
    <strong id='alert_heading'></strong><span id='alert_text'></span>
</div>
<div class="container" style="margin-top:30px;">
	<h2>Album: Product Details</h2>
	<div class="col-md-12" style="padding-right:0">
		<button class="btn btn-info pull-right"
				style="margin-top:-20px;margin-bottom:10px;margin-right:0"
				type="button" id="update" title="All modifications of product will only be updated and be visible to public only upon pressing this button, AND also ticking a checkbox in the  'O' (O-Shop) column.">Update<br> Public
		</button>
	</div>	
	<span  id="merchant-error-messages">
    </span>
	<div class="table-responsive col-md-12 no-padding">
		<table class="table table-bordered" cellspacing="0" width="100%" id="gridmerchant">
			<thead>
				<tr class="bg-black" id="table_row">
					<th class="text-center no-sort" style="background-color: black;">No</th>
					<th class="text-center" style="background-color: #558ED5;">SMM</th>
					<th class="text-center" style="background-color: black;">Product&nbsp;ID</th>
					<th class="text-center" style="background-color: black;">Name</th>
					<th class="text-center" style="background-color: black;">Category</th>
					<th class="text-center" style="background-color: black;">SubCategory</th>
					<th class="text-center" style="background-color: black;">Brand</th>
				<!--	<th class="text-center" style="background-color: #004080;">Hyper</th> -->
					<th class="text-center" style="background-color: #black;">Delete</th>
			<!--		<th class="text-center">Category</th>
					<th class="text-center">SubCategory</th>
					<th class="text-center">Brand</th>
					<th class="text-center">Hyper&nbsp;Price</th>
					<th class="text-center">Delete</th> -->
				</tr>
			</thead>
			<tbody>	
				<tr>
					<td class="text-center">1</td>
					<?php 
						$pname = $product->name;
						if(strlen($pname) > 50){
							$pname = substr($pname,0,47);
							$pname .= "...";
						}
					?>
					<td class="text-center">
					<?php $disabled_smm = "disabled";
						  $message_smm = "Product has to be displayed at O-Shop first by clicking on [Update to Public]";
						if($product->oshop_id != 0){
							$disabled_smm = "";
							$message_smm = "";
						}
					?>
						<label style="margin-bottom:0">
					<?php 	if($product->smm_selected=='0'){ ?>
								<input data-pid="'+product.id+'" title="<?php echo $message_smm; ?>" type="checkbox" value="1"  class="smm_action marker_<?php echo $product->id; ?>" <?php echo $disabled_smm; ?>>
					<?php 	} else if($product->smm_selected=='1'){ ?>
								<input type="checkbox" value="0"  class="smm_action marker_<?php echo $product->id; ?>" data-pid="<?php echo $product->id; ?>"  checked ="checked" <?php echo $disabled_smm; ?>>
					<?php 	} ?>
						</label>
												
					</td>					
					<td class="text-center">{{IdController::nP($product->id)}}</td>
					<td class="text-center"><img src="{{asset('/')}}images/product/{{$product->parent_id}}/{{$product->photo_1}}" width="30" height="30" style="padding-top:0;margin-top:4px"><span style="vertical-align: middle;">{{$pname}}</span></td>

					<td class="text-center">{{$category->description}}</td>
					<td class="text-center">{{$subcategory->description}}</td>
					<td class="text-center">{{$brand->name}}</td>
					<?php
						$background_hyper = "#FFF";
						$color_hyper = "#777";
						$border_hyper = "#ddd";
						$hyperss = DB::table('product')->join('owarehouse','product.id','=','owarehouse.product_id')
								->where('product.parent_id',$product->id)
								->where('product.segment','hyper')
								->orderBy('owarehouse.created_at','DESC')
								->first();
						$hypertxt = "Hyper";
						$isreset = 0;
						if(!is_null($hyperss)){
							$moq = $hyperss->moq;
							$pledges = DB::table('owarehousepledge')->
								select(DB::raw('SUM(pledged_qty) as pledged_qty'))->
								where('owarehouse_id',$hyperss->id)->
								where('status','executed')->first();
							$total_pledges = 0;
							if(!is_null($pledges)){
								$total_pledges = $pledges->pledged_qty;
							}
							$percentages = $total_pledges*100/$moq;

							if($hyperss->status == 'active'){
								$hypertxt = number_format($percentages,0) . "%";
								$background_hyper = "#00F878";
								$border_hyper = "#00BD5B";
								$color_hyper = "#000";
								$date = $hyperss->created_at;
								$date = strtotime($date);
								$current_date = strtotime(date('Y-m-d H:i:s'));
								$date1 = new DateTime('now');

								$date2 = new DateTime(date('Y-m-d H:i:s',
									strtotime("+ $global_system_vars->hyper_duration day", $date)));
								$dDiff = $date1->diff($date2);
								if ($dDiff->format("%r") == '-') {							
									if($percentages >= 100){
										$background_hyper = "#EFFF00";
										$border_hyper = "#D4E300";
										$color_hyper = "#000";	
										//$hypertxt = "100%";	
										$isreset = 1;
									} else {
										$background_hyper = "#FF5151";
										$border_hyper = "#C70D0D";
										$color_hyper = "#FFF";	
										$isreset = 1;									
									}
								} else {

									if($product->oshop_selected == 1 &&
										$product->available > 0 &&
										$product->status == 'active' &&
										$hyperss->owarehouse_price > 0 &&
										$hyperss->owarehouse_moq > 0 &&
										$hyperss->owarehouse_moqperpax > 0) {
										
									} else {
										$hypertxt = "Hyper";
										$background_hyper = "#FFF";
										$color_hyper = "#777";
										$border_hyper = "#ddd";									
									}
								}
							} else if($hyperss->status == 'executed'){
								$hypertxt = number_format($percentages,0) . "%";
								$background_hyper = "#EFFF00";
								$border_hyper = "#D4E300";
								$color_hyper = "#000";	
								//$hypertxt = "100%";							
							} else if($hyperss->status == 'expired'){
								$hypertxt = number_format($percentages,0) . "%";
								$background_hyper = "#FF5151";
								$border_hyper = "#C70D0D";
								$color_hyper = "#FFF";
							}
						}
						$style="background: " .$background_hyper . "; color: " .$color_hyper. "; border-color: " . $border_hyper .";";
						$style_color="color: " .$color_hyper. ";";
					?>
					<!-- <td class="text-center" style='{{$style}}'>
						<a rel="{{$product->id}}" class="hy_info" href="javascript:void(0)"
						 style='{{$style_color}}'
						data-toggle="modal"
						data-isreset="{{$isreset}}"
						data-target="#myModal"
						data-rowid="{{$product->id}}"
						data-rowname="{{$product->name}}"
						data-route="{{route('hyper', $product->id)}}"
						data-detail-type="HYSP">
						{{$hypertxt}}</a>
					</td> -->
					<?php 
					$disabled_delete = "";
					$crel = 1;
					$title_delete = "This will permanently delete your product!";
					if($product->oshop_id > 0){
						$disabled_delete = "disabled";
						$crel = 0;
						$title_delete = "In order to delete this product you need to remove it from public display";
					}					
					?>
					<td class="text-center">
						<a class="btn btn-danger delete_product" rel="{{$product->id}}" crel="{{$crel}}" {{$disabled_delete}} title="{{ $title_delete }}" href="javascript:void(0)"> Delete </a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<input type="hidden" value="{{$global_system_vars->smm_quota_max}}" id="smm_quota_max" />
<input type="hidden" value="{{$merchant_id}}" id="merchant_id" />
<!-- Modal -->
{{--  --}}
<meta name="_token" content="{!! csrf_token() !!}"/>
<script type="text/javascript">
$(document).ready(function () {
    $('#gridmerchant').DataTable({
        "order": [],
        "scrollX": true,
        "scrollY": false,
        "columnDefs": [
			{"targets": 'no-sort', "orderable": false, },
			{"targets": "medium", "width": "80px" },
			{"targets": "large",  "width": "120px" },
			{"targets": "approv", "width": "180px"},
			{"targets": "blarge", "width": "200px"},
			{"targets": "bsmall",  "width": "20px"},
			{"targets": "clarge", "width": "250px"},
			{"targets": "xlarge", "width": "300px" }
		],
        "fixedColumns":  true
    });
	
	       $('#update').click(function(){
			//
			$('#update').html("Updating...");
            var data={};
          /*  $('.oshop_select').each(function () {
				
				var key= $(this).attr('rel');
				//console.log(key);
				data[key]=[$(this).val(),$("#ret" + key).val(),$("#disc" + key).val(),$("#ret_qty" + key).val(),$("#b2b_qty" + key).val()];
            });*/
            var datasmm={};
			var count_smm = 0;
            $('.smm_action').each(function () {
				var key= $(this).attr('data-pid');
                if (this.checked) {
                    datasmm[key]=true;
					count_smm++;
                } else {
					datasmm[key]=false;
				}
            });
			var smm_quota_max = parseInt($("#smm_quota_max").val());
			console.log(count_smm);
			if(count_smm > smm_quota_max){
				toastr.error("Warning: SMM quota exceeeded");
				$('#update').html("Update to Public");	
			} else {
				
            // Ajax Call
				console.log(datasmm);
                $.ajax({
                    type: 'POST',
                    url: JS_BASE_URL + "/product/update/selected_product",
                    data:{'data':data, 'merchant_id':$('#merchant_id').val(), 'datasmm':datasmm},
                    dataType:'json',
                    success: function(resultData) {
                        console.log(resultData);
						$('#update').html("Update to Public");	
						toastr.info("Product Successfully updated!");						
						setTimeout(function () {
							$('#updatedalert').addClass('hidden').fadeIn(2000);						
						}, 3000);
					}
                });
				}
                //
            });	
	
			$('body').on('click', '.delete_product', function() {
				var _this = $(this);
				var pid = $(this).attr('rel');
				var crel = $(this).attr('crel');
				console.log(crel);
				if(parseInt(crel) == 1){
				alert_confirm=confirm("Warning! Are you sure you want to permanently delete this product?");
				if(!alert_confirm){
				} else {

						var url = JS_BASE_URL + '/products/delete';
						$.ajax({
						  url: url,
						  type: "post",
						  data: {
								'pid': pid			  
						  },
						  success: function(data){
							//location.reload();
							//console.log(data);
							if(data == "1"){
								toastr.info("Product successfully deleted");						
							} else {
								toastr.info("Hyper product is currently having active pledges. Unable to Delete");
							}			
						  }
						});	
					}
				}				
			});		
			
			$(".hy_info").on('click', function (event) {
            //    var model = $(this);
               // var button = $(event.relatedTarget);
                var product_id = $(this).data('rowid');
				$("#productid").val(product_id);
                var product_name = $(this).data('rowname');
                var isreset = $(this).data('isreset');
				$("#productname").val(product_name);
                var detail_type = $(this).data('detail-type');
                var route = $(this).data('route');
				console.log(route);
                getPopUp(detail_type, route);

                function getPopUp(detail_type, route) {
                    var title = setTitle(detail_type);
                    $.ajax({
                        url : route,
                        type : 'GET',
                        success : function(response) {
                            if(response){
                                $("#myModal").find('.modal-body').html(response);
                                $("#myModal").find('.modal-title').html(title);

								if(detail_type == 'HYSP'){
								var pledgesqty = $("#pledgesqty").val();
								$('.delivery_require_hyper').on('keyup', function () {
									var del_width = $("#del_width_hyper").val();
									var del_lenght = $("#del_lenght_hyper").val();
									var del_height = $("#del_height_hyper").val();
									var del_weight = $("#del_weight_hyper").val();
									
									if(del_weight != "" && del_height != "" && del_lenght != "" && del_width != ""){
										//alert("fdsafsadf");
										del_width = parseFloat(del_width);		
										del_lenght = parseFloat(del_lenght);		
										del_height = parseFloat(del_height);		
										del_weight = parseFloat(del_weight);
										var cms_pricing = parseFloat($("#cms_pricing_hyper").val());
										var grs_pricing = parseFloat($("#grs_pricing_hyper").val());
										var mts_pricing = parseFloat($("#mts_pricing_hyper").val());	
										var total_pricing = (del_width * del_height * del_lenght * cms_pricing) + (del_weight * grs_pricing);
										$("#del_pricing_hyper").val(total_pricing).number(true, 2);
									} else {
										$("#del_pricing_hyper").val("0.00");
									}
								});    
								
								$('#checkboxD_hyper').click(function () {
									$('.toggleDelivery_hyper').find('input').attr('disabled', this.checked);
									$('.toggleDelivery_hyper').find('input').val('');
									if(this.checked){
										$('#checkboxDq_hyper').prop('checked', false);
										$("#checkboxDqn_hyper").prop('disabled', true);
										$("#checkboxDqn_hyper").val('');
									}
								});
								
								$('#checkboxDq_hyper').on('change', function () {
										var boo = $(this).is(":checked");
										if(boo){
											$("#checkboxDqn_hyper").prop('disabled', false);
											$('#checkboxD_hyper').prop('checked', false);
										} else {
											$("#checkboxDqn_hyper").prop('disabled', true);
											$("#checkboxDqn_hyper").val('');
										}
								});	
								
								$('input:radio[name=del_option_hyper]').change(function () {
									$("#own_delivery_hyper").toggle();
									$("#system_delivery_hyper").toggle();
								});		
									
								$('input.delivery_prices_hyper, input.delivery_require_hyper, input.numberformat').number(true, 2);		
									
								$('#states_hyper').on('change', function () {
									$(this).removeClass('error');
									$(this).siblings('label.error').remove();
									var val = $(this).val();
									if (val != "") {
										var text = $('#states_hyper option:selected').text();
									  //  $('#states_p').html(text);
										$.ajax({
											type: "post",
											url: JS_BASE_URL + '/city',
											data: {id: val},
											cache: false,
											success: function (responseData, textStatus, jqXHR) {
												if (responseData != "") {
													$('#cities_hyper').html(responseData);
													document.getElementById('cities_hyper').disabled = false;
												}
												else {
													$('#cities_hyper').empty();
													$('#select2-cities_hyper-container').empty();
													document.getElementById('cities_hyper').disabled = false;
												}
											},
											error: function (responseData, textStatus, errorThrown) {
												alert(errorThrown);
											}
										});
									}
									else {
										$('#select2-cities_hyper-container').empty();
										$('#cities_hyper').html('<option value="0" selected>Choose Option</option>');
									}
								});

								$('#cities_hyper').on('change', function () {
									$(this).removeClass('error');
									$(this).siblings('label.error').remove();
									var val = $(this).val();
									if (val != "") {
										var text = $('#cities_hyper option:selected').text();
										//$('#cities_p').html(text);
										$.ajax({
											type: "post",
											url: JS_BASE_URL + '/area',
											data: {id: val},
											cache: false,
											success: function (responseData, textStatus, jqXHR) {
												if (responseData != "") {
													$('#areas_hyper').html(responseData);
													document.getElementById('areas_hyper').disabled = false;
												}
												else {
													$('#areas_hyper').empty();
													$('#select2-areas_hyper-container').empty();
													document.getElementById('areas_hyper').disabled = false;
												}
											},
											error: function (responseData, textStatus, errorThrown) {
												alert(errorThrown);
											}
										});
									}
									else {
										$('#select2-areas_hyper-container').empty();
										$('#areas_hyper').html('<option value="0" selected>Choose Option</option>');
									}
								});

								$('#areas_hyper').on('change', function () {
									var val = $(this).val();
									if (val != "") {
										var text = $('#areas_hyper option:selected').text();
									  //  $('#areas_p').html(text);
									}
								});


									$('#states_biz_hyper').on('change', function () {
										$(this).removeClass('error');
										$(this).siblings('label.error').remove();
										var val = $(this).val();
										if (val != "") {
											var text = $('#states_biz_hyper option:selected').text();
											//$('#states_p').html(text);
											$.ajax({
												type: "post",
												url: JS_BASE_URL + '/city',
												data: {id: val},
												cache: false,
												success: function (responseData, textStatus, jqXHR) {
													if (responseData != "") {
														$('#cities_biz_hyper').html(responseData);
														document.getElementById('cities_biz').disabled = false;
													}
													else {
														$('#cities_biz_hyper').empty();
														$('#select2-cities_biz_hyper-container').empty();
														document.getElementById('cities_biz_hyper').disabled = false;
													}
												},
												error: function (responseData, textStatus, errorThrown) {
													alert(errorThrown);
												}
											});
										}
										else {
											$('#select2-cities_biz_hyper-container').empty();
											$('#cities_biz_hyper').html('<option value="0" selected>Choose Option</option>');
										}
									});

									$('#cities_biz_hyper').on('change', function () {
										$(this).removeClass('error');
										$(this).siblings('label.error').remove();
										var val = $(this).val();
										if (val != "") {
											var text = $('#cities_biz_hyper option:selected').text();
											//$('#cities_p').html(text);
											$.ajax({
												type: "post",
												url: JS_BASE_URL + '/area',
												data: {id: val},
												cache: false,
												success: function (responseData, textStatus, jqXHR) {
													if (responseData != "") {
														$('#areas_biz_hyper').html(responseData);
														document.getElementById('areas_biz_hyper').disabled = false;
													}
													else {
														$('#areas_biz_hyper').empty();
														$('#select2-areas_biz_hyper-container').empty();
														document.getElementById('areas_biz_hyper').disabled = false;
													}
												},
												error: function (responseData, textStatus, errorThrown) {
													alert(errorThrown);
												}
											});
										}
										else {
											$('#select2-areas_biz_hyper-container').empty();
											$('#areas_biz_hyper').html('<option value="0" selected>Choose Option</option>');
										}
									});		
									
									$('#hyperprice').on('keyup', function () {
										var rp = parseInt($('#retail_priceh').val());
										var hp = parseInt($('#hyperprice').val());
										var res = 0;
										if(hp > 0 && rp > 0){
											res = ((rp - hp) / rp) * 100;
										}

										if(res>99.99){
											res=99.99
										}
										if(res < 0){
											res = 0;
										}
										//if(!isNaN(res)) {
										if(hp >= rp || hp == 0){
											$("#error_hyper").show();
											$("#save_hyper").hide();
											$("#update_hyper").prop("disabled",true);
											$("#add_hyper").prop("disabled",true);
											$('#resultSaveh').text(0).number(true, 2);
										} else {
											$("#error_hyper").hide();
											$("#save_hyper").show();
											$("#update_hyper").prop("disabled",false);
											$("#add_hyper").prop("disabled",false);				
											if (res > 0) {
												$('#resultSaveh').text(res).number(true, 2);
											} else {
												$('#resultSaveh').text(0).number(true, 2);
											}				
										}

										//}
									});		

									$('.hyper_terms').summernote({
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
										dialogsInBody: true,
										focus: true,     // set focus to editable area after initializing summernote
										airMode: false,
									});

									$("#minusmoq").click(function (e) {
										var val = $("#moq").val();
										var valcaf = $("#moqcaf").val();
										var newval = parseInt(val) - (1*parseInt(valcaf));
										if(newval <= 0){
											$("#moq").val(val);
										} else {
											if((parseInt(newval) % parseInt(valcaf)) != 0){
												var modd = (parseInt(newval) % parseInt(valcaf));
												console.log(modd);
												newval = newval + (parseInt(valcaf) - modd);
											}
											$("#moq").val(newval);
										}
									});

									$("#plusmoq").click(function (e) {
										var val = $("#moq").val();
										var valcaf = $("#moqcaf").val();
										var newval = parseInt(val) + (1*parseInt(valcaf));
										if((parseInt(newval) % parseInt(valcaf)) != 0){
											var modd = (parseInt(newval) % parseInt(valcaf));
											newval = newval + (parseInt(valcaf) - modd);
										}										
										$("#moq").val(newval);
									});		

									$("#minushqty").click(function (e) {
										var val = $("#hqty").val();
										var valcaf = $("#moqcaf").val();
										var newval = parseInt(val) - (1*parseInt(valcaf));
										if(newval == 0){
											$("#hqty").val(val);
										} else {
											if((parseInt(newval) % parseInt(valcaf)) != 0){
												var modd = (parseInt(newval) % parseInt(valcaf));
												newval = newval + modd;
											}											
											$("#hqty").val(newval);
										}
									});
									
									
									$("#plushqty").click(function (e) {
										var val = $("#hqty").val();
										var valcaf = $("#moqcaf").val();
										var newval = parseInt(val) + (1*parseInt(valcaf));
										if((parseInt(newval) % parseInt(valcaf)) != 0){
											var modd = (parseInt(newval) % parseInt(valcaf));
											newval = newval + modd;
										}										
										$("#hqty").val(newval);
									});

									$("#minusmoqcaf").click(function (e) {
										var val = $("#moqcaf").val();
										var newval = parseInt(val) - 1;
										if(newval == 0){
											$("#moqcaf").val(val);
											$("#moq").val(val);
											$("#hqty").val(val);
										} else {
											$("#moqcaf").val(newval);
											$("#moq").val(newval);
											$("#hqty").val(newval);											
										}
									});

									$("#plusmoqcaf").click(function (e) {
										var val = $("#moqcaf").val();
										var newval = parseInt(val) + 1;
										$("#moqcaf").val(newval);
										$("#moq").val(newval);
										$("#hqty").val(newval);											
									});
									
									$("#minusdur").click(function (e) {
										var val = $("#duration").val();
										var newval = parseInt(val) - 1;
										if(newval == 0){
											$("#duration").val(val);
										} else {
											$("#duration").val(newval);
										}
									});

									$("#plusdur").click(function (e) {
										var val = $("#duration").val();
										var newval = parseInt(val) + 1;
										$("#duration").val(newval);
									});		
									
									$("#setcaf").click(function (e) {
										var moq_location = $("#moq_location").val();
									//	alert("moq_location: " + moq_location);
										if(moq_location ==  "0"){
											$("#setcaf").addClass("btn-success");
											$("#setcaf").removeClass("btn-warning");
											$("#setcafgly").addClass("glyphicon-check");
											$("#setcafgly").removeClass("glyphicon-transfer");
											$("#moqcaf").attr("disabled", false);
											$("#plusmoqcaf").attr("disabled", false);
											$("#minusmoqcaf").attr("disabled", false);
											$("#plusmoq").attr("disabled", true);
											$("#minusmoq").attr("disabled", true);
											$("#moq").attr("disabled", true);
											$("#plushqty").attr("disabled", true);											
											$("#minushqty").attr("disabled", true);											
											$("#hqty").attr("disabled", true);	
											$("#hyperprice").attr("disabled", true);	
											$("#moq_location").val("1");
										} else {
											$("#setcaf").removeClass("btn-success");
											$("#setcaf").addClass("btn-warning");
											$("#setcafgly").removeClass("glyphicon-check");
											$("#setcafgly").addClass("glyphicon-transfer");
											$("#moqcaf").attr("disabled", true);
											$("#plusmoqcaf").attr("disabled", true);
											$("#minusmoqcaf").attr("disabled", true);
											$("#plusmoq").attr("disabled", false);
											$("#minusmoq").attr("disabled", false);
											$("#moq").attr("disabled", false);
											$("#plushqty").attr("disabled", false);											
											$("#minushqty").attr("disabled", false);											
											$("#hqty").attr("disabled", false);
											$("#hyperprice").attr("disabled", false);
											$("#moq_location").val("0");											
										}
									});										

									$("#close_hyper").click(function (e) {
										$('#myModal').modal('hide');
									});
									
									$("#nremove_hyper").click(function (e) {
										toastr.error("Hyper have not been created yet.");
									});
									
									$("#noremove_hyper").click(function (e) {
										toastr.error("You can't remove this hyper. Already have pledges.");
									});										
									
									$("#remove_hyper").click(function (e) {
										var isremove = confirm("This will remove product from Hyper Pool and OShop Hyper. Do you want to continue?");
										if(isremove){
											$('#remove_hyper').html('Removing...');
											var owarehouse_id = $("#owarehouse_id").val();
											var hyper_id = $("#hyper_id").val();
											$.ajax({
												url: JS_BASE_URL+"/removehyperprice",
												type: "POST",
												data: {
													owarehouse_id : owarehouse_id,
													hyper_id : hyper_id
												},
												async: false,
												success: function(response)
												{
													$('#remove_hyper').html('Removed');
													$('#myModal').modal('hide');
													product_table.destroy();
													$('#tab-product-detail-tbody').empty();	
													$("#tab-product-detail").parents('div.dataTables_wrapper').first().hide();			
													$("#myspinner").show();			
													$.ajax({
														url: '{{ route('getmerchantproducts') }}',
														cache: false,
														method: 'GET',
														data: {merchant_id: $('#merchant_id').val()},
														success: function(result, textStatus, errorThrown) {
															console.log(result);
															
															$("#tab-product-detail-tbody").append(result);
															product_table = $("#tab-product-detail").DataTable({
																'order': [],
																'responsive': false,
																'autoWidth': false,
																"scrollX":true,
																"aoColumnDefs": [
																	{"bSortable":false, "aTargets": [0,1,2]},
																],
																"columnDefs": [
																	{ "targets": "no-sort", "orderable": false },
																	{ "targets": "small", "width": "50px" },
																	{ "targets": "medium", "width": "80px" },
																	{ "targets": "large", "width": "120px" },
																	{ "targets": "blarge", "width": "200px" },
																	{ "targets": "xlarge", "width": "280px" }
																]
															});	
															$("#myspinner").hide();	
															$("#tab-product-detail").parents('div.dataTables_wrapper').first().show();					
														},
														error: function (responseData, textStatus, errorThrown) {
															console.log(errorThrown);
															product_table = $("#tab-product-detail").DataTable({
																'order': [],
																'responsive': false,
																'autoWidth': false,
																"scrollX":true,
																"aoColumnDefs": [
																	{"bSortable":false, "aTargets": [0,1,2]},
																],
																"columnDefs": [
																	{ "targets": "no-sort", "orderable": false },
																	{ "targets": "small", "width": "50px" },
																	{ "targets": "medium", "width": "80px" },
																	{ "targets": "large", "width": "120px" },
																	{ "targets": "blarge", "width": "200px" },
																	{ "targets": "xlarge", "width": "280px" }
																]
															});		
															$("#myspinner").hide();	
															$("#tab-product-detail").parents('div.dataTables_wrapper').first().show();				
														}
													});															
												}
											});										
											$('#myModal').modal('hide');											
										}
									});											

									$("#add_hyper").click(function (e) {
										$('#add_hyper').html('Saving...');
										var hyper_duration = $("#hyper_duration").val();
										//var hqty = $("#hqty").val();
										var states_hyper = $("#states_hyper").val();
										var cities_hyper = $("#cities_hyper").val();
										var areas_hyper = $("#areas_hyper").val();
										var del_world_v_hyper = $("#del_world_v_hyper").val();
										var del_malaysia_v_hyper = $("#del_malaysia_v_hyper").val();
										var del_sabah_v_hyper = $("#del_sabah_v_hyper").val();
										var del_sarawak_v_hyper = $("#del_sarawak_v_hyper").val();
										var del_width_hyper = $("#del_width_hyper").val();
										var del_height_hyper = $("#del_height_hyper").val();
										var del_lenght_hyper = $("#del_lenght_hyper").val();
										var del_weight_hyper = $("#del_weight_hyper").val();
										var del_option_hyper = $('input:radio[name=del_option_hyper]:checked').val();
										var states_biz_hyper = $("#states_biz_hyper").val();
										var cities_biz_hyper = $("#cities_biz_hyper").val();
										var free_delivery_with_purchase_qty = $("#free_delivery_with_purchase_qty").val();
										var areas_biz_hyper = $("#areas_biz_hyper").val();
										var free_delivery = 0;
										var isfree_delivery = $("#checkboxD_hyper").prop('checked');
										console.log(isfree_delivery);
										if(isfree_delivery){
											free_delivery = 1;
										}
										var del_pricing_hyper = $("#del_pricing_hyper").val();
										var hqty = $("#hqty").val();
										//var deliveryqty = $("#deliveryqty").val();
										var moq = $("#moq").val();
										var moqcaf = $("#moqcaf").val();
										var hyperprice = $("#hyperprice").val();
										var hyper_terms = $("#hyper_terms").val();
										var parent_id = $("#parent_id").val();
										//alert(cities_hyper);
										if(parseInt(moq) < parseInt(moqcaf) || parseInt(hqty) < parseInt(moqcaf)){
											toastr.error("MOQ and Maximum most be greater than MOQ/location");
										} else {
											if((parseInt(moq) % parseInt(moqcaf)) != 0 ||  (parseInt(hqty) % parseInt(moqcaf)) != 0 ){
												toastr.error("MOQ and Maximum most be multiples of MOQ/location");
											} else {
												$.ajax({
													url: "/addhyperprice",
													type: "POST",
													data: {
														moq : moq,
														moqcaf : moqcaf,
														duration : hyper_duration,
														hyperprice : hyperprice,
														hyper_terms : hyper_terms,
														hqty : hqty,
														free_delivery : free_delivery,
														free_delivery_with_purchase_qty : free_delivery_with_purchase_qty,
														del_world_v_hyper : del_world_v_hyper,
														del_malaysia_v_hyper : del_malaysia_v_hyper,
														del_sabah_v_hyper : del_sabah_v_hyper,
														del_sarawak_v_hyper : del_sarawak_v_hyper,
													//	deliveryqty : deliveryqty,
														states_hyper : states_hyper,
														cities_hyper : cities_hyper,
														areas_hyper : areas_hyper,
														del_width_hyper : del_width_hyper,
														del_height_hyper : del_height_hyper,
														del_lenght_hyper : del_lenght_hyper,
														del_weight_hyper : del_weight_hyper,
														del_option_hyper : del_option_hyper,
														states_biz_hyper : states_biz_hyper,
														cities_biz_hyper : cities_biz_hyper,
														areas_biz_hyper : areas_biz_hyper,
														del_pricing_hyper : del_pricing_hyper,
														parent_id : parent_id
													},
													async: false,
													success: function(response)
													{
														$('#add_hyper').html('Saved');
														$('#myModal').modal('hide');
														product_table.destroy();
														$('#tab-product-detail-tbody').empty();	
														$("#tab-product-detail").parents('div.dataTables_wrapper').first().hide();			
														$("#myspinner").show();			
														$.ajax({
															url: '{{ route('getmerchantproducts') }}',
															cache: false,
															method: 'GET',
															data: {merchant_id: $('#merchant_id').val()},
															success: function(result, textStatus, errorThrown) {
																console.log(result);
																
																$("#tab-product-detail-tbody").append(result);
																product_table = $("#tab-product-detail").DataTable({
																	'order': [],
																	'responsive': false,
																	'autoWidth': false,
																	"scrollX":true,
																	"aoColumnDefs": [
																		{"bSortable":false, "aTargets": [0,1,2]},
																	],
																	"columnDefs": [
																		{ "targets": "no-sort", "orderable": false },
																		{ "targets": "small", "width": "50px" },
																		{ "targets": "medium", "width": "80px" },
																		{ "targets": "large", "width": "120px" },
																		{ "targets": "blarge", "width": "200px" },
																		{ "targets": "xlarge", "width": "280px" }
																	]
																});	
																$("#myspinner").hide();	
																$("#tab-product-detail").parents('div.dataTables_wrapper').first().show();					
															},
															error: function (responseData, textStatus, errorThrown) {
																console.log(errorThrown);
																product_table = $("#tab-product-detail").DataTable({
																	'order': [],
																	'responsive': false,
																	'autoWidth': false,
																	"scrollX":true,
																	"aoColumnDefs": [
																		{"bSortable":false, "aTargets": [0,1,2]},
																	],
																	"columnDefs": [
																		{ "targets": "no-sort", "orderable": false },
																		{ "targets": "small", "width": "50px" },
																		{ "targets": "medium", "width": "80px" },
																		{ "targets": "large", "width": "120px" },
																		{ "targets": "blarge", "width": "200px" },
																		{ "targets": "xlarge", "width": "280px" }
																	]
																});		
																$("#myspinner").hide();	
																$("#tab-product-detail").parents('div.dataTables_wrapper').first().show();				
															}
														});															
													}
												});
											}
										}
									});
									
									$("#reset_hyper").click(function (e) {
										$("#hyper_div :input").attr("disabled", false);
										$("#reset_hyper").hide();
										$("#setcaf").addClass("btn-success");
										$("#setcaf").removeClass("btn-warning");
										$("#setcafgly").addClass("glyphicon-check");
										$("#setcafgly").removeClass("glyphicon-transfer");
										$("#moqcaf").attr("disabled", false);
										$("#plusmoqcaf").attr("disabled", false);
										$("#minusmoqcaf").attr("disabled", false);
										$("#plusmoq").attr("disabled", true);
										$("#minusmoq").attr("disabled", true);
										$("#moq").attr("disabled", true);
										$("#plushqty").attr("disabled", true);											
										$("#minushqty").attr("disabled", true);											
										$("#hqty").attr("disabled", true);	
										$("#hyperprice").attr("disabled", true);	
										$("#checkboxDqn_hyper").attr("disabled", true);	
										$("#moq_location").val("1");
										$("#pledges_values").hide();
										$("#update_hyper").hide();
										$("#return_policy").hide();
										$("#hypercant").hide();
										$("#add_hyper").show();
										$("#hyper_terms_summ").show();
									});									

									$("#update_hyper").click(function (e) {
										$('#update_hyper').html('Updating...');
										//alert("1");
										var moq = $("#moq").val();
										var moqcaf = $("#moqcaf").val();
										var hyperprice = $("#hyperprice").val();
										var hyper_duration = $("#hyper_duration").val();
										var owarehouse_id = $("#owarehouse_id").val();
										var hyper_terms = $("#hyper_terms").val();
										var hyper_id = $("#hyper_id").val();
										var parent_id = $("#parent_id").val();
										var states_hyper = $("#states_hyper").val();
										var cities_hyper = $("#cities_hyper").val();
										var areas_hyper = $("#areas_hyper").val();
										var del_world_v_hyper = $("#del_world_v_hyper").val();
										var del_malaysia_v_hyper = $("#del_malaysia_v_hyper").val();
										var del_sabah_v_hyper = $("#del_sabah_v_hyper").val();
										var del_sarawak_v_hyper = $("#del_sarawak_v_hyper").val();
										var del_width_hyper = $("#del_width_hyper").val();
										var del_height_hyper = $("#del_height_hyper").val();
										var del_lenght_hyper = $("#del_lenght_hyper").val();
										var del_weight_hyper = $("#del_weight_hyper").val();
										var del_option_hyper = $('input:radio[name=del_option_hyper]:checked').val();
										var states_biz_hyper = $("#states_biz_hyper").val();
										var cities_biz_hyper = $("#cities_biz_hyper").val();
										var areas_biz_hyper = $("#areas_biz_hyper").val();
										var del_pricing_hyper = $("#del_pricing_hyper").val();
										var free_delivery_with_purchase_qty = $("#free_delivery_with_purchase_qty").val();
										var free_delivery = 0;
										var isfree_delivery = $("#checkboxD_hyper").prop('checked');
										console.log(isfree_delivery);
										if(isfree_delivery){
											free_delivery = 1;
										}										
										var hqty = $("#hqty").val();
										//alert("2");
										if(parseInt(moq) < parseInt(moqcaf) || parseInt(hqty) < parseInt(moq)){
											toastr.error("Maximum most be greater than MOQ");
										} else {
											if((parseInt(moq) % parseInt(moqcaf)) != 0 ||  (parseInt(hqty) % parseInt(moqcaf)) != 0 ){
												toastr.error("MOQ and Maximum most be multiples of MOQ/location");
											} else {
												$.ajax({
													url: "/updatehyperprice",
													type: "POST",
													data: {
														moq : moq,
														moqcaf : moqcaf,
														hyperprice : hyperprice,
														duration : hyper_duration,
														hyper_terms : hyper_terms,
														free_delivery : free_delivery,
														free_delivery_with_purchase_qty : free_delivery_with_purchase_qty,
														hqty : hqty,
														owarehouse_id : owarehouse_id,
														del_world_v_hyper : del_world_v_hyper,
														del_malaysia_v_hyper : del_malaysia_v_hyper,
														del_sabah_v_hyper : del_sabah_v_hyper,
														del_sarawak_v_hyper : del_sarawak_v_hyper,
														states_hyper : states_hyper,
														cities_hyper : cities_hyper,
														areas_hyper : areas_hyper,
														del_width_hyper : del_width_hyper,
														del_height_hyper : del_height_hyper,
														del_lenght_hyper : del_lenght_hyper,
														del_weight_hyper : del_weight_hyper,
														del_option_hyper : del_option_hyper,
														states_biz_hyper : states_biz_hyper,
														cities_biz_hyper : cities_biz_hyper,
														areas_biz_hyper : areas_biz_hyper,
														del_pricing_hyper : del_pricing_hyper,					
														hyper_id : hyper_id,
														parent_id : parent_id
													},
													async: false,
													success: function(response)
													{
														//alert("3");
														setTimeout(function(){
															$('#update_hyper').html('Updated');
															setTimeout(function(){
																$('#update_hyper').html('Go Hyper!');
																$('#myModal').modal('hide');
																product_table.destroy();
																$('#tab-product-detail-tbody').empty();	
																$("#tab-product-detail").parents('div.dataTables_wrapper').first().hide();			
																$("#myspinner").show();			
																$.ajax({
																	url: '{{ route('getmerchantproducts') }}',
																	cache: false,
																	method: 'GET',
																	data: {merchant_id: $('#merchant_id').val()},
																	success: function(result, textStatus, errorThrown) {
																		console.log(result);
																		
																		$("#tab-product-detail-tbody").append(result);
																		product_table = $("#tab-product-detail").DataTable({
																			'order': [],
																			'responsive': false,
																			'autoWidth': false,
																			"scrollX":true,
																			"aoColumnDefs": [
																				{"bSortable":false, "aTargets": [0,1,2]},
																			],
																			"columnDefs": [
																				{ "targets": "no-sort", "orderable": false },
																				{ "targets": "small", "width": "50px" },
																				{ "targets": "medium", "width": "80px" },
																				{ "targets": "large", "width": "120px" },
																				{ "targets": "blarge", "width": "200px" },
																				{ "targets": "xlarge", "width": "280px" }
																			]
																		});	
																		$("#myspinner").hide();	
																		$("#tab-product-detail").parents('div.dataTables_wrapper').first().show();					
																	},
																	error: function (responseData, textStatus, errorThrown) {
																		console.log(errorThrown);
																		product_table = $("#tab-product-detail").DataTable({
																			'order': [],
																			'responsive': false,
																			'autoWidth': false,
																			"scrollX":true,
																			"aoColumnDefs": [
																				{"bSortable":false, "aTargets": [0,1,2]},
																			],
																			"columnDefs": [
																				{ "targets": "no-sort", "orderable": false },
																				{ "targets": "small", "width": "50px" },
																				{ "targets": "medium", "width": "80px" },
																				{ "targets": "large", "width": "120px" },
																				{ "targets": "blarge", "width": "200px" },
																				{ "targets": "xlarge", "width": "280px" }
																			]
																		});		
																		$("#myspinner").hide();	
																		$("#tab-product-detail").parents('div.dataTables_wrapper').first().show();				
																	}
																});																	
															},2000);
														}, 2000);
													},
													error: function(response){
														alert(response);
													}
												});
											}
										}
									});

									$('#hyperprice').number(true, 2, '.', '');
									//$('#hqty').number(true, 2);
									//$('#deliveryqty').number(true, 2);	
									
									if(parseInt(pledgesqty)> 0){
										$("#hyper_div :input").attr("disabled", true);
										$("#hypercant").show();
									}
									
									$("#isreset").val(isreset);
									if(isreset == "1"){
										$("#reset_hyper").show();
										$("#reset_hyper").attr("disabled",false);
									}									
								}
                            }
							$("#myModal").modal('show');
                        }
                    })
                }

                //set title of popup according to detail
                function setTitle(detail_type){
                    if (detail_type == 'HSP') {
                        return 'B2B Price';
                    } else if (detail_type == 'DPR') {
                        return 'Delivery Price';
                    } else if (detail_type == 'DCV') {
                        return 'Delivery Coverage';
                    } else if (detail_type == 'PSP') {
                        return 'Product Specifications';
                    } else if (detail_type == 'SPP') {
                        return 'Special Price';
                    } else if (detail_type == 'HYSP') {
						return 'Hyper Price';
					}
                }
            });			
});
</script>
@stop
