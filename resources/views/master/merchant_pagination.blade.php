<?php
use App\Classes;
define('MAX_COLUMN_TEXT', 40);
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
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
<script type="text/javascript">
	$(document).ready(function(){
		var d = new Date();

	    m = d.getMonth()+1;

	    y = d.getFullYear();

	});
</script>
<?php $i=1; ?>
<div class="modal fade" id="myModalRemarks" role="dialog" aria-labelledby="myModalRemarks">
	<div class="modal-dialog" role="remarks" style="width: 50%">
		<div class="modal-content">
			<div class="row" style="padding: 15px;">
				<div class="col-md-12" style="">
					<form id="remarks-form">
						<fieldset>
							<h2>Remarks</h2>
							<br>
							<textarea style="width:100%; height: 250px;" name="name" id="status_remarks" class="text-area ui-widget-content ui-corner-all">
							</textarea>
							<br>
							<input type="button" id="save_remarks" class="btn btn-primary" value="Save Remarks">
							<input type="hidden" id="current_role_roleId" remarks_role="" >
							<input type="hidden" id="current_status" value="" >
						</fieldset>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>				
		</div>			
	</div>	
</div>
<div class="overlay" style="display:none;">
    <p><span style="position: relative;" class="all-filter-fa"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span></p>
</div>
<div style="display: none;" class="removeable alert">
    <strong id='alert_heading'></strong><span id='alert_text'></span>
