@extends("common.default")
@section("content")
@include('common.sellermenu')

<section class="">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">  
				<div class="row panel-body ">
					<h3>Quantity of 1 Definition Table</h3>
					<table class="table table-bordered" id="q1-table" width="100%">
					 	<thead style="background-color: #e46c0a;color:#fff">
							<tr role="row">
								<th class="text-left">No</th>
								<th class="text-left">Product</th>
								<th class="text-center">Measurement</th>
								<th class="text-center">Unit</th>
							</tr>
						</thead>
						<tbody>
							<?php $index = 0;?>
							@if(count($products) > 0)
							@foreach($products as $product)
							<tr>
								<td class="text-left">{{++$index}}</td>
								<td class="text-left">{{$product->name}}</td>
								<td class="text-center">
									<span>Quantity of 1 = </span>
									<input class="q1-input text-right" type="number" value="{{$product->measurement}}" data-pid="{{$product->id}}">
									<span class="msg"></span>
								</td>
								<td class="text-center">
									<select data-pid="{{$product->id}}" class="q1-select">
										@foreach($units as $key => $unit)
											<option value="{{$key}}" @if($unit==$product->symbol) selected  @endif>{{$unit}}</option>
										@endforeach
									</select>
									<span class="msg"></span>
								</td>
							</tr>		
							@endforeach
							@endif					
						</tbody> 
					</table>

				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	$(document).ready( function () {    	
    	let editor = $('#q1-table').DataTable({
    		"pagingType": "full_numbers"
    	});

    	$(document).on( 'change', '.q1-input', function (e) { 
    		$ctx = $(this);   		
	        $val = $ctx.val();
	        $pid = $ctx.attr('data-pid');

	        $span = $ctx.parent().find('span.msg');
	        $span.text('Updating..');
	        toggleFormElements(true)
	        $.ajax({
	        	method: 'POST',
	        	url: '/seller/q1/update',
	        	data: {
	        		'product_id': $pid,
	        		'measurement': $val,
	        		'_token': '{{csrf_token()}}'
	        	},
	        	success: function(data) {
	        		$span.text('');
	        	},
	        	error: function(data) {
	        		$span.text('Error updating');
	        	}
	        }).always(function() {
	        	toggleFormElements(false)
	        });
	    } );

	    $(document).on( 'change', '.q1-select', function (e) { 
    		$ctx = $(this);   		
	        $val = $ctx.val();
	        $pid = $ctx.attr('data-pid');
	        $span = $ctx.parent().find('span.msg')
	        
	         $span.text('Updating');
			toggleFormElements(true)
	        $.ajax({
	        	method: 'POST',
	        	url: '/seller/q1/update',
	        	data: {
	        		'product_id':$pid,
	        		'unit': $val,
	        		'_token': '{{csrf_token()}}'
	        	},
	        	success: function(data) {
	        		if(data.error == true)
                    {
                        $span.text('Error updating');
                    }
                    else{
                        $span.text('');
                    }
	        	},
	        	error: function(data) {
	        		$span.text('Error updating');
	        	}
	        }).always(function() {
	        	toggleFormElements(false)
	        });
	    } );
	    function toggleFormElements(bool) {
	    	$('.q1-input,.q1-select').attr('disabled',bool);
	    }	    
	} );
</script>
<style type="text/css">
.q1-input{
	width: 80px;
}
</style>
@endsection
<!--  -->