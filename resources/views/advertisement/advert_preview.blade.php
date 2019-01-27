@extends('common.default')
@section('content')
@include("advertisement.advert_modal")
@include("advertisement.advert_right_modal")
@include("advertisement.advert_oshop_modal")

<style type="text/css">
.fa-times-thin:before {
	content: '\00d7';
}

*, *:before, *:after{
  margin: 0;
  padding: 0;
  -webkit-box-sizing: border-box;
  -moz-box-sizing:border-box;
  box-sizing: border-box;
}

.slick-prev:before, .slick-next:before {
	color: black;
	font-size: 30px;

}

.productbox{
	font-family: 'Lato', sans-serif !important;
	position: relative;
    border-top: 1px solid #ccc;
    margin: auto;
  overflow: hidden;
  padding-top: 10px;
}
.productbox .content-overlay {
  background: rgba(0,0,0,0.7);
  position: absolute;
  height: 99%;
  width: 100%;
  left: 0;
  top: 0;
  bottom: 0;
  right: 0;
  opacity: 0;
  -webkit-transition: all 0.4s ease-in-out 0s;
  -moz-transition: all 0.4s ease-in-out 0s;
  transition: all 0.4s ease-in-out 0s;
}

.productbox:hover .content-overlay{
  opacity: 1;
}

.img{
  width: 100%;
  height:160px;
  object-fit: contain;
}

.content-details {
  position: absolute;	
  text-align: center;
  padding-left: 1em;
  padding-right: 1em;
  width: 100%;
  top: 50%;
  left: 50%;
  opacity: 0;
  -webkit-transform: translate(-50%, -50%);
  -moz-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  -webkit-transition: all 0.3s ease-in-out 0s;
  -moz-transition: all 0.3s ease-in-out 0s;
  transition: all 0.3s ease-in-out 0s;
}

.productbox:hover .content-details{
  top: 50%;
  left: 50%;
  opacity: 1;
}

.content-details p{
  color: #fff;
  font-size: 1.0em;
}

.fadeIn-bottom{
  top: 80%;
}

.div-left-imgslider{
	height: 420px;
	width: 730px;
	/*
	border-style: solid;
	border-width: 3px;
	margin-top: 34px;
	*/
}

.div-right-imgslider{
	height: 210px;
	width: 410px;
	padding:0;
	/*
	border-style: solid;
	border-width: 3px;
	*/
}

.btn-add-div
{
	width: 40px;
	height: 40px;
	text-align: center;
	padding: 4px 0;
	font-size: 20px;
	line-height: 1.42;
	border-radius: 20px;
	margin-top: 20px;
}

/*.internal-right-bottom{
	border-style: solid;
	border-width: 2px;
}*/

.right-bottom-image
{
	height: 200px;
	border-style: solid;
	border-color: #c0c0c0;
	border-width: 1px;
}

.oshop-image{
  height: 100px;
  border-style: solid;
  border-width: 1px;
}

.right-top-image{
	height: 200px;
	border-style: solid;
	border-color: #c0c0c0;
	border-width: 1px;
}
.save-btn-div{
	margin-top: 20px;
}
.save-btn-leftdiv{
	margin-top: 20px;
}
.btn-close{
	width: 40px;
	height: 40px;
	text-align: center;
	padding: 4px 0;
	font-size: 20px;
	line-height: 1.42;
	border-radius: 20px;
	margin-top: -10px;
	margin-right: -10px;
}
.btn-upload{
	width: 40px;
	height: 40px;
	text-align: center;
	padding: 4px 0;
	font-size: 20px;
	line-height: 1.42;
	border-radius: 20px;
	margin-top: 153px;
}
.btn-small-top-upload {
	width: 40px;
	height: 40px;
	text-align: center;
	padding: 4px 0;
	font-size: 20px;
	line-height: 1.42;
	border-radius: 20px;
	margin-top: 153px;
}
.btn-small-bottom-upload {
	width: 40px;
	height: 40px;
	text-align: center;
	padding: 4px 0;
	font-size: 20px;
	line-height: 1.42;
	border-radius: 20px;
	margin-top: 153px;
}
.small-container-btn {
	width: 30px;
	height: 20px;
	text-align: center;
	padding: 0;
	font-size: 20px;
	border-width:0;
	border-radius: 4px;
}

.scb-slider {
	margin-top: -10px;
	margin-right: -14px;
}
.scb-top {
	margin-top: -4px;
	margin-right: -13px;
}
.scb-bottom {
	margin-top: -2px;
	margin-right: -9px;
}
.scb-oshop {
	margin-top: -7px;
	margin-right: -18px;
}
 

