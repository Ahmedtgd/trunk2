@extends("common.default")

@section("content")
    <section class="">
        <div class="container"><!--Begin main cotainer-->
            <div class="row" style="padding-top: 100px; padding-bottom: 10px;">
				<h2>Recover your password!</h2>
			</div>
			<input type="hidden" id="useraid" value="{{$id}}" />
			<div class="row">
				<div class="col-xs-5">					
					<p>Enter password:</p>
					<input type="password" class="form-control" id="user_pass" size="25" />
				</div>
			</div>			
			<div class="row" style="padding-bottom: 10px;">
				<div class="col-xs-5">							
					<p>Reconfirm new password:</p>
					<input type="password" class="form-control" id="user_passc" size="25" />		
				</div>
			</div>	
			<div class="row" style="padding-bottom: 10px;">
				<div class="col-xs-5">						
					<input type="button" id="change_password" class="btn btn-primary" value="Reset" style="margin-top: 10px;">
					<p style="color: red; display: none;" id="wrong_passold" style="margin-top: 10px;">Wrong password.</p>
					<p style="color: red; display: none;" id="wrong_pass" style="margin-top: 10px;">Passwords don't match.</p>
					<p style="color: green; display: none;" id="sucess_pass" style="margin-top: 10px;">Password successfully changed! Pease, log in!</p>
				</div>
			</div>			
		</div>
	</section>
	
    <script>     
		$(document).ready(function () {			
			 $(document).delegate( '#change_password', "click",function (event) {
				//console.log("passs");
				var userid = $("#useraid").val();
				var password = $("#user_pass").val();
				var cpassword = $("#user_passc").val();
				 if(password == cpassword){
						var formData = {
							userid: userid,
							password: password
						}
						$.ajax({
							type: "POST",
							url: JS_BASE_URL + "/changepassword",
							data: formData,
							dataType: 'json',
							success: function (data) {
								$("#sucess_pass").show();						
								setTimeout(function(){
									$("#user_pass").val("");
									$("#sucess_pass").hide();
									$('#myModal').modal('toggle');
								}, 3000);							
							},
							error: function (error) {
								console.log(error);
							}

						});
					} else {
						$("#wrong_pass").show();
						setTimeout(function(){
							$("#wrong_pass").hide();
						}, 4000);					
					}				
				});	
		});
	</script>				
@stop