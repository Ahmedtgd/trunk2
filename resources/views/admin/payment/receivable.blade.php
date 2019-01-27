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
                        <th style="background-color:#4c4c4c;color:#fff" class="no-sort text-center bsmall">No</th>
                        <th style="background-color:#4c4c4c;color:#fff"  class="text-center blarge">Payment Gateway ID</th>
                        <th style="background-color:#4c4c4c;color:#fff"  class="text-center blarge">Name</th>
                        <th style="background-color:#4c4c4c;color:#fff"  class="text-center bmedium" style="background-color:#008000;color:#fff">Details</th>
                        <th style="background-color:#4c4c4c;color:#fff"  class="sum text-center bmedium no-sort">Receivable</th>
                        <th style="background-color:#4c4c4c;color:#fff"  class="text-center bmedium">Due Date</th>
                        <th style="background-color:#4c4c4c;color:#fff"  class="text-center bmedium">Partial</th>
                        <th style="background-color:#4c4c4c;color:#fff"  class="bsmall text-center">Balance</th>
                        <th style="background-color:#18072b;color:#fff"  class="text-center bmedium">Confirmation</th>
                        <th style="background-color:#18072b;color:#fff"  class="text-center bmedium">Remarks</th>
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
                                    <a href="javascript:void(0)" class="view-user-modal" data-id="{{ $receivable->gateway_id }}">
                                        [{!! str_pad($receivable->gateway_id, 10, '0', STR_PAD_LEFT) !!}]
                                    </a>
                                </td>

                                <td  class='text-center'>
                                    {!! $receivable->gateway_name !!}
                                </td>

                                <td class=' text-center'>
                                    <a target="_blank" href="{{route('paymentReceivableGatewayDetail', ['week_number' => $receivable->week_number])}}"
                                       target="popup"
                                       onclick="window.open('{{route('paymentReceivableGatewayDetail', ['week_number' => $receivable->week_number])}}'); return false;">
                                        Details
                                    </a>
                                </td>

                                <td class=' text-center'>
                                    @if(!is_null($receivable->receivable) && $receivable->receivable > 0)
                                        {{$currency->code}} {{ number_format($receivable->receivable,2) }}
                                    @else
                                        0.00
                                    @endif
                                </td>

                                <td class='text-center'>
                                    {{$receivable->due_date}}
                                </td>

                                <td class='text-center'>
                                    <?php
                                        //$currency->code . " ".
                                    if(!is_null($receivable->partial) && $receivable->partial > 0){
                                        $partial = number_format($receivable->partial,2);
                                    }else{
                                        $partial = '0.00';
                                    }
                                    ?>
                                    <div class="form-group">
                                        <input id="{{$receivable->week_number}}" type="text" value="{{$partial}}"
                                            data-id="{{$receivable->payment_id}}"  data-url="{{route('paymentReceivableGatewayPartial')}}"  class="form-control partial-field">
                                    </div>
                                </td>

                                <td>
                                    @if(!is_null($receivable->balance) && $receivable->balance > 0)
                                        {{$currency->code}} {{ number_format($receivable->balance,2) }}
                                    @else
                                        0.00
                                    @endif
                                </td>

                                <td id="{{$receivable->week_number}}-confirmation">

                                    @if($receivable->remarks)
                                        {{$receivable->confirmation}}
                                    @else
                                        <button id="{{$receivable->week_number}}-confirmation-btn"
                                                data-id="{{$receivable->week_number}}"
                                                data-url="{{route('paymentReceivableGatewayRemark')}}"
                                                data-text="{{$receivable->payment_id}}"
                                                type="button"
                                                class="receivable-remarks-modal btn btn-sucess btn-small">
                                                Confirm
                                        </button>
                                    @endif

                                </td>

                                <td id="{{$receivable->week_number}}-remarks">
                                    {{$receivable->remarks or '-'}}
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

    <!-- Product Modal -->
    <div class="modal fade myModal" id="receivable-remarks-modal" role="dialog">
        <div class="modal-dialog modal-fullscreen">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button id='productClose' type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <h3>Remarks</h3>
                    </h4>
                </div>
                <div class='modal-body'>
                    <form id="receivable-remark-form">
                        <div class="form-group">
                            <label for="email"></label>
                            <div class="alert alert-danger" style="display: none;" id="remark-alert"></div>
                            <textarea name="receivable-remark" class="form-control" id="receivable-remark"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default"><i class="fa fa-spin fa-cog" style="display:none;"></i> Save</button>
                    </form>
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


            $('.receivable-remarks-modal').click(function()
            {
                $('#receivable-remarks-modal').modal('show');

                var url = $(this).attr('data-url');
                var week_number = $(this).attr('data-id');

                var week_remarks = $('#'+week_number+'-remarks');
                var week_confirmation = $('#'+week_number+'-confirmation');
                var week_confirmation_btn = $('#'+week_number+'-confirmation-btn');

                $('#receivable-remark-form').on('submit', function(e)
                {
                    e.preventDefault();
                    var remark = $(this).find('#receivable-remark').val();
                    var alertbox = $(this).find('#remark-alert');
                    var spinner = $(this).find('.fa-spin');

                    spinner.show();

                    if(remark == ''){
                        alertbox.html('Please enter remarks').show();
                    }else if(remark.length < 5 ){
                        alertbox.html('Please should be atleast 5 characters long').show();
                    }else{
                        alertbox.hide();

                        $.ajax({
                            url:url,
                            type:'POST',
                            data: {remarks: remark, week_number: week_number},
                            success:function (r) {
                                if (r.status==true)
                                {
                                    $('#receivable-remarks-modal').modal('hide');
                                    week_remarks.html(remark);
                                    week_confirmation.html(r.message);
                                    toastr.info("Remark was saved successfully");
                                }else{
                                    alertbox.html(r.response).show();
                                    toastr.error("Remark could not be saved");
                                }
                            }
                        });
                    }


                });
            });


            $('.partial-field').change(function()
            {
                var week_number = $(this).prop('id');
                var partial = $(this).val();
                var payment_id = $(this).attr('data-id');
                var url = $(this).attr('data-url');

                if(isNaN(parseFloat(partial))){
                    toastr.error("Please enter a valid amount");
                }else{
                    $.ajax({
                        url:url,
                        type:'POST',
                        data: {partial: partial, week_number: week_number, payment_id: payment_id},
                        success:function (r) {
                            if (r.status==true)
                            {
                                toastr.info("Partial was saved successfully");
                            }else{
                                toastr.error("Partial could not saved successfully");
                            }
                        }
                    });
                }
            });


            $('.view-user-modal').click(function()
            {

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