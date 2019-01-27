<?php 
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Classes;
?>
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
     <div id="" class="tab-content">
         <div id="sell" class="tab-pane fade in active">
            <table class="table-bordered"  id="sellTable" width="100%">
                <thead style="background-color: #F29FD7;color:white">
                    <tr class="bg-gator">
                        <th class="text-center">No</th>
                        <th class="text-center">Invoice&nbsp;No</th>
                        <th class="text-center">Invoice&nbsp;Date</th>       
                        <th class="text-center">Merchant&nbsp;&nbsp;</th>
                        <th class="text-center">Amount ({{$currency->code}})</th>
                    </tr>
                </thead>
                <tbody>   
                    @foreach($porders as $order)
                        <?php
							$receipt_tstamp = date_create($order->receipt_tstamp);
							$delivery_tstamp = date_create($order->created_at);
							// $ordertproducts = DB::table('ordertproduct')->where('porder_id',$order->porderid)->get();
							// $total = 0;
							// foreach($ordertproducts as $ordertproduct){
							// 	$total += ($ordertproduct->quantity * $ordertproduct->order_price);
							// }
                        ?>
                            <tr>
                                <td class="text-center">{{$c++}}</td>
                                @if($order->status == 'cancelled')
                                    <td class="text-center" style="background-color: red;">
                                        <a href="{{route('Invoice',
									['orderid' => $order->porderid])}}" target="_blank">

                                        <!-- {{IdController::nO($order->porderid)}} -->
                                            {{sprintf('%010d', $order->invoice_no)}}
                                        </a></td>
                                @else

                                    <td class="text-center" style="background-color: yellow;">
                                        <a href="{{route('Invoice',
									['orderid' => $order->porderid])}}" target="_blank">

                                        <!-- {{IdController::nO($order->porderid)}} -->
                                            {{sprintf('%010d', $order->invoice_no)}}
                                        </a></td>
                                @endif
                                <td class="text-center">
									{{UtilityController::s_date($order->created_at)}}</td>
                                <td class="text-center">
                                    {{IdController::cN($order->seller_id)}}</td>
                                <td class="text-right p">
									{{$currency->code.'&nbsp;'.
									number_format(($order->order_price / 100) , 2,'.','')}}</td>
								
                            </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
     </div>	
<script>
$(document).ready(function () {
	$("#myModalLabel2").text("Invoice Issued");
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

	$("#b_tab").click(function(){
		$("#buy").css("position" ,"relative");
	});
	$("#s_tab").click(function(){
		$("#buy").css("position" ,"absolute");
	});
});
</script>	 
