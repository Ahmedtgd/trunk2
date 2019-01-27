@extends("common.default")<?php
use App\Classes;
define('MAX_COLUMN_TEXT', 20);
?>
@inject('helper', 'App\Helper')
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
    <div class="container" style="margin-top:30px;">
        @include('admin/panelHeading')
        <h2>Payment: Station Recruiter</h2><span  id="user-error-messages"></span>
        <form method="POST" action="{{route('srPaymentConsolidate')}}">
            <div class="tableData">
                <div class="table-responsive">

                    @if(Session::has('error_msg'))
                        <div class="alert alert-danger"></span><strong> {!! session('error_msg') !!}</strong></div><br>
                    @elseif(Session::has('success_msg'))
                        <div class="alert alert-success"></span><strong> {!! session('success_msg') !!}</strong></div><br>
                    @endif

                <table class="table table-bordered" cellspacing="0" width="100%" id='recruiterTable'>
                    <thead style="background-color: #FF4C4C; color: white;">
                        <tr>
                        <th style="background-color:#000000;color:#fff" class="no-sort text-center bsmall">No</th>
                        <th style="background-color:#000000;color:#fff"  class="text-center medium">User&nbsp;ID</th>
                        <th style="background-color:#000000;color:#fff"  class="text-center blarge">Name</th>
                        <th style="background-color:#000000;color:#fff"  class="text-center blarge" style="background-color:#008000;color:#fff">Details</th>
                        <th style="background-color:#000000;color:#fff"  class="text-center no-sort medium" style="background-color:#008000;color:#fff">Analysis</th>
                        <th style="background-color:#000000;color:#fff"  class="sum text-center medium no-sort">Outstanding</th>
                        <th style="background-color:#000000;color:#fff"  class="text-center medium">Due Date</th>
                        <th style="background-color:#F40307;color:#fff"  class="xlarge text-center">PAYMENT</th>
                        <th style="background-color:#000000;color:#fff"  class="text-center medium">Date Paid</th>
                    </tr>
                    </thead>
                    @if(isset($station_recruiter) and !is_null($station_recruiter))
                        <tfoot>
                            <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class= 'pay' id='pay'></th>
                            <th colspan=1 >
                                <span class="pull-left hidden subtotal">Subtotal :</span>
                                <span class="pull-right hidden subtotal_amount"></span>
                            </th>

                            <th colspan=2 >
                                @if(isset($station_recruiter) && is_array($station_recruiter) && count($station_recruiter) )
                                    <button class='btn btn-block btn-danger btn-sm'>Consolidate</button>
                                @endif
                            </th>

                        </tr>
                        </tfoot>
                        <tbody>
                        @def $i = 1; $x = 0; $today = Carbon::today();
                        @foreach($station_recruiter as $sr)
                            <?php $sr->currency_code = $currency->code; ?>
                            <tr>
                                <input type="text" name="user" value="{{$sr->user_id}}" hidden>
                                <td class='text-center'>{!! $i++ !!}</td>
                                <td class='text-center'>
                                    <a href="javascript:void(0)" class="view-user-modal" data-id="{{ $sr->user_id }}"> [{!! str_pad($sr->user_id, 10, '0', STR_PAD_LEFT) !!}] </a>
                                </td>
                                <td  class='text-center'>{!! $sr->sr_name !!}</td>
                                <td class=' text-center'><a target="_blank" href="{{route('srPaymentDetails', ['sr_id'=>$sr->user_id])}}">Details</a></td>
                                <td class=' text-center'><a target="_blank" href="{{route('srPaymentAnalysis', ['sr_id'=>$sr->user_id])}}">Details</a></td>
                                <td class=' text-center'>{{number_format((!empty($sr->outstanding)?$sr->outstanding:0) / 100 , 2)}}</td>

                                <td class="tex-center">{{$helper->dueDate($sr->rcv)}}</td>

                                <td class='text-center'>
                                    <input type='checkbox' name='sr_ids[]' value='{{$sr->user_id}}'>
                                    <input type='hidden' name='station_ids[{{$sr->user_id}}]' value='{{$sr->station_id}}'>
                                    <input type='hidden' name='receivables[{{$sr->user_id}}]' value='{{$sr->receivable}}'>
                                </td>

                                <td></td>
                            </tr>
                        @endforeach
                        </tbody>
                    @endif
                </table>
            </div>
        </div>
        {!! Form::close() !!}
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
            var table = $('#recruiterTable').DataTable({
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
            $('table th:first').removeClass('sorting_asc');
//            var currency = $('.curr').val();

            $('.com, .pay').append("<span class='pull-left'>{{$currency->code}}</span>");
        });
    </script>
@stop