</div>
<div class="container" style="margin-top:30px;">
	@include('admin/panelHeading')

	<h2>Merchant Master (Active: {{$total_active->counting}})</h2>
	<span  id="merchant-error-messages">
    </span>
	<div class="table-responsive">
		<table class="table table-bordered" cellspacing="0" width="100%" id="gridmerchant">
			<thead style="background-color: #FF4C4C; color: white;">
				<tr>
					<th class="no-sort text-center bsmall">No</th>
					<th class="text-center medium">Merchant&nbsp;ID</th>
					<th class="text-center blarge">Company&nbsp;Name</th>
					{{-- <th class="text-center">Domicile</th> --}}
					{{-- <th class="text-center large">Business&nbsp;Type</th> --}}
					{{-- <th class="text-center">GST</th> --}}
					<th class="text-center medium">O-Shop</th>
				<!--	<th class="text-center no-sort medium">Manager</th>
					<th class="text-center medium no-sort">Statement</th>-->
					{{--<th class="text-center medium">PWD</th>--}}
					<th class="text-center medium"
						style="background-color:#444;color:#fff">Product</th>
					<th class="text-center medium"
						style="background-color:#4E2E28;color:#fff">Station</th>
					<th class="text-center medium"
						style="background-color:#400080;color:#fff">Tokens</th>
					<th class="text-center medium">Since</th>
				<!--	 <th class="xlarge text-center"
						style="background-color:#008000;color:#fff">Remarks</th>
					<th class="text-center medium"
						style="background-color:#008000;color:#fff">Status</th>
					<th class="text-center no-sort approv"
						style="background-color:#008000;color:#fff">Approval</th> -->
					<th class="medium text-center"
						style="background-color:#008000;color:#fff">Status</th>	
						<th class="medium text-center"
						style="background-color:#008000;color:#fff">Cash Back</th>	
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
	<br>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Account Manager</h4>
            </div>
            <div class="modal-body">
				<h3 id="modal-Tittle1"></h3>
                <h3 id="modal-Tittle"></h3>
                <div class="table-responsive">
                    <table id="myTable" class="table table-bordered myTable"></table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content" style='max-height: 500px; overflow-y: scroll;'>
            <div class="modal-body">
                <h3 id="modal-Tittle2"></h3>
                <div id="myBody2">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="myModalToken" role="dialog" aria-labelledby="myModalRemarks">
	<div class="modal-dialog" role="remarks" style="width: 55%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" align="center"
						id="myModalLabel">Token Control</h4>
			</div>
			<div class="modal-body">
				<div class="row" style="padding: 15px;">
					<div class="col-md-12" style="">	
						<!-- Only users which has role "AAP" is able use Grant -->
						@if(Auth::user()->hasRole('aap'))
							<div class="col-md-3 no-padding" style="">
								<input type="text" class="form-control"
									value="" placeholder="Free Tokens" id="tokens_add" />
							</div>
							<div class="col-md-3 no-padding" style="">
								<a href="javascript:void(0);"
									class="btn btn-primary add_tokens"
									style="background-color: #400080 !important; width: 100%;">Grant</a>
							</div>
							<div class="clearfix"> </div><br>
						@endif
						<div class="col-md-1 no-padding" style="">
							<center style="margin-top: 5px;">Qty</center>
						</div>
						<div class="col-md-3 no-padding" style="">
							<input type="text" class="form-control"
							value="" placeholder="Buy" id="tokens_buy" />
						</div>
						<div class="col-md-1 no-padding" style="">
							<center style="margin-top: 5px;">Price</center>
						</div>
						<div class="col-md-3 no-padding" style="">
							<input type="text" class="form-control"
								value="" placeholder="Free" id="tokens_free" />
						</div>
						<div class="col-md-3 no-padding" style="">
							<a href="javascript:void(0);"
								class="btn btn-primary add_tokens_offer"
								style="background-color: #400080 !important; width: 100%;">Grant</a>
						</div>
						<div class="clearfix"> </div><br>
							<?php
								$tglobals = DB::table('global')->first();
								$product1 = null;
								$product2 = null;
								$product3 = null;
								$product4 = null;
								$product5 = null;
								$checked_p1 = "";
								$checked_p2 = "";
								$checked_p3 = "";
								$checked_p4 = "";
								$checked_p5 = "";
								if(property_exists($tglobals, 'token_product_id1')){
									$product1 = DB::table('product')->where('id',$tglobals->token_product_id1)->first();
								}
								if(property_exists($tglobals, 'token_product_id2')){
									$product2 = DB::table('product')->where('id',$tglobals->token_product_id2)->first();
								}
								if(property_exists($tglobals, 'token_product_id3')){
									$product3 = DB::table('product')->where('id',$tglobals->token_product_id3)->first();
								}
								if(property_exists($tglobals, 'token_product_id4')){
									$product4 = DB::table('product')->where('id',$tglobals->token_product_id4)->first();
								}
								if(property_exists($tglobals, 'token_product_id5')){
									$product5 = DB::table('product')->where('id',$tglobals->token_product_id5)->first();
								}
							?>
								<div class='row no-padding'>
									<div class='col-sm-4'><p align="center"><b>Token</b></p></div>
									<div class='col-sm-4'>
										<p align="center"><b>Quantity</b></p>
									</div>
									<div class='col-sm-4'><p align="left"><b>Price</b></p></div>
								</div>
							@if(!is_null($product1))
								<div class='row no-padding'>
									<div class='col-sm-4'><p align="center"><label style="font-size: 16px;"><b><input type="checkbox" class="showhidetoken" rel="{{$product1->id}}" id="checked_p1" {{$checked_p1}} />&nbsp;{{$product1->name}}</b></label></p></div>
									<div class='col-sm-4'>
										<p align="center">{{number_format(( $product1->retail_price)/100)}}</p>
									</div>
									<div class='col-sm-4'>{{$currentCurrency}}&nbsp;{{number_format($product1->discounted_price/100)}}</div>
								</div>
							@endif
							@if(!is_null($product2))
								<div class='row no-padding'>
									<div class='col-sm-4 margint7' ><p align="center"><label style="font-size: 16px;"><b><input type="checkbox" class="showhidetoken" rel="{{$product2->id}}" id="checked_p2" {{$checked_p2}} />&nbsp;{{$product2->name}}</b></label></p></div>
									<div class='col-sm-4 margint7'>
										<p align="center">{{number_format(($product2->retail_price)/100)}}</p>
									</div>
									<div class='col-sm-4 margint7'>{{$currentCurrency}}&nbsp;{{number_format($product2->discounted_price/100)}}</div>	
								</div>
							@endif
							@if(!is_null($product3))
								<div class='row no-padding'>
									<div class='col-sm-4 margint7'><p align="center"><label style="font-size: 16px;"><b><input type="checkbox" class="showhidetoken" rel="{{$product3->id}}" id="checked_p3" {{$checked_p3}} />&nbsp;{{$product3->name}}</b></label></p></div>
									<div class='col-sm-4 margint7'>
										<p align="center">{{number_format(($product3->retail_price)/100)}}</p>
									</div>
									<div class='col-sm-4 margint7'>{{$currentCurrency}}&nbsp;{{number_format($product3->discounted_price/100)}}</div>
								</div>
							@endif
							@if(!is_null($product4))
								<div class='row no-padding'>
									<div class='col-sm-4 margint7'><p align="center"><label style="font-size: 16px;"><b><input type="checkbox" class="showhidetoken" rel="{{$product4->id}}" id="checked_p4" {{$checked_p4}} />&nbsp;{{$product4->name}}</b></label></p></div>
									<div class='col-sm-4 margint7'>
										<p align="center">{{number_format(( $product4->retail_price)/100)}}</p>
									</div>
									<div class='col-sm-4 margint7'>{{$currentCurrency}}&nbsp;{{number_format($product4->discounted_price/100)}}</div>
								</div>
							@endif
							@if(!is_null($product5))
								<div class='row no-padding'>
									<div class='col-sm-4 margint7'><p align="center"><label style="font-size: 16px;"><b><input type="checkbox" class="showhidetoken" rel="{{$product5->id}}" id="checked_p5" {{$checked_p5}} />&nbsp;{{$product5->name}}</b></label></p></div>
									<div class='col-sm-4 margint7'>
										<p align="center">{{number_format(($product5->retail_price)/100)}}</p>
									</div>							
									<div class='col-sm-4 margint7'>{{$currentCurrency}}&nbsp;{{number_format($product5->discounted_price/100)}}</div>	
								</div>
							@endif	
							<div class="clearfix"> </div><br>
							<div class='row no-padding'>
								<div class='col-sm-12 no-padding'>
									<table id="facilities_info" class="table table-bordered" width="100%">
										<thead style="background-color: #400080; color: #fff;"><th style="text-align:center">No</th><th style="text-align:center">Facility</th><th style="text-align:center">Annual Fee</th><th style="text-align:center">Variable</th><th style="text-align:center">Since</th></thead>
									</table>
								</div>
							</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
			
		</div>
	</div>		
</div>	

