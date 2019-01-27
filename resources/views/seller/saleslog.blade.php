<style>
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
    		background-color: #5a319ce8;
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
    		background-color: #6d9370;
    		border: 0;
    		color: #dadada;
    	}
    </style>
    <link rel="stylesheet" type="text/css" media="all" href="{{asset('css/bootstrap-timepicker.min.css')}}">
   <script type="text/javascript" src="{{asset('js/bootstrap-timepicker.min.js')}}"></script>
<div class="row">
	<div class="col-md-12" style="margin-bottom:10px">
		<!-- <div class="col-sm-6" style="margin-bottom:10px"> -->
			<div class="float-left" style="margin-top: 15px;">
	            <table>
	            <tr>
	                <td>Cash:</td>
	                <td>1000</td>
	            </tr>
	            <tr>
	                <td>Credit Card:</td>
	                <td>5</td>
	            </tr>
	            <tr>
	                <td>Points:</td>
	                <td>10</td>
	            </tr>
	            <tr>
	                <td>Voucher:</td>
	                <td>5</td>
	            </tr>
	            </table>           
	        </div>
	        <div class="float-right" style="margin-top: 15px;">
	            <button id="saleslog"class="btn pad-control black sparoombtn1">
	                > <
	            </button>
	           <button id="saleslog" class="btn pad-control red sparoombtn1">
	               Pay
	           </button>
	        </div>
	</div>
</div>
 <section class="">
        <div class="container table-sections">
			<table id="raw-datatable" class="table table-bordered" style="width:100%">
				<thead>
					<tr>
					    <td class="text-center bg-primarypurple">No</td>
					    <td class="text-center bg-primarypurple">Description</td>
					    <td class="text-center bg-primarypurple">Price</td>
					    <td class="text-center bg-primarypurple">Key No</td>
					    <td class="text-center bg-primarypurple">Massure</td>
					    <td class="text-center bg-primarypurple">Room</td>
					    <td class="text-center bg-primarypurple">Start</td>
					    <td class="text-center bg-primarypurple">End</td>
					    <td class="text-center" style="background-color:green;">Status</td>
					</tr>
				</thead>
				<tbody id="new-terminal">
					<?php $index = 0;?>
					<tr>
                        <td class="text-center" style="vertical-align: middle">{{++$index}}</td>
                        <td class="text-left" style="vertical-align: middle">Pic Body Massage 100</td>
                        <td class="text-right" style="vertical-align: middle">100</td>
                        <td class="text-center" style="vertical-align: middle">
                        	<select>
                        		<option>Key No V</option>
                        		<option>1</option>
                        		<option>2</option>
                        	</select>
                    	</td>
                        <td class="text-center" style="vertical-align: middle;background-color:#0580FE;color: #f6f6f6;">Massure</td>
                        <td class="text-center" style="vertical-align: middle">
                        	<select>
                        		<option>Room V</option>
                        		<option>1</option>
                        		<option>2</option>
                        	</select>
                        </td>
                        <td class="text-center" style="vertical-align: middle"><input class="timepicker form-control" type="text"></td>
                        <td class="text-center timepicker" style="vertical-align: middle"><input class="timepicker form-control" type="text"></td>
                        <td class="text-center" style="vertical-align: middle">Cancelled</td>
                    </tr>
				</tbody>
			</table>
		</div>
	</section>


<script>

  $(document).ready(function() {
		$('#raw-datatable').DataTable();
  });
  $('.timepicker').timepicker();
</script>