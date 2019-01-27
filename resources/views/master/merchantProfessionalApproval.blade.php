<?php
use App\Classes;
define('MAX_COLUMN_TEXT', 95);
define('MAX_COLUMN_TEXT2', 20);
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
    table#grid4c
    {
        table-layout: fixed;
        max-width: none;
        width: auto;
        min-width: 100%;
    }
</style>
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
			<div class='col-xs-6'><h2>Merchant Professional Master</h2></div>
			<div class='col-xs-6'>
				@foreach($merchantsconsultant as $merchantc)
					<a class="btn btn-default role_status_button pull-right add_remark" role="sales_staff" do_status="add_remark" current_role_id="{{$merchantc->id}}" style="width: 110px !important;" href="javascript:void(0)"> Add Remark </a>
				@endforeach
			</div>	
		</div>
	<span  id="mpid-error-messages">
    </span>
<span  id="recruiter-error-messages">
    </span>

	<div class="table-responsive">
		<table class="table table-bordered" cellspacing="0" width="1160px" id="grid4c">
			<thead style="background-color: #604a7b; color: #fff;">
				<tr>
					<th class="text-center no-sort bsmall">No</th>
					<th class="text-center bmedium">MP&nbsp;ID</th>
					<th class="text-center blarge">Name</th>
					<!--<th class="text-center bmedium">Nationality</th>
					<th class="text-center bmedium">MC&nbsp;ID</th>
					<th class="text-center medium">Commission</th>-->
						<th class="text-center xlarge" style="background-color: #008000; color: #fff;">Remarks</th> 
					<th class="text-center medium" style="background-color: #008000; color: #fff;">Status</th>
						<th class="text-center approv" style="background-color: #008000; color: #fff;">Approval</th> 
				</tr>
			</thead>
			<tbody>
				@foreach($merchantsconsultant as $merchantc)
				<tr>
					<td class="text-center">
						{{$i++}}
					</td>

					<td class="text-center">
						<?php $formatted_merchantc_id = str_pad($merchantc->id, 10, '0', STR_PAD_LEFT); ?>
					 <!--<a target="_blank" href="{{route('userPopup', ['id' => $merchantc->user_id])}}">[{{$formatted_merchantc_id}}]</a>-->
				<a href="javascript:void(0)" class="view-mpid-modal" data-id="{{$merchantc->user_id }}"> 
						{{IdController::nB($merchantc->user_id)}}  </a> 

					</td>

					<td>
					<?php
                        /* Processed remark */
                        $pfullremark = null;
                        $premark = null;
						$elipsis = "...";
						$pfullremark = $merchantc->first_name . " " . $merchantc->last_name;
						$premark = substr($pfullremark,0, MAX_COLUMN_TEXT2);

						if (strlen($pfullremark) > MAX_COLUMN_TEXT2)
							$premark = $premark . $elipsis;
					?>								
								<span title='{{$pfullremark}}'>{{$premark}}</span>					
					</td>

				<!--	<td class="text-center">
						{{$merchantc->nationality}}
					</td>

					<td class="text-center">
						<?php $formatted_recruiter_id = str_pad($merchantc->recruiter_id, 10, '0', STR_PAD_LEFT); ?>
						 <!--<a target="_blank" href="{{route('userPopup', ['id' => $merchantc->recruiter_id])}}">[{{$formatted_recruiter_id}}]</a>
					<a href="javascript:void(0)" class="view-recruiter-modal" data-id="{{ $merchantc->recruiter_id }}">
						{{IdController::nB($merchantc->recruiter_id)}}  </a>
					</td>
					<td class="text-center">
						<a rel="{{ $merchantc->id }}"
						class="commission" href="javascript:void(0);">
						Details</a>
						<input id="id_{{ $merchantc->id }}" type="hidden" value="{{$i}}" />
						<input id="target_{{ $merchantc->id }}" type="hidden" value="{{$merchantc->target_merchant}}" />

						<?php
						$revenue = number_format(($merchantc->target_revenue/100),2);
            			?>
            			<input id="revenue_{{ $merchantc->id }}" type="hidden" value="{{$currency}}&nbsp;{{$revenue}}" />

						<input id="bonus_{{ $merchantc->id }}" type="hidden" value="{{$merchantc->bonus}}%" />						
					</td>-->

						<td id="remarks_column">
					<?php
						$remark = DB::table('remark')
						->select('remark')
						->join('sales_staffremark','sales_staffremark.remark_id','=','remark.id')
						->where('sales_staffremark.sales_staff_id',$merchantc->id)
						->orderBy('remark.created_at', 'desc')
						->first();

                        /* Processed remark */
                        $pfullremark = null;
                        $premark = null;

                        if ($remark) {
                            $elipsis = "...";
                            $pfullremark = $remark->remark;
                            $premark = substr($pfullremark,0, MAX_COLUMN_TEXT);

                            if (strlen($pfullremark) > MAX_COLUMN_TEXT)
                                $premark = $premark . $elipsis;
                        }
					?>
						<a href="javascript:void(0)" id="mcrid_{{$merchantc->id}}" class="mcrid" rel="{{$merchantc->id}}">
							<span title='{{$pfullremark}}'>{{$premark}}</span>
						</a>
					</td>

					<td id="status_column" class="text-center">
						<span id="status_column_text">
							<a class="approval_details" rel="{{ $merchantc->user_id }}" target="_blank"  href="{{route('merchantPApproval', ['id' => $merchantc->user_id])}}">{{ucfirst($merchantc->status)}}</a>
						</span>
					</td>

						<td class="text-center">
						<div class="action_buttons">
							<?php
							$approve = new Classes\Approval('sales_staff', $merchantc->id);
							if ($merchantc->status == 'active') {
								$approve->getSuspendButton();
							} else if ($merchantc->status == 'suspended' || $merchantc->status == 'rejected') {
								$approve->getReactivateButton();
							}
							echo $approve->view;
							?>
						</div>
					</td> 
				</tr>
				@endforeach
			</tbody>
		</table>
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