<div id="admindialog" title="Reset Password" style="display:none">
	<p>Enter new password</p>
	<input type="password" id="user_pass" size="25" />
	<input type="hidden" id="useraid" value="0" />
	<p>Confirm new password</p>
	<input type="password" id="user_passc" size="25" />
	<input type="button" id="change_password" class="btn btn-primary" value="Reset" style="margin-top: 10px;">
	<p style="color: red; display: none;" id="wrong_pass" style="margin-top: 10px;">Passwords don't match.</p>
	<p style="color: green; display: none;" id="sucess_pass" style="margin-top: 10px;">Password successfully changed!</p>
</div>
{{-- Modal --}}
<div id="srconfirmModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Attention!</h4>
      </div>
      <div class="modal-body">
        <p>Suspension of an account means a merchant will NOT be able to conduct business online anymore. Do you still want to suspend?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      	<button type="button" class="btn btn-warning" id="srconfirm">Yes</button>
      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="myModalHumancap" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 40%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">HumanCap Detail</h4>
            </div>
            <div class="modal-body">
                <h3 id="modal-Tittle"></h3>
                <div class="table-responsive1">
                    <table id="myTableHyper" class="table table-bordered myTable">
						<tr style="width:100%;background-color:#0F71B9;color:white;">
							<th class="text-center">HumanCap&nbsp;ID</th>
							<th class="text-center">Company&nbsp;Name</th>
							<th class="text-center">Staff&nbsp;No</th>
						</tr>
						<tr>
							<td class="text-center"><span id="humancapid"></span></td>
							<td class="text-center"><span id="humancapname"></span></td>
							<td class="text-center"><span id="humancapstaff"></span></td>
						</tr>
					</table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
					data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="myModalFair" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 40%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">FairMode Detail</h4>
            </div>
            <div class="modal-body">
                <h3 id="modal-Tittle"></h3>
                <div class="table-responsive1">
                    <table id="myTableHyper" class="table table-bordered myTable">
						<tr style="width:100%;background-color:#CCFF66;">
							<th class="text-center">Fair&nbsp;ID</th>
							<th class="text-center">Company&nbsp;Name</th>
							<th class="text-center">Staff&nbsp;No</th>
						</tr>
						<tr>
							<td class="text-center"><span id="fairid"></span></td>
							<td class="text-center"><span id="fairname"></span></td>
							<td class="text-center"><span id="fairstaff"></span></td>
						</tr>
					</table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
					data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
	<div class="modal fade" id="FacilitiesFeeModal" role="dialog" aria-labelledby="WholeSaleModal">
		<div class="modal-dialog" role="document" style="width: 15%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
					<h4 class="modal-titlelike" id="myModalLabel">Variable Fee</h4>
				</div>
				<div class="modal-body">
					<div id=""></div>
					<div id="">
						<table id="" class="table table-bordered">
							<tr style="background-color: #400080; color: #fff;">
								<td style="text-align:center"><span id="fee_name"></span></td>
							</tr>
							<tr>
								<td style="text-align: center;"><span id="fee_value"></span></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>

			</div>
		</div>
	</div>	
{{--  --}}
<meta name="_token" content="{!! csrf_token() !!}"/>
<script type="text/javascript">
function toTitleCase(str)
{
	return str.replace(/\w\S*/g,
		function(txt){return txt.charAt(0).toUpperCase() +
			txt.substr(1).toLowerCase();});
}

