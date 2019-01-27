@extends("common.default")

@section('opengraph')

<meta property="og:title" content="OpenWish! {{$product->name}}" />
<meta property="og:image" content="{{asset('/images/product/'.$product->id)}}/{{$product->photo_1 }}" />
<meta property="og:type" content="website"/>
<meta property="og:description" content="Help your friend buy it. {{$product->description}}" />
<meta property="og:url" content="{{url()."/productconsumer/".$product->id."/"."$openwish_id"}}" />

@stop
@section("content")

    <div class="container">
        <div class="row">

            <div class="col-md-8 col-md-offset-2">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div style="border:1px solid #ddd; padding:1px;">
                    <a href="{{ route('productconsumer', [$product->id]) }}">
					<img src="/images/product/{{ $product->id }}/{{ $product->photo_1 }}"
					style="height:300px; width:300px; object-fit:contain; padding-bottom: 1px;" alt=""/></a>

                    <div style="padding: 20px;">
                        <h3>{{ $product->merchant->first()->oshop_name }}
						{{-- <small>oshop name</small> --}}
                        </h3>
                        <h4>{{ $product->name }} 
                        {{-- <small>product name</small> --}}
                        </h4>
						<?php
						use App\Http\Controllers\UtilityController;
                        $price=UtilityController::realPrice($product->id);
						?>
                        <p>
							<table>
							<tr><td>Price:</td>
							<td style="text-align:right">{{$currentCurrency}} {{number_format($price/100,2)}}</td></tr>
                       
                            <tr><td width="175px">Accumulated:</td>
							<td style="text-align:right">{{$currentCurrency}} {{number_format($pledged_amt/100,2)}}</td></tr>
							<tr><td></td><td></td></tr>
                            <tr><td>Balance:</td>
                            
							<td style="text-align:right">{{$currentCurrency}} {{number_format(($price-$pledged_amt)/100,2)}}</td></tr>
							</table>
                        </p>
                        <div class="row">
                            <div class="col-md-6">
                                <a href="https://www.opensupermall.com">https://www.opensupermall.com</a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{url()}}" style="line-height: 85px;">
                                    <img src="{{asset('images/logo.png')}}" alt="" class="img-responsive"/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {!! Form::open(array('route' => ['oauth.postPledge', $openwish_id])) !!}
				<br>
                <div class="form-group">
                @if($pledgeAllowed == 1)

					<label for="amount_pledge">Please click here to buy for OpenWisher</label>
		            <div class="input-group">
					<span class="input-group-addon">MYR</span>
                    <input style = "width:40%;display:inline;height: 4.6em;" type="text"
					name="pledged_amt" class="form-control" id="pledged_amt" max="{{$max_amount}}" min="0" />
			
					<button type="submit" class="cartBtn btn btn-openwish" id="ow_submit" style="height: 4.3em !important;font-size: 1.1em;width: 100px;">
					ADD</button>
                   {{--  <label for="amount_pledge">OpenWish Discount Coupon</label> --}}

                    </div>
					
                @else
                This OpenWish is no longer accepting contributions.

                @endif
                <span id="ow_error_message" class="text-warning"></span>
                </div>

                <input type="hidden" name="product_id"
					value="{{$product->id}}" />

                

                {!! Form::close() !!}
            </div>
        </div>
        <div class="row">
         <div class="col-md-2 col-md-offset-2">
                <div class="form-group">
                    <label>Your name!</label>
                    <input type="text" name="custom_name" class="form-control" value="" style="height: 3.3em">
                </div>
            </div>

            <div class="col-md-4 col-md-offset-2">
                <div class="form-group">
                    <label>Message for your friend!</label>
                    <input type="text" name="custom_message" class="form-control" value="Hi , I just  helped you!" style="height: 3.3em;">
                </div>
            </div>
        </div>
    </div>
	{{-- <br><br> --}}
    <script type="text/javascript">
        $(document).ready(function(){
            $('#pledged_amt').number(true,2);
            $('#ow_submit').click(function(){
                $(this).preventDefault();
            });
        });

    </script>

@endsection
