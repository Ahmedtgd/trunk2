@extends("common.default")
@section("content")
    @include('common.sellermenu')

<style>
	button.btn.btn-red.btn-mid{
        margin-bottom: 3px;
        font-size: 14px;
        padding: 8px 60px;
        background-color: #f50909b8;
        width: 100%;
        border-radius: 15px;
	}
    .select2-container{width: 50% !important;}

</style>
    <div class="container" style="margin-top:30px;">
        <style>
            #paysliptable{
                border-collapse:collapse;
            }
            #paysliptable td{
                padding: 3px;
                margin: 0;
                text-align: center;
            }
        </style>
        <table style="width:100%;">
            <tr>
                <td width="25%">
                    @if($staff)
                    <div><h3>{{$staff[0]->name}}</h3></div>
                    <div style="font-size: 16px;">Staff ID.:{{$staff[0]->uid}}</div>
                    @endif
                    <div>
                        <select style="background-color: white; font-weight: bold;" id="recordOf">
                            <option value="today">Today</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                            <option value="yearly">Yearly</option>
                            <option value="since">Since</option>
                        </select>
                        <input type="date" id="sinceDate" style="display: none;" class="form-control">
                    </div>
                    <div><h3>Attendance</h3></div>

                </td>
                <td width="30%">
                    <div style="float: right;">
                        <p style="height: 100px;width: 100px;border: 1px solid;"></p>
                        @if($schedule!=null)
                        <p>working hours: {{$schedule->shift->start}}-{{$schedule->shift->end}}</p>
                            @else
                        <p>No Schedule for today</p>
                        @endif
                    </div>
                </td>

                <td width="50%" >
                    <div style="float:  right; margin-top: 80px;margin-right: -5px;">
                        <div class="sellerbutton" style="background-color: #7E7D82;color: white;">
                            <span>Entitle</span>
                        </div>
                        <div class="sellerbutton" onclick="summary()" style="background-color: #0F52E7;color: white;">
                            <span>Summary</span>
                        </div>
                        <div class="sellerbutton" onclick="schedule()" style="background-color: #0F52E7;color: white;">
                            <span>Schedule</span>
                        </div>

                        <div class="sellerbutton" onclick="payslip()" style="background-color: #D03A39;color: white;">
                            <span>Pay Slip</span>
                        </div>
                        <!-- <button type="button" class="btn btn-red btn-mid" style="font-size: 14px;padding: 8px 60px;background-color: #D03A39;" onclick="payslip()" >Pay Slip</button><br/>
                         <button type="button" class="btn btn-red btn-mid" style="font-size: 14px;padding: 8px 60px;background-color: #0F52E7;" onclick="summary()">Summary</button><br/>
                         <button type="button" class="btn btn-red btn-mid" style="font-size: 14px;padding: 8px 60px;background-color: #0F52E7;" onclick="schedule()">Schedule</button><br/>
                         <button type="button" class="btn btn-red btn-mid" style="font-size: 14px;padding: 8px 60px;background-color: #7E7D82;">Entitlement</button>-->
                    </div>
                </td>
            </tr>

        </table>

        <table style="width:100%; text-align: center;" id="raw-datatable" style="margin-bottom: 15px;margin-top: 15px;">
            <thead style="color:white">
                <tr>
                    <td width="20%"
						class="text-center"
						style="background-color: #0F67E2; color:white;">
						<b>Date</b></td>
                    <td width="15%" width="30%"
						class="text-center"
						style="background-color:#36A44B;color:white">
						<b>In</b></td>
                    <td width="15%" width="30%"
						class="text-center"
						style="background-color:#36A44B;color:white">
						Status</td>
                    <td width="20%" width="30%"
						class="text-center"
						style="background-color:#D63137;color:white">
						<b>Out</b></td>
                    <td width="15%" width="30%"
						class="text-center"
						style="background-color:#D63137;color:white">
						<b>Status</b></td>
                    <td width="15%" width="30%"
						class="text-center"
						style="background-color:#EA7F3B;color:white">
						<b>Overtime (hrs)</b></td>
                </tr>
            </thead>
            <tbody>
                    @if($attendance!=null)
                <tr>
                    <td>{{$attendance[0]}}</td>
                    <td>{{$attendance[1]}}</td>
                    <td>{{$attendance[2]}}</td>
                    <td>{{$attendance[3]}}</td>
                    <td>{{$attendance[4]}}</td>
                    <td>{{$attendance[5]}}</td>

                </tr>
                @endif
            </tbody>

        </table>

        <div class="modal fade" id="payslipModal " role="dialog">
            <div class="modal-dialog maxwidth60" style="width:60%">
                <!-- Modal content-->
                <div class="modal-content modal-content-sku">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2>Pay Slip</h2>
                    </div>
                    <div id="payslipBody" style="padding-left:0;padding-right:0" class="modal-body"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="summaryModal" role="dialog">
            <div class="modal-dialog maxwidth40" style="min-width:48%">
                <!-- Modal content-->
                <div class="modal-content modal-content-sku">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2>Summary</h2>
                    </div>
                    <div id="summaryBody" style="padding-left:0;padding-right:0" class="modal-body"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="scheduleModal" role="dialog">
            <div class="modal-dialog maxwidth40" style="min-width: 840px;">
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
            <div class="modal-dialog maxwidth40" style="min-width: 840px;">
                <!-- Modal content-->
                <div class="modal-content modal-content-sku">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2>Leave Application</h2>
                    </div>
                    <div id="leaveBody" style="padding-left:0;padding-right:0" class="modal-body"></div>
                </div>
            </div>
        </div>

   </div>
