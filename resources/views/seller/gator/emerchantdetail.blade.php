
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
<div class="col-sm-10">


					<div class="form-inline">
						<div class="myform">
							<label>Company Name *</label>
							<input class="form-control" disabled="disabled" value="{{$emerchant->company_name}}" type="text" name="company_name">
						</div>


						<div class="myform">

							<label class="">Business Registration No *</label>

							<input class="form-control" disabled="disabled" value="{{$emerchant->business_reg_no}}" type="text" name="br">
						</div>


						<div class="myform">

							<label class="">GST Registration No *</label>

							<input class="form-control" disabled="disabled" value="{{$emerchant->gst_reg_no}}" type="text" name="gst">


						</div>

								<!--
								<div class="myform">
									<label >Location</label>

									<input class="form-control" type="text" name="location">
								</div>
							-->

							<div class="myform">
								<label >Address line 1</label>

								<input class="form-control" disabled="disabled" value="{{$emerchant->address_line1}}" type="text" name="address1">
							</div>

							<div class="myform">
								<label >Address line 2</label>

								<input class="form-control" disabled="disabled" value="{{$emerchant->address_line2}}" type="text" name="address2">
							</div>

							<div class="myform">
								<label >Address line 3</label>

								<input class="form-control" disabled="disabled" value="{{$emerchant->address_line3}}" type="text" name="address3">
							</div>

							<div hidden="hidden" class="row single-input form-group5">
								<div class="col-sm-12 col-lg-12">
									<label class="col-sm-4 col-lg-4">Country *</label>
									<div class="col-sm-8 col-lg-8">
										<input class="form-control" disabled="disabled" value="{{$emerchant->country}}" type="number" value="150" name="country">
									</div>
								</div>
							</div>


							<div class="myform">
								<label >State *</label>

								<input class="form-control" disabled="disabled" value="{{$emerchant->state}}" type="text"  name="state">
							</div>


							<div class="myform">
								<label >City *</label>

								<input class="form-control" disabled="disabled" value="{{$emerchant->city}}" type="text" value="Kuala Lumpur" name="city">

							</div>

							<div class="myform">
								<label >PostCode *</label>

								<input class="form-control" disabled="disabled" value="{{$emerchant->postcode}}" type="text" name="postcode">
							</div>


							
					</div>
				</div>