@extends("common.default")
<?php 
define('MAX_COLUMN_TEXT', 20);
use App\Http\Controllers\IdController;
use App\Models\Currency;

$total_smm_army=0;
$channels = array(
	array('id'=> 1, 'description' => 'Email', 'checked' => true),
	array('id'=> 2, 'description'=> 'SMM Army', 'checked' => true));
	$currency =   $currency = Currency::where('active', 1)->first();
	$currencyCode = $currency->code;
?>
@section("content")
@include('common.sellermenu')
<style>
	.storebutton{
		background-color: #FF3333 !important;
	}
</style>
<section class="">
  	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-lg-12">  
				{{-- Tabbed Nav --}}
				<h2>New supplier</h2>
				<!-- <div class="panel with-nav-tabs panel-default ">
					<div class="panel-heading">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#customers" data-toggle="tab">Customer</a></li>
							<li><a href="#employees" data-toggle="tab">Staff</a></li>
							<li><a href="#merchantOpenchannel" id="merchantOpenchannellink" data-toggle="tab">Supplier</a></li>
							<li><a href="#stationOpenchannel" id="stationOpenchannellink" data-toggle="tab">Dealer</a></li>
							
						</ul>
					</div>
				</div> -->
				{{--ENDS  --}}
				<div id="dashboard" class="row panel-body" style="padding-top:20px" >
					<div class="tab-content top-margin" style="margin-top:-30px">
						<!-- CUSTOMER LIST -->
						<?php $e=1;?>
						<div class="container nomobile">
							<div class="row">
								<div class="col-sm-2"></div>
								<div class="col-sm-8">
			                		<form>
								         <div class="row single-input form-group">
				                			<div class="col-sm-12 col-lg-12">
					                			<label class="col-sm-4 col-lg-4">Company Name *</label>
					                			<div class="col-sm-8 col-lg-8">
					                				<input class="form-control" type="text" name="name">
					                			</div>
					                		</div>
					                	</div>
					                	<div class="row single-input form-group">
					                		<div class="col-sm-12 col-lg-12">
					                			<label class="col-sm-4 col-lg-4">Business Registration No *</label>
					                			<div class="col-sm-8 col-lg-8">
					                				<input class="form-control" type="text" name="br">
					                			</div>
					                		</div>
					                	</div>
					                	<div class="row single-input form-group">
					                		<div class="col-sm-12 col-lg-12">
					                			<label class="col-sm-4 col-lg-4">GST Registration No *</label>
					                			<div class="col-sm-8 col-lg-8">
					                				<input class="form-control" type="text" name="gst">
					                			</div>
					                		</div>
					                	</div>
					                	<div class="row single-input form-group">
					                		<div class="col-sm-12 col-lg-12">
					                			<label class="col-sm-4 col-lg-4">Address *</label>
					                			<div class="col-sm-8 col-lg-8">
					                				<textarea class="form-control" type="text" name="address"></textarea>
					                			</div>
					                		</div>
					                	</div>
					                	<div class="row single-input form-group">
					                		<div class="col-sm-12 col-lg-12">
					                			<label class="col-sm-4 col-lg-4">Country *</label>
					                			<div class="col-sm-8 col-lg-8">
					                				<input class="form-control" type="text" name="country">
					                			</div>
					                		</div>
					                	</div>
					                	<div class="row single-input form-group">
					                		<div class="col-sm-12 col-lg-12">
					                			<label class="col-sm-4 col-lg-4">State *</label>
					                			<div class="col-sm-8 col-lg-8">
					                				<input class="form-control" type="text" name="state">
					                			</div>
					                		</div>
					                	</div>
					                	<div class="row single-input form-group">
					                		<div class="col-sm-12 col-lg-12">
					                			<label class="col-sm-4 col-lg-4">City *</label>
					                			<div class="col-sm-8 col-lg-8">
					                				<input class="form-control" type="text" name="city">
					                			</div>
					                		</div>
					                	</div>
					                	<div class="row single-input form-group">
					                		<div class="col-sm-12 col-lg-12">
					                			<label class="col-sm-4 col-lg-4">PostCode *</label>
					                			<div class="col-sm-8 col-lg-8">
					                				<input class="form-control" type="text" name="postcode">
					                			</div>
					                		</div>
					                	</div>
					                	<div class="row single-input form-group">
					                		<div class="col-sm-12 col-lg-12">
					                			<label class="col-sm-4 col-lg-4">Contact Name *</label>
					                			<div class="col-sm-8 col-lg-8">
					                				<input class="form-control" type="text" name="cname">
					                			</div>
					                		</div>
					                	</div>
					                	<div class="row single-input form-group">
					                		<div class="col-sm-12 col-lg-12">
					                			<label class="col-sm-4 col-lg-4">Title *</label>
					                			<div class="col-sm-8 col-lg-8">
					                				<input class="form-control" type="text" name="title">
					                			</div>
					                		</div>
					                	</div>
					                	<div class="row single-input form-group">
					                		<div class="col-sm-12 col-lg-12">
					                			<label class="col-sm-4 col-lg-4">Mobile *</label>
					                			<div class="col-sm-8 col-lg-8">
					                				<input class="form-control" type="text" name="mobile">
					                			</div>
					                		</div>
					                	</div>
					                	<div class="row single-input form-group">
					                		<div class="col-sm-12 col-lg-12">
					                			<label class="col-sm-4 col-lg-4">Email *</label>
					                			<div class="col-sm-8 col-lg-8">
					                				<input class="form-control" type="text" name="email">
					                			</div>
					                		</div>
					                	</div>
				                		<div class="modal-footer">
						                	<button type="button" class="btn btn-green">Save</button>
						               		<!--  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> -->
					            		</div>
			            			</form>
					            </div>
					            <div class="col-sm-2"></div>
				        	</div>
			            </div>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
</section>
@stop
