<?php
$cf = new \App\lib\CommonFunction();
use App\Http\Controllers\IdController;
$selectListForBusinessType =  $cf->getBusinessType();
use App\Classes;
// {!! Form::select('country', $cf->country(), null, ['class' => 'form-control']) !!}
?>

@extends("common.default")
@section("content")
    @include('common.sellermenu')
    <style type="text/css">
        .table-sections{padding-top: 20px;padding-bottom: 20px}
        .sellerbutton{
            min-width: 70px;
            min-height: 70px;
            padding-top: 26px;
            text-align: center;
            vertical-align: middle;
            float: left;
            font-size: 13px;
            cursor: pointer;
            margin-right: 5px;
            margin-bottom: 5px;
            border-radius: 5px;
            border: none;
        }
        .bg-primaryii{
            background-color: #02d4f9;
            color: #f6f6f6;
        }
        .bg-primarypurple{
            background-color: #2a75ed;
            color: #f6f6f6;
        }
        .bg-black{
            background-color: rgb(0,0,0);
            color: #f6f6f6;
        }

        .sellerbuttons{
            min-width: 70px;
            min-height: 70px;
            padding-top: 4px;
            text-align: center;
            vertical-align: middle;
            float: left;
            font-size: 13px;
            cursor: pointer;
            margin-right: 5px;
            margin-bottom: 5px;
            border-radius: 5px;
            box-shadow: none;
            /*background-color: #6d9370;*/
            border: 0;
            /*color: #dadada;*/
        }
        .select2-container{
            width: 45px !important;
        }


    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js">

    </script>
    <div class="container">

        <div class="row" style="margin-top: 10px;">
            <div class="col-sm-6">
                <h2>Staff Management</h2>
            </div>
            <div class="col-sm-6">
                <!--  <h4>Staff Management</h4>
                 <h4>Staff Management</h4> -->

            </div>
        </div>

        <div class="row">
            <div class="table-responsive" style="padding-left:15px">
                <table class="table table-bordered" cellspacing="0"
                       id="StaffManagement" style="width:100% !important;">
                    <thead style="color:white">
                    <tr style="">
                        <td class="text-center bg-primarypurple">No</td>
                        <td class="text-center bg-primarypurple">Staff ID</td>
                        <td class="text-center bg-primarypurple">Name</td>
                        <td class="text-center bg-primarypurple">Attendance</td>
                        <td class="text-center bg-primarypurple">Schedule</td>
                        <td class="text-center" style="background-color: #34dabb;color: #f6f6f6;">Leave</td>
                        <td class="text-center bg-primarypurple">Today</td>
                        <td class="text-center bg-primarypurple">Salary</td>
                        <td class="text-center bg-primarypurple">Over&nbsp;Time</td>
                        <td class="text-center bg-primarypurple">Commission</td>
                        <td class="text-center bg-primarypurple">Part&nbsp;Time</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $num = 0;?>
                    @foreach($staffs as $staf)
                        <tr>
                            <td style="text-align: center;">{{ ++$num }}</td>
                            <td class="text-center" style="vertical-align: middle">{{sprintf('%010d',$staf->uid)}}</td>
                            <td class="text-center" style="vertical-align: middle"><a onclick="show_staff_name({{$staf->mid}})" href="#">{{$staf->name}}</a></td>
                            <td class="text-center" style="vertical-align: middle"><a href="staff/attendance/{{$staf->uid}}" target="_blank">{{$staf->attendance}}</a></td>
                            <!--  <td class="text-center" style="vertical-align: middle"><a href="staff/test" target="_blank">20</a></td>
                            <td class="text-center" style="vertical-align: middle"><a onclick="showAttendance()" href="#">20</a></td-->
                            <td class="text-center" style="vertical-align: middle"><a onclick="showSchedule({{$staf->uid}})" href="#">{{$staf->schedule}}</a></td>
                            <td class="text-center" style="vertical-align: middle"><a onclick="showleave({{$staf->uid}})" href="#">{{$staf->leave}}</a></td>
                            <td class="text-center" style="vertical-align: middle">Yes</td>
                            <td class="text-center" style="vertical-align: middle">2</td>
                            <td class="text-right" style="vertical-align: middle"><a onclick="showOvertime({{$staf->uid}})" href="#">{{number_format($staf->over_time, 2)}}</a></td>
                            <td class="text-right" style="vertical-align: middle"><a onclick="showCommission({{$staf->mid}})" href="#">{{number_format($staf->commission/100, 2)}}</a></td>
                            <td class="text-right" style="vertical-align: middle"><a onclick="showparttimer({{$staf->uid}})" href="#">{{number_format($staf->part_time, 2)}}</a></td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>


        <div class="modal fade" id="attendanceeModal" role="dialog">
            <div class="modal-dialog maxwidth60" style="min-width: 800px;">
                <!-- Modal content-->
                <div class="modal-content modal-content-sku">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2>March 2018 Attendance</h2>
                    </div>
                    <div id="attendanceBody" style="padding-left:0;padding-right:0" class="modal-body"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="commissionModal" role="dialog">
            <div class="modal-dialog maxwidth60" style="min-width: 990px;">
                <!-- Modal content-->
                <div class="modal-content modal-content-sku">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2>Commissions</h2>
                    </div>
                    <div id="commissionBody" style="padding-left:0;padding-right:0" class="modal-body"></div>
                </div>
            </div>
        </div>



        <div class="modal fade" id="overtimeModal" role="dialog">
            <div class="modal-dialog" style="min-width: 860px;">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2>Over&nbsp;Time</h2>
                    </div>
                    <div id="overtimeBody" class="modal-body text-center"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="scheduleModal" role="dialog">
            <div class="modal-dialog maxwidth60" style="min-width: 800px;">
                <!-- Modal content-->
                <div class="modal-content modal-content-sku">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2>Schedule</h2>
                    </div>
                    <div id="scheduleBody" style="padding-left:0;padding-right:0" class="modal-body"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="leaveModal" role="dialog">
            <div class="modal-dialog maxwidth60" style="min-width: 800px;">
                <!-- Modal content-->
                <div class="modal-content modal-content-sku">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2>Leave</h2>
                    </div>
                    <div id="leaveBody" style="padding-left:0;padding-right:0" class="modal-body"></div>
                </div>
            </div>
        </div>
        <style>
            /*#parttimerModal{*/
            /*display: block !important;*/
            /*}*/
            /*.maxwidth60{*/
            /*overflow-y: initial !important*/
            /*}*/

        </style>

        <div class="modal fade" id="parttimerModal" role="dialog" style="overflow: scroll;">
            <div class="modal-dialog" style="min-width:860px;">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2>Commission & Over Time Definition</h2>
                    </div>
                    <div id="parttimerBody"  class="modal-body"></div>
                </div>
            </div>
        </div>

        <input type="hidden" id="branchmemberid">
        <input type="hidden" id="selectedbranch">
        <!---------------------------------------Branches Pop up Modal------------------------------------>
        <div class="modal fade"  id="show_branches_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document" style="width:65% !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>
                            Branches
                            <small><button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></small>
                        </h3>
                    </div>

                    <div class="modal-body" >

                        @foreach ($branches->chunk(3) as $items)
                            <div class="row">
                                @foreach ($items as $branch)
                                    <div class="col-md-4">
                                        <label id="branch{{$branch->id}}" >
                                            <input id="b{{$branch->id}}" name="branch" onclick="addBranches({{$branch->id}})" type="checkbox" value="{{$branch->id}}"> &nbsp;{{$branch->location}}</label>
                                    </div>
                                @endforeach
                            </div>

                        @endforeach

                    </div>

                </div>
            </div>
        </div>
         <!-------------------------- Product Pop up Modal ---------------------->
    <div class="modal fade" id="show_products_modal" tabindex="-1" role="dialog"
         data-controls-modal="your_div_id" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width:60% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" onclick="close_modal()" data-backdrop="static" data-keyboard="false" class="close">&times;</button>
                    <h3>
                        Products
                    </h3>
                </div>

                <div class="modal-body" >
                    <table class="table table-bordered" style="width:100% !important;" id="product_table">
                    <thead>
                    <tr class="bg-caiman">
                    <th class="text-center">No.</th>
                    <!-- <th class="text-center">Product&nbsp;ID</th> -->
                    <th class="text-center">Product Name</th>
                    </tr>
                    </thead>
                    <?php $index=0; ?>

                    <tbody id="product_content">
                    @foreach($products as $product)
                    <tr style="vertical-align: middle;">
                        <td class="text-center">{{ ++$index }}</td>
                        <!-- <td>{{$product->nproduct_id}}</td> -->
                        <td style="cursor: pointer" onclick="displayTextDisappearModal('{{ $product->name }}','{{$product->id}}',
                                '{{number_format($product->commission_amt/100, 2)}}','{{ asset('images/product/'.$product->id.'/thumb/'.$product->thumb_photo) }}');">
                            <img src="{{ asset('images/product/'.$product->id.'/thumb/'.$product->thumb_photo) }}" alt="thumb" width="30" height="30">{{ $product->name }}
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                    </table>

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    </div>
@stop

