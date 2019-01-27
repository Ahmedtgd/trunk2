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
{{--
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
--}}
<script type="text/javascript">
	$(document).ready(function() {
		$("#supplier").select2();
		$("#supplierAddButton").click(function(){
			if($("#supplier").val() > 0) {
				$("#selectedSupplier").val($("#supplier").val());
				$(".selectedSupplier label").html($("#supplier :selected").text());
			}else {
				alert("Select a Supplier");
			}			
		});
	});
</script>
<style>
	.storebutton{
		background-color: #FF3333 !important;
	}
	.suppliersearchtable td{ padding-right:5px; vertical-align: middle;}
	.suppliersearchtable .newtd{ padding-right:5px;}
	

</style>
<section class="">
  <div class="container">
	<div class="row">
	<div class="col-sm-12">  
	{{-- Tabbed Nav --}}
	<!-- <h2>Data Management</h2> -->
	<!-- <div class="panel with-nav-tabs panel-default ">
		<div class="panel-heading">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#customers" data-toggle="tab">Customer</a></li>
				<li><a href="#employees" data-toggle="tab">Staff</a></li>
				<li><a href="#merchantOpenchannel" id="merchantOpenchannellink" data-toggle="tab">Supplier</a></li>
				<li><a href="#stationOpenchannel" id="stationOpenchannellink" data-toggle="tab">Dealer</a></li>
				
			</ul>
		</div>
	</div> -->
	{{--ENDS  --}}
	<div id="dashboard" class="row panel-body " style="margin-top:20px">
	<form id="inventorycost" method="post" action="/inventorycost/save_inventory_cost">
		<div class="tab-content top-margin" >
			<!-- CUSTOMER LIST -->
			<div class="tab-pane fade in active">
				<div class="row">
					<div class="col-sm-12 col-lg-6">
						<div class="row">
							<div class="text-left">
								<table class="suppliersearchtable">
									<tr>
										<td><label>Supplier Search:</label></td>
										<td>
											<select class="form-control" name="supplier" id="supplier" style="width:300px;">
												<option value="0">Please Select Supplier</option>
												@foreach($suppliers as $supplier)
												<option value="{{$supplier->id}}">{{$supplier->first_name}} {{$supplier->last_name}}</option>
												@endforeach
											</select>
										</td>
										<td><button type="button" id="supplierAddButton" style="background-color: #77ff33; color:#fff; vertical-align:top;border:1px solid #77ff33" class="form-group">Add </button></td>
									</tr>
									<tr>
										<td><label>Supplier:</label></td>
										<td class="selectedSupplier"><label></label>
											<input class="form-group" type="hidden" name="selectedSupplier" id="selectedSupplier">
										</td>
										<td><button type="button" style="background-color: #993366; color:#fff;vertical-align:top;border:1px solid #993366" class="form-group">Details </button></td>
									</tr>
									<tr>
										<td><label>Document Date:</label></td>
										<td><input class="form-group" type="text" name="search" style="height: 34px;"></td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td><label>Document No.:</label></td>
										<td><input class="form-group" type="text" name="search" style="height: 34px;"></td>
										<td>&nbsp;</td>
									</tr>
								</table>
							</div>
			            </div>
		            </div>
		            <div class="col-sm-12 col-lg-6">
		            </div>
				</div>
				
				<div class="row">
					<div class="col-sm-12 col-lg-6"></div>
					<div class="col-sm-12 col-lg-6">
		            	<a href="{{URL::to('/')}}/inventorycost/add_product" class="sellerab pull-right">
							<div class="sellerbutton" style="background-color: #888844;">
								+  Product
							</div>
						</a>
						<a href="{{URL::to('/')}}/inventorycost/new_supplier" class="sellerab pull-right">
							<div class="sellerbutton" style="background-color: #009999;padding-top: 19px;">
								New <br>Supplier
							</div>
						</a>

						<a href="{{URL::to('/')}}/inventorycost/registered_supplier" class="sellerab pull-right">
							<div class="sellerbutton" style="background-color: #862d86;padding-top: 19px;">
								Registered Supplier
							</div>
						</a>
		            </div>
				</div>
				
				<?php $e=1;?>
				
				<div class="row" style="padding-top:50px">
					<div class="row col-sm-12">
                		<div class="text-left col-sm-6">
							<h3><b>Inventory Cost </b></h3>
						</div>
						<div class="text-right col-sm-6">
							<h3 class="modal-title" id="myModalLabel" style="font-size:20px"><b>Total Cost  MYR 2,000</b></h3>
						</div>
					</div>
					<div class=" col-sm-12">
						<table class="table table-bordered"
							id="customer-table" width="100%">
							<thead>
							
							<tr style="background-color: red; color: #fff">
								<th class="text-center bsmall">No.</th>
								
								<th class="text-center">Product ID</th>
								<th class="text-center">Product Name</th>
								<th class="text-center">Qty</th>
								<th class="text-center">Cost</th>
								<th class="text-center">Average</th>
							</tr>
							</thead>
							<tbody>							
							<?php $id = 1; ?>
								@foreach($products as $product)
									<tr>
										<td class="text-center">{{$e}}</td>
										<td class="text-center"> {{ $product->product_id }}</td>
										<td class="text-center" >				
											{{ $product->name }}
										</td>
										<td class="text-center">
											<span title='qty' class="customer_name" id="customer_name{{$id}}" rel="{{$id}}">&nbsp;&nbsp;&nbsp;&nbsp;</span>	
											<span id="sinputcustomer_name{{$id}}" style="display: none;">
												<input type="text" value="" rel="{{$id}}" class="customer_name_input" id="inputcustomer_name{{$id}}" />
											</span>
										</td>
										<td class="text-center"> 
											<span title='cost' class="cost" id="cost{{$id}}" rel="{{$id}}">&nbsp;&nbsp;&nbsp;&nbsp;</span>	
											<span id="sinputcost{{$id}}" style="display: none;">
												<input type="text" value="" rel="{{$id}}" class="cost_input" id="inputcost{{$id}}" />
											</span>
										</td>
										<td class="text-center"></td>
									</tr>
								<?php $e++;?>
							@endforeach
							</tbody>
						</table>
						<input type="hidden" value="{{$e}}" id="nume_c" /> 
					</div>
					<div class="col-lg-12" style="padding-top:20px"> 
						<div class="col-lg-11"></div>
						<div class="text-left col-lg-1">
							<!-- <a href="{{URL::to('/')}}/seller/inventorycost/save_inventory_cost" class=" sellerab"> -->
							<!-- <div class="sellerbutton" style="background-color: #5cd6d6;"> -->
								<input type="submit" value="Confirm" class="sellerbutton" style="background-color: #5cd6d6;">
							<!-- </div> -->
							<!-- </a> -->
						</div>
					</div>
				</div> 				
			</div>
		</div>
	</form>
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
	
    $(document).ready(function()
    {
		$('.dataTables_empty').attr('colspan', '100%')
		
		$(document).delegate( '.customer_name', "click",function (event) {
			var id = $(this).attr('rel');
			$(this).hide();
			$("#sinputcustomer_name" + id).show();
		});

		$(document).delegate( '.cost', "click",function (event) {
			var id = $(this).attr('rel');
			$(this).hide();
			$("#sinputcost" + id).show();
		});	
		
			$(document).delegate( '.customer_name_input', "blur",function (event) {
			var id = $(this).attr('rel');
			var value = $(this).val();
			$.ajax({
				type: "POST",
				data: {data: value},
				url: "/seller/member/name/" + id,
				dataType: 'json',
				success: function (data) {
					$("#sinputcustomer_name" + id).hide();
					$("#customer_name" + id).html(value);
					$("#customer_name" + id).show();
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});			
		});
		$
		$(document).delegate( '.cost_input', "blur",function (event) {
			var id = $(this).attr('rel');
			var value = $(this).val();
			$.ajax({
				type: "POST",
				data: {data: value},
				url: "/seller/member/name/" + id,
				dataType: 'json',
				success: function (data) {
					$("#sinputcost" + id).hide();
					$("#cost" + id).html(value);
					$("#cost" + id).show();
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
				}

			});			
		});	
			
		var cust_table = $('#customer-table').DataTable({
        "order": [],
		 "columns": [
				{ "width": "20px", "orderable": false },
				{ "width": "80px" },
				{ "width": "250px" },
				{ "width": "50px" },
				{ "width": "80px" },
				{ "width": "80px" },
				// { "width": "20px", "orderable": false },
				// { "width": "20px", "orderable": false },
				// { "width": "0px", "visible": false},
			]
		});
    });
</script>
@stop
