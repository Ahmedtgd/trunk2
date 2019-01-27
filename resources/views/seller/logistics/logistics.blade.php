@extends("common.default")
@section("content")
@include('common.sellermenu')

<link href="{{url('jqgrid/ui.jqgrid.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('css/datatable.css')}}" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}"/>
<style>
.tab-pane{
	margin-top: 4em;
}

.top-margin{
	margin-top: -30px;
}

.controlbtn{
    	width: 70px;
    	height: 70px;
    	padding-top: 15px;
    	text-align: center;
    	vertical-align: middle;
    	font-size: 13px;
    	cursor: pointer;
    	margin-right: 5px;
    	margin-bottom: 5px;
    	border-radius: 5px
    }
.float-right{
	float: right;
}

table#notproduct_details_table
{
	/*  table-layout: fixed;*/
	max-width: none;
	width: auto;
	min-width: 100%;
}

table#product_details_table
{
	table-layout: fixed;
	max-width: none;
	width: auto;
	min-width: 100%;
}
.aproducts{
	width: 100% !important;
}
.no-sort{
	width: 20px !important;
}
#upload-form{
	/*position: absolute;*/
	/*top: 50%;*/
	/*left: 50%;*/
	/*margin-top: -100px;*/
	/*margin-left: -250px;*/
	width: 500px;
	height: 200px;
	border: 4px dashed #333333;
}
.select2{display: none;}
#upload-form .p-sty{
	width: 100%;
	height: 100%;
	text-align: center;
	line-height: 170px;
	color: #333333;
}
#upload-form .input-sty{
	position: absolute;
	margin: 0;
	padding: 0;
	width: 100%;
	height: 200px;
	outline: none;
	opacity: 0;
}
#upload-form .button-sty{
	margin: 0;
	color: #fff;
	background: #16a085;
	border: none;
	width: 508px;
	height: 35px;
	margin-top: -20px;
	margin-left: -4px;
	border-radius: 4px;
	border-bottom: 4px solid #117A60;
	transition: all .2s ease;
	outline: none;
}
#upload-form .button-sty:hover{
	background: #149174;
	color: #0C5645;
}
#upload-form .button-sty:active{
	border:0;
}
.logo-header {
	padding-left:0;
	padding-right:0;
}
body {
	font-family: Lato;
}
.navbar-inverse .navbar-nav>li>a {
	color:white;
}

