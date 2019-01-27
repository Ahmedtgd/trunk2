@extends("common.default")
@section("extra-links")
<style type="text/css">
	.thead th{
		text-align: center;
	}
	.red{
		background: #FC0000;
		color: #fff;
	}
	.orange{
		background: #FF6600;
		color: #fff;
	}
	.violet{
		background: #604A7B;
		color: #fff;
	}

	.sub-menu {
		float: right;
		cursor: pointer;
		margin-right: 30px;
		margin-top: 8px;
		font-size: 15px;
	}

	.commission_fields{
		width: 70px;
		text-align: right;
	}

	.colm{
		cursor: text;
		background: #ddd;
	}
</style>
@stop
@section("content")

<br><br>
<div class="container">
	<h1>Admin Commission View</h1> <br>
	
	<div class="row">
		<div class="table-responsive col-sm-12 ">
		    <table class="table table-condensed table-bordered text-muted " id="paymentRequest">
		    	<thead>
			        <tr class="bg-success">
			            <th colspan="100" class='text-center' style='font-weight: 900; font-size: 20px; color: #fff' >
			            	Account Information
			            	<span><i class="fa fa-bars sub-menu"></i></span>
			            </th>
			        </tr>
			        <thead>
						<tr class='thead' style='color: #111'>
							<th class='red'>No</th>
							<th class='red'>O-Shop&nbsp;ID</th>
							<th class='red'>Commission</th>
							<th class='red'>Company</th>
							<th class='orange'>MC</th>
							<th class='orange'>ID</th>
							<th class='orange'>Referral</th>
							<th class='orange'>ID</th>
							<th class='violet'>MP1</th>
							<th class='violet'>ID</th>
							<th class='violet'>MP2</th>
							<th class='violet'>ID</th>
							<th class='violet'>PUSHER</th>
							<th class='violet'>PUSHER ID</th>
						</tr>
					</thead>
					<tbody class='text-center sub'>
						<?php $i=1; $j=0; ?>
						@foreach($merchants as $merchant)
							<?php 
								$mc = $merchants[$j]->mcsc * $merchants[$j]->amount/100;
								$rc = $merchants[$j]->rsc * $merchants[$j]->amount/100;
								$m1 = $merchants[$j]->m1sc * $merchants[$j]->amount/100;
								$m2 = $merchants[$j]->m2sc * $merchants[$j]->amount/100;
								$pc = $merchants[$j]->psc * $merchants[$j]->amount/100;
								$amount = $merchants[$j]->amount;
								$company = $amount - ($mc + $rc + $m1 + $m2 + $pc);
							?>
							<tr>
								<td>{!! $i++ !!}</td>
								<td>[{!! str_pad($merchants[$j]->id, 6, '0', STR_PAD_LEFT) !!}]</td>
								<td>{!! number_format($amount,2) !!}</td>
								<td>{!! number_format($company,2) !!}</td>
								<td>{!! number_format($mc,2) !!}</td>
								<td>[{!! str_pad($merchants[$j]->mcid, 6, '0', STR_PAD_LEFT) !!}]</td>
								<td>{!! number_format($rc,2) !!}</td>
								<td>[{!! str_pad($merchants[$j]->rid, 6, '0', STR_PAD_LEFT) !!}]</td>
								<td>{!! number_format($m1,2) !!}</td>
								<td>[{!! str_pad($merchants[$j]->m1id, 6, '0', STR_PAD_LEFT) !!}]</td>
								<td>{!! number_format($m2,2) !!}</td>
								<td>[{!! str_pad($merchants[$j]->m2id, 6, '0', STR_PAD_LEFT) !!}]</td>
								<td>{!! number_format($pc,2) !!}</td>
								<td>[{!! str_pad($merchants[$j]->pid, 6, '0', STR_PAD_LEFT) !!}]</td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td>{!! 100 !!}%</td>
								<td>{!! 
									100 - 
									(
										($merchants[$j]->mcsc )+($merchants[$j]->rsc )+
										($merchants[$j]->m1sc )+($merchants[$j]->m2sc )+
										($merchants[$j]->psc )
									)
									!!}%</td>
								<td class='colm'>
									<span class='commission'>{!! $merchants[$j]->mcsc !!}</span>
									<input data='{!! $merchants[$j]->id !!}' class='mc commission_fields hidden' value='{!! $merchants[$j]->mcsc !!}'> %
								</td>
								<td></td>
								<td class='colm'>
									<span class='commission'>{!! $merchants[$j]->rsc !!}</span>
									<input  data='{!! $merchants[$j]->id !!}' class='rc commission_fields hidden' value='{!! $merchants[$j]->rsc !!}'> %
								</td>
								<td></td>
								<td class='colm'>
									<span class='commission'>{!! $merchants[$j]->m1sc !!}</span>
									<input  data='{!! $merchants[$j]->id !!}' class='m1 commission_fields hidden' value='{!! $merchants[$j]->m1sc !!}'> %
								</td>
								<td></td>
								<td class='colm'>
									<span class='commission'>{!! $merchants[$j]->m2sc !!}</span>
									<input  data='{!! $merchants[$j]->id !!}' class='m2 commission_fields hidden' value='{!! $merchants[$j]->m2sc !!}'> %
								</td>
								<td></td>
								<td class='colm'>
									<span class='commission'>{!! $merchants[$j]->psc !!}</span>
									<input  data='{!! $merchants[$j]->id !!}' class='pc commission_fields hidden' value='{!! $merchants[$j]->psc !!}'> %</td>
								<td></td>
							</tr>
						<?php $j++; ?>
						@endforeach

					</tbody>
					
		    </table>
		</div>
	</div>

	<div class="row">
		<div class="table-responsive col-sm-12 ">
		    <table class="table table-condensed table-bordered text-muted " id="paymentRequest">
		    	<thead>
			        <tr class="bg-success">
			            <th colspan="100" class='text-center' style='font-weight: 900; font-size: 20px; color: #fff' >
			            	Station Recruiter
			            	<span><i class="fa fa-bars sub-menu"></i></span>
			            </th>
			        </tr>
			        <thead>
						<tr class='thead' style='color: #111'>
							<th>No</th>
							<th>Station ID</th>
							<th>ID</th>
							<th>Name</th>
							<th>Commission</th>
						</tr>
					</thead>

					<tbody class='text-center sub'>
						<?php $i=1; $j=0; ?>
						@foreach($recruiters as $recruiter)
						<tr>
							<td>{!! $i++ !!}</td>
							<td>[{!! str_pad($recruiters[$j]->uid, 6, '0', STR_PAD_LEFT) !!}]</td>
							<td>[{!! str_pad($recruiters[$j]->mid, 6, '0', STR_PAD_LEFT) !!}]</td>
							<td>{!! $recruiters[$j]->fn !!}</td>
							<td>{!! number_format($recruiters[$j]->commission,2) !!} %</td>
						</tr>
						<?php $j++; ?>
						@endforeach
					</tbody>
		    </table>
		</div>
	</div>

		<div class="row">
		<div class="table-responsive col-sm-12 ">
		    <table class="table table-condensed table-bordered text-muted " id="paymentRequest">
		    	<thead>
			        <tr class="bg-success">
			            <th colspan="100" class='text-center' style='font-weight: 900; font-size: 20px; color: #fff' >
			            	SMM Commission
			            	<span><i class="fa fa-bars sub-menu"></i></span>
			            </th>
			        </tr>
			        <thead>
						<tr class='thead' style='color: #111'>
							<th>No</th>
							<th>Product&nbsp;ID</th>
							<th>Unit</th>
							<th>Sales Derived from SMM</th>
							<th>Commission from Merchant</th>
							<th>Revenue</th>
							<th>Allocation for SMM(%)</th>
							<th>Allocation for SMM</th>
							<th>Successful Sales Click</th>
							<th>Average=Allocation/Successful</th>
						</tr>
					</thead>

					<tbody class='text-center sub'>
						<?php $i=1; $j=0; ?>
						@foreach($smms as $smm)
						<tr>
							<td>{!! $i++ !!}</td>
							<td>[{!! str_pad($smms[$j]->pid, 6, '0', STR_PAD_LEFT) !!}]</td>
							<td>{!! $smms[$j]->unit !!}</td>
							<td>{!! number_format($smms[$j]->sdsmm,2) !!}</td>
							<td>{!! number_format($smms[$j]->commission,2) !!}</td>
							<td>{!! number_format($smms[$j]->revenue,2) !!}</td>
							<td class='colm'>
								<span class='commission'>{!! number_format($smms[$j]->asmmp,2) !!}</span>
								<input data='{!! $smms[$j]->mid !!}' class='smm commission_fields hidden' value='{!! $smms[$j]->asmmp !!}'> %
							</td>
							<td>{!! number_format($smms[$j]->asmm,2) !!}</td>
							<td>{!! $smms[$j]->sclick !!}</td>
							<td>{!! number_format($smms[$j]->average,2) !!}</td>
						</tr>
						<?php $j++; ?>
						@endforeach
					</tbody>
		    </table>
		</div>
	</div>
