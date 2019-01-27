<div class="table-responsive" style="width: 100%;">
    <table class="table table-bordered" id="supplier-open-channel">
        <tr style="background-color: #101010; color: white;">
            <td colspan="9">Shipping</td>
        </tr>
        <tr style="background-color: #101010; color: white;">
            <td>No.</td>
            <td>Order ID</td>
            <td>Order Received</td>
            <td>Order Executed</td>
            <td>Description</td>
            <td>Total</td>
            <td>User ID(Buyer)</td>
            <td>Source</td>
        </tr>
        <tr>
            <td align="center">1</td>
            <td align="center" class="order-id-details" order_id="{{ $order->id }}"><p style="color: darkblue;">[{{ $order->getPrefixofID($order->id) }}]</p>   </td></td>
            <td align="center">{{ date_format(date_create($order->delivery_tstamp),'dMy h:s') }}</td>
            <td align="center">{{ date_format(date_create($order->checkout_tstamp),'dMy h:s') }}</td>
            <td align="left">{{ $order->description }}</td>
            <td align="right">{{ $currentCurrency .' '. number_format($order->payment_receivable/100,2) }}</td>
            <td align="center">{{ $order->user_id }}</td>
            <td align="left">{{ $order->source }}</td>
        </tr>
    </table>
</div>

<script type="text/javascript">
    $('.order-id-details').on('click', function () {
        var orderId = $(this).attr('order_id');

        $('#orderDetailModal').modal('show');

        $.ajax({
            url: '{{route('load:orderDetails')}}',
            cache: false,
            method: 'GET',
            data: {orderId: orderId},
            beforeSend: function () {
            },
            success: function (result) {
                $('.orderDetails').html(result);
            }
        });
    });
    $('.closeModal').on('click', function () {
        $('#orderDetailModal').modal('hide');
    });
</script>
