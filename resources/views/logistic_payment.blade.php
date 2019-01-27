@extends("common.default")
<?php use App\Http\Controllers\IdController;?>
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
                                    @if(Session::has('error_msg'))
                                    <div class="alert alert-danger"></span><strong> {!! session('error_msg') !!}</strong></div><br>
                                    @elseif(Session::has('success_msg'))
                                    <div class="alert alert-success"></span><strong> {!! session('success_msg') !!}</strong></div><br>
                                    @endif
                                    {{-- Merchant View Table --}}
                                    <h2>Payment: Logistic</h2>
									<span  id="merchant-error-messages"></span>
                                    <br>
									@def $total_payment = 0
                                    {!! Form::open(array('url'=>'/paymerchant')) !!}
                                    <div class="tableData">
                                    <div class="table-responsive">
                                    <table class="table table-bordered" cellspacing="0" width="100%" id='merchantTable'>
                                        <thead>
                                            <tr class='paymentTable' style="background-color: black!important">
                                                <th class="nosort">No</th>
                                                <th class="nosort">Logistic&nbsp;ID</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Details</th>
                                                <th class='sum nosort'>Outstanding</th>
                                                <th>Due&nbsp;Date</th>
                                                <th class="nosort" bgcolor="red">Payment</th>
                                                <th>Date Paid</th>
                                            </tr>
											@if(isset($logistics) and !is_null($logistics))
                                            <tr class="border-less-tr">
                                                <th ></th>
                                                <th >Total</th>
                                                <th ></th>
                                                <th ></th>
                                                <th  class= 'nosort pay' id='pay'></th>
                                                <th >
                                                    <span class="pull-left hidden subtotal">Subtotal:</span>
                                                    <span class="pull-right hidden subtotal_amount"></span>
                                                </th>
                                                <th ></th>
                                                <th ></th>
                                                
                                            </tr>
											@endif
                                        </thead>
                                        @if(isset($logistics) and !is_null($logistics))
                                        <input type="hidden" class='curr' value="{{$currentCurrency}}">
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th ></th>
                                                <th ></th>
                                                <th ></th>
                                                <th colspan=1 >
                                                    <span class="pull-left hidden subtotal">Subtotal:</span>
                                                    <span class="pull-right hidden subtotal_amount"></span>
                                                </th>
                                                <th colspan=2 ><button class='btn btn-block btn-danger btn-sm'>Consolidate</button></th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @def $i = 1
                                            @foreach($logistics as $logistic)
                                                <tr>
                                                    <td class='text-center'>{!! $i++ !!}</td>
                                                    
                                                    <td>
													<span class=''>
														<a href="{{ route('logistic_dashboard', ['id' => $logistic->user_id]) }}" target="_blank" >{{IdController::nS($logistic->station_id)}}</a>
													</span>
                                                    </td>
                                                    <td class='text-left'>{!! $logistic->company_name !!}</td>
                                                    <td class='text-center'><a target="_blank" href="{{url('/admin/payment/logistic_single/'.$logistic->logistic_id)}}" >Details</a></td>
                                                    
                                                    <td class='pay text-right'>
														<?php 
															$total_payment += round($logistic->payable/100,2);
														?>
														<span class="pull-left">MYR</span>
                                                        {!! number_format(round($logistic->payable/100,2),2) !!}
                                                    </td>
                                                    <td class='text-center'>{!! $logistic->due !!}</td>
                                                    <td class='text-center'>
														<input 
                                                        type="checkbox" name="merchant_checked[]" value="{{$logistic->user_id}}_{{number_format($logistic->payable,0,'.','')}}_13" />
														<input type="hidden" name="logistic_payment[]" value="{{number_format($logistic->payable,0,'.','')}}" />
														<input type="hidden" name="logistic_id[]" value="{{$logistic->user_id}}" />
													</td>
                                                    <td class='text-center'>{!! $logistic->rcv !!}</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                        @endif
                                    </table>
                                    </div>
                                    </div>
                                    {!! Form::close() !!}
									<input type="hidden" id="total_payment" value="{{number_format($total_payment,2)}}" />
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

    <style type="text/css">
        .border-less-tr th{
            border: 0 !important; 
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#merchantTable, #orderTable').DataTable({
                'aoColumnDefs': [ { "bSortable": false, "aTargets": [] } ],
                "orderCellsTop": true
            });

            $('table th:first').removeClass('sorting_asc');

            var currency = $('.curr').val();
			var total_payment = $("#total_payment").val();
            $('.com, #pay').append("<span class='pull-left'>"+ currency +"</span><span class='pull-right'>"+ total_payment +"</span>");

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

            $('.logistic').click(function(){
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
            });
			
			setTimeout(function(){
				$('.alert').hide("slow");
			}, 4000);
        });

window.setInterval(function(){
              $('#merchant-error-messages').empty();
            }, 10000);


    </script>

    @yield('left_sidebar_scripts')

@stop


