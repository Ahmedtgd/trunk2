<div class="row">
	<div class="col-md-12" style="margin-bottom:10px">
		<div class="col-sm-8" style="margin-bottom:10px">
			<div class="float-left" style="margin-top: 15px;">
	          <h4>Julian</h4>
              <h4>325688</h4>
	        </div>
	   </div>
       <div class="col-sm-4" style="margin-bottom:10px;">
            <div class="float-right" style="margin-top: 15px;">
                <table>
                        <tr>
                            <td style="padding-right: 60px;"> Days</td>
                            <td>Hours(MYR)</td>
                        </tr>
                        <tr>
                            <td>Full Day</td>
                            <td>10</td>
                        </tr>
                        <tr>
                            <td>Half Day</td>
                            <td>4</td>
                        </tr>
                        <tr>
                            <td>Overtime</td>
                            <td>3</td>
                        </tr>
                        <tr>
                            <td>Absent</td>
                            <td>3</td>
                        </tr>
                        <tr>
                            <td>MIA</td>
                            <td>0</td>
                        </tr>
                </table> 
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

					    <td class="text-center" style="background-color:#3366FF;color:white";>Date</td>
					    <td class="text-center" style="background-color:#339966;color:white">In</td>
					    <td class="text-center" style="background-color:#FF0000;color:white">Out</td>
					    <td class="text-center" style="background-color:#FF9900;color:white">Overtime(hrs)</td>
					    <td class="text-center" style="background-color:#008000;color:white">Status</td>
					</tr>
				</thead>
				<tbody id="new-terminal">
					<?php $index = 0;?>
					<tr>
                         <td class="text-center" style="vertical-align: middle">02Aug18</td>
                        <td class="text-right" style="vertical-align: middle">08:02:05</td>
                        <td class="text-right" style="vertical-align: middle">09:02:05</td>
                        <td class="text-right" style="vertical-align: middle">0</td>
                        <td class="text-center" style="vertical-align: middle">Full Day</td>
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