<!-- LANDING PAGE ADVERTISEMENT PANEL -->
<!-- Do NOT add any advertisement related code or layout in the main landing
	 page view. Do so in *THIS* file. -->

	<!-- Primary Slider Section START -->
	<!-- Rahul -->
	<div class="slider-image-container" id="slider_image_container">
		<div class="image-slider div-left-imgslider pull-left"
			id="div_left_imgslider">
		@if(count($sliderImages) > 0 && $sliderImages_hide == 0)
			@foreach($sliderImages as $sliderImage)
			<a href="{{url($sliderImage->target)}}" target="_blank"
			style="height:100%">
				<img src="{{$slider_path.$sliderImage->id.'/'.
				$sliderImage->path}}" height="100%" width="100%"
				style="object-fit: cover;">
				</img>
			</a>
			@endforeach
		@endif
		</div>
		<div class="div-right-imgslider pull-right" id="div-right-imgslider">
			@if($smallTopImage != null && $smallTopImage->hide_public == 0)
			<a href="{{url($smallTopImage->target)}}" target="_blank">
				<img src="{{$slider_path.$smallTopImage->id.'/'.
					$smallTopImage->path}}" height="100%" width="100%"
					style="object-fit: cover;">
				</img>
			</a>
			@endif
		</div>
		<div class="div-right-imgslider pull-right" id="div-right-imgslider">
			@if($smallBottomImage != null && $smallBottomImage->hide_public == 0)
			<a href="{{url($smallBottomImage->target)}}" target="_blank">
				<img src="{{$slider_path.$smallBottomImage->id.'/'.
					$smallBottomImage->path}}" height="100%" width="100%"
					style="object-fit: cover;">
				</img>
			</a>
			@endif
		</div>
	</div>
	<!-- Primary Slider Section END -->


	<!-- O-Shop Section START -->
	<!-- Rahul -->
	<div class="col-sm-12 oshops_container {{ $oshopImages->is_hidden ? 'hide' : '' }}" style="padding:0">
		<div class="row">
			<div class="col-sm-12 col-xs-12 nomobile">
				<h1 style="font-family:'LatoLatin Light';font-style:italic">Official Shops</h1>
			</div>
		</div>
		<div style="padding-left:5px" class="oshop">
		@if(!empty($oshopImages))
			@foreach($oshopImages->AdControl->AdImages->chunk(6) as $images)
			@foreach($images as $image)
				<div class="col-sm-2 col-xs-6"
					style="padding-left:0;padding-right:0">
					<a href="{{url('o/'.$image->target)}}" target="_blank">
					<img src="{{$slider_path.$image->id.'/'.$image->path}}" 
					height="100%" width="100%" style="object-fit: cover;">
					</img>
					</a>
				</div>
			@endforeach    
			@endforeach
		</div>
		@endif  
	</div>
	<!-- O-Shop Section END -->


	<!-- Hyper Deals Section START -->
	<!-- Rahul -->
	@if(!empty($hyper_deals))
	<div class="col-sm-12 hyper_deals_container">
	<div class="row">
		<div class="col-sm-6 col-xs-6 nomobile">
			<h1>Hyper Deals</h1>
		</div>
		<div class="col-sm-6 col-xs-6 nomobile text-right view_more pull-right">
			<a href="{{route('hyperdeals')}}" class="view-more">View More</a>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 col-xs-12 no-padding">
			@foreach($hyper_deals as $deal)
				<div class="col-sm-2 col-xs-6" data-pid="{{$deal->parent_id}}">
				<div class="col-xs-12 no-padding mouseover"
					data-tooltip="{{$deal->name}}">
				<a href="{{ route('owarehouse', [$deal->subcat_id.'-'.
					$deal->subcat_level]) }}" class="redirect_llink"
					target="_blank">

				<img src="{{ URL::to('/') }}/images/product/{{$deal->parent_id}}/thumb/{{$deal->thumb_photo}}"
					class="img-responsive" style="border:0px"
					data-pid="{{$deal->parent_id}}" alt="{{$deal->name}}"/>
				<span class="discount">
				<span style="text-shadow: 0px 1.5px #666666; font-size: 22px;">SAVE</span><br>
				<strong style="text-shadow: 0px 1.5px #666666; font-size: 45px;">&nbsp;&nbsp;{{number_format((($deal->retail_price -$deal->collection_price) * 100)/$deal->retail_price,0)}}
				</strong><span style="text-shadow: 0px 1.5px #666666; font-size: 45px;">%</span></span>
				</a>
				</div>
				</div>
			@endforeach
			</div>
		</div>
	</div>
	@endif
	<!-- Hyper Deals Section END -->
