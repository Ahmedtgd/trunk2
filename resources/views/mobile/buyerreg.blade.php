<?php $cf = new \App\lib\CommonFunction(); 
use App\Http\Controllers\UtilityController;
?>

@extends('common.default')
@section('extra-links')
<style type="text/css">
	.container{
		font-size:15px;
	}
	.input-group{
		font-size:1.2em !important;
	}
	.table_input{
	
		line-height: 1.3em;
		height:2em !important;
		font-size:1.1em;
		/*padding: 2px;*/
		/*float: right;*/
		/*display: block !important;*/
		margin: 0 !important;
		/*width: 100% !important;*/

		font-family: sans-serif !important;
		appearance: none !important;
		box-shadow: none !important;
		border-radius: none !important;
		/*border: 1px solid black;*/
	}
	select>option{
		/*font-size: 0.5em !important;*/
	}
	.table_button{
		
	    border: none;
	    color: white;
	  	/*padding: 1px !important;*/
	    line-height:2em;
	    text-align: center;
	    font-size:1.1em;
	    float: left;

	   
	}
	.bi_wrapper{
		margin-top: -5px;
		margin-bottom: -5px;
		top:0px;
		bottom:0px;
	}
	.table>tr{
		margin: none;
		padding: none !important;
		border: none !important;
	}
	.table td{
		border-top: none !important;
	}
	.table >tr>td {border:none ;margin:0px !important; padding: 0px !important;}
	.table_button_quarter{
		width:25%;
	}
	.table_button_half{
		width:50%;
	}
	.table_input_half{
		width: 50%;
	}
	.table_input_3_4{
		width:80% !important;
	}
	.table_input_full{
		width:100% !important;
	}
	.table_input::-webkit-input-placeholder { /* Chrome/Opera/Safari */
	  font-size:1em;
	  text-align: center;
	  padding: 2px;
	  color:#d3d3d3;
	}
	.table_input::-moz-placeholder { /* Firefox 19+ */
	  color: #d3d3d3;
	  font-size:1em;
	  text-align: center;
	  padding: 2px;
	}
	.table_input:-ms-input-placeholder { /* IE 10+ */
	  color: black;
	}
	.table_input:-moz-placeholder { /* Firefox 18- */
	  color: black;
	}
	.btn-whatsapp{color:#fff; text-align:center; background:#48C631;}
	.btn-facebook{color:#fff;background-color:#3b5998;border-color:rgba(0,0,0,0.2)}
	.btn-facebook:focus,.btn-facebook.focus{color:#fff;background-color:#2d4373;border-color:rgba(0,0,0,0.2)
	}
	.btn-wechat{color:#fff;background-color: #98d11c;}
	.btn-twitter{color:#fff;background-color:#55acee;border-color:rgba(0,0,0,0.2)}.btn-twitter:focus,.btn-twitter.focus{color:#fff;background-color:#2795e9;border-color:rgba(0,0,0,0.2)}
	.btn-twitter:hover{color:#fff;background-color:#2795e9;border-color:rgba(0,0,0,0.2)}
	.btn-instagram:active,.btn-instagram.active,.open>.dropdown-toggle.btn-instagram{background-image:none}
	.btn-instagram.disabled:hover,.btn-instagram[disabled]:hover,fieldset[disabled] .btn-instagram:hover,.btn-instagram.disabled:focus,.btn-instagram[disabled]:focus,fieldset[disabled] .btn-instagram:focus,.btn-instagram.disabled.focus,.btn-instagram[disabled].focus,fieldset[disabled] .btn-instagram.focus{background-color:#3f729b;border-color:rgba(0,0,0,0.2)}
	.btn-instagram .badge{color:#3f729b;background-color:#fff}
	.btn-linkedin{color:#fff;background-color:#007bb6;border-color:rgba(0,0,0,0.2)}.btn-linkedin:focus,.btn-linkedin.focus{color:#fff;background-color:#005983;border-color:rgba(0,0,0,0.2)}
	.btn-linkedin:hover{color:#fff;background-color:#005983;border-color:rgba(0,0,0,0.2)}
	.btn-linkedin:active,.btn-linkedin.active,.open>.dropdown-toggle.btn-linkedin{color:#fff;background-color:#005983;border-color:rgba(0,0,0,0.2)}.btn-linkedin:active:hover,.btn-linkedin.active:hover,.open>.dropdown-toggle.btn-linkedin:hover,.btn-linkedin:active:focus,.btn-linkedin.active:focus,.open>.dropdown-toggle.btn-linkedin:focus,.btn-linkedin:active.focus,.btn-linkedin.active.focus,.open>.dropdown-toggle.btn-linkedin.focus{color:#fff;background-color:#00405f;border-color:rgba(0,0,0,0.2)}
	.btn-linkedin:active,.btn-linkedin.active,.open>.dropdown-toggle.btn-linkedin{background-image:none}
	.btn-linkedin.disabled:hover,.btn-linkedin[disabled]:hover,fieldset[disabled] .btn-linkedin:hover,.btn-linkedin.disabled:focus,.btn-linkedin[disabled]:focus,fieldset[disabled] .btn-linkedin:focus,.btn-linkedin.disabled.focus,.btn-linkedin[disabled].focus,fieldset[disabled] .btn-linkedin.focus{background-color:#007bb6;border-color:rgba(0,0,0,0.2)}
	.btn-linkedin .badge{color:#007bb6;background-color:#fff}
</style>
@stop
@section('content')

<div class="container">

	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table">
				<tr>
					<td><h2>Buyer Registration</h2></td>
				</tr>
				<tr>
					<td>
				
					<div class="bi_wrapper">		
					  <button type="button" class="table_button table_button_half btn-facebook ">Facebook</button><input type="text" class="table_input table_input_half " placeholder="Text input" >
					</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="bi_wrapper">
							
							  <button type="button" class="table_button table_button_half btn-whatsapp ">Whatsapp</button>
							
							<input type="text" class="table_input table_input_half " placeholder="Text input">
							
          				</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="bi_wrapper">
							
							  <button type="button" class="table_button table_button_half btn-wechat ">&nbsp;WeChat&nbsp;</button>
							
							<input type="text" class="table_input table_input_half " placeholder="Text input">
							
          				</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="bi_wrapper">
							
							  <button type="button" class="table_button table_button_half btn-twitter ">&nbsp;&nbsp;Twitter&nbsp;&nbsp;</button>
							
							<input type="text" class="table_input table_input_half" placeholder="Text input">
							
          				</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="bi_wrapper">
							
							  <button type="button" class="table_button table_button_half btn-linkedin ">&nbsp;&nbsp;Linkedin&nbsp;&nbsp;</button>
							
							<input type="text" class="table_input table_input_half " placeholder="Text input">
							
          				</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="bi_wrapper">
							
							  <button type="button" class="table_button table_button_half btn-instagram ">&nbsp;&nbsp;Instagram&nbsp;&nbsp;</button>
							
							<input type="text" class="table_input table_input_half " placeholder="Text input">
							
          				</div>
					</td>
				</tr>
				
			</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<table class="table">
					<tr>
					<td colspan="2">
						<input type="" name="" class=" table_input table_input_full" placeholder="Username">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="" name="" class=" table_input table_input_full" placeholder="Email">
					</td>
				</tr>
					<tr>
						<td><input type="text" class="table_input table_input_full" placeholder="Password"></td>
						<td><input type="text" class="table_input table_input_full" placeholder="ReConfirm"></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<table class="table">
					<tr>
						<td colspan="3">
						<input type="" name="" class=" table_input table_input_full" placeholder="Name">
						</td>
					</tr>
					<tr>
						<td>
							<select class="table_input table_input_full table_input_select no_select2 form-control"><option>Salutation</option></select>
						</td>
						<td ><select class="table_input table_input_full table_input_select no_select2 form-control"><option>Gender</option></select></td>
						<td><select class="table_input table_input_full table_input_select no_select2 form-control"><option>Annual Income</option></select></td>
					</tr>
					{{--  --}}
					<tr>
						<td>
							<select class="table_input table_input_full table_input_select no_select2 form-control"><option>Occupation</option></select>
						</td>
						<td ><input type="text" name="" class="table_input_full datepicker table_input" placeholder="DOB"></td>
						<td><select class="table_input table_input_full table_input_select no_select2 form-control"><option>Language</option></select></td>

					</tr>
					<tr>
						<td colspan="2">
							<input type="text" name="" class="table_input table_input_3_4" placeholder="Mobile" style="float: left;">
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	{{-- Delivery --}}
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<table class="table">
					<tr>
						<td colspan="2"><h2>Delivery</h2></td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="" name="" class="table_input_full table_input" placeholder="Default Address">
						</td>
					</tr>
					<tr>
						<td>
							<select class="form-control table_input_select no_select2 ">
								<option>Country</option>
							</select>
						</td>
						<td>
							<select class="form-control table_input_select no_select2">
								<option>State</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<select class="form-control no_select2 table_input_select">
								<option>City</option>
							</select>
						</td>
						<td>
							<select class="form-control no_select2 table_input_select">
								<option>Area</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<input type="" name="" class="table_input_full table_input" placeholder="Postcode">
						</td>
						<td></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<table class="table">
					<tr>
						<td colspan="2">
							<input type="" name="" class="table_input_full table_input" placeholder="Billing Address">
						</td>
					</tr>
					<tr>
						<td>
							<select class="form-control table_input_select no_select2 ">
								<option>Country</option>
							</select>
						</td>
						<td>
							<select class="form-control table_input_select no_select2">
								<option>State</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<select class="form-control no_select2 table_input_select">
								<option>City</option>
							</select>
						</td>
						<td>
							<select class="form-control no_select2 table_input_select">
								<option>Area</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<input type="" name="" class="table_input_full table_input" placeholder="Postcode">
						</td>
						<td></td>
					</tr>
					<tr>
						<td colspan="2"><label class="pull-right"><input type="checkbox" name="" class="table_input_checkbox">
						Same as default address
						</label>
						</td>

					</tr>
				</table>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<table class="table">
					<tr>
						<td colspan="2">
							<input type="" name="" class="table_input_full table_input" placeholder="Default Address">
						</td>
					</tr>
					<tr>
						<td>
							<select class="form-control table_input_select no_select2 ">
								<option>Country</option>
							</select>
						</td>
						<td>
							<select class="form-control table_input_select no_select2">
								<option>State</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<select class="form-control no_select2 table_input_select">
								<option>City</option>
							</select>
						</td>
						<td>
							<select class="form-control no_select2 table_input_select">
								<option>Area</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<input type="" name="" class="table_input_full table_input" placeholder="Postcode">
						</td>
						<td></td>
					</tr>
					<tr>
						<td colspan="2"><label class="pull-right"><input type="checkbox" name="" class="table_input_checkbox">
						Same as default address
						</label>
						</td>

					</tr>
				</table>
			</div>
		</div>
	</div>
	
	 <div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<table class="table">
					<tr>
						<td>
							<h2>Received Method</h2>
						</td>
					</tr>
					<tr>
						<td>
							<input type="" name="" class=" table_input table_input_full" placeholder="Account Name">
						</td>
					</tr>
					<tr>
						<td>
							<input type="" name="" class=" table_input table_input_full" placeholder="Account Name">
						</td>
					</tr>
					<tr>
						<td>
							<input type="" name="" class=" table_input table_input_full" placeholder="Account Number">
						</td>
					</tr>
					<tr>
						<td>
							<input type="" name="" class=" table_input table_input_full" placeholder="Bank">
						</td>
					</tr>
					<tr>
						<td>
							<input type="" name="" class=" table_input table_input_full" placeholder="IBAN">
						</td>
					</tr>
					<tr>
						<td>
							<input type="" name="" class=" table_input table_input_full" placeholder="SWIFT">
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>

</div>

@stop
@section('footer_script')

<script type="text/javascript" src="{{asset('js/niceselect.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('select').niceSelect();
		$('.datepicker').DatePicker();
	});
</script>
@stop