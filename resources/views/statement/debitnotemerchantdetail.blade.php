<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
use App\Classes;
?>
<?php $i = 0;$c = 1;?>
<style>
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
       
</span>
     <div id="" class="tab-content">
         <div id="sell" class="tab-pane fade in active">
            <table class="table-bordered"  id="sellTableissued" width="100%">
                <thead style="background-color: #F29FD7;color:white">
                    <tr class="bg-ageing">
                        <th class="text-center">No</th>
                        <th class="text-center">Debit Note</th>
                        <th class="text-center">Date</th>
						            <!-- <th class="text-center">Station&nbsp;ID&nbsp;</th> -->
                        <th class="text-center">Company Name</th>
                        <th class="text-center">Amount&nbsp;({{$currentCurrency}})</th>
                    </tr>
                </thead>
                <tbody>   
                @foreach($porders as $order)
                <?php
                        $order_price =$order->total ;
                        ?>
                    <tr>
                    <td class="text-center">{{$c++}}</td>
                    <td class="text-center"><a href="/view_debit_notes/{{$order->id}}?dealer_id={{$order->dealer_user_id}}" class="view_debit_notes1" >{{sprintf('%010d', $order->debitnote_no)}}</td>
                    <td class="text-center">{{UtilityController::s_date($order->created_at)}}</td>
                    <td class="text-center"> {{$order->company_name}}</td>
                    <td class="text-center">{{$currency->code.'&nbsp;'.
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
	$('#sellTableissued').dataTable().fnDestroy();
	$('#sellTableissued').DataTable({
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
