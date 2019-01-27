@foreach($catDetails->products as $product)
    <div class="column productbox col-md-3 col-sm-4">
		<a href="{{route('productconsumer', $product->id)}}">
        <div class="cat-img">
            
                <img class="img simg img-responsive full-width" src="/images/product/{{$product->id}}/{{$product->photo_1}}">
            
        </div></a>
		<div data-tooltip="{{$product->name}}"  class="mouseover producttitle">
			<div class="gradientEllipsis inside" >
				{{ucfirst($product->name)}}
				<div class="dimmer"></div>
			</div>
		</div>

	<div class="productprice" style="padding-top: 0;">

	<div class="pricetext" style="font-size:1em">
					@if (($product->discounted_price == $product->retail_price) || ($product->discounted_price == 0))
						@if ($product->retail_price > 0)
							<br/><strong style="font-size:1em;">
								RM{{number_format($product->retail_price/100,2)}}</strong>
						@else
							&nbsp;
						@endif
						<br/>
						<span>&nbsp;</span>
					@else
							<br/><strong style="color:black; font-size:1em;">{{$currentCurrency}}</strong><strike style="color:red"><span style="color:#333;">
							<strong style="color:black; font-size:1em;">
								{{number_format($product->retail_price/100,2)}}</strong></span>
						</strike>

						<strong style="color:red;font-size:1em;">
							{{number_format($product->discounted_price/100,2)}}</strong>
						<br/>
						<strong style="color:white;background:red; font-size:1em;"
								class="pull-right badgenew">
						
							Save {{number_format((($product->retail_price - $product->discounted_price)/$product->retail_price)*100,0)."%"}}
							</strong><br/>

					@endif
				</div>
	</div>

    </div>

@endforeach


<div class="clearfix"></div>