@stop
@section('scripts')
<script>
    var table;
  $(document).ready(function() {
        table=$('#raw-datatable').DataTable();
          $('.select_forall_staff').select2();

  });
    $('#sinceDate').change(function() {
        var date = $("#sinceDate").val();
        var val=$( "select#recordOf option:selected").val();
        var data={id:'{{$id}}',type:val,'date':date};
        $.ajax({
            type: "POST",
            url: JS_BASE_URL+"/staff/attendance/record",
            data:data,
            success: function( data ) {
                console.log(data);
                table.destroy();
                table=$('#raw-datatable').DataTable( {
                    data: data
                } );
            }
        });
    });
  $( "#recordOf" )
          .change(function() {

              var val=$( "select#recordOf option:selected").val();
              console.log(val);
              if(val!="since"){
                  $("#sinceDate").css('display','none');
              }else {
                  $("#sinceDate").css('display','block');
                  return;
              }
              var data={id:'{{$id}}',type:val};
              $.ajax({
                  type: "POST",
                  url: JS_BASE_URL+"/staff/attendance/record",
                  data:data,
                  success: function( data ) {
                      console.log(data);
                      table.destroy();
                      table=$('#raw-datatable').DataTable( {
                          data: data
                      } );
                  }
              });
          });


  function payslip()
  {

      $.ajax({
          type: "GET",
          url: JS_BASE_URL+"/staff/payslip",
          success: function( data ) {
              $("#payslipBody").html(data);
              $('#payslipModal').modal('show');
          }
      });
  }
  function summary()
  {
      $.ajax({
          type: "GET",
          url: JS_BASE_URL+"/staff/summary",
          success: function( data ) {
              $("#summaryBody").html(data);
              $('#summaryModal').modal('show');
          }
      });
  }

  function schedule()
  {
      $.ajax({
          type: "GET",
          url: JS_BASE_URL+"/staff/schedule",
          success: function( data ) {
              $("#scheduleBody").html(data);
              $('#scheduleModal').modal('show');
          }
      });
  }

  function leave()
  {
      $.ajax({
          type: "GET",
          url: JS_BASE_URL+"/staff/leave",
          success: function( data ) {
              $("#leaveBody").html(data);
              $('#leaveModal').modal('show');
          }
      });
  }


</script>


@stop
