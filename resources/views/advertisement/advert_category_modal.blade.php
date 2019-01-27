<form action="{{url('/admin/general/category_image')}}" method="post" id="slider_image_form" enctype="multipart/form-data">
{!! csrf_field() !!}
<div id="categoryModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Category Images</h4>
      </div>
<div class="modal-body">
		{{-- <div class="row">
			<div class="col-sm-5">
				<div class="form-group h2">
					<b>Images</b>
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
		</div> --}}

	 <div class="category_container">
		<div class="category_div row">
		<label class="control-label form-group" for="target" style="margin-top:20px;">Target </label>
	     	<input type="text" name="target" class="form-control"><br>
	     	<div class="category_image_div" style="border-style: solid;border-width: 1px; height: 200px;border-color:#c0c0c0">
	     		<input type="file" style="display: none;" name="category_image" data-preview-file-type="text" multiple/>
	     		<img src="" class="category_image">
	     		<button type="button" style="background:#000000; color:#ffffff;" class="btn btn-upload pull-right"><i class="fa fa-upload"></i></button>
	     	</div>
	     </div>
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
<input type="hidden" name="category_id" value="{{$categoryImages->id}}" />
<input type="hidden" name="delete_cat_image" id="delete_cat_image"/>
<input type="hidden" name="adv_target" id="adv_target" value="" />
</form>