<?php
use App\Classes;
use App\Http\Controllers\IdController;
?>
@extends("common.default")

@section("content")
@include('common.sellermenu')
<div class="container" style="margin-top:30px;">
    <div class="table-responsive" style="margin-bottom: 28px;">
    <h2>Tracking and Stock Take Report by Location</h2>
            <table class="table table-bordered" cellspacing="0"
				id="merchant-inventory" style="width:100% !important;">
                <thead style="background-color: #db4249; color: white;">
                <tr style="background-color: #000; color: white;">
				<td class="text-center bsmall no-sort"
					style="background-color: #4A452A;">No.</td>
				<td class="text-right"
					style="background-color: #4A452A;">Report No</td>
				<td class="text-center "
					style="background-color:#7F7F7F;">Type</td>
				<td class="text-center "
					style="background-color:#7F7F7F;">Date</td>
				<td class="text-center "
					style="background-color:#2F4177;">Location</td>
                </tr>
                </thead>
                <tbody>
                <?php $num = 1; ?>
				@foreach($merchant_pro as $product)
				<tr>
					<td align="center">{{ $num }}</td>
					<td align="center">
						<a href="{{url()}}/productconsumer/{{$product->id}}"
						target="_blank">{{IdController::nP($product->id)}}</a>
					</td>
					<?php 
						$pname = $product->name;
						if(strlen($pname) > 20){
							$pname = substr($pname, 0, 17);
							$pname .= "...";
						}
					?>
					<td align="left">
						<a href="{{url()}}/productconsumer/{{$product->id}}"
						target="_blank">
						<img src="{{asset('/')}}images/product/{{$product->id}}/{{$product->photo_1}}"
						width="30" height="30"
						style="padding-top:0;margin-top:4px">
						<span style="vertical-align: middle;"
						title="{{$product->name}}">&nbsp;{{$pname}}</span></a>
					</td>
					<td align="right">{{$product->available}}</td>
					<?php
						$totalb2b = 0;
						$b2b = 0;
						$term = 0;
						if(!is_null($product->availableb2b)){ $b2b= $product->availableb2b; }
						if(!is_null($product->warehouse_available)){ $term= $product->warehouse_available; }
						$totalb2b = $b2b + $term;
					?>
					
					<td align="right"><a href="javascript:void(0);" class="avb2b" rel-b2b="{{$b2b}}" rel-term="{{$term}}" rel-total="{{$totalb2b}}">{{$totalb2b}}</td>
					<td align="right">@if(!is_null($product->availablehyper)) {{$product->availablehyper}} @else 0 @endif</td>
					<td align="right">0</td>
					<td align="right"><span class="warehouse_qty" id="warehouse_qtyspan{{$product->id}}" rel="{{$product->id}}">@if(!is_null($product->stock)){{$product->stock}}@else 0 @endif</span></td>
					<?php 
						$totalavailable = $product->available + $totalb2b + $product->availablehyper;
					?>
					<td align="right"><a href="javascript:void(0);" class="mapping" rel="{{$product->id}}"><span id="totalavailable{{$product->id}}">{{$totalavailable}}</span></a></td>
				</tr>
				<?php $num++; ?>
				@endforeach

				@foreach($merchant_prot as $tproduct)
				<tr>
					<td align="center">{{ $num }}</td>
					<td align="center">
						{{IdController::nTp($tproduct->id)}}
					</td>
					<?php 
						$pname = $tproduct->name;
						if(strlen($pname) > 20){
							$pname = substr($pname, 0, 17);
							$pname .= "...";
						}
					?>
					<td align="left">
						<span style="vertical-align: middle;">{{$pname}}</span>
					</td>
					<td align="right">0</td>
					<td align="right">0</td>
					<td align="right">0</td>
					<td align="right">0</td>
					<td align="right">
					<span class="twarehouse_qty"
					id="twarehouse_qtyspan{{$tproduct->id}}"
					rel="{{$tproduct->id}}">{{$tproduct->available}}</span> 
					<input style="display:none;" type="text" size="6"
					class="twarehouse_qty_input form-control"
					id="twarehouse_qty{{$tproduct->id}}"
					rel="{{$tproduct->id}}" b2crel="0" b2brel="0"
					hyperrel="0" consrel="0" value="{{$tproduct->available}}"/></td>
					<?php 
						$totalavailable = $tproduct->available;
					?>
					<td align="right"><span id="ttotalavailable{{$tproduct->id}}">{{$totalavailable}}</span></td>
				</tr>
				<?php $num++; ?>
				@endforeach
                </tbody>
            </table>
            </div>
</div>

