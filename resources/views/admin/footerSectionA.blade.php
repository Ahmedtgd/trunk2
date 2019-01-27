@extends("common.default")

@section("content")

<style type="text/css">
	.save-form .note-editor{margin-bottom: 2px!important;}
	.clear {clear:both;}
</style>
<div class="container" style="margin-top:30px;">
	@include('admin/panelHeading')
	<div class="equal_to_sidebar_mrgn">
		<div id="alert-info"></div>
		<div class="row">	
			<div class="col-md-12">
				<!-- `id`, `about_us`, `private_policy`, `how_to_buy`, `how_to_return`, `how_to_sell`, `terms_and_conditions` -->
				<h3>Footer: Section A</h3><br>

				<form class="save-form" id="aboutUs" action="{{ url('admin/footerSectionA/save') }} ">
					<h4>About Us </h4>
					<div class="summernote" id="summernoteAboutUs">
						{!! $data['about_us'] !!}
					</div>
					<div class="alert mainAlert fade in">
						<button type="button" class="close" onclick="$(this).parent().hide();">×</button>
						<div class="alert-content"></div>
					</div>
					<div class="form-group">
						<font class="currentalerr pull-left" color="red"></font>
						<button type="submit" class="btn btn-primary save-button pull-right">Save</button>
						<div class="sk-circle pull-right">
							<div class="sk-circle1 sk-child"></div>
							<div class="sk-circle2 sk-child"></div>
							<div class="sk-circle3 sk-child"></div>
							<div class="sk-circle4 sk-child"></div>
							<div class="sk-circle5 sk-child"></div>
							<div class="sk-circle6 sk-child"></div>
							<div class="sk-circle7 sk-child"></div>
							<div class="sk-circle8 sk-child"></div>
							<div class="sk-circle9 sk-child"></div>
							<div class="sk-circle10 sk-child"></div>
							<div class="sk-circle11 sk-child"></div>
							<div class="sk-circle12 sk-child"></div>
						</div>
						<div class="clear"></div>
					</div>
				</form>
				<hr>

				<form class="save-form" id="PrivatePolicy" action="{{ url('admin/footerSectionA/save') }} ">
					<h4>Private Policy </h4>
					<div class="summernote" id="summernotePrivatePolicy">
						{!! $data['private_policy'] !!}					
					</div>
					<div class="alert mainAlert fade in">
						<button type="button" class="close" onclick="$(this).parent().hide();">×</button>
						<div class="alert-content"></div>
					</div>

					<div class="form-group">
						<font class="currentalerr pull-left" color="red"></font>
						<button type="submit" class="btn btn-primary save-button pull-right">Save</button>
						<div class="sk-circle pull-right">
							<div class="sk-circle1 sk-child"></div>
							<div class="sk-circle2 sk-child"></div>
							<div class="sk-circle3 sk-child"></div>
							<div class="sk-circle4 sk-child"></div>
							<div class="sk-circle5 sk-child"></div>
							<div class="sk-circle6 sk-child"></div>
							<div class="sk-circle7 sk-child"></div>
							<div class="sk-circle8 sk-child"></div>
							<div class="sk-circle9 sk-child"></div>
							<div class="sk-circle10 sk-child"></div>
							<div class="sk-circle11 sk-child"></div>
							<div class="sk-circle12 sk-child"></div>
						</div>
						<div class="clear"></div>
					</div>
				</form>
				<hr>

				<form class="save-form" id="HowToBuy" action="{{ url('admin/footerSectionA/save') }} ">
					<h4>How To Buy </h4>
					<div class="summernote" id="summernoteHowToBuy">
						{!! $data['how_to_buy'] !!}
					</div>
					<div class="alert mainAlert fade in">
						<button type="button" class="close" onclick="$(this).parent().hide();">×</button>
						<div class="alert-content"></div>
					</div>

					<div class="form-group">
						<font class="currentalerr pull-left" color="red"></font>
						<button type="submit" class="btn btn-primary save-button pull-right">Save</button>
						<div class="sk-circle pull-right">
							<div class="sk-circle1 sk-child"></div>
							<div class="sk-circle2 sk-child"></div>
							<div class="sk-circle3 sk-child"></div>
							<div class="sk-circle4 sk-child"></div>
							<div class="sk-circle5 sk-child"></div>
							<div class="sk-circle6 sk-child"></div>
							<div class="sk-circle7 sk-child"></div>
							<div class="sk-circle8 sk-child"></div>
							<div class="sk-circle9 sk-child"></div>
							<div class="sk-circle10 sk-child"></div>
							<div class="sk-circle11 sk-child"></div>
							<div class="sk-circle12 sk-child"></div>
						</div>
						<div class="clear"></div>
					</div>
				</form>
				<hr>

				<form class="save-form" id="HowToReturn" action="{{  url('admin/footerSectionA/save') }} ">
					<h4>How To Return </h4>
					<div class="summernote" id="summernoteHowToReturn">
						{!! $data['how_to_return'] !!}
					</div>
					<div class="alert mainAlert fade in">
						<button type="button" class="close" onclick="$(this).parent().hide();">×</button>
						<div class="alert-content"></div>
					</div>
					
					<div class="form-group">
						<font class="currentalerr pull-left" color="red"></font>
						<button type="submit" class="btn btn-primary save-button pull-right">Save</button>
						<div class="sk-circle pull-right">
							<div class="sk-circle1 sk-child"></div>
							<div class="sk-circle2 sk-child"></div>
							<div class="sk-circle3 sk-child"></div>
							<div class="sk-circle4 sk-child"></div>
							<div class="sk-circle5 sk-child"></div>
							<div class="sk-circle6 sk-child"></div>
							<div class="sk-circle7 sk-child"></div>
							<div class="sk-circle8 sk-child"></div>
							<div class="sk-circle9 sk-child"></div>
							<div class="sk-circle10 sk-child"></div>
							<div class="sk-circle11 sk-child"></div>
							<div class="sk-circle12 sk-child"></div>
						</div>
						<div class="clear"></div>
					</div>
				</form>
				<hr>

				<form class="save-form" id="HowToSell" action="{{  url('admin/footerSectionA/save') }} ">
					<h4>How To Sell </h4>
					<div class="summernote" id="summernoteHowToSell">
						{!! $data['how_to_sell'] !!}
					</div>
					<div class="alert mainAlert fade in">
						<button type="button" class="close" onclick="$(this).parent().hide();">×</button>
						<div class="alert-content"></div>
					</div>

					<div class="form-group">
						<font class="currentalerr pull-left" color="red"></font>
						<button type="submit" class="btn btn-primary save-button pull-right">Save</button>
						<div class="sk-circle pull-right">
							<div class="sk-circle1 sk-child"></div>
							<div class="sk-circle2 sk-child"></div>
							<div class="sk-circle3 sk-child"></div>
							<div class="sk-circle4 sk-child"></div>
							<div class="sk-circle5 sk-child"></div>
							<div class="sk-circle6 sk-child"></div>
							<div class="sk-circle7 sk-child"></div>
							<div class="sk-circle8 sk-child"></div>
							<div class="sk-circle9 sk-child"></div>
							<div class="sk-circle10 sk-child"></div>
							<div class="sk-circle11 sk-child"></div>
							<div class="sk-circle12 sk-child"></div>
						</div>
						<div class="clear"></div>
					</div>
				</form>
				<hr>

				<form class="save-form" id="Terms-Conditions" action="{{  url('admin/footerSectionA/save') }} ">
					<h4>Terms & Conditions </h4>
					<div class="summernote" id="summernoteTerms-Conditions">
						{!! $data['terms_and_conditions'] !!}
					</div>
					<div class="alert mainAlert fade in">
						<button type="button" class="close" onclick="$(this).parent().hide();">×</button>
						<div class="alert-content"></div>
					</div>

					<div class="form-group">
						<font class="currentalerr pull-left" color="red"></font>
						<button type="submit" class="btn btn-primary save-button pull-right">Save</button>
						<div class="sk-circle pull-right">
							<div class="sk-circle1 sk-child"></div>
							<div class="sk-circle2 sk-child"></div>
							<div class="sk-circle3 sk-child"></div>
							<div class="sk-circle4 sk-child"></div>
							<div class="sk-circle5 sk-child"></div>
							<div class="sk-circle6 sk-child"></div>
							<div class="sk-circle7 sk-child"></div>
							<div class="sk-circle8 sk-child"></div>
							<div class="sk-circle9 sk-child"></div>
							<div class="sk-circle10 sk-child"></div>
							<div class="sk-circle11 sk-child"></div>
							<div class="sk-circle12 sk-child"></div>
						</div>
						<div class="clear"></div>
					</div>
				</form>
				<hr>
				<form class="save-form" id="mtc" action="{{  url('admin/footerSectionA/save') }} ">
					<h4>Merchant Terms & Conditions </h4>
					<div class="summernote" id="summernotemtc">
						{!! $merchant_tc !!}
					</div>
					<div class="alert mainAlert fade in">
						<button type="button" class="close" onclick="$(this).parent().hide();">×</button>
						<div class="alert-content"></div>
					</div>

					<div class="form-group">
						<font class="currentalerr pull-left" color="red"></font>
						<button type="submit" class="btn btn-primary save-button pull-right">Save</button>
						<div class="sk-circle pull-right">
							<div class="sk-circle1 sk-child"></div>
							<div class="sk-circle2 sk-child"></div>
							<div class="sk-circle3 sk-child"></div>
							<div class="sk-circle4 sk-child"></div>
							<div class="sk-circle5 sk-child"></div>
							<div class="sk-circle6 sk-child"></div>
							<div class="sk-circle7 sk-child"></div>
							<div class="sk-circle8 sk-child"></div>
							<div class="sk-circle9 sk-child"></div>
							<div class="sk-circle10 sk-child"></div>
							<div class="sk-circle11 sk-child"></div>
							<div class="sk-circle12 sk-child"></div>
						</div>
						<div class="clear"></div>
					</div>
				</form>
				<hr>
				<form class="save-form" id="stc" action="{{  url('admin/footerSectionA/save') }} ">
					<h4>Station Terms & Conditions </h4>
					<div class="summernote" id="summernotestc">
						{!! $station_tc !!}
					</div>
					<div class="alert mainAlert fade in">
						<button type="button" class="close" onclick="$(this).parent().hide();">×</button>
						<div class="alert-content"></div>
					</div>

					<div class="form-group">
						<font class="currentalerr pull-left" color="red"></font>
						<button type="submit" class="btn btn-primary save-button pull-right">Save</button>
						<div class="sk-circle pull-right">
							<div class="sk-circle1 sk-child"></div>
							<div class="sk-circle2 sk-child"></div>
							<div class="sk-circle3 sk-child"></div>
							<div class="sk-circle4 sk-child"></div>
							<div class="sk-circle5 sk-child"></div>
							<div class="sk-circle6 sk-child"></div>
							<div class="sk-circle7 sk-child"></div>
							<div class="sk-circle8 sk-child"></div>
							<div class="sk-circle9 sk-child"></div>
							<div class="sk-circle10 sk-child"></div>
							<div class="sk-circle11 sk-child"></div>
							<div class="sk-circle12 sk-child"></div>
						</div>
						<div class="clear"></div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<script>
	$(document).ready(function() {

		$('.summernote').summernote({
		  minHeight: 300,             // set minimum height of editor
		  maxHeight: 500,             // set maximum height of editor
		  callbacks: {
		  	onImageUpload: function(image){
		  		uploadImage(image[0], $(this));
		  	}
		  },
		  codemirror: { // codemirror options
		  	theme: 'monokai',
		  	lineNumbers: true,
            tabMode: "indent"
		  }

		});

 		$(".summernote").on("summernote.change", function (e) {   // callback as jquery custom event 
 			var code = $(this).summernote('code'),
 			filteredContent = code.replace(/\s+/g, '');
 			if(filteredContent.length == 0 || code.replace(/\<(?!img).*?\>/g,'').length == 0) {
 				$(this).parent().find(".note-frame").attr("style","border:1px solid #F00 !important");
 				$(this).parent().find(".currentalerr").attr("color","red").text('This field is required.');
 				$(this).parent().find(".currentalerr").show();
 			} else {
 				$(this).parent().find(".note-frame").attr("style","");
 				$(this).parent().find(".currentalerr").fadeOut("slow");
 			}
 		});

 	});
   // sumernote upload image handler
   function uploadImage(image,editor) {
   	var data = new FormData();
   	data.append("file", image);
   	$.ajax({
   		url: '{{ url("summernote/upload") }}',
   		cache: false,
   		contentType: false,
   		processData: false,
   		data: data,
   		type: "post",
   		success: function(url) {
   			var image = $('<img>').attr('src', url);
   			editor.summernote("insertNode", image[0]);
   		},
   		error: function(data) {
   			console.log(data);
   		}
   	});
   }
</script>


@stop

@section("extra-links")
<link rel="stylesheet" href="{{asset('/css/spinner.css')}}"/>
@stop
@section("scripts")
<script src="{{asset('/js/footer-section.js')}}"></script>
@stop
