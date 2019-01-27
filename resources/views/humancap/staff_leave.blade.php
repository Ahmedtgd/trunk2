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
                <p style="text-align: center;">Days</p>
                <table>
                        <tr>
                            <td style="padding-right: 40px;">Full Day</td>
                            <td>10</td>
                        </tr>
                        <tr>
                            <td>Half Day</td>
                            <td>4</td>
                        </tr>
                        <tr>
                            <td>Declined</td>
                            <td>3</td>
                        </tr>
                        <tr>
                            <td>In Progress</td>
                            <td>3</td>
                        </tr>
                        <tr>
                            <td>Cancelled</td>
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
                        <td class="text-center" style="background-color:#33CCCC;color:white;">Date</td>
					    <td class="text-center" style="background-color:#008000;color:white;">Status</td>
					</tr>
				</thead>
				<tbody id="new-terminal">
					<tr>
                        <td class="text-center" style="vertical-align: middle">03/01/2018</td>
                        <td class="text-center" style="vertical-align: middle">Half Day</td>
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