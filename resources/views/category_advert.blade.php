{{-- Category Image Banner --}}
<div class="category_image_container" style="margin-left:0;margin-right:0">
	<div class="row">
		<div class="category_section col-sm-8 col-xs-6 cat_adv1" style="padding-right: 0px; padding-left: 0px;" >
			@if($cat_adv1)
			<img class="img" src="{{$slider_path.$cat_adv1->id.'/'.$cat_adv1->path}}" />
			@endif
		</div>
		<div class="category_section col-sm-4 col-xs-6 cat_adv2" style="padding-right: 0px; padding-left: 0px;">
			@if($cat_adv2)
			<img class="img" src="{{$slider_path.$cat_adv2->id.'/'.$cat_adv2->path}}" />
			@endif
		</div>
	</div>
	<div class="row" style="margin-left:0;margin-right:0">
		<div class="category_section col-sm-4 col-xs-6 cat_adv3" style="padding-right: 0px; padding-left: 0px;">
			@if($cat_adv3)
			<img class="img" src="{{$slider_path.$cat_adv3->id.'/'.$cat_adv3->path}}" />
			@endif
		</div>
		<div class="category_section col-sm-4 col-xs-6 cat_adv4" style="padding-right: 0px; padding-left: 0px;">
			@if($cat_adv4)
			<img class="img" src="{{$slider_path.$cat_adv4->id.'/'.$cat_adv4->path}}" />
			@endif
		</div>
		<div class="category_section col-sm-4 col-xs-6 cat_adv5" style="padding-right: 0px; padding-left: 0px;">
			@if($cat_adv5)
			<img class="img" src="{{$slider_path.$cat_adv5->id.'/'.$cat_adv5->path}}" />
			@endif
		</div>
	</div>
</div>
{{-- Category Image Banner end --}}