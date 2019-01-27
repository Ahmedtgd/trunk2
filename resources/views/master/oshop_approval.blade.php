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

	<div class='row'>
		<div class='col-xs-6'>
			<h2>O-Shops Masters: Status</h2>
			<h3>O-Shop status: {{ucfirst($oshop->status)}}</h3>
		</div>
		<div class='col-xs-6'>
			&nbsp;
		</div>	
	</div>	
	
	<span  id="merchant-error-messages">
    </span>
	<div class='col-xs-12'><h3>Merchant</h3></div>
	<div class="">
		<table class="table table-bordered" cellspacing="0" width="100%" id="gridmerchant">
			<thead style="background-color: #FF4C4C; color: white;">
				<tr>
					<th class="no-sort text-center bsmall">No</th>
					<th class="text-center medium">Merchant&nbsp;ID</th>
					<th class="text-center blarge">Company&nbsp;Name</th>
					<th class="text-center no-sort approv"
						style="background-color:#008000;color:#fff">Status</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="text-center">
						1
					</td>
					<td class="text-center">
						<a href="{{URL::to('/')}}/admin/popup/merchant/{{$merchant->id}}" target="_blank" data-id="{{$merchant->id }}"> 
						{{IdController::nSeller($merchant->user_id)}} </a>
					</td>
					<td class="text-center">
						{{$merchant->company_name}}
					</td>
					<td class="text-center">
						{{ucfirst($merchant->status)}}
					</td>					
				</tr>
			</tbody>
		</table>
	</div>	
	<div class='col-xs-12'><h3>Products</h3></div>
	<div class="">
		<table class="table table-bordered" cellspacing="0" width="100%" id="gridproducts">
			<thead style="background-color: #444; color: white;">
				<tr>
					<th class="no-sort text-center bsmall">No</th>
					<th class="text-center medium">Product&nbsp;ID</th>
					<th class="text-center blarge">Product&nbsp;Name</th>
					@if($oshop->single == 0)
						<th class="text-center medium">Transfer</th>
					@endif					
					<th class="text-center no-sort approv" style="background-color:#008000;color:#fff">Status</th>
					@if($oshop->single == 0)
						<th class="text-center medium" style="background-color:#008000;color:#fff">History</th>
					@endif
				</tr>
			</thead>
			<tbody>
				<?php $m = 0; ?>
				
				@foreach($products as $product)
					@if($product->status != 'deleted')
						<?php $m++; ?>
						<?php 
							$style = "";
							if($product->status == 'transferred'){
								$style = "background-color: #FCA8FF";
							}
						?>
						<tr style="{{$style}}">
							
							<td class="text-center">
								{{ $m }}
							</td>
							<td class="text-center">
								<a href="{{URL::to('/')}}/productconsumer/{{$product->id}}" target="_blank" data-id="{{$product->id }}"> 
								{{IdController::nP($product->id)}} </a>
							</td>
							<td class="text-center">
								{{$product->name}}
							</td>
							@if($oshop->single == 0)
								<td class="text-center">
									@if($product->status != 'transferred')
									<a href="{{URL::to('/')}}/admin/master/oshop/product/transfer/{{$product->id}}" target="_blank" data-id="{{$product->id }}"> 
									Transfer </a>
									@endif
								</td>
							@endif							
							<td class="text-center">
								{{ucfirst($product->status)}}
							</td>		
							@if($oshop->single == 0)
								<td class="text-center">
									<a href="{{URL::to('/')}}/admin/master/oshop/product/transfer_history/{{$product->id}}" target="_blank" data-id="{{$product->id }}"> History </a>
								</td>
							@endif							
						</tr>
					@endif
				@endforeach
			</tbody>
		</table>
	</div>
	<br>
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

    $('#gridproducts').DataTable({
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

    // $(".mcrid").click(function () {
    $(document).delegate( '.mcrid', "click",function (event) {
		_this = $(this);
		var id_oshop= _this.attr('rel');

		$('#modal-Tittle2').html("Remarks");

		var url = '/admin/master/oshop_remarks/'+ id_oshop;
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
					html += "<td class='text-center'><a href='"+JS_BASE_URL+"/oshop/"+obj.url+"' class='update' data-id='"+id_oshop+"'>["+pad(id_oshop.toString(),10)+"]</a></td>";
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
