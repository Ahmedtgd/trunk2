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

        <h2>General: Station Type </h2><span  id="user-error-messages">


    </span>
        <div>
            <form method="POST">

                @include('partials.alert')

                <table class="table table-bordered table-responsive" cellspacing="0" width="840px" id='merchantTable'>

                    <input type="hidden" value="mcp" name="ss_type" />
                    <div style="clear:both;"></div>

                    <thead style="background-color: #FF4C4C; color: white;"> <br>
                    <tr>
                        <th style="background-color:#4c4c4c;color:#fff" class="no-sort text-center bsmall">No</th>
                        {{--<th style="background-color:#4c4c4c;color:#fff" class="no-sort text-center bsmall">ID</th>--}}
                        <th style="background-color:#4c4c4c;color:#fff"  class="text-center bmedium">Name</th>
                        <th style="background-color:#4c4c4c;color:#fff"  class="text-center blarge">Description</th>
                       {{--  <th style="background-color:#4c4c4c;color:#fff"  class="text-center bsmall">Action</th> --}}
                    </tr>
                    </thead>

                    @if(isset($station_types) && is_array($station_types) && count($station_types))
                        <tfoot>
                        <tr>

                        </tr>
                        </tfoot>
                        <tbody>
                        @def $i = 1
                        @foreach($station_types as $key => $station_type)
                            <tr>
                                <td class='text-center'>{!! $i++ !!}</td>

                                {{--<td class='text-center'>--}}
                                    {{--{{$station_type->id}}--}}
                                {{--</td>--}}

                                <td class=' text-center'>
                                    <input type="text" value="{{$station_type->name}}"
                                           data-id="{{$station_type->id}}"
                                           data-text="name"
                                           data-url="{{route('generalUpdateStationType', ['id' => $station_type->id])}}"
                                           class="form-control update-station-type-field">
                                </td>

                                <td class=' text-center'>
                                    <input type="text" value="{{$station_type->description}}"
                                           data-text="description"
                                           data-id="{{$station_type->id}}"
                                           data-url="{{route('generalUpdateStationType', ['id' => $station_type->id])}}"
                                           class="form-control partial-field update-station-type-field">
                                </td>

                             {{--    <td class='text-center'>
                                    <button type="button" class='btn btn-block btn-danger btn-sm btn-delete confirm-delete-modal-btn'
                                            data-id="{{$station_type->id}}"
                                            data-url="{{route('generalDeleteStationType', ['id' => $station_type->id])}}"
                                            style="width: 60px;">
                                        Delete</button>
                                </td> --}}
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
            </div>
        </div>
    </div>

    <!-- Station Type Delete Confirmation -->
    <div class="modal fade myModal" id="confirm-station-type-delete-modal" role="dialog">
        <div class="modal-dialog modal-fullscreen">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button id='productClose' type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <h3>Delete Confirmation</h3>
                    </h4>
                </div>
                <div class='modal-body'>
                    <p>
                        Are you sure you want to delete this station Type.<br>
                        It may have been linked to existing record.
                    </p>
                </div>
                <div class="modal-footer" style='border:none'>
                    <button id="confirm-delete-btn" class='btn btn-danger'
                            style="float:right;">Yes I am sure</button>
                    <button type="button" class="btn btn-success " data-dismiss="modal"
                            style="float:left;">No</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Station Type Delete Confirmation -->
    <div class="modal fade myModal" id="add-station-type-modal" role="dialog">
        <div class="modal-dialog modal-fullscreen">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button id='productClose' type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <h3>Add New Station Type</h3>
                    </h4>
                </div>
                <div class='modal-body'>
                    <form>
                        <div class="form-group">
                            <input type="text" placeholder="Name" class="form-control" id="add-pg-name" name="name">
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Description" class="form-control" id="add-pg-description" name="description">
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style='border:none'>
                    <button id="save-station-type-btn" class='btn btn-success'
                            style="float:right;">Save</button>

                    <button type="button" class="btn btn-default" data-dismiss="modal"
                            style="float:left;">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#merchantTable').DataTable({
                "scrollX": true,
                "columnDefs": [
                    {"targets": [0], "width": "15px"}, //No
                    {"targets": [1], "width": "300px"}, // Name
                    {"targets": [2], "width": "auto"}, // Description
                    {"targets": [3], "width": "15px"}, // New IC No
                ]
            });

            /**
             * Delete Station Type
             */
            $('.confirm-delete-modal-btn').click(function()
            {
                $('#confirm-station-type-delete-modal').modal('show');
                $("#confirm-station-type-delete-modal").on('hidden.bs.modal', function () {
                    $(this).data('bs.modal', null);
                })

                var url = $(this).attr('data-url');


                $('#confirm-delete-btn').click(function(){
                    $.ajax({
                        url:url,
                        type:'GET',
                        success:function (r) {
                            if (r.status==true)
                            {
                                toastr.info("Station Type was deleted successfully");
                            }else{
                                toastr.error("Station Type could not deleted successfully");
                            }

                            $('#confirm-station-type-delete-modal').modal('hide');

                            location.reload();
                        },
                        error: function(r){
                            toastr.error("Ops! Internal server error occured");
                        }
                    });
                });
            });

            /**
             * Add New Station Type
             */
            $('#add-new-station-type-btn').on('click', function(e)
            {
                e.preventDefault();

                $('#add-station-type-modal').modal('show');
                $('#add-station-type-modal').on('hidden', function(){
                    $(this).data('modal', null);
                });

                var url = $(this).attr('data-url');
                var name = $('#add-pg-name');
                var description = $('#add-pg-description');
                var save_btn = $('#save-station-type-btn');

                $('#save-station-type-btn').click(function()
                {
                    if(!name.val() || !description.val()){
                        toastr.error('All fields are required');
                    }else{
                        $.ajax({
                            url:url,
                            type:'POST',
                            data: {name: name.val(), description: description.val()},
                            success:function (r) {
                                if (r.status==true)
                                {
                                    toastr.info("Station Type was saved successfully");
                                }else{
                                    toastr.error("Station Type could not be saved");
                                }

                                $('#add-station-type-modal').modal('hide');

                                location.reload();
                            },
                            error: function(r){
                                toastr.error("Ops! Internal server error occurred");
                            }
                        });
                    }
                });
            });


            /**
             * Update station Type
             */
            $('.update-station-type-field').on('change', function(e)
            {
                var id = $(this).attr('data-id');
                var url = $(this).attr('data-url');
                var type = $(this).attr('data-text');
                var value = $(this).val();

                if(value == '' || value.length < 2){
                    toastr.error('Please enter valid '+type);
                }else{
                    var data = {
                        name: (type == 'name') ? value : null,
                        description: (type == 'description') ? value : null
                    }

                    $.ajax({
                        url:url,
                        type:'POST',
                        data: data,
                        success:function (r) {
                            if (r.status==true)
                            {
                                toastr.info("Station Type was updated successfully");
                            }else{
                                toastr.error("Station Type could not be updated");
                            }
                        },
                        error: function(r){
                            toastr.error("Ops! Internal server error occurred");
                        }
                    });
                }

            });

        });

        window.setInterval(function(){
            $('#user-error-messages').empty();
        }, 10000);
    </script>


@stop