.oshops_container{
	width:1170px;
	height:180px;
	border:0px solid #D3D3D3;
	margin-top:10px;   
}
.btn-oshop-upload{
	width: 25px;
	height: 25px;
	text-align: center;
	padding: 4px 0;
	font-size: 15px;
	line-height: 1.42;
	border-radius: 20px;
	margin-top: 70px;
	margin-right: 5px;
	/*
	position: absolute;
	top:258px;
	left:229px;
	*/
}
.btn-close-oshop{
	position: absolute;
	top:87px;
	right:20px; 
}
.slider-container .btn-close{
	position: absolute;
	right: 15px;
}
.slider_image_div .btn-upload{
	position: fixed;
	right: 30px;
	/*bottom: -6px;*/
}
.btn-close-bottom{
	position: absolute;
	right: 10px;
	top: 92px;
}
.btn-small-bottom-upload{
	position: absolute;
	right: 0px;
	bottom: 12px;
}
.btn-close-top{
	position: absolute;
	right: 13px;
	top: 94px;
}
.btn-small-top-upload{
	position: absolute;
	right: 0px;
	bottom: 6px;
}
.fa-2x{
	font-size: 20px;
	font-weight: bold;
}
.btn-black{
background-color: #000;
	color:#fff;
}
.btn-black:hover{
	color:#fff; 
}
.top_space{
  padding-top:0px;
}
.div-right-imgslider .hide-button{
	position: absolute;
}
.hide-button{
//	margin-left: 10px;
}
.div-left-imgslider .hide-button{
	position: absolute;
	z-index: 11;
}
.hide{
	display: none;
}
</style>
<div class="container nomobile">
@include('admin/panelHeading')
<div class="row" style="margin-bottom:0;margin-left:0;margin-right:0">
	<div class="col-sm-10" style="padding-left:0;padding-right:0">
		@include('admin/advertPanelHeading')
	</div>
	<div class="col-sm-2;padding-right:0"
		style="margin-top:35px">
		<button class="pull-right btn btn-success btn_update_to_public">Update To Public</button>
	</div>
</div>

<div class="slider"></div>
@if(!is_null($sliderDetails))
	<div class="image-slider div-left-imgslider pull-left" id="divsliderhide">
		
		<button type="" data-targettype="lpage_slider" id="sliderhide" data-container="lpage_slider" class="btn btn-pink hide-button">{{ $sliderDetails->is_hidden ? 'Show' : 'Hide' }}</button>
		<div class="lpage_slider {{ $sliderDetails->is_hidden ? 'hide' : '' }}" id="div-left-imgslider" data-toggle="modal" data-target="#landingModal">
			@if($sliderDetails != null && $sliderDetails->AdControl != null && count($sliderDetails->AdControl->AdImages) > 0)
				@foreach($sliderDetails->AdControl->AdImages as $image)
				<img src="{{$slider_path.$image->id.'/'.$image->temp_path}}"
				style="object-fit:cover"
				height="100%" width="100%"></img>
				@endforeach
			@endif
		</div>
	</div>
@else
	<div class="image-slider div-left-imgslider pull-left" id="divsliderhide">
		<button type="" data-targettype="lpage_slider" id="sliderhide" data-container="lpage_slider" class="btn btn-pink hide-button">Hide</button>
		<div class="lpage_slider" id="div-left-imgslider" data-toggle="modal" data-target="#landingModal">
			<img 
				style="object-fit:cover"
				height="100%" width="100%"></img>
		</div>
	</div>
	
@endif
@if(!is_null($topContainerDetails))	
	<div class="div-right-imgslider pull-right" id="topdivsliderhide">
		<button type="" data-targettype="lpage_internal_top"
			id="topsliderhide" data-container="lpage_internal_top"
			class="btn btn-pink hide-button">
			{{ $topContainerDetails->is_hidden ? 'Show' : 'Hide' }}</button>
		<div id="div-right-imgslider" data-toggle="modal"
			data-target="#landingTopRightModal" class="lpage_internal_top"
			style="width:410px;height:210px;display:{{ $topContainerDetails->is_hidden ? 'none' : 'block' }}">
			@if($topContainerDetails != null &&
				$topContainerDetails->AdControl != null &&
				count($topContainerDetails->AdControl->AdImages) > 0)	
				<img src="{{$slider_path.$topContainerDetails->AdControl->AdImages[0]->id.'/'.$topContainerDetails->AdControl->AdImages[0]->temp_path}}"
				style="object-fit:cover"
				height="100%" width="100%"></img>
			@endif
		</div>
	</div>
@else
	<div class="div-right-imgslider pull-right" id="topdivsliderhide">
		<button type="" data-targettype="lpage_internal_top"
			id="topsliderhide" data-container="lpage_internal_top"
			class="btn btn-pink hide-button">Hide</button>
		<div id="div-right-imgslider" data-toggle="modal"
			data-target="#landingTopRightModal" class="lpage_internal_top" >
				<img
				style="object-fit:cover"
				height="100%" width="100%"></img>
		</div>
	</div>
