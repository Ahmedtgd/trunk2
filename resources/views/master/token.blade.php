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
	<div class="table-responsive">
		<table class="table table-bordered" cellspacing="0" width="100%" id="gridmerchant">
			<thead style="background-color: #FF4C4C; color: white;">
				<tr>
					<th class="no-sort text-center bsmall">No</th>
					<th class="text-center medium">Token&nbsp;Owner</th>
					<th class="text-center medium">Qty&nbsp;Left</th>
					<th class="text-center medium">Tied&nbsp;To</th>
					<th class="text-center medium">Log</th>
				</tr>
			</thead>
			<tbody>
				<?php $m = 0; ?>
				@foreach($tokens as $token)
				<?php $m++; ?>
				<tr>
					<td class="text-center">
						{{ $m }}
					</td>
					<td class="text-center">
					<?php 
						$ismerchant = false;
						$mm = DB::table('merchant')->where('user_id',$token->user_id)->first();
						$ss = null;
						if(!is_null($mm)){
							$ismerchant = true;
						} else {
							$ss = DB::table('station')->where('user_id',$token->user_id)->first();
						}
					?>
					@if($ismerchant)
						<a href="javascript:void(0)" class="view-merchant-modal" data-id="{{$mm->id }}"> 
							{{IdController::nSeller($token->user_id)}} </a> 
						</td>
					@else
						<a href="javascript:void(0)" class="view-station-modal" data-id="{{$ss->id }}"> 
							{{IdController::nSeller($token->user_id)}} </a> 
						</td>
					@endif
					<td class="text-right">
						{{$token->qty}}
					</td>
					<td class="text-center">
						<a class="facilities_details" rel="{{ $token->user_id }}"  href="javascript:void(0)">Facilities</a>
					</td>
					<td class="text-center">
						<a class="log_details" rel="{{ $token->user_id }}"  href="javascript:void(0)">Token Log</a>
					</td>
				</tr>
				@endforeach
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
					<div id="title_log_modal"></div>
					<div id="content_log_modal">
						<table id="log_info" class="table table-bordered"></table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				</form>

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
			var facilities_info;
			$(document).delegate( '.facilities_details', "click",function (event) {
            //$(".likes_infoa").click(function () {

                $('#title_facilities_modal').html("Facilities");

                if(facilities_info){
                    facilities_info.destroy();
                    $('#facilities_info').empty();
                }

                _this = $(this);

                var user_id= _this.attr('rel');

                var url = '/admin/token/facilities/'+user_id;

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: 'json',
                    success: function (data) {

						console.log(data);
                      //  $('#title_sinfo_modal').append("<h2> Product: "+data[0].name + "</h2>");
                        $('#facilities_info').append('<thead style="background-color: #FF4C4C; color: #fff;"><th>No</th><th>Facility</th><th>Since</th></thead>');
                        $('#facilities_info').append('<tbody>');
                        for (i=0; i < data.length; i++) {
                            var obj = data[i];
                            $('#facilities_info').append('<tr><td style="text-align: center;">' + (i+1).toString() +'</td><td style="text-align: center;">'+obj.description +'</a></td><td style="text-align: center;">' + obj.since + ' </td></tr>');
                        }
                        $('#facilities_info').append('</tbody>');

                        facilities_info = $('#facilities_info').DataTable({
                            'autoWidth':false,
                             "order": [],
                             "iDisplayLength": 10,
                             "columns": [
                                { "width": "20px", "orderable": false },
                                { "width": "85px" },
                                { "width": "40px" }
                              ]
                        });

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

                $('#title_log_modal').html("Token Log");

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
                      //  $('#title_sinfo_modal').append("<h2> Product: "+data[0].name + "</h2>");
                        $('#log_info').append('<thead style="background-color: #FF4C4C; color: #fff;"><th>No</th><th>Facility</th><th>Tokens</th><th>Since</th></thead>');
                        $('#log_info').append('<tbody>');
                        for (i=0; i < data.length; i++) {
                            var obj = data[i];
                            $('#log_info').append('<tr><td style="text-align: center;">' + (i+1).toString() +'</td><td style="text-align: center;">'+obj.description +'</a></td><td style="text-align: right;">' + obj.value + ' </td><td style="text-align: center;">' + obj.since + ' </td></tr>');
                        }
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

    $('#gridmerchant').DataTable({
        "order": [],
        "scrollX": false,
        "scrollY": false,
        "columnDefs": [
			{"targets": 'no-sort', "orderable": false, },
			{"targets": "medium", "width": "40px" },
			{"targets": "lmedium", "width": "80px" },
			{"targets": "large",  "width": "120px" },
			{"targets": "approv", "width": "180px"},
			{"targets": "blarge", "width": "200px"},
			{"targets": "bsmall",  "width": "20px"},
			{"targets": "clarge", "width": "250px"},
			{"targets": "xlarge", "width": "300px" }
		],
        "fixedColumns":  true
    });

    function removeMessage() {
        $('.removeable').fadeOut(7000);
//            $('.removeable').remove();
    }
    setTimeout(removeMessage, 2000);

	$(window).resize();
});

$('.view-merchant-modal').click(function(){

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
