@extends("common.default")

@section("content")
<div class="container" style="margin-top:30px;">
	@include('admin/panelHeading')
        <div class="equal_to_sidebar_mrgn">
        	<div id="alert-info"></div>
			<div class="row">	
				<div class="col-md-12">
					<h3>Download Apps Management</h3>		
		            <button  id="add_top_btn" class="btn btn-info" data-toggle="modal" data-target="#downloadApps-add-modal"><span class="glyphicon glyphicon-plus">Add</span></button>
					<div class="table-responsive">
						<div id = "dvData">
						<table class="table table-bordered table-hover table-striped" >
							<thead id="tblHeader">	
							<tr>		  	
								<th>Name</th>
								<th>Link</th>
								<th>OS</th>
								<th>Version</th>
								<th>Active</th>
								<th class="operation">Operations</th>
							</tr>
							</thead>
							<tbody id="tbody_download_apps">
								
							</tbody>			  	
						</table>
						</div>
					</div>
				</div>

			</div>
        </div>
</div>
<div class="modal fade" id="downloadApps-add-modal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="downloadAppsModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="downloadAppsForm" action="#" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title downloadApps-title" id="downloadAppsModalLabel">Add Download Apps</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Link</label>
                        <input type="text" class="form-control" name="link" id="link" required data-parsley-type="url">
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">OS</label>
                        <select id="os" name="os" class="form-control">
					      <option value="android">Android</option>
					      <option value="apple">Apple</option>
					      <option value="windows">Windows</option>
					    </select>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Version</label>
                        <input type="text" class="form-control" name="version" id="version" placeholder="0.0.0" required>
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
							    	<input type="file" name="downloadAppspic" id="gen2ImageInput">
							    </span>
							    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
							  </div>
							</div>
						</div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">Description</label>
                        <textarea class="form-control" id="textarea" name="content" placeholder="default text" data-parsley-minlength="200" ></textarea>
                    </div>
                    <div class="form-group">
				      <span class="input-group-addon">     
				          <input type="checkbox" checked="checked" name="activeStatus" >     
				      </span>
				      <span class="input-group-addon">Active</span>
				    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="add_download_apps_btn">Add Download Apps</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditDownloadApps" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="aboutUsModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="downloadAppsEditForm" action="#" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title " id="">Edit Download Apps</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" class="form-control" name="name" id="nameEdit" required>
                        <input type="hidden"  name="" id="editId">
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Link</label>
                        <input type="text" class="form-control" name="link" id="linkEdit" required data-parsley-type="url">
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">OS</label>
                        <select id="osEdit" name="os" class="form-control">
					      <option value="android">Android</option>
					      <option value="apple">Apple</option>
					      <option value="windows">Windows</option>
					    </select>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Version</label>
                        <input type="text" class="form-control" name="version" id="versionEdit" placeholder="0.0.0" required>
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
						          	<input type="file" name="downloadappsPic" >
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

