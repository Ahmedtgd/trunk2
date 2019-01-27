
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
    #raw-datatable_manager_working_wrapper{
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


        <table style="width:100%; text-align: center;"  id="raw-datatable_manager_working">
            <thead style="color:white">
                <tr>
                    <td width="10%" style="background-color: #6666FF; color:white;"><b>No</b></td>
                    <td width="30%" style="background-color: #6666FF; color:white;"><b>Name</b></td>
                    <td width="15%" width="30%" style="background-color:#66FF66;color:white"><b>Position</b></td>
                    <td width="15%" width="30%" style="background-color:#31859C;color:white">Shift</td>
                 </tr>
            </thead>
            <p  id="date_work" > </p>
            <p style="display: none;" id="counter" > </p>
            <tbody>
           <p style="display: none;" ><?php $count = 1; ?></p>

            @foreach($staffs as $staff)
            <tr>
                <td>{{$count}}</td>

                <td>{{$staff->name}} </td>
                <td>{{$staff->rname}}  </td>
                <td>
                    <table class="working_tab" width="100%">
                        <tr id="full" class="not" >
                            <td   style="background-color: #00FF00;"><a>F</a></td>
                            <td  style="background-color:#99CC00;"><a>1</a></td>
                            <td  style="background-color: #33CCCC"><a>2</a></td>
                            <td  style="background-color: #cc7a21"><a>3</a></td>

                        </tr>
                    </table>
                </td>
             </tr>
            <p style="display: none;" > {{$count++}}</p>
            <p id="user_id" style="display: none;" > {{$staff->uid}}</p>
                @endforeach

            </tbody>
        </table>
   </div>

<script>
    $('#raw-datatable_manager_working').DataTable();


    $( "tr #full td" ).click(function() {
        var $shiftId = ($(this).text());
        var $userId = $('#user_id').text();
        var $date = $('#date_work').text();
        save_shift($shiftId, $userId, $date);
        add_to_working()
    });
    function add_to_working() {
        $
            var $counter = $('#counter').text();
            var working = $('#working'+$counter).text();
        dd(working);
//        if($('.working_tab tr' ).attr("class") == "not"){
//            alert("Here");
            var newworking = (parseInt(working) + 1);
            $('#working'+$counter).html(newworking);
//            $('#full').toggleClass("Clicked");
//        }

    }

    function save_shift($sid, $uid, $date)
    {
        $.ajax({
            type: "POST",
            url: JS_BASE_URL+"/manager/daily_schedule",
            data:{"user_id":$uid,"shift_id" : $sid, "date":$date},
            success: function( data ) {
                console.log(data)
            }
        });
    }
</script>