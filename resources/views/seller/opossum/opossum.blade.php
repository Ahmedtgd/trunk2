<?php
use App\Classes;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>
@extends("common.default")
@section('content')
@if (Session::has('error')) 
	<div class="alert alert-danger">
  <strong>Danger!</strong> Please Select a Merchant.
</div>
@endif
<script type="text/javascript">


	var quantitiy=0;
	function plus(index) {

        // Stop acting like a button
        
        // Get the field name
        var quantity = $('#'+index).val();
        
        // If is not undefined
        $('#'+index).attr("value", ++quantity);
        $('#i'+index).attr("value", quantity);
        var total = $('.total').html();
        var price = $('#price'+index).html();

        total = parseInt(total)+parseInt(price);
        $('.total').html(total);
        finalPrice = price*quantity;

        $('#pricetotal'+index).html(++finalPrice);

            // Increment

        }

        function minus(index) {
        // Stop acting like a button

        // Get the field name
        var quantity = $('#'+index).val();
        
        // If is not undefined

            // Increment
            if(quantity>1){

            	$('#'+index).attr("value", --quantity);
            	$('#i'+index).attr("value", quantity);
            	var total = $('.total').html();
            	var price = $('#price'+index).html();
            	total = parseInt(total)-parseInt(price);
            	$('.total').html(total);
            	finalPrice = price*quantity;
            	$('#pricetotal'+index).html(++finalPrice);
            }
        }


    </script>
    <style>
    .float-right{
    	float: right;
    }
    .loader {
    	border: 16px solid #f3f3f3;
    	border-radius: 50%;
    	border-top: 16px solid blue;
    	border-bottom: 16px solid blue;
    	width: 120px;
    	position: absolute;
    	margin-left: 40%;
    	margin-top: 100px;
    	height: 120px;
    	-webkit-animation: spin 2s linear infinite;
    	animation: spin 2s linear infinite;
    }
    .blur-filter {
    	-webkit-filter: blur(2px);
    	-moz-filter: blur(2px);
    	-o-filter: blur(2px);
    	-ms-filter: blur(2px);
    	filter: blur(2px);
    }
    
    .hide{
    	display: none;
    }

    @-webkit-keyframes spin {
    	0% { -webkit-transform: rotate(0deg); }
    	100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
    	0% { transform: rotate(0deg); }
    	100% { transform: rotate(360deg); }
    }
</style>
@include("common.sellermenu")
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#merchant").select2();

	});
	$(document).ready(function() {
		$("#merchantproduct").select2();

	});
