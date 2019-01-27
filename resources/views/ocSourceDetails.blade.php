<?php use App\Http\Controllers\IdController;?>
@if(!is_null($results))

<table class="table table-responsive table-bordered" id='sourceTable'>
    <tbody>
        <tr>
            <th>ID</th>
			@if($results['source'] == 'smm')
				[{{ str_pad($results['id'], 10, '0', STR_PAD_LEFT) }}]
			@elseif($results['source'] == 'openwish')
				<td>{{IdController::nOw($results['id'])}}</td>
			@elseif($results['source'] == 'hyper')
				<td>{{IdController::nH($results['id'])}}</td>
			@elseif($results['source'] == 'cre')
				<td>{{IdController::nCre($results['id'])}}</td>
			@endif
        </tr>

        <tr>
            <th>User ID</th>
            <td> 
                <a href="{{ route('userPopup', ['id' => $results['userID']]) }}" target="_blank">
				{{IdController::nB($results['userID'])}}
                </a>
            </td>
        </tr>

        <tr>
            <th>Product ID</th>
            <td> 
            @if(!is_null($orderproducts))
                @foreach($orderproducts as $op)
                <a href="{{ route('productconsumer', $op->product_id) }}" target="_blank"> 
                    {{IdController::nP($op->product_id) }}
                </a>
                @endforeach
            @else
                <a href="{{ route('productconsumer', $results['productID']) }}" target="_blank"> 
                    {{IdController::nP($results['productID']) }}
                </a>
            @endif
            </td>
        </tr>

        @if($results['source'] == 'smm')
        <tr>
            <th>Commissions</th>
            <td>{{ $currency }} {{ number_format($results['commission'], 2) }}</td>
        </tr>

        <tr>
            <th>Connections</th>
            <td>{{ $results['connection'] }}</td>
        </tr>
        @elseif($results['source'] == 'openwish')
        <tr>
            <th>Bought Amount</th>
            <td>{{ $currency }} {{ number_format($results['pamount']/100, 2) }}</td>
        </tr>

        <tr>
            <th>Duration</th>
            <td>{{ $results['duration'] }}</td>
        </tr>
        @elseif($results['source'] == 'hyper')
        <tr>
            <th>Bought Amount</th>
            <td>{{ $currency }} {{ number_format($results['pamount']/100, 2) }}</td>
        </tr>

        <tr>
            <th>Price</th>
            <td>{{ $currency }} {{ number_format($results['price']/100, 2)}}</td>
        </tr>

        <tr>
            <th>Duration</th>
            <td>{{ $results['duration'] }}</td>
        </tr>
        @elseif($results['source'] == 'cre')
        <tr>
            <th>Value</th>
            <td>{{ $currency }} {{ $results['value'] }}</td>
        </tr>

        <tr>
            <th>Type</th>
            <td>{{ $results['type'] }}</td>
        </tr>
			
			<tr>
				<th>Reason</th>
				<td>
					@if($results['creason'] > 0)
						<a href="">
							[{{ str_pad($results['creason'], 10, '0', STR_PAD_LEFT) }}]
						</a>
					@endif
				</td>
			</tr>
			
        @endif
        <tr>
            <th>Status</th>
            <td>{{ ucfirst($results['status']) }}</td>
        </tr>
    </tbody>
</table>
@endif


