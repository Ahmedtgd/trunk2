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
                        <tr class="bg-beige">
                            <th class="text-center">No.</th>
                            <th class="text-center">Order&nbsp;ID</th>
                            <th class="text-center">
								&nbsp;Received&nbsp;&nbsp;</th>
                            <th class="text-center">Completed</th>
                            <th class="text-center class="text-center" style="display: none;">DTotal</th>
                            <th class="text-center class="text-center">Total</th>
<!--                             <th>Product ID</th>
                            <th>Description</th> -->
                            <th class="text-center">Buyer&nbsp;ID</th>
                            <th class="text-center">Segment</th>
                            <th class="text-center" style="background-color:#008000;color:#fff">Status</th>
                        </tr>
                        </thead>
                        <tbody>
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
	<input type="hidden" value="{{$globals->merchant_process_salesorder_window}}" id="dateglobal" />
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
 
		var page=$('#order_details_table_page').val();
		var product_dtable=$('#order_details_table').DataTable({
			"serverSide":false,
			"processing":true,
			"paging":true,
			"aoColumnDefs": [
			  { "iDataSort": 4, "aTargets": [ 5 ] }
			],
			"columnDefs": [
				{
					"targets": [ 5 ],
					"visible": false
				}
			],
			"searching":{"regex":true},
			"ajax":{
				type:"GET",
				pages:5,
				url:JS_BASE_URL+"/paginate/order",
				dataSrc:function(json){
				
					var return_data=new Array();
					subcat_pids=[];
					var dateglobal = $("#dateglobal").val();
					for (var i=0;i <json.data.length;i++) {
						var d=json.data[i];
						subcat_pids.push(d.pid);
						var completed = "--";
						var source = d.source;
						if(source == ""){
							source = "b2c";
						}
						var date1 = new Date(d.created_at);
						var date2 = new Date(dateglobal);
						var timeDiff = date2.getTime() - date1.getTime();
						var color="black";
						if(timeDiff < 0 && d.status == 'pending'){
							color="red";
						}
						if(d.status == 'complained'){
							color="white";
						}
						if(d.status == "completed" || d.status == "reviewed" || d.status == "commented" ){
							var completed = d.completed;
						}
						
						return_data.push({
							'id': i+1,
							'order_id':'<a href="javascript:void(0)" class="view-orderid-modal" data-id="'+d.id+'">'+d.order_id+'</a>',
							'received':d.received,
							'completed': completed,
							'dtotal':'<span class="hprice">' + parseInt(d.total) + '</span>',
							'total':"MYR "+js_number_format(parseInt(d.total)/100,2,".",""),
							'buyer_id':'<a href="javascript:void(0)" class="view-buyer-modal" data-id="'+d.user_id+'">'+d.buyer_id+'</a>',
							'segment':source.toUpperCase(),
							'status':'<a href="javascript:void(0)" role_id="'+d.id+'" class="preventDefault approval" style="color:'+color+';">'+ucfirst(d.status)+'</a>'

						});


					}
					return return_data;
				}

			},
			"columns":[
				{data:'id',name:'created_at',className:'text-center no-sort'},
				{data:"order_id",name:'order_id',className:'text-center'},
				{data:"received",name:'received',className:'text-center'},
				{data:"completed",name:'completed',className:'text-center no-sort'},
				{data:"dtotal",name:'total',className:'text-center'},
				{data:"total",name:'total',className:'text-center'},
				{data:"buyer_id",name:'buyer_id',className:'text-center'},
				{data:"segment",name:'segment',className:'text-center'},
				{data:"status",name:'status',className:'text-center'}

			]
		});
		
		$('#order_details_table').on('draw.dt', function () {
				console.log("Color");
					$(".hprice").each(function() {
							$(this).closest('td').css("display","none");
					});
		} );
		
		$(document).delegate( '.view-orderid-modal', "click",function (event) {
		//$('.view-orderid-modal').click(function(){

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
		$(document).delegate( '.view-buyer-modal', "click",function (event) {
		//$('.view-buyer-modal').click(function(){

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
				var check_url=JS_BASE_URL+"/admin/popup/lx/check/merchantu/"+user_id;
				$.ajax({
					url:check_url,
					type:'GET',
					success:function (r) {
					console.log(r);
					
					if (r.status=="success") {
					var url=JS_BASE_URL+"/admin/popup/merchant/"+r.id;
						var w=window.open(url,"_blank");
						w.focus();
					}
					if (r.status=="failure") {
					var check_url=JS_BASE_URL+"/admin/popup/lx/check/station/"+user_id;
					$.ajax({
						url:check_url,
						type:'GET',
						success:function (r) {
							if (r.status=="success") {
							var url=JS_BASE_URL+"/admin/popup/station/"+r.id;
							var w=window.open(url,"_blank");
							w.focus();
							}
							if (r.status=="failure") {
								var msg="<div class='alert alert-danger'>"+r.long_message+"</div>";
								$('#buyer-error-messages').html(msg);
							}
						}
					});
					}
					}
				});
			}
			}
			});
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

window.setInterval(function(){
              $('#orderid-error-messages').empty();
            }, 10000);

window.setInterval(function(){
              $('#buyer-error-messages').empty();
            }, 10000);


    </script>
@stop