</script>
<div class="container blur">
	<form method="POST" action="{{route('checkoutopossum')}}">
	<div class="table-responsive" style="margin-bottom: 28px;">
		<h2>Opossum</h2>
			<!-- {{-- Tab-bed Nav --}}
					<div class="panel with-nav-tabs panel-default hidden-xs">
						 <div class="panel-heading">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#location" data-toggle="tab">Locations</a></li>
								<li ><a href="#consignment" data-toggle="tab">
									A/C No.
								</a></li>
							</ul>
						</div>
					</div>
					{{--ENDS  --}}
				-->
			</div>

			{{-- TABS --}}

			<div class="container">
				<div style="width:300px;float: left; margin-bottom: 10px;">
					<h3>Merchant</h3> 
					<select class="form-control" name="merchant" id="merchant" style="width:300px;">
						<option value="0">Please Select Merchant</option>
						@foreach($merchant as $merchant)
						<option value="{{$merchant->id}}">{{$merchant->first_name}}</option>
						@endforeach
					</select>
				</div>
				<div class="start-loader-main "></div>
				<!-- Trigger the modal with a button -->
				<button style="float: right;margin: 10px;" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Add Product</button>

				<!-- Modal -->
				<div class="modal fade" id="myModal" role="dialog">
					<div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">

							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h2>Select Product</h2>
							</div>
							<div class="modal-body">
								<div class="start-loader "></div>
								<div style="width:300px;">
									<select class="form-control" id="merchantproduct" style="width:300px;">
										@foreach($html as $hh)
										<option value="{{$hh->id}}">{{$hh->name}}</option>
										@endforeach
									</select>
								</div>
								<div class="opossum-modal-body">
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" id="addintable" class="btn btn-primary" >Add product</button>
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>

					</div>
				</div>

			</div>
			<div class="tab-content">
				<div id="mainopossumtable" >
					<table class="table table-bordered" ">
						<thead style="background: #6666ff; color: white;">
							<tr>
								<td class='text-center no-sort bsmall'>No</td>
								<td class='text-center bmedium'>Name</td>
								<td class='text-center bmedium'>Descriprion</td>
								<td class='text-center bmedium'>Price</td>
								<td class='text-center bmedium'>Total</td>
								<td style="width: 17%;" class='text-center bmedium'>Quantity</td>
								<td class='text-center bmedium'>Action</td>
							</tr>
						</thead>
						<tbody>
							<?php $index = 0;?>
							@foreach($products as $product)
							<tr>
								<td class='text-center bmedium'>{{++$index}}</td>
								<td class='text-center bmedium'>{{$product->name}}</td>
								<td class='text-center bmedium'>{{$product->description}}</td>
								<td id="price{{$index}}" class='text-center bmedium'>{{$product->retail_price}}</td>

								<td id="pricetotal{{$index}}" class='text-center bmedium'>{{$product->retail_price}}</td>
								<td>  
									<div class="col-lg-10">
										<div class="input-group">
											<span class="input-group-btn">
												<button onclick="minus({{$index}})" type="button" class="quantity-left-minus btn btn-danger btn-number"  data-type="minus" data-field="">
													<span class="glyphicon glyphicon-minus"></span>
												</button>
											</span>
											<input disabled="true"  type="text" id="{{$index}}" name="quantity{{$product->id}}" class="form-control input-number" value="1" min="1" max="100">
											<input  type="hidden" id="i{{$index}}" name="quantity{{$product->id}}" class="form-control input-number" value="1" min="1" max="100">
											<span class="input-group-btn">
												<button onclick="plus({{$index}})" type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-field="">
													<span class="glyphicon glyphicon-plus"></span>
												</button>
											</span>
										</div>
									</div>
								</td>
								<td class='text-center bmedium'><button type="button" onclick="removefromsession({{$product->id}})" value="{{$product->id}}" class="btn removefromsession btn-danger">Del</button></td>
							</tr>

							
							@endforeach
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td><h3>Grand Total</h3></td>
							<h3><td class="h4"><span class="total">{{$total}}</span></td></h3>
						</tbody>
					</table>
					<button type="Submit" class="btn float-right btn-lg btn-success">Submit</button>
				</div>
				<?php $count = 1; ?>
		<!-- <div id="consignment" class="tab-pane fade">
		<h3>opossum</h3>
		<p>Content goes here</p>
	</div> -->
	</form>
</div>


</div>
<div class="modal fade" id="consignment_pop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<style>
			.seller_con_table_css{
				width:100%;
			}
			.seller_con_table_css > tbody > tr > td {
				padding: 0px 21px;
				font-weight: 555;
				font-family: sans-serif;
			}
			.hedd_seller{
				padding: 10px 0px;
				font-weight: 555;
				font-family: sans-serif;
			}
			#stock_tool_list > tr {
				font-weight: 555;
				font-family: sans-serif;
			}
		</style>
		<div class="modal-body">
			<div class="col-sm-10 col-md-offset-2">
				<table class="seller_con_table_css">
					<tr>
						<td>Total Report</td>
						<td id="totalreport"></td>
						<td id="location"><span style="padding-left: 0px;">Name</span></td>
					</tr>
					<tr>
						<td>Total Stock In </td>
						<td id="totaltrackoutin"></td>
						<td id="totaluser">Total User<span style="padding-left: 18px;">Name</span></td>
					</tr>
					<tr>
						<td>Total Stock Out</td>
						<td id="totaltrackoutout"></td>
						<td id="lost">Lost Case<span style="padding-left: 18px;">Name</span></td>
					</tr>
				</table>
			</div>
			<div class="clearfix"></div>
			<h4 class="hedd_seller">Tracking And Stock Take Report By Location </h4>
			<table class="table table-bordered" id="consignment-open-channel">
				<thead style="background: #6666ff; color: white;font-family: sans-serif;">
					<tr class="tr_class_css">
						<th class='text-center'>No</th>
						<th class='text-center'>Report No</th>
						<th class='text-center'>Type</th>
						<th class='text-center'>Date</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
		<div class="modal-footer">
		</div>
	</div>
</div>
</div>

