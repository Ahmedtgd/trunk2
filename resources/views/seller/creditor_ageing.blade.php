@extends("common.default")
<?php 
define('MAX_COLUMN_TEXT', 20);
use App\Http\Controllers\IdController;
?>
@section("content")
@include('common.sellermenu')
<section class="">
  <div class="container">
	<div class="row">
	<div class="col-sm-12">  
	<div id="employees">
		<div class="row">
			@include('seller.ageingTabs')
			<div class=" col-sm-6">
				<h2>Creditor Ageing Report</h2>

			</div>
			<div class=" col-sm-6">
				<h3 align="right">Total Amount: {{$currentCurrency}} <span id="toamt"></span></h3>
			</div>
		</div>
		<?php 
			$e=1;
			$totalamt=0;
		?>
		<div class="row">
			<div class=" col-sm-12">
				<table class="table table-bordered"
					id="invoices-table" width="100%">
					<thead>
					
					<tr class="bg-ageing">
						<th class="text-center bsmall">No.</th>
						<th class="text-center">Document&nbsp;No.</th>
						<th class="large text-center">Merchant&nbsp;ID</th>
						<th class="large text-center">Name</th>
						<th class="text-center">Payable</th>
						<th class="text-center">Mode</th>
						<th class="text-center">Payment</th>
						<th  style="background-color: green;" class="text-center">Status</th>
						<th class="text-center" style="background-color: #FF6600">Balance</th>
					</tr>
					</thead>					
					<tbody>
					@foreach($invoices as $inv)
						<tr>
							<td class="text-center">{{$e}}</td>
							<td class="text-center">
								<a href="{{ url('/') }}/invoice/{{$inv['oid']}}" target="_blank">{{str_pad($inv['invoice_no'],10,"0",STR_PAD_LEFT)}}</a>
							</td>
							<td class=""> 
								{{IdController::nM($inv['merchant_id'])}}
							</td>
							<td class="text-center">
								{{$inv['merchant_name']}}
							</td>
							<td class="text-right">
								{{$currentCurrency}} {{ number_format($inv['total']/100,2) }}
							</td>
							<td class="text-center">
								{{ ucfirst($inv['mode']) }}
							</td>
							<td class="text-center">
								<a href="{{ url('/') }}/seller/balance/{{$inv['oid']}}/{{$inv['uid']}}" target="_blank"> 
									{{ ucfirst($inv['invoice_payment']) }}
								</a>
							</td>
							<td class="text-center">
								<a href="{{ url('/') }}/seller/ageing/{{$inv['oid']}}/{{$inv['uid']}}" target="_blank"> 
									{{ ucfirst($inv['invoice_status']) }}
								</a>
							</td>
							<td class="text-right">
								<a href="{{ url('/') }}/seller/creditor_balance/{{$inv['oid']}}/{{$inv['uid']}}" target="_blank">
									{{$currentCurrency}} {{ number_format(($inv['total'] - $inv['paid'])/100,2) }}
									<?php $totalamt += ($inv['total'] - $inv['paid'])/100; ?>
								</a>
							</td>
						</tr>
					<?php $e++;?>
					@endforeach
					</tbody>
				</table>
				<input type="hidden" value="{{$e}}" id="nume" /> 
				<input type="hidden" value="{{$selluser->id}}" id="lpeid" />
				<input type="hidden" value="{{$totalamt}}" id="totalamt" />
		</div>
		</div>    
	</div>
	</div>
	</div>
 </div>
</section>
<script type="text/javascript">
	function firstToUpperCase( str ) {
		return str.substr(0, 1).toUpperCase() + str.substr(1);
	}

	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}
	
	
	
    $(document).ready(function(){
		var ramt = js_number_format(parseFloat($("#totalamt").val()),2,'.',',');
		$("#toamt").html(ramt);
		var emp_table = $('#invoices-table').DataTable({
            "order": [],
			 "columns": [
					{ "width": "20px", "orderable": false },
					{ "width": "120px" },
					{ "width": "120px" },
					{ "width": "120px" },
					{ "width": "120px" },
					{ "width": "120px" },
					{ "width": "120px" },
					{ "width": "120px" },
					{ "width": "120px" },
				]
			});		

		$(document).delegate( '.memberchek', "click",function (event) {
			if($(this).prop('checked')){
				$('.memberchek').prop('checked',false);
				$(this).prop('checked',true);
			}
		});				
			
		$(document).delegate( '.view-employee-modal', "click",function (event) {
	//	$('.view-employee-modal').click(function(){

		var user_id=$(this).attr('data-id');
		var check_url=JS_BASE_URL+"/admin/popup/lx/check/user/"+user_id;
		$.ajax({
				url:check_url,
				type:'GET',
				success:function (r) {
				console.log(r);

				if (r.status=="success") {
				var url=JS_BASE_URL+"/admin/popup/user/"+user_id;
						var w=window.open(url,"_blank");
						w.focus();
				}
				if (r.status=="failure") {
				var msg="<div class=' alert alert-danger'>"+r.long_message+"</div>";
				$('#employee-error-messages').html(msg);
				}
				}
			});
		});		
    });
</script>
@stop