@endif
@if(!is_null($bottomContainerDetails))	
	<div class="div-right-imgslider pull-right" id="botdivsliderhide">
		<button type="" data-targettype="lpage_internal_bottom"
			id="botsliderhide" data-container="lpage_internal_bottom"
			class="btn btn-pink hide-button">
			{{ $bottomContainerDetails->is_hidden ? 'Show' : 'Hide' }}</button>
		<div id="div-right-bimgslider" data-toggle="modal"
			data-target="#landingBottomRightModal" class="lpage_internal_bottom"
			style="width:410px;height:210px;display:{{ $bottomContainerDetails->is_hidden ? 'none' : 'block' }}">
				@if($bottomContainerDetails != null && $bottomContainerDetails->AdControl != null && count($bottomContainerDetails->AdControl->AdImages) > 0)
					<img src="{{$slider_path.$bottomContainerDetails->AdControl->AdImages[0]->id.'/'.$bottomContainerDetails->AdControl->AdImages[0]->temp_path}}"
					style="object-fit:cover"
					height="100%" width="100%"></img>
				@endif
				{!!csrf_field()!!}
		</div>
	</div>
@else
	<div class="div-right-imgslider pull-right" id="botdivsliderhide">
		<button type="" data-targettype="lpage_internal_bottom" id="botsliderhide" data-container="lpage_internal_bottom" class="btn btn-pink hide-button">Hide</button>
		<div id="div-right-bimgslider" data-toggle="modal" data-target="#landingBottomRightModal" class="lpage_internal_bottom">
				<img
				style="object-fit:cover"
				height="100%" width="100%"></img>
		</div>
	</div>	
@endif	

	<input type="hidden" id="slider_path" value="{{$slider_path}}">


  {{-- OShops Section By Rahul --}}
	<div class="col-sm-12 oshops_container" id="oshop_images">
	<div class="row">
		<div style="padding-left:0" class="col-sm-12 col-xs-12 nomobile">
		<div id='oshop_title' class="show">
		<h1 style="font-family:'LatoLatin Light';font-style:italic;float: left;">Official Shops</h1>
		</div>
		<!--
		{{ $oshopImages->is_hidden ? 'FOO' : 'BAR' }}
		<h1 style="font-family:'LatoLatin Light';font-style:italic;float: left;">Official Shops</h1>
		Official Shops</h1>
		-->
		<button type="" data-targettype="lpage_oshop" data-container="oshop" class="btn btn-pink hide-button">{{ $oshopImages->is_hidden ? 'Show' : 'Hide' }}</button>
		</div>
	</div>
	<div style="padding-left:5px" class="oshop {{ $oshopImages->is_hidden ? 'hide' : '' }}">
	@if(!empty($oshopImages))
		@foreach($oshopImages->AdControl->AdImages->chunk(6) as $images)
		@foreach($images as $image)
		<div class="col-sm-2 col-xs-6"
			style="padding-right: 0px; padding-left: 0px;" data-toggle="modal" data-target="#oshopModal">
			<img src="{{$slider_path.$image->id.'/'.$image->temp_path}}"
			   height="100%" width="100%"
			   style="object-fit: cover;">
			</img>
		</div>
		@endforeach    
		@endforeach
	@endif
	</div>
	</div>
  {{-- OShops Section end By Rahul --}}
</div>

