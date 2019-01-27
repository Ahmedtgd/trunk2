<div class="modal-content">
    <div class="modal-header bg-gator"
	style="border-top-left-radius:5px;border-top-right-radius:5px">
        <button type="button" class="close"
        style="margin-top:0;padding-top:10px"
        data-dismiss="modal"
        aria-label="Close">
        <span aria-hidden="true">&times;
        </span></button>

        <h2 class="modal-title"
        id="smModalLabel2">Sales Order

        <!-- START STATS Table -->
        <span style="font-size:14px !important;"
        class="pull-right">
			<table>
            <tr style="font-weight:bold">
                <td class="text-right">Monthly:</td>
                <td class="text-center">
                &nbsp;{{$currentCurrency}}&nbsp;</td>
                <td class="text-right">
                    <span class="monthlysales">0</span></td>
			</tr>
            <tr style="font-weight:bold">
				<td class="text-right">Today:</td>
				<td class="text-center">
				&nbsp;{{$currentCurrency}}&nbsp;</td>
				<td style="text-align:right">
					<span class="todaysales" >0</span></td>
			</tr>
			</table>
            </span>
            <!-- END STATS Table -->
        </h2>
    </div>
    <div class="modal-body">
        <h3 id="setmonthyear"></h3>
        <span >
            <table class="table table-bordered" id="table-id" >
                <thead class="aproducts">
                    <tr class="bg-gator">
                        <th class="text-center no-sort" width="20px"
                        style="width: 20px !important;">No</th>
                        <th class="text-center">Sales&nbsp;Order&nbsp;No</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Company&nbsp;Name</th>
                        <th class="text-center">Amount&nbsp;(MYR)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  $count=1; ?>
                    @foreach($porder as $p)
                    <?php $total = $p->quantity * $p->price/100;  ?>
                    <tr>
                        <td class="text-center" width="5%">{{$count}}</td>
                        @if($p->status == 'cancelled')

                            <td class="text-center" width="15%" style="background-color: red;">
                         <a target="_blank"
                            href="{{URL::to('DO/displaysalesorderdocument',$p->id)}}">
                         {{sprintf('%010d', $p->salesorder_no)}}</a></td>
                        @else
                            <td class="text-center" width="15%" style="background-color: yellow;">
                         <a target="_blank"
                            href="{{URL::to('DO/displaysalesorderdocument',$p->id)}}">
                         {{sprintf('%010d', $p->salesorder_no)}}</a></td>
                        @endif
                         <td class="text-center">{{date('dMy H:i:s', strtotime($p->created_at))}}</td>
						 <td class="text-left" width="35%">
						 	@if($p->is_emerchant == 1)
                            {{\App\Models\Emerchant::find($p->user_id)['company_name']}}
                            @else
                            {{\App\Models\Merchant::where('user_id',$p->user_id)->pluck('company_name')}}
							@endif
						</td>
                        <td style="text-align: right;">{{number_format($p->price/100,2)}}</td>
                    </tr>
                    <?php  $count++; ?>
                    @endforeach
                </tbody>
            </table>
        </span>
    </div>
	<!--

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"
			style="min-width: 60px;">Close</button>
    </div>
	-->
	<br>
</div>
<script type="text/javascript">
 $('#table-id').DataTable({
    "order": [],

});

$(".monthlysales").text("{{number_format($monthly_sales/100,2)}}");
$(".todaysales").text("{{number_format($todaysales/100,2)}}");
</script>
