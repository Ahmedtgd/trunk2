<?php $i = 0;$c = 1;?>
<style>
    th , td{
        text-align: center;
    }
    .p{
        text-align: right;
    }
    thead{
        margin: 5px;
}
</style>
    <div>
        {{$name or ''}}<br>
        {{ $s->line1 or '' }}<br>
        {{ $s->line2 or '' }}<br>
        {{ $s->line3 or '' }}<span id="did" style="float: right;">{{$mer}} {{ $id }}</span><br>
        {{ $s->line4  or '' }}<br>
    </div>

    <ul class="nav nav-tabs" style="margin:10px;">
        <li  class="active"><a id="s_tab" data-toggle="tab" href="#sell">Sell</a></li>
        <li ><a id="b_tab" data-toggle="tab" href="#buy">Buy</a></li>
    </ul>
     <div id="" class="tab-content">
         <div id="sell" class="tab-pane fade in active">
            <table class="table text-muted counter_table"  id="sellTable">
                <thead style="background-color: darkgreen;color:white">
                    <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Order ID</th>
                        <th>Merchant ID</th>
                        <th>Station ID</th>
                        <th>User ID (Buyer)</th>
                        <th>Product ID</th>
                        <th class="p">Price</th>
                        <th>Quantity</th>
                        <th class="p">Amount</th>
                    </tr>
                </thead>
                <tbody>   
                   
                        @foreach($porders as $order)
                        <?php
                                $time = strtotime($order->created_at);
                                $date = Carbon::create(date('Y',$time),date('m',$time),date('d',$time),date('h',$time),date('i',$time),date('s',$time));
                            ?>
                            <tr>
                                <td>{{$c++}}</td>
                                <td>{{$date->format("dMy")}}</td>
                                <td>{{$order->description}}</td>
                                <td>{{' ['.sprintf('%010d', $order->transaction_id).']  '}}</td>
                                
                                <td>{{' ['.sprintf('%010d', $order->merchant_id).']  '}}</td>
                               <td>{{' ['.sprintf('%010d', $order->station_id ).']  '}}</td> <!-- $station->id-->
                                
                                <td>{{' ['.sprintf('%010d', $order->buyer_id).']  '}}</td>
                                <td>{{' ['.sprintf('%010d', $order->product_id).']  '}}</td>
                                <td class="p">{{$currency->code .' '.number_format(($order->order_price / 100) , 2,'.',',')}}</td>
                                <td>{{ $order->quantity }}</td>
                                <td class="p">{{$currency->code .' '. number_format(($order->quantity * ($order->order_price / 100)) , 2,'.',',') }}</td>
                            </tr>
                        @endforeach
                </tbody>
            </table>
        </div>
        <div id="buy" class="tab-pane fade" style="display: none;">
            <table class="table text-muted counter_table"  id="buyTable">
                <thead style="background-color: black;color:white">
                    <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Order ID</th>
                        <th>Merchant ID</th>
                        <th>Product ID</th>
                        <th class="p">Price</th>
                        <th>Quantity</th>
                        <th class="p">Amount</th>
                    </tr>
                </thead>
                <tbody>
                             @foreach($sorders as $order)
                             <?php
                                $time = strtotime($order->created_at);
                                $date = Carbon::create(date('Y',$time),date('m',$time),date('d',$time),date('h',$time),date('i',$time),date('s',$time));
                            ?>
                                <tr>
                                <td>{{$i++}}</td>
                                <td>{{$date->format("dMy")}}</td>
                                <td>{{$order->description }}</td>
                                <td>{{' ['.sprintf('%010d', $order->transaction_id).']  '}}</td>
                                <td>{{'['.sprintf('%010d', $order->merchant_id or 0).']  '}}</td>
                                <td>{{'['.sprintf('%010d', $order->product_id).']  '}}</td>
                                <td class="p">{{$currency->code .' '.number_format(($order->order_price / 100) , 2,'.',',')}}</td>
                                <td>{{ $order->quantity }}</td>
                                <td class="p">{{$currency->code .' '. number_format((($order->order_price / 100) * $order->quantity) , 2,'.',',') }}</td>
                            </tr>
                      @endforeach    
                </tbody>
            </table>
        </div>
     </div>

<script>
    var user_role = "<?php echo $user_role?>";
    console.log(user_role);
    if(user_role === "sto"){
        $("#myModalLabel2").text("Station Statement");
        $("#sell").show();
            $("#buy").css("position" ,"absolute");
//            $('#sellTable').dataTable().fnDestroy();
            $('#sellTable').DataTable({
            "order": [],
            "columnDefs": [ {
            "targets" : 0,
            "orderable": false
            }]
           });
            $("#buy").show();
        //   $('#buyTable').dataTable().fnDestroy();
            $('#buyTable').DataTable({
            "order": [],
            "columnDefs": [ {
            "targets" : 0,
            "orderable": false
            }]
           });
    }
    else if(user_role === "mct"){ 
        $("#myModalLabel2").text("Merchant Statement");
            $("#sell").show();
            $('#sellTable').dataTable().fnDestroy();
            $('#sellTable').DataTable({
            "order": [],
            "columnDefs": [ {
            "targets" : 0,
            "orderable": false
            }]
           });
            $("#buy").css("position" ,"absolute");
            $("#buy").show();
            $('#buyTable').dataTable().fnDestroy();
            $('#buyTable').DataTable({
            "order": [],
            "columnDefs": [ {
            "targets" : 0,
            "orderable": false
            }]
           });
    }
        else if(user_role === "byr"){
            $("#myModalLabel2").text("Buyer Statement");
            $("#sell").show();
            $("#buy").css("position" ,"absolute");
            $("#buy").show();
            $('#sellTable').dataTable().fnDestroy();
            $('#sellTable').DataTable({
            "order": [],
            "columnDefs": [ {
            "targets" : 0,
            "orderable": false
            }]
           });
            $('#buyTable').dataTable().fnDestroy();
            $('#buyTable').DataTable({
            "order": [],
            "columnDefs": [ {
            "targets" : 0,
            "orderable": false
            }]
           });
        }
        $("#b_tab").click(function(){
            $("#buy").css("position" ,"relative");
        });
        $("#s_tab").click(function(){
            $("#buy").css("position" ,"absolute");
        });
</script>