<script type="text/javascript">
$(document).ready(function(){
	var divsliderhide_width = $("#divsliderhide").width();
	var sliderhide_width = $("#sliderhide").width();
//	console.log("LEFT " + sliderhide_width);
	var sliderhide_left = divsliderhide_width - (sliderhide_width + 24);
	$("#sliderhide").css('marginLeft', sliderhide_left + "px");
	
	var divtopsliderhide_width = $("#topdivsliderhide").width();
//	console.log("LEFT " + divtopsliderhide_width);
	var topsliderhide_width = $("#topsliderhide").width();
//	console.log("LEFT " + topsliderhide_width);
	var topsliderhide_left = divtopsliderhide_width - (topsliderhide_width + 24);
//	console.log("LEFT " + topsliderhide_left);
	$("#topsliderhide").css('marginLeft', topsliderhide_left + "px");	

	$("#botsliderhide").css('marginLeft', topsliderhide_left + "px");
	
	$(".new-add-targetdiv").on("click",".btn-close",function(){
		var id = $(this).data('id');
		if(confirm("Want to delete image slider?") == true) {
			$("input[name='delete_image']").
				val($("input[name='delete_image']").val()+","+id);
			$("#left_slider_"+id).empty();
			$("#left_slider_"+id).html('<label class="control-label '+
			'form-group" for="target" style="margin-top:20px;">'+
			'Target </label>'+
			'<input type="text" name="target[]" class="form-control"><br>'+
			'<div class="slider_image_div" '+
			'style="border-style: solid;border-width: 1px; height: '+
			'200px;border-color:#c0c0c0">'+
			'<input type="file" style="display:none;" '+
			'name="slider_image[]" '+
			'data-preview-file-type="text" data-count="'+id+'">'+
			'<img src="" class="slider_'+id+'">'+
			'<button type="button" style="background:#000000; '+
			'color:#ffffff;" class="btn btn-upload pull-right">'+
			'<i class="fa fa-upload"></i></button></div>');
			toastr.success(
				'<div><p>Successfully deleted Slider Image</p></div>');
		}
	});

	$("#div-left-imgslider").on("click",function(){
	$.ajax({
		url: '/admin/general/left_image_slider',
		type: 'GET',
		success: function(data){
			//console.log(data);
			if(data.ad_control != null) {
				$("#rottime").val(data.ad_control.rotation_time);
				$("#height").val(data.ad_control.height);
				$("#width").val(data.ad_control.width);                		
			}
			var slider_path = $("#slider_path").val();
			
			if(data.ad_control != null &&
				data.ad_control.ad_images.length > 0){
				var sliders = "";
				data.ad_control.ad_images.forEach(function(image){
					sliders += '<div class="slider-container" '+
					'id="left_slider_'+image.id+'">'+
					'<label class="control-label form-group" for="target" '+
					'style="margin-top:20px;">Target </label>'+
					'<input type="text" value="'+image.target+
					'" name="old_target[]" class="form-control">'+
					'<input type="hidden" value="'+image.id+
					'" name="ids[]"><br><button type="button" '+
					'class="btn btn-black small-container-btn scb-slider btn-close '+
					'pull-right" data-id="'+ image.id+'" data-src="'+
					image.temp_path+'">'+
					'<i class="fa fa-times-thin fa-2x" '+
					'style="margin-top:0.4px;vertical-align:top">'+
					'</i></button>'+
					'<div class="slider_image_div" style="border-style: '+
					'solid;border-color:#c0c0c0;border-width: 1px; '+
					'height: 200px;"><img src="'+slider_path+image.id+'/'+
					image.temp_path+'" style="object-fit:cover;height:100%;'+
					'width:100%"></div></div>';
				});

				$(".new-add-targetdiv").html(sliders)                		
			}
			// $("#landingModal").toggle();
		},
		error: function(error){
			console.log(error);
		}
	});
	});

	$("#div-right-imgslider").on("click",function(e){
	$.ajax({
		url: '/admin/general/right_image_slider',
		type: 'GET',
		success: function( data ){
			var slider_path = $("#slider_path").val();

			if(data.top_container != null &&
				data.top_container.ad_control != null &&
				data.top_container.ad_control.ad_images.length > 0){

				var top_container_details =
				'<div class="form-group">'+
				'<label class="control-label " '+
				'for="toptarget">Target</label>'+
				'<input class="form-control" id="toptarget" '+
				'name="old_toptarget" placeholder="add URL" type="text" '+
				'value="'+ data.top_container.ad_control.ad_images[0].target+
				'"/></div><div class="form-group ">'+
				'<label class="control-label " for="toptmage">Image</label>'+
				'<button type="button" class="btn btn-black '+
				'small-container-btn scb-top btn-close-top pull-right" '+
				'data-id="'+
				data.top_container.ad_control.ad_images[0].id+'" data-src="'+
				data.top_container.ad_control.ad_images[0].temp_path+
				'"><i class="fa fa-times-thin fa-2x" '+
				'style="margin-top:0.4px;vertical-align:top"></i></button>'+
				'<div class="right-top-image"><img src="'+
				slider_path+data.top_container.ad_control.ad_images[0].id+
				'/'+data.top_container.ad_control.ad_images[0].temp_path+
				'" style="object-fit:cover;height:100%;width:100%" '+
				'class="slider_image_top"></div></div>';

			} else {
				var top_container_details = '<div class="form-group">'+
				'<label class="control-label " '+
				'for="toptarget">Target</label>'+
				'<input class="form-control" id="toptarget" '+
				'name="toptarget" placeholder="add URL" '+
				'type="text"/></div><div class="form-group ">'+
				'<label class="control-label " for="toptmage">Image</label>'+
				'<div class="right-top-image">'+
				'<input type="file" style="display: none;" '+
				'name="slider_image_top" data-preview-file-type="text">'+
				'<img src="" class="slider_image_top">'+
				'<button type="button" class="btn btn-danger '+
				'btn-small-top-upload pull-right">'+
				'<i class="fa fa-upload"></i></button></div></div>';
			}
			$(".top-container").html(top_container_details);
		},
		error: function( error ){
			console.log(error);
		}
	});
	e.preventDefault();
	});


  $("#div-right-bimgslider").on("click",function(e){
            $.ajax({
                url: '/admin/general/right_bimage_slider',
                type: 'GET',
                success: function( data ){
					var slider_path = $("#slider_path").val();
					if(data.bottom_container != null && data.bottom_container.ad_control != null && data.bottom_container.ad_control.ad_images.length > 0){
						var bottom_container_details = '<div class="form-group">'+
						'<label class="control-label " for="bottomtarget">Target</label>'+
                        '<input class="form-control" id="bottomtarget" name="old_bottomtarget" placeholder="add URL" value="'+data.bottom_container.ad_control.ad_images[0].target+'" type="text"/></div>'+
						'<div class="form-group ">'+
						'<label class="control-label " for="bottomImage">Image</label>'+
						'<button type="button" class="btn btn-black small-container-btn scb-bottom btn-close-bottom pull-right" data-id="'+data.bottom_container.ad_control.ad_images[0].id+'" data-src="'+data.bottom_container.ad_control.ad_images[0].temp_path+'"><i class="fa fa-times-thin fa-2x" style="vertical-align:top;margin-top:0.4px"></i></button>'+
                          '<div class="right-bottom-image">'+
                          '<img src="'+slider_path+data.bottom_container.ad_control.ad_images[0].id+'/'+data.bottom_container.ad_control.ad_images[0].temp_path+'" " style="object-fit:cover;height:100%;width:100%" class="slider_image_bottom"></div></div>';
                  }
                  else {
                var bottom_container_details = '<div class="form-group">'+
                          '<label class="control-label " for="bottomtarget">Target</label>'+
                        '<input class="form-control" id="bottomtarget" name="bottomtarget" placeholder="add URL" type="text"/></div>'+
                          '<div class="form-group ">'+
                          '<label class="control-label " for="bottomImage">Image</label>'+
                          '<div class="right-bottom-image">'+
                          '<input type="file" style="display: none;" name="slider_image_bottom" data-preview-file-type="text">'+
                          '<img src="" class="slider_image_bottom">'+
                          '<button type="button" class="btn btn-danger btn-small-bottom-upload pull-right"><i class="fa fa-upload"></i></button></div></div>';
                  }
                  $(".bottom-container").html(bottom_container_details);
                },
                error: function( error ){
                    console.log(error);
                }
            });
            e.preventDefault();
    });

	/* get oshop images section images */

	$("#oshop_images").on("click",function(e){
		$.ajax({
			url: '/admin/general/oshop_slider',
			type: 'GET',
			success: function(data){
				//console.log(data.oshop);
				var slider_path = $("#slider_path").val();
				if(data.max != null && data.max !=undefined) {
					var max = data.max;
				} else {
					var max = 6;
				}

				var target='<select class="form-control target_dropdown" '+
					'name="target[]" placeholder="add URL">';
				$.each(data.oshop,
					function(index, val) {
					target+='<option value="'+val.url+'">'+val.oshop_name+'</option>';
				});
				target+="</select>";

				if(data.oshop_container != null &&
					data.oshop_container.ad_control != null &&
					data.oshop_container.ad_control.ad_images.length > 0){

					var oshop_container_details = "";
					var count = 0;
					var loop = 0;

					$.each(data.oshop_container.ad_control.ad_images ,
						function(index, val) {
						// console.log("FOO:"+index);
						// console.log("BAR:"+JSON.stringify(val));
						count++;
				
						if(index=="0" || loop=="0"){
							oshop_container_details+='<div class="row">';            
						}

						loop++;

						/*if(loop=="0"){
						console.log('inside loop');
						oshop_container_details+='<div class="row">';            
						}*/


            var old_target='<select class="form-control target_dropdown" '+
              'name="old_target[]" placeholder="add URL">';
            var target = val.target;  
            $.each(data.oshop,
              function(index, val) {
              var selected = (val.url == target) ? "selected" : "";
              old_target+='<option value="'+val.url+'"' +selected+ '>'+val.oshop_name+'</option>';
            });
            old_target+="</select>";               

						oshop_container_details +=
						'<div class="col-sm-6" id="image_'+val.id+
						'"><div class="form-group">'+
						'<label class="control-label " for="target">Target</label>'+old_target+
            '<input type="hidden" value="'+val.id+
            '" name="ids[]">'+
						'</div>'+
						'<div class="form-group">'+
						'<label class="control-label top_space" for="oshopImage">Image</label>'+
						'<button type="button" class="btn btn-black '+
						'small-container-btn scb-oshop btn-close-oshop '+
						'pull-right" data-id="'+
						val.id+'" data-src="'+val.temp_path+
						'"><i class="fa fa-times-thin fa-2x" '+
						'style="margin-top:0.4px;vertical-align:top">'+
						'</i></button><div class="oshop-image" '+
						'style="border-color:#d0d0d0">'+
						'<img src="'+slider_path+val.id+'/'+val.temp_path+
						'" style="object-fit:cover;'+
						'height:100%;width:100%" '+
						'class="oshop_images"></div></div></div>';

						if(count==max || loop=="2"){
						   oshop_container_details+='</div>';            
						}

						if(loop=="2") {
						  loop=0;
						}
					});

				
					for (i = 1; i <= (max - data.oshop_container.ad_control.ad_images.length) ; ++i) {
						count++;

						if(loop=="0"){
						   oshop_container_details+='<div class="row">';
						}

						loop++;

						oshop_container_details +=
						'<div class="col-sm-6"><div class="form-group">'+
						'<label class="control-label " for="target">'+
						'Target</label>'+target+ '</div>'+
						'<div class="form-group ">'+
						'<label class="control-label top_space" for="oshopImage">Image</label>'+
						'<div class="oshop-image" style="border-color:#d0d0d0">'+
						'<input type="file" style="display: none;" '+
						'name="slider_oshop_image[]" data-preview-file-type="text" '+
						'data-count="'+
						(data.oshop_container.ad_control.ad_images.length+i)+'">'+
						'<img src="" class="oshop_images_'+
						(data.oshop_container.ad_control.ad_images.length+i)+'">'+
						'<button type="button" class="btn btn-danger '+
						'btn-oshop-upload pull-right">'+
						'<i class="fa fa-upload"></i></button></div></div></div>';

						if(count==max || loop=="2"){
						   oshop_container_details+='</div>';            
						}

						if(loop=="2") {
						  loop = 0;
						}
					}

				} else {
					var i;
					var container_count= 0;
					var container_loop = 0;
					var oshop_container_details = "";
							
					for (i = 1; i <= max; ++i) {
						container_count++;
						if(container_count=="0" || container_loop=="0"){
							oshop_container_details+='<div class="row">';            
						}
						container_loop++;
						oshop_container_details +=
						'<div class="col-sm-6"><div class="form-group">'+
						'<label class="control-label " for="target">'+
						'Target</label>'+target+ '</div>'+
						'<div class="form-group ">'+
						'<label class="control-label top_space" for="oshopImage">'+
						'Image</label>'+
						'<div class="oshop-image" style="border-color:#d0d0d0">'+
						'<input type="file" style="display: none;" '+
						'name="slider_oshop_image[]" '+
						'data-preview-file-type="text" '+
						'data-count="'+i+'">'+
						'<img src="" class="oshop_images_'+i+'">'+
						'<button type="button" class="btn btn-danger '+
						'btn-oshop-upload pull-right">'+
						'<i class="fa fa-upload">'+
						'</i></button></div></div></div>';

						if(container_count==max || container_loop=="2"){
						   oshop_container_details+='</div>';            
						}

						if(container_loop=="2") {
						  container_loop = 0;
						}
					}
				}

				$(".oshop-container").html(oshop_container_details);
				$(".target_dropdown").select2();
			},
			error: function( error ){
				console.log(error);
			}
		});
		e.preventDefault();
	});

	$(document).on("click",".btn-close-top",function(){
		if(confirm("Want to delete top image?") == true) {
		$.ajax({
			url: '/admin/general/slider/delete',
			type: 'POST',
			data:{'id':$(this).data('id'),
				'_token':$("input[name=_token]").val(),
				'path':$(this).data('src')},
			success: function(data){
				$(".top-container").empty();
				$(".top-container").html('<div class="form-group">'+
				'<label class="control-label " for="toptarget">Target</label>'+
				'<input class="form-control" id="toptarget" '+
				'name="toptarget" placeholder="add URL" type="text"/></div>'+
				'<div class="form-group ">'+
				'<label class="control-label " for="toptmage">Image</label>'+
				'<div class="right-top-image">'+
				'<input type="file" style="display: none;" '+
				'name="slider_image_top" data-preview-file-type="text">'+
				'<img src="" height="150px" class="slider_image_top">'+
				'<button type="button" class="btn btn-danger '+
				'btn-small-top-upload pull-right">'+
				'<i class="fa fa-upload"></i></button></div></div>');

				//alert("Successfully deleted Slider Image");
				$("#landingTopRightModal").modal("hide");
				toastr.success('<div><p>Successfully deleted Slider Image</p></div>');
				//location.reload();
			},
			error: function(error){
				console.log(error);
			}
		});
		}
	});

	$(document).on("click",".btn-close-bottom",function(){
		if(confirm("Want to delete bottom image?") == true) {
		$.ajax({
			url: '/admin/general/slider/delete',
			type: 'POST',
			data:{'id':$(this).data('id'),
				'_token':$("input[name=_token]").val(),
				'path':$(this).data('src')},
			success: function(data){
				$(".bottom-container").empty();
				$(".bottom-container").html('<div class="form-group">'+
				'<label class="control-label" for="bottomtarget">Target</label>'+
				'<input class="form-control" id="bottomtarget" '+
				'name="bottomtarget" placeholder="add URL" type="text"/></div>'+
				'<div class="form-group ">'+
				'<label class="control-label " for="bottomImage">Image</label>'+
				'<div class="right-bottom-image">'+
				'<input type="file" style="display: none;" '+
				'name="slider_image_bottom" data-preview-file-type="text">'+
				'<img src="" height="150px" class="slider_image_bottom">'+
				'<button type="button" class="btn btn-danger '+
				'btn-small-bottom-upload pull-right">'+
				'<i class="fa fa-upload"></i></button></div></div>');

				//alert("Successfully deleted Slider Image");
				$("#advertsmall_bimage_form").modal("hide");
				toastr.success('<div><p>Successfully deleted Slider Image</p></div>');
				location.reload();
			},
			error: function(error){
				console.log(error);
			}
		});
		}
	});


	$(document).on("click",".btn-close-oshop",function(){
		if(confirm("Want to delete O-Shop image?") == true) {
			var id = $(this).data('id');

			$.ajax({
				url: '/admin/general/oshop_slider',
				type: 'GET',
				success: function(data){

				var target='<select class="form-control target_dropdown" name="target[]" placeholder="add URL">';
				$.each(data.oshop,
					function(index, val) {
					target+='<option value="'+val.url+'">'+
						val.oshop_name+'</option>';
				});
				target+="</select>";

				$("input[name='delete_oshop_image']").
					val($("input[name='delete_oshop_image']").val()+","+id);
				$("#image_"+id).empty();
				$("#image_"+id).html('<div class="form-group">'+
				'<label class="control-label " for="target">Target</label>'+target+
				'</div>'+
				'<div class="form-group">'+
				'<label class="control-label" for="oshopImage">Image</label>'+
				'<div class="oshop-image" style="border-color:#d0d0d0">'+
				'<input type="file" style="display: none;" '+
				'name="slider_oshop_image[]" data-preview-file-type="text" '+
				'data-count="'+id+'">'+
				'<img src="" class="oshop_images_'+id+'">'+
				'<button type="button" class="btn btn-danger '+
				'btn-oshop-upload pull-right">'+
				'<i class="fa fa-upload"></i></button></div></div>');

				$(".target_dropdown").select2();
				toastr.success(
					'<div><p>Successfully deleted O-Shop Image</p></div>');
				},
				error:function(error) {
					console.log(error);
				}
			});
		}
	});


	$('.minus').click(function(){
		var v = $(this).closest('.input-group').find('input[type=text]').val();
				
		v= parseInt(v);
		if (v > 0) {
			$(this).closest('.input-group').find('input[type=text]').val(v-1);
		}
				
			});
	$('.add').click(function(){
		var v = $(this).closest('.input-group').find('input[type=text]').val();
		var v = parseInt(v)
		$(this).closest('.input-group').find('input[type=text]').val(v+1);
				
	});

	$(".btn-add-div").on("click",function(){
		var count = 0;
		$('.slider_image_div').each(function(){
			count += 1; 
		});

		$(".new-add-targetdiv").append('<div class="slider-container"><label class="control-label '+
		'form-group" for="target" style="margin-top:20px;">Target </label>'+
		'<input type="text" name="target[]" class="form-control"><br>'+
		'<div class="slider_image_div" '+
		'style="border-style: solid;border-width: 1px; height: 200px;border-color:#c0c0c0">'+
		'<input type="file" style="display:none;" name="slider_image[]" '+
		'data-preview-file-type="text" data-count="'+count+'">'+
		'<img src="" class="slider_'+count+'">'+
		'<button type="button" style="background:#000000; color:#ffffff;" '+
		'class="btn btn-upload pull-right">'+
		'<i class="fa fa-upload"></i></button></div></div>');

		// RefreshAddImageEventListener();
	});

	// $(".slider_image_div").find("input").trigger('click');
	// $(".slider_image_div").on("click",function(){
	// 	$(this).children('input[type="file"]').click();
	// 	return false;
	// });

	// $(".btn-upload").off("click");
	$(".new-add-targetdiv").on("click",".btn-upload",function(e){
		e.preventDefault();
		$(this).parent(".slider_image_div").find("input[name='slider_image[]']").click();
	});

	$(".new-add-targetdiv").on("change","input[name='slider_image[]']",
		function(e){
		e.preventDefault();
		var count = $(this).data("count");
		readURL(this,'.slider_'+count+'');
		$(this).parent(".slider_image_div").
			find('img').
			attr("style","object-fit:cover;height:100%;width:100%");
		return false;
	});

	$(document).on("change","input[name='slider_image_top']",function(e){
		e.preventDefault();
		readURL(this,'.slider_image_top');
		$(this).parent(".right-top-image").
			find('img').
			attr("style","object-fit:cover;height:100%;width:100%");
		return false;
	});

	$(document).on("change","input[name='slider_image_bottom']",function(e){
		e.preventDefault();
		readURL(this,'.slider_image_bottom');
		$(this).parent(".right-bottom-image").
			find('img').
			attr("style","object-fit:cover;height:100%;width:100%");
		return false;
	});

	$(document).on("click",".btn-small-top-upload",function(){
		console.log("top");
		$("input[name='slider_image_top']").click();
	});

	$(document).on("click",".btn-small-bottom-upload",function(){
		console.log("bottom");
		$("input[name='slider_image_bottom']").click();
	});

	$(document).on("change","input[name='slider_oshop_image[]']",function(e){
		e.preventDefault();
		var count = $(this).data("count");
		readURL(this,'.oshop_images_'+count+'');
		$(this).parent(".oshop-image").
			find('img').
			attr("style","object-fit:cover;height:100%;width:100%");
		return false;
	});

	$(document).on("click",".btn-oshop-upload",function(){       
		$(this).parent(".oshop-image").
			find("input[name='slider_oshop_image[]']").click();
	});

	function readURL(input,id) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$(id).attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	$("#div-left-imgslider").slidesjs({
		width:760,
		height:400,
		pagination: false,
		generatePagination: false,
		navigation:{
			active:true,
			effect:"slide"
		},
		play: {
		  active: true,
			// [boolean] Generate the play and stop buttons.
			// You cannot use your own buttons. Sorry.
		  effect: "slide",
			// [string] Can be either "slide" or "fade".
		  interval:5000,
			// [number] Time spent on each slide in milliseconds.
		  auto:true,
			// [boolean] Start playing the slideshow on load.
		  swap: true,
			// [boolean] show/hide stop and play buttons
		  pauseOnHover: false,
			// [boolean] pause a playing slideshow on hover
		  restartDelay: 2500
			// [number] restart delay on inactive slideshow
		}
	});

		$(".oshop").slick({
			dots: false,
			infinite: false,
			slidesToShow: 6,
			slidesToScroll: 1
		});

		$('ul.categories_list li').click(function(e) 
   	{ 
   		var category_id = $(this).data('id');
   		
	   	$.ajax({
			url: '/admin/general/get_sub_category/'+category_id,
			type: 'GET',
			success: function(data){
				if(data!=undefined && data!=""){
					$(".sub_categories_list").html('');
					var sub_categories = "";
					$.each(data,function(index, val) {
							sub_categories+='<li data-id="'+index+'"><a href="/admin/general/advert/subcategory/'+index+'">'+val+'</a></li>';
					});
					$(".sub_categories_list").html(sub_categories);
				}else{
					$(".sub_categories_list").html('');
				}
			},
			error: function(error){
				console.log(error);
			}
		});

   });
});

