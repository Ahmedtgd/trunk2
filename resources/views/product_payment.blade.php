<div class='col-md-12'>
	<table class="table table-responsive" id="pt">
	    <thead>
	        <tr class='paymentTable'>
	            <th>No</th>
	            <th class='nosort'>Order ID</th>
	            <th>Order Received</th>
	            <th>Order Executed</th>
	            <th class='nosort'>Quantity</th>
	            <th class='nosort'>Price</th>
	            <th class='nosort'>Total</th>
	            <th class='nosort'>User</th>
	            <th>Source</th>
	        </tr>
	    </thead>
	    @if(isset($products) and !is_null($products))
	    <tbody>
	        @def $i = 1
	        @foreach($products as $product)
	            <tr>
	                <td class='text-center'>{!! $i++ !!}</td>
	                <td class='text-center'>
                            [{!! str_pad($product->poid, 10, '0', STR_PAD_LEFT) !!}]
                    </td>
	                <td class='text-center'>{!! $product->order_received !!}</td>
	                <td class='text-center'>{!! $product->order_executed !!}</td>
	                <td class='text-center'>{!! number_format($product->quantity,2) !!}</td>
	                <td>
	                	<span class="pull-left">{!! $product->currency !!}</span>
	                	<span class="pull-right">{!! number_format($product->price,2) !!}</span>
	                </td>
	                <td>
	                	<span class="pull-left">{!! $product->currency !!}</span>
	                	<span class="pull-right">{!! number_format($product->price  * $product->quantity,2) !!}</span>
	                </td>
	                <td class='text-center'>
	                	<span class="pull-left">[{!! str_pad($product->user_id, 10, '0', STR_PAD_LEFT) !!}]</span>
	                	<span class="pull-right">{!! $product->user_name !!}</span>
	                </td>
	                <td class='text-center'>{!! $product->source !!}</td>
	            </tr>
	        @endforeach
	    </tbody>
		@endif
	</table>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('#pt').addClass('table-bordered');
    $('#pt').DataTable({
        'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': ['nosort']
        }],
    });
})
</script>