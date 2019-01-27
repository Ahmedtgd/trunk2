<?php
use App\Models\Brand;
   $queryBrands = Brand::distinct()
                ->join('product', 'brand.id', '=', 'product.brand_id')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->where('merchant.status', '=', 'active')
                ->where('product.oshop_selected', '=', true)
                ->where('product.status', '=', 'active')
               ->where('product.retail_price','>','0')->where('product.segment','=','b2c')
                ->where('product.available','>','0')
                //->join('sectionproduct', 'sectionproduct.product_id', '=', 'product.id')
                ->join('oshopproduct', 'oshopproduct.product_id','=','product.id')
                //->where('brand.name', 'like', 'A%')
                ->select('brand.*')
                ->orderBy('brand.name', 'ASC')
                ->get();

$brands_collection = array();
//dump($queryBrands);
// Build brands collection
foreach ($queryBrands as $brand) $brands_collection[strtoupper($brand->name[0])][] = $brand;
//dump($brands_collection);
$chunk_size = 15;

?>
<?php foreach ($brands_collection as $letter => $all_brands): ?>
	@if(!empty($all_brands) && count($all_brands) > 0)
		@if(!is_numeric($letter) && !preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $letter))
	    <div id="B<?php echo $letter ?>"
			style="margin-top:10px"
			class="col-xs-12 tab-pane<?php if ($letter == 'A') echo " active" ?>">
		    <div class="row">
			    <div class="col-xs-12">
			        <h4 style="text-align:left;margin-bottom:0"><?php echo $letter ?></h4>
			    </div>
				@foreach(array_chunk($all_brands, $chunk_size) as $brands)
			    <div class="col-xs-3">
				    <ul class="nav nav-submenu">
			            @foreach($brands as $brand)
			                <li><a href="{{URL::to('brand-details/'.$brand->id)}}" target="_blank">{{$brand->name}}</a></li>
				        @endforeach
			        </ul>
			    </div>
				@endforeach
		    </div>
	    </div>
		@endif
	@endif
<?php endforeach ?>
	@if(!empty($all_brands) && count($all_brands) > 0)
		<div id="B0"
			style="margin-top:10px"
			class="col-xs-12 tab-pane">
		    <div class="row">
			    <div class="col-xs-12">
			        <h4 style="text-align:left;margin-bottom:0">0-9</h4>
			    </div>
				<?php foreach ($brands_collection as $letter => $all_brands): ?>
					@if(count($all_brands) > 0)
						@if(is_numeric($letter))
							@foreach(array_chunk($all_brands, $chunk_size) as $brands)
							<div class="col-xs-3">
								<ul class="nav nav-submenu">
									@foreach($brands as $brand)
										<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
									@endforeach
								</ul>
							</div>
							@endforeach
						@endif
					@endif
				<?php endforeach ?>	
		    </div>
	    </div>
	@endif
	
	@if(!empty($all_brands) && count($all_brands) > 0)
		<div id="BSC"
			style="margin-top:10px"
			class="col-xs-12 tab-pane">
		    <div class="row">
			    <div class="col-xs-12">
			        <h4 style="text-align:left;margin-bottom:0">*</h4>
			    </div>
				<?php foreach ($brands_collection as $letter => $all_brands): ?>
					@if(!empty($all_brands) &&  count($all_brands) > 0)
						@if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $letter))
							@foreach(array_chunk($all_brands, $chunk_size) as $brands)
							<div class="col-xs-3">
								<ul class="nav nav-submenu">
									@foreach($brands as $brand)
										<li><a href="{{URL::to('brand-details/'.$brand->id)}}">{{$brand->name}}</a></li>
									@endforeach
								</ul>
							</div>
							@endforeach
						@endif
					@endif
				<?php endforeach ?>	
		    </div>
	    </div>
	@endif	
