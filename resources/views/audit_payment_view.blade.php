<?php
use App\Http\Controllers\UtilityController;
use App\Classes;
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
                        <div class="main-container">
                            <div class="row payment-area">
                                <div class="col-md-12">
								@def $total_amount = 0
                                    @if(Session::has('error_msg'))
                                    <div class="alert alert-danger"></span><strong> {!! session('error_msg') !!}</strong></div><br>
                                    @elseif(Session::has('success_msg'))
                                    <div class="alert alert-success"></span><strong> {!! session('success_msg') !!}</strong></div><br>
                                    @endif
                                    {{-- Merchant View Table --}}
                                    <h2>Audit: Payment Consolidator</h2>
									<span  id="merchant-error-messages"></span>
                                    <br>
									@def $total_payment = 0
                                    <div class="tableData">
                                    <div class="table-responsive">
                                    <table class="table table-bordered" cellspacing="0" width="1400px" id='auditpaymentTable'>
                                        <thead>
                                            <tr class='paymentTable' style="background-color: #555!important">
                                                <th class="nosort bsmall">No</th>
												<th class="text-center bmedium">Date</th>
                                                <th class="nosort bmedium">ID</th>
                                                <th class="text-center blarge">Name</th>
                                                <th class="text-center bmedium">Role</th>
                                                <th class="text-center blarge">Period</th>
                                                <th class='sum nosort bsmall'>DO</th>
                                                <th class='sum nosort bmedium'>Status</th>
                                                <th class="text-center clarge">Amount</th>                                             
                                            </tr>
                                        </thead>
                                        @if(isset($audits) and !is_null($audits))
                                        <tbody>
                                            @def $i = 1
                                            @if(!empty($audits))
                                             @foreach($audits as $audit)
                                                <tr>
                                                    <td class='text-center'>{!! $i++ !!}</td>
                                                    
                                                    <td class='text-center'>
														<?php $date = UtilityController::s_date($audit->created_at);
															$datearr=explode(" ", $date);
														?>
														{{ $datearr[0] }}
                                                    </td>
                                                    <td class='text-center'><span class=''>
															[{!! str_pad($audit->user_id, 10, '0', STR_PAD_LEFT) !!}]
													</span></td>
													<?php 
														$name = null;
														if($audit->role_id == 3){
															$name = DB::table('merchant')->where('user_id',$audit->user_id)->first()->company_name;
														} 
														if($audit->role_id == 11){
															$name = DB::table('station')->where('user_id',$audit->user_id)->first()->company_name;
														}
													?>
													<td class='text-center'>{{$name}}</td>
                                                     <td class='text-center'>
														@if($audit->role_id == 3)
															Merchant
														@endif
														@if($audit->role_id == 11)
															Station
														@endif													
													 </td>
                                                    <td class='pay text-center'>
														<?php $period_start = UtilityController::s_date($audit->period_start);
															$period_startarr=explode(" ", $period_start);
															$period_end = UtilityController::s_date($audit->period_end);
															$period_endarr=explode(" ", $period_end);
														?>													
                                                        {{ $period_startarr[0] }} - {{ $period_endarr[0] }}
                                                    </td>
													@if($audit->status == 'executed')
														<?php
															$orders_count = DB::table('audit_cs_payment_detail')->join('audit_cs_payment','audit_cs_payment_detail.cs_payment_id','=','audit_cs_payment.cs_id')->where('audit_cs_payment.user_id',$audit->user_id)->where('audit_cs_payment.role_id',$audit->role_id)->where('audit_cs_payment.id',$audit->id)->count();
														?>
														<td class='text-center'><a href="javascript:void(0)" class="orders" rel="{{$audit->user_id}}_{{$audit->role_id}}">{{$orders_count}}</a></td>
													@else
														<td class='text-center'></td>
													@endif
													 <td class='text-center'>
														{{$audit->status}}											
													</td>
													<td class='text-center'>
														<span class="pull-left">{{$currentCurrency}}</span> <span class="pull-right">{!! number_format($audit->amount/100,2) !!}</span>													
													</td>
													
                                                </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                        @endif
                                    </table>
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
							<th class="xlarge">Amount</th>
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
		
		function pad (str, max) {
			str = str.toString();
			return str.length < max ? pad("0" + str, max) : str;
		}			
		var table = $('#auditpaymentTable').DataTable({
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
			  url: JS_BASE_URL + '/paymentordersaudit/' + user_id,
			  dataType:'json',
			  async:false,
			  type:'get',
			  processData: false,
			  contentType: false,
			  success:function(response){
				 for(var tt = 0; tt < response.length; tt++){
					 order_table.row.add( [ "<center>" + (tt + 1) + "</center>", "<center><a href='" + JS_BASE_URL + "/deliveryorder/"+response[tt].order_id+"' target='_blank'>[" + pad(response[tt].order_id,10) + "]</a></center>", "<span class='pull-right'>{{$currentCurrency}}&nbsp;&nbsp;&nbsp;&nbsp;" + number_format(parseFloat(response[tt].pending_amount/100),2,".",",") +  "</span>" ] ).draw();
				 }	
				 $("#myModal").modal("show");
			  },
			  error:function(jqXHR, textStatus, errorThrown ){
				  toastr.error("An unexpected error ocurred, please, try again or contact OpenSupport");
			  }
			});								
		});		
	 });
</script>

    @yield('left_sidebar_scripts')

@stop


