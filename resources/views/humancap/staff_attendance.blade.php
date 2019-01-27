<style>
	button.btn.btn-red.btn-mid{
        margin-bottom: 3px;
        font-size: 14px;
        padding: 8px 60px;
        background-color: #f50909b8;
        width: 100%;
        border-radius: 5px;
	}
</style>

<div class="row">
	<div class="col-md-12" style="margin-bottom:10px">
		<div class="col-sm-4" style="margin-bottom:10px">
			<div class="float-left" style="margin-top: 15px;">
	          <h3>Julian Kurosowa</h3>
              <h4>Staff ID : 000324X</h4>
                <!--<button type="button" class="btn" style="font-size: 14px;">Monthly</button>
                <h3>Attendance</h3>-->
	        </div>
	   </div>

        <div class="col-sm-4" style="margin-top: 15px;position: relative;height: 110px;border: 1px solid #3a1515;">
            <p style="height: 100px;margin-top: 85px;bottom:0;text-align: center;">Thumb print</p>
        </div>

       <div class="col-sm-4" style="margin-bottom:10px;">
            <div class="float-right" style="margin-top: 15px;">
                <button type="button" class="btn btn-red btn-mid" style="font-size: 14px;padding: 8px 60px;background-color: #D03A39;">Pay Slip</button>
                <button type="button" class="btn btn-red btn-mid" style="font-size: 14px;padding: 8px 60px;background-color: #0F52E7;">Summary</button>
                <button type="button" class="btn btn-red btn-mid" style="font-size: 14px;padding: 8px 60px;background-color: #0F52E7;">Schedule</button>
                <button type="button" class="btn btn-red btn-mid" style="font-size: 14px;padding: 8px 60px;background-color: #7E7D82;">Entitlement</button>
            </div>
       </div>
    </div>
</div>
    <div class="" style="margin-top:30px;">
        <div class="table-responsive" style="margin-bottom: 28px;">
            <!-- <h2>March 2018 Attendance</h2> -->
			<table id="raw-datatable" class="table table-bordered" style="width:100% !important;">
				<thead>
					<tr>
					    <td class="text-center bg-primarypurple">Date</td>
					    <td class="text-center" style="background-color:#36A44B;color:white">In</td>
                        <td class="text-center" style="background-color:#36A44B;color:white">Status</td>
					    <td class="text-center" style="background-color:#D63137;color:white">Out</td>
                        <td class="text-center" style="background-color:#D63137;color:white">Status</td>
					    <td class="text-center" style="background-color:#EA7F3B;color:white">Overtime(hrs)</td>
					</tr>
				</thead>
				<tbody id="new-terminal">
					<?php $index = 0;?>
					<tr>
                        <td class="text-center" style="vertical-align: middle">03Aug18</td>
                        <td class="text-right" style="vertical-align: middle">09:45:54</td>
                        <td class="text-center" style="vertical-align: middle">Full Day</td>
                        <td class="text-right" style="vertical-align: middle">10:45:54</td>
                        <td class="text-center" style="vertical-align: middle">Full Day</td>
                        <td class="text-right" style="vertical-align: middle">0</td>
                    </tr>
				</tbody>
			</table>
		</div>
    </div>
<script>
  $(document).ready(function() {
		$('#raw-datatable').DataTable();
  });
</script>
