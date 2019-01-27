@extends('common.default')
@section('content')

<link rel="stylesheet" type="text/css" href="{{asset('css/dropzone.js')}}">
<style>
        html, body {
        height: 100%;
        }
        #actions {
        margin: 2em 0;
        }


        /* Mimic table appearance */
        div.table {
        display: table;
        }
        div.table .file-row {
        display: table-row;
        }
        div.table .file-row > div {
        display: table-cell;
        vertical-align: top;
        border-top: 1px solid #ddd;
        padding: 8px;
        }
        div.table .file-row:nth-child(odd) {
        background: #f9f9f9;
        }



        /* The total progress gets shown by event listeners */
        #total-progress {
        opacity: 0;
        transition: opacity 0.3s linear;
        }

        /* Hide the progress bar when finished */
        #previews .file-row.dz-success .progress {
        opacity: 0;
        transition: opacity 0.3s linear;
        }

        /* Hide the delete button initially */
        #previews .file-row .delete {
        display: none;
        }

        /* Hide the start and cancel buttons and show the delete button */

        #previews .file-row.dz-success .start,
        #previews .file-row.dz-success .cancel {
        display: none;
        }
        #previews .file-row.dz-success .delete {
        display: block;
        }
</style>
<script type="text/javascript" src="{{asset('js/dropzone.js')}}"></script>
  <script>
    var Dropzone = require("enyo-dropzone");
    Dropzone.autoDiscover = false;
  </script>
