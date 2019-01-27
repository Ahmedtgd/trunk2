@extends("common.default")
@section("content")
<?php
use App\Classes;
use App\Http\Controllers\IdController;
define('MAX_COLUMN_TEXT', 95);
?>
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
	input.error_rec {background-color: pink; border: 1px red; color: white}
</style>
<?php $i=1; ?>
<div class="modal fade" id="myModalRemarks" role="dialog" aria-labelledby="myModalRemarks">
	<div class="modal-dialog" role="remarks" style="width: 60%">
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
	<h2>Buyer Master</h2>
	<div class="table-responsive">
		<table class="table table-bordered" cellspacing="0" width="100%" id="grid4c">
			<thead style="background-color: #0000ff; color: #fff;">
				<tr>
					<th class="text-center no-sort bsmall">No</th>
					<th class="text-center bmedium">Buyer ID</th>
					<th class="text-center xlarge">Username</th>
					<th class="text-center bmedium">Roles</th>
					<th class="text-center bmedium">Likes</th>
					<th class="text-center bmedium">Others</th>
					<th class="text-center bedium"
					style="background-color: #008000; color: #fff;">Status</th>
					<th class="text-center bedium"
					style="background-color: #fe6600; color: #fff;">
						OpenCredit</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>
<br>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 75%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"
				data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Details</h4>
            </div>
            <div class="modal-body">
                <h3 id="modal-Tittle"></h3>
                <div id="myBody">

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

	<!-- Modal LIKE -->
	<div class="modal fade" id="LikeModal" role="dialog" aria-labelledby="WholeSaleModal">
		<div class="modal-dialog" role="document" style="width: 50%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-titlelike" id="myModalLabel">Likes</h4>
				</div>
				<div class="modal-body">
					<div id="title_like_modal"></div>
					<div id="content_like_modal">
						<table id="likes_info"
						class="table table-bordered"></table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				</form>

			</div>
		</div>
	</div>
	
	<!-- Modal OCredit -->
	<div class="modal fade" id="OcreditModal" role="dialog" aria-labelledby="WholeSaleModal">
		<div class="modal-dialog" role="document" style="width: 50%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-titlelike" id="myModalLabel">OpenCredit</h4>
				</div>
				<div class="modal-body">
					<div id="title_ocredit_modal"></div>
					<div id="content_ocredit_modal">
						<table id="ocredit_info" class="table table-bordered"></table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				</form>

			</div>
		</div>
	</div>	
	
<!-- Modal -->
<div class="modal fade" id="myModal3" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 60%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Details</h4>
            </div>
            <div class="modal-body">
                <h3 id="modal-Tittle3"></h3>
                <div id="modal-bbody3">
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>	

<!-- Modal -->
<div class="modal fade" id="modalpayment" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Payment Details</h4>
            </div>
            <div class="modal-body">
                <h3 id="modal-Tittle"></h3>
                <table class='table table-bordered' cellspacing='0' width='100%' >
                        <tr>
                            <td style='background-color: #0000ff; color: #fff;'>Account Name</td>
                            <td>
                                <b><span id="account_name"></span></b>
                            </td>
                        </tr>
                        <tr>
                            <td style='background-color: #0000ff; color: #fff;'>Account Number</td>
                            <td>
                                <b><span id="account_number"></span></b>
                            </td>
                        </tr>
                        <tr>
                            <td style='background-color: #0000ff; color: #fff;'>Bank</td>
                            <td>
                                <b><span id="bank"></span></b>
                            </td>
                        </tr>
                        <tr>
                            <td style='background-color: #0000ff; color: #fff;'>Bank Code</td>
                            <td>
                                <b><span id="bank_code"></span></b>
                            </td>
                        </tr>
                        <tr>
                            <td style='background-color: #0000ff; color: #fff;'>IBAN</td>
                            <td>
                                <b><span id="iban"></span></b>
                            </td>
                        </tr>
                        <tr>
                            <td style='background-color: #0000ff; color: #fff;'>SWIFT</td>
                            <td>
                                <b><span id="swift"></span></b>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

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

