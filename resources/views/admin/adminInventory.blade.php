<?php
use App\Classes;
define('MAX_COLUMN_TEXT', 15);
use App\Http\Controllers\IdController;
?>
@extends("common.default")

@section("content")
<div class="container" style="margin-top:30px;">
		@include('admin/panelHeading')
            <div class="equal_to_sidebar_mrgn">
               <h2>Administration Inventory Report & Analysis</h2>
                <br>
                <table id="test" class="table table-bordered" cellspacing="0" width="100%">
                <thead style="background-color: #AAA; color: white">
                    <tr>
                        <th colspan="5" style="background-color: #AAA; color: white; text-align: center;">&nbsp;</th>
                        <th colspan="2" style="background-color: #AAA; color: white;">Accumulated Sales</th>
                        <th colspan="2" style="background-color: #ff6666; color: white;">O-Shop Availability</th>
                        <th colspan="2" style="background-color: goldenrod; color: white;">Album Availability</th>
                        <th colspan="2" style="background-color: #4E2E28; color: white;">Station</th>
                    </tr>
                    <tr>
                        <th class="no-sort" style="background-color: #AAA; color: white; text-align: center;">No</th>
                        <th class="large" style="background-color: #AAA; color: white; text-align: center;">Product ID</th>
                        <th class="large" style="background-color: #AAA; color: white; text-align: center;">Name</th>
                        <th class="medium" style="background-color: #AAA; color: white; text-align: center;">Since</th>
                        <th class="medium" style="background-color: #AAA; color: white; text-align: center;">Type</th>
                        <th class="medium" style="background-color: #AAA; color: white; text-align: center;">Qty</th>
                        <th class="medium" style="background-color: #AAA; color: white; text-align: center;">$</th>
                        <th class="medium" style="background-color: #ff6666; color: white;text-align: center;">Retail</th>
                        <th class="medium" style="background-color: #ff6666; color: white;text-align: center;">B2B</th>
                        <th class="medium" style="background-color: goldenrod; color: white;text-align: center;">Retail</th>
                        <th class="medium" style="background-color: goldenrod; color: white;text-align: center;">B2B</th>
                        <th class="medium" style="background-color: #4E2E28; color: white;text-align: center;">Low</th>
                        <th class="medium" style="background-color: #4E2E28; color: white;text-align: center;">High</th>
                    </tr>
                </thead>
                <tbody>
                  <?php $i = 1;?>
                     @foreach($inventoryResults as $inventory)
                     <tr>
                   <td class="text-center">{{$i++}}</td>
				   <?php
						$product_id =IdController::nP($inventory->id);
					?>
                   <td class="text-center"><a href="{{route('productconsumer', ['id' => $inventory->parent_id])}}" target="_blank" rel="{{ $inventory->id }}">
					{{$product_id}}</a>
                   </td>
                   <td class="text-center">
						<?php
 							/* Processed note */
							$pfullnote = null;
							$pnote = null;

							if ($inventory->name) {
								$elipsis = "...";
								$pfullnote = $inventory->name;
								$pnote = substr($inventory->name,0, MAX_COLUMN_TEXT);

								if (strlen($pfullnote) > MAX_COLUMN_TEXT)
									$pnote = $pnote . $elipsis;
							}
						?> 
					<span title='{{$pfullnote}}'>{{$pnote}}</span>
                   </td>
                   <td class="text-center">{{(!empty($inventory->created_at)) ? date('dMy', strtotime($inventory->created_at)) : null}}</td>
				   <td class="text-center">{{(!empty($inventory->type)) ? $inventory->type : null}}</td>
                   <td class="text-center">{{(!empty($inventory->qty)) ? $inventory->qty : 0}}</td>
                   <td class="text-center">{{$currencyCode}} {{(!empty($inventory->total)) ? number_format($inventory->total/100,2) : 0.00}}</td>
                   <td class="text-center">{{(!empty($inventory->retail_oshop)) ? $inventory->retail_oshop : 0}}</td>
                   <td class="text-center">{{(!empty($inventory->b2b_oshop)) ? $inventory->b2b_oshop : 0}}</td>
                   <td class="text-center">{{(!empty($inventory->album_available)) ? $inventory->album_available : 0}}</td>
                   <td class="text-center">{{(!empty($inventory->b2b_available)) ? $inventory->b2b_available : 0}}</td>
				   <?php
						$high_stock = DB::select(DB::raw(
							'SELECT COUNT(sproduct.id) as count FROM sproduct WHERE sproduct.available >= (sproduct.stock*0.3) AND sproduct.product_id = ' . $inventory->id
						));

						$low_stock = DB::select(DB::raw(
							'SELECT COUNT(sproduct.id) as count FROM sproduct WHERE sproduct.available < (sproduct.stock*0.3) AND sproduct.product_id = ' . $inventory->id
						));
						//dd($high_stock);
				   ?>
                  <td class="text-center"><a href="javascript:void(0)" rel="{{ $inventory->id }}" nrel="{{IdController::nP($inventory->id)}}" class="inventory_low">{{(!empty($low_stock[0]->count)) ? $low_stock[0]->count : 0}}</a></td>
				   <td class="text-center"><a href="javascript:void(0)" rel="{{ $inventory->id }}" nrel="{{IdController::nP($inventory->id)}}" class="inventory_high">{{(!empty($high_stock[0]->count)) ? $high_stock[0]->count : 0}}</a></td>
                 </tr>
             @endforeach
				</tbody>
            </table>

            </div>
    </div>
 <!-- Modal -->
