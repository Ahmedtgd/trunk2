<?php 
set_time_limit(0) ;
//use App\Classes;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
$globals = DB::table('global')->first();
$cStatus=["completed","reviewed","commented"];
?>

@extends("common.default")

{{-- @section('breadcrumbs', Breadcrumbs::render('SalesStaff')) --}}

@section("content")
    <div class="container" style="margin-top:30px;">
        <div class="row">
            <div class="col-md-12">
                @include('admin/panelHeading')
                <h2>Order Master</h2>
		<span id ="orderid-error-messages"></span>
		<span id ="buyer-error-messages"></span>
                <p class="bg-success success-msg" style="display:none;padding: 15px;"></p>
                <!-- <button type="button" id="btn-add" class="btn btn-primary btn-lg">Add Product</button> -->
                <!-- <hr> -->
                <div class="table-wrapper">
                    <table class="table table-bordered" cellspacing="0" width="100%" id="order_details_table">
                        <thead>
                        <tr style="background-color:#000; color: #fff;">
                            <th class="text-center">No.</th>
                            <th class="text-center">Order&nbsp;ID</th>
                            <th class="text-center">
								&nbsp;Received&nbsp;&nbsp;</th>
                            <th class="text-center">Completed</th>
                            <th class="text-center class="text-center"">Total</th>
