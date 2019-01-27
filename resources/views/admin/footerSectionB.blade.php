@extends("common.default")

@section("content")

<style type="text/css">
	.save-form .note-editor{margin-bottom: 2px!important;}
	.clear {clear:both;}

	.thumb-image {
		width: 308px;
		height: 190px;
	}
	input.hidden {
		position: absolute;
		left: -9999px;
	}



	.uploadIMG {
		cursor: default;
		background: #AAA;
		width: 320px;
		height: 250px;
		color: black;
		text-align: center;
		border: 5px solid #f2f2f2;
		background-size: 315px 200px;
		background-position: center; 
		padding-top: 25px;
		padding-bottom: 25px;
		border-radius: 4px;
		margin-bottom: 5px;
	}

	.profile-image {
		position: relative;
		top: 90px;
	}
	.cursor {
		cursor: pointer;
		font-size: 16px;
		font-weight: 600;
	}
	
	.icon {
		height: 20px;
		border: 5px solid #0d0d0d;
		background: #0d0d0d;
		height: 28px;
		width: 30px;
		margin-left: 260px;
		margin-top: 155px;
		border-radius: 10px;
		color: #fff;

	}
	.input_fields_wrap {
		width: 535px;
		float: right;
	}
	.input_fields_wrap .inline {
		display: inline-block;
	}
	label.mlabel input[type="file"] {
		position: fixed;
		top: -1000px;
	}

	/***** Example custom styling *****/
	.mlabel {
		border: 2px solid #AAA;
		border-radius: 4px;
		padding: 2px 5px;
		margin: 2px;
		background: #DDD;
		display: inline-block;
		width: 100px;
		text-align: center;
	}
	.mlabel:hover {
		background: #CCC;
	}
	.mlabel:active {
		background: #CCF;
	}
	.mlabel :invalid + span {
		color: #A44;
	}
	.mlabel :valid + span {
		color: #4A4;
	}

	.upload {
		border-radius: 5px;
		padding-left: 5px;
		width: 400px;
	}

	.mini-container {
		width: 900px;
		margin: auto;
	}
	.margin {
		margin-left: 4px;
		margin-right: 6px;
	}

	.closeBtn:hover {
		color: red !important;
	}
	.Xphoto {
		cursor:pointer; 
		display:block !important; 
		width:20px; 
		margin-top:-8%;
		margin-left:93%; 
		color:black;
	}	



</style>
<div class="container" style="margin-top:30px;">
	@include('admin/panelHeading')
	<div class="equal_to_sidebar_mrgn">
		<div id="alert-info"></div>
		<div class="row">	
			<div class="col-md-12">
				<h3>Footer: Section B</h3><br>
				<form class="save-form" id="allRight" action="#">
					<h4>All Rights Reserved </h4>
					<div class="summernote" id="summernoteAllRight">
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
				
				<h4>Download Apps</h4><br>
				<div class = "mini-container">
					<div class="input_fields_wrap">
						<input type="text" name="mytext[]" placeholder="Description of file" class="upload">
						<label class="mlabel">
							<input type="file" required/>
							<span>Upload</span>
						</label>
						<a class="add_field_button text-green" href="#"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
					</div>


					<div class="uploadIMG"> <span class="profile-image cursor">Add Image</span>
						<input class="profile-image-upload hidden" type="file">
						<div class="pic">
							<i class="fa fa-upload icon" aria-hidden="true"></i>
						</div>
					</div>

					<div class="uploadIMG"> <span class="profile-image cursor">Add Image</span>
						<input class="profile-image-upload hidden" type="file">
						<div class="pic">
							<i class="fa fa-upload icon" aria-hidden="true"></i>
						</div>
					</div>

					<div class="uploadIMG"> <span class="profile-image cursor"> Add Image</span>
						<input class="profile-image-upload hidden" type="file">
						<div class="pic">
							<i class="fa fa-upload icon" aria-hidden="true"></i>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>


<script>
	$(document).ready(function() {

		$('.summernote').summernote({
		  minHeight: 100,             // set minimum height of editor
		  maxHeight: 200,             // set maximum height of editor
		  callbacks: {
		  	onImageUpload: function(image){
		  		uploadImage(image[0], $(this));
		  	}
		  },
		  codemirror: { // codemirror options
		  	theme: 'monokai',
		  	lineNumbers: true,
		  	tabMode: "indent",
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

   $(function() {
   	$(".profile-image").on('click', function() {
   		$(this).siblings('.profile-image-upload').click();
   	});
   });

   $(document).ready(function() {
	    var max_fields      = 50; //maximum input boxes allowed
	    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
	    var add_button      = $(".add_field_button"); //Add button ID
	    
	    var x = 1; //initlal text box count
	    $(add_button).click(function(e){ //on add input button click
	    	e.preventDefault();
	        if(x < max_fields){ //max input box allowed
	            x++; //text box increment
	            $(wrapper).append('<div class="input_fields_wrap"><input type="text" name="mytext[]" placeholder="Description of file" class="upload"><label class="mlabel margin"><input type="file" required/><span>Upload</span></label><a href="#" class="remove_field remRem text-danger"><i class="fa fa-minus-circle" aria-hidden="true"></i></a></div>'); //add input box
	        }
	    });
	    
	    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
	    	e.preventDefault(); $(this).parent('div').remove(); x--;
	    })
	});

   $(".hidden").on('change', function () {

   	if (typeof (FileReader) != "undefined") {

   		var image_holder = $(this).parent().closest('.uploadIMG');
   		$(this).siblings("span.profile-image").hide();
   		$(this).siblings("div.pic").hide();

   		var reader = new FileReader();
   		reader.onload = function (e) {

   			$(image_holder).css({"background-image": "url(" + e.target.result + ")", "background-repeat":"no-repeat"});
   			var Xphoto = '<div class="Xphoto closeBtn" id="Xphoto"><span id="closeboton" class="fa fa-times-circle fa-lg " title="remove"></span></div>';
   			image_holder.append(Xphoto);

   			$(".Xphoto").on('click',function(){
   				$(this).siblings("span.profile-image").show();
   				$(this).siblings("div.pic").show();
   				$(this).siblings("input.profile-image-upload").val("");
				$(this).closest('div.uploadIMG').css({"background-image": "url('/images/upload.png')"});
   				$(this).remove();
   			});

   		}
   		image_holder.show();
   		reader.readAsDataURL($(this)[0].files[0]);
   	} else {
   		alert("This browser does not support FileReader.");
   	}
   });


   // $(function () {
   // 	$("#Xphoto").on("click", function () {
   // 		// $(this).closest('.uploadIMG').css({"background-image": "url('images/upload.png')","background-size":"75% 25%"});
   // 		// $(this).parent().find(".uploadIMG").css({"background-image": "url('images/upload.png')","background-size":"75% 25%"});
   // 		$(this).hide();

   // 	});
   // });


</script>

<script type="text/javascript">
	$(document).ready(function(){
	});

</script>


@stop

@section("extra-links")
<link rel="stylesheet" href="{{asset('/css/spinner.css')}}"/>
@stop
@section("scripts")
<script src="{{asset('/js/footer-section.js')}}"></script>
@stop