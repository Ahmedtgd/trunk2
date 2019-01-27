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
                        <div >
							{{--
                            <div class="banner-area">
                                <img src="{{asset('images/img1.jpg')}}"
									alt="{{ asset('images/img1.jpg') }}">
                            </div>
							--}}
                            <div class="row payment-area">
                                <div class="col-md-12">
                                    @if(Session::has('error_msg'))
                                    <div class="alert alert-danger"></span><strong> {!! session('error_msg') !!}</strong></div><br>
                                    @elseif(Session::has('success_msg'))
                                    <div class="alert alert-success"></span><strong> {!! session('success_msg') !!}</strong></div><br>
                                    @endif
                                    {{-- Merchant View Table --}}
                                    <h2>Payment: Merchant / Station</h2>
                                    <br>
                                    {!! Form::open(array('url'=>'/paymerchant')) !!}
                                    <div class="tableData">
                                    <div class="table-responsive">
                                    <table class="table table-bordered" cellspacing="0" width="100%" id='merchantTable'>
                                        <thead>
                                            <tr class='paymentTable'>
                                                    <th colspan="2">Station ID:[{!! str_pad($station_id, 10, '0', STR_PAD_LEFT) !!}]</th>
                                                    <th colspan="2">Commission Receivable</th>
                                                    <th colspan="2">Payment Gateway</th>
                                                    <th>Logistics</th>
                                                    <th style="background-color: black;">Outstanding</th>
                                                </tr>
                                            <tr class='paymentTable'>
                                                {{-- <th class="nosort">No</th> --}}
                                                <th class="nosort">Order ID</th>
                                                <th class="nosort">Sales</th>
                                                <th class='text-left nosort'>%</th>
                                                <th class='text-left nosort'>{{$currentCurrency}}</th>
                                                <th class="text-left ">%</th>
                                                <th class="text-left ">{{$currentCurrency}}</th>
                                                <th class="text-left ">{{$currentCurrency}}</th>
                                                <th class="text-left " style="background-color: black;">{{$currentCurrency}}</th>
                                            </tr>
                                        </thead>
										 @if(!empty($stations))
											<tfoot>
												<tr>
													<th></th>
													<th><span class="pull-left">{{$currentCurrency}}</span><span class="pull-right sales_total"></span></th>
													<th></th>
													<th><span class="pull-left">{{$currentCurrency}}</span><span class="pull-right receivable_total"></span></th>
													<th></th>
													<th><span class="pull-left">{{$currentCurrency}}</span><span class="pull-right gateway_total"></span></th>
													<th><span class="pull-left">{{$currentCurrency}}</span><span class="pull-right logistics_total"></span></th>
													<th><span class="pull-left">{{$currentCurrency}}</span><span class="pull-right outstanding_total"></span></th>
												</tr>
											</tfoot>	
                                        <tbody>
											@def $sales_total = 0;
											@def $receivable_total = 0;
											@def $gateway_total = 0;
											@def $logistics_total = 0;
											@def $outstanding_total = 0;
                                                @foreach($stations as $merchant)
                                                    <tr>
                                                        <td class="text-center"><a href="javascript:void(0)" class="view-orderid-modal" data-id="{{$merchant->poid }}">[{!! str_pad($merchant->poid, 10, '0', STR_PAD_LEFT) !!}]</a></td>
														<?php 
														/*	$mc_pay = 0;
															if($merchant->mc_id > 0){
																if($merchant->mc_commission > 0){
																	$mc_pay = $merchant->mc_commission;
																} else {
																	$mc_pay = $globals->mc_sales_staff_commission;
																}
															}
															$referral_pay = 0;
															if($merchant->referral_id > 0){
																if($merchant->referral_commission > 0){
																	$referral_pay = $merchant->referral_commission;
																} else {
																	$referral_pay = $globals->referral_sales_staff_commission;
																}
															}
															$mcp1_pay = 0;
															if($merchant->mcp1_id > 0){
																if($merchant->mcp1_commission > 0){
																	$mcp1_pay = $merchant->mcp1_commission;
																} else {
																	$mcp1_pay = $globals->mcp1_sales_staff_commission;
																}
															}															
															$mcp2_pay = 0;
															if($merchant->mcp2_id > 0){
																if($merchant->mcp2_commission > 0){
																	$mcp2_pay = $merchant->mcp2_commission;
																} else {
																	$mcp2_pay = $globals->mcp2_sales_staff_commission;
																}
															}															
															$gateway_pay = $globals->payment_gateway_commission;
															$logistic_pay = $globals->logistic_commission;
															$payable = $merchant->payable -
																((($mc_pay/100)*$merchant->net_payable) +
																(($mcp1_pay/100)*$merchant->net_payable) +
																(($referral_pay/100)*$merchant->net_payable) +
																(($mcp2_pay/100)*$merchant->net_payable) +
																(($gateway_pay/100)*$merchant->net_payable));
															$sales_total += $merchant->net_payable;*/
															$gateway_pay = $globals->payment_gateway_commission;
															$logistic_pay = $globals->logistic_commission;
															$sales_total += $merchant->net_payable;															
														?>												
														<td class="text-right">
															<span class="pull-left">{{$currentCurrency}}</span>
															{{number_format($merchant->net_payable/100,2)}}</td>

                                                        <td class="text-right">
															@if($merchant->commission_sv == -1)
																VAR%
															@else
																{{$merchant->commission_sv}}%
															@endif
														</td>
                                                        <?php 
															$commission_amount=
																($merchant->net_payable - $merchant->mpayable); 
															$receivable_total += $commission_amount;
														?>
                                                        <td class="text-right">
															<span class="pull-left">{{$currentCurrency}}</span>
															{{number_format($commission_amount/100,2)}}</td>

                                                        <td class="text-right">{{$gateway_pay}}%</td>
                                                        <?php 
															$gateway_amount=(($gateway_pay/100)*$merchant->net_payable); 
															$gateway_total += $gateway_amount;
														?>														
                                                        <td class="text-right">
															<span class="pull-left">{{$currentCurrency}}</span>
															{{number_format((($gateway_pay/100) *
																$merchant->net_payable)/100,2)}}</td>
                                                       <?php 
															$logistics_amount =
																(($logistic_pay/100) * $merchant->net_payable); 
															$logistics_total += $logistics_amount;
														?>															
                                                        <td><span class="pull-left">{{$currentCurrency}}</span>
															<span class="pull-right">
															{{number_format((($logistic_pay/100) *
																$merchant->net_payable)/100,2)}}</span></td>
                                                       <?php 
															$outstanding_total += $merchant->payable;
														?>															
                                                        <td class="text-right">
															<span class="pull-left">{{$currentCurrency}}</span>
																{{number_format($merchant->payable/100,2)}}</td>
                                                    </tr>        
                                               @endforeach
                                            @else
                                                <p>Details not available</p>
                                            @endif
											<input type="hidden" value="{{number_format($sales_total/100,2)}}" id="sales_total" />
											<input type="hidden" value="{{number_format($receivable_total/100,2)}}" id="receivable_total" />
											<input type="hidden" value="{{number_format($gateway_total/100,2)}}" id="gateway_total" />
											<input type="hidden" value="{{number_format($logistics_total/100,2)}}" id="logistics_total" />
											<input type="hidden" value="{{number_format($outstanding_total/100,2)}}" id="outstanding_total" />
                                        </tbody>
                                    </table>
                                    </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
    </div>

    <!-- Order Modal -->
    <div class="modal fade myModal" id="orderModal" role="dialog">
        <div class="modal-dialog modal-fullscreen">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button id='orderClose' type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <h3>Order</h3>
                    </h4>
                </div>
                <div class='modal-body'>

                </div>
                <div class="modal-footer" style='border:none'>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Modal -->
    <div class="modal fade myModal" id="productModal" role="dialog">
        <div class="modal-dialog modal-fullscreen">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button id='productClose' type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <h3>Product/Voucher</h3>
                    </h4>
                </div>
                <div class='modal-body'>

                </div>
                <div class="modal-footer" style='border:none'>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function() {
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
			
			var sales_total = $("#sales_total").val();
			$(".sales_total").text(sales_total);
			var receivable_total = $("#receivable_total").val();
			$(".receivable_total").text(receivable_total);
			var gateway_total = $("#gateway_total").val();
			$(".gateway_total").text(gateway_total);
			var logistics_total = $("#logistics_total").val();
			$(".logistics_total").text(logistics_total);
			var outstanding_total = $("#outstanding_total").val();
			$(".outstanding_total").text(outstanding_total);
            var table = $('#merchantTable, #orderTable').DataTable({
                'aoColumnDefs': [ { "bSortable": false, "aTargets": [] } ],
                "initComplete": function (settings, json) {
                    this.api().columns('.sum').every(function () {
                        var column = this;
                        var sum = column
                           .data()
                           .reduce(function (a, b) {
                               return parseFloat(a) + parseFloat(b);
                           });

                        sum = parseFloat(sum).toFixed(2);
                        $(column.footer()).html("<span class='pull-right'>"+sum+"</span>");
                    });
                }
            });

            $('table th:first').removeClass('sorting_asc');

            var currency = $('.curr').val();

            $('.com, .pay').append("<span class='pull-left'>"+ currency +"</span>");

            $('.uid').on('change', function(){
                total = 0;
                $('.uid:checked').each(function(){
                    amount = parseFloat($(this).attr('data'));
                    total = total + parseFloat(amount);
                })

                if(total > 0){
                    $('.subtotal').removeClass('hidden');
                    $('.subtotal_amount').removeClass('hidden').text(currency + ' ' + total);
                }else{
                    $('.subtotal').addClass('hidden');
                    $('.subtotal_amount').addClass('hidden');
                }
            })

            $('.merchant_id').click(function(){
                $('body').css('padding','0px');
                var route = $(this).attr('data-val');
                $.ajax({
                    type : "GET",
                    url : route,
                    success : function(response){
                        $('#orderModal').find('.modal-body').html(response);
                        $('#orderModal').modal('show');
                    }
                })
            })
        });
    </script>

    @yield('left_sidebar_scripts')

@stop


