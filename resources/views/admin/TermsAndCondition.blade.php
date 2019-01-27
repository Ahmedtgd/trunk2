@extends("common.default")

@section("content")
<div class="container" style="margin-top:30px;">
	@include('admin/panelHeading')
        <div class="equal_to_sidebar_mrgn">
        	<div id="alert-info"></div>
			<div class="row">	
				<div class="col-md-12">
					<h3>Terms And Condition Management</h3>		
		            <button  id="add_top_btn" class="btn btn-info" data-toggle="modal" data-target="#termsAndCondition-add-modal"><span class="glyphicon glyphicon-plus">Add</span></button>
					<div class="table-responsive">
						<div id = "dvData">
						<table class="table table-bordered table-hover table-striped" >
							<thead id="tblHeader">	
							<tr>		  	
								<th>Name</th>
								<th>Content</th>
								<th>Active</th>
								<th class="operation">Operations</th>
							</tr>
							</thead>
							<tbody id="tbody_terms_and_condition">
								
							</tbody>			  	
						</table>
						</div>
					</div>
				</div>

			</div>
        </div>
</div>
<div class="modal fade" id="termsAndCondition-add-modal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="termsAndConditionModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="termsAndConditionForm" action="#" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title termsAndCondition-title" id="termsAndConditionModalLabel">Add Terms And Condition</h4>
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
							    	<input type="file" name="termsAndConditionpic" id="gen2ImageInput">
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
                    <button type="button" class="btn btn-primary" id="add_terms_and_condition_btn">Add Terms And Condition</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditTermsAndCondition" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="aboutUsModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="termsAndConditionEditForm" action="#" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title " id="">Edit Terms And Condition</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" class="form-control" name="name" id="nameEdit" required>
                        <input type="hidden"  name="" id="editId">
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
						          	<input type="file" name="termsandconditionPic" >
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