<!-- Modal -->
<div class="modal fade" id="modalcommission" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Commission Details</h4>
            </div>
            <div class="modal-body">
                <h3 id="modal-Tittle"></h3>
                <div id="myBody">
					<table id="myTableMPC" class="table table-bordered myTable"></table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>
<!--browser popup -->
<script language="javascript" type="text/javascript">
	<!--
	function popitup(url) {
		var win = window.open(url, '_blank');
		win.focus();
	}

	// -->
</script>



<meta name="_token" content="{!! csrf_token() !!}"/>

<script type="text/javascript">
$(document).ready(function () {

    function pad (str, max) {
        str = str.toString();
        return str.length < max ? pad("0" + str, max) : str;
    }

	$('#grid4c').DataTable({
		'scrollX':true,
		 'autoWidth':true,
		 "order": [],
		 "columnDefs": [
				{ "targets": "no-sort", "orderable": false },
				{"targets": "medium", "width": "80px"},
				{"targets": "bmedium", "width": "100px"},
				{"targets": "large",  "width": "120px"},
				{"targets": "bsmall",  "width": "20px"},
				{"targets": "approv", "width": "180px"}, //Approval buttons
				{"targets": "blarge", "width": "200px"}, // *Names
				{"targets": "clarge", "width": "250px"},
				{"targets": "xlarge", "width": "300px"}, //Remarks + Notes 
			]
	});

	$(".mc_edit").click(function(){
		_this = $(this);
		var mc_id= _this.attr('rel');
		$("#mc_p" + mc_id).hide();
		$("#mc_i" + mc_id).show();
	});

	$('.commission').click(function(){
		_this = $(this);
		var staff_id= _this.attr('rel');

		$('#modal-Tittle').html("Commission");
		$('#myTableMPC').empty();
		$('#myTableMPC').append("<thead style='background-color: #604a7b; color: #fff;'><th class='text-center'>No.&nbsp;</th><th class='text-center'>Target&nbsp;Merchant</th><th class='text-center'>Target&nbsp;Revenue</th><th class='text-center'>Commission&nbsp;%</th></thead>");
		var id = $('#id_'+staff_id).val();
		var target = $('#target_'+staff_id).val();
		var revenue = $('#revenue_'+staff_id).val();
		var bonus = $('#bonus_'+staff_id).val();
		$('#myTableMPC').append('<tbody><tr><td class="text-center">'+id+'</td><td class="text-center">'+target+'</td><td class="text-right">'+revenue+'</td><td class="text-center">'+bonus+'</td></tr></tbody>');

		$("#modalcommission").modal("show");

	});

	$('.mc_btnedit').click(function(){
		_this = $(this);
		var mc_id= _this.attr('rel');
		var commission = $('#mc_c' + mc_id).val();
		if($.isNumeric(commission)){
			var url = '/admin/commission/sales_staff/'+ mc_id;
			$.ajax({
			  url: url,
			  type: "post",
			  data: {'commission': commission},
			  success: function(data){
				location.reload();
			  }
			});
		} else {
			alert(commission + "Invalid Number!");
		}
	});

	// $(".mcrid").click(function () {
    $(document).delegate( '.mcrid', "click",function (event) {
		_this = $(this);
		var id_merchantc= _this.attr('rel');

		$('#modal-Tittle2').html("Remarks");

		var url = '/admin/master/sales_staff_remarks/'+ id_merchantc;
		$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			success: function (data) {
				console.log(data);
				var html = "<table class='table table-bordered' cellspacing='0' width='100%' ><tr style='background-color: #604a7b; color: white;'><th class='text-center'>No</th><th class='text-center'>MC&nbsp;ID</th><th class='text-center'>Status</th><th class='text-center'>Admin&nbsp;User&nbsp;ID</th><th class='text-center'>Remarks</th><th class='text-center'>DateTime</th></tr>";
				for (i=0; i < data.length; i++) {
					var obj = data[i];
					html += "<tr>";
					html += "<td class='text-center'>"+(i+1)+"</td>";
					html += "<td class='text-center'><a href='admin/popup/user/"+id_merchantc+"' class='update' data-id='"+id_merchantc+"'>["+pad(id_merchantc.toString(),10)+"]</a></td>";
					html += "<td class='text-center'>"+ucfirst(obj.status)+"</td>";
					html += "<td class='text-center'><a href='admin/popup/user/"+obj.user_id+"' class='update' data-id='"+obj.user_id+"'>["+pad(obj.user_id.toString(),10)+"]</td>";
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
});

$('.view-mpid-modal').click(function(){

var user_id=$(this).attr('data-id');
var check_url=JS_BASE_URL+"/admin/popup/lx/check/user/"+user_id;
$.ajax({
	url:check_url,
	type:'GET',
	success:function (r) {
	console.log(r);
	
	if (r.status=="success") {
	var url=JS_BASE_URL+"/admin/popup/user/"+user_id;
		var w=window.open(url,"_blank");
		w.focus();
	}
	if (r.status=="failure") {
	var msg="<div class=' alert alert-danger'>"+r.long_message+"</div>";
	$('#mpid-error-messages').html(msg);
	}
	}
	});
});

$('.view-recruiter-modal').click(function(){

            var recruiter_id=$(this).attr('data-id');
            <!--var check_url=JS_BASE_URL+"/admin/popup/lx/check/user/"+recruiter_id;-->
		 var check_url=JS_BASE_URL+"/admin/popup/lx/check/user/"+recruiter_id;
            $.ajax({
                url:check_url,
                type:'GET',
                success:function (r) {
		console.log(r);
		    
                    if (r.status=="success") {
                    var url=JS_BASE_URL+"/admin/popup/user/"+recruiter_id;
                        var w=window.open(url,"_blank");
		        w.focus();
                    }
                    if (r.status=="failure") {
                        var msg="<div class='alert alert-danger'>"+r.long_message+"</div>";
                        $('#recruiter-error-messages').html(msg);
                    }
                }
            });
});

window.setInterval(function(){
              $('#mpid-error-messages').empty();
            }, 10000);
window.setInterval(function(){
              $('#recruiter-error-messages').empty();
            }, 10000);


</script>
@yield("left_sidebar_scripts")
@stop
