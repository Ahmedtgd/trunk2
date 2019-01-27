@extends("common.default")
<?php 
define('MAX_COLUMN_TEXT', 20);
use App\Http\Controllers\IdController;
use App\Models\Currency;

$total_smm_army=0;
$channels = array(
	array('id'=> 1, 'description' => 'Email', 'checked' => true),
	array('id'=> 2, 'description'=> 'SMM Army', 'checked' => true));
	$currency =   $currency = Currency::where('active', 1)->first();
	$currencyCode = $currency->code;
?>
@section("content")
@include('common.sellermenu')
<style>
	.storebutton{
		background-color: #FF3333 !important;
	}
</style>
<section class="">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">  
				<div id="dashboard" class="row panel-body ">
					<div class="tab-content top-margin" >
						<!-- CUSTOMER LIST -->
						<div class="tab-pane fade in active">
							<?php $e=1;?>
							<div class="row" style="padding-top:30px">
								<div class="row col-sm-12">
									<div class="row">
										<div class="col-sm-7"></div>
										<div class="col-sm-5">
				                			<div class="col-sm-12 col-lg-12">
					                			<label class="col-sm-8 col-lg-8">Qty Left </label>
					                			<label class="col-sm-4 col-lg-4 text-right">8 </label>
					                		</div>
					                		<div class="col-sm-12 col-lg-12">
					                			<label class="col-sm-8 col-lg-8">Average Cost (Baased on Qty Purchased)</label>
					                			<label class="col-sm-4 col-lg-4 text-right">0.97</label>
					                		</div>
										</div>
									</div>
									<div class="row">
				                		<div class="text-left col-sm-6">
										<h2>
										<b>Historical Purchase Cost</b>
										</h2>
										</div>
									</div>
								</div>
								<div class=" col-sm-12">
									<table class="table table-bordered"
										id="customer-table" width="100%">
										<thead>
										<tr style="background-color: red; color: #fff">
											<th class="text-center">No.</th>
											<th class="text-center">Date</th>
											<th class="text-center" >Doc Date</th>
											<th class="text-center">Doc No</th>
											<th class="text-center">Cost</th>
											<th class="text-center">Qty Purchased</th>
										</tr>
										</thead>
										<tbody>
											<tr>
												<td class="text-center">{{$e}}</td>
												<td class="text-center"> 
												3/30/2018
												</td>
												<td class="text-center">1/1/2018</td>
												<td class="text-center">2</td>
												<td class="text-center">1.00</td>
												<td class="text-center">10</td>
											</tr>
										<?php $e++;?>
										</tbody>
									</table>
									<input type="hidden" value="{{$e}}" id="nume_c" /> 
								</div>
							</div> 				
						</div>				
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	function firstToUpperCase( str ) {
		return str.substr(0, 1).toUpperCase() + str.substr(1);
	}

	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}
	
	var cust_table = null;
	
    $(document).ready(function(){
		$('.dataTables_empty').attr('colspan', '100%')
		
		var cust_table = $('#customer-table').DataTable({
        "order": [],
		 "columns": [
				{ "width": "20px", "orderable": false },
				{ "width": "130px" },
				{ "width": "130px" },
				{ "width": "80px" },
				{ "width": "80px" },
				{ "width": "130px" },
				// { "width": "80px" },
				// { "width": "80px" },
				// { "width": "20px", "orderable": false },
				// { "width": "20px", "orderable": false },
				// { "width": "0px", "visible": false},
			]
		});
    });
</script>
@stop
