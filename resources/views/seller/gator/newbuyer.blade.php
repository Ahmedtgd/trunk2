<style>
.myform {
	display: flex;
	align-items: center;
}

.myform label {
	order: 1;
	width: 16em;
	padding-right: 0.5em;
}

.myform input {
	order: 2;
	flex: 1 1 auto;
	margin-bottom: 0.2em;
}
</style>
<div class="modal fade" id="newbuyer" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">

			<div class="modal-header"
			style="border-top-left-radius:10px;border-top-right-radius:10px;
				border-color:green;background-color:green;color:white;
				-webkit-background-clip: padding-box; 
				background-clip:padding-box;
				-moz-background-clip:padding;">
				<button type="button" class="close"
					style="color:white"
					data-dismiss="modal">&times;
				</button>
				<h3 style="margin-top:0;margin-bottom:0"
					class="text-left">New Unregistered Merchant</h3>
			</div>
			<div class="modal-footer">


				<div class="col-sm-10">
					<form id="savebuyer" class="form-inline">
						<h3 class="text-right">
						Unregistered Merchant Details</h3>

						<div class="myform">
							<label>Company Name *</label>
							<input class="form-control" type="textbox"
								value="" name="company_name">
						</div>

						<div class="myform">
							<label class="">Business Registration No *</label>
							<input class="form-control" value="" type="textbox" name="br">
						</div>

						<div class="myform">
							<label class="">GST/SST/VAT Registration No</label>
							<input class="form-control" value="" type="textbox" name="gst">
						</div>

						<!--
						<div class="myform">
							<label >Location</label>

							<input class="form-control" type="text" name="location">
						</div>
						-->

						<div class="myform">
							<label >Address line 1 *</label>
							<input class="form-control" type="textbox"
                                   value=""	name="address1">
						</div>

						<div class="myform">
							<label >Address line 2</label>
							<input class="form-control" type="textbox"
                                   value=""	name="address2">
						</div>

						<div class="myform">
							<label >Address line 3</label>
							<input class="form-control" type="textbox"
                                   value=""	name="address3">
						</div>

						<div hidden="hidden"
							class="row single-input form-group5">
							<div class="col-sm-12 col-lg-12">
								<label class="col-sm-4 col-lg-4">Country *</label>
								<div class="col-sm-8 col-lg-8">
									<input class="form-control" type="number"
									value="150" name="country">
								</div>
							</div>
						</div>


						<div class="myform">
							<label >State *</label>

							<input class="form-control" type="textbox" value="Wilayah Persekutuan" name="state">
						</div>


						<div class="myform">
							<label >City *</label>

							<input class="form-control" type="textbox" value="Kuala Lumpur" name="city">

						</div>

						<div class="myform">
							<label >PostCode *</label>

							<input value="" class="form-control" type="textbox" name="postcode">
						</div>

						<hr>

						<h3 style="display: flex; padding-left: 7em">Contact Person</h3>
						<div class="myform">
							<label >First Name</label>
							<input value="" class="form-control" type="textbox" name="fname">

						</div>


						<div class="myform">
							<label >Last Name</label>

							<input value="" class="form-control" type="textbox" name="lname">

						</div>

						<div class="myform">
							<label>Designation</label>

							<input value="" class="form-control" type="textbox" name="designation">

						</div>

						<div class="myform">

							<label>Mobile</label>

							<input value="" class="form-control" type="textbox" name="mobile">
						</div>


						<div class="myform">
							<label >Email</label>

							<input value="" class="form-control" type="textbox" name="email">
						</div>

						<div class="modal-footer" style="padding-right: 0px">
							<button id="btnsavebuyer" type="button"
							style="border-radius:5px"
							class="btn btn-green">Save</button>
							<!--  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> -->
						</div>
					</form>
				</div>

			</div>

		</div>

	</div>
</div>
