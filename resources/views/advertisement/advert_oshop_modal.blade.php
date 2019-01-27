<form action="{{url('/admin/general/oshop_image')}}" method="post"
	id="oshop_image_form" enctype="multipart/form-data">
{!! csrf_field() !!}
<div id="oshopModal" class="modal fade" role="dialog"
	data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"
			data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Landing Page O-Shop Advert Manager</h4>
      </div>
      <div class="modal-body">

      	<div class="oshop-container">
		</div>

      </div>

      <div class="modal-footer" style="border-top: none;">
      	<div class="col-sm-10 col-sm-offset-2 save-btn-leftdiv">
	      	<button type="submit" style="background:#27A98A;"
				class="btn btn-success" name="submit">Save</button>
	      </div>
      </div>
    </div>

  </div>
</div>
<input type="hidden" name="delete_oshop_image" id="delete_oshop_image"/>
</form>