<?php 
$routes=Route::getRoutes();
?>
<div class="container" id="container">
	<div class="row">
	<div class="col-xs-12"> <h2>Admin Advertisement Manage</h2></div>
	</div>
	@if(isset($message))
	<div class="row">
		<h4>{{$message}}</h4>
	</div>
	@endif
	<div class="row">
	
	{{-- 
		<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
    	<h3>DropzoneJS Upload Example - http://www.dropzonejs.com/</h3>  
    </div>
  </div><!--/row-->
  <hr>
  <div> 
      <form action="/upload" class="dropzone" drop-zone="" id="file-dropzone"></form>
  </div>
</div>
	 --}}
		<div class="col-xs-12">

	    <fieldset>
	    	<legend>New Advertisement</legend>
	     <div class="form-group ">
	      <label class="control-label requiredField" for="target">
	       Target Page
	       <span class="asteriskField">
	        *
	       </span>
	      </label>
	      <select class="select form-control" id="target" name="target">
	       <option value="" selected>
	        Chose a target page
	       </option>
	       @foreach($targets as $t)
					<option value="{{$t->id}}">{{$t->description}}</option>
			@endforeach
	      </select>
	     </div>
	     <input type="hidden" id="adcontrol_id" value="none" >
	     <div class="form-group ">
	      <label class="control-label " for="height">
	       Height
	      </label>
	      <div class="input-group">
	      <span class="input-group-btn">
		      <button type='button' class="up btn btn-default btn-danger minus"><span class="glyphicon glyphicon-minus"></span></button>
		      </span>
		      <input class="form-control" id="height" name="height" placeholder="numbers" type="text"/>
		      <span class="input-group-btn">
		      <button type='button' class="up btn btn-default btn-info add"><span class="glyphicon glyphicon-plus"></span></button>
	      </span>
	      </div>
	      
	      <span class="help-block" id="hint_height">
	       in pixels
	      </span>
	     </div>
	     <div class="form-group ">
	      <label class="control-label " for="width">
	       Width
	      </label>
	      <div class="input-group">
	      <span class="input-group-btn">
		      <button type='button' class="up btn btn-default btn-danger minus"><span class="glyphicon glyphicon-minus"></span></button>
		      </span>
		      <input class="form-control" id="width" name="width" placeholder="numbers" type="text"/>
		      <span class="input-group-btn">
		      <button type='button' class="up btn btn-default btn-info add"><span class="glyphicon glyphicon-plus"></span></button>
	      </span>
	      </div>
	      
	      <span class="help-block" id="hint_width">
	       in pixels, default to 0
	      </span>
	     </div>
	     <div class="form-group" id="div_nav">
	      <label class="control-label " for="nav">
	       User Navigation
	      </label>
	      <div class="">
	       <label class="radio-inline">
	        <input name="nav" type="radio" value="yes"/>
	        yes
	       </label>
	       <label class="radio-inline">
	        <input name="nav" type="radio" value="no" checked ="checked"/>
	        no
	       </label>
	      </div>
	     </div>
	     <div class="form-group ">
	      <label class="control-label " for="priority">
	       Priority
	      </label>
	      <div class="input-group">
	      <span class="input-group-btn">
		      <button type='button' class="up btn btn-default btn-danger minus"><span class="glyphicon glyphicon-minus"></span></button>
		      </span>
		     <input class="form-control" id="priority" name="priority" placeholder="number" type="text" value="0" />
		      <span class="input-group-btn">
		      <button type='button' class="up btn btn-default btn-info add"><span class="glyphicon glyphicon-plus"></span></button>
	      </span>
	      </div>
		      
	      <span class="help-block" id="hint_priority">
	       optional
	      </span>
		 
	     </div>
	     <div class="form-group ">
	      <label class="control-label " for="rottime">
	       Rotation Time
	       </label>
	      <div class="input-group">
	      <span class="input-group-btn">
		      <button type='button' class="up btn btn-default btn-danger minus"><span class="glyphicon glyphicon-minus"></span></button>
		      </span>
		      <input class="form-control" id="rottime" name="rottime" placeholder="numbers only" type="text"/>
		      <span class="input-group-btn">
		      <button type='button' class="up btn btn-default btn-info add"><span class="glyphicon glyphicon-plus"></span></button>
	      </span>
	      </div>
	      <span class="help-block" id="hint_rottime">
	       in milliseconds
	      </span>
	     </div>
	  {{--    <div class="form-group ">
	      <label class="control-label " for="rottime">
	      	Images
	       </label>
	      <div id="addmore">
		      <div class="input-group">
		      <span class="input-group-btn">
			      <button type='button' class="up btn btn-default btn-danger delete"><span class="glyphicon glyphicon-minus"></span></button>
			      </span>
			      <input class="images filestyle" data-icon="false" name="images[]" type="file" style="padding:10px;" id="1" />
			      <span class="input-group-btn">
			      <button type='button' class="up btn btn-default btn-info addmore"><span class="glyphicon glyphicon-plus"></span></button>
		      </span>
		      </div>
		   </div>
	      <span class="help-block" id="hint_rottime">
	       images
	      </span>
	     </div> --}}
	    
	     <div class="form-group">
	      <div>
	       <button  class="btn btn-primary pull-right" name="submit" type="submit" id="adsave">

	        Save And Continue
	       </button>
	       <p>&nbsp</p>
	      </div>
	     </div>
	     </fieldset>
	   
	   
		{{-- Ends --}}
		</div>
		
		{{-- <div class="col-xs-4"></div> --}}
		{{-- Code for checkout adcotron --}}
		<script type="text/javascript">
			$(document).ready(function(){
				url= "{{url('admin/general/set/ad')}}";
				$('#adsave').click(function(){
					$.ajax({
					url:url,
					type:'GET',
					data:{
						target:$('#target').val(),
						
						rottime:$('#rottime').val(),
						priority:$('#priority').val()
					},
					success:function(r){
						if (r.status=="success") {
							$('#adcontrol_id').val(r.adcontrol_id);
							$('#adsave').attr('disabled',true);
							toastr.info(r.long_message);
						}
					}
				});
				});
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				
				// ADD MINUS
				$('.minus').click(function(){
					var v=$(this).closest('.input-group').find('input[type=text]').val();
					
					v= parseInt(v);
					if (v>0) {
						$(this).closest('.input-group').find('input[type=text]').val(v-1);
					}
					
				});
				$('.add').click(function(){
					var v=$(this).closest('.input-group').find('input[type=text]').val();
					// alert(v);
					var v= parseInt(v)
					$(this).closest('.input-group').find('input[type=text]').val(v+1);
					
				});
				$('#target').change(function(){
					// ToDO
				});
				var max_fields=10;
				var x=1;
				$('body').on('click','.addmore',function(){
					if (x<max_fields) {
						var html='<div class="input-group"><span class="input-group-btn"><button type="button" class="up btn btn-default btn-danger delete"><span class="glyphicon glyphicon-minus"></span></button></span><input class="images filestyle" data-icon="false" name="images[]" type="file" style="padding:10px;" id="'+(x+1)+'"/><span class="input-group-btn"><button type="button" class="up btn btn-default btn-info addmore"><span class="glyphicon glyphicon-plus"></span></button></span></div>';
					$('#addmore').append(html);
					x++;
					console.log(x);
					}
				});
				// $('.addmore').click(function(){
					
				// });
				$('body').on('click','.delete',function(){
					if (x>1) {
						$(this).closest('.input-group').remove();
						x--;
					}
					
				});
		});
				
				
				
		</script>
		</div>
		{{--  --}}
		 <div id="actions" class="row">

        <div class="col-lg-7">
            <!-- The fileinput-button span is used to style the file input field as button -->
        <span class="btn btn-success fileinput-button">
            <i class="glyphicon glyphicon-plus"></i>
            <span>Add files...</span>
        </span>
            <button type="submit" class="btn btn-primary start">
                <i class="glyphicon glyphicon-upload"></i>
                <span>Start upload</span>
            </button>
            <button type="reset" class="btn btn-warning cancel">
                <i class="glyphicon glyphicon-ban-circle"></i>
                <span>Cancel upload</span>
            </button>
        </div>

        <div class="col-lg-5">
            <!-- The global file processing state -->
        <span class="fileupload-process">
          <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
              <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
          </div>
        </span>
        </div>

    </div>








    <div class="table table-striped files" id="previews">

        <div id="template" class="file-row">
            <!-- This is used as the file preview template -->
            <div>
                <span class="preview"><img data-dz-thumbnail /></span>
            </div>
            <div>
                <p class="name" data-dz-name></p>
                <strong class="error text-danger" data-dz-errormessage></strong>
            </div>
            <div>
                <p class="size" data-dz-size></p>
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                    <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                </div>
            </div>
            <div>

            	<select class="oshop">
            		<option>Select O-Shop</option>
            		<option value="1">1</option>
            		<option value="2">2</option>
            	</select>
                <button class="btn btn-primary start">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
                <button data-dz-remove class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
                <button data-dz-remove class="btn btn-danger delete">
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>

            </div>
        </div>

    </div>
   <script type="text/javascript">

   </script>
  <script>
                // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#template");
        previewNode.id = "";
        var previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);
        
        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
          url: "{{route('image.store')}}", // Set the url
          thumbnailWidth: 80,
          paramName:'image',
          thumbnailHeight: 80,
          parallelUploads: 20,
          maxFiles:20,
          previewTemplate: previewTemplate,
          autoQueue: false, // Make sure the files aren't queued until manually added
          previewsContainer: "#previews", // Define the container to display the previews
          clickable: ".fileinput-button", // Define the element that should be used as click trigger to select files.
          acceptedFiles:"image/*",
          addRemoveLinks: true,
          removedfile: function(file) {
		    var _ref;
		    $.ajax({
		        type: 'POST',
		        url: 'delete.php',
		        data: "id="+name,
		        
		        success:function(r){
		        	if (r.status=="success") {
		        		return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
		        	}
		        }
		    });
		    
		  }
        });
        function mockfiles(item,myDropzone) {
        	 
        }
     	$('#target').change(function(){
     		myDropzone.removeAllFiles();
     		$('#previews').empty();
   		var target= $(this);
   		if (target.val()!="") {
   			var adtarget_id= target.val();
   			url= JS_BASE_URL+"/admin/general/ad/exist/"+adtarget_id;
   			$.ajax({
   				url:url,
   				type:'GET',
   				success:function(r){
   					if (r.status=="success" && r.exists=="true") {
   						$.each(r.images, function(index, val) {
					    var mockFile = { name: val.path, size:00 };
					    myDropzone.options.addedfile.call(myDropzone, mockFile);
					    myDropzone.options.thumbnail.call(myDropzone, mockFile, JS_BASE_URL+"/images/adimage/"+val.id +"/"+ val.path);
					    myDropzone.emit("complete", mockFile);
					    myDropzone.emit("thumbnail",mockFile);
					    myDropzone.createThumbnailFromUrl(val.path,JS_BASE_URL+"/images/adimage/"+val.id +"/"+ val.path);
					    // Add Params
					    var adc= r.adcontrol;
					    var atg=r.adtarget;
					    $('#height').val(atg.height).attr('disabled',true);
					    $('#width').val(atg.width).attr('disabled',true);
					    $('#rottime').val(adc.rotation_time);
					    // Params ends
					  });

   					}
   				}
   			});
   		}
   	});
        // Add link to oshop
        var oshop= 
        myDropzone.on('sending', function(file, xhr, formData){
            
        });
     
        myDropzone.on("addedfile", function(file) {
          // Hookup the start button
          file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
        });
        
        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
          document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
        });
        
        myDropzone.on("sending", function(file,xhr,formData) {
          // Show the total progress bar when upload starts
          document.querySelector("#total-progress").style.opacity = "1";
          var oshop= file.previewElement.querySelector(".oshop").value;
          var adcontrol_id=$('#adcontrol_id').val();
          formData.append('oshop',oshop);
          formData.append('adcontrol_id',adcontrol_id);
          // And disable the start button
          file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
          file.previewElement.querySelector(".oshop").setAttribute("disabled","disabled");
        });
        
        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
          document.querySelector("#total-progress").style.opacity = "0";
        });
        
        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
          myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
        };
        document.querySelector("#actions .cancel").onclick = function() {
        $('#previews').empty();
          myDropzone.removeAllFiles(true);
        };
        
    </script>  <!-- js for the add files area /-->

     
</div> 
</div>
{{-- Container --}}
@stop
