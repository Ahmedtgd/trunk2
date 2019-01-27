<?php
use App\Http\Controllers\UtilityController;
use App\Classes;
use App\Http\Controllers\IdController;
define('MAX_COLUMN_TEXTvw', 20);
?>
@extends("common.default")

@section('css')
    .paymentTable{ background : #30849B; color : #fff; }
    table.dataTable tfoot th, table.dataTable tfoot td {
        padding: 10px 8px 6px 9px !important;
        border:none;
    }

    .paymentTable th { text-align : center !important }

    .modal-fullscreen{
      margin: 0;
      margin-right: auto;
      margin-left: auto;
      width: 95% !important;
    }


    @media (min-width: 768px) {
      .modal-fullscreen{
        width: 750px;
      }
    }
    @media (min-width: 992px) {
      .modal-fullscreen{
        width: 970px;
      }
    }
    @media (min-width: 1200px) {
      .modal-fullscreen{
         width: 1170px;
    }

    .com, .pay, .ocom, .opay, .osales {
        width: 170px ;
    }

    table#merchantTable
    {
        table-layout: fixed;
        max-width: none;
        width: auto;
        min-width: 100%;
    }

@stop

@section("content")
    <div class="container" style="margin-top:30px;">
        <div class="row">
            <div class="col-sm-12">
                @include('admin/panelHeading')
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div id="main">
                    <div class="">
                        <div>
                            <div class="row payment-area">
                                <div class="col-md-12">
								@def $total_amount = 0
                                    @if(Session::has('error_msg'))
                                    <div class="alert alert-danger"></span><strong> {!! session('error_msg') !!}</strong></div><br>
                                    @elseif(Session::has('success_msg'))
                                    <div class="alert alert-success"></span><strong> {!! session('success_msg') !!}</strong></div><br>
                                    @endif
                                    {{-- Merchant View Table --}}
                                    <h2>Payment: Consolidator</h2>
									<span  id="merchant-error-messages"></span>
                                    <br>
									@def $total_payment = 0
                                    <div class="tableData">
                                    <div class="table-responsive">
                                    <table class="table table-bordered" cellspacing="0" width="1200px" id='consolidationTable'>
                                        <thead>
                                            <tr class='paymentTable' style="background-color: #555!important">
                                                <th class="nosort bsmall">No</th>
												<th class="text-center bmedium">Date</th>
                                                <th class="nosort bmedium">ID</th>
                                                <th class="text-center blarge">Name</th>
                                                <th class="text-center blarge">Period</th>
                                                <th class='sum nosort bsmall'>DO</th>
                                                <th class="text-center clarge">Amount</th>
                                                <th class="bmedium"></th>
                                                
                                                
                                            </tr>
                                        </thead>
                                        @if(isset($consolidators) and !is_null($consolidators))
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th></th>
												
                                                <th></th>
                                                
												<th ><button class='btn btn-block btn-danger btn-sm btn-file'>Generate File</button></th>
												<th><span class="file_link"></span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="file_giro"></span></th>
												<th></th>
												<th><span class="pull-left">{{$currentCurrency}}</span><span class="pull-right total_amount"></span></th>
                                                <th></th>
												
                                                
                                                
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @def $i = 1
                                            
											
                                            @if(!empty($consolidators))
                                             @foreach($consolidators as $consolodation)
                                                <tr>
                                                    <td class='text-center'>{!! $i++ !!}</td>
                                                    
                                                    <td class='text-center'>
														<?php $date = UtilityController::s_date($consolodation->created);
															$datearr=explode(" ", $date);
														?>
														{{ $datearr[0] }}
                                                    </td>
                                                    <td class='text-center'><span class=''>
															@if($consolodation->role_id == 3)
																{{IdController::nM($consolodation->id)}}
															@elseif($consolodation->role_id == 11)
																{{IdController::nS($consolodation->id)}}
															@elseif($consolodation->role_id == 13)
																{{IdController::nS($consolodation->id)}}
															@endif
													</span></td>
													<td class='text-center'>{{$consolodation->name}}</td>
                                                    
                                                    <td class='pay text-center'>
														<?php $period_start = UtilityController::s_date($consolodation->period_start);
															$period_startarr=explode(" ", $period_start);
															$period_end = UtilityController::s_date($consolodation->period_end);
															$period_endarr=explode(" ", $period_end);
														?>													
                                                        {{ $period_startarr[0] }} - {{ $period_endarr[0] }}
                                                    </td>
													<?php
														$orders_count = DB::table('cs_payment_detail')->join('cs_payment','cs_payment_detail.cs_payment_id','=','cs_payment.id')->where('cs_payment.user_id',$consolodation->user_id)->where('cs_payment.status','pending')->where('cs_payment.role_id',$consolodation->role_id)->count();
													?>
                                                    <td class='text-center'><a href="javascript:void(0)" class="orders" rel="{{$consolodation->user_id}}_{{$consolodation->role_id}}">{{$orders_count}}</a></td>
                                                    <td class='text-center'>
														<span class="pull-left">{{$currentCurrency}}</span> <span class="pull-right">{!! number_format($consolodation->pending_amount/100,2) !!}</span>
														<?php $total_amount += $consolodation->pending_amount; ?>	
														<input type="hidden" name="user_checked" class="user_checked" value="{{$consolodation->user_id}}_{{number_format($consolodation->pending_amount,0,'.','')}}_{{$consolodation->role_id}}" />														
													</td>
													
                                                    <td class='text-center'>
														<button class='btn btn-block btn-danger btn-sm btn-delete' id="btn-delete-{{$consolodation->user_id}}" rel="{{$consolodation->user_id}}" rel-role="{{$consolodation->role_id}}" rel-amount="{{number_format($consolodation->pending_amount/100,2)}}">Reverse</button>
													</td>
                                                </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                        @endif
                                    </table>
									<input type="hidden" id="total_amount" value="{{number_format($total_amount/100,2)}}" />
									<input type="hidden" id="mc_sales_staff_commission" value="{{number_format($global->mc_sales_staff_commission/100,2)}}" />
									<input type="hidden" id="referral_sales_staff_commission" value="{{number_format($global->referral_sales_staff_commission/100,2)}}" />
									<input type="hidden" id="mcp1_sales_staff_commission" value="{{number_format($global->mcp1_sales_staff_commission/100,2)}}" />
									<input type="hidden" id="mcp2_sales_staff_commission" value="{{number_format($global->mcp2_sales_staff_commission/100,2)}}" />
									<input type="hidden" id="payment_gateway_commission" value="{{number_format($global->payment_gateway_commission,2)}}" />
									<input type="hidden" id="logistic_commission" value="{{number_format($global->logistic_commission,2)}}" />
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
    </div>
	
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 40%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Payment orders</h4>
            </div>
            <div class="modal-body">
				<h3 id="modal-Tittle1"></h3>
                <h3 id="modal-Tittle"></h3>
                <div class="table-responsive">
                    <table id="myTable" class="table table-bordered myTable" width="100%" >
						<thead style="background-color: #555!important; color: #fff;">
							<th class="no-sort bsmall">No</th>
							<th class="xlarge">Order&nbsp;ID</th>
						</thead>
						<tbody>
						</tbody>
					</table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>	

<script type="text/javascript">
	$(document).ready(function() {
		function number_format(number, decimals, dec_point, thousands_sep) {
		number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
		var n = !isFinite(+number) ? 0 : +number,
		prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
		sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
		dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
		s = '',
		toFixedFix = function(n, prec) {
			var k = Math.pow(10, prec);
			return '' + (Math.round(n * k) / k).toFixed(prec);
			};
			// Fix for IE parseFloat(0.55).toFixed(0) = 0;
			s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
			if (s[0].length > 3) {
			s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
			}
			if ((s[1] || '')
			.length < prec) {
			s[1] = s[1] || '';
			s[1] += new Array(prec - s[1].length + 1).join('0');
		}
		return s.join(dec);
	}
		
	function pad(str, max) {
		str = str.toString();
		return str.length < max ? pad("0" + str, max) : str;
	}			

		var table = $('#consolidationTable').DataTable({
			"order": [],
			"scrollX": true,
			"scrollY": false,
			"columnDefs": [
				{"targets": 'no-sort', "orderable": false, },
				{"targets": "medium", "width": "80px" },
				{"targets": "bmedium", "width": "100px" },
				{"targets": "large",  "width": "120px" },
				{"targets": "clarge",  "width": "150px" },
				{"targets": "approv", "width": "180px"},
				{"targets": "blarge", "width": "200px"},
				{"targets": "bsmall",  "width": "20px"},
				{"targets": "clarge", "width": "250px"},
				{"targets": "xlarge", "width": "300px" }
			],
			"fixedColumns":  true
		});		
		
		$(".total_amount").text($("#total_amount").val());
		
		var order_table = $('#myTable').DataTable({
			"order": [],
			"columnDefs": [
				{"targets": 'no-sort', "orderable": false, },
				{"targets": "medium", "width": "80px" },
				{"targets": "bmedium", "width": "100px" },
				{"targets": "large",  "width": "120px" },
				{"targets": "clarge",  "width": "150px" },
				{"targets": "approv", "width": "180px"},
				{"targets": "blarge", "width": "200px"},
				{"targets": "bsmall",  "width": "20px"},
				{"targets": "clarge", "width": "250px"},
				{"targets": "xlarge", "width": "300px" }
			],
			"fixedColumns":  true
		});
		
		$(document).delegate( '.orders', "click",function (event) {
			order_table.clear().draw();
			var user_id = $(this).attr("rel");
			$.ajax({
			  url: JS_BASE_URL + '/paymentorders/' + user_id,
			  dataType:'json',
			  async:false,
			  type:'get',
			  processData: false,
			  contentType: false,
			  success:function(response){
				 for(var tt = 0; tt < response.length; tt++){
					var mc_pay = 0;
					if(response[tt].mc_id > 0){
						if(response[tt].mc_commission > 0){
							mc_pay = response[tt].mc_commission;
						} else {
							$mc_pay = $("#mc_sales_staff_commission").val();
						}
					}
					var referral_pay = 0;
					if(response[tt].referral_id > 0){
					if(response[tt].referral_commission > 0){
							referral_pay = response[tt].referral_commission;
						} else {
							$referral_pay = $("#referral_sales_staff_commission").val();
						}
					}
					var mcp1_pay = 0;
					if(response[tt].mcp1_id > 0){
						if(response[tt].mcp1_commission > 0){
							mcp1_pay = response[tt].mcp1_commission;
						} else {
							$mcp1_pay = $("#mcp1_sales_staff_commission").val();
						}
					}															
					var mcp2_pay = 0;
					if(response[tt].mcp2_id > 0){
						if(response[tt].mcp2_commission > 0){
							mcp2_pay = response[tt].mcp2_commission;
						} else {
							mcp2_pay = $("#mcp2_sales_staff_commission").val();
						}
					}	
					var gateway_pay = $("#payment_gateway_commission").val();
					var logistic_pay = $("#logistic_commission").val();
					console.log("mc_pay: " + mc_pay);
					console.log("mcp1_pay: " + mcp1_pay);
					console.log("referral_pay: " + referral_pay);
					console.log("mcp2_pay: " + mcp2_pay);
					console.log("gateway_pay: " + gateway_pay);
					console.log("logistic_pay: " + logistic_pay);
					console.log("net_payable: " + response[tt].net_payable);
					var peding_amount = parseFloat(response[tt].payable) -
						((parseFloat(gateway_pay)/100) * parseFloat(response[tt].net_payable));
					 order_table.row.add( [ "<center>" + (tt + 1) + "</center>", "<center><a href='" + JS_BASE_URL + "/deliveryorder/"+response[tt].poid+"' target='_blank'>" + response[tt].nporder_id + "</a></center>"] ).draw();
				 }	
				 $("#myModal").modal("show");
			  },
			  error:function(jqXHR, textStatus, errorThrown ){
				  console.log(jqXHR);
				  console.log(textStatus);
				  console.log(errorThrown);
				  toastr.error("An unexpected error ocurred, please, try again or contact OpenSupport");
			  }
			});								
		});			

		$(document).delegate( '.btn-delete', "click",function (event) {
			var user_id = $(this).attr("rel");
			var role_id = $(this).attr("rel-role");
			var role_amount = parseFloat($(this).attr("rel-amount").replace(',',''));
			var total_amount = parseFloat($("#total_amount").val().replace(',',''));
			var fdata = new FormData();
			fdata.append("user_id", user_id);
			fdata.append("role_id", role_id);
			$.ajax({
			  url: JS_BASE_URL + '/paymentdelete',
			  data:fdata,
			  dataType:'json',
			  async:false,
			  type:'post',
			  processData: false,
			  contentType: false,
			  success:function(response){
					toastr.info("Payment deleted!");	
					total_amount = total_amount - role_amount;
					$("#total_amount").val(total_amount);
					$(".total_amount").text(number_format($("#total_amount").val(),2,".",","));
					table.row($("#btn-delete-" + user_id).parents('tr')).remove().draw();			 
			  },
			  error:function(jqXHR, textStatus, errorThrown ){
				  $("#next_retail_spinner").hide();
				  toastr.error("An unexpected error ocurred, please, try again or contact OpenSupport");
			  }
			});								
		});
		
		$(document).delegate( '.btn-confirm', "click",function (event) {
			var user_id = $(this).attr("rel");
			var role_id = $(this).attr("rel-role");
			var fdata = new FormData();
			fdata.append("user_id", user_id);
			fdata.append("role_id", role_id);
			$.ajax({
			  url: JS_BASE_URL + '/paymentconfirm',
			  data:fdata,
			  dataType:'json',
			  async:false,
			  type:'post',
			  processData: false,
			  contentType: false,
			  success:function(response){
				 toastr.info("Payment confirmed!");	
				 $("#btn-confirm-" + user_id).hide();					 
				 $("#btn-delete-" + user_id).hide();					 
			  },
			  error:function(jqXHR, textStatus, errorThrown ){
				  $("#next_retail_spinner").hide();
				  toastr.error("An unexpected error ocurred, please, try again or contact OpenSupport");
			  }
			});								
		});
		
		$(document).delegate( '.file_link', "click",function (event) {
			$(this).html("");
			$('.btn-file').attr("disabled",false);
			$('.user_checked').attr("disabled",false);
			var users = new Array();
			var counter = 0;
			$("input:hidden[name=user_checked]").each(function(){
				users.push($(this).val());
				counter++;
			});
			console.log(users);
			var fdata = new FormData();
			fdata.append("users", users);
			$.ajax({
			  url: JS_BASE_URL + '/paymentfiledownload',
			  data:fdata,
			  dataType:'json',
			  async:false,
			  type:'post',
			  processData: false,
			  contentType: false,
			  success:function(response){
				 location.reload();					
			  },
			  error:function(jqXHR, textStatus, errorThrown ){
				  $("#next_retail_spinner").hide();
				  toastr.error("An unexpected error ocurred, please, try again or contact OpenSupport");
			  }
			});			
		});
		
		$(document).delegate( '.btn-file', "click",function (event) {
			$(this).attr("disabled",true);
			$('.user_checked').attr("disabled",true);
			var users = new Array();
			var counter = 0;
			$("input:hidden[name=user_checked]").each(function(){
				users.push($(this).val());
				counter++;
			});
			if(counter == 0){
				toastr.warning("You need to select the users to generate file");
			} else {
				var fdata = new FormData();
				fdata.append("users", users);
				$.ajax({
				  url: JS_BASE_URL + '/paymentfile',
				  data:fdata,
				  dataType:'json',
				  async:false,
				  type:'post',
				  processData: false,
				  contentType: false,
				  success:function(response){
						console.log(response);
						$(".file_link").html(response);
						var splitarr = response.split("text/");
						var splitarr2 = splitarr[1].split(".");
						$(".file_giro").html("<a href='" + JS_BASE_URL + "/admin/general/giro-reader/" + splitarr2[0] + "' target='_blank'>View File</a>");
						var count=300;
						/*var counter=setInterval(function timer()
						{
						  count=count-1;
						  if (count <= 0)
						  {
							 clearInterval(counter);
							 $(".file_link").html("");
							 $(".file_timer").text("");
							 $('.btn-file').attr("disabled",false);
							 $('.user_checked').attr("disabled",false);
							 return;
						  }

						 $(".file_timer").text(count + " secs"); // watch for spelling
						}, 1000);*/ //1000 will  run it every 1 second					
				  },
				  error:function(jqXHR, textStatus, errorThrown ){
					  $('.btn-file').attr("disabled",false);
					  $("#next_retail_spinner").hide();
					  toastr.error("An unexpected error ocurred, please, try again or contact OpenSupport");
				  }
				});	
			}				
		});
	 });
</script>

    @yield('left_sidebar_scripts')

@stop


