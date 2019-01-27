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
        <li  class="active"><a id="s_tab" data-toggle="tab"
			style="margin-right:0"
			href="#sell">Sell</a></li>
        <li><a id="b_tab" data-toggle="tab"
			style="margin-left:0;margin-right:0"
			href="#buy">Buy</a></li>
    </ul>
     <div id="" class="tab-content">
         <div id="sell" class="tab-pane fade in active">
            <table class="table text-muted counter_table"  id="sellTable">
                <thead style="background-color: darkgreen;color:white">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">DO&nbsp;ID</th>
                        <th class="text-center">Receipt&nbsp;ID</th>
                        <th class="text-center">Order&nbsp;ID</th>
                        <th class="text-center">Order&nbsp;Received</th>
                        <th class="text-center">Order&nbsp;Excecuted</th>          
                        <th class="text-center">Total</th>
						<th class="text-center">User&nbsp;ID&nbsp;(Buyer)</th>
                    </tr>
                </thead>
                <tbody>   
                    @foreach($porders as $order)
                        <?php
							$receipt_tstamp = date_create($order->receipt_tstamp);
							$delivery_tstamp = date_create($order->delivery_tstamp);
                        ?>
                            <tr>
                                <td class="text-center">{{$c++}}</td>
                                <td class="text-center">
									<a href="{{route('DeliveryOrder',
									['deliveryorderid' => $order->doid])}}">
									{{' ['.sprintf('%010d', $order->doid).']  '}}</a></td>
                                <td class="text-center">
									{{' ['.sprintf('%010d', $order->recid).']  '}}</td>
								<td class="text-center">
									{{' ['.sprintf('%010d', $order->porderid).']  '}}</td>
                                <td class="text-center">
									{{date_format($receipt_tstamp,'dMy h:s')}}</td>
                                <td class="text-center">
									{{date_format($delivery_tstamp,'dMy h:s')}}</td>
                                <td class="text-right p">
									{{$currency->code.'&nbsp;'.
									number_format(($order->order_price / 100) , 2,'.',',')}}</td>
								<td class="text-center">
									{{' ['.sprintf('%010d', $order->buyer_id).']  '}}</td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id="buy" class="tab-pane fade" style="display: none;">
            <table class="table text-muted counter_table"  id="buyTable">
                <thead style="background-color: black;color:white">
                    <tr>
                        <th class="text-center">No</th>
						<th class="text-center">DO&nbsp;ID</th>
                        <th class="text-center">Receipt&nbsp;ID</th>
                        <th class="text-center">Order&nbsp;ID</th>
                        <th class="text-center">Order&nbsp;Received</th>
                        <th class="text-center">Order&nbsp;Excecuted</th>          
                        <th class="text-center">Total</th>
						<th class="text-center">User&nbsp;ID&nbsp;(Seller)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sorders as $order)
                        <?php
							$receipt_tstamp = date_create($order->receipt_tstamp);
							$delivery_tstamp = date_create($order->delivery_tstamp);
                        ?>
                            <tr>
                                <td class="text-center">{{$c++}}</td>
								<td class="text-center">
									<a href="{{route('DeliveryOrder',
										['deliveryorderid' => $order->doid])}}">
										{{' ['.sprintf('%010d', $order->doid).']  '}}</a></td>
                                <td class="text-center">
									{{' ['.sprintf('%010d', $order->recid).']  '}}</td>
								<td class="text-center">
									{{' ['.sprintf('%010d', $order->porderid).']  '}}</td>
                                <td class="text-center">
									{{date_format($receipt_tstamp,'d-M-y h:s')}}</td>
                                <td class="text-center">
									{{date_format($delivery_tstamp,'d-M-y h:s')}}</td>
                                <td class="text-right">
									{{$currency->code .' '.
									number_format(($order->order_price / 100) , 2,'.',',')}}</td>
								<td class="text-center">
									{{' ['.sprintf('%010d', $order->seller_id).']  '}}</td>
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
        $("#myModalLabel2").text("Station Delivery Order");
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
        $("#myModalLabel2").text("Merchant Delivery Order");
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
        else if(user_role === "both"){
            $("#myModalLabel2").text("Merchant Delivery Order");
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
