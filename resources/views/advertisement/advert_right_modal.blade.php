<form action="{{url('/admin/general/advertsmall_image')}}" method="post" id="advertsmall_timage_form" enctype="multipart/form-data">
{!! csrf_field() !!}
<div id="landingTopRightModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Landing Page Internal Display</h4>
      </div>
      <div class="modal-body">
      	<div class="col-sm-12 internal-right-bottom">
	      <div class="top-container">
	      
	      </div>
	    </div>
      </div>
      <div class="modal-footer" style="border-top: none;">
	      <div class="col-sm-10 col-sm-offset-2 save-btn-div">
	      	<button type="submit" class="btn btn-danger" name="submit">Save</button>
	      </div>
      </div>
    </div>
  </div>
</div>
</form>



<form action="{{url('/admin/general/advertsmall_bimage')}}" method="post" id="advertsmall_bimage_form" enctype="multipart/form-data">
{!! csrf_field() !!}
<div id="landingBottomRightModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Landing Page Internal Display</h4>
      </div>
      <div class="modal-body">
	    <div class="col-sm-12 internal-right-bottom">
	      	<div class="bottom-container">
		      	
		    </div>
	    </div>
      </div>
      <div class="modal-footer" style="border-top: none;">
	      <div class="col-sm-10 col-sm-offset-2 save-btn-div">
	      	<button type="submit" class="btn btn-danger" name="submit">Save</button>
	      </div>
      </div>
    </div>
  </div>
</div>
</form>