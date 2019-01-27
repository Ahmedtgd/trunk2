<!DOCTYPE html>
<?php
use App\Http\Controllers\UtilityController;
?>
<html>
<head>
	<title>NinjaVan</title>
	<style type="text/css">
		table.center {
		margin-left:auto; 
		margin-right:auto;
	}
	.right{
		position:relative;
		margin-right: -200px;
	}
	.border{
		border: 1px solid black;
	}
	.center:{
		text-align: center;
	}
	div.page {
		page-break-after: always;
		page-break-inside: avoid;
	}
	</style>
</head>
<body style="margin-left: auto;margin-right: auto;width:1300px;">
	<?php
	$i=0; $total=sizeof($data['parcels']);
	?>
	@foreach($data['parcels'] as $par)
	<div  class="border" style="margin-left: auto;margin-right: auto;width:99%;">
		<table style="width: 100%;" class="center">
			<tr>
				<td>
					<img src="{{asset('ninjavan/'.$data['order_id']."/".$par->nv_tracking_id."_qr.png")}}" height="150px" width="150px">
				
				</td>
				<td><div><div style="font-size:3em;font-weight: bold;">Ninja Van</div>
				<span style="text-align:center;margin-top: -10px;">AIRWAY BILL www.ninjavan.co</span></div>
				</td>
				<td><div>
				{{$par->nv_tracking_id}}<br>
				<img src="{{asset('ninjavan/'.$data['order_id']."/".$par->nv_tracking_id."_bc.png")}}" height="100px" width="740px"
					class="right">&nbsp;&nbsp;<br>

				</div></td>
			</tr>
			</table>
			<table  style="width: 100%;" class="center">
			<tr>
				<td  class="border" width="45%;"><div style="border-bottom: 1px solid black;">FROM(SENDER)</div>
				<p></p>
				<table>
					<tr>
						<td><strong>Name: </strong></td>
						<td>
						@if($data['type']=="m2b"){{$data['merchant']->company_name}}@else {{$data['user']->name}} @endif</td>
					</tr>
					<tr>
						<td><strong>Contact: </strong></td>
						<td>@if($data['type']=="m2b"){{$data['merchant']->contact_person}}@else {{$data['user']->mobile_no}}@endif</td>
					</tr>
					<tr>
						<td><strong>Address:</strong></td>
						<td>{{$data['mAdd']->line1}}
					</tr>
					<tr><td></td>
						<td>{{$data['mAdd']->line2}}</td>
					</tr>
					@if($data['mAdd']->line3!="")
					<tr><td></td>
					<td>{{$data['mAdd']->line3}}</td>
					@endif
					<tr><td></td>
					<td>{{$data['mAdd']->city}},<br>{{$data['mAdd']->state}}
							<br>Malaysia -{{$data['mAdd']->postcode}}
						</td>
					</tr>
				</table>
				</td>
			
				<td width="5%"></td>
				<td class="border"  width="45%;"><div style="border-bottom: 1px solid black;">TO(ADDRESSEE)</div>
				<p></p>

				<table>
					<tr>
						<td><strong>Name: </strong></td>
						<td>@if($data['type']=="b2m")
							{{$data['merchant']->company_name}}
						@else{{$data['user']->name}}@endif</td>
					</tr>
					<tr>
						<td><strong>Contact: </strong></td>
						<td>@if($data['type']=="b2m"){{$data['merchant']->contact_person}}@else{{$data['user']->mobile_no}}@endif</td>
					</tr>
					<tr>
						<td><strong>Address:</strong></td>
						<td>{{$data['bAdd']->line1}}</td>
					</tr>
					<tr>
						<td></td>
						<td>{{$data['bAdd']->line2}}</td>
					</tr>
					@if($data['bAdd']->line3!="")
					<tr><td></td>
					<td>{{$data['bAdd']->line3}}
					</td>
					</tr>
					@endif
					<tr>
						<td></td>
						<td>{{$data['bAdd']->city}},<br>{{$data['bAdd']->state}}
					<br>Malaysia -{{$data['bAdd']->postcode}}</td>
					</tr>
				</table>
		
	
				</td>
			</tr>
			<tr>
				<td class="border"><div style="height: 40px;">COD: </div></td>
				<td style="width: 5px;"></td>
				<?php
				$d_date=strtotime($par->nv_delivery_date);
				$d_date=date("dMY ",$d_date);
				
				?>
				<td class="border"><div style="height: 40px;">Deliver By:&nbsp;{{$d_date or "--"}}</div></td>
			</tr>

		</table>
		<table style="width:100%;" class="center">
			<tr >
				<?php $j=$i+1;?>
				<td class="border"><div style="border-bottom: 1px solid black;"><strong>Comments:</strong></div>
				<div style="height: 50px;">Order Id: <strong>{{$data['forder_id']}}</strong><br>
				Parcel <strong>{{$j}}</strong> of <strong>{{$total}}</strong>
				</div>
				</td>
				<?php $i++;?>
			</tr>
		</table>
		</div>
		@if($i%3==0)
		<div class="page"></div>
		@endif
	@endforeach
</body>
</html>