<div class="modal fade" id="myModalInventory" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Product Inventory</h4>
            </div>
            <div class="modal-body">
                <h3 id="modal-Tittle"></h3>
                <div class="table-responsive">
                    <table id="myTable" class="table table-bordered myTable"></table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>
    <script type="text/javascript">

  $(document).ready(function () {
 	function pad (str, max) {
	  str = str.toString();
	  return str.length < max ? pad("0" + str, max) : str;
	}

        var oTable = $('#test').dataTable({
        "order": [],
        "scrollX": true,
        "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false,
			},{ "targets": "large", "width": "120px" },{ "targets": "xlarge", "width": "300px" },{ "targets": "medium", "width": "90px" }],
        "info":           true,
        "paging":         true,
        "iDisplayLength": 10
		});

	var table_modal;
	$(document).delegate( '.inventory_qty', "click",function (event) {
	//$(".inventory_qty").click(function () {

		$('#modal-Tittle').html("");

		if(table_modal){
			table_modal.destroy();
			$('#myTable').empty();
		}

		_this = $(this);

		var product_id= _this.attr('rel');


		var url = '/admin/analysis/inventory/'+product_id;

		var urlbase = $('meta[name="base_url"]').attr('content');

		$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			success: function (data) {

				$('#modal-Tittle').append("Product ID: ["+pad(product_id,10) + "]");
				//console.log(data);
				$('#myTable').append('<thead style="background-color: #AAA; color: #fff;"><th>No</th><th>Station/Merchant ID</th><th>Name</th><th>Qty Left</th>');
				$('#myTable').append('<tbody>');
				for (i=0; i < data.length; i++) {
					var obj = data[i];
					var type = obj.type;
					var route = "";
					if(type=="station"){
						route = urlbase + "/admin/popup/station/" + obj.id;
					} else {
						route = urlbase + "/admin/popup/merchant/" + obj.id;
					}
					$('#myTable').append('<tr><td>'+(i+1)+'</td><td><a target="_blank" href="'+route+'">['+pad(obj.id,10)+']</a></td><td>'+obj.name+'</td><td>'+ obj.qty +'</td></tr>');
				}
				$('#myTable').append('</tbody>');

				table_modal = $('#myTable').DataTable({
					'autoWidth':false,
					 "order": [],
					 "iDisplayLength": 10,
					 "columns": [
						{ "width": "20px", "orderable": false },
						{ "width": "85px" },
						{ "width": "85px" },
						{ "width": "85px" },
					  ]
				});

				$("#myModalInventory").modal("show");
			},
			error: function (error) {
				console.log(error);
			}
		});
	});
	$(document).delegate( '.inventory_high', "click",function (event) {
//	$(".inventory_high").click(function () {

		$('#modal-Tittle').html("");

		if(table_modal){
			table_modal.destroy();
			$('#myTable').empty();
		}

		_this = $(this);

		var product_id= _this.attr('rel');
		var nproduct_id= _this.attr('nrel');


		var url = '/admin/analysis/inventory_high/'+product_id;

		var urlbase = $('meta[name="base_url"]').attr('content');

		$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			success: function (data) {
				$('#modal-Tittle').append("High Station Product ID: "+ nproduct_id);
				//console.log(data);
				$('#myTable').append('<thead style="background-color: #4E2E28; color: #fff;"><th>No</th><th>Station ID</th><th>Name</th><th>Qty Left</th>');
				$('#myTable').append('<tbody>');
				for (i=0; i < data.length; i++) {
					var obj = data[i];
					var type = obj.type;
					var route = "";
					route = urlbase + "/admin/popup/station/" + obj.id;
					$('#myTable').append('<tr><td class="text-center">'+(i+1)+'</td><td class="text-center"><a target="_blank" href="'+route+'">['+pad(obj.id,10)+']</a></td><td class="text-center">'+obj.name+'</td><td class="text-center">'+ obj.qty +'</td></tr>');
				}
				$('#myTable').append('</tbody>');

				table_modal = $('#myTable').DataTable({
					'autoWidth':false,
					 "order": [],
					 "iDisplayLength": 10,
					 "columns": [
						{ "width": "10%", "orderable": false },
						{ "width": "30%" },
						{ "width": "45%" },
						{ "width": "15%" }
					  ]
				});

				$("#myModalInventory").modal("show");
			},
			error: function (error) {
				console.log(error);
			}
		});
	});

	$(document).delegate( '.inventory_low', "click",function (event) {
	//$(".inventory_low").click(function () {

		$('#modal-Tittle').html("");

		if(table_modal){
			table_modal.destroy();
			$('#myTable').empty();
		}

		_this = $(this);

		var product_id= _this.attr('rel');
		var nproduct_id= _this.attr('nrel');


		var url = '/admin/analysis/inventory_low/'+product_id;

		var urlbase = $('meta[name="base_url"]').attr('content');

		$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			success: function (data) {
				$('#modal-Tittle').append("Low Station Product ID: "+ nproduct_id);
				//console.log(data);
				$('#myTable').append('<thead style="background-color: #4E2E28; color: #fff;"><th>No</th><th>Station ID</th><th>Name</th><th>Qty Left</th>');
				$('#myTable').append('<tbody>');
				for (i=0; i < data.length; i++) {
					var obj = data[i];
					var type = obj.type;
					var route = "";
					route = urlbase + "/admin/popup/station/" + obj.id;
					$('#myTable').append('<tr><td class="text-center">'+(i+1)+'</td><td class="text-center"><a target="_blank" href="'+route+'">['+pad(obj.id,10)+']</a></td><td class="text-center">'+obj.name+'</td><td class="text-center">'+ obj.qty +'</td></tr>');
				}
				$('#myTable').append('</tbody>');

				table_modal = $('#myTable').DataTable({
					'autoWidth':false,
					 "order": [],
					 "iDisplayLength": 10,
					 "columns": [
						{ "width": "10%", "orderable": false },
						{ "width": "30%" },
						{ "width": "45%" },
						{ "width": "15%" },
					  ]
				});

				$("#myModalInventory").modal("show");
			},
			error: function (error) {
				console.log(error);
			}
		});
	});

 });
        </script>
@stop