<div class="modal fade" id="modalPreviewDownloadApps" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabelPreviewDownloadApps">Name</h4>
			</div>
			<div class="modal-body">
				<div class="well">
					<div class="row">
						<div class="col-md-12">
							<div>
							<div class="fileinput-new thumbnail" style="float:left;width:200px;height:200px; margin-right:10px;display: block;">
						          <img data-src="" alt="noprofilepic.png" id="previewImage" style="height: 100%; width: 100%; display: block;">
						        </div>
								<div  class="table-responsive">
									<table class="table table-bordered table-hover table-striped " >
										<tr>
											<th>Name:</th>
											<td id="namePreview"></td>
										</tr>
										<tr>
											<th>OS:</th>
											<td id="osPreview"></td>
										</tr>
										<tr>
											<th>Version:</th>
											<td id="versionPreview"></td>
										</tr>
										<tr>
											<th>Link:</th>
											<td ><p><a href="" id="linkPreview"></a></p></td>
										</tr>
									</table>
								</div>
								
								
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
<div class="modal fade" id="modalDeleteDownloadApps" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabelDeleteDownloadApps">Are Your sure you want to delete Name</h4>
			</div>
			<div class="modal-body">
				<div class="well">
					<div class="row">
						<div class="col-md-12">
							<input type="hidden" id="deleteId">
							<div>
							<div class="fileinput-new thumbnail" style="float:left;width:200px;height:200px; margin-right:10px;display: block;">
						          <img data-src="" alt="noprofilepic.png" id="deleteImage" style="height: 100%; width: 100%; display: block;">
						        </div>
								<div  class="table-responsive">
									<table class="table table-bordered table-hover table-striped " >
										<tr>
											<th>Name:</th>
											<td id="nameDelete"></td>
										</tr>
										<tr>
											<th>OS:</th>
											<td id="osDelete"></td>
										</tr>
										<tr>
											<th>Version:</th>
											<td id="versionDelete"></td>
										</tr>
										<tr>
											<th>Link:</th>
											<td ><p><a href="" id="linkDelete"></a></p></td>
										</tr>
									</table>
								</div>
								
								
							</div>
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
	function populateDownloadApps(){
		$('#alert-info').hide();
		$.get('../../downloadapps', function() {
			$('#tbody_download_apps').empty();
		}).done(function(data) {
			data = data.downloadapps;
			$.each(data,function(key,value){
				// console.log(value.name);
				var buttondelete = "";
				if (value.active == 1) {
					value.active = "Active";
				} else {
					value.active = "In Active";
				}
				buttondelete = '<button id = "btnShowDelete'+value.id+'" class="btn btn-danger"  data-toggle="modal" data-target="#modalDeleteDownloadApps"><span class="glyphicon glyphicon-trash">delete</span></button>';
				var tr = 
					'<tr>'+
						'<td id = "name'+value.id+'">'+value.name+'</td>'+
						'<td id = "link'+value.id+'">'+value.link+'</td>'+
						'<td id = "os'+value.id+'">'+value.os+'</td>'+
						'<td id = "version'+value.id+'">'+value.version+'</td>'+
						'<td id = "active'+value.id+'">'+value.active+'</td>'+
					  	'<td>'+
							'<button id = "btnShowPreview'+value.id+'" class="btn btn-info" data-toggle = "modal" data-target ="#modalPreviewDownloadApps"><span class="glyphicon glyphicon-eye">preview</span></button>'+
							'<button id = "btnShowEdit'+value.id+'" class="btn btn-warning"  data-toggle="modal" data-target="#modalEditDownloadApps"><span class="glyphicon glyphicon-cog">edit</span></button>'+
							buttondelete+
					  	    '<input id = "download_apps_pic'+value.id+'" type = "hidden" value = "'+value.picture+'">'+
					  	    '<input id = "content'+value.id+'" type = "hidden" value = "'+value.description+'">'+
				  	    '</td>'+	
					'</tr>';	
				$('#tbody_download_apps').append(tr);
			}); 
	    }).fail(function() {
		    // alert( "error" );
	    });		
	};
	$('#btnRequestDelete').click(function  () {
		var downloadAppsId =  $('#deleteId').val();
		var formData = new FormData();    
		formData.append( '_method', 'DELETE');
		$.ajax({
			type 		: 'POST', 
			url 		: '../../downloadapps/'+downloadAppsId,
			data 		: formData, 
	        contentType	: false,
	        processData	: false,
		}).done(function(data) {
		 $('#modalDeleteDownloadApps').modal("hide");
		 	$('#alert-info').html(
						'<div class="alert alert-success">'+
                            'Download Apps deleted successfully.'+
                        '</div>');
		 	$('#alert-info').delay(1000).hide(1000);
			populateDownloadApps();
		}).fail(function(data){

		});
	});
	$('#add_download_apps_btn').click(function  () {
		var formData =  new FormData($('form#downloadAppsForm')[0]);
		if ($('form#downloadAppsForm').parsley().validate()) {
			$.ajax({
					type 		: 'POST', 
					url 		: '../../downloadapps',
					data 		: formData, 
					enctype		: 'multipart/form-data',
					contentType	: false,
					processData	: false
			}).done(function(data) {
				$('#alert-info').html(
					'<div class="alert alert-success">'+
	                    'Download Apps added successfully.'+
	                '</div>');
				$('#alert-info').delay(1000).hide(500);
				$('form#downloadAppsForm')[0].reset();
				populateDownloadApps();
			   $('#downloadApps-add-modal').modal("hide");
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
		var downloadAppsId = this.id.slice(14, this.id.length);
	    $('#myModalLabelPreviewDownloadApps').html('App (' + $("#name"+downloadAppsId).html() +')');
		$('#modalPreviewContent').html($('#content'+downloadAppsId).val());
		$('#namePreview').html( $("#name"+downloadAppsId).html() );
	    $('#linkPreview').attr('href', $("#link"+downloadAppsId).html() ).html($("#link"+downloadAppsId).html());
	    $('#versionPreview').html( $("#version"+downloadAppsId).html() );
	    $('#osPreview').html( $("#os"+downloadAppsId).html() ).change();
	   	$('#previewImage').prop('src','../../images/downloadapps/' + $('#download_apps_pic'+downloadAppsId).val() ); 
		var img=$('#previewImage');
	    var src=img.attr('src');
	    var i=src.indexOf('?dummy=');
	    src=i!=-1?src.substring(0,i):src;
	    d = new Date();
	    img.attr('src', src+'?dummy='+d.getTime() );
	 });

	$('body').on('click', 'button[id^=\'btnShowDelete\']', function() {
		var downloadAppsId = this.id.slice(13, this.id.length);
		$('#deleteId').val(downloadAppsId);
	    $('#myModalLabelDeleteDownloadApps').html('Are you sure you want to delete Download Apps (' + $("#name"+downloadAppsId).html() +') ?');
		$('#modalDeleteContent').html($('#content'+downloadAppsId).val());
		$('#nameDelete').html( $("#name"+downloadAppsId).html() );
	    $('#linkDelete').attr('href', $("#link"+downloadAppsId).html() ).html($("#link"+downloadAppsId).html());
	    $('#versionDelete').html( $("#version"+downloadAppsId).html() );
	    $('#osDelete').html( $("#os"+downloadAppsId).html() ).change();
	   	$('#deleteImage').prop('src','../../images/downloadapps/' + $('#download_apps_pic'+downloadAppsId).val() ); 
		var img=$('#deleteImage');
	    var src=img.attr('src');
	    var i=src.indexOf('?dummy=');
	    src=i!=-1?src.substring(0,i):src;
	    d = new Date();
	    img.attr('src', src+'?dummy='+d.getTime() );
	 });

	$('body').on('click', 'button[id^=\'btnShowEdit\']', function() {
		var downloadAppsId = this.id.slice(11, this.id.length);
		$('#editId').val(downloadAppsId);
	    $('#nameEdit').val( $("#name"+downloadAppsId).html() );
	    $('#linkEdit').val( $("#link"+downloadAppsId).html() );
	    $('#versionEdit').val( $("#version"+downloadAppsId).html() );
	    $('#osEdit').val( $("#os"+downloadAppsId).html() ).change();
		$('#textareaEdit').html($('#content'+downloadAppsId).val());
	   	$('#editImage').prop('src','../../images/downloadapps/' + $('#download_apps_pic'+downloadAppsId).val() ); 
		var img=$('#editImage');
	    var src=img.attr('src');
	    var i=src.indexOf('?dummy=');
	    src=i!=-1?src.substring(0,i):src;
	    d = new Date();
	    img.attr('src', src+'?dummy='+d.getTime() );
	    if ($("#active"+downloadAppsId).html() == "Active") {
	    	$('#activeStatusEdit').prop('checked', true);
	    } else {
	    	$('#activeStatusEdit').prop('checked', false);
	    }
	 });

	 $('body').on('click', 'button[id^=\'btnRequestEdit\']', function() {
	 	var downloadAppsId =  $('#editId').val();
		var formData =  new FormData($('form#downloadAppsEditForm')[0]);
		formData.append( '_method', 'PUT');
		$('.form-group').removeClass('has-error'); 
		$.ajax({
				type 		: 'POST', 
				url 		: '../../downloadapps/'+downloadAppsId,
				data 		: formData, 
				enctype		: 'multipart/form-data',
				contentType	: false,
				processData	: false
		}).done(function(data) {
			populateDownloadApps();
		 	$('#alert-info').html(
						'<div class="alert alert-success">'+
	                        'Download Apps edited successfully.'+
	                    '</div>');
		 	$('#modalEditDownloadApps').modal("hide");
		 	$('form#downloadAppsEditForm')[0].reset();
		 	$('#alert-info').delay(500).hide(1000);
		}).fail(function (argument) {
		 	$('#alert-info').html(
						'<div class="alert alert-danger">'+
	                        'Download Apps not edited successfully.'+
	                    '</div>');
		 	$('#modalEditDownloadApps').modal("hide");
		 	$('form#downloadAppsEditForm')[0].reset();
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
	populateDownloadApps();
</script>
@stop