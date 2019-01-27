@extends('common.default')
<style type="text/css">
	.col-centered{
    float: none;
    margin: 0 auto;
}
</style>
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-centered">
				@if($message_type=="error")
					<h1>Error</h1>
				<h2><span class="bg-danger">{{$message}}</span></h2>
				@elseif($message_type=="success")
					<h2>Success</h2>
				<h2><span class="bg-success">{{$message}}</span></h2>
				@elseif($message_type=="pwdreset")
					{!! Form::open(array('url'=>route('pwdreset'),'id'=>'pwdresetform')) !!}
					<div class="col-md-4"></div>
					<div class="col-md-4 col-centered">
					<br>
					<h2 style="margin-bottom:20px">Password Reset</h2>
					<input type="hidden" name="uid" value="{{$uid}}">
					<input type="hidden" name="key" value="{{$key}}">

					<label for="password">New Password</label>
					<input type="password" name="password" id="password"
						style="margin-bottom:10px;border-radius:5px"
						class="form-control validator" required>

					<label for="confirm_password">Confirm Password</label>
					<input type="password" name="password_confirmation"
						id="confirm_password"
						style="margin-bottom:20px;border-radius:5px"
						class="form-control validator"required>

					<button type="submit" value="Reset"
						class="btn pull-right"
						style="margin-bottom:20px;height: 70px;width:70px;
							background-color:red;border-color:red;color:white;
							border-radius:10px;"
						id="pswdreset">Reset</button>

					</div>
					<div class="col-md-4"></div>

					{!!Form::close()!!}
				<script type="text/javascript">
					$(document).ready(function () {
						$('#pwdresetform').bootstrapValidator({
							framework:'bootstrap',
							live:'enabled',
			                icon: {
                    			valid: 'glyphicon glyphicon-ok',
                    			invalid: 'glyphicon glyphicon-remove',
                    			validating: 'glyphicon glyphicon-refresh'
                			},
                			fields:{
				                    password: {
                        					validators: {
                            				notEmpty: {
                                				message: "Password cannot be left empty"
                            				},
			                            identical: {
		                    			field: 'password',
		                    			message: 'The password and its confirm are not the same'
		                			},
			                            stringLength: {
			                                min: 7,
			                                max: 20,
			                                message: "The Password must be more than 7 and less than 20 characters"
			                            }
                        			}
                    				}
                    ,
		                    password_confirmation: {
		                        validators: {
		                            notEmpty: {
		                                message: 'Confirm password cannot be left empty'
		                            },
		                            identical: {
		                    			field: 'password',
		                    			message: 'The password and its confirm are not the same'
		                			},
		                            stringLength: {
		                                min: 7,
		                                max: 20,
		                                message: "The password must be more than 7 and less than 20 characters"
		                            }
		                        }
		                    }
                			}
						});
					});
				</script>					
				@endif
			</div>
		</div>
		</div>
@stop
