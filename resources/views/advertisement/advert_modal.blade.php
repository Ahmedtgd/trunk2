<form action="{{url('/admin/general/slider_image')}}" method="post" id="slider_image_form" enctype="multipart/form-data">
{!! csrf_field() !!}
<div id="landingModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">>
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Landing Page Slider</h4>
      </div>
      <div class="modal-body">
      	<div class="form-group ">
	      <label class="control-label " for="rottime">
	       Rotation Time
	       </label>
	      <div class="input-group">
 		      <span class="input-group-btn">
				<button type='button'
					class="up btn btn-default btn-info add">
					<span class="glyphicon glyphicon-plus"></span>
				</button>
			  </span> 
		      <input class="form-control" id="rottime" name="rottime" value="0"
			  	placeholder="numbers only" type="text"/>
 			  <span class="input-group-btn">
				  <button type='button'
					class="up btn btn-default btn-danger minus">
					<span class="glyphicon glyphicon-minus"></span>
				  </button>
		      </span> 
	      </div>
	      <span class="help-block" id="hint_rottime">
	       in milliseconds
	      </span>
	     </div>
      	
	<!--
    <div class="row">
      	<div class="col-sm-6">
      	<div class="form-group ">
	      <label class="control-label " for="height">
	       Height
	      </label>
	      <div class="input-group">
	      <span class="input-group-btn">
		      <button type='button' class="up btn btn-default btn-danger minus"><span class="glyphicon glyphicon-minus"></span></button>
		      </span>
		      <input class="form-control" id="height" name="height" value="0" placeholder="numbers" type="text"/>
		      <span class="input-group-btn">
		      <button type='button' class="up btn btn-default btn-info add"><span class="glyphicon glyphicon-plus"></span></button>
	      </span>
	      </div>
	      
	      <span class="help-block" id="hint_height">
	       in pixels
	      </span>
	     </div>
	    </div>

	    <div class="col-sm-6">
        <div class="form-group ">
	      <label class="control-label " for="width">
	       Width
	      </label>
	      <div class="input-group">
	      <span class="input-group-btn">
		      <button type='button' class="up btn btn-default btn-danger minus"><span class="glyphicon glyphicon-minus"></span></button>
		      </span>
		      <input class="form-control" id="width" name="width" value="0" placeholder="numbers" type="text"/>
		      <span class="input-group-btn">
		      <button type='button' class="up btn btn-default btn-info add"><span class="glyphicon glyphicon-plus"></span></button>
	      </span>
	      </div>
	      
	      <span class="help-block" id="hint_width">
	       in pixels, default to 0
	      </span>
	     </div>
	    </div>
	</div>
	-->

	<div class="row">
		<div class="col-sm-5">
			<div class="form-group h2">
				<b>Slider Images</b>
			</div>
		</div>
		<div class="col-sm-7">
			<div class="form-group">
				<button style="background:#27A98A;"
					class="btn btn-success btn-add-div"
					type="button">
					<i class="fa fa-plus" aria-hidden="true"></i>
				</button>		
			</div>
		</div>
	</div>

	 <div class="new-add-targetdiv">
		<label class="control-label form-group" for="target" style="margin-top:20px;">Target </label>
	     	<input type="text" name="target[]" class="form-control"><br>
	     	<div class="slider_image_div" style="border-style: solid;border-width: 3px; height: 200px;">
	     		<input type="file" style="display: none;" name="slider_image[]" data-preview-file-type="text" data-count="0" multiple/>
	     		<img src="" height="150px" class="slider_0">
	     		<button type="button" style="background:#000000; color:#ffffff;" class="btn btn-upload pull-right"><i class="fa fa-upload"></i></button>
	     	</div><br>
	     </div>
      </div>
      <div class="modal-footer">
      	<div class="col-sm-10 col-sm-offset-2 save-btn-leftdiv">
	      	<button type="submit" style="background:#27A98A;" class="btn btn-success" name="submit">Save</button>
	      </div>
      </div>
    </div>

  </div>
</div>
<input type="hidden" name="delete_image" id="delete_image"/>
</form>