<script>	
	$('#addintable').click(function(){
		var id = $('#merchantproduct').val();
		$.ajax({
			type: "GET",
			url: 'addopossumproductsession/'+id,
			data:{},
			success: function( data ) {
				$('#myModal').modal('toggle');
				$('#mainopossumtable').html(data);

			}
		});
	});
	function removefromsession(id) {
		
		
		$('.blur').addClass("blur-filter");
		$('.start-loader-main').addClass("loader");
		
		$.ajax({
			type: "GET",
			url: 'removefromsession/'+id,
			data:{},
			success: function( data ) {
				$('#mainopossumtable').html(data);
				$('.blur').removeClass("blur-filter");
				$('.start-loader-main').removeClass("loader");
				
			}
		});
	}
	
	$('#merchantproduct').change(function(){
		$('.start-loader').addClass("loader");
		$('.blur').addClass("blur-filter");
		var id = $('#merchantproduct').val();
		$.ajax({
			type: "GET",
			url: 'opossumproduct/'+id,
			data:{},
			success: function( data ) {
				$('.start-loader').removeClass("loader");
				$('.opossum-modal-body').html(data);
				$('.blur').removeClass("blur-filter");
			}
		});
	});
	var types = {treport:"Tracking Report", tin:"Stock In", tout:"Stock Out", tou:"Stock Out", smemo:"Sales Memo", stocktake:"Stock Take"};
	
	$(document).ready(function(){
		var c_table = $('#consignment-open-channel').DataTable({
			'autoWidth':false,
			"columnDefs": [
			{"targets": 'no-sort', "orderable": false, },
			{"targets": "medium", "width": "80px" },
			{"targets": "bmedium", "width": "10px" },
			{"targets": "large",  "width": "120px" },
			{"targets": "approv", "width": "180px"},
			{"targets": "blarge", "width": "200px"},
			{"targets": "bsmall",  "width": "20px"},
			{"targets": "clarge", "width": "250px"},
			{"targets": "xlarge", "width": "300px" }
			]
		});				
		
		var table = $('#supplier-open-channel').DataTable({
			'scrollX':true,
			'bScrollCollapse': true,
			'scrollX':true,
			'autoWidth':false,
			"columnDefs": [
			{"targets": 'no-sort', "orderable": false, },
			{"targets": "medium", "width": "80px" },
			{"targets": "bmedium", "width": "10px" },
			{"targets": "large",  "width": "120px" },
			{"targets": "approv", "width": "180px"},
			{"targets": "blarge", "width": "200px"},
			{"targets": "bsmall",  "width": "20px"},
			{"targets": "clarge", "width": "250px"},
			{"targets": "xlarge", "width": "300px" }
			]
		});
		$(".dataTables_empty").attr("colspan","100%");

			/*$(document).delegate( '.getstockid', "click",function (event) {
				var id = $(this).attr("rel");
				$.ajax({
					url: JS_BASE_URL + '/seller/consignmentvalue',
					cache: false,
					method: 'get',
					dataType: 'json',
					data: {id: id},
					success: function(result) {
						//console.log(result.lists);
						c_table
						.clear()
						.draw();
						$('#totalreport').text(result.treports);
						$('#location').find('span').text(result.locations);
						$('#totaltrackoutin').text(result.tin);
						$('#totaluser').find('span').text(result.tusers);
						$('#totaltrackoutout').text(result.tout);
						$('#totalsalesmemo').text(result.treport);
						$('#lost').find('span').text(result.lcase);
						$("#consignment_pop").modal('show');
						
						var type = "";
						for(var ii = 0; ii < result.data.length; ii++){
							if(typeof(types[result.data[ii].ttype]) == undefined || types[result.data[ii].ttype] == null){
								type = "";
							} else {
								type = types[result.data[ii].ttype];
							}
							console.log(type + "TYPE");
							var rowNode = c_table.row.add(["<p align='center'>" + (ii+1) + "</p>","<p align='center'>" + result.data[ii].no + "</p>","<p align='center'>" + type + "</p>","<p align='center'>" + result.data[ii].date_created + "</p>"]).draw();
							$( rowNode )
							.css( 'text-align', 'center');
						}
						$(".no-footer").css("width","100%");
					}
				});	
			});	*/		
			
		});

	</script>
	@yield("left_sidebar_scripts")
	@stop
