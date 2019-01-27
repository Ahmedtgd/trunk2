@def $currency = \App\Models\Currency::where('active',1)->first()->code;

@if(!Auth::check())
    <div id='alert' class="cart-alert alert alert-warning" role="alert" style="border-color: red;">
      <strong><h4><a href="{{ route('buyerreg') }}"><b style="color: red;">Please SignUp and link to our merchants to view wholesale price!</b></a></h4></strong>
    </div>
@endif

<div class="col-sm-12" style="margin-bottom:10px">
    <div class="row">
        <h2 style="margin-left:8px;margin-bottom:0;margin-top:0">Business To Business</h2>
    </div>
</div>
<div class="col-sm-12" style="margin-bottom:10px">
    <div class="row">
		<h2 class="title"
			style="margin-left:8px;margin-top:0;">
			{{$category->description}}
		</h2>
    </div>
</div>
	<div class="row" id="{{$category->name}}">
		<div class="col-sm-12">
{{--@if(sizeof($subcategoriesp)>0)--}}
<?php $kk = 0; ?>
<?php $page_b2b = 0; ?>
<?php $oproducts_b2b = 0; ?>
@foreach($subcategoriesp as $products)
    <?php $value = 4;$av = 12; $text = 25; $o = 3;?>
			<?php $k=0; ?>
			@if(sizeof($products)>0)
                    @foreach($products as $product)
						@if($oproducts_b2b == 0) <div id="page_b2b{{$page_b2b}}" class="pages_b2b" @if($page_b2b > 0) style="display: none;" @endif> @endif
                        <div class="p-box col-xs-6 col-sm-4 col-md-3" style="padding-right:2px; margin-bottom:30px">
                            <div class="p-box-content">
                                <div class="cat-img">
                                    @if(Auth::check())
										<a href="{{ route('productb2b', $product->id) }}">
                                          <img class="img-responsive" alt="Missing"
                                            src="{{ asset('images/product') }}/{{ $product->id }}/thumb/{{ $product->thumb_photo }}">
										</a>
									@else
										<a href="javascript:void(0)" data-toggle="modal" data-target="#loginModal" class="b2b_validation" role="button">
                                          <img class="img-responsive" alt="Missing"
                                            src="{{ asset('images/product') }}/{{ $product->id }}/thumb/{{ $product->thumb_photo }}">
										</a>
									@endif
                                </div>
                                {{-- img ends --}}
                                <div class='product-info'>
                                    <div class="product-name col-sm-12 col-xs-12">
                                        <div class="row">
                                            <div class="col-sm-7 col-xs-7">
                                                <div data-toggle="tooltip" data-placement="top" title='{{ $product->name }}' class="row productName">
                                                    {{ $product->name }}
                                                </div>
                                            </div>
                                            <div class="col-sm-5 col-xs-5">
                                                <div class="row">

                                                    <span data='{{ $product->id }}'
														class="hide wholesale-price wholesale-price-{{ $product->id }}">
                                                    </span>
                                                </div>
                                            </div>
                                         </div>
                                    </div>
                                    @if(Auth::check())
                                        <div class="tier-price col-sm-12 col-xs-12">
                                        	@if(isset($product->special_funit) && isset($product->special_unit) && isset($product->special_price))
                                            @def $wholesales = \App\Models\Wholesale::where('product_id', $product->ssid)->orderBy('funit','asc')->take(3)->get()
											@def $all_wholesales2 = \App\Models\Wholesale::where('product_id', $product->ssid)->get()
                                            @else
                                            @def $wholesales = \App\Models\Wholesale::where('product_id', $product->ssid)->orderBy('funit','asc')->take(4)->get()
											@def $all_wholesales2 = \App\Models\Wholesale::where('product_id', $product->ssid)->get()
                                            @endif
                                            @if(isset($wholesales))
                                            <div class="row">
                                                <div class="table-responsive" style="border:0px">
                                                    <table class="priceTable table">
                                                        <thead>
                                                            @if(isset($product->special_funit) && isset($product->special_unit) && isset($product->special_price))
                                                                <tr  style='color: #F54400'>
                                                                    <th class='text-left special_price_row'>
                                                                        {{-- <span> {{ $product->special_funit }} </span> -
                                                                        <span> {{ $product->special_unit }} </span> --}}
                                                                        Special Price
                                                                    </th>
                                                                    <th class='text-right special_price_row'>
                                                                        <span> {{ $currency }} </span>
                                                                        <span> {{ number_format($product->special_price/100,2) }} </span>
                                                                    </th>
                                                                </tr>
                                                            @endif
                                                            <tr>
                                                                <th class='text-left'>Tier</th>
                                                                <th class='text-right'>Price/Unit</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
															@def $wholesalescount = count($wholesales)
															@def $all_wholesalescount = count($all_wholesales2)
															@def $counter = 1;														
                                                            @foreach($wholesales as $wholesale)
                                                            <tr>
                                                                <td class='text-left'>
																	@if($wholesalescount == $all_wholesalescount && $counter == $all_wholesalescount)
																		<span> > {{ $wholesale->funit }} </span>	
																	@else 
																		<span> {{ $wholesale->funit }} </span> -
																		<span> {{ $wholesale->unit }} </span>
																	@endif
                                                                </td>
                                                                <td class='text-right'>
                                                                    <span> {{ $currency }} </span>
                                                                    <span> {{ number_format($wholesale->price/100,2) }} </span>
                                                                </td>
                                                            </tr>
															<?php $counter++; ?>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <br>
                                        <div>
                                            <a title="Price List" tabindex="0"  data-toggle="popover" data-trigger="focus" data-container="body" data-placement="top" type="button" data-html="true"  id="{{ $product->id }}">See full price list</a>
                                        </div>

                                        {{-- popover view --}}
                                        <div class="hide" id="price-{{ $product->id }}">
                                            @def $all_wholesales = \App\Models\Wholesale::where('product_id', $product->ssid)->orderBy('funit','asc')->get()
                                            @if(isset($all_wholesales))
                                                <div class="row">
                                                    <div class="table-responsive" style="border:0px">
                                                        <table class="priceTable table">
                                                            <thead>
                                                                <tr>
                                                                    <th class='text-left'>Tier</th>
                                                                    <th class='text-right'>Price/Unit</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if(isset($product->special_funit) && isset($product->special_unit) && isset($product->special_price))
                                                                    <tr  style='color: #F54400'>
                                                                        <td class='text-left'>
                                                                            <span> {{ $product->special_funit }} </span> -
                                                                            <span> {{ $product->special_unit }} </span>
                                                                        </td>
                                                                        <td class='text-right'>
                                                                            <span> {{ $currency }} </span>
                                                                            <span> {{ number_format($product->special_price/100,2) }} </span>
                                                                        </td>
                                                                    </tr>
                                                                @endif
																@def $all_wholesalescounter = count($all_wholesales);
																@def $counter = 1;																	
                                                                @foreach($all_wholesales as $wholesale)
                                                                {{-- start: all data for calculation --}}
                                                                <p  class=' price-info-{{ $product->id }}'
                                                                    special-funit='{{ isset($product->special_funit) ? $product->special_funit : 0 }}'
                                                                    special-unit='{{ isset($product->special_unit) ? $product->special_unit : 0 }}'
                                                                    special-price='{{ isset($product->special_price) ? $product->special_price : 0 }}'
                                                                    from-unit='{{ $wholesale->funit }}'
                                                                    to-unit='{{ $wholesale->unit }}'
                                                                    price='{{ $wholesale->price }}'>
                                                                </p>
                                                                {{-- end --}}
                                                                <tr>
                                                                    <td class='text-left'>
																		@if($all_wholesalescounter == $counter)
																			<span> > {{ $wholesale->funit }} </span>
																			<input type="hidden" id="funit{{$counter}}-{{$product->id}}" value="{{ $wholesale->funit }}" />
																			<input type="hidden" id="unit{{$counter}}-{{$product->id}}" value="100000000" />
																			<input type="hidden" id="wprice{{$counter}}-{{$product->id}}" value="{{ $wholesale->price/100 }}" />													
																		@else
																			<span> {{ $wholesale->funit }} </span> -
																			<span> {{ $wholesale->unit }} </span>
																			<input type="hidden" id="funit{{$counter}}-{{$product->id}}" value="{{ $wholesale->funit }}" />
																			<input type="hidden" id="unit{{$counter}}-{{$product->id}}" value="{{ $wholesale->unit }}" />
																			<input type="hidden" id="wprice{{$counter}}-{{$product->id}}" value="{{ $wholesale->price/100 }}" />
																		@endif
                                                                    </td>
                                                                    <td class='text-right'>
                                                                        <span> {{ $currency }} </span>
                                                                        <span> {{ number_format($wholesale->price/100,2) }} </span>
                                                                    </td>
                                                                </tr>
																<?php $counter++; ?>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
						<?php $oproducts_b2b++; ?>
						@if($oproducts_b2b >=12 )
							<?php $oproducts_b2b = 0; ?>
							<?php $page_b2b++; ?>
							</div>
						@endif
									
                    @endforeach
				@endif								
	<?php $kk++; ?>
{{--@endif--}}
@endforeach
 @if($oproducts_b2b > 0 )
		</div>
 @endif
 <div class="clearfix"> </div>