<meta name="_token" content="{!! csrf_token() !!}"/>
<script type="text/javascript">
$(document).ready(function () {

	function pad (str, max) {
	  str = str.toString();
	  return str.length < max ? pad("0" + str, max) : str;
	}

			$(document).delegate( '.pwd_reset', "click",function (event) {
				var userid = $(this).attr("rel");
				var formData = {
					email: userid
				}				
				$.ajax({
					type: "POST",
					url: JS_BASE_URL + "/forgot_password",
					data: formData,
					dataType: 'json',
					success: function (data) {
						toastr.info("Password successfully sent!");
					},
					error: function (error) {
						toastr.warning("Password could not be changed!");
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
        else if ( cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper ) {
            // outside cached data - need to make a request
            ajax = true;
        }
        else if ( JSON.stringify( request.order )   !== JSON.stringify( cacheLastRequest.order ) ||
                  JSON.stringify( request.columns ) !== JSON.stringify( cacheLastRequest.columns ) ||
                  JSON.stringify( request.search )  !== JSON.stringify( cacheLastRequest.search )
        ) {
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
 
		var page=$('#product_pagination_page').val();
		var product_dtable=$('#grid4c').DataTable({
			"serverSide":false,
			"processing":true,
			"paging":true,
			"searching":{"regex":true},
			"ajax":{
				type:"GET",
				pages:5,
				url:JS_BASE_URL+"/paginate/buyer",
				dataSrc:function(json){
				
					var return_data=new Array();
					subcat_pids=[];
					for (var i=0;i <json.data.length;i++) {
						var d=json.data[i];
						subcat_pids.push(d.pid);
						return_data.push({
							'id': i+1,
							'buyer_id':'<a target="_blank" href="'+JS_BASE_URL+'/admin/popup/user/'+d.user_id+'">'+d.buyer_id+'</a>',
							'username':d.first_name + " " + d.last_name,
							'roles':'<a rel="' + d.user_id + '" class="roles" href="javascript:void(0)">Roles</a>',
							'likes':'<a rel="' + d.user_id + '" class="likes" href="javascript:void(0)">'+d.likes+'</a>',
							'others':'<a rel="' + d.email + '" class="others" target="_blank" href="'+JS_BASE_URL+'/admin/master/buyer/others/'+d.id+'">Others</a>',
							'status':'<a target="_blank" href="'+JS_BASE_URL+'/admin/master/buyer/approval/'+d.id+'">'+ucfirst(d.status)+'</a>',
							'ocredit':'<a href="'+JS_BASE_URL+"/admin/master/opencredit?buyer="+ d.buyer_id + '" target="_blank">{{$currentCurrency}}&nbsp;'+js_number_format(parseFloat(d.ocredit/100),2,'.',',')+'</a>'

						});


					}
					return return_data;
				}

			},
			"columns":[
				{data:'id',name:'buyer.created_at',className:'text-center no-sort'},
				{data:"buyer_id",name:'buyer_id',className:'text-center'},
				{data:"username",name:'username',className:'text-center'},
				{data:"roles",name:'roles',className:'text-center no-sort'},
				{data:"likes",name:'likes',className:'text-center'},
				{data:"others",name:'others',className:'text-center'},
				{data:"status",name:'status',className:'text-center'},
				{data:"ocredit",name:'ocredit',className:'text-center'},

			]
		});

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

var ocredit_info;
				$(document).delegate( '.ocredit', "click",function (event) {

                $('#title_ocredit_modal').html("");
                var currency = $('#currencyval').val();

                if(ocredit_info){
                    ocredit_info.destroy();
                    $('#ocredit_info').empty();
                }

                _this = $(this);

                var buyer_id= _this.attr('rel');

                var url = JS_BASE_URL+'/admin/master/buyer_ocredit/'+buyer_id;

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: 'json',
                    success: function (data) {

						console.log(data);
                      //  $('#title_sinfo_modal').append("<h2> Product: "+data[0].name + "</h2>");
                        $('#ocredit_info').append('<thead style="background-color: #0000ff; color: #fff;"><th style="text-align: center;">No</th><th style="text-align: center;">Order ID</th><th style="text-align: center;">Source</th><th style="text-align: center;">Total</th></thead>');
                        $('#ocredit_info').append('<tbody>');
                        for (i=0; i < data.length; i++) {
                            var obj = data[i];
                            console.log(obj.mode);
                            $('#ocredit_info').append('<tr><td style="text-align: center;">' + (i+1).toString() +'</td><td style="text-align: center;"><a target="_blank" href="' + JS_BASE_URL + '/deliveryorder/'+obj.porder_id+'">'+ obj.nporder_id +'</a></td><td style="text-align: center;">' + obj.source +'&nbsp;('+obj.mode+')</td><td style="text-align: center;">{{$currentCurrency}}&nbsp' + js_number_format(parseFloat(obj.value)/100,2,'.',',') + ' </td></tr>');
                        }
                        $('#ocredit_info').append('</tbody>');

                        ocredit_info = $('#ocredit_info').DataTable({
                            'autoWidth':false,
                             "order": [],
                             "iDisplayLength": 10,
                             "columns": [
                                { "width": "20px", "orderable": false },
                                { "width": "85px" },
                                { "width": "85px" },
                                { "width": "40px" }
                              ]
                        });

                        $("#OcreditModal").modal("show");
                    },
                    error: function (error) {
                        console.log(error);
                    }

                });

            });			
			
var likes_info;
				$(document).delegate( '.likes', "click",function (event) {

                $('#title_like_modal').html("");
                var currency = $('#currencyval').val();

                if(likes_info){
                    likes_info.destroy();
                    $('#likes_info').empty();
                }

                _this = $(this);

                var buyer_id= _this.attr('rel');

                var url = JS_BASE_URL+'/admin/master/buyer_likes/'+buyer_id;

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: 'json',
                    success: function (data) {

						console.log(data);
                      //  $('#title_sinfo_modal').append("<h2> Product: "+data[0].name + "</h2>");
                        $('#likes_info').append('<thead style="background-color: #0000ff; color: #fff;"><th style="text-align: center;">No</th><th style="text-align: center;">Product ID</th><th style="text-align: center;">Since</th></thead>');
                        $('#likes_info').append('<tbody>');
                        for (i=0; i < data.length; i++) {
                            var obj = data[i];
							if(i==0){
								$('#title_like_modal').append("<h2> Buyer: "+ obj.first_name + " " + obj.last_name + "</h2>");
							}
                            $('#likes_info').append('<tr><td style="text-align: center;">' + (i+1).toString() +'</td><td style="text-align: center;"><a target="_blank" href="' + JS_BASE_URL + '/productconsumer/'+obj.product_id+'">'+ obj.nproduct_id +'</a></td><td style="text-align: center;">' + obj.since + ' </td></tr>');
                        }
                        $('#likes_info').append('</tbody>');

                        likes_info = $('#likes_info').DataTable({
                            'autoWidth':false,
                             "order": [],
                             "iDisplayLength": 10,
                             "columns": [
                                { "width": "20px", "orderable": false },
                                { "width": "85px" },
                                { "width": "40px" }
                              ]
                        });

                        $("#LikeModal").modal("show");
                    },
                    error: function (error) {
                        console.log(error);
                    }

                });

            });

	// $('.interest').click(function(){
	$(document).delegate( '.interest', "click",function (event) {// <-- notice where the selector and event is
		_this = $(this);
		var user_id= _this.attr('rel');

		$('#modal-Tittle').html("Interests");

		var url = JS_BASE_URL+'/admin/master/buyer_interest/'+ user_id;
			$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			success: function (data) {
				var html = "<table class='table table-bordered' cellspacing='0' width='100%''><tr style='background-color: #0000ff; color: #fff;'><th>No</th><th>Category</th><th>Subcategory Level</th><th>Subcategory</th></tr>";
				for (i=0; i < data.length; i++) {
					var obj = data[i];
					//console.log("html="+html);
					html = html + "<tr><td>"+ (i+1) +"</td><td>"+obj.query.catdescription+"</td><td>"+obj.level+"</td><td>"+obj.query.description+"</td></tr>";
				}
				html = html + "</table>";
				$('#myBody').html(html);
				$("#myModal").modal("show");
		  	}
		});

	});

	// $('.address').click(function(){
	$(document).delegate( '.address', "click",function (event) {// <-- notice where the selector and event is
		_this = $(this);
		var user_id= _this.attr('rel');

		$('#modal-Tittle3').html("Addresses");

		var url = JS_BASE_URL+'/admin/master/buyer_address/'+ user_id;
			$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			success: function (data) {
				var html = "";
				var add_desc = "";
				console.log()
				for (i=0; i < data.length; i++) {
					var obj = data[i];
					if(i==0){
						add_desc = "Default Address";
					} else if(i==1){
						add_desc = "Billing Address";
					} else if(i==2){
						add_desc = "Delivery Address";
					}
					html = html + "<div class='row'><div class='col-sm-3'><b>"+add_desc+"</b></div><div class='col-sm-9'><div class='col-sm-12'>"+obj.description+"</div><br><div class='col-sm-6'><b>Country: </b>"+obj.countryname+"</div><div class='col-sm-6'><b>State: </b>"+obj.statename+"</div><br><div class='col-sm-6'><b>City: </b>"+obj.cityname+"</div><div class='col-sm-6'><b>Area: </b>"+obj.areaname+"</div><br><div class='col-sm-6'><b>Postcode: </b>"+obj.postcode+"</div><div class='col-sm-6'></div></div></div><br>";
				}
				$('#modal-bbody3').html(html);
				$("#myModal3").modal("show");
		  	}
		});

	});

	// $('.payment').click(function(){
	$(document).delegate( '.payment', "click",function (event) {// <-- notice where the selector and event is
		_this = $(this);
		var buyer_id= _this.attr('rel');

		$('#modal-Tittle').html("Payments");

		var url = JS_BASE_URL+ '/admin/master/buyer_payment_method/'+ buyer_id;
			$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			success: function (data) {
				$("#account_name").text(data[0]);
				$("#account_number").text(data[1]);
				$("#bank").text(data[2]);
				$("#bank_code").text(data[3]);
				$("#iban").text(data[4]);
				$("#swift").text(data[5]);
				$("#modalpayment").modal("show");
		  	}
		});

	});

	//$('.roles').on('click',function(){
	$(document).delegate( '.roles', "click",function (event) {// <-- notice where the selector and event is
		_this = $(this);
		var buyer_id= _this.attr('rel');

		$('#modal-Tittle').html("Roles");

		var url = JS_BASE_URL+'/admin/master/buyer_roles/'+ buyer_id;
			$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			success: function (data) {
			//	console.log(data);
				var empdis = 0;
				var btnedis = 0;
				var btnedise = 0;
				var otherdis = 0;
				var str = "Inactive";
				var strd = "";
				var strc = "";
				var strr = "";
				var strv = 0;
				var strrid = 0;
				if(data[1] > 0){
					str = "Active";
					strd = "";
					strv = 0;
					strc = "checked";
					empdis++;
					btnedis++;
					if(data[7] != ""){
						
						//strd = "disabled='disabled'";
						strv = 0;
						strr = "["+pad(data[13],10)+"]";
						strrid = data[13];
					}
				}
				var mct = "Inactive";
				var mctd = "";
				var mctc = "";
				var mctr = "";
				var mctv = 0;
				var mctrid = 0;
				if(data[2] > 0){
					mct = "Active";
					mctd = "";
					mctv = 0;
					mctc = "checked";
					empdis++;
					btnedis++;
					if(data[8] != ""){

						//mctd = "disabled='disabled'";
						mctv = 0;
						mctr = "["+pad(data[14],10)+"]";
						mctrid = data[14];
					}
				}
				var emp = "Inactive";
				var empd = "";
				var empc = "";
				var empr = "";
				var empv = 0;
				var emprid = 0;
				//console.log(data);
				if(data[0] > 0){
					emp = "Active";
					empd = "";
					empv = 1;
					empc = "checked";
					otherdis++;
					if(data[6] != ""){

						empv = 0;
						//empd= "disabled='disabled'";
						emprid=data[12];
						empr = "["+pad(data[12],10)+"]";
					}
					btnedise++;
				}
				if(empdis > 0){
				//	empd= "disabled='disabled'";
				}
				if(otherdis > 0){
				//	strd= "disabled='disabled'";
				//	mctd= "disabled='disabled'";
				}				
				var mcp = "Inactive";
				//var mcpd = "disabled='disabled'";
				var mcpc = "";
				var mcpr = "";
				var mcpv = 0;
				if(data[3] > 0){
					mcp = "Active";
					mcpd = "";
					mcpv = 1;
					if(data[9] != "" && data[9] != "pending"){
						mcpc = "checked";
						mcpd = "disabled='disabled'";
						mcpv = 0;
						mcpr ="["+pad(data[15],10)+"]";
					}
				}
				var psh = "Inactive";
				var pshd = "disabled='disabled'";
				var pshc = "";
				var pshr = "";
				var pshv = 0;
				if(data[4] > 0){
					psh = "Active";
					pshd = "";
					pshv = 1;
					if(data[10] != "" && data[10] != "pending"){
						pshc= "checked";
						pshd = "disabled='disabled'";
						pshv = 0;
						pshr = "["+pad(data[16],10)+"]";
					}
				}
				var smm = "Inactive";
				var smmd = "disabled='disabled'";
				var smmc = "";
				var smmr = "";
				var smmv = 0;
				if(data[5] > 0){
					smm = "Active";
					smmd = "";
					smmv = 1;
					if(data[11] != "" && data[11] != "pending"){
						smmc = "checked";
						smmd = "disabled='disabled'";
						smmv = 0;
						smmr = "["+pad(data[17],10)+"]";
					}
				}

				var bcp = "Inactive";
				if(parseInt(data[19]) > 0){
					bcp = "Active";
				}
				
				var html = "<table class='table table-bordered' cellspacing='0' width='100%'' ><tr style='background-color: #0000ff; color: #fff;'><th>Admin</th><th>Role</th><th>Appointment</th><th>RecruiterID</th></tr>";
				html = html + "<tr><td></td><td>Buyer</td><td style='color:red;'>"+bcp+"</td><td></td></tr>";
				html = html + "<tr><td><input type='checkbox' id='emp' "+empd+" value='"+empv+"' "+empc+"></td><td>Employee</td><td style='color:red;'>"+emp+"</td><td><select "+empd+" id='emp_rec'><option value='0'>Choose Recruiter</option></select><input type='hidden' id='emp_recid' value='"+emprid+"' /></td></td></tr>";
				html = html + "<tr><td><input type='checkbox' id='mct' "+mctd+" value='"+mctv+"' "+mctc+"></td><td>Merchant Consultant</td><td style='color:red;'>"+mct+"</td><td><select "+mctd+" id='mc_rec'><option value='0'>Choose Recruiter</option></select><input type='hidden' id='mc_recid' value='"+mctrid+"' /></td></tr>";
				html = html + "<tr><td></td><td>Merchant Professional</td><td style='color:red;'>"+mcp+"</td><td>"+mcpr+"</td></tr>";
				html = html + "<tr><td></td><td>Merchant Professional</td><td style='color:red;'>"+mcp+"</td><td>"+mcpr+"</td></tr>";
				html = html + "<tr><td></td><td>Professional Integrator</td><td style='color:red;'>"+psh+"</td><td>"+pshr+"</td></tr>";
				html = html + "<tr><td></td><td>SMM</td><td style='color:red;'>"+smm+"</td><td></td></tr>";
				html = html + "</table>";
				
				//if(btnedise == 0 && btnedis <= 1){
					html = html + "<a class='btn btn-primary btnedit' href='javascript:void(0)' rel='"+buyer_id+"' > Save</a>";
			//	}	
				html = html + '<p align="right" style=" float:right; position: relative; display:none;" id="btnedit_spinner"><i class="fa-li fa fa-spinner fa-spin fa-2x fa-fw" style=" float:right;"></i></p><br><br>';
				$('#myBody').html(html);
				for (i=0; i < data[18].length; i++) {
					var obj = data[18][i];
					//console.log(obj);
					var selected_mct = "";
					if(obj.id == mctrid){
						selected_mct = "selected";
					}
					var selected_str = "";
					if(obj.id == strrid){
						selected_str = "selected";
					}
					var selected_emp = "";
					if(obj.id == emprid){
						selected_emp = "selected";
					}
					$("#str_rec").append('<option value="'+obj.id+'" '+selected_str+'>'+obj.bid+' - '+obj.first_name+' '+obj.last_name+'</option>');
					$("#mc_rec").append('<option value="'+obj.id+'" '+selected_mct+'>'+obj.bid+' - '+obj.first_name+' '+obj.last_name+'</option>');
					$("#emp_rec").append('<option value="'+obj.id+'" '+selected_emp+'>'+obj.bid+' - '+obj.first_name+' '+obj.last_name+'</option>');
					
				}
				$("#str_rec").select2();
				$("#mc_rec").select2();
				$("#emp_rec").select2();			
				$("#myModal").modal("show");
				
				 $('#mct').change(function () {
					 if($(this).is(":checked") || $('#str').is(":checked")){
						 $("#emp").attr("disabled",true);
						 $("#emp_rec").attr("disabled",true);
						 $("#emp").prop( "checked", false );
					 } else {
						 $("#emp").attr("disabled",false);
						 $("#emp_rec").attr("disabled",false);
					 }
				 });
				 
				 $('#str').change(function () {
					 if($(this).is(":checked") || $('#mct').is(":checked")){
						 $("#emp").attr("disabled",true);
						 $("#emp_rec").attr("disabled",true);
					 } else {
						 $("#emp").attr("disabled",false);
						 $("#emp_rec").attr("disabled",false);
					 }
				 });	

				 $('#emp').change(function () {
					 if($(this).is(":checked")){
						 $("#str").attr("disabled",true);
						 $("#str_rec").attr("disabled",true);
						 $("#mct").attr("disabled",true);
						 $("#mct").prop( "checked", false );
						 $("#mc_rec").attr("disabled",true);						 
					 } else {
						 $("#str").attr("disabled",false);
						 $("#str_rec").attr("disabled",false);
						 $("#mct").attr("disabled",false);
						 $("#mc_rec").attr("disabled",false);	
					 }
				 });					 
				 
				 $('#mc_rec').change(function () {
					 $('#mc_rec').removeClass("error_rec");
					 $('#mc_recid').val($(this).val());
				 });
				 
				 $('#str_rec').change(function () {
					 $('#str_rec').removeClass("error_rec");
					 $('#str_recid').val($(this).val());
				 });	

				 $('#emp_rec').change(function () {
					 $('#emp_rec').removeClass("error_rec");
					 $('#emp_recid').val($(this).val());
				 });				 				
			
				$('.btnedit').click(function(){
					_this = $(this);
					$('.btnedit').hide();
					$('#btnedit_spinner').show();
					var c = 0;
					var cerr = 0;
					var emp = 0;
					var err_str = 0;
					var str = 0;
					var mc = 0;
					var mc_recid = $("#mc_recid").val();
					var str_recid = $("#str_recid").val();
					var emp_recid = $("#emp_recid").val();
					var appt= "";
					var appterr= "";
					var user_id= _this.attr('rel');
					$('.btnedit').html("Saving...");
					if ($("#emp").is(':checked')){
						appt= appt + "Employee";
						emp = 1;
						c++;
					}	
						
					//console.log("Actualizar Empleado");
					if(emp == 1 && emp_recid == 0){
						$("#emp_rec").addClass("error_rec");
						appterr= appterr + "Employee";
						err_str = 1;
						cerr++;
					} else {
						if(emp == 1 && (emp_recid == user_id)){
							$("#emp_rec").addClass("error_rec");
							err_str = 2;							
						} else {
							if(emp == 1){
								var url = JS_BASE_URL+'/admin/master/buyer_edit/'+ user_id + '/employee/' + emp + '/' + emp_recid;
								$.ajax({
								  url: url,
								  type: "post",
								  async: "false",
								  success: function(data){

								  }
								});									
							}
						}						
					}					

						
					
					if ($("#str").is(':checked')){
						if(c > 0){
							appt= appt + "/";
						}
						appt= appt + "Station Recruiter";
						c++;	
						str = 1;
					}
					if(str == 1 && str_recid == 0){
						$("#str_rec").addClass("error_rec");
						appterr= appterr + "Station Recruiter";
						err_str = 1;
						cerr++;
					} else {
						if(str == 1 && (str_recid == user_id)){
							$("#str_rec").addClass("error_rec");
							err_str = 2;							
						} else {
							if(str == 1){
								var url = JS_BASE_URL+'/admin/master/buyer_edit/'+ user_id + '/str/' + str + '/' + str_recid;
								$.ajax({
								  url: url,
								  type: "post",
								  async: "false",
								  success: function(data){

								  }
								});									
							}				
						}						
					}
					
					if ($("#mct").is(':checked')){
						if(c > 0){
							appt= appt + "/";
						}
						appt= appt + "Merchant Consultant";		
						mc = 1;
						c++;
					}
					if(mc == 1 && mc_recid == 0){
						$("#mc_rec").addClass("error_rec");
						if(cerr > 0){
							appterr= appterr + "/";
						}
						appterr= appterr + "Merchant Consultant";							
						err_str = 1;
					} else {
						if(mc == 1 && (mc_recid == user_id)){
							$("#mc_rec").addClass("error_rec");
							err_str = 2;							
						} else {
							if(mc == 1){
								var url = JS_BASE_URL+'/admin/master/buyer_edit/'+ user_id + '/mct/' + mc + '/' + mc_recid;
								$.ajax({
								  url: url,
								  type: "post",
								  async: "false",
								  success: function(data){

								  }
								});									
							}
						}
					}				
					$('#btnedit_spinner').hide();
					if (c > 0){
						if(err_str == 1){
							toastr.error("Please key in RecruiterID for: " + appterr);
						} else {
							if(err_str == 2){
								toastr.error("User can't be the same as recruiter!");
							} else {
								toastr.info("This person has been appointed as: " + appt);
							}
						}
						
					}

					$('.btnedit').html("Save");
					//location.reload();
					//var commission = $('#mc_c' + mc_id).val();
					/*var url = '/admin/commission/sales_staff/'+ mc_id;
					$.ajax({
					  url: url,
					  type: "post",
					  data: {'commission': commission},
					  success: function(data){
						location.reload();
					  }
					});		*/
					
					$("#myModal").modal("hide");
				});
		  	}
		});

	});

	// $(".mcrid").click(function () {
    $(document).delegate( '.mcrid', "click",function (event) {
		_this = $(this);
		var id_buyer= _this.attr('rel');

		$('#modal-Tittle2').html("Remarks");

		var url = JS_BASE_URL+'/admin/master/buyer_remarks/'+ id_buyer;
		$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			success: function (data) {
				console.log(data);
				var html = "<table class='table table-bordered' cellspacing='0' width='100%' ><tr style='background-color: #0000ff; color: white;'><th>No</th><th>Buyer ID</th><th>Status</th><th>Admin User ID</th><th>Remarks</th><th>DateTime</th></tr>";
				for (i=0; i < data.length; i++) {
					var obj = data[i];
					html += "<tr>";
					html += "<td>"+(i+1)+"</td>";
					html += "<td><a href='../../admin/popup/user/"+id_buyer+"' class='update' data-id='"+id_buyer+"'>"+pad(id_buyer.toString(),10)+"</a></td>";
					html += "<td>"+obj.status+"</td>";
					html += "<td><a href='../../admin/popup/user/"+obj.user_id+"' class='update' data-id='"+obj.user_id+"'>"+pad(obj.user_id.toString(),10)+"</td>";
					html += "<td>"+obj.remark+"</td>";
					html += "<td>"+obj.created_at+"</td>";
					html += "</tr>";
				}
				html = html + "</table>";
				$('#myBody2').html(html);
				$("#myModal2").modal("show");
			}
		});
	});

});
</script>

@stop
