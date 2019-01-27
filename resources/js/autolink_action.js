$(document).ready(function(){
	$('#link_delete').button().click(function(){
		var id= $('#autolink').attr('val');
		alert(id);
		var url=JS_BASE_URL+"/autolink/"+id+"/delete";
		$.ajax({
			url:url,
			success:function(data){
				if (data.code=="lds") {
					$('#link_delete').html("Deleted");
					// $('#autolink').html('Success');
				};
				if (data.code=="ldf") {
					$('#link_delete').replaceWith("Failed to delete");
				};
			}
		});
	});
	$('#req_delete').button().click();
	$('#accept').button().click();
	// $('#link_delete').button().click();
	// $('#link_delete').button().click();
});