<center >
	@if($page_b2b > 0 )
		<ul class="pagination">
			<li><a href="javascript:void(0)" class="first_page_b2b fontsize nomobile"><<</a></li>
			<li><a href="javascript:void(0)" class="prev_page_b2b fontsize nomobile">< Prev</a></li>
			<li><a href="javascript:void(0)" class="prev_page_b2b fontsize mobile"><</a></li>
			<li><span  class="last_ellipsis_b2b fontsize" style="display: none;">...</span><li>
			@for($pp = 0; $pp <= $page_b2b; $pp++)
				@if($pp > 5 && $pp == $page_b2b)
					<li><span  class="ellipsis_b2b fontsize">...</span><li>
				@endif
					<li><a href="javascript:void(0)" id="apage_b2b{{ $pp }}" rel="{{$pp}}" class="fontsize apage_b2b @if($pp == 0) selecteda @endif" @if($pp >= 5 && $pp != $page_b2b ) style="display: none;" @endif>{{$pp + 1}}</a></li>						
			@endfor
			<li><a href="javascript:void(0)" class="next_page_b2b fontsize nomobile"> Next ></a></li>
			<li><a href="javascript:void(0)" class="next_page_b2b fontsize mobile">></a></li>
			<li><a href="javascript:void(0)" class="last_page_b2b fontsize nomobile">>></a></li>
		</ul>

		<input type="hidden" value="{{$page_b2b}}" id="page_count_b2b" />
		<input type="hidden" value="0" id="current_page_b2b" />
	@endif	
</center>	
</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
		$("[data-toggle=popover]").popover({
			html: true,
			content: function() {
				id = $(this).attr('id');
				return $('#price-'+id).html();
			}
		});
	});
</script>