<div class="modal fade" id="modalPreviewTermsAndCondition" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabelPreviewTermsAndCondition">Name</h4>
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
<div class="modal fade" id="modalDeleteTermsAndCondition" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabelDeleteTermsAndCondition">Are Your sure you want to delete Name</h4>
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
	function populateTermsAndCondition(){
		$('#alert-info').hide();
		$.get('../../termsandcondition', function() {
			$('#tbody_terms_and_condition').empty();
		}).done(function(data) {
			data = data.termsandcondition;
			$.each(data,function(key,value){
				// console.log(value.name);
				var buttondelete = "";
				if (value.active == 1) {
					value.active = "Active";
				} else {
					value.active = "In Active";
					buttondelete = '<button id = "btnShowDelete'+value.id+'" class="btn btn-danger"  data-toggle="modal" data-target="#modalDeleteTermsAndCondition"><span class="glyphicon glyphicon-trash">delete</span></button>';
				}
					var tr = '<tr><td id = "name'+value.id+'">'+value.name+'</td><td id = "content'+value.id+'">'+value.description+'</td><td id = "active'+value.id+'">'+value.active+'</td>'+
					  '<td>'+
							 '<button id = "btnShowPreview'+value.id+'" class="btn btn-info" data-toggle = "modal" data-target ="#modalPreviewTermsAndCondition"><span class="glyphicon glyphicon-eye">preview</span></button>'+
							 '<button id = "btnShowEdit'+value.id+'" class="btn btn-warning"  data-toggle="modal" data-target="#modalEditTermsAndCondition"><span class="glyphicon glyphicon-cog">edit</span></button>'+
							 buttondelete+
					  	    '<input id = "terms_and_condition_pic'+value.id+'" type = "hidden" value = "'+value.filename+'">'+
					  	    '</td>'+	
					'</tr>';	
				$('#tbody_terms_and_condition').append(tr);
			}); 
	    }).fail(function() {
		    // alert( "error" );
	    });		
	};
	$('#btnRequestDelete').click(function  () {
		var termsAndConditionId =  $('#deleteId').val();
		var formData = new FormData();    
		formData.append( '_method', 'DELETE');
		$.ajax({
			type 		: 'POST', 
			url 		: '../../termsandcondition/'+termsAndConditionId,
			data 		: formData, 
	        contentType	: false,
	        processData	: false,
		}).done(function(data) {
		 $('#modalDeleteTermsAndCondition').modal("hide");
		 	$('#alert-info').html(
						'<div class="alert alert-success">'+
                            'Terms And Condition deleted successfully.'+
                        '</div>');
		 	$('#alert-info').delay(1000).hide(1000);
			populateTermsAndCondition();
		}).fail(function(data){

		});
	});
	$('#add_terms_and_condition_btn').click(function  () {
		var formData =  new FormData($('form#termsAndConditionForm')[0]);
		if ($('form#termsAndConditionForm').parsley().validate()) {
			$.ajax({
					type 		: 'POST', 
					url 		: '../../termsandcondition',
					data 		: formData, 
					enctype		: 'multipart/form-data',
					contentType	: false,
					processData	: false
			}).done(function(data) {
				$('#alert-info').html(
					'<div class="alert alert-success">'+
	                    'Terms And Condition added successfully.'+
	                '</div>');
				$('#alert-info').delay(1000).hide(500);
				$('form#termsAndConditionForm')[0].reset();
				populateTermsAndCondition();
			   $('#termsAndCondition-add-modal').modal("hide");
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
		var termsAndConditionId = this.id.slice(14, this.id.length);
	    $('#myModalLabelPreviewTermsAndCondition').html('Terms And Conditions (' + $("#name"+termsAndConditionId).html() +')');
		$('#modalPreviewContent').html($('#content'+termsAndConditionId).html());
	   	$('#previewImage').prop('src','../../images/termsandcondition/' + $('#terms_and_condition_pic'+termsAndConditionId).val() ); 
		var img=$('#previewImage');
	    var src=img.attr('src');
	    var i=src.indexOf('?dummy=');
	    src=i!=-1?src.substring(0,i):src;
	    d = new Date();
	    img.attr('src', src+'?dummy='+d.getTime() );
	 });

	$('body').on('click', 'button[id^=\'btnShowDelete\']', function() {
		var termsAndConditionId = this.id.slice(13, this.id.length);
		$('#deleteId').val(termsAndConditionId);
	    $('#myModalLabelDeleteTermsAndCondition').html('Are you sure you want to delete Terms And Condition (' + $("#name"+termsAndConditionId).html() +') ?');
		$('#modalDeleteContent').html($('#content'+termsAndConditionId).html());
	   	$('#deleteImage').prop('src','../../images/termsandcondition/' + $('#terms_and_condition_pic'+termsAndConditionId).val() ); 
		var img=$('#deleteImage');
	    var src=img.attr('src');
	    var i=src.indexOf('?dummy=');
	    src=i!=-1?src.substring(0,i):src;
	    d = new Date();
	    img.attr('src', src+'?dummy='+d.getTime() );
	 });

	$('body').on('click', 'button[id^=\'btnShowEdit\']', function() {
		var termsAndConditionId = this.id.slice(11, this.id.length);
		$('#editId').val(termsAndConditionId);
	    $('#nameEdit').val( $("#name"+termsAndConditionId).html() );
		$('#textareaEdit').html($('#content'+termsAndConditionId).html());
	   	$('#editImage').prop('src','../../images/termsandcondition/' + $('#terms_and_condition_pic'+termsAndConditionId).val() ); 
		var img=$('#editImage');
	    var src=img.attr('src');
	    var i=src.indexOf('?dummy=');
	    src=i!=-1?src.substring(0,i):src;
	    d = new Date();
	    img.attr('src', src+'?dummy='+d.getTime() );
	    if ($("#active"+termsAndConditionId).html() == "Active") {
	    	$('#activeStatusEdit').prop('checked', true);
	    } else {
	    	$('#activeStatusEdit').prop('checked', false);
	    }
	 });

	 $('body').on('click', 'button[id^=\'btnRequestEdit\']', function() {
	 	var termsAndConditionId =  $('#editId').val();
		var formData =  new FormData($('form#termsAndConditionEditForm')[0]);
		formData.append( '_method', 'PUT');
		$('.form-group').removeClass('has-error'); 
		$.ajax({
				type 		: 'POST', 
				url 		: '../../termsandcondition/'+termsAndConditionId,
				data 		: formData, 
				enctype		: 'multipart/form-data',
				contentType	: false,
				processData	: false
		}).done(function(data) {
			populateTermsAndCondition();
		 	$('#alert-info').html(
						'<div class="alert alert-success">'+
	                        'Terms And Condition edited successfully.'+
	                    '</div>');
		 	$('#modalEditTermsAndCondition').modal("hide");
		 	$('form#termsAndConditionEditForm')[0].reset();
		 	$('#alert-info').delay(500).hide(1000);
		}).fail(function (argument) {
		 	$('#alert-info').html(
						'<div class="alert alert-danger">'+
	                        'Terms And Condition not edited successfully.'+
	                    '</div>');
		 	$('#modalEditTermsAndCondition').modal("hide");
		 	$('form#termsAndConditionEditForm')[0].reset();
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
	populateTermsAndCondition();
</script>
@stop
