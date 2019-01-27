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

	<h2>Token Master</h2>
	<span  id="merchant-error-messages">
    </span>
	<div class="col-sm-4">
		&nbsp;
	</div>
	<div class="col-sm-2">
		<b>Total Issued</b>
	</div>
	<div class="col-sm-2">
		<span id="total_issued_token"></span>
	</div>
	<div class="col-sm-2">
		<b>Total Paid Token</b>
	</div>
	<div class="col-sm-2">
		<span id="total_paid_token"></span>
	</div>
	<div class="clearfix"></div>
	<div class="col-sm-4">
		&nbsp;
	</div>
	<div class="col-sm-2">
		<b>Total Used</b>
	</div>
	<div class="col-sm-2">
		<span id="total_used_token"></span>
	</div>
	<div class="col-sm-2">
		<b>Total Free Token</b>
	</div>
	<div class="col-sm-2">
		<span id="total_free_token"></span>
	</div>
	<div class="clearfix"></div>
	<div class="col-sm-4">
		&nbsp;
	</div>
	<div class="col-sm-2">
		<b>Total Balance</b>
	</div>
	<div class="col-sm-2">
		<span id="total_balance_token"></span>
	</div>
	<div class="col-sm-2">
		<a href="javascript:void(0)" class="btn btn-primary btn-danger allTransactions">
			All Transactions
		</a>
	</div>	
	<div class="clearfix"></div>
	<br>
	<div class="table-responsive">
		<table class="table table-bordered" cellspacing="0" width="100%" id="gridmerchant">
			<thead style="background-color: #400080; color: white;">
				<tr>
					<th class="no-sort text-center bsmall">No</th>
					<th class="text-center medium">Token&nbsp;Owner</th>
					<th class="text-center large">Name</th>
					<th class="text-center medium">Issued</th>
					<th class="text-center medium">Used</th>
					<th class="text-center medium">Balance</th>
					<th class="text-center medium">Tied&nbsp;To</th>
					<th class="text-center medium">Log</th>
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
{{--  --}}
	<!-- Modal LIKE -->
	<div class="modal fade" id="FacilitiesModal" role="dialog" aria-labelledby="WholeSaleModal">
		<div class="modal-dialog" role="document" style="width: 50%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
					<h4 class="modal-titlelike" id="myModalLabel">Facilities</h4>
				</div>
				<div class="modal-body">
					<div id="title_facilities_modal"></div>
					<div id="content_facilities_modal">
						<table id="facilities_info" class="table table-bordered"></table>
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
	<div class="modal fade" id="LogModal" role="dialog" aria-labelledby="WholeSaleModal">
		<div class="modal-dialog" role="document" style="width: 50%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
					<h4 class="modal-titlelike" id="myModalLabel">Token Log</h4>
				</div>
				<div class="modal-body">
					<div id="content_log_modal">
						<table id="log_info" class="table table-bordered"></table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>

			</div>
		</div>
	</div>	
	
	<div class="modal fade" id="TransactionModal" role="dialog" aria-labelledby="WholeSaleModal">
		<div class="modal-dialog" role="document" style="width: 50%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
					<h4 class="modal-titlelike" id="myModalLabel">Token Transactions</h4>
				</div>
				<div class="modal-body">
					<div id="content_transaction_modal">
						<table id="transaction_info" class="table table-bordered"></table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>

			</div>
		</div>
	</div>		
	
	<div class="modal fade" id="AllTransactionModal" role="dialog" aria-labelledby="WholeSaleModal">
		<div class="modal-dialog" role="document" style="width: 80%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
					<h4 class="modal-titlelike" id="myModalLabel">Token All Transactions</h4>
				</div>
				<div class="modal-body">
					<div id="content_transaction_modal">
						<table id="all_transaction_info" class="table table-bordered"></table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>

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
	
	<div class="modal fade" id="IssuedModal" role="dialog" aria-labelledby="WholeSaleModal">
		<div class="modal-dialog" role="document" style="width: 25%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
					<h4 class="modal-titlelike" id="myModalLabel">Tokens</h4>
				</div>
				<div class="modal-body">
					<div id=""></div>
					<div id="">
						<table id="" class="table table-bordered">
							<tr style="background-color: #400080; color: #fff;">
								<td style="text-align:center">Paid Token</td>
								<td style="text-align:center">Free Token</td>
							</tr>
							<tr>
								<td style="text-align: center;"><span id="paid_token"></span></td>
								<td style="text-align: center;"><span id="free_token"></span></td>
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

