{!! Form::open(array('url'=>'/payorder')) !!}
	<div class='col-md-12'>
		<table class="table table-bordered  table-responsive" id="orderTable">
		    <thead>
		        <tr class='paymentTable'>
		            <th>No</th>
		            <th class='nosort'>Order ID</th>
		            <th class='osum nosort'>Sales</th>
		            <th class='osum nosort'>Commission</th>
		            <th class='osum nosort'>Payable</th>
		            <th>Status</th>
		            <th>Receive Date</th>
		            <th>Due Date</th>
		            <th>Source</th>
		            <th class="nosort"></th>
		        </tr>
		    </thead>
	        @if(isset($orders) and !is_null($orders))
			<input type="hidden" class='curr' value="{!! $orders[0]->currency !!}">
	        <tfoot>
	            <tr>
	                <th></th>
	                <th></th>
	                <th class='osales text-right'></th>
	                <th class='ocom text-right'></th>
	                <th class='opay text-right'></th>
	                <th></th>
                    <th colspan=2 >
                        <span class="pull-left hidden osubtotal">Subtotal :</span>
                        <span class="pull-right hidden osubtotal_amount"></span>
                    </th>
	                <th colspan=2 ><button class='btn btn-block btn-danger btn-sm'>Pay</button></th>
	            </tr>
	        </tfoot>
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
		                <td class='osales text-right'>
		                    {!! number_format($order->sales,2) !!}
		                </td>
		                <td class='ocom text-right'>
		                    {!! number_format($order->commission,2) !!}
		                </td>
		                <td class='opay text-right'> 
		                    {!! number_format($order->payable,2) !!}
		                </td>
		                <td class='text-center'> 
		                    {!! ucfirst($order->status) !!}
		                </td>
		                <td class='text-center'>{!! $order->rcv !!}</td>
		                <td class='text-center'>{!! $order->due !!}</td>
		                <td class='text-center'>{!! $order->source !!}</td>
		                <td class='text-center'><input data='{!! number_format($order->payable,2) !!}' class='oid' type="checkbox" name='order[]' value='{!! $order->poid !!}'></td>
		            </tr>
		        @endforeach
		    </tbody>
			@endif
		</table>
	</div>
{!! Form::close() !!}

<script type="text/javascript">
$(document).ready(function() {
    var table = $('#orderTable').DataTable({                
        'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': ['nosort']
        }],
        "initComplete": function (settings, json) {
            this.api().columns('.osum').every(function () {
                var column = this;

                var sum = column
                   .data()
                   .reduce(function (a, b) { 
                       return parseFloat(a) + parseFloat(b);
                   });

                sum = parseFloat(sum).toFixed(2);
                $(column.footer()).html(sum);
            });
        }
    });

    var currency = $('.curr').val();

    $('.ocom, .opay, .osales').append("<span class='pull-left'>{!! $orders[0]->currency !!}</span>");

    $('.oid').on('change', function(){	    
    	total = 0;
	    $('.oid:checked').each(function(){
	        amount = parseFloat($(this).attr('data'));
	        total = total + parseFloat(amount);
	    })

	    if(total > 0){
	        $('.osubtotal').removeClass('hidden');
	        $('.osubtotal_amount').removeClass('hidden').text(currency + ' ' + total);
	    }else{
	        $('.osubtotal').addClass('hidden');
	        $('.osubtotal_amount').addClass('hidden');
	    }
	})

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