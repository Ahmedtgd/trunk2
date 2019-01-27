
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
    #raw-datatable2_wrapper{
        width: 65%;
    }
</style>
    <div class="container">
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
        <div class="row">
        <table style="width:65%; margin-bottom: 10px;">
            <tr>
                <td width="40%">
                    <div><h3>{{$user->first_name}} {{$user->last_name}}</h3></div>
                    <div style="font-size: 16px;">Staff ID.:{{$user->id}}</div>
                    <div>
                        <select class="select_forall_staff" id="select_forall_staff">
                            <option value=""></option>
                            <option value="1">Today</option>
                            <option value="2">Weekly</option>
                            <option value="3">Monthly</option>
                            <option value="4">Yearly</option>
                            <option value="5">Since</option>
                        </select>
                    </div>


                </td>
                <!--<td width="40%"><p style="border-radius: 1px solid black; height: 80px;width: 90px;border: 1px solid;"></p>

                    <p>Working Hours:9:00:00-17:00:00</p>
                </td>-->

                <td width=" ">
                    <div style="float:  left;width:40%;">
                        <p style="margin-top: 80px;"></p>
                    </div>
                    <div style="float:  right;margin-top: 30px;">
                        <div class="sellerbutton" onclick=" " style="background-color: #7E7D82;color: white;">
                            <span>Entitle</span>
                        </div>
                        <div class="sellerbutton" onclick="showleave({{$user_id}})" style="background-color: #24A095;color: white;">
                            <span>Leave</span>
                        </div>
                    </div>
                </td>
            </tr>

        </table>

        <table width="100%"  id="raw-datatable2" style="text-align: center;">
            <thead style="color:white">
                <tr>

                    {{--<td   style="width:20%; background-color: #0C4FD2; color:white;"><b>Day</b></td>--}}
                    <td  style="width:20%; background-color:#0C4FD2;color:white"><b>Date</b></td>
                    <td   style="width:20%; background-color:#2A9336;color:white">In</td>
                    <td  style="width:20%; background-color:#C62C2E;color:white"><b>Out</b></td>
                    <td style="width:20%; background-color:#29734E;color:white"><b>Working</b></td>
                </tr>
            </thead>
            <tbody id="">

            </tbody>
            <p id="user_id" style="display: none;">{{$user_id}}</p>
        </table>
   </div>
</div>
<script>

    function woosh($rid) {

        var $id =   $("#leave_app"+$rid).val();
        var $user_id = $('#user_id').html();
        var $type =   $("#leave_app"+$rid+" option:selected").text();



        $.ajax({
            type: "POST",
            url: JS_BASE_URL+"/staff/leave",
            data:{"user_id":$user_id,"leave_type": $id,"type" : $type},
            success: function( data ) {
                console.log(data)
            }
        });
    }

    $(document).ready(function() {
        var id = $('#user_id').html();
       // alert(id);
        var table = $('#raw-datatable2').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": JS_BASE_URL+"/staff/schedule/"+id,
                "type": "POST",
                "data": function(d){
                    d.id = document.getElementById("select_forall_staff").value

                }
            }

        });

        $( ".select_forall_staff" ).change(function(){
                      table.ajax.reload();
        });


        $('.select_forall_staff').select2();
        $('.leave_type').select2();
    });

</script>
