@extends("common.default")<?php
use App\Classes;
use App\Http\Controllers\UtilityController;
define('MAX_COLUMN_TEXT', 20);
$today = date('d');
$month = date('m');
$year = date('Y');
if($month == "02"){
    if($today < 16){
        $due_pay = "15-" . $month . "-" . $year . " 00:00:00";
    } else {
        $due_pay = "28-" . $month . "-" . $year . " 00:00:00";
    }
} else {
    if($today < 16){
        $due_pay = "15-" . $month . "-" . $year. " 00:00:00";
    } else {
        $due_pay = "30-" . $month . "-" . $year . " 00:00:00";
    }
}

if($month == "01"){
    if($today > 15){
        $paid_pay = "15-" . $month . "-" . $year. " 00:00:00";
    } else {
        $paid_pay = "30-" . "12". "-" . ($year-1) . " 00:00:00";
    }
} else if($today > 15){
    if($today > 15){
        $paid_pay = "15-" . $month . "-" . $year . " 00:00:00";
    } else {
        $paid_pay = "25-" . "02" . "-" . $year . " 00:00:00";
    }
} else {
    if($today > 15){
        $paid_pay = "15-" . $month . "-" . $year . " 00:00:00";
    } else {
        $paid_pay = "25-" . str_pad(($month - 1), 2, '0', STR_PAD_LEFT) . "-" . $year . " 00:00:00";
    }
}
?>


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
    </style>
    <?php $i=1; ?>

    <div class="container" style="margin-top:30px;">
        @include('admin/panelHeading')

        <h2>Receivable: Payment Gateway IPay88</h2><span  id="user-error-messages">


    </span>
        <div>
            <form method="POST" action="{{route('postMPPaymentConsolidate')}}">

                @include('partials.alert')

                <table class="table table-bordered table-responsive" cellspacing="0" width="840px" id='merchantTable'>

                    <input type="hidden" value="mcp" name="ss_type" />
                    <thead style="background-color: #FF4C4C; color: white;">
                    <tr>
                        <th style="background-color:#148cc8;color:#fff" class="no-sort text-center bsmall">No</th>
                        <th style="background-color:#148cc8;color:#fff"  class="text-center blarge">User ID</th>
                        <th style="background-color:#148cc8;color:#fff"  class="text-center blarge">Order ID</th>
                        <th style="background-color:#148cc8;color:#fff"  class="sum text-center bmedium no-sort">Expense</th>
                        <th style="background-color:#18072b;color:#fff"  class="text-center bmedium">Sales</th>
                        <th style="background-color:#18072b;color:#fff"  class="bsmall text-center">Visa/Master</th>
                        <th style="background-color:#18072b;color:#fff"  class="bsmall text-center">Bank ID</th>
                        <th style="background-color:#18072b;color:#fff"  class="text-center bmedium">Bank</th>
                        <th style="background-color:#18072b;color:#fff"  class="text-center bmedium">Paypal</th>
                        <th style="background-color:#18072b;color:#fff"  class="text-center bmedium">Receivable</th>
                    </tr>
                    </thead>

                    @if(isset($receivables) && is_array($receivables) && count($receivables))
                        <tfoot>
                        <tr>
                        </tr>
                        </tfoot>
                        <tbody>
                        @def $i = 1
                        @foreach($receivables as $key => $receivable)
                            <tr>
                                <td class='text-center'>{!! $i++ !!}</td>

                                <td class='text-center'>
                                    <a href="javascript:void(0)" class="view-user-modal" data-id="{{ $receivable->user_id }}">
                                        [{!! str_pad($receivable->user_id, 10, '0', STR_PAD_LEFT) !!}]
                                    </a>
                                </td>

                                <td  class='text-center'>
                                    [{!! str_pad($receivable->order_id, 10, '0', STR_PAD_LEFT) !!}]
                                </td>

                                <td class=' text-center'>
                                    @if(!is_null($receivable->expense) && $receivable->expense > 0)
                                        {{$currency->code}} {{ number_format($receivable->expense,2) }}
                                    @else
                                        0.00
                                    @endif
                                </td>

                                <td class=' text-center'>
                                    @if(!is_null($receivable->sales) && $receivable->sales > 0)
                                        {{$currency->code}} {{ number_format($receivable->sales, 2) }}
                                    @else
                                        0.00
                                    @endif
                                </td>

                                <td class=' text-center'>
                                    -
                                </td>
                                <td class=' text-center'>
                                    -
                                </td>

                                <td class='text-center'>
                                    @if(!is_null($receivable->expense) && $receivable->expense > 0)
                                        {{$currency->code}} {{ number_format($receivable->expense,2) }}
                                    @else
                                        0.00
                                    @endif
                                </td>

                                <td class='text-center'>
                                    -
                                </td>

                                <td class='text-center'>
                                    @if(!is_null($receivable->receivable) && $receivable->receivable > 0)
                                        {{$currency->code}} {{ number_format($receivable->receivable,2) }}
                                    @else
                                        0.00
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    @endif
                </table>
            </form>
        </div>
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
            var table = $('#merchantTable').DataTable({
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

            $('.view-user-modal').click(function(){

                var user_id=$(this).attr('data-id');
                var check_url=JS_BASE_URL+"/admin/popup/check/user/"+user_id;
                $.ajax({
                    url:check_url,
                    type:'GET',
                    success:function (r) {
                        if (r.status=="success") {
                            var url=JS_BASE_URL+"/admin/popup/user/"+user_id;
                            var w=window.open(url,"_blank");
                            w.focus();
                        }
                        if (r.status=="failure") {
                            var msg="<div class='alert alert-danger'>"+r.long_message+"</div>";
                            $('#user-error-messages').html(msg);
                        }
                    }
                });


            });
            /*   $('table th:first').removeClass('sorting_asc');
             var currency = $('.curr').val();

             $('.com, .pay').append("<span class='pull-left'>"+ currency +"</span>");	*/
        });
        window.setInterval(function(){
            $('#user-error-messages').empty();
        }, 10000);
    </script>


@stop