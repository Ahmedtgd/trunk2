<?php
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;

$total=0;$c=1;
?>
<h3>{{$month}} {{$year}}</h3>
<table id="smdt" cellspacing="0" class="table table-striped" width="100%">
    <thead>
    <tr class="bg-caiman">
        <th class="text-center">Date</th>
        <th class="text-center">Sales Memo Number</th>
        <th class="text-center">Total</th>     
    </tr>
    </thead>

    <tbody>
	@if(isset($memos))
		@foreach($memos as $p)
		<tr>
		<td class="text-center">
			@if(isset($p->created_at))
				{{UtilityController::s_date($p->created_at,true)}}
			@endif
		</td>

		<td class="text-center" style="
			<?php
			if($p->status=="voided"){
				echo "background-color:red";
			}else{
				echo "background-color:yellow";
			} 
			?>
		"> 
			<a href="{{route('Salesmemo', ['id' => $p->id])}}"
				target="_blank"> {{UtilityController::nsid($p->salesmemo_no,10,"0")}}
			</a>
		</td>
	
		<td style="text-align: right;">
			 {{$currentCurrency}}&nbsp;{{number_format($p->total/100,2)}}
		</td>
		</tr>
		<?php $c+=1; ?>
		@endforeach
	@endif
    </tbody>
</table>

<script type="text/javascript">
  $(document).ready(function(){
    var id="#trModalLabel2";
    $(id).text('Tracking Report List');
    $('#smdt').DataTable({
		 "order": [],
		 fixedHeader: {
			footer: true
		},
		/* "scrollX":true,*/
		});

	$("#smmonthly").text("{{$sale["month"]}}");
	$("#smdaily").text("{{$sale['day']}}");
  });
</script>
