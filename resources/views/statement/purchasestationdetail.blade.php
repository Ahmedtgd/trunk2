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
            <table class="table-bordered"  id="purchTable" width="100%">
                <thead style="background-color: #F29FD7;color:white">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Order&nbsp;ID</th>
                        <th class="text-center">Invoice&nbsp;Date</th>       
                        <th class="text-center">Total</th>
						<th class="text-center">Merchant&nbsp;ID&nbsp;</th>
                    </tr>
                </thead>
                <tbody>   
                    @foreach($porders as $order)
                        <?php
							$receipt_tstamp = date_create($order->receipt_tstamp);
							$delivery_tstamp = date_create($order->created_at);
							// $ordertproducts = DB::table('ordertproduct')->where('porder_id',$order->porderid)->get();
                            $ordertproducts = DB::table('orderproduct')->where('porder_id',$order->porderid)->get();
							$total = 0;
							foreach($ordertproducts as $ordertproduct){
								$total += ($ordertproduct->quantity * $ordertproduct->order_price);
							}
                        ?>
                            <tr>
                                <td class="text-center">{{$c++}}</td>
								<td class="text-center">
									<a href="{{route('purchaseorder',
									['orderid' => $order->porderid])}}" target="_blank">{{IdController::nO($order->porderid)}}</a></td>
                                <td class="text-center">
									{{UtilityController::s_date($order->created_at)}}</td>
                                <td class="text-right p">
									{{$currency->code.'&nbsp;'.
									number_format(($total / 100) , 2,'.','')}}</td>
								<td class="text-center">
									{{IdController::nM($order->seller_id)}}</td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
     </div>	
<script>
$(document).ready(function () {
	$("#myModalLabel2").text("Station Invoices");
	$("#sell").show();
	$("#buy").css("position" ,"absolute");
	$("#buy").show();
	$('#purchTable').dataTable().fnDestroy();
	$('#purchTable').DataTable({
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
