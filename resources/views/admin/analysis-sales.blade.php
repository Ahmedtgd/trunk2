<div class="table-responsive">
    <table id="datatable" class="table table-striped">
        <thead>
            <tr style="background-color:rgb(64,49,82); color: white;">
                <td class="no-sort">No.</td>
                <td>Order ID</td>
                <td>Merchant ID</td>
                <td>External Delivery ID</td>
                <td>Delivery Company</td>
                <td>Status</td>
                <td>Days Since Ordered</td>
                <td style="background-color:rgb(41,135,177); color: white;">Date Received</td>
                <td style="background-color:rgb(41,135,177); color: white;">Due Date</td>
            </tr>
        </thead>
        <tbody>
            <?php $num = 1; ?>
            @foreach($orders as $order)
                <tr>
                    <td align="center" class="no-sort">{{ $num }}</td>
                    <td align="center" class="order-details" order_id="{{ $order->id }}"><p style="color: darkblue;">[{{ $order->getPrefixofID($order->id) }}]</p>   </td>
                    <td align="center" class="merchant-details" merchant_id="{{ $order->merchant_id }}"><p style="color: darkblue;">[{{ $order->getPrefixofID($order->merchant_id) }}]</p></td>
                    <td align="center">{{ $order->shipping_id }}</td>
                    <td align="left">{{ $order->shipping_company }}</td>
                    <td align="left">{{ $order->payment_status }}</td>
                    <td align="center">{{ $order->getSinceDate($order->created_at) }}</td>
                    <td align="center">{{ date_format(date_create($order->delivery_tstamp),'dMy h:s') }}</td>
                    <td align="center">{{ date_format(date_create($order->date_payment),'dMy h:s') }}</td>
                </tr>
                <?php $num++; ?>
            @endforeach
        </tbody>
    </table>
{{--</div>--}}

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Order Details</h4>
            </div>
            <div class="modal-body orderDetails">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="orderDetailModal" tabindex="-1" role="dialog" aria-labelledby="order-details-label">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Order Details</h4>
            </div>
            <div class="modal-body orderDetails">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="merchantModal" tabindex="-1" role="dialog" aria-labelledby="merchantModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Order Details</h4>
            </div>
            <div class="modal-body merchantDetails">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#datatable').DataTable({
			"order":[],
            'scrollX':true,
            'autoWidth':false,
            "aoColumnDefs" : [ {
                "bSortable" : false,
                "width" : "10%",
                "aTargets" : [ "no-sort" ]
            } ]
        });
    });

    $('.order-details').on('click', function () {
        var orderId = $(this).attr('order_id');
        $('#myModal').modal('show');
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

    $('.merchant-details').on('click', function () {
        var merchantId = $(this).attr('merchant_id');
        $('#merchantModal').modal('show');
        $.ajax({
            url: '{{route('load:merchantDetails')}}',
            cache: false,
            method: 'GET',
            data: {merchantId: merchantId},
            beforeSend: function () {
            },
            success: function (result) {
                $('.merchantDetails').html(result);
            }
        });
    });
</script>
