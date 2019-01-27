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

        table#merchantTable, table#giro-detail-invoices
        {
            table-layout: fixed;
            max-width: none;
            width: auto;
            min-width: 100%;
        }

        .btn-file {
            position: relative;
            overflow: hidden;
        }
        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }


    </style>
    <?php $i=1; ?>

    <div class="container" style="margin-top:30px;">
        @include('admin/panelHeading')

        <h2>OCBC Giro Reader Invoices</h2><span  id="user-error-messages">
    </span>
        <div>
            @include('partials.alert')

            <table class="table table-bordered table-responsive" cellspacing="0" width="840px" id="giro-detail-invoices" style="display:none;">
                <thead style="background-color: #808080; color:#fff; ">
                <tr>
                    <th class="no-sort bsmall text-center">No</th>
                    <th class="text-left blarge">Description</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function()
        {
            //giro detail
            //--------------------------------------------------------------------------------------
            console.log(localStorage.getItem('giroDetails'));
            var details = JSON.parse(localStorage.getItem('giroDetails'));
            var id = '{{$id}}';

            if(typeof details == 'object')
            {
                var invoices = [];

                $.each(details[id].invoice_details, function(key, inv)
                {
                    invoices.push({
                        id                  : key + 1,
                        description         : inv.description
                    });
                });

                $('#giro-detail-invoices').show();

                $('#giro-detail-invoices').dataTable({
                    "scrollX": true,
                    "columnDefs": [
                        {"targets": [0], "width": "15px"}, //No
                    ],
                    "data": invoices,
                    "columns": [
                        { "data": "id", className: "text-center"},
                        { "data": "description", className: "text-left"}
                    ]
                });
            };
        });
    </script>
@stop