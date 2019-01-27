@extends("common.default")

@section("content")

<div class="container"><!--Begin main cotainer-->
    <div class="row">
		<div class="table-responsive col-sm-12 ">
		    <table class="table table-bordered text-muted " id="p-detailT">
		    	<thead>
			        <tr class="bg-black">
			            <th colspan="100">Response Details</th>
			        </tr>
			        <tr class="bg-black">
			            <td>No</td>
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