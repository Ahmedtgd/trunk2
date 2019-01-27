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
<span style="font-size:14px !important;"
       class="pull-left">
       <h3> {{$selectedMonthYear}} </h3>
</span>
<span style="font-size:14px !important;"
       class="pull-right">
       <table>
           <tr>
               <td class="text-right">Monthly:</td>
               <td class="text-center">
               &nbsp;{{$currentCurrency}}&nbsp;</td>
               <td class="text-right">
                   <span class="monthlyinvoice">{{number_format($monthly_invoice/100,2)  }}</span></td>
               </tr>
               <tr>
                   <td class="text-right">Today:</td>
                   <td class="text-center">
                   &nbsp;{{$currentCurrency}}&nbsp;</td>
                   <td style="text-align:right">
                       <span class="todayinvoice" >{{ number_format($todayInvoice/100,2) }}</span></td>
                   </tr>
               </table>
</span>
     <div id="" class="tab-content">
         <div id="sell" class="tab-pane fade in active">
            <table class="table-bordered"  id="sellTable" width="100%">
                <thead style="background-color: #F29FD7;color:white">
                    <tr class="bg-gator">
                        <th class="text-center">No</th>
                        <th class="text-center">Invoice&nbsp;No</th>
                        <th class="text-center">Date</th>
						            <!-- <th class="text-center">Station&nbsp;ID&nbsp;</th> -->
                        <th class="text-center">Company Name</th>
                        <th class="text-center">Amount&nbsp;({{$currentCurrency}})</th>
                    </tr>
                </thead>
                <tbody>   
                    @foreach($porders as $order)
                        <?php
                            // $order_price = $order->quantity * $order->order_price;
                        $order_price =$order->TotalOrderPrice ;
							$receipt_tstamp = date_create($order->receipt_tstamp);
							$delivery_tstamp = date_create($order->created_at);
							// $ordertproducts = DB::table('orderproduct')->where('porder_id',$order->porderid)->get();
							// $total = 0;
							// foreach($ordertproducts as $ordertproduct){
							// 	$total += ($ordertproduct->quantity * $ordertproduct->order_price);
							// }
                        ?>
                            <tr>
                                <td class="text-center">{{$c++}}</td>
                                @if($order->status == 'cancelled')
                                    <td class="text-center" style="background-color: red;">
                                        <a href="{{route('deliverinvoice',
									['orderid' => $order->porderid])}}" target="_blank">
                                        {{sprintf('%010d', $order->invoice_no)}}
                                        <!-- {{IdController::nO($order->invoice_no)}} -->
                                        </a></td>
								@else

                                    <td class="text-center" style="background-color: yellow;">
                                        <a href="{{route('deliverinvoice',
									['orderid' => $order->porderid])}}" target="_blank">

                                        <!-- {{IdController::nO($order->invoice_no)}} -->
                                            {{sprintf('%010d', $order->invoice_no)}}
                                        </a></td>
								@endif
                                <td class="text-center">
									{{UtilityController::s_date($order->created_at)}}</td>
								<td class="text-center">
                                         {{$order->companyname}}
									{{--IdController::nSeller($order->buyer_id)--}}</td>
                                <td class="text-right p">
									{{$currency->code.'&nbsp;'.
									number_format(($order_price / 100) , 2,'.',',')}}</td>
								
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
