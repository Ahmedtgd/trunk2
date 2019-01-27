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
<div class="modal fade" id="myModalNotes" role="dialog" aria-labelledby="myModalNotes">
	<div class="modal-dialog" role="notes" style="width: 50%">
		<div class="modal-content">
			<div class="row" style="padding: 15px;">
				<div class="col-md-12" style="">
					<form id="notes-form">
						<fieldset>
							<h2>Remarks</h2>
							<br>
							<textarea style="width:100%; height: 250px;" name="name" id="status_notes" class="text-area ui-widget-content ui-corner-all">
							</textarea>
							<br>
							<input type="button" id="save_notes" class="btn btn-primary" value="Save Notes">
							<input type="hidden" id="tproduct_id" value="0">
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

	<h2>Product Transfer History</h2>
	@if(!is_null($product))
		<h3>Product: {{$product->name}}</h3>
	@endif
	<span  id="merchant-error-messages">
    </span>
	<div class="table-responsive">
		<table class="table table-bordered" cellspacing="0" width="1500px" id="gridmerchant">
			<thead style="background-color: #948A54; color: white;">
				<tr>
					<th class="no-sort text-center bsmall">No</th>
					<th class="text-center medium">Product&nbsp;ID</th>
					<th class="text-center medium">O-Shop&nbsp;ID</th>
					<th class="text-center medium">O-Shop&nbsp;Name</th>
					<th class="text-center medium">Merchant&nbsp;ID</th>
					<th class="text-center medium">Merchant&nbsp;Name</th>
					<th class="text-center medium">Date/Time</th>
					<th class="text-center medium">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php $m = 0; ?>
				@foreach($fhistory as $f)
					<?php $m++; ?>
					<?php 
						$style = "";
						if($f['bold'] == 1){
							$style="font-weight:bold";
						}
					?>
					<tr style="{{$style}}">
						<td class="text-center">
							{{ $m }}
						</td>
						<td class="text-center">
							@if(!is_null($f['old_product']))
								<a href="{{route('productconsumer',['url'=>$f['old_product']->id])}}" target="_blank" data-id="{{$f['old_product']->id }}"> 
								{{IdController::nP($f['old_product']->id)}} </a> 
							@endif
						</td>
						<td class="text-center">
							@if(!is_null($f['old_oshop']))
								<a href="{{route('oshop.one',['url'=>$f['old_oshop']->url])}}" target="_blank" data-id="{{$f['old_oshop']->id }}"> 
								{{IdController::nOshop($f['old_oshop']->id)}} </a> 
							@endif
						</td>
						<td class="text-center">
							@if(!is_null($f['old_oshop']))
								{{$f['old_oshop']->oshop_name}}
							@endif
						</td>					
						<td class="text-center">
							@if(!is_null($f['old_merchant']))
								<a href="javascript:void(0)" class="view-merchant-modal" data-id="{{$f['old_merchant']->id}}"> 
								{{IdController::nSeller($f['old_merchant']->user_id)}} </a> 
							@endif
						</td>
						<td class="text-center">
							@if(!is_null($f['old_merchant']))
								{{$f['old_merchant']->company_name}}
							@endif
						</td>
						<td class="text-center">
							{{UtilityController::s_date($f['datetime'])}}
						</td>
						<td class="text-center">
							{{$f['action']}}
						</td>
					</tr>
				@endforeach
				@foreach($bhistory as $f)
					<?php $m++; ?>
					<?php 
						$style = "";
						if($f['bold'] == 1){
							$style="font-weight:bold";
						}
					?>
					<tr style="{{$style}}">
						<td class="text-center">
							{{ $m }}
						</td>
						<td class="text-center">
							@if(!is_null($f['old_product']))
								<a href="{{route('productconsumer',['url'=>$f['old_product']->id])}}" target="_blank" data-id="{{$f['old_product']->id }}"> 
								{{IdController::nP($f['old_product']->id)}} </a> 
							@endif
						</td>
						<td class="text-center">
							@if(!is_null($f['old_oshop']))
								<a href="{{route('oshop.one',['url'=>$f['old_oshop']->url])}}" target="_blank" data-id="{{$f['old_oshop']->id }}"> 
								{{IdController::nOshop($f['old_oshop']->id)}} </a> 
							@endif
						</td>
						<td class="text-center">
							@if(!is_null($f['old_oshop']))
								{{$f['old_oshop']->oshop_name}}
							@endif
						</td>					
						<td class="text-center">
							@if(!is_null($f['old_merchant']))
								<a href="javascript:void(0)" class="view-merchant-modal" data-id="{{$f['old_merchant']->id}}"> 
								{{IdController::nSeller($f['old_merchant']->user_id)}} </a> 
							@endif
						</td>
						<td class="text-center">
							@if(!is_null($f['old_merchant']))
								{{$f['old_merchant']->company_name}}
							@endif
						</td>
						<td class="text-center">
							{{UtilityController::s_date($f['datetime'])}}
						</td>
						<td class="text-center">
							{{$f['action']}}
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
<meta name="_token" content="{!! csrf_token() !!}"/>
<script type="text/javascript">
$(document).ready(function () {
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

			$(document).delegate( '.btn-transfer', "click",function (event) {
				$("#tproduct_id").val($(this).attr('rel'));
				$("#myModalNotes").modal('show');
			});
			$(document).delegate( '#save_notes', "click",function (event) {
				var oshop = "";
				$('#save_notes').attr('value', 'Saving...');
				$("input:checkbox[class=selectedoshop]:checked").each(function () {
					console.log($(this).val());
					oshop = $(this).val();
				});
				if(oshop == ""){
					toastr.warning("Please, select one O-Shop");
					$("#myModalNotes").modal('toggle');
				} else {
					var formData = {
						oshop_id: oshop,
						product_id: $("#tproduct_id").val(),
						notes: $("#status_notes").val()
					}
					$('.btn-transfer').attr('disabled',true);
					$.ajax({
						type: "POST",
						url: JS_BASE_URL + "/product/transfer",
						data: formData,
						success: function (data) {
							console.log(data);
							$("#myModalNotes").modal('toggle');
							$('#save_notes').attr('value', "Save Notes");
							toastr.info('Product Successfully Transferred');
						},
						error: function (error) {
							console.log(error);
							$('.btn-transfer').attr('disabled',false);
							$("#myModalNotes").modal('toggle');
							$('#save_notes').attr('value', "Save Notes");
							toastr.error('An Unexpected Error Occurred!');
						}

					});
				}
			});
			
			$(document).delegate( '.selectedoshop', "click",function (event) {
				$('.selectedoshop').prop('checked',false);
				$(this).prop('checked',true);
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

    $('#gridmerchant').DataTable({
        "order": [],
        "scrollX": true,
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
			{"targets": "xlarge", "width": "300px" },
			{"targets": "clarge", "width": "250px"}	
		],
        "fixedColumns":  true
    });

    function removeMessage() {
        $('.removeable').fadeOut(7000);
//            $('.removeable').remove();
    }
    setTimeout(removeMessage, 2000);

    // $(".mcrid").click(function () {
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

window.setInterval(function(){
              $('#merchant-error-messages').empty();
            }, 10000);


</script>
@yield("left_sidebar_scripts")
@stop
