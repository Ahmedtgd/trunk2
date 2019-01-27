@extends("common.default")
@section("extra-links")
<style type="text/css">
	.thead th{
		text-align: center;
	}
</style>
@stop
@section("content")

<div class="container"><!--Begin main cotainer-->
	<div class="row">
		<div class="table-responsive col-sm-12 ">
		    <table class="table table-condensed table-bordered text-muted " id="paymentRequest">
		    	<thead>
			        <tr class="bg-success">
			            <th colspan="100">Request Details</th>
			        </tr>
			        <thead>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td colspan=100 class='text-center'>Payment Out</td>
						</tr>
						<tr class='thead'>
							<th>No</th>
							<th>Order ID</th>
							<th>User</th>
							<th>Merchant</th>
							<th>Product ID</th>
							<th>Payment In</th>
							<th>Delivered</th>
							<th>Receipt</th>
							<th>OpenSupermall</th>
							<th>Merchant</th>
							<th>MC</th>
							<th>SMM</th>

						</tr>
					</thead>

					<tbody>
						<tr data-toggle="collapse" data-target=".demo" class="accordion-toggle">
							<td>1</td>
							<td>
								<button class="btn btn-default btn-xs"><i class="fa fa-chevron-right"></i></button>
								000032
							</td>
							<td>0000874 Squidster</td>
							<td></td>
							<td></td>
							<td class='text-right'>409.36</td>
							<td class='text-center'></td>
							<td class='text-center'></td>
							<td class='text-right'>40.94</td>
							<td>
								<span class='pull-left'><input type='checkbox'></span>
								<span class='pull-right text-right'>368.62</span>
							</td>
							<td>
								<span class='pull-left'><input type='checkbox'></span>
								<span class='pull-right text-right'>1,000</span>
							</td>
							<td>
								<span class='pull-left'><input type='checkbox'></span>
								<span class='pull-right text-right'>4.09</span>
							</td>
						</tr>
						<tr class="hiddenRow accordian-body collapse demo" id="demo1">
							<td></td>
							<td></td>
							<td></td>
							<td>0000434 Dyson</td>
							<td>00295 Widget</td>
							<td class='text-right'>44.23</td>
							<td class='text-center'>09/23/15</td>
							<td class='text-center'>09/23/15</td>
							<td class='text-right'>4.42</td>
							<td>
								<span class='pull-left'><input type='checkbox'></span>
								<span class='pull-right text-right'>368.62</span>
							</td>
							<td>
								<span class='pull-left'><input type='checkbox'></span>
								<span class='pull-right text-right'>1,000</span>
							</td>
							<td>
								<span class='pull-left'><input type='checkbox'></span>
								<span class='pull-right text-right'>4.09</span>
							</td>
						</tr>
						<tr class="hiddenRow accordian-body collapse demo" id="demo1">
							<td></td>
							<td></td>
							<td></td>
							<td>0000434 Dyson</td>
							<td>00295 Widget</td>
							<td class='text-right'>44.23</td>
							<td class='text-center'>09/23/15</td>
							<td class='text-center'>09/23/15</td>
							<td class='text-right'>4.42</td>
							<td>
								<span class='pull-left'><input type='checkbox'></span>
								<span class='pull-right text-right'>368.62</span>
							</td>
							<td>
								<span class='pull-left'><input type='checkbox'></span>
								<span class='pull-right text-right'>1,000</span>
							</td>
							<td>
								<span class='pull-left'><input type='checkbox'></span>
								<span class='pull-right text-right'>4.09</span>
							</td>
						</tr>
						<tr class="hiddenRow accordian-body collapse demo" id="demo1">
							<td></td>
							<td></td>
							<td></td>
							<td>0000434 Dyson</td>
							<td>00295 Widget</td>
							<td class='text-right'>44.23</td>
							<td class='text-center'>09/23/15</td>
							<td class='text-center'>09/23/15</td>
							<td class='text-right'>4.42</td>
							<td>
								<span class='pull-left'><input type='checkbox'></span>
								<span class='pull-right text-right'>368.62</span>
							</td>
							<td>
								<span class='pull-left'><input type='checkbox'></span>
								<span class='pull-right text-right'>1,000</span>
							</td>
							<td>
								<span class='pull-left'><input type='checkbox'></span>
								<span class='pull-right text-right'>4.09</span>
							</td>
						</tr>
				</tbody>
		    </table>
		</div>
	</div>
</div>
       

	<br><br><br><br>
    
</div>
@stop

@section('scripts')
$(document).ready(function(){
})
</script>
@stop