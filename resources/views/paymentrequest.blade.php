@extends("common.default")

@section("content")

<div class="container"><!--Begin main cotainer-->
    <div class="row">
		<div class="table-responsive col-sm-12 ">
		    <table class="table table-bordered text-muted " id="p-detailT">
		    	<thead>
			        <tr class="bg-black">
			            <th colspan="100">Request Details</th>
			        </tr>
			        <tr class="bg-black">
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
</div>


@stop