</div>
<br><br><br><br>
</div>
@stop

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
	$('.sub-menu').click(function(){
		$(this).parents('table').find('.sub').slideToggle();
	})

	$('.colm').click(function(){
		$(this).find('input').removeClass('hidden');
		$(this).find('span').addClass('hidden');
		$(this).css('background','#fff');
	})

	$('.mc').on('blur', function(){
		data = $(this).attr('data');
		val = $(this).val();
		$.ajax({
			url: 'edit_commission',
			type: "post",
			data: {
				id : data,
				col : 'mc',
				val : val
			},
			async: false,
			success: function(data)
			{
				if(data == 'fail'){
					alert('Value cannot be null')
				}else{
					window.location.reload();
				}
			}
		});
	})

	$('.rc').on('blur', function(){
		data = $(this).attr('data');
		val = $(this).val();
		$.ajax({
			url: 'edit_commission',
			type: "post",
			data: {
				id : data,
				col : 'rc',
				val : val
			},
			async: false,
			success: function(data)
			{
				if(data == 'fail'){
					alert('Value cannot be null')
				}else{
					window.location.reload();
				}
			}
		});
	})

	$('.m1').on('blur', function(){
		data = $(this).attr('data');
		val = $(this).val();
		$.ajax({
			url: 'edit_commission',
			type: "post",
			data: {
				id : data,
				col : 'm1',
				val : val
			},
			async: false,
			success: function(data)
			{
				if(data == 'fail'){
					alert('Value cannot be null')
				}else{
					window.location.reload();
				}
			}
		});
	})

	$('.m2').on('blur', function(){
		data = $(this).attr('data');
		val = $(this).val();
		$.ajax({
			url: 'edit_commission',
			type: "post",
			data: {
				id : data,
				col : 'm2',
				val : val
			},
			async: false,
			success: function(data)
			{
				if(data == 'fail'){
					alert('Value cannot be null')
				}else{
					window.location.reload();
				}
			}
		});
	})

	$('.pc').on('blur', function(){
		data = $(this).attr('data');
		val = $(this).val();
		$.ajax({
			url: 'edit_commission',
			type: "post",
			data: {
				id : data,
				col : 'pc',
				val : val
			},
			async: false,
			success: function(data)
			{
				if(data == 'fail'){
					alert('Value cannot be null')
				}else{
					window.location.reload();
				}
			}
		});
	})

	$('.smm').on('blur', function(){
		data = $(this).attr('data');
		val = $(this).val();
		$.ajax({
			url: 'edit_commission',
			type: "post",
			data: {
				id : data,
				col : 'smm',
				val : val
			},
			async: false,
			success: function(data)
			{
				if(data == 'fail'){
					alert('Value cannot be null')
				}else{
					window.location.reload();
				}
			}
		});
	})

})
</script>
@stop
