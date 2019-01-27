@extends("common.default")
@section('extra-links')

@stop
@section("content")
    <div class="container" style="margin-top:30px;">
        <div class="row">
            <div class="col-sm-3">
                @include('admin/leftSidebar')
            </div>

            <div class="col-md-9 equal_to_sidebar_mrgn">
                <h3>Delivery Order</h3>
                <hr/>
                <p class="bg-success success-msg" style="display:none;padding: 15px;"></p>
                @if(isset($delivery_orders) && !empty($delivery_orders))

                    {!! $delivery_orders->render() !!}
                    <div class="table-responsive">

                        <table class="table table-striped" id="grid">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>DO ID</th>
                                <th>Order Received</th>
                                <th>Order Executed</th>
                                <th>Total</th>
                                <th>Buyer</th>
                            </tr>
                            </thead>
                            <tbody id="orders-list">
                            @foreach($delivery_orders as $delivery_order)

                                <tr>
                                    <td>
                                        {{$delivery_order->id}}
                                    </td>

                                    <td id="{{$delivery_order->porder_id}}">
                                        <span id="btn-order-details" class="btn btn-link">[{{sprintf('%06d', $delivery_order->porder_id)}}]</span>
                                    </td >

                                    <td>
                                        @if(!is_null($delivery_order->porder())){{$delivery_order->porder->created_at}} @endif
                                    </td>

                                    <td>
                                        @if(!is_null($delivery_order->porder())){{$delivery_order->porder->receipt_tstamp}} @endif
                                    </td>

                                    <td>
                                        @if(!is_null($delivery_order->porder())){{$delivery_order->porder->payment->receivable}} @endif
                                    </td>

                                    <td>
                                        @if(array_key_exists($delivery_order->porder->user_id,$usersfullname))
                                            {{$usersfullname[$delivery_order->porder->user_id]}}
                                        @endif
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
        </div>
        </div>

    </div>

    <!-- End of Table-to-load-the-data Part -->
    <!-- Modal (Pop up when detail button clicked) -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Delivery Order Master </h4>
                </div>
                <div class="col-md-6">
                    <label id="merchant_id" class="btn-block"></label>
                    <label id="merchant_name" class="btn-block"></label>
                    <label id="merchant_address" class="btn-block"></label>
                    <hr>
                    <label id="station_id" class="btn-block"></label>
                    <label id="station_name" class="btn-block"></label>
                    <label id="station_address" class="btn-block"></label>
                    <label>DeliveryOrder: </label><label id="delivery_order_id" class=""></label>
                </div>
                <div class="modal-body">

                    <table class="table table-striped" id="grid">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th class="large">Product</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Amount</th>
                            <th class="xlarge">Remark</th>
                        </tr>
                        </thead>
                        <tbody id="delivery_order_products">

                        </tbody>
                        </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-close">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#grid').on('click', '#btn-order-details',function(){
                var do_id = $(this).parent().attr('id');
                $.ajax({
                    type:'get',
                    url:'/admin/master/delivery_order_details/'+do_id,
                    dataType:'json',
                    success:function(order_details){
                        $('#merchant_id').text(order_details.merchant_id);
                        $('#merchant_name').text(order_details.merchant_name);
                        $('#merchant_address').text(order_details.merchant_address.line1+" - "+order_details.merchant_address.line3+" - "+order_details.merchant_address.line43+" - "+order_details.merchant_address.postcode);
                        $('#station_address').text(order_details.station_address.line1+" - "+order_details.station_address.line2+" - "+order_details.station_address.line3+" - "+order_details.station_address.line4+" - "+order_details.station_address.postcode);
                        $('#station_id').text(order_details.station_id);
                        $('#station_name').text(order_details.station_name);
                        $('#delivery_order_id').text(do_id);
                        var delivery_order_product_rows = "";
                        var product_id;
                        for(var i = 0; i < order_details.delivery_order_products.length;i++){
                            product_id = order_details.delivery_order_products[i].id;
                            delivery_order_product_rows += "<tr>" +
                                    "<td>"+order_details.products[product_id].id+"</td>" +
                                    "<td>"+order_details.products[product_id].name+"</td>" +
                                    "<td>"+order_details.qty+"</td>" +
                                    "<td>"+order_details.delivery_order_products[i].status+"</td>" +
                                    "<td></td>" +
                                    "<td>"+order_details.delivery_order_products[i].remark+"</td></tr>";
                            $('#delivery_order_products').html(delivery_order_product_rows);
                        }
                        $('#myModal').modal('show');
                        console.log(order_details);
                    }
                });
            });
            $('body').on('click', '#btn-close',function(){
                $('#myModal').modal('hide');
            });
        });
    </script>
@stop
