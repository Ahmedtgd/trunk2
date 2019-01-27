@extends('common.default')
@section('content')
    <style>
		html {
			overflow: -moz-scrollbars-vertical;
		}
	
        .easy-autocomplete {
            width: 100% !important;
        }
        .easy-autocomplete-container {
            width: 250px !important;
        }

        li.selected {
            outline: 1px solid #27A98A;
        }
        select label {
            display: inline;
        }

		/* This is the magical stanza for the misaligned header
		 * problem which has been affecting datatables! */
        table.dataTable th, td {
            max-width: 180px !important;
            word-wrap: break-word
        }

        .details-control, .details-control-2 {
            cursor: pointer;
        }

        td.details-control:after, td.details-control-2:after {
            font-family: 'FontAwesome';
            content: "\f0da";
            color: #303030;
            font-size: 17px;
            float: right;
            padding-right: 25px;
        }

        tr.shown td.details-control:after, tr.shown td.details-control-2:after {
            content: "\f0d7";
        }

        .child_table {
            margin-left: 78px;
            width: 920px;;
        }

        .panel {
            border: 0;
        }

        table {
			table-layout: auto !important;
            counter-reset: Serial;
        }

        table.counter_table tr td:first-child:before {
            counter-increment: Serial; /* Increment the Serial counter */
            content: counter(Serial); /* Display the counter */
        }

        .badge-checkbox {
            -webkit-appearance: checkbox;
            -moz-appearance: checkbox;
            -ms-appearance: checkbox;
        }

        table.popup-table th{
            text-align: center;
            background: #337AB7;
            color : #fff;
        }

        table.popup-table tbody td {
            text-align: center;
        }

		.old-value:hover {
			text-decoration: underline;
		}

		.edit_pro:hover {
			text-decoration: underline;
		}

        .margin-top {
            margin-left: -15px;
            margin-right: -15px;
        }

        label.err {
            font-size: 12px;
            color : red;
            font-weight: normal;
        }

        input.errorBorder, span.errorBorder {
            border: 1px solid #F00;
        }

        .errorBorder {
            border: 1px solid #F00;
        }

        .errorDoubleBorder {
            border: 2px solid #F00;
        }

        .errorBorderIng {
            border: 1px solid #F00;
            border-radius: 5px 0px 0px 5px;
        }

        .die {
            pointer-events: none;
            cursor: default;
            opacity: 0.6;
        }

        .li_same_size {
            width: 37px;
            height: 37px;
        }

        form input.error, form select.error, form textarea.error {
            background-color: #FFFFC8 !important;
            border: 1px solid #F00 !important;
        }

        .mt {
            margin-top: 10px;
        }

        table#tab-product-detail {
            table-layout: fixed;
            max-width: none;
            width: auto;
            min-width: 100%;
        }

        /* Start by setting display:none to make this hidden.
       Then we position it in relation to the viewport window
       with position:fixed. Width, height, top and left speak
       speak for themselves. Background we set to 80% white with
       our animation centered, and no-repeating */
        .modal_loading {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(255, 255, 255, .8) url('http://sampsonresume.com/labs/pIkfp.gif') 50% 50% no-repeat;
        }

        /* When the body has the loading class, we turn
           the scrollbar off with overflow:hidden */
        body.loading {
            overflow: hidden;
        }

        /* Anytime the body has the loading class, our
           modal element will be visible */
        body.loading .modal_loading {
            display: block;
        }
        #imagePreviewDiscount {
           position: absolute;
            left: 0;
            height: 170px;
        }
        #imagePreviewVoucher {
           position: absolute;
            left: 0;
            height: 304px;
        }      
		#imagePreviewVoucherv1 {
           position: absolute;
            left: 0;
            height: 304px;
        }		
		#imagePreviewVoucherv2 {
           position: absolute;
            left: 0;
            height: 304px;
        }
		
		#imagePreviewVouchercoverv2 {
            left: 0;
            height: 200px;
        }		

		.upld-signboard {
			border: 1px solid #918F90;
			height: 320px;
			margin: 20px 0;
		}		
		
		.upld-jc {
			border: 1px solid #918F90;
			height: 330px;
			margin: 20px 0;
		}		
		
		.upld-jc .badge-close {
			background: #000;
			border-radius: 0;
			position: absolute;
			right: -10px;
			top: -10px;
			z-index: 9;
		}		
    </style>
	<div class="container"><!--Begin main container-->
        <div class="row">	
			<h2>Telco Mobile Top Up</h2>
			{!! Form::open(['id'=>'productRegForm', 'style'=>'margin-bottom:0;margin-top:0', 'class'=> 'form-horizontal','files' => true]) !!}
				<div class="col-sm-11"><p class="pull-right">Add Product <a class="text-green" id="add_jc"><i class="fa fa-lg fa-plus-circle"></i></a></p></div><div class="col-sm-1"></div>
				<div id="append-jc-0" class="col-sm-offset-0" rel="0">
					<div class="col-sm-11 upld-jc main-parent">
						<div class="col-sm-4 thumbnail" id='thumbnail' style="margin-top: 10px;">
							<div class="product-photo">
								<img class=""  id="preview-img0"
								style="width:345px;height:98%;object-fit:cover;object-position:center top"/>
								<div class="inputBtnSection">
									{!! Form::text('photo',null,['class'=>'disableInputField text-center uploadFilen','id'=>'uploadFile','placeholder'=>'345 x 300','disabled'=>'disabled']) !!}
									<label class="fileUpload">
										{!! Form::file('product_photo[]',['class'=>'upload uploadBtnn','id'=>'uploadBtn0', 'rel'=>'0','required']) !!}
										<span class="uploadBtn badge"><i class="fa fa-lg fa-upload"></i> </span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-sm-4" style="margin-top: 10px; ">
							<div style="margin-bottom:5px; " class="form-group">
								{!! Form::label('name', 'Name', array('style' => 'margin-left: 20px;')) !!}
								<div style="margin-left: 20px;">
								<select id="telcoid0" name="telcoid[]" class="telcoid" rel="0" >
									<option value="">Select value...</option>
									@foreach($telcos as $telco)
										<option value="{{$telco->id}}">{{$telco->description}}</option>
									@endforeach
								</select>
								</div>
							</div>
						</div>
						<div class="col-sm-1" style="margin-top: 10px;">
						</div>
						<div class="col-sm-2" style="margin-top: 10px;">
							<div style="margin-bottom:5px" class="form-group">
								{!! Form::label('price', 'Price', array('style' => 'margin-left: 20px;')) !!}
								<input name="price0[]" class="form-control pricesn" type="number" value="5" min="5" max="200000" />
								<div id="prices0">
								</div>
							</div>
						</div>
						<div class="col-sm-1" style="margin-top: 25px;">
							<center><h3><a  href="javascript:void(0);" id="addprice" rel="0" class="text-green addprice"><i class="fa fa-plus-circle"></i></a></h3></center>
							<div id="sign0">
							</div>
						</div>
					</div>
					<input type="hidden" id="mycurrent0" value="0" />
				<div class="clearfix"></div>														
				</div>
				<div id="products">
				</div>
				<div class="col-sm-11" style="margin-bottom: 20px;"><a href="javascript:void(0)" id="save_jc" class="btn btn-info pull-right">Save products</a></div><div class="col-sm-1"></div>
				<input type="hidden" id="mycurrent" value="0" />
				{!! Form::close() !!}
		</div>
	</div>
	<script type="text/javascript" src="{{url('js/bootstrap-number-input.js')}}"></script>
	<script>
		$(document).ready(function () {
			var _URL = window.URL || window.webkitURL;
			$('.pricesn').bootstrapNumber();
			$('body').on('click',"#save_jc", function () {
				var fdata = new FormData($("#productRegForm")[0]);
				$.ajax({
					  url: JS_BASE_URL + '/jc/save_jc',
					  data: fdata,
					  dataType:'json',
					  async:false,
					  type:'post',
					  processData: false,
					  contentType: false,
					  success:function(response){
							console.log(response);
							toastr.info("Products succesfully saved!");
					  },
					  error:function( jqXHR, textStatus, errorThrown ){
						  $("#next_retail_spinner").hide();
						  toastr.error("An unexpected error ocurred, please, try again or contact OpenSupport");
					  }
					});
			});
			$('body').on('change',".uploadBtnn", function () {
				var rel = $(this).attr("rel");
			   var uploadbtn = this;
			   var file = this.files[0];
			   var img = new Image();
			   var sizeKB = file.size / 1024;
			   img.onload = function() {
					var img_width = img.width;
					var img_height = img.height;
					x = $("#uploadBtn" + rel).val();
					readURLSinglen(uploadbtn, 'preview-img' + rel);			
			   }
			   img.src = _URL.createObjectURL(file);		
			});			 
			
			$('body').on('click','.remprice', function () {
				 var rel = $(this).attr("rel");
				 var nrel = $(this).attr("nrel");				
				$("#prices" + rel +'-'+nrel).remove();
				$("#sign" + rel +'-'+nrel).remove();
			});
			
			$('body').on('click','.remjc', function () {
				 var rel = $(this).attr("rel");
				 $("#append-jc-"+rel).remove();
			});
			
			$('body').on('click','.addprice', function () {
				 var rel = $(this).attr("rel");
				 var current = parseInt($("#mycurrent" + rel ).val());
				 current++;
				 $("#mycurrent" + rel).val(current)
				 $("#prices" + rel).append('<div id="prices'+rel+'-'+current+'"><input name="price'+rel+'[]" class="form-control pricesn" id="price'+rel+'-'+current+'" type="number" value="5" min="5" max="200000" /></div>');
				 $("#sign" + rel).append('<center id="sign'+rel+'-'+current+'" style="margin-top: 10px;"><h3><a  href="javascript:void(0);" rel="'+rel+'" nrel="'+current+'" class="text-danger remprice"><i class="fa fa-minus-circle"></i></a></h3></center>');
				 $('#price'+rel+'-'+current).bootstrapNumber();
			});
			 
			$('body').on('click','#add_jc', function () {
				var current = parseInt($("#mycurrent").val());
				current++;
				var newproduct = '<div id="append-jc-'+current+'" class="col-sm-offset-0" rel="'+current+'">';
					newproduct += '<div class="col-sm-11 upld-jc main-parent">';
						newproduct += '<a class="badge badge-close remjc" rel="'+current+'" data-id="">X</a>';
					newproduct += '	<div class="col-sm-4 thumbnail" id="thumbnail" style="margin-top: 10px;">';
						newproduct += '	<div class="product-photo">';
					newproduct += '			<img class=""  id="preview-img'+current+'"';
						newproduct += '		style="width:345px;height:98%;object-fit:cover;object-position:center top"/>';
					newproduct += '			<div class="inputBtnSection">';
						newproduct += '		<input class="disableInputField text-center uploadFilen" id="uploadFile" placeholder="345 x 300" disabled="disabled" name="photo" type="text">';
						newproduct += '			<label class="fileUpload">';
						newproduct += '				<input class="upload uploadBtnn" id="uploadBtn'+current+'" rel="'+current+'" required="required" name="product_photo[]" type="file">';
						newproduct += '				<span class="uploadBtn badge"><i class="fa fa-lg fa-upload"></i> </span>';
						newproduct += '			</label>';
						newproduct += '		</div>';
						newproduct += '	</div>';
						newproduct += '</div>';
						newproduct += '<div class="col-sm-4" style="margin-top: 10px; ">';
						newproduct += '	<div style="margin-bottom:5px" class="form-group">';
						newproduct += '			<label for="name" style="margin-left: 20px;">Name</label>';
						newproduct += '			<div style="margin-left: 20px;">';
						newproduct += '		<select id="telcoid'+current+'" name="telcoid[]" class="telcoid" rel="'+current+'" >';
						newproduct += '				<option value="">Select value...</option>';
									@foreach($telcos as $telco)
						newproduct += '	   <option value="{{$telco->id}}">{{$telco->description}}</option>';
									@endforeach
						newproduct += '			</select>';
						newproduct += '			</div>';
						newproduct += '	</div>';
						newproduct += '</div>';
						newproduct += '<div class="col-sm-1" style="margin-top: 10px;">';
						newproduct += '</div>';
						newproduct += '<div class="col-sm-2" style="margin-top: 10px;">';
						newproduct += '	<div style="margin-bottom:5px" class="form-group">';
						newproduct += '			<label for="price" style="margin-left: 20px;">Price</label>';
						newproduct += '			<input name="price'+current+'[]" class="form-control pricesn'+current+'" type="number" value="5" min="5" max="200000" />';
						newproduct += '		<div id="prices'+current+'">';
						newproduct += '		</div>';
						newproduct += '	</div>';
						newproduct += '</div>';
						newproduct += '<div class="col-sm-1" style="margin-top: 25px;">';
						newproduct += '	<center><h3><a  href="javascript:void(0);" id="addprice" rel="'+current+'" class="text-green addprice"><i class="fa fa-plus-circle"></i></a></h3></center>';
						newproduct += '	<div id="sign'+current+'">';
						newproduct += '	</div>';
						newproduct += '</div>';
					newproduct += '</div>';
					newproduct += '<input type="hidden" id="mycurrent'+current+'" value="0" />';
				newproduct += '<div class="clearfix"></div>';													
				newproduct += '</div>';
				$("#products").append(newproduct);
				$('#telcoid' + current).select2();
				$('.pricesn' + current).bootstrapNumber();
			});			
			
			function readURLSinglen(input, id) {
				var fileTypes = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'xls'];  //acceptable file types

				if (input.files && input.files[0]) {
					var extension = input.files[0].name.split('.').pop().toLowerCase(), //file extension from input file
						isSuccess = fileTypes.indexOf(extension) > -1;  //is extension in acceptable types
					if (isSuccess) { //yes
						var reader = new FileReader();
						reader.onload = function (e) {
							$('#' + id).attr('src', e.target.result);
						}
						reader.readAsDataURL(input.files[0]);
					}
					else { //no
						alert('Warning: Type mismatch')
					}
				}
            }			 
		});
	</script>
@stop