.myform{
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

@media (min-width: 768px){
	.modal-dialog {
		width: 800px;
		margin: 30px auto;
	}
}

</style>

<section class="">
	<div class="container"><!--Begin main cotainer-->
		<div class="alert alert-success alert-dismissible hidden cart-notification" role="alert" id="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong class='cart-info'></strong>
		</div>
		<input type="hidden" value="" id="selluserid" />

		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="row">
						@if(Session::has('success'))
						<script type="text/javascript">
							toastr.success("{{Session::get('success')}}");
						</script>
						@endif

						@if(Session::has('error_message'))
						<script type="text/javascript">
							toastr.error("{{Session::get('error_message')}}");
						</script>

						@endif

					</div>
					{{-- Tabbed Nav --}}
					<div class="panel with-nav-tabs panel-default " style="margin: 0 !important;">
						<div class="panel-heading">
						<h2 style="margin-top:10px">Logistics Management</h2>
							<ul class="nav nav-tabs">
								<li id="tb-list-product" class="active">
									<a href="#deliveryorder" data-toggle="tab">
									Delivery Control</a></li>
								<li id="tb-list-pickupcontrol" class="">
									<a href="#pickupcontrol" data-toggle="tab">
									Pick Up Control</a></li>
								<li id="tb-list-deliveryman" class="">
									<a href="#deliveryman" data-toggle="tab">
									Deliveryman </a></li>
								<li id="tb-list-vehicle" class="">
									<a href="#vehicle" data-toggle="tab">
									Vehicle</a></li>
 								<li id="tb-list-delivery" class="">
									<a href="#delivery" data-toggle="tab">
									Delivery</a></li>
 								<li id="tb-list-pickup" class="">
									<a href="#pickup" data-toggle="tab">
									Pick Up</a></li>
 								<li id="tb-list-traffic" class="">
									<a href="#traffic" data-toggle="tab">
									Traffic</a></li>
 
 

							{{-- <li id="tb-return-goods" ><a href="#return-of-goods" data-toggle="tab">Debit Note</a></li>
                            <li id="tb-return-status" ><a href="#return-status" data-toggle="tab">Return Status</a></li>
                            <li id="tb-merchant-approval" ><a href="#merchant-approval" data-toggle="tab">Merchant Approval</a></li> --}}
							<!--	<li id="tb-ageing-report" ><a href="#ageing-report" data-toggle="tab">Debtor Ageing Report</a></li>
									<li id="tb-add-product" ><a href="#documents" data-toggle="tab">Documents</a></li>
									<li id="tb-cageing-report" ><a href="#cageing" data-toggle="tab">Creditor Ageing Report</a></li>
									<li id="tb-cageing-report" ><a href="#sdocuments" data-toggle="tab">Station Documents</a></li> -->
								</ul>
							</div>
						</div>
						{{--ENDS  --}}
						<input type="hidden" value="" id="mmerchant_id" />
						<input type="hidden" value="" id="msell_id" />
						<div id="dashboard" class="row panel-body " style="padding: 0px 15px 15px 15px" >

							<div class="tab-content top-margin" style="margin-top:-50px">

 								<div class="tab-pane fade in" id="deliveryman">
									<div class="row">
										<div class="col-md-6">
											<h2>Deliveryman Management</h2>
										</div>
										<div class="col-md-3">
											<h4>Total Location</h4>
											<h4>Total Assignment (DO+TR)</h4>
										</div>
										<div class="col-md-3">
											<button onclick="vehical_delivery_man()" class="btn pull-right" style="text-align: center;height: 70px;width: 70px; border-radius: 5px; background-color: #6d9270; border-color: #6d9270; color: white;margin: 5px;">Vehicle</button>
										</div>
									</div>


										<div class="row" style="padding: 0px 10px 0px 10px;">
											<table class="table table-bordered table-responsive" id="delivery-man-table" style="width: 100%;">
												<thead class="aproducts">
												<tr style="background-color: #6d9270; color: #FFF;">
													<th class="text-center no-sort" width="20px" style="width: 20px !important;">No</th>
													<th class="text-center">Delivery Man ID</th>
													<th class="text-center">Name</th>
													<th class="text-center">Plate No.</th>
													<th class="text-center">Setting</th>
													<th class="text-center">DO</th>
													<th class="text-center">TR</th>
													<th class="text-center">Location </th>
												</tr>
												</thead>
                                                 <tbody>
													<tr class="text-center">
														<td>1</td>
														<td>32452323</td>
														<td>Ali</td>
														<td><a onclick="plateNo()">ABC 1234</a></td>
														<td></td>
														<td></td>
														<td>5</td>
														<td><a onclick="delivery_activity()">5</a>
														</td>

													</tr>
												</tbody>
											</table>
										</div>

									<br>
								</div>

   								<div class="tab-pane fade in" id="pickupcontrol">
									<div class="row">
										<div class="col-md-6">
											<h2>Pick Up Control</h2>
										</div>
									</div>

									<div class="row" style="padding: 0px 10px 0px 10px;">
										<table class="table table-bordered table-responsive" id="pickupcontrol_tbl" style="width: 100%;">
											<thead class="aproducts">
											<tr class="bg-logistics">
												<th class="text-center no-sort" width="20px" style="width: 20px !important;">No</th>
												<th class="text-center">Document No</th>
												<th class="text-center">Date</th>
												<th class="text-center">Source</th>
												<th class="text-center">Deliveryman</th>
												<th class="text-center">Location</th>
												<th class="text-center">Status</th>
												<th class="text-center">Action</th>
											</tr>
											</thead>

											<tbody>
											<tr class="text-center">
												<td>1</td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
											</tbody>
										</table>
									</div>

									<br>
								</div>
 
  								<div class="tab-pane fade in" id="vehicle">
									<div class="row">
										<div class="col-md-6">
											<h2>Vehicle Management</h2>
										</div>
									</div>
									<br>
								</div>

   								<div class="tab-pane fade in" id="delivery">
									<div class="row">
										<div class="col-md-6">
											<h2>Delivery Management</h2>
										</div>
									</div>

                    <div class="row" style="padding: 0px 10px 0px 10px;">
                        <table class="table table-bordered table-responsive" id="delivery-managment" style="width: 100%;">
                            <thead class="aproducts">
                            <tr class="bg-logistics">
                                <th class="text-center no-sort" width="20px" style="width: 20px !important;">No</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">From</th>
                                <th class="text-center">To</th>
                                <th style="background-color: black;" class="text-center">Item</th>
                                <th class="bg-status text-center">Status</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr class="text-center">
                                <td>1</td>
                                <td>12-Dec-18</td>
                                <td>Sri Petaling</td>
                                <td>Subang</td>
                                <td><a onclick="delivery_mng_item()">5</a></td>
				<td><a onclick="delivery_mng_status()">5</a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

									<br>
								</div>

   								<div class="tab-pane fade in" id="pickup">
									<div class="row">
										<div class="col-md-6">
											<h2>Pick Up Management</h2>
										</div>
									</div>
									<div class="row" style="padding: 0px 10px 0px 10px;">
										<table class="table table-bordered table-responsive" id="pickup-managment" style="width: 100%;">
											<thead class="aproducts">
											<tr style="background-color: #FD0002; color: #FFF;">
												<th class="text-center no-sort" width="20px" style="width: 20px !important;">No</th>
												<th class="text-center">Date</th>
												<th class="text-center">Delivery Man</th>
												<th class="text-center">From</th>
												<th class="text-center">To</th>
												<th style="background-color: black;" class="text-center">Item</th>
												<th class="bg-status text-center">Status</th>
											</tr>
											</thead>

											<tbody>
											<tr class="text-center">
												<td>1</td>
												<td>12-Dec-18</td>
												<td></td>
												<td>Sri Petaling</td>
												<td>Subang</td>
												<td><a onclick="delivery_mng_item_pickup()">5</a></td>
												<td><a onclick="delivery_mng_status_pickup()">5</a></td>
											</tr>
											</tbody>
										</table>
									</div>
									<br>
								</div>
 
								<div class="tab-pane fade in" id="traffic">
									<div class="row">
										<div class="col-md-6">
											<h2>Traffic Management</h2>
										</div>
									</div>
									<br>
								</div>
 

								<div class="tab-pane fade in active" id="deliveryorder">
									<div class="row">
										<div class="col-md-6">
											<h2>Delivery Control</h2>
										</div>
										<div class="col-md-6">
											<button class="btn pull-right" data-toggle="modal" data-target="#importModal" style="text-align: center;height: 70px;width: 70px; border-radius: 5px; background-color: #d34142; border-color: #d34142; color: white;margin: 5px;">Excel<br>Import</button>
											<button class="btn pull-right" data-toggle="modal" data-target="#exportModal" style="text-align: center;height: 70px;width: 70px; border-radius: 5px; background-color: #196000; border-color: #196000; color: white;margin: 5px;">Excel<br>Export</button>
										</div>
									</div>
									<div class="row" style="padding: 0px 10px 0px 10px;">
									<table class="table table-bordered table-responsive" id="delivery-order-table" >
									<thead class="aproducts">
									<tr style="background-color: #6d9270; color: #FFF;">
										<th class="text-center no-sort"
											width="20px" style="width: 20px !important;">No</th>
										<th class="text-center">DO No.</th>
										<th class="text-center">Date</th>
										<th class="text-center">Source</th>
										<th class="text-center">Amount ({{$currentCurrency}})</th>
										<th class="text-center">Deliveryman </th>
										<th class="text-center">Initial</th>
										<th class="text-center">Status</th>
										<th class="text-center">Action</th>
									</tr>
									</thead>
									<tbody><?php $count=1 ?>
										@if(isset($delivery_orders))

										<?php   $savequery = $cporders;  ?>
										@foreach($delivery_orders as $do)
										<?php  $porders = $savequery;  ?>
										<tr>
											<td class="text-center" style="vertical-align: middle">{{$count++}}</td>
											<td class="text-center" style="vertical-align: middle">
												@if(($do['status'] != 'pending'))
													@if(!(is_null($do['deliveryorder_no'])) )
												<a target="_blank" href="{{route("displaydeliveryorderdocument",$do['porder_id'])}}">
													{{sprintf('%010d', $do['deliveryorder_no'])}}</a>
														@endif
												@endif
												{{--@if($do['source']=="imported")--}}
												{{--{{$do['ndid']}}--}}
												{{--@else--}}
													{{--<a href="{{route('displaysalesorderdocument',--}}
													{{--['id' => $do['porder_id'],--}}
													{{--'nid' => $do['ndid'],--}}
													{{--'heading'=> "Delivery Order"])}}">{{$do['ndid']}}</a>--}}
													{{--@endif--}}
											</td>
											<td class="text-center" style="font-size:13px;width:95px;vertical-align: middle;padding-left:0;padding-right:0">{{date('dMy H:i', strtotime($do['created_at']))}}</td>
											<td class="text-center" style="vertical-align: middle">
												{{--@if($do['status'] == "inprogress" || $do['status'] == "completed" || $do['status'] == "cancelled" --}}
												{{--||( $do['action'] == "issue" && $do['discard'] == "pickup"))--}}
													@if(!is_null($do->invoice_no))
													<a onclick="displayDirectInvoice({{$do->porder_id}})" >{{strtoupper($do['source'])}}</a>
												@else
													<a onclick="displaySalesOrder({{$do->porder_id}})" >{{strtoupper($do['source'])}}</a>
												@endif
											</td>
											<td class="text-right" style="vertical-align: middle">
												{{number_format($do->price/100, 2)}}
											</td>
											<td  style="vertical-align: middle">
												@if($do['delivery_firstname'] != null && $do['delivery_lastname'] != null)
												{{$do['delivery_firstname']}} {{$do['delivery_lastname']}}

												@elseif($do['delivery_username'] != null)
												{{$do['delivery_username'] }}
												@else
												{{$do['delivery_man_email']}}
												@endif
											</td>
											<td style="vertical-align: middle">
												<select name="" id="ini_loc{{$count}}" class="form-control"  @if($do['initial_location_id']) disabled @endif>
													@if($do['initial_location_id'])
													@foreach($dils as $dil)
													@if($do['initial_location_id'] == $dil->id )
													<option value="{{$dil->id}}">{{$dil->location}}</option>
													@endif
													@endforeach
													@else
													@foreach($dils as $dil)

													<option value="{{$dil->id}}"
														@if($dil->default_initial_location == 1) selected @endif
														>{{$dil->location}}</option>
														@endforeach
														@endif
													</select>
												</td >
												<td class="text-center" style="vertical-align: middle">
													@if($do["stockreport_status"]=="confirmed")
													<a onclick="importedstatus({{$do['do_id']}})">Confirmed</a>
													@else
														@if($do['source']=="imported")
														<a onclick="importedstatus({{$do['do_id']}})">
															@if($do['status']=='converted_tr')
															{{'Attached TR'}}
															@elseif($do['status']=='inprogress')
															{{'In Progress'}}
															@else
															{{ucfirst($do['status'])}}
															@endif
														</a>
														@else
															@if($do['status']=='converted_tr')
															{{'Attached TR'}}
															@elseif($do['status']=='inprogress')
															{{'In Progress'}}
															@else
															{{ucfirst($do['status'])}}
															@endif
														@endif
													@endif
												</td>
												<td class="text-center" style="vertical-align:middle;padding-left:0;padding-right:0">
													@if($do['stockreport_status']=="confirmed")
													<button class="btn btn-disabled" disabled="" style="min-width: 70px; margin: 0px; font-size: 14px">DO/Invoice</button>
													<button class="btn btn-disabled" disabled="" style="min-width: 70px; margin: 0px; font-size: 14px"> TR </button>
													<button class="btn btn-disabled" disabled="" style="min-width: 70px; margin: 0px; font-size: 14px"> Discard </button>
													@elseif($do['status']=="completed")
													<button class="btn btn-disabled" disabled="disabled" style="min-width: 70px; margin: 0px; font-size: 14px">DO/Invoice</button>
													<button class="btn btn-disabled" disabled="disabled" style="min-width: 70px; margin: 0px; font-size: 14px"> TR </button>
													<button class="btn btn-disabled" disabled="disabled" style="min-width: 70px; margin: 0px; font-size: 14px"> Discard </button>
													@else
													<?php
														$disabled = '';
														$class = '';
														if($do['status']=='cancelled'){
															$disabled = 'disabled';
														}
													?>
													<button {{$disabled}}  @if($do['source']=="imported")
														class="btn btn-disabled"  disabled
														@else
														class="btn @if($do['status']=='cancelled') btn-disabled @else btn-success @endif" " onclick="issueDoModal('{{$do['ndid']}}','{{$do['do_id']}}','{{$do['porder_id']}}')"
														@endif
														style="min-width: 70px; margin: 1px; font-size: 14px">DO/Invoice
													</button>
													@if($do['status']=='converted_tr')
													<a href="{{route('canceltr',$do['do_id'])}}">
														<button style="min-width: 70px; margin: 1px; font-size: 14px" class="btn btn-danger" >
															Cancel
														</button>
													</a>
													@else
													<button  

													@if($do['source']=="imported")
													class="btn btn-warning"
													onclick="trDoModal('{{$do['ndid']}}','{{$do['do_id']}}','{{$count}}','{{$do['f_location']}}')"

													@else  class="btn btn-disabled"  disabled
													@endif
													style="min-width: 70px; margin: 1px; font-size: 14px">

													TR
												</button>
												@endif
												<?php
													$disabled = '';
													$class = '';
													if(($do['status']=='cancelled') || ($do['status']=='pending')) {
														$disabled = 'disabled';
													}
													
												?>
												<button class="btn @if($do['status']=='cancelled') btn-disabled @else btn-danger @endif" {{$disabled}}	onclick="discardDoModal('{{$do['ndid']}}','{{$do['do_id']}}','{{$do['porder_id']}}')"
												style="min-width: 70px; margin: 1px; font-size: 14px">Discard</button>
												@endif
											</td>
										</tr>
										@endforeach

										@endif
										@if(isset($DirectInvoiceData))

										@foreach($DirectInvoiceData as $SingleDirectinvoicedata)
										<tr>
											<td class="text-center" style="vertical-align: middle">{{$count++}}</td>
											<td>
												
											</td>
											<td class="text-center" style="font-size:13px;width:95px;vertical-align: middle;padding-left:0;padding-right:0">{{date('dMy H:i', strtotime($SingleDirectinvoicedata->created_at))}}</td>
											<td class="text-center" style="vertical-align: middle">

												<a  onclick="displayDirectInvoice({{$SingleDirectinvoicedata->porder_id}})" >GATOR</a>
												
											</td>
											<td class="text-right" style="vertical-align: middle">
												{{number_format($SingleDirectinvoicedata->order_price/100, 2)}}
											</td>
											<td  style="vertical-align: middle">
												@if($do['delivery_firstname'] != null && $do['delivery_lastname'] != null)
												{{$do['delivery_firstname']}} {{$do['delivery_lastname']}}

												@elseif($do['delivery_username'] != null)
												{{$do['delivery_username'] }}
												@else
												{{$do['delivery_man_email']}}
												@endif
											</td>
											<td style="vertical-align: middle">
												<select name="" id="ini_loc{{$count}}" class="form-control"  @if($do['initial_location_id']) disabled @endif>
													@if($do['initial_location_id'])
													@foreach($dils as $dil)
													@if($do['initial_location_id'] == $dil->id )
													<option value="{{$dil->id}}">{{$dil->location}}</option>
													@endif
													@endforeach
													@else
													@foreach($dils as $dil)

													<option value="{{$dil->id}}"
														@if($dil->default_initial_location == 1) selected @endif
														>{{$dil->location}}</option>
														@endforeach
														@endif
													</select>
												</td >
											<td class="text-center" style="vertical-align: middle">
													{{ucfirst($SingleDirectinvoicedata->status)}}
														
												</td>
											<td class="text-center" style="vertical-align:middle;padding-left:0;padding-right:0">
													@if($do['stockreport_status']=="confirmed")
													<button class="btn btn-disabled" disabled="" style="min-width: 70px; margin: 0px; font-size: 14px">DO/<br>Invoice</button>
													<button class="btn btn-disabled" disabled="" style="min-width: 70px; margin: 0px; font-size: 14px"> TR </button>

													<button class="btn btn-disabled" disabled="" style="min-width: 70px; margin: 0px; font-size: 14px"> Discard</button>
													@else
													<button @if($do['source']=="imported")
													class="btn btn-disabled"  disabled
													@else
													class="btn btn-success" onclick="issueDoModal('{{$do['ndid']}}','{{$do['do_id']}}')"
													@endif
													style="min-width: 70px; margin: 1px; font-size: 14px">DO/<br>Invoice</button>

													@if($do['status']=='converted_tr')
													<a href="{{route('canceltr',$do['do_id'])}}">
														<button style="min-width: 70px; margin: 1px; font-size: 14px" class="btn btn-danger" >
															Cancel
														</button>
													</a>
													@else
													<button  

													@if($do['source']=="imported")
													class="btn btn-warning"
													onclick="trDoModal('{{$do['ndid']}}','{{$do['do_id']}}','{{$count}}','{{$do['f_location']}}')"

													@else  class="btn btn-disabled"  disabled
													@endif
													style="min-width: 70px; margin: 1px; font-size: 14px">

													TR
												</button>
												@endif
												<button class="btn btn-danger" 	onclick="discardDoModal('{{$do['ndid']}}','{{$do['do_id']}}','{{$do['porder_id']}}')"
												style="min-width: 70px; margin: 1px; font-size: 14px">Discard</button>
												@endif
											</td>
										</tr>
										@endforeach

										@endif

									</tbody>
									</table>
									</div>
								</div>

							<!-- <div class="tab-pane fade" id="documents">
										</div>

										<div class="tab-pane fade" id="add-product">
										</div>

										<div class="tab-pane fade" id="cageing">
										</div>

										<div class="tab-pane fade" id="sdocuments">

										</div>				 -->
									</div>
								</div>

							</div>
						</div>
					</div>
				</section>
<div class="modal fade" id="soModal" role="dialog">
	<div style="width: 80%;"  class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">


			<div class="modal-header">
				<button type="button" class="close"
						style="position:relative;top:-6px"
						data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body" style="padding-top:0 !important">
				<div id="sodisp"></div>
				<div style="display:none;" id="logistic_check">1</div>

			</div>
			<div class="modal-footer">

				<div class="col-md-12" id="footerDetails" style="display:none;">
				<table>
				<tr>
					<td style="text-align: left">
						<strong >Invoice No.  </strong>
					</td>
					<td>
						: <span id="InvoiceNo"></span>
					</td>
				</tr>
				
				<tr>
					<td style="text-align: left">
						<strong >Delivery Order ID  </strong>
					</td>
					<td>
						: <span id="doid"></span>
					</td>
				</tr>
				</table>
				<!-- <h5 style="float:left;padding-left:25px"></h5><br>
				<h5 style="float:left;padding-left:25px"></h5> -->
				</div>
				<!-- <h5 style="float:left"><strong>Invoice No: </strong>{{-- {{$do->do_id}} --}}</h5> -->
			
				<ul class="diff_msg">
				</ul>
			</div>
		</div>

	</div>
</div>

<div class="modal fade" id="doModal" role="dialog">
	<div style="width: 80%;"  class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">


			<div class="modal-header">
				<button type="button" class="close"
						style="position:relative;top:-6px"
						data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body" style="padding-top:0 !important">
				<div id="dodisp"></div>
			</div>
			<!-- <div class="modal-footer">

				<div class="col-md-12" id="footerDetails" style="display:none;">
				<table>
				<tr>
					<td style="text-align: left">
						<strong >Invoice No.  </strong>
					</td>
					<td>
						: <span id="InvoiceNo"></span>
					</td>
				</tr>
				
				<tr> -->
					<!-- <td style="text-align: left">
						<strong >Delivery Order ID  </strong>
					</td>
					<td>
						: <span id="doid"></span>
					</td>
				</tr>
				</table> -->
				<!-- <h5 style="float:left;padding-left:25px"></h5><br>
				<h5 style="float:left;padding-left:25px"></h5> -->
				<!-- </div> -->
				<!-- <h5 style="float:left"><strong>Invoice No: </strong>{{-- {{$do->do_id}} --}}</h5> -->
				<!-- <ul class="diff_msg">
				</ul>
			</div> -->
		</div>

	</div>
</div>



				<div id="plateNoPopUp" class="modal fade" role="dialog">
					<div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">ABC 123</h4>
							</div>
							<div style="padding: 15px;" class="modal-body-importedstatus" >
								<table class="table table-bordered table-responsive" id="plate-no-table" style="width: 100%;">
									<thead class="aproducts">
									<tr style="background-color: #6d9270; color: #FFF;">
										<th style="width:140px;"  class="text-center">Vehicle</th>
										<th style="width:140px;" class="text-center">Type</th>
										<th class="text-center">Max Volumetric</th>
										<th class="text-center">Capabilities</th>
										<th class="text-center">Owership</th>
										<th class="text-center">Assignment</th>
									</tr>
									</thead>
									<tbody>
									<tr class="text-center">
										<td>Man LorryMan Lorry</td>
										<td>Lorry Man Lorry</td>
										<td>150kg</td>
										<td></td>
										<td></td>
										<td>Delivery man</td>
									</tr>
									</tbody>
								</table>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>

				<div id="delivery_activityPopUp" class="modal fade" role="dialog">
					<div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h3 class="modal-title">Delivery Activity </h3>
							</div>
							<div style="padding: 15px;" class="modal-body-importedstatus" >
								<table class="table table-bordered table-responsive" id="delivery-activity-table" style="width: 100%;">
									<thead class="aproducts">
									<tr style="background-color: #131513; color: #FFF;">
										<th class="text-center">No</th>
										<th class="text-center">Location</th>
										<th class="text-center">Item</th>
										<th class="text-center">Start</th>
										<th class="text-center">Complete</th>
										<th class="text-center">Verified by</th>
									</tr>
									</thead>
									<tbody>
									<tr class="text-center">
										<td>1</td>
										<td>Kajang</td>
										<td>5</td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									</tbody>
								</table>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>



				<div id="delivery_activityPopUp" class="modal fade" role="dialog">
					<div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Delivery Activity </h4>
							</div>
							<div style="padding: 15px;" class="modal-body-importedstatus" >
								<table class="table table-bordered table-responsive" id="delivery-activity-table" style="width: 100%;">
									<thead class="aproducts">
									<tr style="background-color: #131513; color: #FFF;">
										<th class="text-center">No</th>
										<th class="text-center">Location</th>
										<th class="text-center">Item</th>
										<th class="text-center">Start</th>
										<th class="text-center">Complete</th>
										<th class="text-center">Verified by</th>
									</tr>
									</thead>
									<tbody>
									<tr class="text-center">
										<td>1</td>
										<td>Kajang</td>
										<td>5</td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									</tbody>
								</table>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>

				<div id="delivery_mng_status_PopUp" class="modal fade" role="dialog">
					<div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h3 class="modal-title">Status</h3>
							</div>

							<div class="row">
								<div style="padding: 25px;" class="modal-body-importedstatus" >
									<table class="table table-bordered table-responsive" id="vehical_delivery-table" style="width: 100%;">
										<thead class="aproducts">
										<tr style="background-color: green; color: #FFF;">
											<th style="width: 140px;" class="text-center">Company</th>
											<th style="width: 140px;" class="text-center">Mobile</th>
											<th class="text-center">Start</th>
											<th class="text-center">End</th>
											<th class="text-center">Verified by</th>
											<th class="text-center" style="background-color: #355761;">Remarks</th>
										</tr>
										</thead>
										<tbody>
										<tr class="text-center">
											<td>opensupermall</td>
											<td>12332</td>
											<td></td>
											<td></td>
											<td></td>
											<td>good</td>
										</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>

			<div id="delivery_mng_status_pickup" class="modal fade" role="dialog">
				<div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h3 class="modal-title">Status</h3>
						</div>

						<div class="row">
							<div style="padding: 25px;" class="modal-body-importedstatus" >
								<table class="table table-bordered table-responsive" id="vehical_delivery-table_pickup" style="width: 100%;">
									<thead class="aproducts">
									<tr style="background-color: #FD0002; color: #FFF;">
										<th style="width: 140px;" class="text-center">Company</th>
										<th style="width: 140px;" class="text-center">Mobile</th>
										<th class="text-center">Start</th>
										<th class="text-center">End</th>
										<th class="text-center">Verified by</th>
										<th class="text-center" style="background-color: #355761;">Remarks</th>
									</tr>
									</thead>
									<tbody>
									<tr class="text-center">
										<td>opensupermall</td>
										<td>12332</td>
										<td></td>
										<td></td>
										<td></td>
										<td>good</td>
									</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>

			<div id="delivery_mng_item_pickup" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Item</h3>
			</div>

			<div class="row">
				<div style="padding: 25px;" class="modal-body-importedstatus" >
					<table class="table table-bordered table-responsive" id="delivery_mng_item_table_pickup" style="width: 100%;">
						<thead class="aproducts">
						<tr style="background-color: black; color: #FFF;">
							<th style="width: 140px;" class="text-center">No</th>
							<th style="width: 140px;" class="text-center">Product ID</th>
							<th class="text-center">Product Name</th>
							<th class="text-center">Qty</th>
						</tr>
						</thead>
						<tbody>
						<tr class="text-center">
							<td>1</td>
							<td>12332asd</td>
							<td></td>
							<td></td>

						</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>



			<div id="delivery_mng_item" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Item</h3>
			</div>

			<div class="row">
				<div style="padding: 25px;" class="modal-body-importedstatus" >
					<table class="table table-bordered table-responsive" id="delivery_mng_item_table" style="width: 100%;">
						<thead class="aproducts">
						<tr style="background-color: black; color: #FFF;">
							<th style="width: 140px;" class="text-center">No</th>
							<th style="width: 140px;" class="text-center">Product ID</th>
							<th class="text-center">Product Name</th>
							<th class="text-center">Qty</th>
						</tr>
						</thead>
						<tbody>
						<tr class="text-center">
							<td>1</td>
							<td>12332asd</td>
							<td></td>
							<td></td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>



		<div id="discardDoPopUp" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div style="color:white" class="modal-header btn-danger">
						<button type="button" class="close"
							style="color:white;position:relative;top:10px"
							data-dismiss="modal">&times;</button>
						<h3 class="modal-title">Discard</h3>
					</div>
					<div class="modal-body" >
						<div class="row">
							<h2 style="text-align: center">Discard Delivery Order</h2>
						</div>
						<!-- <form action="{{--route('discard.do')--}}" method="POST"> -->
							{{--csrf_field()--}}
							<input type="hidden" value="{{$user_id}}" name="user_id">
							<input type="hidden" name="discard_do_id" value="">
							<input type="hidden" id="hiddenPorderId" name="porder_id" value="">
							<div class="row">
								<div class="col-md-4">
									<h3 style="text-align: left">DO ID:</h3>
								</div>
								<div class="col-md-8">
									<h3 id="discard_do_id_no" style="text-align: left;padding: 0;"></h3>
									<h6 id="porder_do_id" style="text-align: left;padding: 0; display:none;" ></h6>
								</div>
							</div>
							<br>
							<hr>
							<div class="row" style="vertical-align:middle">
								<div class="col-md-4" style="padding-left: 95px; padding-right: 0px;" >
									<label style="font-size: 18px;" class="radio-inline"><input type="radio" value="pickup" name="optradio" checked>Customer&nbsp;Pick&nbsp;Up</label>
								</div>

								<div class="col-md-4" style="padding-left: 63px;">
									<label style="font-size: 18px;" class="radio-inline"><input type="radio" value ="cancelled" name="optradio">Cancelled&nbsp;Order</label>
								</div>
								<div class="col-md-4" style="padding-left: 0px;">
									<label style="font-size: 18px;" class="radio-inline"><input value ="error"  type="radio" name="optradio"> Error&nbsp;Adjustment</label>
								</div>
								<hr>
								<br>
							</div>
							<div class="row">
								<div class="col-md-6">
									<button id="set_status_order" type="submit"  class="btn btn-success btn-lg btn-block">Confirm</button>
								</div>
								<div class="col-md-6">
									<button type="button" class="btn btn-danger btn-lg btn-block" data-dismiss="modal">Cancel</button>
								</div>
							</div>
						<!-- </form> -->
					</div>
				</div>
			</div>
		</div>


		<div id="importedstatus" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Tracking Report</h4>
					</div>
					<div style="padding: 15px;" class="modal-body-importedstatus" >
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>




		<div id="issueDoPopUp" class="modal fade" role="dialog">
			<div class="modal-dialog" style="width: 70%">
				<form action="{{route('issue.do')}}" method="POST">
							{{csrf_field()}}
							<input type="hidden" name="issue_do_id" value="">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header bg-deliveryorder">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h3 class="modal-title">Action</h3>
							</div>
							<div class="modal-body" >
								<div class="row">
									<h2 style="text-align: center">
									Issue Delivery Order/Invoice</h2>
								</div>
								<div id="price_list" style="align-self:flex-end">
								</div>
							<!--End of price List -->
							<div class="row">
								<h3 style="padding-left:15px">Select Deliveryman:</h3>
							</div>

							<?php $index = 1;?>
							@foreach($delivery_men as $delivery_man)
							<div class="row">
								<div class="col-md-2" style="text-align: right; padding: 0;">
									<input type="radio" name="member_id" value="{{$delivery_man->id}}" @if($index == 1) required  <?php $index++?> @endif id="dmanid_{{$delivery_man->id}}">
								</div>
								<div class="col-md-10" style="text-align: left">
									<label for="">
										@if($delivery_man->first_name != null && $delivery_man->last_name != null)
										{{$delivery_man->first_name}} {{$delivery_man->last_name}}

										@elseif($delivery_man->username != null)
										{{$delivery_man->username}}
										@else
										{{$delivery_man->email}}
										@endif


									</label>
								</div>
							</div>

							@endforeach
							<br>
							<div class="row" style="padding-bottom: 10px;">
								<div class="col-md-6">
									<button id="yes_btn_href" href="#" class="btn btn-success btn-lg btn-block" style="float: right; width: 50%;">Confirm</button>
								</div>
								<div class="col-md-6">
									<button type="button" class="btn btn-danger btn-lg btn-block" data-dismiss="modal" style="float: left;width: 50%;">Cancel</button>
								</div>
							</div>

						</form>

					</div>
					<div class="modal-footer">
					<!--
						<div class="col-md-12" id="ImeiWarranty">
						</div>
						 <ul class="diff_msg">
						</ul>
						-->
						<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
					</div>
				</div>

			</div>
		</div>


		<div id="trDoPopUp" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Tracking Report</h4>
					</div>
					<div class="modal-body" >
						<div class="row">
							<h2 style="text-align: center">Attach With Tracking Report</h2>
						</div>
						<form action="{{route('tr.do')}}" method="POST">
							{{csrf_field()}}
							<input type="hidden" name="tr_do_id" value="">
							<input type="hidden" name="initial_location_id" value="">
							<div class="row">
								<div class="col-md-5">
									<h3 style="text-align: left">DO ID:</h3>
								</div>
								<div class="col-md-y">
									<h3 id="tr_do_id_no" style="text-align: left;padding: 0;"></h3>
								</div>
							</div>
							<div class="row">
								<div class="col-md-5">
									<h3 style="text-align: left">Initial Location:</h3>
								</div>
								<div style="padding-left: 0px;" class="col-md-7">
									<h3 id="initial_location" style="text-align: left;padding: 0;"></h3>
								</div>
							</div>
							<div class="row">
								<div class="col-md-5">
									<h3 style="text-align: left">Final Location:</h3>
								</div>
								<div style="padding-left: 0px;" class="col-md-7">
									<h3 id="final_location" style="text-align: left;padding: 0;"></h3>
								</div>
							</div>
							<div style="padding-left: 15px;    width: 48%;float: left;" class="row">
								<h3>Select Deliveryman:</h3>
							</div>
							<div style="width: 50%;float: left;padding-top: 25px;margin-bottom: 25px;">
								<?php $index = 1;?>
								@foreach($delivery_men as $delivery_man)
								<div class="row">
									<div class="col-md-1" style="text-align: right; padding: 0;float: left;">
										<input type="radio" name="member_id" value="{{$delivery_man->id}}" @if($index == 1) required  <?php $index++?> @endif>
									</div>
									<div class="col-md-10" style="text-align: left">
										<label for="">
											@if($delivery_man->first_name != null && $delivery_man->last_name != null)
											{{$delivery_man->first_name}} {{$delivery_man->last_name}}

											@elseif($delivery_man->username != null)
											{{$delivery_man->username}}
											@else
											{{$delivery_man->email}}
											@endif
										</label>
									</div>
								</div>
								@endforeach
							</div>
							<br>
							<div class="row">
								<div class="col-md-6">
									<button id="yes_btn_href" href="#" class="btn btn-success btn-lg btn-block">Confirm</button>
								</div>
								<div class="col-md-6">
									<button type="button" class="btn btn-danger btn-lg btn-block" data-dismiss="modal">Cancel</button>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>

			</div>
		</div>


		<div id="importModal" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content" style="height: 350px !important;">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Delivery Order Import</h4>
					</div>
					<div class="modal-body text-center" >

						<form id="upload-form" action="{{route('import.do')}}" method="POST" enctype="multipart/form-data">
							<input type="hidden" value="{{$user_id}}" name="user_id">
							{{csrf_field()}}
							<input type="file" name="file" class="input-sty" multiple required>
							<p class="p-sty">click here to select a file.</p>
							<br>
							<button type="submit" class="button-sty">Upload</button>
						</form>
					</div>
					<div class="modal-footer" style="padding: 20px !important; border-top: none !important;">

					</div>
				</div>

			</div>
		</div>

		<div id="exportModal" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Delivery Order Export</h4>
					</div>
					<div class="modal-body" >
						<div class="row">
							<h2 style="text-align: center">Export Delivery Orders</h2>
						</div>
						<form id="export_form" action="{{route('export.do')}}" method="POST">
							{{csrf_field()}}
							<input type="hidden" value="{{$user_id}}" name="user_id">
							<div class="row">
								<div class="col-md-6">
									<label for="">From</label>
									<input id="from_date" type="date" class="form-control" name="from" required>
								</div>
								<div class="col-md-6">
									<label for="">To</label>
									<input id="to_date" type="date" class="form-control" name="to" required>
								</div>
							</div>
							<br><br>
							<div class="row">
								<div class="col-md-6">
									<button type="button" onclick="exportForm()" class="btn btn-success btn-lg btn-block">Confirm</button>
								</div>
								<div class="col-md-6">
									<button type="button" class="btn btn-danger btn-lg btn-block" data-dismiss="modal">Cancel</button>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>

			</div>
		</div>
		<!-- START -->
  	<div class="modal fade" id="directMerchantInvoice" role="dialog">
    <div style="width: 80%;"  class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">


        <div class="modal-header">
          <button type="button"
		  	style="position:relative;top:-6px"
		  	class="close" data-dismiss="modal">&times;</button>
          <!-- <h3>Direct Merchant Invoice</h3> -->
        </div>
        <div class="modal-body">
          <div id="directMerchantInvoiceHtml"> </div>

        </div>
        <div class="modal-footer" style="text-align: left;">
        	<div class="col-md-12" id="footerDetailsForInvoice" style="display:none;">
				 <table style="margin-top: 5px;">
                     <tr id="salesorderView" style="display: none;">
                        <td style="text-align: left"><strong>Sales Order No.</strong></td>
                        <td>: <span id="salesorderid"></span></td>
                    </tr>
                    <tr>
                        <td style="text-align: left"><strong>Delivery Order ID</strong></td>
                        <td>: <span id="InvoiceNoDI"></span></td>
                    </tr>
                    <tr>
                        <td style="text-align: left"><strong>DeliveryMan Name</strong></td>
                        <td>: <span id="dmanName"></span></td>
                    </tr>
                    <tr>
                        <td style="text-align: left"><strong>DeliveryMans ID </strong></td>
                        <td>: <span id="dmanID"></span></td>
                    </tr>
                    </table>
				<div  id="ImeiWarrant">
				</div>
				<ul id="Qtydifferent_message" style="margin-left: -10px;">
				</ul>
			</div>

      </div>

    </div>
  </div>
</div>
  <!-- END -->



<script>
$(document).ready(function(){
	$('link[rel=stylesheet][href~="{{asset('/css/select2.min.css')}}"]').remove();
	$('form .input-sty').change(function () {
		$('form .p-sty').text(this.files.length + " file(s) selected");
	});
});
$('#delivery-order-table').DataTable();
$('#plate-no-table').DataTable();
$('#delivery-activity-table').DataTable();
$('#delivery_mng_item_table').DataTable();
$('#delivery_mng_item_table_pickup').DataTable();
$('#pickup-managment').DataTable();
$('#vehical_delivery-table_pickup').DataTable();
$('#pickupcontrol_tbl').DataTable();



//$('#vehical_delivery-table').DataTable();

var t = $('#vehical_delivery-table').DataTable({
	"columnDefs": [ {
		"paging": true,
		"orderable": true,
		"targets": 0
	} ],
	"order": [[ 1, 'desc' ]]
});


function plateNo() {
	$('#plateNoPopUp').modal('show');
}


function vehical_delivery_man_list_Add(){
	var rowHtml = $("#newRow").find("tr")[0].outerHTML
	console.log(rowHtml);
	t.row.add($(rowHtml)).draw();
}

function getfooterdetails(id,type=null) {
	// alert('in');
	$('#Qtydifferent_message').html('');
	$('#salesorderid').html('');
	$("#salesorderView").attr("style", "display: none;");
	$.ajax({
		type: "GET",
		url: JS_BASE_URL+"/seller/Sofooterdetails/"+id,
		success: function( data ) {
			console.log('====SoFooter====');
			console.log(data);
			console.log('====SoFooter====');
			console.log(data.ProductData);
			

			if(data.deliveryId != ""){

				if(type="di")
				{
					$('#footerDetailsForInvoice').show();

					if(data.direct == 0){
						$('#salesorderView').removeAttr('style');
						$('#salesorderid').html(data.salesorder_no);
					}
		            $('#dmanName').html(data.dman_name);
		            $('#dmanID').html(data.dman_id);
		            var url = JS_BASE_URL+"/DO/displaydeliveryorderdocument/"+id;
		            $('#InvoiceNoDI').html('<a href="'+url+'" target="_blank">'+data.deliveryId+'</a>');
				}

				$('#footerDetails').show();
	            //$('#InvoiceNo').html(': '+data.doid);
	            $('#InvoiceNo').html(data.invoiceNo);

				if(data.ProductData != "" ){


					var HtmlTableImei = '';
					HtmlTableImei += '<table>';
							// console.log(data.ProductData[0].imeiNo);
							// console.log('======================');
							// console.log(data.ExistingDataInArray);
					// $.each(data.ProductData,function(key,value){
					console.log("Data existing in Array");
					console.log(data.ExistingDataInArray);
					$.each(data.ExistingDataInArray,function(key,datavalue){
						// var imeiNo = datavalue.imeiNo;
						// var warrantyNo = datavalue.warrantyNo;
						// console.log(datavalue.imeiNo);
						if(data.deliveryId == 'none'){
							data.deliveryId = '';
						}
						// console.log('========ProductData========');
						// if((data.ProductData[key].imeiNo != "" && data.ProductData[key].imeiNo != null )&&( data.ProductData[key].warrantyNo != "" && data.ProductData[key].warrantyNo != null)){
						var mainQty = datavalue.quantity;

						if(datavalue.approved_qty >= 0){

						$('#doid').html('<a href="#" onclick="deliveryorder('+id+')">'+data.deliveryId+'</a>');

							mainQty = datavalue.approved_qty;


						var ul_list = $('#Qtydifferent_message');

                       	var dif = datavalue.quantity - datavalue.approved_qty;

                       	var units = ' unit';
                       if((dif > 0) && (datavalue.approved_qty != null)){

							var msg = '<li class="text-left">' +datavalue.pname + ' has been approved with a difference of '+ dif + units+' less than original quantity.</li>';
							ul_list.append(msg);
                   			}
						}
							HtmlTableImei += 	'<tr>';

							for (var i = 0; i < datavalue.imeiDetail.length; i++) {

								if(datavalue.imeiDetail[i].imeiNo != '' || datavalue.imeiDetail[i].warrantyNo != ''){
									if(i==0){
									
										HtmlTableImei += 		'<td style="text-align: left">';
										//HtmlTableImei += 			'<strong >'+datavalue.pname+'</strong> ( '+mainQty+' )';
										HtmlTableImei += 			'<strong >'+datavalue.pname+'</strong>';
										HtmlTableImei += 		'</td>';
									}
								}
								
								HtmlTableImei += 		'<tr>';	
								if(datavalue.imeiDetail[i].imeiNo != ''){
									HtmlTableImei += 			'<td>';
									HtmlTableImei += 				'Serial/IMEI No. : <span>'+datavalue.imeiDetail[i].imeiNo+'</span>';
									HtmlTableImei += 			'</td>';
								}
								if(datavalue.imeiDetail[i].warrantyNo != ''){
									HtmlTableImei += 			'<td>';
									HtmlTableImei += 				'Warranty No. : <span>'+datavalue.imeiDetail[i].warrantyNo+'</span>';
									HtmlTableImei += 			'</td>';
								}
								HtmlTableImei += 		'</tr>';
								
							}
							HtmlTableImei += 	'</tr>';


					});
					var condition = '';
					$.each(data.ProductData,function(key,returns) {

						if(returns.status == 'approved'){
							HtmlTableImei += '<tr> ';
							if (returns.return_option == 'd') {
								condition = 'Exchange of Stocks';
							}else if(returns.return_option == 'dx') {
								condition = 'Exchange of Stocks (Damaged)';
							}
							else if(returns.return_option == 'rx'){
								condition = 'Return Only (Damaged)';
							}
							else if(returns.return_option == 'r'){
								condition = 'Return Only';
							}
							HtmlTableImei += '<td>';
							HtmlTableImei += returns.pname + ' has been returned with 1 quantity (' + condition + ')' ;
							HtmlTableImei += '</td>';

							HtmlTableImei += 		'</tr>';
						}
					console.log("El Fin");
					});
					HtmlTableImei += '</table>';


					$('#ImeiWarranty').html(HtmlTableImei);
					$('#ImeiWarrant').html(HtmlTableImei);
				}

				$('#dmanid_'+data.dman_id).prop("checked",true);
				}
					 	
			}
	});
}

function deliveryorder(id) {
	// console.log(id);
	// getfooterdetails(id);
	$.ajax({
		type: "GET",
		url: JS_BASE_URL+"/DO/displaydeliveryorderpopup/"+id,
		success: function( data ) {
			console.log("Opening Modal");
			$("#dodisp").html(data);
			$('#doModal').modal('show');
		}
	});
}

function displaySalesOrder(id) {
	$('*[id^="dmanid_"]').prop('checked', false);
	$.ajax({
		type: "GET",
		url: JS_BASE_URL+"/seller/gator/saleorder/"+id,
		success: function( data ) {
			console.log("Opening Modal");
			getfooterdetails(id,"so");
			$("#sodisp").html(data);
			$('#soModal').modal('show');
			if($('#logistic_check').html() == 1){
				console.log("hit");
			}
		}
	});
}
function displayDirectInvoice(id) {
	console.log(id);
	$.ajax({
		type: "GET",
		url: JS_BASE_URL+"/seller/directinvoice/"+id,
		success: function( data ) {
			console.log("Openings Modal");
			getfooterdetails(id,"di");
			$('#directMerchantInvoice').modal('show');
            $('#directMerchantInvoiceHtml').html(data);
		}
	});
}


function delivery_activity() {
	$('#delivery_activityPopUp').modal('show');
}

function vehical_delivery_man(){
	$('#vehical_delivery_manPopUp').modal('show');
}

function delivery_mng_item(){
	$('#delivery_mng_item').modal('show');
}

function delivery_mng_item_pickup(){
	$('#delivery_mng_item_pickup').modal('show');
}

$('#delivery-man-table').DataTable();
$('#delivery-managment').DataTable();

function delivery_mng_status_pickup(){
	$('#delivery_mng_status_pickup').modal('show');
}

function delivery_mng_status(){
	$('#delivery_mng_status_PopUp').modal('show');
}

function importedstatus(do_id) {
	$.ajax({
		url:JS_BASE_URL+"/importedstatus/"+do_id,
		type:'GET',
		success:function (r) {
			//console.log(r);
			$('.modal-body-importedstatus').html(r);
			$('#importedstatus').modal('show');
		}
	});
}
// function issueDoModal(do_id_no,do_id) {
// console.log(do_id);
// console.log('================');

// 	$('#issue_do_id_no').html(do_id_no);
// 	$('input[name=issue_do_id]').val(do_id);
// 	$('#issueDoPopUp').modal('show');
// }

function issueDoModal(do_id_no,do_id,p_id) { 
		$('*[id^="dmanid_"]').prop('checked', false);		
		console.log("Issue Modal Hit");
		console.log(p_id);
		$.ajax({
		type: "GET",
		url: JS_BASE_URL+"/seller/gator/price_list/"+p_id,
		success: function( data ) {
		  	console.log(data);
			  console.log("Opening Modal");
			console.log(p_id);
			  getfooterdetails(p_id);
			  $("#price_list").html(data);
			  $('#issue_do_id_no').html(do_id_no);
			  $('input[name=issue_do_id]').val(do_id);
			  console.log('=============');
			  console.log($('#selectedDmember').val());
			  $('#dmanid_'+$('#selectedDmember').val()).prop('checked', true);
			  $('#issueDoPopUp').modal('show');
		  }
	  });

  }
function trDoModal(do_id_no,do_id,inl_id,f_loc) {

	$('#tr_do_id_no').html(do_id_no);
	$('#initial_location').html($('#ini_loc'+inl_id+' :selected').text());
	$('#final_location').html(f_loc);
	$('input[name=initial_location_id]').val($('#ini_loc'+inl_id).val());

	$('input[name=tr_do_id]').val(do_id);
	$('#trDoPopUp').modal('show');
}

function discardDoModal(do_id_no,do_id,po_id) {

	$('#porder_do_id').html(po_id);
	$('#hiddenPorderId').val(po_id);
	$('#discard_do_id_no').html(do_id_no);
	$('input[name=discard_do_id]').val(do_id);
	$('#discardDoPopUp').modal('show');
}

function exportForm() {
	var from_date = document.getElementById('from_date').value;
	var to_date = document.getElementById('to_date').value;


	if (from_date == "" || to_date == "") {
		toastr.error("Please Select Both Date");
	} else if (new Date(from_date) > new Date(to_date)) {
		toastr.error("From Date must be earlier than To Date");
	} else{
		document.getElementById("export_form").submit();
	}
}

$(document).on('click','#set_status_order',function(e){
	e.preventDefault();
	var p_id = $('#porder_do_id').html();
	var status = $('input[name=optradio]:checked').val();
	$.ajax({
		type:"POST",
		url: JS_BASE_URL+"/seller/gator/set_status",
		data:{ "id" : p_id, "status" : status},
		success: function (data){
		    location.reload();
		}
	});
});
	
</script>

@stop



