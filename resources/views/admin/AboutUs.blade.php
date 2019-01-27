@extends("common.default")

@section("content")
<div class="container" style="margin-top:30px;">
	@include('admin/panelHeading')
        <div class="equal_to_sidebar_mrgn">
			<div id="alert-info"></div>
			<div class="row">	
				<div class="col-md-12">
						<h3>About Us</h3>		
			            <button  id="add_top_btn" class="btn btn-info" data-toggle="modal" data-target="#aboutUs-add-modal"><span class="glyphicon glyphicon-plus">Add</span></button>
						<div class="table-responsive">
							<div id = "dvData">
							<table class="table table-bordered table-hover table-striped" id="personTable">
								<thead id="tblHeader">	
								<tr>		  	
									<th>Name</th>
									<th>Content</th>
									<th>Active</th>
									<th class="operation">Operations</th>
								</tr>
								</thead>
								<tbody id="tbody_about_us">
									 

								</tbody>			  	


							</table>
							</div>
						</div>
				</div>

			</div>
        </div>
</div>
<div class="modal fade" id="aboutUs-add-modal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="aboutUsModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="aboutUsForm" action="#" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title aboutUs-title" id="aboutUsModalLabel">Add About Us</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="control-label">Picture</label>
                        <div class="row">	
							<div class="fileinput fileinput-new" data-provides="fileinput">
							  <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
							  <div>
							    <span class="btn btn-default btn-file">
							    	<span class="fileinput-new">Select image</span>
							    	<span class="fileinput-exists">Change</span>
							    	<input type="file" name="aboutuspic" id="gen2ImageInput">
							    </span>
							    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
							  </div>
							</div>
						</div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">Content</label>
                        <textarea class="form-control" id="textarea" name="content" placeholder="default text" data-parsley-minlength="200" ></textarea>
                    </div>
                    <div class="form-group">
				      <span class="input-group-addon">     
				          <input type="checkbox" checked="checked" name="activeStatus" >     
				      </span>
				      <span class="input-group-addon">Current Active</span>
				    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="add_about_us_btn">Add About Us</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditAboutUs" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="aboutUsModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="aboutUsEditForm" action="#" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title aboutUs-title" id="aboutUsModalLabel">Edit About Us</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" class="form-control" name="name" id="nameEdit" required>
                        <input type="hidden"  name="aboutUsID" id="editId">
                    </div>
                    <div class="form-group">
                        <label for="phone" class="control-label">Picture</label>
							<div class="fileinput fileinput-new" data-provides="fileinput">
						        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
						          <img  data-src="holder.js/100%x100%" alt="noprofilepic.png" id="editImage" style="height: 100%; width: 100%; display: block;">
						        </div>
						        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;"></div>
						        <div>
						          <span class="btn btn-default btn-file">
						          	<span class="fileinput-new">Select image</span>
						          	<span class="fileinput-exists">Change</span>
						          	<input type="hidden" value="" name="">
						          	<input type="file" name="aboutUsPic" >
						          </span>
						          <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
						        </div>
						     </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">Content</label>
                        <textarea class="form-control" id="textareaEdit" name="content" placeholder="default text" data-parsley-minlength="200" ></textarea>
                    </div>
                    <div class="form-group">
				      <span class="input-group-addon">     
				          <input type="checkbox" checked="checked" name="activeStatus" id="activeStatusEdit">     
				      </span>
				      <span class="input-group-addon">Current Active</span>
				    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnRequestEdit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPreviewAboutUs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabelPreviewAboutUs">Name</h4>
			</div>
			<div class="modal-body">
				<div class="well">
					<div class="row">
						<div class="col-md-12">
							<div class="fileinput-new thumbnail" style="float:left;width:200px;height:200px; margin-right:10px;">
					          <img data-src="" alt="noprofilepic.png" id="previewImage" style="height: 100%; width: 100%; display: block;">
					        </div>
					        <p id="modalPreviewContent"></p>
				        </div>
					</div>					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modalDeleteAboutUs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabelDeleteAboutUs">Are Your sure you want to delete Name</h4>
			</div>
			<div class="modal-body">
				<div class="well">
					<div class="row">
						<div class="col-md-12">
							<div class="fileinput-new thumbnail" style="float:left;width:200px;height:200px; margin-right:10px;">
					          <img data-src="" alt="noprofilepic.png" id="deleteImage" style="height: 100%; width: 100%; display: block;">
					        </div>
							<input type="hidden" id="deleteId">
					        <p id="modalDeleteContent"></p>
				        </div>
					</div>					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" id="btnRequestDelete" >Delete</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<script type="text/javascript">
	function populateAboutUs(){
		$('#alert-info').hide();
		$.get('../../aboutus', function() {
			$('#tbody_about_us').empty();
		}).done(function(data) {
			data = data.aboutus;
			$.each(data,function(key,value){
				// console.log(value.name);
				var buttondelete = "";
				if (value.active == 1) {
					value.active = "Active";
				} else {
					value.active = "In Active";
					buttondelete = '<button id = "btnShowDelete'+value.id+'" class="btn btn-danger"  data-toggle="modal" data-target="#modalDeleteAboutUs"><span class="glyphicon glyphicon-trash">delete</span></button>';
				}
					var tr = '<tr><td id = "name'+value.id+'">'+value.name+'</td><td id = "content'+value.id+'">'+value.description+'</td><td id = "active'+value.id+'">'+value.active+'</td>'+
					  '<td>'+
							 '<button id = "btnShowPreview'+value.id+'" class="btn btn-info" data-toggle = "modal" data-target ="#modalPreviewAboutUs"><span class="glyphicon glyphicon-eye">preview</span></button>'+
							 '<button id = "btnShowEdit'+value.id+'" class="btn btn-warning"  data-toggle="modal" data-target="#modalEditAboutUs"><span class="glyphicon glyphicon-cog">edit</span></button>'+
							 buttondelete+
					  	    '<input id = "about_us_pic'+value.id+'" type = "hidden" value = "'+value.filename+'">'+
					  	    '</td>'+	
					'</tr>';	
				$('#tbody_about_us').append(tr);
			}); 
	    }).fail(function() {
		    // alert( "error" );
	    });		
	};
	$('#btnRequestDelete').click(function  () {
		var personId =  $('#deleteId').val();
		var formData = new FormData();    
		formData.append( '_method', 'DELETE');
		$.ajax({
			type 		: 'POST', 
			url 		: '../../aboutus/'+personId,
			data 		: formData, 
	        contentType	: false,
	        processData	: false,
		}).done(function(data) {
		 $('#modalDeleteAboutUs').modal("hide");
		 	$('#alert-info').html(
						'<div class="alert alert-success">'+
                            'About Us deleted successfully.'+
                        '</div>');
		 	$('#alert-info').delay(500).hide(1000);
			populateAboutUs();
		}).fail(function(data){

		});
	});
	$('#add_about_us_btn').click(function  () {
		var formData =  new FormData($('form#aboutUsForm')[0]);
		if ($('form#aboutUsForm').parsley().validate()) {
			$.ajax({
					type 		: 'POST', 
					url 		: '../../aboutus',
					data 		: formData, 
					enctype		: 'multipart/form-data',
					contentType	: false,
					processData	: false
			}).done(function(data) {
				$('#alert-info').html(
					'<div class="alert alert-success">'+
	                    'About us added successfully.'+
	                '</div>');
				$('#alert-info').delay(1000).hide(500);
				$('form#aboutUsForm')[0].reset();
				populateAboutUs();
			   $('#aboutUs-add-modal').modal("hide");
			}).fail(function (data) {
					console.log(data);
					var errormsg = '<ul>';
					data = JSON.parse(data.responseText);
					for(var key in data){
						for (var j = data[key].length - 1; j >= 0; j--) {
							errormsg = errormsg + '<li>' + data[key][j] + '</li>';
						};
					}
					errormsg = errormsg + '</ul>';
					$('#alert-info-add').html('<div class="alert alert-danger" role="alert"> <strong>Sorry!</strong></br>'+errormsg+' </div>');
			});
		} else{
		};
		event.preventDefault();
	});
	$('body').on('click', 'button[id^=\'btnShowPreview\']', function() {
		var aboutUsId = this.id.slice(14, this.id.length);
	    $('#myModalLabelPreviewAboutUs').html('About Us (' + $("#name"+aboutUsId).html() +')');
		$('#modalPreviewContent').html($('#content'+aboutUsId).html());
	   	$('#previewImage').prop('src','../../images/aboutus/' + $('#about_us_pic'+aboutUsId).val() ); 
		var img=$('#previewImage');
	    var src=img.attr('src');
	    var i=src.indexOf('?dummy=');
	    src=i!=-1?src.substring(0,i):src;
	    d = new Date();
	    img.attr('src', src+'?dummy='+d.getTime() );
	 });

	$('body').on('click', 'button[id^=\'btnShowDelete\']', function() {
		var aboutUsId = this.id.slice(13, this.id.length);
		$('#deleteId').val(aboutUsId);
	    $('#myModalLabelDeleteAboutUs').html('Are you sure you want to delete About us (' + $("#name"+aboutUsId).html() +') ?');
		$('#modalDeleteContent').html($('#content'+aboutUsId).html());
	   	$('#deleteImage').prop('src','../../images/aboutus/' + $('#about_us_pic'+aboutUsId).val() ); 
		var img=$('#deleteImage');
	    var src=img.attr('src');
	    var i=src.indexOf('?dummy=');
	    src=i!=-1?src.substring(0,i):src;
	    d = new Date();
	    img.attr('src', src+'?dummy='+d.getTime() );
	 });

	$('body').on('click', 'button[id^=\'btnShowEdit\']', function() {
		var aboutUsId = this.id.slice(11, this.id.length);
		$('#editId').val(aboutUsId);
	    $('#nameEdit').val( $("#name"+aboutUsId).html() );
		$('#textareaEdit').html($('#content'+aboutUsId).html());
	   	$('#editImage').prop('src','../../images/aboutus/' + $('#about_us_pic'+aboutUsId).val() ); 
		var img=$('#editImage');
	    var src=img.attr('src');
	    var i=src.indexOf('?dummy=');
	    src=i!=-1?src.substring(0,i):src;
	    d = new Date();
	    img.attr('src', src+'?dummy='+d.getTime() );
	    if ($("#active"+aboutUsId).html() == "Active") {
	    	$('#activeStatusEdit').prop('checked', true);
	    } else {
	    	$('#activeStatusEdit').prop('checked', false);
	    }
	 });

	 $('body').on('click', 'button[id^=\'btnRequestEdit\']', function() {
	 	var personId =  $('#editId').val();
		var formData =  new FormData($('form#aboutUsEditForm')[0]);
		formData.append( '_method', 'PUT');
		$('.form-group').removeClass('has-error'); 
		$.ajax({
				type 		: 'POST', 
				url 		: '../../aboutus/'+personId,
				data 		: formData, 
				enctype		: 'multipart/form-data',
				contentType	: false,
				processData	: false
		}).done(function(data) {
			populateAboutUs();
		 	$('#alert-info').html(
						'<div class="alert alert-success">'+
	                        'About Us  edited successfully.'+
	                    '</div>');
		 	$('#modalEditAboutUs').modal("hide");
		 	$('form#aboutUsEditForm')[0].reset();
		 	$('#alert-info').delay(500).hide(1000);
		}).fail(function (argument) {
		 	$('#alert-info').html(
						'<div class="alert alert-danger">'+
	                        'About Us not edited successfully.'+
	                    '</div>');
		 	$('#modalEditAboutUs').modal("hide");
		 	$('form#aboutUsEditForm')[0].reset();
		})
		
		event.preventDefault();
	  });
</script>
@stop

@section("extra-links")
    <link rel="stylesheet" href="{{asset('/css/jasny-bootstrap.css')}}"/>
@stop
@section("scripts")
<script src="{{asset('/vendor/jasny-bootstrap.min.js')}}"></script>
<script src="{{asset('/vendor/parsley.min.js')}}"></script>
<script type="text/javascript">
	populateAboutUs();
</script>
@stop