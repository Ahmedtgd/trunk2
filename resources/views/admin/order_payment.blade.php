<div class='col-md-12'>
	@if(isset($orders) and !is_null($orders))
	<input type="hidden" class='curr' value="{!! $orders[0]->currency !!}">
	<table class="table table-bordered  table-responsive" id="orderTable">
	    <thead>
	        <tr class='paymentTable'>
	            <th>No</th>
	            <th>Order ID</th>
	            <th class='osum'>Commission</th>
	            <th class='osum'>Payable</th>
	            <th>Receive Date</th>
	            <th>Due Date</th>
	            <th>Source</th>
	            <th></th>
	        </tr>
	        <tfoot>
	            <tr>
	                <th></th>
	                <th></th>
	                <th class='ocom text-right'></th>
	                <th class='opay text-right'></th>
	                <th></th>
	                <th></th>
	                <th colspan=2 ><button class='btn btn-block btn-danger btn-sm'>Pay</button></th>
	            </tr>
	        </tfoot>
	    </thead>
	    <tbody>
	        @def $i = 1
	        @foreach($orders as $order)
	            <tr>
	                <td class='text-center'>{!! $i++ !!}</td>
	                <td class='text-center'>
	                	<a class='clickable order_id' data-val="{!! $order->poid !!}">
                            [{!! str_pad($order->poid, 10, '0', STR_PAD_LEFT) !!}]
                        </a>
                    </td>
	                <td class='ocom text-right'>
	                    {!! number_format($order->commission,2) !!}
	                </td>
	                <td class='opay text-right'> 
	                    {!! number_format($order->payable,2) !!}
	                </td>
	                <td class='text-center'>{!! $order->rcv !!}</td>
	                <td class='text-center'>{!! $order->due !!}</td>
	                <td class='text-center'>{!! $order->source !!}</td>
	                <td class='text-center'><input type="checkbox"></td>
	            </tr>
	        @endforeach
	    </tbody>
	</table>
	@else
	    <h3 class='text-muted'> no data found for order in database </h3>
	@endif
</div>

<script type="text/javascript">
$(document).ready(function() {
    var table = $('#orderTable').DataTable({
        "initComplete": function (settings, json) {
            this.api().columns('.osum').every(function () {
                var column = this;

                var sum = column
                   .data()
                   .reduce(function (a, b) { 
                       return parseFloat(a) + parseFloat(b);
                   });

                $(column.footer()).html(sum.toFixed(2));
            });
        }
    });

    var currency = $('.curr').val();

    $('.ocom, .opay').append("<span class='pull-left'>{!! $orders[0]->currency !!}</span>");

    $('.order_id').click(function(){
        $('body').css('padding','0px');
        $order_id = $(this).attr('data-val');
    	$('#orderModal').modal('hide');
        $('#productClose').click(function(){
        	$('#productModal').modal('hide');
        	$('#orderModal').modal('show');
        })
        $.ajax({
            type : "GET",
            url : 'merchant/product/'+$order_id,
            success : function(response){
    			$('#productModal').modal('show');
        		$('#productModal').find('.modal-body').html(response);
            }
        })
    })
})
</script>