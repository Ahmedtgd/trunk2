<?php
use App\Classes;
define('MAX_COLUMN_TEXT', 20);
?>
@extends("common.default")

@section("content")
 
<?php $i=1; ?>
@section("content")
    <div class="container" style="margin-top:30px;">
	
	@include('admin/panelHeading')

	<h2>Merchant Professional Detail</h2>
	<div class="table-responsive">
		<table class="table table-bordered" cellspacing="0" width="100%" id="gridmerchant">
			<thead style="background-color: #1B767C; color: white;">
                <tr>
					<th class="no-sort text-center bsmall">No</th>
					<th class="no-sort text-center blarge">Merchant</th>
					<th class="text-center medium">Order&nbsp;ID</th>
					<th class="text-center blarge">Revenue</th>
					<th class="text-center blarge" >Rate</th>
					<th style="background-color:black;color:white"
						class="text-center blarge" >Outstanding</th>	
				</tr>
			</thead>
			@if(isset($mcp) && is_array($mcp) && count($mcp))
				<tbody>
				@def $i = 1
				@foreach($mcp as $key => $mp)
					@if(!is_null($mp->revenue) && $mp->revenue > 0)
					<tr>
						<td class='text-center'>{!! $i++ !!}</td>
						<td class='text-center'>
							<a href="{{route('merchantPopup', ['id' => $mp->merchant_id])}}" target="popup" onclick="window.open('{{route('merchantPopup', ['id' => $mp->merchant_id])}}','popup', 'scrollbars=1','width=600,height=600'); return false;">
								[{{str_pad($mp->merchant_id,10,0,STR_PAD_LEFT)}}]
							</a>	
						</td>
						<td  class='text-center'>
							<a href="{{route('deliverorder', ['id' => $mp->order_id])}}" target="popup" onclick="window.open('{{route('deliverorder', ['id' => $mp->order_id])}}','popup', 'scrollbars=1','width=800,height=600'); return false;">
								[{{str_pad($mp->order_id,10,0,STR_PAD_LEFT)}}]
							</a>							   
						</td>
						<td>
							<span class="pull-left">
								MYR
							</span>                                                      
							<span class="pull-right">
							@if(!is_null($mp->revenue))
								{{ number_format($mp->revenue/100,2) }}
							@endif
							</span>						   
						</td> 

						<td class='com text-center'>
							{{$mp->rate}}%
						</td>
						<td >
							<span class="pull-left">
								MYR
							</span>                                                      
							<span class="pull-right">
							@if(!is_null($mp->revenue))
								{{ number_format(($mp->revenue*($mp->rate/100))/100,2) }}
							@endif
							</span>								
						</td>						
					</tr>
					@endif
				@endforeach
				</tbody>
			@endif			
		</table>
	</div>
</div>
 

    <script type="text/javascript">
        $(document).ready(function() {
            $('#gridmerchant').DataTable({
                "scrollX": true,
                'aoColumnDefs': [{
                    'bSortable': false,
                    'aTargets': ['nosort']
                }]
            });

 
            
        })
    </script>

    @yield('left_sidebar_scripts')
@stop

