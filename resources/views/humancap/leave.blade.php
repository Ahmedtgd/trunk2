
<style>
    button.btn.btn-red.btn-mid{
        margin-bottom: 3px;
        font-size: 14px;
        padding: 8px 60px;
        background-color: #f50909b8;
        width: 100%;
        border-radius: 15px;
    }
    .select2-container{width: 20% !important;}
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
        #raw-datatable3_wrapper{
            width: 65%;
        }
    </style>
    <table style="width:65%;margin-bottom: 10px;">
        <tr>
            <td width="70%">

                <div><h3>{{$user->first_name}} {{$user->last_name}}</h3></div>
                <div style="font-size: 16px;">Staff ID.:{{$user->id}}</div>
                <div>
                    <select class="select_forall_staff">
                        <option>Today</option>
                        <option>Weekly</option>
                        <option>Yearly</option>
                        <option>Since</option>
                    </select>
                </div>

            </td>

            <td width="30%">
                <div style="float:  left;width: 50%;margin-top: 50px;">
                    <p>
                       Approver<br/>
                        Back up Approver
                    </p>
                </div>
                <div style="text-align: right; float:  right;width: 50%;margin-top: 50px;">
                    <p>
                       Ms Liu Fei<br/>
                        Steffen Maerler
                    </p>
                </div>
            </td>
        </tr>

    </table>

    <table width="100%" id="raw-datatable3" style="text-align: center;">
        <thead style="color:white">
            <tr>
                <td width="10%" style="background-color: #36A7AB; color:white;"><b>Date</b></td>
                <td width="15%"   style="background-color:#36A7AB;color:white"><b>Application</b></td>
                <td width="15%"   style="background-color:#36A7AB;color:white"><b>Approval Date</b></td>
                <td width="10%" style="background-color:#225626;color:white"><b>Status</b></td>
                <td width="30%"   style="background-color:#225626;color:white">Remarks</td>
            </tr>
        </thead>

        <tbody>
        @foreach($leaves as $leave)
                <?php
               if($leave->approval_dt == ("0000-00-00 00:00:00") || ("0000-00-00")){
               $leave->approval_dt = "--";
               }
               ?>
            <tr>

                <td>
                    <?php
                    $leave->created_at= strtotime($leave->created_at);
                    echo date('d-M-y', $leave->created_at);
                    ?></td>
                <td></td>
                <td>{{$leave->approval_dt}}</td>
                <td><?php echo ucfirst($leave->status) ?></td>
                <td>{{$leave->remarks}}</td>
            </tr>

           @endforeach
        </tbody>
    </table>
</div>

<script>
    $('#raw-datatable3').DataTable();
    $(document).ready(function() {
        $('.select_forall_staff').select2();
    });
</script>