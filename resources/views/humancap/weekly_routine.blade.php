

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
            .confirm{
                color: white;
                background-color: #00CCFF;
                width: 70px;
                height: 70px;
                text-align: center;
                float: left;
                font-size: 13px;
                cursor: pointer;
                margin-right: 5px;
                margin-bottom: 5px;
                border-radius: 5px;
            }
            #raw-datatable_weekly_wrapper{
                width: 40%;
            }

        </style>

        <table >
            <tr style="justify-content: right">
                <td style="width: 67.5%" >

                </td>
                <td>
                    <span style="background-color: #0d0; color: #fff;" id="weeksModal"  type="text" class="sellerbutton" >Weeks</span></td>
                <td>
                    <span class="sellerbutton" id="analyticsbutton" style="background-color: #0CC0E8; color:white; ">Confirm</span>

                </td>
            </tr>
        </table>

        <table style="width:100%; text-align: center;"  id="raw-datatable_weekly">

            <thead style="color:white">
                <tr>
                    <td  style="background-color: #66FF66; color:white;"><b>Weekly Routine</b></td>
                    <td  style="background-color:#66FF66;color:white"><b>Working</b></td>
                 </tr>
            </thead>
            <tbody>
            <?php $count = 0 ?>
            @foreach($days as $day)
                <tr>
                    <td><?php  $day_of_week = strtotime($day);
                        echo date('D', $day_of_week);
                        $day_of_week = strtotime($day);
                        ?></td>
                    <td onclick="manager_working()">@if($works[$count]){{$works[$count]->working}} @else 0 @endif</td>
                </tr>
                <p style="display: none;" >{{$count++}}</p>
                @endforeach
            </tbody>
        </table>
   </div>


    <script>
        //$('#raw-datatable_weekly').DataTable();
        $('#raw-datatable_weekly').dataTable( {
            "ordering": false
        } );
     </script>

