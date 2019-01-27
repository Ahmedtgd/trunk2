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
								<div class=" col-sm-12">
									<div class="row">
				                		<div class="text-left col-sm-6">
											<h3><b>Registered Supplier</b></h3>
										</div>
									</div>
									<table class="table table-bordered"
										id="customer-table" width="100%">
										<thead>
											<tr style="background-color: red; color: #fff">
												<th class="text-center bsmall">No.</th>
												<th class="text-center">Merchant ID</th>
												<th class="text-center">Reg No</th>
												<th class="text-center">Company Name</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="text-center">1</td>
												<td class="text-center">11</td>
												<td class="text-center">xcfsdf45</td>
												<td class="text-center">test cmpy</td>
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
				// { "width": "80px" },
				// { "width": "130px" },
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