@section('scripts')
    <style>
        .modal-open {
            overflow: scroll;
        }
    </style>
    <script>
        $(document).delegate( '#new-row', "click",function (event) {
            {{--var url="{{ url('staff/getcommprods') }}";--}}
            {{--var data={--}}
                {{--branch_id:1--}}
            {{--};--}}
            {{--$.ajax({--}}
                {{--url:url,--}}
                {{--data:data,--}}
                {{--type:"POST",--}}
                {{--success:function(r){--}}
                    {{--// alert(r);--}}
                    {{--var table="";--}}
                    {{--var index=1;--}}
                    {{--var value = JSON.parse(r);--}}
                    {{--JS_BASE_URL="https://opensupermall.com";--}}
                    {{--for (var i in value) {--}}
                        {{--// table += '<tr><td>1</td><td>2</td><td>3</td></tr>';--}}
                        {{--table += '<tr><td class="text-center">'+index+'</td><td>'+value[i].nproduct_id+'</td> <td>'+value[i].name+'</td></tr>';--}}
                        {{--index++;--}}
                    {{--}--}}
                    {{--//table += '<tr><td>1</td><td>2</td><td>3</td></tr>';--}}
                    {{--// alert(table);--}}
                    {{--$("#product_content").empty();--}}
                    {{--$("#product_content").append(table);--}}
                    {{--// pdb.draw();--}}
                    {{--$("#show_products_modal").modal("show");--}}

                {{--},--}}
                {{--error:function(){toastr.warning("Failed to connect to server..")}--}}
            {{--});--}}
            $("#show_products_modal").modal("show");
        });

        function displayTextDisappearModal(pname, pid, pcomm, img_path) {
            // alert(pname);
            $("#rowNum"+rowNum+" #productName").text(pname);
            $("#rowNum"+rowNum+" #productImg").attr('src',img_path);
            $("#rowNum"+rowNum+" #productId").val(pid);
            $("#rowNum"+rowNum+" #prodComm").val(pcomm);
            $("#show_products_modal").modal("hide");
        }
        <!-- Branches Modal -->
        $(document).delegate( '#branch-row', "click",function (event) {

            $('#show_branches_modal').on('shown.bs.modal',function(){
                 $('*[id^="b"]').prop('checked',false);
                var selected  = $('#selectedbranch').val();
                var selectedid = selected.split(",");
                console.log(selectedid);
                if(selectedid.length > 0)
                {
                    for (i = 0; i < selectedid.length; i++) { 
                        // $('#selected_'+selectedid[i]).attr("disabled",false);
                         $('#b'+selectedid[i]).prop('checked',true);
                    }
                }             
               
            });

            $("#show_branches_modal").modal("show");
           
        });
        function addBranches(name){

            // var check = $(this).varal();
            $name = $("#branch"+name).text();
            $id = $("#b"+name).val();
            if($("#b"+name).is(':checked'))
            {
                var elements = $();
                // elements = elements.add('<div class="col-md-10" style="float: padding-bottom: 10px;width: 100%;" id="branch_'+$id+'">'+
                //         '<p onclick="removeRow('+rowNum+');" style=" display:inline; background-color: #FF0000;width: ' +
                //         '10%;text-align: center;color: white; border-radius: 5px;" align="right">&nbsp;&nbsp;&times;&nbsp;&nbsp;</p>'+
                //         ' <input id="name'+$id+'" required type="text" name="commtext" style="width: 25%;" placeholder="Manager commission12"> ='+
                //         ' <input type="hidden" value="'+$id+'" name="location_id" style="width: 25%;"  placeholder="Branch">'+
                //         '<p style=" display:inline;">'+$name+' </p>' +
                //         '  X <input type="text" onfocus="b_erase('+$id+')" required id="percent'+$id+'" onblur="valid_percents('+$id+')" name="commission_pct" style="width: 25%;">%</div>' +
                //         '<strong><span style="color: #ff0000; display: none;" id="b_warning'+$id+'"> Input is out of Percentage Range</span></strong>');

                elements = elements.add(
                        '<div class="row col-md-12" style="padding: 4px;" id="branch_'+$id+'">'+
                            '<div class="col-md-10" >'+
                                '<div class="col-md-1" style="padding-left: 0px;padding-right: 0px;width: 4.33%;line-height: 25px;">'+
                                    '<p onclick="removeBranchRow('+$id+');" style=" display:inline; background-color: #ff100e;width:10%;text-align: center;color: white; border-radius: 5px;padding-top: 5px;padding-bottom: 5px;" align="right">&nbsp;&nbsp;&times;&nbsp;&nbsp;</p>'+
                                '</div>'+
                                '<div class="col-md-4 pl-0" style="padding-right: 0px;">'+
                                    '<input id="name'+$id+'" required type="text" name="commtext"  placeholder="Manager commission" class="commenttext">&nbsp; = '+
                                    ' <input type="hidden" value="'+$id+'" name="location_id" style="width: 25%;"  class="locations" placeholder="Branch">'+
                                '</div>'+
                                '<div class="col-md-2" style="line-height: 25px;">'+
                                    '<p style=" display:inline;">'+$name+' </p> ' +
                                '</div>'+
                                '<div class="col-md-5">'+
                                    ' x &nbsp;<input type="number" onfocus="b_erase('+$id+')" required id="percent'+$id+'"  name="commission_pct" style="width:100px" class="distext" max="100" min="0"> &nbsp;'+
                                    '<span class="inside" style="text-align: left"><strong>%</strong> </span>'+
                                    '<strong><span style="color: #ff0000; display: none;" id="b_warning'+$id+'"> Input is out of Percentage Range</span></strong>'+
                                '</div>'+
                            '</div>'+
                        '</div>');

                $('.manager_comison').append(elements);
                // $('input[name=commission_pct]').number(true, 0, '.', '' );
            }
            else
            {
                removeBranchRow($id);
            }

        }
        function show(element) {  element.css("display","block"); }
        function hide(element) {  element.css("display","none"); }
        function b_erase(num){
            var $error = $('#b_warning'+num);
            hide($error);
        }
        // function valid_percents($id) {
        //     var $myId = $('#percent'+$id).val();
        //     var $error = $('#b_warning'+$id);

        //     var percents = new RegExp('^\\d+\\.\\d{1,2}$');
        //     if (percents.test($myId)) {
        //         //Should not be more than hundred
        //         if (parseFloat($myId) > 100) {
        //             show($error);
        //         }else{

        //             saveComm($id);
        //         }
        //     }else{
        //        show($error);
        //     }
        // }

         function valid_percents() {
            var member_id = $('#branchmemberid').val();
            var data = [];
            $('.commenttext').each(function( index ) {

                var commtext = $( this ).val();
                var id = $(this).attr('id');
                var location_id = id.slice("4");
                var commission_pct = $('#percent'+location_id).val();
                var error = $('#b_warning'+location_id);

                // var percents = new RegExp('^\\d+\\.\\d{1,2}$');

                // if (percents.test(commission_pct)) {
                    //Should not be more than hundred
                    if (parseFloat(commission_pct) > 100) {
                        show(error);
                    }else{
                        if(commtext != '' && commission_pct != '')
                        {
                            data.push({
                                commtext: commtext,
                                location_id:location_id,
                                commission_pct:commission_pct
                            });
                        }                       
                    }
                // }else{
                //    show(error);
                // }                
            }); 
            if(data.length > 0)         
            {
                console.log(data);
                saveComm(data,member_id);
            }
        }

        function removeBranchRow($id)
        {
            var member_id = $('#branchmemberid').val();
            jQuery('#branch_'+$id).remove();
             $.ajax({
                    type: "POST",
                    url: JS_BASE_URL+"/staff/delete_branch_comm",
                    data:{"location_id":$id,"user_id":member_id},
                    success: function( data ) {
                        // console.log(data)
                    }
                });
        }
        function saveComm($data,member_id)
        {
            $.ajax({
                type: "POST",
                url: JS_BASE_URL+"/staff/branch_comm",
                data:{"data":$data,"member_id":member_id},
                success: function( data ) {
                    console.log("success");
                    $('#parttimerModal').modal('hide');
                }
            });
        }

        // function saveComm($id)
        // {
        //     var $locationId =     $("#b"+$id).val();
        //     console.log($id);  console.log($locationId); return false;
        //     var $commission_pct =    $("#percent"+$id).val();
        //     var $comm_name = $("#name"+$id).val();

        //     $.ajax({
        //         type: "POST",
        //         url: JS_BASE_URL+"/staff/branch_comm",
        //         data:{"location_id":$locationId,"commtext" : $comm_name, "commission_pct":$commission_pct},
        //         success: function( data ) {
        //             console.log(data)
        //         }
        //     });
        // }


    </script>
    <script>
        $(document).ready(function(){
            $('#StaffManagement').DataTable();

        });
        // $('#product_table').DataTable();
        $(document).ready(function() {
            $('#product_table').DataTable({
                "paging":   true,
                "ordering": true,
                "info":     false
            });
        });
        function showAttendance(id)
        {
            $.ajax({
                type: "GET",
                url: JS_BASE_URL+"/staff/attendance/"+id,
                success: function( data ) {
                    $("#attendanceBody").html(data);
                    $('#attendanceeModal').modal('show');
                }
            });
        }
        function showCommission(id)
        {
            $.ajax({
                type: "GET",
                url: JS_BASE_URL+"/staff/commission/"+id,
                success: function( data ) {
                    $("#commissionBody").html(data);
                    $('#commissionModal').modal('show');
                }
            });
        }

        function showOvertime(id)
        {
            $.ajax({
                type: "GET",
                url: JS_BASE_URL+"/staff/overtime/"+id,
                success: function( data ) {
                    $("#overtimeBody").html(data);
                    $('#overtimeModal').modal('show');
                }
            });
        }

        function showSchedule($id)
        {
            $.ajax({
                type: "GET",
                url: JS_BASE_URL+"/staff/schedule/"+$id,
                success: function( data ) {
                    $("#scheduleBody").html(data);
                    $('#scheduleModal').modal('show');
                }
            });
        }

        function showleave($id)
        {
            $.ajax({
                type: "GET",
                url: JS_BASE_URL+"/staff/leave/"+$id,
                success: function( data ) {
                    $("#leaveBody").html(data);
                    $('#leaveModal').modal('show');
                }
            });
        }

        function showparttimer(id)
        {
            $.ajax({
                type: "GET",
                url: JS_BASE_URL+"/staff/parttimer/"+id,
                success: function( data ) {
                    $("#parttimerBody").html(data);
                    $('#parttimerModal').modal('show');
                }
            });
        }

        function show_staff_name($id)

        {
            // alert("here")
            $.ajax({
                type: "GET",
                url: JS_BASE_URL+"/staff/staff_name/"+$id,
                success: function( data ) {
                    $("#parttimerBody").html(data);
                    $('#parttimerModal').modal('show');
                }
            });
        }



    </script>
@stop
<!-- @yield("left_sidebar_scripts") -->