<!--                             <th>Product ID</th>
                            <th>Description</th> -->
                            <th class="text-center">Buyer&nbsp;ID</th>
                            <th class="text-center">Segment</th>
                            <th class="text-center" style="background-color:#008000;color:#fff">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($order) && !empty($order))
                            @foreach($order as $key => $orderList)
								
                                <tr>
                                    <td class="text-center">{{$key+1}}</td>
                                    <?php
                                    // $formatted_porder_id = str_pad($orderList->id, 10, '0', STR_PAD_LEFT);
                                    ?>
                                    <td rel="{{$orderList->id}}" class="delivery_info text-center">
									<a href="javascript:void(0)" class="view-orderid-modal" data-id="{{$orderList->id }}"> 
									{{-- [{{$formatted_porder_id}}] --}}
                                    {{IdController::nO($orderList->id)}}
									</a>
                                    </td>
                                    <td class="text-center">
                                    {{UtilityController::s_date($orderList->created_at)}}
                                    
                                    </td>
                                    <td class="text-center">
											{{-- {{ date('dMy h:m', strtotime($orderList->created_at)) }} --}}
                                            @if(in_array($orderList->status,$cStatus))
                                    {{UtilityController::s_date($orderList->updated_at)}}
                                    @else
                                        --
                                            {{-- {{ date('dMy h:m', strtotime($orderList->receipt_tstamp)) }} --}}
                                        {{--     {{UtilityController::s_date($orderList->receipt_tstamp)}} --}}
                                    @endif
									</td>
                                    <td style="text-align:right;">
											{{$currency or 'MYR'}}&nbsp;{{number_format($orderList->oprice/100,2)}} 
									</td>
                                    <td class="text-center">
                                        <?php
											// $formatted_user_id = str_pad($orderList->user_id, 10, '0', STR_PAD_LEFT);
										?>
										<a href="javascript:void(0)" class="view-buyer-modal" data-id="{{$orderList->user_id }}">
													{{IdController::nB($orderList->user_id)}}
										</a>
                                    </td>
                                    <td class="text-center">
										{{strtoupper($orderList->segment)}}
									</td>
                                    <?php $cE="nC";
                                    $cTest=UtilityController::cE($orderList->id);
                                    // dump($cTest);
                                    if ($cTest[0]==1) {
                                        $cE='cE';
                                    }
                                 ?>
                                    <td class="text-center {{$cE}}">
                                     
                                                <a href="javascript:void(0)" role_id="{{$orderList->id}}" class="preventDefault approval" <?php

                                        if ($cE=="cE") {
                                            $ceid=$cTest[1]->complaint_reason_id;
                                    
                                            // $ceid=1;
                                            $reason="#ComplaintID: ".$cTest[1]->id." ". DB::table('buyercomplaintreason')->where('id',$ceid)->first()->description ."";
                                            // dump($reason);
                                            echo "title='Complaint Filed' data-toggle='popover' data-placement='bottom' data-content='".$reason."'";
                                        }
                                        ?>
                                        >
									 <?php 
										$color="black";
										$date = $orderList->created_at;
										$date = strtotime($date);
										$date1 = new DateTime('now');
										$date2 = new DateTime(date('Y-m-d H:i:s', strtotime("+ $globals->merchant_process_salesorder_window hours", $date)));
										$dDiff = $date1->diff($date2);
										if ($dDiff->format("%r") == '-' && $orderList->status=='pending') {
											$color="red";
										}
										if($orderList->status=='complained'){
											$color="white";
										}


									 ?>
										<span style="color: {{$color}}">{{ucfirst($orderList->status)}}</span>
                                    </a>
									</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                {{--Model Form Start--}}
                        <!-- Button trigger modal -->

                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document" style="width: 80%">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Add Sales Staff</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" action="#" id="addSalesStaff">

                                    <div class="form-group">
                                        <label for="emp-user-id" class="col-sm-2 control-label">User Id</label>
                                        <div class="col-sm-4">
                                            <select class="bootstrap-select" id="staff-user-id">

                                            </select>
                                        </div>

                                        <label for="emp-position" class="col-sm-2 control-label">Type</label>
                                        <div class="col-sm-4">
                                            {{--<input type="text" class="form-control" id="staff-type"--}}
                                            {{--placeholder="Enter type">--}}

                                            <select class="bootstrap-select" id="staff-type">
                                                <option value="SMM">SMM</option>
                                                <option value="MCT">MCT</option>
                                                <option value="MCP">MCP</option>
                                                <option value="PSH">PSH</option>
                                                <option value="STR">STR</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="emp-visa-no" class="col-sm-2 control-label">Target Merchant</label>
                                        <div class="col-sm-4">
                                            <input type="number" class="form-control" id="staff-target-merchant"
                                            placeholder="Enter target merchant">
                                        </div>

                                        <label for="emp-socso-no" class="col-sm-2 control-label">Target Revenue</label>
                                        <div class="col-sm-4">
                                            <input type="number" min="0" class="form-control" id="staff-target-revenue"
                                                   placeholder="Enter target revenue">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="emp-epf-no" class="col-sm-2 control-label">Commission</label>
                                        <div class="col-sm-4">
                                            <input type="number" min="0" step="any" class="form-control" id="staff-commission"
                                                   placeholder="Enter commission">
                                        </div>

                                        <label for="emp-pcb" class="col-sm-2 control-label">Bonus</label>
                                        <div class="col-sm-4">
                                            <input type="number" min="0" step="any" class="form-control" id="staff-bonus"
                                                   placeholder="Enter bonus">
                                        </div>

                                    </div>

                                    {{--<button type="submit" class="btn btn-default">Save</button>--}}
                                    <input type="hidden" id="staff-staff-id" value="">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary btn-title">Save</button>
                            </div>
                            </form>

                        </div>
                    </div>
                </div>
            {{--Model Form End--}}
        </div>
    </div>
    </div>
    {{--</div>--}}
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <script type="text/javascript">
        $(document).ready(function(){
    $('.preventDefault').click(function(e){e.preventDefault();});
    $('[data-toggle="popover"]').popover();   
});
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            var formSubmitType = null;
			$(document).delegate( '.approval', "click",function (event) {
                //  Paul on 1st May 2017 at 11 55 pm
				//window.open(JS_BASE_URL + "/admin/master/orderapp/" + $(this).attr("role_id"), '_blank');
                window.open(JS_BASE_URL + "/orderapp/" + $(this).attr("role_id"), '_blank');
			});	
            //Function To handle add button action
            $("#btn-add").click(function () {
                formSubmitType = "add";
                $(".modal-title").text("Add Staff");
                $("#addSalesStaff").trigger("reset");
                $("#myModal").modal("show");

            });

			var table = $('#order_details_table').DataTable({
				"order": [],
				 "columns": [
					{ "width": "20px", "orderable": false },
                    { "width": "120px" },
					{ "width": "120px" },
					{ "width": "120px" },
					{ "width": "120px" },
					{ "width": "120px" },
					{ "width": "120px" },
					{ "width": "120px" }
				  ]
			});

            //Function To Handle Edit Button action
            $(".btn-edit").click(function () {
                $("#addSalesStaff").trigger("reset");
                $("#myModal").modal("hide");

                var val = $(this).attr('value');
                console.log(val);
                var url = "/admin/general/salesstaff/" + val + "/edit";
                formSubmitType = "edit";
                $(".modal-title").text("Edit Sale Staff");

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        $("#staff-user-id").val(data["user_id"]);
                        $("#staff-type").val(data["type"]);
                        $("#staff-bonus").val(data["bonus"]);
                        $("#staff-commission").val(data["commission"]);
                        $("#staff-target-merchant").val(data["target_merchant"]);
                        $("#staff-target-revenue").val(data["target_revenue"]);
                        $("#staff-staff-id").val(data["id"]);

                        $("#myModal").modal("show");
                    },
                    error: function (error) {
                        console.log(error);
                    }

                });

            })

            //Delete Recored
            $(".btn-delete").click(function () {
                if (confirm('Are you sure you want to remove Staff Record?')) {
                    var id = $(this).attr("value");
                    var my_url = '/admin/general/salesstaff/' + id;
                    var method = "DELETE";

                    $.ajax({
                        type: method,
                        url: my_url,
                        dataType: 'json',
                        success: function (data) {
                            $(".success-msg").fadeIn();
                            $(".success-msg").text("Sale Staff successfully removed.");
                            $(".success-msg").fadeOut(4000);
                        },
                        error: function (error) {
                            console.log(error);
                        }

                    });

                }


            })

            //Handle Form Submit For Bothh Add and Edit
            $("#addSalesStaff").on('submit', function (event) {

                var method = null;
                var my_url = null;
                var id = null;


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                })
                event.preventDefault();


                if (formSubmitType == null) {
                    return false;
                }

                if (formSubmitType == "edit") {
                    id = $("#staff-staff-id").val();
                    method = 'PUT';
                    my_url = '/admin/general/salesstaff/' + id;
                }

                if (formSubmitType == "add") {
                    method = 'POST';
                    my_url = '/admin/general/salesstaff';
                }

                var formData = {
                    user_id: $("#staff-user-id").val(),
                    type: $("#staff-type").val(),
                    commission: $("#staff-commission").val(),
                    bonus: $("#staff-bonus").val(),
                    target_merchant: $("#staff-target-merchant").val(),
                    target_revenue: $("#staff-target-revenue").val(),
                }
                console.log(formData);
                $.ajax({
                    type: method,
                    url: my_url,
                    data: formData,
                    dataType: 'json',
                    success: function (data) {
//                        console.log(data);

                        $('#myModal').modal('hide');
                        $(".success-msg").fadeIn();
                        if (formSubmitType == 'edit') {
                            $(".success-msg").text("Sales Staff successfully updated.");
                        } else {
                            $(".success-msg").text("Sales Staff successfully added.");
                        }
                        $(".success-msg").fadeOut(4000);
                        formSubmitType = null;
                    },
                    error: function (error) {
                        console.log( error);
                    }

                });

            });

            // var table_modal;

            // $(".delivery_info").click(function(){
            //     var _this = $(this);

            //     if(table_modal){
            //         table_modal.destroy();
            //         $('#myTable').empty();
            //     }

            //     var id = _this.attr('rel');
            //     var url = "admin/order/"+id;
            //     // $.ajax({
            //     //     type: "GET",
            //     //     url: url,
            //     //     dataType: 'json',
            //     //     success: function (data) {

            //     //         $("#myModal").modal("show");
            //     //     },
            //     //     error: function (error) {
            //     //         console.log(error);
            //     //     }
            //     // });
            //     $('#myTable').append('<thead style="background-color: #FF8B91; color: #fff;"><th>No</th><th>Product ID</th><th>Description</th><th>Qty</th><th>Unit Price</th><th>Amount</th><th>Remarks</th></thead>');
            //     // $('#myTable').append('<tbody>');
            //     // for (i=0; i < data[0].products.length; i++) {
            //     //     var obj = data[0].products[i];
            //     //     $('#myTable').append('<tr><td>'+obj.id+'</td><td>'+obj.osmall_commission+'%</td></tr>');
            //     // }
            //     // $('#myTable').append('</tbody>');

            //     table_modal = $('#myTable').DataTable({
            //         'autoWidth':false,
            //          "order": [],
            //          "iDisplayLength": 10,
            //          "columns": [
            //             { "width": "20px", "orderable": false },
            //             { "width": "85px" }
            //           ]
            //     });
            //     $("#myModalDelivery").modal("show");
            // });
        });
$('.view-orderid-modal').click(function(){

var porder_id=$(this).attr('data-id');
var check_url=JS_BASE_URL+"/admin/popup/lx/check/order/"+porder_id;
$.ajax({
	url:check_url,
	type:'GET',
	success:function (r) {
	console.log(r);
	
	if (r.status=="success") {
		var url=JS_BASE_URL+"/deliveryorder/"+porder_id;
		
		var w=window.open(url,"_blank");
		w.focus();
	}
	if (r.status=="failure") {
	var msg="<div class=' alert alert-danger'>"+r.long_message+"</div>";
	$('#orderid-error-messages').html(msg);
	}
	}
	});
});

$('.view-buyer-modal').click(function(){

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
	$('#buyer-error-messages').html(msg);
	}
	}
	});
});


window.setInterval(function(){
              $('#orderid-error-messages').empty();
            }, 10000);

window.setInterval(function(){
              $('#buyer-error-messages').empty();
            }, 10000);


    </script>
@stop
