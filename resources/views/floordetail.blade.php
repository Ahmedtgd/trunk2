<?php $k=0; ?>
<?php $kw=0; ?>
<?php $page = 0; ?>
<?php $oproducts = 0; ?>
<p class="nomobile" align="center" style="font-size: 22px;">{{$filter_name}}</p>
<div class="row cat-items boxrow4">
@foreach($products as $product)
	@if($oproducts == 0) <div id="page{{$page}}" class="pages" @if($page > 0) style="display: none;" @endif> @endif
	<div class="col-md-2 col-sm-4 col-xs-6">
		<div class="col-xs-12 no-padding">
			<?php
				$raw_orip = $product->retail_price;
				$raw_retp = $product->discounted_price;
			
				($raw_orip > 0) ? $orip = $raw_orip/100 : $orip = 0;
				($raw_retp > 0) ? $retp = $raw_retp/100 : $retp = 0;
			?>

			@if ($retp > 0)
				<span class="badge dispprice" style="padding: 6px 12px !important;">{{$currentCurrency}}&nbsp;{{number_format($retp,2)}}</span>
			@else
				@if ($orip > 0)
					<span class="badge dispprice" style="padding: 6px 12px !important;">{{$currentCurrency}}&nbsp;{{number_format($orip,2)}}</span>
				@endif
			@endif
			@if ($orip > $retp && $retp != 0)
				<span class="badge-cutoff"><strong>
				@if ($orip > 0)
				{{--*/
					$res = number_format((($orip - $retp) / $orip) * 100);
					if ($res < 0) $res = 0;
				/*--}}  
				@else
				{{--*/ $res = 0; /*--}}  
				@endif
				<span>{{$res}}</span>%</strong><br>off</span>
			@endif

			<a href="{{ route('productconsumer', [$product->id]) }}"> 
			<img src="{{ URL::to('/') }}//images/product/{{$product->id}}/thumb/{{$product->thumb_photo}}"
				alt="Missing" class="img-responsive timg" style="border-style: hidden;" />
			</a>
	</div>
	<?php $pdesc = str_replace('"','&quot;',$product->name); ?>
	<div data-tooltip="{{$pdesc}}" class="mouseover producttitle col-xs-12">
		<div class="discription inside" style="">
		{{ $product->name}}
		
		</div>
	</div>	
	</div>  
	<?php $oproducts++; ?>
	@if($oproducts >=18 )
	<?php $oproducts = 0; ?>
	<?php $page++; ?>
	</div>
	@endif
	<?php $kw++; ?>
	@if($kw == 6)
	<div class="clearfix"> </div>
	<?php $kw=0; ?>	
	@endif									
@endforeach
 </div>
 <div class="clearfix"> </div>
<center >
	@if($page > 0 )
		<ul class="pagination">
			<li><a href="javascript:void(0)" class="first_page fontsize nomobile"><<</a></li>
			<li><a href="javascript:void(0)" class="prev_page fontsize nomobile">< Prev</a></li>
			<li><a href="javascript:void(0)" class="prev_page fontsize mobile"><</a></li>
			<li><span  class="last_ellipsis fontsize" style="display: none;">...</span><li>
			@for($pp = 0; $pp <= $page; $pp++)
				@if($pp > 5 && $pp == $page)
					<li><span  class="ellipsis fontsize">...</span><li>
				@endif
					<li><a href="javascript:void(0)" id="apage{{ $pp }}" rel="{{$pp}}" class="fontsize apage @if($pp == 0) selecteda @endif" @if($pp >= 5 && $pp != $page ) style="display: none;" @endif>{{$pp + 1}}</a></li>						
			@endfor
			<li><a href="javascript:void(0)" class="next_page fontsize nomobile"> Next ></a></li>
			<li><a href="javascript:void(0)" class="next_page fontsize mobile">></a></li>
			<li><a href="javascript:void(0)" class="last_page fontsize nomobile">>></a></li>
		</ul>

		<input type="hidden" value="{{$page}}" id="page_count" />
		<input type="hidden" value="0" id="current_page" />
	@endif
</center>
@if(sizeof($products)==0)
	<h3>Empty Floor</h3>
@endif