<meta name="_token" content="{!! csrf_token() !!}"/>
<script type="text/javascript">
$(document).ready(function () {
	 $('.hover-long-text').tooltip();
    function pad (str, max) {
        str = str.toString();
        return str.length < max ? pad("0" + str, max) : str;
    }

	function toTitleCase(str)
	{
	    return str.replace(/\w\S*/g,
			function(txt){return txt.charAt(0).toUpperCase() +
				txt.substr(1).toLowerCase();});
	}

	var facilities_info;
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

			
			$(document).delegate( '.facilities_details', "click",function (event) {
            //$(".likes_infoa").click(function () {

                if(facilities_info){
                    facilities_info.destroy();
                    $('#facilities_info').empty();
                }

                _this = $(this);

                var user_id= _this.attr('rel');

                var url = '/admin/token/facilities/'+user_id;
				$('#facilities_info').html("");
                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: 'json',
                    success: function (data) {

						console.log(data);
                      //  $('#title_sinfo_modal').append("<h2> Product: "+data[0].name + "</h2>");
                        $('#facilities_info').append('<thead style="background-color: #400080; color: #fff;"><th style="text-align:center">No</th><th style="text-align:center">Facility</th><th style="text-align:center">Annual Fee</th><th style="text-align:center">Variable Fee</th><th style="text-align:center">Since</th></thead>');
                        $('#facilities_info').append('<tbody>');
                        for (i=0; i < data.length; i++) {
                            var obj = data[i];
                            $('#facilities_info').append('<tr><td style="text-align: center;">' + (i+1).toString() +'</td><td style="text-align: center;">'+obj.description +'</td><td style="text-align: center;"><input type="text" size="8" style="display: none;" class="subs_fee_input" rel="'+obj.id +'" value="'+obj.token_subscription_fee +'" /><span class="spantoks" style="display: none;">&nbsp;Tokens</span><span class="subs_fee_text" rel="'+obj.id +'">'+obj.token_subscription_fee +'</span></td><td style="text-align: center;"><a href="javascript:void(0);" class="variable_fee" rel="'+obj.token_admin_fee+'" nrel="'+obj.variable_fee_name+'" idrel="'+obj.id+'">Variable</a></td><td style="text-align: center;">' + obj.since + ' </td></tr>');
                        }
						
                        $('#facilities_info').append('</tbody>');

                    /*    facilities_info = $('#facilities_info').DataTable({
                            'autoWidth':false,
                             "order": [],
                             "iDisplayLength": 10,
                             "columns": [
                                { "width": "20px", "orderable": false },
                                { "width": "85px" },
                                { "width": "40px" }
                              ]
                        });*/

                        $("#FacilitiesModal").modal("show");
                    },
                    error: function (error) {
                        console.log(error);
                    }

                });

            });
			
			var log_info;
			$(document).delegate( '.log_details', "click",function (event) {
            //$(".likes_infoa").click(function () {

              //  $('#title_log_modal').html("Token Log");

                if(log_info){
                    log_info.destroy();
                    $('#log_info').empty();
                }

                _this = $(this);

                var user_id= _this.attr('rel');

                var url = '/admin/token/log/'+user_id;

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: 'json',
                    success: function (data) {

						console.log(data);
						console.log(data.length);
                      //  $('#title_sinfo_modal').append("<h2> Product: "+data[0].name + "</h2>");
                        $('#log_info').append('<thead style="background-color: #400080; color: #fff;"><th style="text-align:center">No</th><th style="text-align:center">Facility</th><th style="text-align:center">Tokens</th><th style="text-align:center">Date</th></thead>');
                        $('#log_info').append('<tbody>');
						var symbol = "";
						var free = "";
						var ii = 1;
                       $.each( data, function( i, val ) {
                            
							console.log(i);
							//console.log(val.facility);
							symbol = "";
							free = "";
							if(val.symbol == "minus"){
								symbol = "-";	
							}
							if(val.isfree == "yes"){
								free = "<span style='color: green;'>(Free)</span>";	
							}
							if(val.isfree == "no"){
								free = "<span style='color: red;'>(Bought)</span>";	
							}
                            $('#log_info').append('<tr><td style="text-align: center;">' + (ii).toString() +'</td><td style="text-align: center;">'+val.facility +'</a></td><td style="text-align:center;">' + symbol + val.value + '&nbsp;' + free + ' </td><td style="text-align: center;">' + val.since + ' </td></tr>');
							ii++;
                        });
                        $('#log_info').append('</tbody>');

                        log_info = $('#log_info').DataTable({
                            'autoWidth':false,
                             "order": [],
                             "iDisplayLength": 10,
                             "columns": [
                                { "width": "20px", "orderable": false },
                                { "width": "85px" },
                                { "width": "40px" },
                                { "width": "40px" }
                              ]
                        });

                        $("#LogModal").modal("show");
                    },
                    error: function (error) {
                        console.log(error);
                    }

                });

            });	

			var all_transaction_info;
			$(document).delegate( '.allTransactions', "click",function (event) {
            //$(".likes_infoa").click(function () {

              //  $('#title_log_modal').html("Token Log");

                if(all_transaction_info){
                    all_transaction_info.destroy();
                    $('#all_transaction_info').empty();
                }

                _this = $(this);

                var user_id= _this.attr('rel');

                var url = '/admin/token/alltransactions/';

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: 'json',
                    success: function (data) {

						console.log(data);
						console.log(data.length);
                      //  $('#title_sinfo_modal').append("<h2> Product: "+data[0].name + "</h2>");
                        $('#all_transaction_info').append('<thead style="background-color: #400080; color: #fff;"><th style="text-align:center">No</th><th style="text-align:center">Name</th><th style="text-align:center">Action</th><th style="text-align:center">Facility</th><th style="text-align:center">Tokens</th><th style="text-align:center">Date</th></thead>');
                        $('#all_transaction_info').append('<tbody>');
						var symbol = "";
						var free = "";
						var ii = 1;
                       $.each( data, function( i, val ) {
                            
							console.log(i);
							//console.log(val.facility);
							symbol = "";
							free = "";
							if(val.symbol == "minus"){
								symbol = "-";	
							}
							if(val.isfree == "yes"){
								free = "<span style='color: green;'>(Free)</span>";	
							}
							if(val.isfree == "no"){
								free = "<span style='color: red;'>(Bought)</span>";	
							}
                            $('#all_transaction_info').append('<tr><td style="text-align: center;">' + (ii).toString() +'</td><td style="text-align: center;">'+val.name +'</td><td style="text-align: center;">'+val.action +'</td><td style="text-align: center;">'+val.facility +'</td><td style="text-align:center;">' + symbol + val.value + ' </td><td style="text-align: center;">' + val.since + ' </td></tr>');
							ii++;
                        });						
                        $('#all_transaction_info').append('</tbody>');

                        all_transaction_info = $('#all_transaction_info').DataTable({
                            'autoWidth':false,
                             "order": [],
                             "iDisplayLength": 10,
                             "columns": [
                                { "width": "20px", "orderable": false },
                                { "width": "85px" },
                                { "width": "85px" },
                                { "width": "85px" },
                                { "width": "40px" },
                                { "width": "40px" }
                              ]
                        });

                        $("#AllTransactionModal").modal("show");
                    },
                    error: function (error) {
                        console.log(error);
                    }

                });

            });				
			
			var transaction_info;
			$(document).delegate( '.transaction_details', "click",function (event) {
            //$(".likes_infoa").click(function () {

              //  $('#title_log_modal').html("Token Log");

                if(transaction_info){
                    transaction_info.destroy();
                    $('#transaction_info').empty();
                }

                _this = $(this);

                var user_id= _this.attr('rel');

                var url = '/admin/token/transaction/'+user_id;

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: 'json',
                    success: function (data) {

						console.log(data);
						console.log(data.length);
                      //  $('#title_sinfo_modal').append("<h2> Product: "+data[0].name + "</h2>");
                        $('#transaction_info').append('<thead style="background-color: #400080; color: #fff;"><th style="text-align:center">No</th><th style="text-align:center">Facility</th><th style="text-align:center">Tokens</th><th style="text-align:center">Date</th></thead>');
                        $('#transaction_info').append('<tbody>');
						var symbol = "";
						var free = "";
						var ii = 1;
                       $.each( data, function( i, val ) {
                            
							console.log(i);
							//console.log(val.facility);
							symbol = "";
							free = "";
							if(val.symbol == "minus"){
								symbol = "-";	
							}
							if(val.isfree == "yes"){
								free = "<span style='color: green;'>(Free)</span>";	
							}
							if(val.isfree == "no"){
								free = "<span style='color: red;'>(Bought)</span>";	
							}
                            $('#transaction_info').append('<tr><td style="text-align: center;">' + (ii).toString() +'</td><td style="text-align: center;">'+val.facility +'</a></td><td style="text-align:center;">' + symbol + val.value + '&nbsp;' + free + ' </td><td style="text-align: center;">' + val.since + ' </td></tr>');
							ii++;
                        });						
                        $('#transaction_info').append('</tbody>');

                        transaction_info = $('#transaction_info').DataTable({
                            'autoWidth':false,
                             "order": [],
                             "iDisplayLength": 10,
                             "columns": [
                                { "width": "20px", "orderable": false },
                                { "width": "85px" },
                                { "width": "40px" },
                                { "width": "40px" }
                              ]
                        });

                        $("#TransactionModal").modal("show");
                    },
                    error: function (error) {
                        console.log(error);
                    }

                });

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
 
		var page=$('#gridmerchant_page').val();
		var product_dtable=$('#gridmerchant').DataTable({
			"serverSide":false,
			"processing":true,
			"paging":true,
			"searching":{"regex":true},
			"ajax":{
				type:"GET",
				pages:5,
				url:JS_BASE_URL+"/paginate/token",
				dataSrc:function(json){				
					var return_data=new Array();
					subcat_pids=[];
					var total_issued_token = 0;
					var total_paid_token = 0;
					var total_free_token = 0;
					var total_used_token = 0;
					var total_balance_token = 0;
					for (var i=0;i <json.data.length;i++) {
						var d=json.data[i];
						subcat_pids.push(d.pid);
						total_issued_token += (parseInt(d.tpaid) + parseInt(d.tfree));
						var issued_token = (parseInt(d.tpaid) + parseInt(d.tfree));
						total_paid_token += d.tpaid;
						console.log(d.tpaid);
						total_free_token += d.tfree;
						total_used_token += d.used;
						total_balance_token += d.qty;
						return_data.push({
							'id': i+1,
							'token_owner':'<a href="javascript:void(0)" class="view-merchant-modal" data-id="'+d.merchant_id+'">'+d.seller_id+'</a>',
							'company_name':d.company_name,
							'issued':'<a href="javascript:void(0)" class="total_token" rel-paid="'+d.tpaid+'" rel-free="'+d.tfree+'">'+ issued_token +'</a>',
							'paid':d.used,
							'balance':d.qty,
							'tied_to':'<a class="facilities_details" rel="'+d.user_id+'"  href="javascript:void(0)">Facilities</a>',
							'log':'<a class="log_details" rel="'+d.user_id+'"  href="javascript:void(0)">Log</a>'

						});
					}
					$("#total_issued_token").html(js_number_format(total_issued_token,0,'.',','));
					$("#total_paid_token").html(js_number_format(total_paid_token,0,'.',','));
					$("#total_free_token").html(js_number_format(total_free_token,0,'.',','));
					$("#total_used_token").html(js_number_format(total_used_token,0,'.',','));
					$("#total_balance_token").html(js_number_format(total_balance_token,0,'.',','));
					return return_data;
				}
			},
			"columns":[
				{data:'id',name:'created_at',className:'text-center no-sort'},
				{data:"token_owner",name:'token_owner',className:'text-center'},
				{data:"company_name",name:'company_name',className:'text-center'},
				{data:"issued",name:'issued',className:'text-center no-sort'},
				{data:"paid",name:'paid',className:'text-center no-sort'},
				{data:"balance",name:'balance',className:'text-center no-sort'},
				{data:"tied_to",name:'tied_to',className:'text-center'},
				{data:"log",name:'log',className:'text-center'}

			]
		});

    function removeMessage() {
        $('.removeable').fadeOut(7000);
//            $('.removeable').remove();
    }
    setTimeout(removeMessage, 2000);

	$(window).resize();
});
	$(document).delegate( '.view-merchant-modal', "click",function (event) {
	//$('.view-merchant-modal').click(function(){

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
		var msg="<div class=' alert alert-danger'>"+r.long_message+"</div>";
		$('#merchant-error-messages').html(msg);
		}
		}
		});
	});


        $('.view-station-modal').click(function(){

            var station_id=$(this).attr('data-id');
            var check_url=JS_BASE_URL+"/admin/popup/lx/check/station/"+station_id;
            $.ajax({
                url:check_url,
                type:'GET',
                success:function (r) {
                    if (r.status=="success") {
                    var url=JS_BASE_URL+"/admin/popup/station/"+station_id;
                    var w=window.open(url,"_blank");
                    w.focus();
                    }
                    if (r.status=="failure") {
                        var msg="<div class='alert alert-danger'>"+r.long_message+"</div>";
                        $('#station-error-messages').html(msg);
                    }
                }
            });


        });

window.setInterval(function(){
              $('#merchant-error-messages').empty();
            }, 10000);


</script>
@yield("left_sidebar_scripts")
@stop
