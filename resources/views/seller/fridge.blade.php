@extends("common.default")
@section("content")
@include('common.sellermenu')
<?php  

// mock data
$usedData = [
	['date' => '08/09/2018', 'quantity' => 30],
	['date' => '07/09/2018', 'quantity' => 10],
	['date' => '06/09/2018', 'quantity' => 50],
	['date' => '05/09/2018', 'quantity' => 8],
	['date' => '04/09/2018', 'quantity' => 2]
];

?>
<section class="">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">  
				<div class="row panel-body ">

					<h3>Fridge & Storage Management</h3>
					<table class="table table-bordered" id="fridge-table" width="100%">
						<thead>
							<tr  style="background-color: #fb7102;color: #fff">
								<th class="text-center bsmall">No.</th>
								<th class="text-left">Product Name</th>
								<th class="text-center">Qty.&nbsp;Used</th>
								<th class="text-center">Optimum </th>
								<th class="text-center">Estimated</th>
								<th class="text-center">Qty.&nbsp;Left</th>
								<th class="text-center">Status</th>
								
							</tr>
						</thead>
						<tbody>
							@foreach($sproducts as $k=>$product)
							<tr>
								<td class="text-center bsmall">{{$k+1}}</td>
								<td class="text-left"><!--{{$product->photo_1}}--> {{$product->name}}</td>
								<td class="text-center"><a href="javascript:void(0);" onclick="showUsed({{$product->orders}})">
									<!-- {{max(0,$product->qtystock-$product->qtyleft)}} -->
									{{$product->orders->pluck('quantity')->sum()}}
								</a></td>
								<td class="text-center">
									{{$product->orders->count()>0?$product->orders->pluck('quantity')->sum()/$product->orders->count():0}}
								</td>
								<td class="text-center"><input type="text" name=""></td>
								<td class="text-center">{{$product->qtyleft}}</td>
								<td class="text-center">
									{{(isset($product->estimated) && $product->estimated>0)?$product->qtyleft-$product->estimated/$product->estimated:0}}%&nbsp;Optimum</td>
							</tr>		
							@endforeach	
						</tbody>
					</table>
					
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="quantityUsed"  data-keyboard="true" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="quantityUsed">
    <div class="modal-dialog" role="document">
    	
        <div class="modal-content">   
	        <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	            <h4 class="modal-title" id="quantityUsed">Quantity used table</h4>
	        </div>         
            <div class="modal-body">
                <table class="table table-bordered" id="quantity-used-table" width="100%">
						<thead>
							<tr class="bg-inventory">
								<th class="text-center bsmall">No.</th>
								<th class="text-center">Date</th>
								<th class="text-center">Qty. Used</th>							
							</tr>
						</thead>
						<tbody>
							@foreach($usedData as $k=>$d)
							<tr>
								<td class="text-center bsmall">{{$k+1}}</td>								
								<td class="text-center">{{$d['date']}}</td>
								<td class="text-center">{{$d['quantity']}}</td>
							</tr>		
							@endforeach			
						</tbody>
					</table> 
            </div>                          
        </div>
    </div>
</div>
</section>
<script type="text/javascript">
	$(document).ready( function () {
		
	    $('#fridge-table').DataTable();
	} );

	function showUsed(data) {
		// content render logic
		$('#quantityUsed').modal()
		
		let htmlText = '';
		for (var i = 0; i < data.length; i++) {
			htmlText += `<tr>
					<td class="text-center bsmall">`+(i+1)+`</td>								
					<td class="text-center">`+data[i].pivot.created_at.split(' ')[0]+`</td>
					<td class="text-center">`+data[i].pivot.quantity+`</td>
				   </tr>`
		}
		
		$('#quantity-used-table tbody').html(htmlText)
		$('#quantity-used-table').DataTable();
		
	}
</script>
@endsection