$(document).ready(function () {
	var token_merchant_id = 0;
	 $('.hover-long-text').tooltip();
    function pad (str, max) {
        str = str.toString();
        return str.length < max ? pad("0" + str, max) : str;
    }

			$('.pwd_reset').click(function () {
				var userid = $(this).attr("rel");
				
				var formData = {
					email: userid
				}	;	

				$.ajax({
					type: "POST",
					url: JS_BASE_URL + "/forgot_password",
					data:formData,
					success: function (data) {
						toastr.info(data);
						toastr.info("Password successfully sent!");
					},
					error: function (error) {
						toastr.warning("Password could not be changed!");
						console.log(error);
					}

				});				
			});

			$(document).delegate( '#sendmail', "click",function (event) {
				$.ajax({
					type: "POST",
					url: JS_BASE_URL + "/sendmail",
					dataType: 'json',
					success: function (data) {
						console.log(data);
					},
					error: function (error) {
						console.log(error);
					}

				});
			});

	 $(document).delegate( '#change_password', "click",function (event) {
		//console.log("passs");
		var userid = $("#useraid").val();
		var password = $("#user_pass").val();
		var cpassword = $("#user_passc").val();

		if(password == cpassword){
			var formData = {
				userid: userid,
				password: password
			}

			$.ajax({
				type: "POST",
				url: JS_BASE_URL + "/changepassword",
				data: formData,
				dataType: 'json',
				success: function (data) {
					$("#sucess_pass").show();
					setTimeout(function(){
						$("#user_pass").val("");
						$("#sucess_pass").hide();
						$("#admindialog").dialog("close");
					}, 3000);
				},
				error: function (error) {
					console.log(error);
				}
			});
		} else {
			$("#wrong_pass").show();
			setTimeout(function(){
				$("#wrong_pass").hide();
			}, 4000);
		}
	});

	$.fn.dataTable.pipeline = function ( opts ) {
	    // Configuration options
	    var conf = $.extend( {
	        pages: 5,     // number of pages to cache
	        url: '',      // script url
	        data: null,   // function or object with parameters to send to the server
	                      // matching how `ajax.data` works in DataTables
	        method: 'GET' // Ajax HTTP method
	    }, opts );
	 
	    // Private variables for storing the cache
	    var cacheLower = -1;
	    var cacheUpper = null;
	    var cacheLastRequest = null;
	    var cacheLastJson = null;
 
    return function ( request, drawCallback, settings ) {
        var ajax          = false;
        var requestStart  = request.start;
        var drawStart     = request.start;
        var requestLength = request.length;
        var requestEnd    = requestStart + requestLength;
         
        if ( settings.clearCache ) {
            // API requested that the cache be cleared
            ajax = true;
            settings.clearCache = false;
        }
        else if (cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper) {
            // outside cached data - need to make a request
            ajax = true;
        }
        else if (JSON.stringify(request.order)!==JSON.stringify(cacheLastRequest.order)||
                 JSON.stringify(request.columns)!==JSON.stringify(cacheLastRequest.columns)||
                 JSON.stringify(request.search)!==JSON.stringify(cacheLastRequest.search)) {
            // properties changed (ordering, columns, searching)
            ajax = true;
        }
         
        // Store the request for checking next time around
        cacheLastRequest = $.extend( true, {}, request );
 
        if ( ajax ) {
            // Need data from the server
            if ( requestStart < cacheLower ) {
                requestStart = requestStart - (requestLength*(conf.pages-1));
 
                if ( requestStart < 0 ) {
                    requestStart = 0;
                }
            }
             
            cacheLower = requestStart;
            cacheUpper = requestStart + (requestLength * conf.pages);
 
            request.start = requestStart;
            request.length = requestLength*conf.pages;
 
            // Provide the same `data` options as DataTables.
            if ( $.isFunction ( conf.data ) ) {
                // As a function it is executed with the data object as an arg
                // for manipulation. If an object is returned, it is used as the
                // data object to submit
                var d = conf.data( request );
                if ( d ) {
                    $.extend( request, d );
                }
            }
            else if ( $.isPlainObject( conf.data ) ) {
                // As an object, the data given extends the default
                $.extend( request, conf.data );
            }
 
            settings.jqXHR = $.ajax( {
                "type":     conf.method,
                "url":      conf.url,
                "data":     request,
                "dataType": "json",
                "cache":    false,
                "success":  function ( json ) {
                    cacheLastJson = $.extend(true, {}, json);
 
                    if ( cacheLower != drawStart ) {
                        json.data.splice( 0, drawStart-cacheLower );
                    }
                    if ( requestLength >= -1 ) {
                        json.data.splice( requestLength, json.data.length );
                    }
                     
                    drawCallback( json );
                }
            } );
        }
        else {
            json = $.extend( true, {}, cacheLastJson );
            json.draw = request.draw; // Update the echo for each response
            json.data.splice( 0, requestStart-cacheLower );
            json.data.splice( requestLength, json.data.length );
 
            drawCallback(json);
        }
    }
};
 
		// Register an API method that will empty the pipelined data, forcing an Ajax
		// fetch on the next draw (i.e. `table.clearPipeline().draw()`)
		$.fn.dataTable.Api.register( 'clearPipeline()', function () {
		    return this.iterator( 'table', function ( settings ) {
		        settings.clearCache = true;
		    } );
		} );
 
		var page=$('#gridmerchant_page').val();
		var product_dtable=$('#gridmerchant').DataTable({
			"serverSide":false,
			"processing":true,
			"paging":true,
			"searching":{"regex":true},
			"ajax":{
				type:"GET",
				pages:5,
				url:JS_BASE_URL+"/paginate/merchant",
				dataSrc:function(json){
				
					var return_data=new Array();
					subcat_pids=[];
					for (var i=0;i <json.data.length;i++) {
						var d=json.data[i];

						//console.log(JSON.stringify(d));

						subcat_pids.push(d.pid);

						/*
						if (d.merchant_id == '0011300100000200') {
							console.log(JSON.stringify(d));
						}

						if (d.total_sales != null) {
							console.log(d.merchant_id+":"+d.total_sales);
						}
						*/
						var html_company = d.company_name;
						if(d.role == "2"){
							html_company = '<a href="javascript:void(0)" class="humancap" data-id="'+d.id+'" data-staff="'+d.staff+'" data-nid="'+d.merchant_id+'" data-name="'+d.company_name+'">'+d.company_name+'</a>'
						}
						if(d.role == "3"){
							html_company = '<a href="javascript:void(0)" class="fairmode" data-id="'+d.id+'" data-staff="'+d.staff+'" data-nid="'+d.merchant_id+'" data-name="'+d.company_name+'">'+d.company_name+'</a>'
						}
						return_data.push({
							'id':`<a href='${JS_BASE_URL}/admin/merchant/module/access/${d.id}'
								target="_blank"
							>${i+1}</a>`,
							'merchant_id':'<a href="javascript:void(0)" class="view-merchant-modal" data-id="'+d.id+'">'+d.merchant_id+'</a>',
							'company_name':html_company,
							'oshop':'<a target="_blank" href="'+JS_BASE_URL+'/admin/master/oshops/'+d.id+'">'+d.oshops+'</a>',
							'product':'<a target="_blank" href="'+JS_BASE_URL+'/admin/master/product/'+d.id+'">'+d.products+'</a>',
							'station':'<a target="_blank" href="'+JS_BASE_URL+'/admin/master/network/'+d.id+'">'+d.autolinks+'</a>',
							'tokens':'<a href="javascript:void(0)" class="free-tokens" id="free-tokens'+d.user_id+'" data-id="'+d.user_id+'">'+d.tokens+'</a>',
							'total_sales':'{{$currentCurrency}} ' + js_number_format(parseInt(d.since_sales)/100,2,'.',','),
							'status':'<a target="_blank" href="'+JS_BASE_URL+'/admin/master/merchant/approval/'+d.id+'" class="merchant_role" srel="'+d.role+'">'+ucfirst(d.status)+'</a>',
							'cashback':d.cashback,
						});
					}
					return return_data;
				}
			},
			"columns":[
				{data:'id',name:'merchant.id',className:'text-center no-sort'},
				{data:"merchant_id",name:'nsellerid.nseller_id',className:'text-center'},
				{data:"company_name",name:'merchant.company_name',className:'text-center'},
				{data:"oshop",name:'merchantoshop.id',className:'text-center no-sort'},
				{data:"product",name:'merchantproduct.id',className:'text-center'},
				{data:"station",name:'autolink.id',className:'text-center'},
				{data:"tokens",name:'orderproduct.id',className:'text-center'},
				{data:"total_sales",name:'orderproduct.id',className:'text-center'},				
				{data:"status",name:'merchant.status',className:'text-center'},
				{data:"cashback",name:'merchantproduct.cashback',className:'text-center'}
				

			]
		});
		
		$('#gridmerchant').on('draw.dt', function () {
				console.log("Color");
					$(".merchant_role").each(function() {
						if ($(this).attr('srel')=="0") {
							$(this).closest('tr').css("background-color","rgba(255, 0, 0, 0.4)");
						}
						if ($(this).attr('srel')=="1") {
						//	$(this).closest('tr').css("background-color","#FCA8FF");
						}
						if ($(this).attr('srel')=="2") {
							$(this).closest('tr').css("background-color","#0F71B9");
							$(this).closest('tr').css("color","white");
							$(this).closest('tr').find('a').css("color","white");
							//$(this).closest('tr').('a').css("color","white");
						}
						if ($(this).attr('srel')=="3") {
							$(this).closest('tr').css("background-color","#CCFF66");
						}
					});
			/*	$.ajax({
					'type':'POST',
					'url':JS_BASE_URL+"/subcats/by/pid",
					'data':{'pids':subcat_pids},
					'success':function(r) {
							if (r.status=="success") {
							
								data=r.data;
								for (var i = data.length - 1; i >= 0; i--) {
									$('.subcat_'+data[i].id).text(data[i].subcat_name);
									if (data[i].pstatus=="pending") {
										$('.subcat_'+data[i].id).closest('tr').css("background-color","rgba(240, 255, 0, 0.4)");
									}
								}
							}
					}

				});*/

		} );	

            $('#product_details_table tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format(tr) ).show();
                    tr.addClass('shown');
                }
            } );

    function removeMessage() {
        $('.removeable').fadeOut(7000);
//            $('.removeable').remove();
    }
    setTimeout(removeMessage, 2000);

    // $(".mcrid").click(function () {
    $(document).delegate( '.humancap', "click",function (event) {
		$('#humancapid').html($(this).attr('data-nid'));
		$('#humancapname').html($(this).attr('data-name'));
		$('#humancapstaff').html($(this).attr('data-staff'));
		$("#myModalHumancap").modal('show');
	});
	
    $(document).delegate( '.fairmode', "click",function (event) {
		$('#fairid').html($(this).attr('data-nid'));
		$('#fairname').html($(this).attr('data-name'));
		$('#fairstaff').html($(this).attr('data-staff'));
		$("#myModalFair").modal('show');
	});	
	$("#tokens_free").number(true,2,'.','');
    $(document).delegate( '.add_tokens_offer', "click",function (event) {
		console.log(token_merchant_id);
		$(this).html("Saving...");
		var but = $(this);
		var val = parseInt($("#tokens_free").val()) || 0;
		var val2 = parseInt($("#tokens_buy").val()) || 0;
		if(val <= 0 || val2 <= 0){
			toastr.warning("Invalid value!");
		} else {
			$.ajax({
				type: "POST",
				data: { 
					tokens_free:$("#tokens_free").val(),
					tokens_buy:$("#tokens_buy").val(),
					user_id:token_merchant_id 
				},
				url: JS_BASE_URL+"/admin/offer_tokens",
				beforeSend: function(){},
				success: function(response){
					toastr.info("Token Offer Successfully saved!");
					//$("#free-tokens" + token_merchant_id).html(response);
					but.html("Offer");
					//location.reload();
					$("#myModalToken").modal('toggle');
				}
			});	
		}
	});
    $(document).delegate( '.add_tokens', "click",function (event) {
		console.log(token_merchant_id);
		$(this).html("Saving...");
		var but = $(this);
		var val = parseInt($("#tokens_add").val()) || 0;
		if(val <= 0){
			toastr.warning("Invalid value!");
		} else {
			$.ajax({
				type: "POST",
				data: { 
					tokens:$("#tokens_add").val(),
					user_id:token_merchant_id 
				},
				url: JS_BASE_URL+"/admin/free_tokens",
				beforeSend: function(){},
				success: function(response){
					toastr.info("Tokens Successfully saved!");
					$("#free-tokens" + token_merchant_id).html(response);
					but.html("Grant");
					//location.reload();
					$("#myModalToken").modal('toggle');
				}
			});	
		}		
	});
	
    $(document).delegate( '.showhidetoken', "click",function (event) {
		var rel = $(this).attr("rel");
		var checked = $(this).prop('checked');
		console.log(checked);
		$.ajax({
			type: "POST",
			data: { 
				user_id:token_merchant_id,
				product_id:rel,
				action:checked
			},
			url: JS_BASE_URL+"/admin/set_tokens",
			beforeSend: function(){},
			success: function(response){
				console.log(response);
			}
		});
		console.log(rel);
	});
	
    $(document).delegate( '.free-tokens', "click",function (event) {
		token_merchant_id = $(this).attr("data-id");
		$.ajax({
			type: "POST",
			data: { 
				user_id:token_merchant_id 
			},
			url: JS_BASE_URL+"/admin/available_tokens",
			dataType: 'json',
			beforeSend: function(){},
			success: function(response){
				console.log(response);
				for(var jj = 0; jj < response.length; jj++){
					var kk = jj +1;
					if(response[jj] == "1"){
						$('#checked_p' + kk).prop('checked', true);
					} else {
						$('#checked_p' + kk).prop('checked', false);
					}
				}
				//toastr.info("Tokens Successfully saved!");
				
				//location.reload();
				//$("#myModalToken").modal('toggle');
			}
		});
		$('#facilities_info').html('');
		$.ajax({
			type: "POST",
			data: { 
				user_id:token_merchant_id 
			},
			url: JS_BASE_URL+"/admin/available_facilities",
			dataType: 'json',
			beforeSend: function(){},
			success: function(response){
				console.log(response);
				$('#facilities_info').append('<thead style="background-color: #400080; color: #fff;"><th style="text-align:center">No</th><th style="text-align:center">Facility</th><th style="text-align:center">Annual Fee</th><th style="text-align:center">Variable Fee</th><th style="text-align:center">Since</th></thead>');
				$('#facilities_info').append('<tbody>');
				for (i=0; i < response.length; i++) {
					var obj = response[i];
					$('#facilities_info').append('<tr><td style="text-align: center;">' + (i+1).toString() +'</td><td style="text-align: center;">'+obj.description +'</td><td style="text-align: center;"><input type="text" size="8" style="display: none;" id="subs_fee_input'+obj.id +'" class="subs_fee_input" rel="'+obj.id +'" value="'+obj.token_subscription_fee +'" /><span class="spantoks" id="spantoks'+obj.id +'" style="display: none;">&nbsp;Tokens</span><span class="subs_fee_text" id="subs_fee_text'+obj.id +'" rel="'+obj.id +'">'+obj.token_subscription_fee +'</span></td><td style="text-align: center;"><a href="javascript:void(0);" class="variable_fee" rel="'+obj.token_admin_fee+'" nrel="'+obj.variable_fee_name+'" idrel="'+obj.id+'">Variable</a></td><td style="text-align: center;">' + obj.since + ' </td></tr>');
				}
				
				$('#facilities_info').append('</tbody>');
			}
		});
		$("#myModalToken").modal('show');
		
	});
		$(document).delegate( '.variable_fee', "click",function (event) {
		var _this = $(this);
		var name = _this.attr("nrel").replace('_',' ');
		var value = _this.attr("rel");
		var id = _this.attr("idrel");

		$("#fee_name").html(toTitleCase(name));
		$("#fee_value").html('<input type="text" style="display: none;" size="4" class="admin_fee_input" rel="'+id +'" value="'+ value +'" /><span class="spantok" style="display: none;">&nbsp;Tokens</span><span rel="'+id+'" class="admin_fee_text">' + value + '</span>');
		 $("#FacilitiesFeeModal").modal("show");
	});
	
	$(document).delegate('.total_token', "click",function (event) {
		var _this = $(this);
		var paid = _this.attr("rel-paid");
		var free = _this.attr("rel-free");
		$("#paid_token").html(paid);
		$("#free_token").html(free);
		 $("#IssuedModal").modal("show");
	});
	
			$(document).delegate( '.subs_fee_input', "blur",function (event) {
				 var _this = $(this);
				 var facility_id = $(this).attr("rel");
				 var val = $(this).val();
				 var url = '/admin/token/facilities/edit_subscription';
				 var formData = {
					facility_id: facility_id,
					value: val
				};
				 $.ajax({
                    type: "POST",
                    url: url,
					data:formData,
                    success: function (data) {
						toastr.info("Fee successfully changed!");
						$("#subs_fee_text" + facility_id).html(val);
						$("#subs_fee_text" + facility_id).show();
						_this.hide();
						$("#spantoks" + facility_id).hide();
					},
                    error: function (error) {
                        console.log(error);
                    }

                });
			});
			
			$(document).delegate( '.admin_fee_input', "blur",function (event) {
				 var facility_id = $(this).attr("rel");
				 var val = $(this).val();
				 var url = '/admin/token/facilities/edit_admin';
				 var formData = {
					facility_id: facility_id,
					value: val
				};
				 $.ajax({
                    type: "POST",
                    url: url,
					data:formData,
                    success: function (data) {
						toastr.info("Fee successfully changed!");
						$(".admin_fee_text").html(val);
						$(".admin_fee_text").show();
						$(".admin_fee_input").hide();
						$(".spantok").hide();
					},
                    error: function (error) {
                        console.log(error);
                    }

                });
			});
			
			$(document).delegate( '.admin_fee_text', "click",function (event) {
				$(".admin_fee_text").hide();
				$(".admin_fee_input").show();
				$(".spantok").show();
			});
			
			$(document).delegate( '.subs_fee_text', "click",function (event) {
				$(this).hide();
				$("#subs_fee_input" + $(this).attr('rel')).show();
				$("#spantoks" + $(this).attr('rel') ).show();
			});
	
	
    $(document).delegate( '.mcrid', "click",function (event) {
		_this = $(this);
		var id_merchant= _this.attr('rel');

		$('#modal-Tittle2').html("Remarks");

		var url = '/admin/master/merchant_remarks/'+ id_merchant;
		$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			success: function (data) {
				console.log(data);
				var html = "<table class='table table-bordered' cellspacing='0' width='100%' ><tr style='background-color: #FF4C4C; color: white;'><th class='text-center'>No</th><th class='text-center'>Merchant&nbsp;ID</th><th class='text-center'>Status</th><th class='text-center'>Admin&nbsp;User&nbsp;ID</th><th class='text-center'>Remarks</th><th class='text-center'>DateTime</th></tr>";
				for (i=0; i < data.length; i++) {
					var obj = data[i];
					html += "<tr>";
					html += "<td class='text-center'>"+(i+1)+"</td>";
					html += "<td class='text-center'><a href='../../admin/popup/merchant/"+id_merchant+"' class='update' data-id='"+id_merchant+"'>["+pad(id_merchant.toString(),10)+"]</a></td>";
					html += "<td class='text-center'>"+ucfirst(obj.status)+"</td>";
					html += "<td class='text-center'><a href='../../admin/popup/user/"+obj.user_id+"' class='update' data-id='"+obj.user_id+"'>["+pad(obj.user_id.toString(),10)+"]</td>";
					html += "<td>"+obj.remark+"</td>";
					html += "<td class='text-center'>"+obj.created_at+"</td>";
					html += "</tr>";
				}
				html = html + "</table>";
				$('#myBody2').html(html);
				$("#myModal2").modal("show");
			}
		});
	});

    $(document).delegate( '.mcrid', "click",function (event) {
		_this = $(this);
		var id_merchant= _this.attr('rel');

		$('#modal-Tittle2').html("Remarks");

		var url = '/admin/master/merchant_remarks/'+ id_merchant;
		$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			success: function (data) {
				console.log(data);
				var html = "<table class='table table-bordered' cellspacing='0' width='100%' ><tr style='background-color: #FF4C4C; color: white;'><th class='text-center'>No</th><th class='text-center'>Merchant&nbsp;ID</th><th class='text-center'>Status</th><th class='text-center'>Admin&nbsp;User&nbsp;ID</th><th class='text-center'>Remarks</th><th class='text-center'>DateTime</th></tr>";
				for (i=0; i < data.length; i++) {
					var obj = data[i];
					html += "<tr>";
					html += "<td class='text-center'>"+(i+1)+"</td>";
					html += "<td class='text-center'><a href='../../admin/popup/merchant/"+id_merchant+"' class='update' data-id='"+id_merchant+"'>["+pad(id_merchant.toString(),10)+"]</a></td>";
					html += "<td class='text-center'>"+ucfirst(obj.status)+"</td>";
					html += "<td class='text-center'><a href='../../admin/popup/user/"+obj.user_id+"' class='update' data-id='"+obj.user_id+"'>["+pad(obj.user_id.toString(),10)+"]</td>";
					html += "<td>"+obj.remark+"</td>";
					html += "<td class='text-center'>"+obj.created_at+"</td>";
					html += "</tr>";
				}
				html = html + "</table>";
				$('#myBody2').html(html);
				$("#myModal2").modal("show");
			}
		});
	});

	$(document).delegate( '.mcid', "click",function (event) {

        $('#modal-Tittle').html("");
        $('#modal-Tittle1').html("");
        $('#myTable').empty();
        _this = $(this);

        var id_merchant= _this.attr('id');
        var id_merchant_n= _this.attr('rel');
        var mname= $('#mname' + id_merchant).val();
		var url = '/admin/master/getmerchantmngrs/'+id_merchant;

		var urlbase = $('meta[name="base_url"]').attr('content');

		$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			success: function (data) {
			//	console.log(data);
				var mc = "";
				var mcref = "";
				var mp1 = "";
				var mp2 = "";

				var mcselect = '<select style="display:none;" class="mymerselect" id="mcsel"><option value="0">None Selected</option>';
				var mcrefselect = '<select style="display:none;" class="mymerselect" id="mcrefsel"><option value="0">None Selected</option>';
				mcsobj = data.mcs;
				for(i=0;i<mcsobj.length;i++){
					var selected = "";
					var selectedref = "";
					if(mcsobj[i].id == data.mc){
						selected = "SELECTED"
					}
					if(mcsobj[i].id == data.mcref){
						selectedref = "SELECTED"
					}
					mcselect = mcselect + '<option value="' + mcsobj[i].id + '" '+selected+'>'+mcsobj[i].first_name+ ' ' + mcsobj[i].last_name +'</option>';
					mcrefselect = mcrefselect + '<option value="' + mcsobj[i].id + '" '+selectedref+'>'+mcsobj[i].first_name+ ' ' + mcsobj[i].last_name +'</option>';
				}
				mcselect = mcselect + '</select>';
				mcrefselect = mcrefselect + '</select>';

				var mp1select = '<select style="display:none;" class="mymerselect" id="mp1sel"><option value="0">None Selected</option>';
				var mp2select = '<select style="display:none;" class="mymerselect" id="mp2sel"><option value="0">None Selected</option>';
				mpsobj = data.mps;
				for(i=0;i<mpsobj.length;i++){
					var selected = "";
					var selected2 = "";
					if(mpsobj[i].id == data.mp1){
						selected = "SELECTED"
					}
					if(mpsobj[i].id == data.mp2){
						selected2 = "SELECTED"
					}
					mp1select = mp1select + '<option value="' + mpsobj[i].id + '" '+selected+'>'+mpsobj[i].first_name+ ' ' + mpsobj[i].last_name +'</option>';
					mp2select = mp2select + '<option value="' + mpsobj[i].id + '" '+selected2+'>'+mpsobj[i].first_name+ ' ' + mpsobj[i].last_name +'</option>';
				}
				mp1select = mp1select + '</select>';
				mp2select = mp2select + '</select>';

				$('#myTable').append('<tbody><tr><td class="text-center">'+mcselect+'</td><td class="text-center">'+mcrefselect+'</td><td class="text-center">'+mp1select+'</td><td class="text-center">'+mp2select+'</td><td class="text-center"><a class="btn btn-primary mymerselect btn-save" href="javascript:void(0)" rel="'+ id_merchant +'" > Save</a></td></tr></tbody>');

				
				$("#mcsel").select2();
				$("#mcrefsel").select2();
				$("#mp1sel").select2();
				$("#mp2sel").select2();
				$("#mcsel").hide();
				$("#mcrefsel").hide();
				$("#mp1sel").hide();
				$("#mp2sel").hide();				
				$(".mer_edit").click(function(){
					_this = $(this);
					var mer_id= _this.attr('rel');
					_this.hide();
					$(".mymerlink").hide();
					$(".mymerselect").show();
				});

				$(".btn-save").click(function(){
					$(".btn-save").text("Saving...");
					_this = $(this);
					var mer_id= _this.attr('rel');
					if($("#mcsel").val() != data.mc){
						var url = '/admin/master/setmerchantmngrs/'+ mer_id;
							$.ajax({
							  url: url,
							  type: "post",
							  data: {'ssid': $("#mcsel").val(), 'column': 'mc_sales_staff_id'},
							  success: function(data){
								  console.log(data);
							}
						});
					}
					if($("#mcrefsel").val() != data.mcref){
						var url = '/admin/master/setmerchantmngrs/'+ mer_id;
							$.ajax({
							  url: url,
							  type: "post",
							  data: {'ssid': $("#mcrefsel").val(), 'column': 'referral_sales_staff_id'},
							  success: function(data){
								  console.log(data);
							}
						});
					}
					if($("#mp1sel").val() != data.mp1){
						var url = '/admin/master/setmerchantmngrs/'+ mer_id;
							$.ajax({
							  url: url,
							  type: "post",
							  data: {'ssid': $("#mp1sel").val(), 'column': 'mcp1_sales_staff_id'},
							  success: function(data){
								  console.log(data);
							}
						});
					}
					if($("#mp2sel").val() != data.mp2){
						var url = '/admin/master/setmerchantmngrs/'+ mer_id;
							$.ajax({
							  url: url,
							  type: "post",
							  data: {'ssid': $("#mp2sel").val(), 'column': 'mcp2_sales_staff_id'},
							  success: function(data){
								  console.log(data);
							}
						});
					}
					$(".btn-save").text("Save");
					$("#myModal").modal("hide");
					//location.reload();
				});
			},
			error: function (error) {
				console.log(error);
			}
		});
	
        $('#modal-Tittle1').append("Merchant Name: "+mname);
        $('#modal-Tittle').append("Merchant ID: "+id_merchant_n);
        $('#myTable').append("<thead style='background-color: #FF4C4C; color: #fff;'><th class='text-center'>MC ID</th><th class='text-center'>MC ID (Referal)</th><th class='text-center'>MP1&nbsp;ID</th><th class='text-center'>MP2&nbsp;ID</th><th class='text-center'>Edit</th></thead>");


        $("#myModal").modal("show");
    });

    $(".selectstationchannel").change(function()
    {	
    	var mid=$(this).attr("rel");
        var url = $(this).val()+m+"/"+y+"/"+mid;
        window.open(url);
    });
	
	$(document).delegate( '.view-merchant-modal', "click",function (event) {
//	$('.view-merchant-modal').click(function(){

		var id=$(this).attr('data-id');
		var check_url=JS_BASE_URL+"/admin/popup/lx/check/merchant/"+id;
		$.ajax({
			url:check_url,
			type:'GET',
			success:function (r) {
			console.log(r);
			
				if (r.status=="success") {
				var url=JS_BASE_URL+"/admin/popup/merchant/"+id;
					var w=window.open(url,"_blank");
					w.focus();
				}
				if (r.status=="failure") {
					var msg="<div class=' alert alert-danger'>"+
						r.long_message+"</div>";
					$('#merchant-error-messages').html(msg);
				}
			}
		});
	});
	
	$(window).resize();
});


window.setInterval(function(){
              $('#merchant-error-messages').empty();
            }, 10000);


</script>
@yield("left_sidebar_scripts")
@stop