<div class="modal fade" id="myModalccc" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 30%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">B2B Inventory</h4>
            </div>
            <div class="modal-body">
				<h3 id="modal-Tittle1"></h3>
                <h3 id="modal-Tittle"></h3>
                <div class="table-responsive">
                    <table id="myTable" class="table table-bordered myTable">
						<tr>
							<td style="background-color: #808080; color: white; text-align: center;" >
								B2B
							</td>
							<td style="background-color: #F396D4; color: white; text-align: center;">
								Term
							</td>
							<td style="background-color: #948A54; color: white; text-align: center;">
								Total
							</td>
						</tr>
						<tr>
							<td style="text-align: right;">
								<span id="b2bspan"  style="text-align: right;"></span>
							</td>
							<td style="text-align: right;">
								<span id="termspan" style="text-align: right;"></span>
							</td>
							<td style="text-align: right;">
								<span id="totalspan" ></span>
							</td>
						</tr>
					</table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="myModalMapping" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 60%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Product Mapping</h4>
            </div>
            <div class="modal-body-mapping">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>
    <script>
        $(document).ready(function(){
	

		var table = $('#merchant-inventory').DataTable({
			'bScrollCollapse': true,
			'scrollX':true,
			'autoWidth':false,
			"order": [],
			"columnDefs": [
				{"targets": 'no-sort', "orderable": false, },
				{"targets": "medium", "width": "80px" },
				{"targets": "large",  "width": "120px" },
				{"targets": "approv", "width": "180px"},
				{"targets": "blarge", "width": "200px"},
				{"targets": "bsmall",  "width": "20px"},
				{"targets": "clarge", "width": "250px"},
				{"targets": "xlarge", "width": "300px" }
			],
			"fixedColumns":  false
		});
		
		$(document).delegate( '.mapping', "click",function (event) {
			console.log("HI");
			var id = $(this).attr('rel');
			/*$("#b2bspan").html($(this).attr('rel-b2b'));
			$("#termspan").html($(this).attr('rel-term'));
			$("#totalspan").html($(this).attr('rel-total'));*/
			$.ajax({
				url: JS_BASE_URL + '/productmapping/' + id,
				cache: false,
				method: 'GET',
				success: function(result, textStatus, errorThrown) {
					$(".modal-body-mapping").html(result);
					$("#myModalMapping").modal('show');
				}
			});				
			
		});		
		
		$(document).delegate( '.avb2b', "click",function (event) {
			console.log("HI");
			$("#b2bspan").html($(this).attr('rel-b2b'));
			$("#termspan").html($(this).attr('rel-term'));
			$("#totalspan").html($(this).attr('rel-total'));
			$("#myModalccc").modal('show');
		});
		
		$(document).delegate( '.warehouse_qty_input', "blur",function (event) {
			var objThis = $(this);		
			var id = objThis.attr('rel');
			var b2c = parseInt(objThis.attr('b2crel'));
			var b2b = parseInt(objThis.attr('b2brel'));
			var hyper = parseInt(objThis.attr('hyperrel'));
			var cons = parseInt(objThis.attr('consrel'));
			var value = parseFloat(objThis.val());
			var qty = parseFloat($("#warehouse_qty" + id).val());
			/*$("#b2b_qty" + id).hide();
			$("#b2b_qtyspan" + id).text(qty);
			$("#b2b_qtyspan" + id).show();	*/			
			$.ajax({
					url: JS_BASE_URL + '/product_warehouse_qty',
					cache: false,
					method: 'POST',
					data: {id: id, qty: qty},
					success: function(result, textStatus, errorThrown) {
					//	objThis.hide();
						var totalavailable = b2c + b2b + hyper + cons + parseInt(result.result);
						$("#warehouse_qty" + id).hide();
						$("#warehouse_qtyspan" + id).text(result.result);
						$("#totalavailable" + id).text(totalavailable);
						$("#warehouse_qtyspan" + id).show();
					}
			});			
		});
		
		$(document).delegate( '.warehouse_qty', "click",function (event) {
			var objThis = $(this);
			objThis.hide();
			var id = objThis.attr('rel');
			$("#warehouse_qty" + id).show();
		});		

		$(document).delegate( '.twarehouse_qty_input', "blur",function (event) {
			var objThis = $(this);		
			var id = objThis.attr('rel');
			var b2c = parseInt(objThis.attr('b2crel'));
			var b2b = parseInt(objThis.attr('b2brel'));
			var hyper = parseInt(objThis.attr('hyperrel'));
			var cons = parseInt(objThis.attr('consrel'));
			var value = parseFloat(objThis.val());
			var qty = parseFloat($("#twarehouse_qty" + id).val());
			/*$("#b2b_qty" + id).hide();
			$("#b2b_qtyspan" + id).text(qty);
			$("#b2b_qtyspan" + id).show();	*/			
			$.ajax({
					url: JS_BASE_URL + '/tproduct_warehouse_qty',
					cache: false,
					method: 'POST',
					data: {id: id, qty: qty},
					success: function(result, textStatus, errorThrown) {
					//	objThis.hide();
						var totalavailable = b2c + b2b + hyper + cons + parseInt(result.result);
						$("#twarehouse_qty" + id).hide();
						$("#twarehouse_qtyspan" + id).text(result.result);
						$("#ttotalavailable" + id).text(totalavailable);
						$("#twarehouse_qtyspan" + id).show();
					}
			});			
		});
		
		$(document).delegate( '.twarehouse_qty', "click",function (event) {
			var objThis = $(this);
			objThis.hide();
			var id = objThis.attr('rel');
			$("#twarehouse_qty" + id).show();
		});			
    });
 
    </script>
@yield("left_sidebar_scripts")
@stop