// Update To Public

$(document).on("click",".btn_update_to_public",function(){
    if(confirm("Want to update all advert publically ?") == true) {
    $.ajax({
      url: '/admin/general/upload_public',
      type: 'POST',
      data:{'_token':$("input[name=_token]").val()},
      success: function(data){
        toastr.success('<div><p>Advert successfully published publically.</p></div>');
      },
      error: function(error){
        console.log(error);
      }
    });
    }
});

$(document).on("click",".hide-button",function(e){
	e.stopPropagation();
	var target = $(this).data('targettype');
	var container = $(this).data('container');
    var hide_button = $(this);
    $.ajax({
		url: '/admin/general/hide_advert/'+target,
		type: 'POST',
		data:{'_token':$("input[name=_token]").val()},
		success: function(data){
		/*
      	console.log(data);
		*/
      	if(data=='1'){
      		hide_button.text('Show');
      		$('.'+container).hide();
      	} else {
      		hide_button.text('Hide');
      		/*console.log($.trim($('.'+container).text()).length);
      		if ($.trim($('.'+container).text()).length == 0){
  					location.reload();	
			}*/

			$('.'+container).show();

			if($('.'+container).hasClass('hide')) {
				$('.'+container).removeClass('hide');
				
				if($('.'+container) == "oshop") {
					$($('.'+container)).slick();				
				} else {
					var slidejs = $("#div-left-imgslider").slidesjs();
					slidejs.resize();
				}
			}
      	}
        toastr.success('<div><p>Advert Updated Successfully.</p></div>');
      },
      error: function(error){
        console.log(error);
      }
    });
    
});

/*$('#oshop_images').on("click","a",function(e){
	  e.stopPropagation();
});*/
</script>
@stop
