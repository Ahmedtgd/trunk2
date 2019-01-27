<?php 
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>
@extends("common.default")

@section('css')
    .paymentTable{ background : #000; color : #fff; }

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


@stop
{{--{{ dd($employees) }}--}}
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
                                    {{-- Employee View Table --}}
                                    <h2>Payment: Logistics</h2>
			     	    <span  id="employee-error-messages">
	      			    </span>
                                    <br>
                                    <!--{!! Form::open(array('url'=>'/payemployee')) !!}-->
                                        {!! Form::open(array('url'=>'/paymerchant')) !!}
                                    <table class="table table-bordered" style="border: none;" id='employeeTable' width="100%">
                                        <thead>
                                        <tr class='paymentTable'>
                                            <th class='text-center no-sort bsmall'>No</th>
                                            <th class='text-center blarge'>User&nbsp;ID</th>
                                            <th class='text-center blarge'>Name</th>
                                            <th class='text-center bmedium'>Details</th>
                                            <th class='text-center blarge'>Outstanding</th>
                                            <th class='text-center blarge'>Payment&nbsp;Due&nbsp;Date</th>
                                            <th class='text-center bmedium' style="background-color: red;">Payment</th>
                                            <th class='text-center blarge'>Date&nbsp;Paid</th>
                                        </tr>
                                        </thead>
                                        @if(isset($employees) and !is_null($employees))
                                            <tfoot>
                                            <tr>
                                                <th style="border: none;"></th>
                                                <th style="border: none;"></th>
                                                <th style="border: none;"></th>
                                                <th style="border: none;"></th>
                                                <th style="border: none;"></th>
                                                <th style="border: none;"></th>
												<th colspan=2 style="border: none;"><button class='btn btn-block btn-danger btn-sm'>Consolidate</button></th>
                                            </tr>
                                            </tfoot>
                                            <tbody>
                                            @def $i = 1
                                            @for($w=0;$w<sizeof($employees[0]);$w++)
                                                <tr>
                                                    <td class='text-center'>{!! $i++ !!}</td>
                                                    <td class='text-center'>
                                                        <!--<a class='emp_id' data-val="{!! route('userPopup', $employees[0][$w]->emp_id) !!}">[{!! str_pad($employees[0][$w]->emp_id, 10, '0', STR_PAD_LEFT) !!}]-->
					<a href="javascript:void(0)" class="view-employee-modal" data-id="{{$employees[0][$w]->emp_id}}">
					{!! IdController::nB($employees[0][$w]->emp_id) !!}

                                                        </a>
                                                    </td>
                                                    <td  class='text-center'>
                                                        {!! $employees[0][$w]->name !!}
                                                    </td>
                                                    <td  class='text-center'>
                                                        <!--<a href="{{route('employeepaydetails', ['id' => $employees[0][$w]->emp_id])}}" target="_blank" onclick="window.open('{{route('employeepaydetails', ['id' => $employees[0][$w]->emp_id])}}','popup', 'scrollbars=1','width=800,height=600'); return false;" class="emppayment_details" rel="{{$employees[0][$w]->emp_id}}">Details</a>-->
							<a href="{{route('employeepaydetails', ['id' => $employees[0][$w]->emp_id])}}" target="_blank" onclick="window.open('{{route('employeepaydetails', ['id' => $employees[0][$w]->emp_id])}}'); return false;" class="emppayment_details" rel="{{$employees[0][$w]->emp_id}}">Details</a>
                                                    </td>
                                                    <td>
                                                        <span class="pull-left">
                                                        {!! $employees[0][$w]->currency !!}
                                                        </span>
														<?php
															$eepf = 0;
															$esocso = 0;
															$epcb = 0;
															if(isset($employees[1][$w]['epf'])){
																$eepf = $employees[1][$w]['epf'] + $employees[1][$w]['eepf'];
															}
															if(isset($employees[1][$w]['socso'])){
																$esocso = $employees[1][$w]['socso'] + $employees[1][$w]['esocso'];
															}
															if(isset($employees[1][$w]['pcb'])){
																$epcb = $employees[1][$w]['pcb'];
															}															
															$outstanding = $employees[0][$w]->monthly_income - ($eepf + $esocso + $epcb);
														?>
                                                        <span class="pull-right">
														{{ number_format($outstanding,2) }}
                                                        </span>
                                                    </td>
                                                    <td class='text-center'>
                                                        {!! $employees[0][$w]->due !!}
                                                    </td>
                                                    <td class="text-center">
                                                        @if($employees[0][$w]->payment)
                                                            <input type="checkbox" name='employee[]' value='{!! $employees[0][$w]->emp_id !!}'>
                                                        @else
                                                            <input type="checkbox" name='employee[]' value='{!! $employees[0][$w]->emp_id !!}'>
                                                        @endif
                                                    </td>

                                                    <td class="text-center">
                                                        @if(!empty($employees[0][$w]->payment_at)){{ UtilityController::s_date($employees[0][$w]->payment_at) }}@endif
                                                    </td>												
                                                </tr>
                                            @endfor
                                            </tbody>
                                        @endif
                                    </table>
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
    <div class="modal fade myModal" id="empModal" role="dialog">
        <div class="modal-dialog modal-fullscreen">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button id='empClose' type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <h3>User Information</h3>
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
            $('#employeeTable').DataTable({
                "scrollX": true,
				"columnDefs": [
					{"targets": "no-sort", "orderable": false},
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

            $('.emp_id').click(function(){
                $('body').css('padding','0px');
                var route = $(this).attr('data-val');
                $.ajax({
                    type : "GET",
                    url : route,
                    success : function(response){
                        $('#empModal').find('.modal-body').html(response);
                        $('#empModal').modal('show');
                    }
                })
            })
            $('table th:first').removeClass('sorting_asc');
        })

$('.view-employee-modal').click(function(){

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
        $('#employee-error-messages').html(msg);
        }
        }
        });
});

window.setInterval(function(){
              $('#employee-error-messages').empty();
            }, 10000);

    </script>

    @yield('left_sidebar_scripts')
@stop

