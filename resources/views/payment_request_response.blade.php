@extends("common.default")
@section("extra-links")
<link href="{{url('jqGrid/ui.jqgrid.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('css/datatable.css')}}" rel="stylesheet" type="text/css"/>
@stop
@section("content")

<div class="container"><!--Begin main cotainer-->
	<div class="row">
		<div class="table-responsive col-sm-12 ">
		    <table class="table table-bordered text-muted " id="paymentRequest">
		    	<thead>
			        <tr class="bg-success">
			            <th colspan="100">Request Details</th>
			        </tr>
			        <tr class="bg-success">
			            <td>No</td>
			            <td>Payment ID</td>
			            <td>Merchant Code</td>
			            <td>Ipay88 Payment ID</td>
			            <td>Ref No</td>
			            <td>Amount</td>
			            <td>Currency</td>
			            <td>Description</td>
			            <td>Username</td>
			            <td>Email</td>
			            <td>Contact</td>
			            <td>Remark</td>
			            <td>Lang</td>
			            <td>Signature</td>
			            <td>Response URL</td>
			            <td>Backend URL</td>
			        </tr>
		    	</thead>
		    	<tbody>
		    		@foreach($payment_requests as $payment_request)
			        <tr class="bg-white">
			            <td>{!! $payment_request->id !!}</td>
			            <td>{!! $payment_request->payment_id !!}</td>
			            <td>{!! $payment_request->merchant_code !!}</td>
			            <td>{!! $payment_request->ipay88_payment_id !!}</td>
			            <td>{!! $payment_request->ref_no !!}</td>
			            <td>{!! $payment_request->amount !!}</td>
			            <td>{!! $payment_request->currency !!}</td>
			            <td>{!! $payment_request->prod_desc !!}</td>
			            <td>{!! $payment_request->user_name !!}</td>
			            <td>{!! $payment_request->user_email !!}</td>
			            <td>{!! $payment_request->user_contact !!}</td>
			            <td>{!! $payment_request->remark !!}</td>
			            <td>{!! $payment_request->lang !!}</td>
			            <td>{!! $payment_request->signature !!}</td>
			            <td>{!! $payment_request->response_url !!}</td>
			            <td>{!! $payment_request->backend_url !!}</td>
			        </tr>
			        @endforeach
		    	</tbody>
		    </table>
		</div>
	</div>
	<br><br><br><br>
    <div class="row">
		<div class="table-responsive col-sm-12 ">
		    <table class="table table-bordered text-muted " id="paymentResponse">
		    	<thead>
			        <tr class="bg-primary">
			            <th colspan="100">Response Details</th>
			        </tr>
			        <tr class="bg-primary">
			            <td>ID</td>
			            <td>Payment ID</td>
			            <td>Merchant Code</td>
			            <td>Ipay88 Payment ID</td>
			            <td>Ref No</td>
			            <td>Amount</td>
			            <td>Currency</td>
			            <td>Remark</td>
			            <td>Trans ID</td>
			            <td>Auth Code</td>
			            <td>Status</td>
			            <td>Error Description</td>
			            <td>Signature</td>
			        </tr>
		    	</thead>
		    	<tbody>
		    		@foreach($payment_responses as $payment_response)
			        <tr class="bg-white">
			            <td>{!! $payment_response->id !!}</td>
			            <td>{!! $payment_response->payment_id !!}</td>
			            <td>{!! $payment_response->merchant_code !!}</td>
			            <td>{!! $payment_response->ipay88_payment_id !!}</td>
			            <td>{!! $payment_response->ref_no !!}</td>
			            <td>{!! $payment_response->amount !!}</td>
			            <td>{!! $payment_response->currency !!}</td>
			            <td>{!! $payment_response->remark !!}</td>
			            <td>{!! $payment_response->trans_id !!}</td>
			            <td>{!! $payment_response->auth_code !!}</td>
			            <td>{!! $payment_response->status !!}</td>
			            <td>{!! $payment_response->err_desc !!}</td>
			            <td>{!! $payment_response->signature !!}</td>
			        </tr>
			        @endforeach
		    	</tbody>
		    </table>
		</div>
	</div>
</div>
@stop

@section('scripts')
<script src="{{url('js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{url('jqGrid/jquery.jqGrid.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function(){
       $('#paymentRequest').DataTable();
       $('#paymentResponse').DataTable();
})
</script>
@stop
