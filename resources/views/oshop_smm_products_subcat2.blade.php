<div class="col-sm-12" style="margin-bottom:10px">
    <div class="row">
        <h2 style="margin-left:8px;margin-bottom:0;margin-top:0">SMM</h2>
    </div>
</div>
<?php $kw=0; ?>
	<div class="row" >
		<div class="col-sm-12">
			@if(isset($subcat))
				<h2 class="title" style="margin-left:8px;margin-top:0;">{{$subcat->description}}</h2>
				<h3 class="title" style="margin-left:8px;margin-top:0;">{{$subcat2->description}}</h3>
			@else
				<h2 class="title" style="margin-left:8px;margin-top:0;">{{$subcat2->description}}</h2>
			@endif
			<?php $counter_ssmm = 0;?>
			<?php $ksmm = 0;?>
		   @foreach($products as $product)
				<div class="col-sm-2 col-xs-6 column productbox added productbox_{{$product->id}}" data-pid="{{$product->id}}" style="margin-right:1px;">
					<div class="image">
						<img src="{{ URL::to('/') }}/images/product/{{$product->id}}/thumb/{{ $product->thumb_photo}}" class="added img simg img-responsive full-width" data-pid="{{$product->id}}">
					</div>
					 <div data-tooltip="{{$product->name}}"  class="mouseover producttitle">
						 <div class="gradientEllipsis inside" >
							@if(is_null($product->name) || $product->name == "")
								&nbsp;
							@else
								{{$product->name}}
							@endif
							 <div class="dimmer"></div>
						 </div>
					 </div>
					<div class="productprice">
						<div class="pricetext" style="font-size:.8em">
							@if (($product->discounted_price == $product->retail_price) || ($product->discounted_price == 0))
								@if ($product->retail_price > 0)
									<br/><strong style="font-size:1em;">
										RM{{number_format($product->retail_price/100,2)}}</strong>
								@endif
								<br/>
								&nbsp;
								<br/>
							@else
							<br/>
							<strong style="color:black; font-size:1em;">{{$currentCurrency}}</strong>
								<strike style="color:red">
									<span style="color:#333;">
										<strong style="color:black; font-size:1em;">
											{{number_format($product->retail_price/100,2)}}
										</strong>
									</span>
								</strike>

								<strong style="color:red;font-size:1em;">
									{{number_format($product->discounted_price/100,2)}}
								</strong>
									<br/>
								<strong style="color:white;background:red; font-size:1em;" class="pull-right badgenew">
									Save {{number_format((($product->retail_price - $product->discounted_price)/$product->retail_price)*100,0)."%"}}
								</strong><br/>

							@endif
						</div>
					</div>

			</div>
			<?php $ksmm++; ?>
			@if($ksmm == 5)
				<div class="clearfix"> </div>
				<?php $ksmm=0; ?>	
			@endif	
			<?php $counter_ssmm++;?>
		@endforeach
		</div>
	</div>
<div class="col-sm-12 margin-top">
	<button class="btn btn-green pull-right product-selected" id="blast" type="button" disabled>SEND</button>
</div>	
<script type="text/javascript">
    $(document).ready(function(){
        var product_id=-1;
        $('body').click(function(evt){
            if ($(evt.target).hasClass('added')) {
                $('.productbox').removeClass('selected');

                var pid= $(evt.target).attr('data-pid');
                window.product_id=pid;
                var cls=".productbox_"+pid;
                $(cls).toggleClass('selected');
                $('#blast').prop('disabled',false);
                // if ($(evt.target).hasClass('selected')) {
                //     var product_id= $('.productbox').attr('data-pid');
                //     alert(product_id);
                // };

            }
            else{
                $('.productbox').removeClass('selected');
                 $('#blast').prop('disabled',true);
            }
        });

    });
</script>
{{-- AJAC CALL FOR SMM SAVE --}}
 <script type="text/javascript">
 $(document).ready(function(){
    $('#blast').click(function(){
        // alert(product_id);
        $.ajax({
                url: JS_BASE_URL + '/smedia/marketer',
                type: 'GET',
                data: {product_id: product_id},
                success:function(response){
                    toastr.info(response);
                }
        });
    });
 });
</script>