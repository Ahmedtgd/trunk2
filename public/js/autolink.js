$(document).ready(function(){
	$('#autolink').button().click(function(){
		var id= $('#autolink').attr('data-button');

		var url=JS_BASE_URL+"/oshopreq/"+id+"/autolink";
		$.ajax({
			url:url,
			success:function(data){
				if (data.code=="sspr") {
					$('#autolink').prop('disabled', true);
					$('#autolink').html('Success');
				};
				if (data.code=="uara") {
					$('#autolink').prop('disabled', true);
					$('#autolink').html('Requested');
				};
				if (data.code=="unli") {
					/*alert('Please Login');
					$('#autolink').html('Login Needed');*/
				};
				
			}
		});
	});  //Button Action
});
/**/