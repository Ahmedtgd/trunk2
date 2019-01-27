<?php
use App\Http\Controllers\IdController;
$cf = new \App\lib\CommonFunction();
$active_currency = \App\Models\Currency::where('active', 1)->first()->code;
define('MAX_COLUMN_TEXT',50);
?>
@extends("common.default")
@if((\Illuminate\Support\Facades\Session::has('album')))
    <div class="alert alert-success">
        <strong>Success!</strong> Product Registered successfully.
    </div>
@endif
@if((\Illuminate\Support\Facades\Session::has('albumupdated')))
    <div class="alert alert-success">
        <strong>Success!</strong> Product Updated successfully.
    </div>
@endif
@section("content")
	{!! Html::style('css/editor.dataTables.min.css') !!}
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
	<style>
		.nav>li>span {
			position: relative;
			display: block;
			padding: 10px 15px;
		}	
		.btn-number{
			height: 30px;
		}
	</style>
    <style>
		.ret_price{
			cursor: text;
		}
		
		.disc_price{
			cursor: text;
		}
		
		.ret_qty{
			cursor: text;
		}
		.newspinner {
			position: static !important;
			left: -2.14285714em;
			width: 2.14285714em;
			top: .14285714em;
			text-align: center;
		}
	
		html {
			overflow: -moz-scrollbars-vertical;
		}
	
        .easy-autocomplete {
            width: 100% !important;
        }
        .easy-autocomplete-container {
            width: 250px !important;
        }

        li.selected {
            outline: 1px solid #27A98A;
        }
        select label {
            display: inline;
        }

		/* This is the magical stanza for the misaligned header
		 * problem which has been affecting datatables! */
        table.dataTable th, td {
            max-width: 180px !important;
            word-wrap: break-word
        }

        .details-control, .details-control-2 {
            cursor: pointer;
        }

        td.details-control:after, td.details-control-2:after {
            font-family: 'FontAwesome';
            content: "\f0da";
            color: #303030;
            font-size: 17px;
            float: right;
            padding-right: 25px;
        }

        tr.shown td.details-control:after, tr.shown td.details-control-2:after {
            content: "\f0d7";
        }

        .child_table {
            margin-left: 78px;
            width: 920px;;
        }

        .panel {
            border: 0;
        }

        table {
			table-layout: auto !important;
            counter-reset: Serial;
        }

        table.counter_table tr td:first-child:before {
            counter-increment: Serial; /* Increment the Serial counter */
            content: counter(Serial); /* Display the counter */
        }

        .badge-checkbox {
            -webkit-appearance: checkbox;
            -moz-appearance: checkbox;
            -ms-appearance: checkbox;
        }

        table.popup-table th{
            text-align: center;
            background: #337AB7;
            color : #fff;
        }

        table.popup-table tbody td {
            text-align: center;
        }

		.old-value:hover {
			text-decoration: underline;
		}

		.edit_pro:hover {
			text-decoration: underline;
		}

        .margin-top {
            margin-left: -15px;
            margin-right: -15px;
        }

        label.err {
            font-size: 12px;
            color : red;
            font-weight: normal;
        }

        input.errorBorder, span.errorBorder {
            border: 1px solid #F00;
        }

        .errorBorder {
            border: 1px solid #F00;
        }

        .errorDoubleBorder {
            border: 2px solid #F00;
        }

        .errorBorderIng {
            border: 1px solid #F00;
            border-radius: 5px 0px 0px 5px;
        }

        .die {
            pointer-events: none;
            cursor: default;
            opacity: 0.6;
        }

        .li_same_size {
            width: 37px;
            height: 37px;
        }

        form input.error, form select.error, form textarea.error {
            background-color: #FFFFC8 !important;
            border: 1px solid #F00 !important;
        }

        .mt {
            margin-top: 10px;
        }

        table#tab-product-detail {
            table-layout: fixed;
            max-width: none;
            width: auto;
            min-width: 100%;
        }

        /* Start by setting display:none to make this hidden.
       Then we position it in relation to the viewport window
       with position:fixed. Width, height, top and left speak
       speak for themselves. Background we set to 80% white with
       our animation centered, and no-repeating */
        .modal_loading {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(255, 255, 255, .8) url('http://sampsonresume.com/labs/pIkfp.gif') 50% 50% no-repeat;
        }

        /* When the body has the loading class, we turn
           the scrollbar off with overflow:hidden */
        body.loading {
            overflow: hidden;
        }

        /* Anytime the body has the loading class, our
           modal element will be visible */
        body.loading .modal_loading {
            display: block;
        }
        #imagePreviewDiscount {
           position: absolute;
            left: 0;
            height: 170px;
        }
        #imagePreviewVoucher {
           position: absolute;
            left: 0;
            height: 304px;
        }      
		#imagePreviewVoucherv1 {
           position: absolute;
            left: 0;
            height: 304px;
        }		
		#imagePreviewVoucherv2 {
           position: absolute;
            left: 0;
            height: 304px;
        }
		
		#imagePreviewVouchercoverv2 {
            left: 0;
            height: 200px;
        }
        .displaynone{
            display:none;
        }		
    </style>
    <section class="">
        {{--Model Start--}}
        <div class="modal fade" tabindex="-1" role="dialog" id="myModalB2B">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="modal-body">
						<table id="myTable" class="table table-bordered myTable">
							<tr>
								<td style="background-color: #7F7F7F; color: white; text-align: center;" >
									B2B
								</td>
								<td style="background-color: #7F7F7F; color: white; text-align: center;" >
									Special
								</td>
								<td style="background-color: #7F7F7F; color: white; text-align: center;">
									Qty
								</td>
							</tr>
							<tr>
								<td style="text-align: center;">
									<span id="b2bspan"  style="text-align: right;"></span>
								</td>
								<td style="text-align: center;">
									<span id="specialspan" style="text-align: right;"></span>
								</td>
								<td style="text-align: right;">
									<span id="qtyspan"  style="text-align: right;"></span>
								</td>
								<!--<td style="text-align: right;">
									<span id="totalspan" ></span>
								</td> -->
							</tr>
						</table>						
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        {{--Model End--}}	
        {{--Model Start--}}
        <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <p>...</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        {{--Model End--}}
        {{--Model Start--}}
        <div class="modal fade" tabindex="-1" role="dialog" id="myModalProduct">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Choose Subcategory:</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="subcategory" class="col-sm-3 control-label">Sub Category:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="subcategory">
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="goToLink">Go</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        {{--Model End--}}
		@if(Auth::user()->hasRole('mer') or Auth::user()->hasRole('adm'))
		@include("common.sellermenu")	
        @endif	
		<div id="updatedalert" class="alert alert-success alert-dismissible hidden alert-notification" role="alert">
		  <strong class='alert_info'>Products Updated Successfully</strong>
		</div>
        <input type="hidden" id="merchant_id" value="{{ $merchant_id }}">
        <input type="hidden" id="useridsell" value="{{ $selluser->id }}">
		<div class="container" id="album_wait"><!--Begin main container-->
			<h4 align="center">Please Wait...</h4>
		</div>
        <div class="container" style="display: none;" id="album_content">
		<!--Begin main container-->
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-12">
                        <h2>Album</h2> 
                    </div>
                    {{-- Tabbed Nav --}}
                    <div class="panel with-nav-tabs panel-default" id="TabId">
                        <div class="panel-heading">
                            <ul class="nav nav-tabs">
                                <li class="active" id="tb-add-product">
								<a href="#add-product" data-toggle="tab"
									style="margin-left: -15px; margin-right: 0px;">
									Add Product</a></li>
                                <li id="tb-product-detail"><a href="#product-detail"
									style="margin-left:0;margin-right:0;padding-left: 10px; padding-right: 10px;"
									data-toggle="tab">Product List</a></li>
                               <!-- <li id="tb-add-voucher"><a href="#add-voucher"
									style="margin-left: 0px; margin-right: 0px; padding-left: 10px; padding-right: 10px;"
									data-toggle="tab"><span style="margin-left: 0px; margin-right: 0px; padding: 10px; color: #CCC;">Add Voucher</span><!--</a></li>-->
                               <!--< <li id="tb-voucher-detail">a href="#voucher-detail"
									style="margin-left: 0px; margin-right: 0px; padding-left: 10px; padding-right: 10px;"
									data-toggle="tab"><span style="margin-left: 0px; margin-right: 0px; padding: 10px; color: #CCC;">Voucher List</span><!--</a></li> -->
								<li id="tb-add-discount"><a href="#add-discount"
										style="margin-left: 0px; margin-right: 0px; padding-left: 10px; padding-right: 10px;"
										data-toggle="tab">Add Discount</a></li>
                                <li id="tb-signboard"><a href="#album-signboard"
									style="margin-left: 0px; margin-right: 0px; padding-left: 10px; padding-right: 10px;"
									data-toggle="tab">Signboard</a></li>
                                {{--<li id="tb-bunting"><a href="#bunting"
									style="margin-left: 0px; margin-right: 0px;"
									data-toggle="tab">Bunting</a></li>--}}
                               {{-- <li id="tb-video-banner"><a href="#video-banner"
									style="margin-left: 0px; margin-right: 0px; padding-left: 10px; padding-right: 10px;"
									data-toggle="tab">Video Banner</a></li>--}}
                                {{--<li id="tb-advertise"><a href="#advertise"
									style="margin-left: 0px; margin-right: 0px; padding-left: 10px; padding-right: 10px;"
									data-toggle="tab">Advertisement</a></li>--}}
                               {{-- <li id="tb-about"><a href="#about"
									style="margin-left: 0px; margin-right: 0px; padding-left: 10px; padding-right: 10px;"
									data-toggle="tab">About</a></li>--}}
                               {{-- <li id="tb-certificate"><a href="#certificate"
									style="margin-left: 0px; margin-right: 0px; padding-left: 10px; padding-right: 10px;"
									data-toggle="tab">Certificate</a></li>--}}
                            </ul>
                        </div> {{--End Of Panel-heading Div--}}
                        {{--ENDS  --}}
                            <div id="dashboard" class="row panel-body"
								style="margin-left:0;padding-bottom:0;">
                                <div class="tab-content">

								{{-- Add Product Starts --}}
                                <div id="add-product" class="tab-pane fade in active">
									<div id="add_tabs" class="panel with-nav-tabs panel-default">
										<div class="panel-heading" style="font-size: 18px;">
											<ul class="nav nav-tabs">
												<li class="active" >
													<a  data-toggle="tab" class='tab-link'
														id='retail'
														style="color: #000; font-size:18px;margin-right:0"
														href="#content-retail">Retail
													</a>
												</li>
												<li>
													<a  
                                                     class='tab-link'
														id='B2B'
														style="color: #000; font-size:18px;margin-left: 0px; margin-right: 0px; padding-left: 20px; padding-right: 20px;"
														href="#content-b2b">B2B
													</a>
												</li>

												<li>
													<a  data-toggle="tab" class='tab-link'
														id='sp'
														style="color: #000; font-size:18px;margin-left: 0px; margin-right: 0px; padding-left: 20px; padding-right: 20px;"
														href="#content-sp">Special Price
													</a>
												</li>
												
												
												<li>
													<a  data-toggle="tab" class='tab-link'
														id='hyper'
														style="color: #000; font-size:18px;margin-left: 0px; margin-right: 0px;"
														href="#content-hyper">Hyper
													</a>
												</li>
											
												{{--
												<li>
													<a  data-toggle="tab" class='tab-link'
														id='export'
														style="color: #000; font-size:18px;margin-left: 0px; margin-right: 0px;"
														href="#content-export">Export
													</a>
												</li>
												--}}
											</ul>
										</div>
									</div>
									<div class="tab-content">
										<div id="content-retail" class='tab-pane fade in active'>
											<div class="col-sm-12" style="margin-bottom:0;margin-top:0">
												@if($id==0)
                                                    @include('product._forms.productreg_retail')
												@else
													@include('product._forms.productreg_retailedit')
												@endif
											</div>
										</div>
										<div id="content-b2b" class='tab-pane fade'>
											<div class="col-sm-12" style="margin-bottom:0;margin-top:0">

												@if($id==0)
													@include('product._forms.productreg_b2b')
												@else
													@include('product._forms.productreg_b2bedit')
												@endif
											</div>
										</div>
										<div id="content-sp" class='tab-pane fade'>
											<div class="col-sm-12" style="margin-bottom:0;margin-top:0">
													@if($id==0)
														@include('product._forms.productreg_sp')
													@else
														@include('product._forms.productreg_spedit')
													@endif													
											</div>
										</div>
										<div id="content-hyper" class='tab-pane fade'>
											<div class="col-sm-12" style="margin-bottom:20px">
												@if($id==0)
														@include('product._forms.productreg_hyper')
													@else
														@include('product._forms.productreg_hyper')
													@endif	
											</div>
										</div>
										<div id="content-oem" class='tab-pane fade'>
											<div class="col-sm-12" style="margin-bottom:20px">
												<div class="row">
													<h2 style="margin-left:0">OEM</h2>
												</div>
											</div>
										</div>
										<div id="content-export" class='tab-pane fade'>
											<div class="col-sm-12" style="margin-bottom:20px">
												<div class="row">
													<h2 style="margin-left:0">Export</h2>
												</div>
											</div>
										</div>
										<div class="col-sm-12" style="padding-left:0">
												<div id="commentss">
												  <!-- Nav tabs -->
												  <ul class="nav nav-tabs" role="tablist" style="background: #e7e7e7;" >
													<li role="presentation" class="active"><a href="#comments" aria-controls="comments" role="tab" data-toggle="tab" style="color: #000; font-size:18px;margin-left:0;margin-right:0">Comments</a></li>
													{{--
													<li role="presentation"><a href="#sellerinfo" aria-controls="sellerinfo" role="tab" data-toggle="tab" style="color: #000; font-size:18px;margin-left:0;margin-right:0">Seller Info</a></li>
													--}}
													<li role="presentation"><a href="#sellerpolicy" aria-controls="sellerpolicy" role="tab" data-toggle="tab" style="color: #000; font-size:18px;margin-left:0;margin-right:0">Seller Policy</a></li>
													{{--<li role="presentation"><a href="#osmallpolicy" aria-controls="osmallpolicy" role="tab" data-toggle="tab" style="color: #000; font-size:18px;margin-left:0;margin-right:0">OpenSupermall Policy</a></li>--}}
												  </ul>

												  <!-- Tab panes -->
												  <div class="tab-content">
													<div role="tabpanel" class="tab-pane active"id="comments" >
														<div class="col-sm-12" style="margin-bottom:20px">
															<div class="row">
																<h2 style="margin-left:9px">Comments</h2>
																<div class="col-sm-12" id="show_comments" style="border: solid #ddd 1px; margin-top:15px; padding-top: 15px;">
																	<div class="col-sm-12">
																		<p>Comments go here...</p>
																	</div>										
																</div>
															</div>
														</div>
													</div>
													
													<div role="tabpanel" class="tab-pane" id="sellerinfo">
														<div class="col-sm-12" style="margin-bottom:20px">
															<div class="row">
																<h2 style="margin-left:9px">Seller Information</h2>
																<div class="col-sm-6 col-xs-12 table-responsive">
																	<table class="table pseller">
																		<tr><td>Seller Name</td><td>{{ $merchant->company_name }}</td></tr>
																				<tr><td>Ship form Address</td><td>
																					@if(isset($addressm) && !is_null($addressm))
																						{{ 
																							strip_tags($addressm->line_1.'<br>'.
																							$addressm->line_2.'<br>'.
																							$addressm->line_3.'<br>'.
																							$addressm->line_4.'<br>'.
																							$addressm->postcode .',<br>')
																						}}
																					@else 
																						-
																					@endif															
																					@if(isset($citym) && !is_null($citym))
																						{{strip_tags($citym->name)}}
																					@endif														
																			</td></tr>
																		<tr><td>Return / Exchange Address:</td><td>
																					@if(isset($oaddressm) && !is_null($oaddressm))
																						{{
																							strip_tags($oaddressm->line_1.'<br>'.
																							$oaddressm->line_2.'<br>'.
																							$oaddressm->line_3.'<br>'.
																							$oaddressm->line_4.'<br>'.
																							$oaddressm->postcode .',<br>')
																						}}
																					@else 
																						-
																					@endif
																					@if(isset($ocitym) && !is_null($ocitym))
																						{{strip_tags($ocitym->name)}}
																					@endif													
																				</td></tr>
																	</table>
																</div>							
															</div>
														</div>
													</div>
													<div role="tabpanel" class="tab-pane" id="sellerpolicy">
														<div class="col-sm-12" style="margin-bottom:20px">
															<div class="row">
																<h2 style="margin-left:9px">Seller Policy</h2>
																<div class="col-xs-12">
																	{!! Form::textarea('merchant_policy', $merchant->return_policy, array('class' => 'form-control','id'=>'info-merchantpolicy'))!!}
																</div>
															</div>
														</div>
													</div>
													<div role="tabpanel" class="tab-pane" id="osmallpolicy">
														<div class="col-sm-12" style="margin-bottom:20px">
															<div class="row">
																<h2 style="margin-left:9px">OpenSupermall Policy</h2>
																	<div class="thumbnail">
																		<div class="row">
																			<div class="col-sm-12">
																				<h3 class="page-header" style="margin-top:20px">Cancellation</h3>
																				<ol>
																					<li>Request for cancellation can be made after payment for the product is completed.</li>
																					<li>Request for cancellation will only be approved if the product has not been shipped by the Merchant and the Buyer shall be entitled to refund</li>
																					<li>Request for cancellation will be rejected in the event that the Merchant has shipped the product.</li>
																				</ol>

																			</div>
																			<div class="col-sm-12">
																				<h3 class="page-header" style="margin-top:20px">Return &amp; Exchange</h3>
																				<ol>
																					<li>Request for return of the product purchased can be upon the product is delivered.</li>
																					<li>In the event that the product delivered is flawed, the Buyer shall return the product to the Merchant at the Buyer's own cost.</li>
																					<li>Upon receiving the Merchant's confirmation on the approvalfor the request for return, payment shall than be refunded to the Buyer.</li>
																					<li>In the event that wrong product is delivered, the Buyer may return the wrong product to Merchant at the Buyer's own cost and upon receiving the Merchant's confirmation and approval for the request, a new product shall be re-dilivered to the Buyer.</li>
																				</ol>

																			</div>
																			<div class="col-sm-12">
																				<h3 class="page-header" style="margin-top:20px">Terms &amp; Conditions</h3>

																				<ol>
																					<li>Request for return and/or refund shall be made within 7 days from the date of the delivery of the product</li>
																					<li>The Buyer shall not be entitled to refund and/or exchange if:
																						<ol type="a">
																							<li>The product requested for refund and/or exchange is used, destroyed and/or damaged.</li>
																							<li>The tag attached to the product is removed and/or tempered with.</li>
																							<li>The seal and/or package of the product is removed and/or opened.</li>
																							<li>The material(s) of the package product is lost.</li>
																							<li>The components of the product including product's accessory and/or free gifts which comes with the products have been  used, destroyed, damaged and/or lost.</li>
																							<li>The product value is decreased and/or damaged due to, including but not limited to, any reason stated in (a) to (c) stated above and/or due to the delay by the Buyer in returning the product.</li>
																							<li>The product is custom made and/or is customized product.</li>
																							<li>The proof of purchase of product is not provided by the Buyer.</li>
																							<li>The Buyer failed to follow guidelines, manuals, instructions and/or recommendations provided by the products and/or the Vendor Merchant. </li>
																							<li>The product is of e-voucher type of product which is sent to the Buyers email directly and immidiately. It is the buyer own responsibility to ensure the email address inserted and key is correct and accurate. OR</li>
																							<li>The product is of credit top-up type of product including but not limited to prepaid mobile air time, prepaid internet services, prepaid online content which is sent to Buyer's account direclty and immidiately. It is Buyer's own responsibility to ensure the account number(such as mobile telephone number, prepaid internet account number) inserted the key in is correct and accurate.</li>
																						</ol>
																					</li>
																					<li>All shipping cost and expenses paid are non-refundable and the Buyer shall bear for all the cost for the return and/or exchange of the product.</li>
																					<li>In the event of any refund and/or return is approved it is subject to deduction of shipping costs, taxes and/or any changes impossed by the online payment gateway and/or financial instructions.</li>
																				</ol>
														
																			</div>

																		</div>
																	</div>							
															</div>
														</div>
													</div>
													</div>
												  </div>
											</div>										
									</div>
								</div>
								{{-- Add Product Ends --}}

								{{-- Product List Start--}}
								<div class="tab-pane fade" id="product-detail">
									<h2 style="margin-top:20px;margin-bottom:-12px">Product List</h2>
									<div class="col-md-12" style="padding-right:0">
									<button class="btn btn-info pull-right sellerbutton"
										style="margin-top:-40px;margin-bottom:10px;margin-right:0;padding-top: 7px;background:#275c85;border-color:transparent;height:70px;width:70px;border-radius:5px"
										type="button" id="update" title="All modifications of product will only be updated and be visible to public only upon pressing this button, AND also ticking a checkbox in the  'O' (O-Shop) column.">Update<br> Public
										</button>
										<button class="btn btn-info pull-right sellerbutton" data-toggle="modal" data-target="#ImportModal"
												style="height:70px;width:70px;border-radius:5px;margin-top:-40px;margin-bottom:10px;margin-right:5px;padding-top: 7px;background:#d53f45 ;border-color:transparent;"
												type="button"  title="">Data<br>Import
										</button>
										<button class="btn btn-info pull-right sellerbutton" data-toggle="modal" data-target="#ExportModal"
											style="margin-top:-40px;margin-bottom:10px;margin-right:5px;padding-top: 7px;background:#186000;border-color:transparent;height:70px;width:70px;border-radius:5px   "
											type="button"  title="">Data<br>Export
										</button>
										
									</div>
									
									<p align="center" style="display: none;" id="myspinner">
										<i class="fa-li fa fa-spinner fa-spin fa-2x fa-fw"
										style="margin-left:50px;position: static">
										</i>
									</p>
									<div id="thetable">
										<table id="tab-product-detail" class="table-bordered"
											cellpadding="0" cellspacing="0" border="0">
											<thead>
												<tr class="bg-black" id="table_row">
													<th class="text-center no-sort" style="background-color: black;">No</th>
													<th class="text-center no-sort" style="background-color: black;">O-Shop</th>
													<th class="text-center no-sort" style="background-color:#558ED5;">SMM</th>
													<th class="text-center xxlarge" style="background-color: black;">Name</th>
													<th class="text-center" style="background-color: #4A452A;">Product&nbsp;ID</th>
													<th class="text-center blarge" style="background-color: #4A452A;">Retail</th>
													<th class="text-center blarge" style="background-color: #4A452A;">Selling</th>
													<th class="text-center" style="background-color: #4A452A;">Qty</th>
													<th class="text-center" style="background-color: #7F7F7F;">B2B</th>
													<th class="text-center" style="background-color: #7F7F7F;">Special</th>
													<th class="text-center" style="background-color: #7F7F7F;">Qty</th>
													<th class="text-center" style="background-color: #bf0159;">Cashback</th>
											<!--		<th class="text-center">Category</th>
													<th class="text-center">SubCategory</th>
													<th class="text-center">Brand</th>
													<th class="text-center">Hyper&nbsp;Price</th>
													<th class="text-center">Delete</th> -->
												</tr>
											</thead>
											<tbody id="tab-product-detail-tbody">

											</tbody>
										</table>
									</div>
									<br>
									<input type="hidden" value="{{$global_system_vars->smm_quota_max}}" id="smm_quota_max" />
								</div>
								{{-- Product Details End --}}

								{{-- Add Voucher Starts --}}
								<div class="tab-pane fade" id="add-voucher">
                                    {{-- @include('voucher.add_voucher') --}}
								</div>
								{{-- Add Voucher End --}}

								{{-- Voucher List Start --}}
								<div class="tab-pane fade" id="voucher-detail">
									<h2>Voucher List</h2>
									{{-- @include('voucher.voucher_details') --}}
								</div>
								{{-- Voucher Details End --}}
									<div class="tab-pane fade" id="add-discount">
										<h2>Add Discount</h2>
										@include('merchant.dashboard.create_discount_form')
									</div>
								{{-- Signboard Start --}}
								<div id="album-signboard" class="tab-pane fade">
									<div class="alert alert-success" role="alert" id="sign_success" style="display:none;">Signboard successfully updated!</div>
									<div class="alert alert-success" role="alert" id="sign_del_success" style="display:none;">Signboard successfully deleted!</div>
									<div class="col-sm-12" style="padding-left:0;padding-right:0">
										<h2 style="padding-left:0;margin-left:-15px">Signboard
										<small>
										<span id="signboar-counter"
											data-row-count="{{count($signboards)}}">
											{{count($signboards)}}
										</span> results
										</small>
										{{--@if($param !== 'profilesetting')--}}
										<a class="text-green pull-right" id="upldsb"><i
													class="fa fa-lg fa-plus-circle"></i></a>
										{{--@endif--}}
										</h2>
										<?php $index = 1; ?>
										@if(count($signboards)>0)
											<div id="append-sb-img" class="col-sm-offset-0">
												@foreach($signboards as $signboard)
												<?php 
													$schecked = "";
												//	echo $signboard->active;
													if($signboard->active==1){
														$schecked = "checked";
													} 
												?>												
												<div class="main-parentn">
												<div style="width: 10% !important; float: left; vertical-align: middle;" class="select-all">
													<b>Select O-Shop</b>
												</div>
												<div style="width: 40% !important; float: left;" class="select-all">
													
													<select name="oshop_idd" class="badge-select" id="select_o" data-id="{{$signboard->id}}">
														<option value=""  disabled="" selected="">Choose Option</option>
														@foreach($oshops as $Oshop)
															<?php
																$sselected = "";
																if($signboard->oshop_id==$Oshop->id){
																	$sselected = "selected";
																} 
																if($Oshop->single == false){
															?>
																<option value="{{ $Oshop->id }}"
																	{{$sselected}}>
																	{{ $Oshop->oshop_name }}
																</option>
															<?php } ?>
														@endforeach
													</select>

												</div>	
												<div style="width: 37% !important; float: left;" class="select-all">
													<b class="pull-right">Enable</b>
												</div>
												<input type="checkbox"
													style="float: right; margin-right: 10%;"
													class="badge-checkbox"
													{{$schecked}}
													data-id="{{$signboard->id}}"
													data-oshopid="{{$signboard->oshop_id}}"
													value="{{$signboard->id}}"/>													
													<div class="col-sm-11 upld-signboard main-parent"
														title="JPG and PNG format are supported for this image">
														{{--@if($updateSignboard == 'null' && $param =='profilesetting')--}}

														<p align="right"
															style=" float:right; display: none;"
															class="sign-spinner"
															data-id="{{$signboard->id}}">
															<i class="fa-li fa fa-spinner fa-spin
															fa-2x fa-fw pull-right newspinner"
															style="float:right;">
															</i>
														</p>														
														{{--@endif--}}
														{{--@if($param !== 'profilesetting')--}}
														<a class="badge badge-close remupldsignboard"
														   data-id="{{$signboard->id}}">X</a>
														{{--@endif--}}
														<img alt=""
															 src="{{asset('images/signboard/'.$signboard->id.'/'.$signboard->image)}}"
															 id="preview-img-sb{{$index}}"
															 style="object-fit:none"
															 class="img-responsive current-signboard">
														{{--@if($param !== 'profilesetting')--}}
														<div class="inputBtnSection">
															<label class="fileUpload">
																<input type="file"
																	   class="upload signboardupload"
																	   id="signboarduploadBtn"
																	   data-imgid="{{$index}}" name="file"
																	   data-rowid="{{$signboard->id}}">
															<span class="uploadBtn badge pull-right"
															style='padding-right:0;padding-left:0;width:24px'>
															<i class="fa fa-lg fa-upload"></i>
															</span>
															</label>
														</div>
														{{--@endif--}}
													</div>
													</div>
													<?php $index = $index + 1; ?>
												@endforeach
											</div>
											<div class="clearfix"></div>
										@else
											<div id="append-sb-img" class="col-sm-offset-0">
											<div class="main-parentn">
											<div style="width: 10% !important; float: left; vertical-align: middle; display:block;" class="select-all">
												<b>Select O-Shop:</b>
											</div>
											<div style="width: 40% !important; float: left; display:block;" class="select-all">
												<select name="oshop_idd" class="badge-select" id="select_o" data-id="0">
													<option value=""  disabled="" selected="">Choose Option</option>
												
													@foreach($oshops as $Oshop)
														<option value="{{ $Oshop->id }}">{{ $Oshop->oshop_name }}</option>
													@endforeach
												
												</select>

											</div>	
											<div style="width: 37% !important; float: left;" class="select-all">	
												<b class="pull-right">Enable</b>
											</div>										
											<input type="checkbox"
												style="display:block; float: right; margin-top:2px; margin-right: 10%;"
												class="badge-checkbox"
												data-id="0"
												data-oshopid="0"
												value=""/>										
												<div class="col-sm-11 upld-signboard main-parent"
													title="JPG and PNGs are particular format that are supported for this image">
													<p align="right" style=" float:right; display: none;"
															class="sign-spinner" data-id="0">
															<i class="fa-li fa fa-spinner fa-spin fa-2x fa-fw pull-right newspinner"
															style="float:right;">
															</i>
													</p>
													<a class="badge badge-close remupldsignboard" data-id="">X</a>
													<img alt="" src="" id="preview-img-sb{{$index}}"
														style="object-fit:contain"
														class="img-responsive current-signboard">
													<center>
													<input class="disableInputField text-center"
													style="margin-top:90px; color: black;"
													id="uploadFileSign"
													placeholder="2200 x 200"
													disabled="disabled"
													name="photo" type="text"/>
													</center>
													<div class="inputBtnSection">
														<label class="fileUpload">
															<input type="file" class="upload signboardupload"
															style="width:24px"
															id="signboarduploadBtn" data-imgid="1"
															name="file"
															data-rowid="">
															<span class="uploadBtn badge pull-right">
															<i class="fa fa-lg fa-upload">
															</i></span>
														</label>
													</div>
												</div>
												</div>
											</div>
											<div class="clearfix"></div>
										@endif
									</div>
									{{------Signboard Transfer Button-------}}
									{{--@if(!is_null($section_id) || $updateBunting == 'null'|| $updateSignboard == 'null'|| $updateVideoBanner == 'null')--}}
									{{--@endif--}}
									{{------End Of Transfer Button------}}
								</div>
								{{-- Signboard Ends --}}

								{{-- Bunting Starts --}}
								<div id="bunting" class="tab-pane fade">
									<h2>Bunting
										<small><span id="bunting-counter"
													 data-row-count="{{count($buntings)}}">{{count($buntings)}}</span>
											results
										</small>
										@if($param !== 'profilesetting')
											<a class="text-green pull-right" id="upldbb"> <i
														class="fa fa-lg fa-plus-circle"></i></a>
										@endif
									</h2>
									<?php $index = 1; ?>
									@if(count($buntings)>0)
										<div id="append-bb-img" class="col-sm-offset-0">
											@foreach($buntings as $bunting)
												<div class="col-sm-2 upld-bunting main-parent">
													{{--@if( $updateBunting == 'null' && $param == 'profilesetting')--}}
													<input type="radio"
														   class="badge-checkbox"
														   name="bunting" data-id="{{$bunting->id}}"
														   value="{{$bunting->id}}"/>
													{{--@endif--}}
													{{--@if($param !== 'profilesetting')--}}
													<a class="badge badge-close remupldbunting"
													   data-id="{{$bunting->id}}">X</a>
													{{--@endif--}}
													<img alt=""
														 src="{{asset('images/bunting/'.$bunting->id.'/'.$bunting->image)}}"
														 id="preview-img-bnt{{$index}}"
														 class="img-responsive current-bunting">
													<div class="inputBtnSection">
														<input disabled="disabled" class="disableInputField">
														<label class="fileUpload">
															<input type="file" class="upload" id="bntuploadBtn"
																   data-imgid="{{$index}}"
																   data-rowid="{{$bunting->id}}">
															{{--@if($param !== 'profilesetting')--}}
															<span class="uploadBtn badge"><i
																		class="fa fa-lg fa-upload"></i> </span>
															{{--@endif--}}
														</label>
													</div>
												</div>
												<?php $index = $index + 1; ?>
											@endforeach
										</div>
										<div class="clearfix"></div>
									@else
										<div id="append-bb-img" class="col-sm-offset-0">
											<div class="col-sm-2 upld-bunting main-parent">
												<a class="badge badge-close remupldbunting" data-id="">X</a>
												<img alt="" src="" id="preview-img-bnt{{$index}}"
													 class="img-responsive current-bunting">
												<div class="inputBtnSection">
													<input disabled="disabled" class="disableInputField">
													<label class="fileUpload">
														<input type="file" class="upload" id="bntuploadBtn"
															   data-imgid="{{$index}}" data-rowid="">
														<span class="uploadBtn badge"><i
																	class="fa fa-lg fa-upload"></i> </span>
													</label>
												</div>
											</div>
										</div>
										<div class="clearfix"></div>
									@endif
									{{------Bunting Transfer Button-------}}
									{{--@if(!is_null($section_id) || $updateBunting == 'null'|| $updateSignboard == 'null'|| $updateVideoBanner == 'null')--}}
									<div class="col-md-12">
										<button class="btn btn-info pull-right transfer-products"
												style="margin-bottom: 20px;"
												type="button" id="bn_transfer_products">Update
										</button>

									</div>
									{{--@endif--}}
									{{------End Of Transfer Button------}}
								</div>
								{{--Bunting Ends --}}


								{{-- Video Banner Starts --}}
								<div id="video-banner" class="tab-pane fade">
									<h2>Video/Banner
										<small><span id="video-counter"
													 data-row-count="1">{{count($vbanners)}}
											</span>
											results
										</small>
										{{--@if($param !== 'profilesetting')--}}
										<a class="text-green pull-right" id="upld-v-or-b"> <i
													class="fa fa-lg fa-plus-circle"></i></a>
										{{--@endif--}}
									</h2>
									<?php $index = 1; ?>
									@if(count($vbanners)>0)
										<div id="append-v-or-b" class="col-sm-offset-0">
											@foreach($vbanners as $vbanner)
												<div id="video"
													 class="col-xs-12 margin-top video-banner upld-bvideo">
													{{--@if($updateVideoBanner == 'null' && $param == 'profilesetting')--}}
													<input type="radio"
														   class="badge-checkbox"
														   name="video-banner" data-id="{{$vbanner->id}}"
														   value="{{$vbanner->id}}"/>
													{{--@endif--}}
													<div class="placeholder main-parent">
														{{--@if($param !== 'profilesetting')--}}
															<a class="badge badge-close rem-v-or-b"
															   data-id="{{$vbanner->id}}">X</a>
														{{--@endif--}}
														<div id="block{{$index}}">
															<?php $path = explode(':', $vbanner->image)[0];?>
															<span style="display: none"
																  class="videobanner{{$index}}">
																@if($path == 'http' || $path == 'https')
																	{{$vbanner->image}}
																@else
																	{{ asset('/images/vbanner/'.$vbanner->id.'/'.$vbanner->image)}}
																@endif
															</span>
														</div>
														{{--@if($param !== 'profilesetting')--}}
														<a class="badge badge-upload upload-vbanner"
														   data-rowid="{{$vbanner->id}}">
															<i class="fa fa-lg fa-upload"></i>
														</a>
														{{--@endif--}}
													</div>
												</div>
												<?php $index = $index + 1; ?>
											@endforeach
										</div>
									@else
										<div id="append-v-or-b" class="col-sm-offset-0">
											<div id="video" class="col-xs-12 margin-top video-banner upld-bvideo">
												<div class="placeholder main-parent">
													<a class="badge badge-close rem-v-or-b" data-id="">X</a>
													<div id="block{{$index}}">
														<span style="display: none" class="videobanner1"></span>
													</div>
													<a class="badge badge-upload upload-vbanner" data-rowid="">
														<i class="fa fa-lg fa-upload"></i>
													</a>
												</div>
											</div>
										</div>
									@endif
									{{------Video Transfer Button-------}}
									{{--@if(!is_null($section_id) || $updateBunting == 'null'|| $updateSignboard == 'null'|| $updateVideoBanner == 'null')--}}
									<div class="col-md-12">
										<button class="btn btn-info pull-right transfer-products"
												style="margin-bottom: 20px;"
												type="button" id="vb_transfer_products">Update
										</button>

									</div>
									{{--@endif--}}
									{{------End Of Transfer Button------}}
								</div>
								{{-- Video Banner Ends --}}

							</div>
						</div>
                    </div>{{--End Of Tabbed Panel Div--}}
                </div> {{--End Of Div col-sm-11--}}
            </div> {{--End of Div Row--}}
        </div><!--End main container-->
		<br>
    </section>

	<input type="hidden" id="productid" value="0" />
	<input type="hidden" id="productname" value="0" />
	<!-- Modal WHOLESALE -->
	<div class="modal fade" id="WholeSaleModal" role="dialog" aria-labelledby="WholeSaleModal">
		<div class="modal-dialog" role="document" style="width: 50%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">B2B Price/Unit</h4>
				</div>
				<div class="modal-body">
					<div id="title_winfo_modal"></div>
					<div id="title_winfo_modal2"></div>
					<div id="content_winfo_modal">
						<table id="wholetable" class="table table-bordered wholetable"></table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				</form>

			</div>
		</div>
	</div>

	<!-- Modal SPECIAL -->
	<div class="modal fade" id="SpecialModal" role="dialog" aria-labelledby="WholeSaleModal">
		<div class="modal-dialog" role="document" style="width: 50%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Special User/Price/Unit</h4>
				</div>
				<div class="modal-body">
					<div id="title_sinfo_modal"></div>
					<div id="content_winfo_modal">
						<table id="sepcialtable" class="table table-bordered sepcialtable"></table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				</form>

			</div>
		</div>
	</div>
<!-- Export Product list -->
<div class="modal fade" id="ExportModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Export Product list</h4>
      </div>
      <div class="modal-body" style="margin-top: 22px;margin-bottom: 67px;">
      <button class="btn btn-info sellerbutton"
												style="margin-top:-20px;margin-bottom:10px;margin-right:5px;padding-top: 7px;background:#186000;border-color:transparent;   "
												type="button" id="export_public" title="">Export
										</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<style>
    .drop_uploader.drop_zone {
    width: 100%;
    min-height: 100px;
    text-align: center;
    border: 3px dashed #1abc9c70;
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    border-radius: 8px;
    margin: 10px 0;
}
input[type=file] {
   display: unset;
   color:#337ab7;
}
.text{
    font-family: sans-serif;
    font-size: 13px;
}
</style>
<!-- Import Product list -->
<div class="modal fade" id="ImportModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" style="font-family: sans-serif;font-size: 24px;">Import Product list</h4>
      </div>
      <div class="modal-body">
    <form id="upload_form" enctype="multipart/form-data" method="post">
    <div id="drop_uploader_7" class="drop_uploader drop_zone">
    <div class="text_wrapper">
    <i class="pe-7s-cloud-upload"></i> 
    	<div> <span class="glyphicon glyphicon-save-file"></span></div>
   		 <span class="text">Drop files to upload, or <input style="margin-top: 11px;" class="" style="" type="file" name="file1" id="file1"></span>
    </div>
    </div>
      <div style="margin-top: 9px;"> 
      <button type="button" style="width: 100%;" id="importFile" class="btn btn-success">Upload File</button>
      </div>
     <br>
     <div style="  margin-top: 15px;"></div>
     <div id="process_div">
        <div style="  margin-top: 15px;">  <progress id="progressBar" value="0" max="0" style="width:300px;"></progress></div>
          <h3 id="status"></h3>
          <p id="loaded_n_total"></p>
          <div id="file_error_"></div>
          </div>
          <div id="file_process" style="max-height: 157px;overflow-y: scroll;">
     </div>
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="reset_progressBar" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
    user_id="{{$selluser->id}}"
    $(document).ready(function(){
        $("#file_process").hide();
        $("#process_div").hide();
        $("#reset_progressBar").click(function () {
        	$('#file_process').html('');
        	$('#upload_form').reset();
        });
    	function _(el) {
    		  return document.getElementById(el);
    		}
    	  $("#importFile").click(function () {
    		  var file = _("file1").files[0];
    		  var m_id = $('#merchant_id').val();
    		  // alert(file.name+" | "+file.size+" | "+file.type);
    		  var formdata = new FormData();
    		  formdata.append("file1", file);
    		  formdata.append("merchant_id", file);
    		  $('#file_process').html('');
    		  request = $.ajax({
    			  	url: JS_BASE_URL + '/product/import_file_post',
					type: 'POST',
					data: formdata,
					async: false,
					cache: false,
					contentType: false,
					processData: false,
					dataType: 'json',
					success: function (response) {
						console.log(response.flag);
						if(response.flag == 1){
							$('#file_error_').html('');
							$("#process_div").show();
					    	//console.log(prod_data.count[0].length);
					    	$("#progressBar").attr("data-max",response.count);
							import_data(response,0);
						}else{
							$('#file_error_').html('')
							$('#file_error_').append("<div style='color:red'>Invalid file. only .xls supported	 </div>")
						}
						//console.log(response);
					}
				});
		});
    });
</script>
	@if(Auth::user()->hasRole('adm'))
		<input type="hidden" value="1" id="albumadmin"/>
	@else
		<input type="hidden" value="0" id="albumadmin"/>
	@endif
@stop

@section('scripts')
    <script src="{{url('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('js/dataTables.editor.min.js')}}"></script>
    <script src="{{url('jqgrid/jquery.jqGrid.min.js')}}"></script>
    <script src="{{url('js/editablegrid/editablegrid-2.1.0.js')}}"></script>
    <script src="{{url('js/editablegrid/editablegrid-custom.js')}}"></script>
    <script src="{{url('js/editor-custom.js')}}"></script>
    <script type="text/javascript" src="{{ url('js/jquery.validate.min.js') }}"></script>

	{{--
    <script type="text/javascript">
        // var x = new EmbedJS({
        //     element: document.getElementById('block1'),
        //     googleAuthKey: 'AIzaSyCqFouT8h5DKAbxlrTZmjXEmNBjC69f0ts',
        //     videoDetails: false,
        // });
        // x.render();
        // var y = new EmbedJS({
        //     element: document.getElementById('block2'),
        //     googleAuthKey: 'AIzaSyCqFouT8h5DKAbxlrTZmjXEmNBjC69f0ts',
        //     videoDetails: false,
        // });
        // y.render();
	</script>
	--}}
	
    <script type="text/javascript">	
    function _(el) {
		  return document.getElementById(el);
		}

    function progressHandler(loaded,total) {
		  var percent = (loaded / total) * 100;
		  _("progressBar").value = Math.round(percent);
		  _("status").innerHTML = Math.round(percent) + "% uploaded";
		}

    function import_data(prod_data,jk){
    	$("#process_div").show;
    	//for(var jk = 0; jk < prod_data.count; jk++){
    		var product_data = prod_data.result[jk];
    		//console.log(product_data);
    		 request = $.ajax({
 			  	url: JS_BASE_URL + '/product/import_file_process',
					type: 'POST',
					data: {available:product_data.available,brand_id:product_data.brand_id,category_id:product_data.category_id,description:product_data.description,discounted_price:product_data.discounted_price,name:product_data.name,retail_price:product_data.retail_price},
					success: function (response) {
						var response = "Line "+ (jk+1) +' '+response;
						$("#progressBar").val();
						$("#file_process").show();
						$('#file_process').append(response)
						$('#file_process').append("<div style='clear:both'></div>")
						if(jk<(prod_data.count-1)){
							import_data(prod_data,jk+1);
						}
						else
						{
							$("#process_div").hide();
						}
						progressHandler((jk+1),prod_data.count);}
				});
    		 
		//}
    	
   	}
		function resetProductList(data){
			var html = "";
            user_id="{{$selluser->id}}"
			console.log("Reset");
			var products = data.data;
			var albumadmin = parseInt($("#albumadmin").val());
		//	console.log(products);
		//	product_table.destroy();
			var i = 1;
				html += '<table id="tab-product-detail" class="table-bordered" cellpadding="0" cellspacing="0" border="0">';
				html += '<thead>';
				html += '							<tr class="bg-black" id="table_row">';
				html += '								<th class="text-center no-sort" style="background-color: black;">No&nbsp;</th>';
				html += '								<th class="text-center no-sort" style="background-color:black;">Set</th>';
				html += '								<th class="text-center no-sort" style="background-color: black;">O-Shop</th>';					
				html += '								<th class="text-center xxlarge" style="background-color: black;">Name</th>';
				html += '								<th class="text-center" style="background-color: #4A452A; display: none;">Product&nbsp;ID</th>';
				html += '								<th class="text-center blarge" style="background-color: #4A452A;">Retail</th>';
				html += '								<th class="text-center blarge" style="background-color: #4A452A;">Selling</th>';
				html += '								<th class="text-center" style="background-color: #4A452A;">Qty&nbsp;</th>';
				html += '								<th class="text-center" style="background-color: #4A452A;">DP</th>';
				html += '								<th class="text-center" style="background-color: #7F7F7F;">B2B</th>';
				html += '								<th class="text-center" style="background-color: #7F7F7F; display:none;">B2B</th>';
				html += '								<th class="text-center" style="background-color: #7F7F7F; display:none;">Special</th>';
				html += '								<th class="text-center" style="background-color: #7F7F7F; display:none;">Qty</th>';
				html += '								<th class="text-center" style="background-color: #bf0159;">Cashback</th>';
				html += '								<th class="text-center" style="background-color: #7F7F7F; display:none;">FullName</th>';
				html += '							</tr>';
				html += '						</thead><tbody>';	
				//console.log(products);
			if (typeof products != 'undefined'){
			for(var jk = 0; jk < products.length; jk++){
				var product = products[jk];
				//console.log(product);
				if (typeof product != 'undefined'){
				//console.log(product);
				var pname = product.name;
				var pfullname = product.name;
				pfullname = pfullname.replace(/"/g, '&quot;');
				//console.log(pfullname);
				if(pname.length > 13){
					pname = pname.substr(0,10);
					pname += "...";
				}
				var checked_product = "";
				if(product.oshop_selected == 1){
					checked_product = "checked";
				}
				if(product.status == 'active' || product.status == 'pending'){
					var styele = '';
					if(product.status == 'pending'){
						var styele = 'style="background-color: rgba(240, 255, 0, 0.4);"';
					}
					html += '<tr class="'+product.id+'" '+styele+' data-subcategoryid="'+product.subcat_id+' ">';
					html += '<td class="text-center">'+ i +'</td>';
					var oshop = "Not Display";
					if(product.myoshop != "null" && product.myoshop != null){
						oshop = product.myoshop.oshop_name;
					}	
					html += '<td class="text-center"> <a target="_blank" href="' + JS_BASE_URL + '/album/detail/' + product.id +'" class="product_popup" rel="'+product.id+'">Set</a>'; 
					html += '</td>';					
					html += '<td class="text-center">'+ '<a href="javascript:void(0)" class="product_oshop" rel="'+product.id+'" id="a'+product.id+'">'+oshop+'</a>';
					html +=	'<select style="display:none;" class="oshop_select" rel="'+product.id+'" id="select'+product.id+'"><option value="0">Not Display</option>';
					var oshoid = 0;
					if(product.myoshop != "null" && product.myoshop != null){
						oshoid = product.myoshop.oshop_id;
					}
				//	console.log(oshoid);
					if(data.oshops != null){
						//console.log(data.oshops);
						for(var k = 0; k < data.oshops.length; k++){
							var oshop_s = "";
							if(oshoid == data.oshops[k].id){
								oshop_s = "selected";
							}
							html += '<option value="'+data.oshops[k].id+'" '+oshop_s+' >'+data.oshops[k].oshop_name+'</option>';
						}
					}
					html +=	'</select>';				
					html +='</td>';

					
					html +=  '<td data-action="update" class="xxlarge" data-rowid="'+product.id+'" data-columnname="name" data-tablename="Product" data-value="'+product.category_id+'"><img src="'+JS_BASE_URL+'/images/product/'+product.id+'/'+product.photo_1+'" width="30" height="30" style="padding-top:0;margin-top:4px">&nbsp;<span style="vertical-align: middle;" title="'+pfullname+'"><a target="_blank" href="'+ JS_BASE_URL + '/album/'+user_id+"/"+product.id +'" class="product_popup" rel="'+product.id+'">'+pname+'</a></span>';				
					html += '</td>';
					
					html += '<td class="text-center" style="display: none;"><a href="'+ JS_BASE_URL + '/album/'+ product.id +'" target="_blank" class="update" data-id="'+ product.id +'">'+product.formatted_product_id+'</a></td>';
					
					var background = "#FFF";
					if(product.status == 'pending'){
						var background = "rgba(240, 255, 0, 0.0);";
					}
					
					var color = "#000";
					var border = "#ddd";
					if(product.available <= 0){
						background = "#FF5151";
						color = "#FFF";
						if(product.oshop_selected == 1){
							border = "#C70D0D";
						}
					}
					if(product.private_retail_price != null){
						var retail_price = (parseFloat(product.private_retail_price)/100).toFixed(2);
						var retail_price_nc = (parseFloat(product.private_retail_price)/100).toFixed(2);
					} else {
						var retail_price = (parseFloat(0)/100).toFixed(2);
						var retail_price_nc = (parseFloat(0)/100).toFixed(2);
					}
					html += '<td data-action="update" class="text-right" data-rowid="'+product.id+'" data-columnname="retail_price" data-tablename="Product"><span class="ret_price" id="retspan'+product.id+'" rel="'+product.id+'">{{$currentCurrency}} '+retail_price +'</span><input style="display:none;" type="text" size="6" class="ret_price_input form-control" id="ret'+product.id+'" rel="'+product.id+'" value="'+retail_price_nc+'" /></td>';
					if(product.private_discounted_price != null){
						var discounted_price = (parseFloat(product.private_discounted_price)/100).toFixed(2);
						var discounted_price_nc = (parseFloat(product.private_discounted_price)/100).toFixed(2);
					} else {
						var discounted_price = (parseFloat(0)/100).toFixed(2);
						var discounted_price_nc = (parseFloat(0)/100).toFixed(2);
					}
					html += '<input type="hidden" value="{{$currentCurrency}}" id="currencyval" /><td data-action="update" class="text-right" data-rowid="'+product.id+'" data-columnname="original_price" data-tablename="Product"><span class="disc_price" id="discspan'+product.id+'" rel="'+product.id+'">{{$currentCurrency}} '+ discounted_price +'</span><input style="display:none;" type="text" size="6" class="disc_price_input form-control" id="disc'+product.id+'" rel="'+product.id+'" value="'+discounted_price_nc+'" /></td>';	
					
					html += '<td style="background: '+background+'; color: '+color+'; border-color: '+border+'" data-action="update" class="text-center" data-rowid="'+product.id+'" data-columnname="available" class="ret_qty" rel="'+product.id+'" data-tablename="Product" id="available_td"><span class="ret_qty" id="ret_qtyspan'+product.id+'" rel="'+product.id+'">'+product.private_available+'</span> <input style="display:none;" type="text" size="6" class="ret_qty_input form-control" id="ret_qty'+product.id+'" rel="'+product.id+'" value="'+product.private_available+'" /> </td>';
					html += '<td class="text-right">{{$currentCurrency}} '+ parseFloat(product.delivery_pricec/100).toFixed(2) +' </td>';
					if(product.b2b == null){
						html += '<td class="text-center"><a href="javascript:void(0)" data-toggle="modal" data-target="#myModalB2B" data-rowid="'+product.id+'" data-rowname="'+product.name+'"> Details </a></td>';
					} else {
						html += '<td class="text-center"><a href="javascript:void(0)"  id="b2bb'+product.id+'" data-toggle="modal" data-target="#myModalB2B" data-rowid="'+product.id+'" data-qty="'+product.b2b.private_available+'" data-b2b="'+product.b2b.id+'" data-rowname="'+product.name+'"> Details </a></td>';
						
					}
					html += '<td class="text-center"  style="display: none;"><a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" data-rowid="'+product.id+'" data-rowname="'+product.name+'" data-route="'+JS_BASE_URL +'/wholesale/'+product.id+'" data-detail-type="HSP"> Details </a></td>';
					html += '<td class="text-center"  style="display: none;"><a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" data-rowid="'+product.id+'" data-rowname="'+product.name+'" data-route="'+JS_BASE_URL +'/specialprice/'+product.id+'/'+$("#useridsell").val() + '" data-detail-type="SPP"> Special </a> </td>';
					
					if(product.b2b == null){
						html += '<td class="text-center"  style="display: none;"></td>';
					} else {
						html += '<td class="text-center"  style="display: none;"><span class="b2b_fqty" id="b2b_qtyfspan'+product.id+'" rel="'+product.id+'">'+product.b2b.private_available+'</span> <input style="display:none;" type="text" size="6" class="b2b_qty_input form-control" id="b2b_qty'+product.id+'" rel="'+product.id+'" relb2b="'+product.b2b.id+'" value="'+product.b2b.private_available+'" /></td>';
					}
					html += '<td class="text-center"> <input type="text" id="cashbackval'+product.id+'" class="cashbackval" value="'+product.private_cashback+'" data-proid="'+product.id+'" style="border-width:1;border-color:#e0e0e0;width:50px;">%<img src="'+JS_BASE_URL+'/images/loader.gif'+'" class="displaynone" width="30" height="30" style="padding-top:0;margin-top:4px">	 </td>';
					html +='<td style="display:none;">'+pfullname+'</td>';
				} else {
					var word = "suspended";
					var hcolor = "eee";
					if(product.status == 'transferred'){
						word = "transferred";
						hcolor = "FCA8FF";
					} 
					if(albumadmin == 1){
						html += '<tr class="'+product.id+'" style="background-color: #'+hcolor+'"; data-subcategoryid="'+product.subcat_id+' ">';
						html += '<td class="text-center" title="This product is '+word+'">'+ i +'</td>';
						html += '<td class="text-center" title="This product is '+word+'">'; 
						html += '';						
						var oshop = "Not Display";
						if(product.myoshop != "null" && product.myoshop != null){
							oshop = product.myoshop.oshop_name;
						}				
						html += '<td class="text-center" title="This product is '+word+'">'+ '<a href="javascript:void(0)" class="product_oshop" rel="'+product.id+'" id="a'+product.id+'">'+oshop+'</a>';
						html +=	'<select style="display:none;" class="oshop_select" rel="'+product.id+'" id="select'+product.id+'"><option value="0">Not Display</option>';
						var oshoid = 0;
						if(product.myoshop != "null" && product.myoshop != null){
							oshoid = product.myoshop.oshop_id;
						}
					//	console.log(oshoid);
						if(data.oshops != null){
							//console.log(data.oshops);
							for(var k = 0; k < data.oshops.length; k++){
								var oshop_s = "";
								if(oshoid == data.oshops[k].id){
									oshop_s = "selected";
								}
								html += '<option value="'+data.oshops[k].id+'" '+oshop_s+' >'+data.oshops[k].oshop_name+'</option>';
							}
						}
						html +=	'</select>';				
						html +='</td>';

						html +=  '<td data-action="update" title="This product is '+word+'" class="xxlarge" data-rowid="'+product.id+'" data-columnname="name" data-tablename="Product" data-value="'+product.category_id+'"><img src="'+JS_BASE_URL+'/images/product/'+product.id+'/'+product.photo_1+'" width="30" height="30" style="padding-top:0;margin-top:4px">&nbsp;<span style="vertical-align: middle;" title="'+pfullname+'"><a target="_blank" href="'+ JS_BASE_URL + '/album/'+ product.id +'" class="product_popup" rel="'+product.id+'">'+pname+'</a></span>';				
						html += '</td>';
						
						html += '<td class="text-center" style="display: none;" title="This product is '+word+'"><a href="'+ JS_BASE_URL + '/album/'+ product.id +'" target="_blank" class="update" data-id="'+ product.id +'">'+product.formatted_product_id+'</a></td>';
						
						var background = "#FFF";
						var color = "#000";
						var border = "#ddd";
						if(product.available <= 0){
							background = "#FF5151";
							color = "#FFF";
							if(product.oshop_selected == 1){
								border = "#C70D0D";
							}
						}
						if(product.private_retail_price != null){
							var retail_price = (parseFloat(product.private_retail_price)/100).toFixed(2);
							var retail_price_nc = (parseFloat(product.private_retail_price)/100).toFixed(2);
						} else {
							var retail_price = (parseFloat(0)/100).toFixed(2);
							var retail_price_nc = (parseFloat(0)/100).toFixed(2);
						}
						html += '<td data-action="update" title="This product is '+word+'" class="text-right" data-rowid="'+product.id+'" data-columnname="retail_price" data-tablename="Product"><span class="ret_price" id="retspan'+product.id+'" rel="'+product.id+'">{{$currentCurrency}} '+retail_price +'</span><input style="display:none;" type="text" size="6" class="ret_price_input form-control" id="ret'+product.id+'" rel="'+product.id+'" value="'+retail_price_nc+'" /></td>';
						if(product.private_discounted_price != null){
							var discounted_price = (parseFloat(product.private_discounted_price)/100).toFixed(2);
							var discounted_price_nc = (parseFloat(product.private_discounted_price)/100).toFixed(2);
						} else {
							var discounted_price = (parseFloat(0)/100).toFixed(2);
							var discounted_price_nc = (parseFloat(0)/100).toFixed(2);
						}
						html += '<input type="hidden" value="{{$currentCurrency}}" id="currencyval" /><td data-action="update" title="This product is '+word+'" class="text-right" data-rowid="'+product.id+'" data-columnname="original_price" data-tablename="Product"><span class="disc_price" id="discspan'+product.id+'" rel="'+product.id+'">{{$currentCurrency}} '+ discounted_price +'</span><input style="display:none;" type="text" size="6" class="disc_price_input form-control" id="disc'+product.id+'" rel="'+product.id+'" value="'+discounted_price_nc+'" /></td>';	

						html += '<td style="background: '+background+'; color: '+color+'; border-color: '+border+'" data-action="update" class="text-center" data-rowid="'+product.id+'" data-columnname="available" class="ret_qty" rel="'+product.id+'" data-tablename="Product" id="available_td"><span class="ret_qty" id="ret_qtyspan'+product.id+'" rel="'+product.id+'">'+product.private_available+'</span> <input style="display:none;" type="text" size="6" class="ret_qty_input form-control" id="ret_qty'+product.id+'" rel="'+product.id+'" value="'+product.private_available+'" /> </td>';
						html += '<td class="text-right">{{$currentCurrency}} '+ parseFloat(product.delivery_pricec/100).toFixed(2) +' </td>';
						if(product.b2b == null){
							html += '<td class="text-center"><a href="javascript:void(0)" data-toggle="modal" data-target="#myModalB2B" data-rowid="'+product.id+'" data-rowname="'+product.name+'"> Details </a></td>';
						} else {
							html += '<td class="text-center"><a href="javascript:void(0)"  id="b2bb'+product.id+'" data-toggle="modal" data-target="#myModalB2B" data-rowid="'+product.id+'" data-qty="'+product.b2b.private_available+'" data-b2b="'+product.b2b.id+'" data-rowname="'+product.name+'"> Details </a></td>';
							
						}
						html += '<td class="text-center"  style="display: none;"><a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" data-rowid="'+product.id+'" data-rowname="'+product.name+'" data-route="'+JS_BASE_URL +'/wholesale/'+product.id+'" data-detail-type="HSP"> Details </a></td>';
						html += '<td class="text-center"  style="display: none;"><a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" data-rowid="'+product.id+'" data-rowname="'+product.name+'" data-route="'+JS_BASE_URL +'/specialprice/'+product.id+'/'+$("#useridsell").val() + '" data-detail-type="SPP"> Special </a> </td>';
						
						if(product.b2b == null){
							html += '<td class="text-center"  style="display: none;"></td>';
						} else {
							html += '<td class="text-center"  style="display: none;"><span class="b2b_fqty" id="b2b_qtyfspan'+product.id+'" rel="'+product.id+'">'+product.b2b.private_available+'</span> <input style="display:none;" type="text" size="6" class="b2b_qty_input form-control" id="b2b_qty'+product.id+'" rel="'+product.id+'" relb2b="'+product.b2b.id+'" value="'+product.b2b.private_available+'" /></td>';
						}
						html += '<td class="text-center"> <input type="text" id="cashbackval'+product.id+'" class="cashbackval" value="'+product.private_cashback+'" data-proid="'+product.id+'" style="border-width:1;border-color:#e0e0e0;width:50px;">%<img src="'+JS_BASE_URL+'/images/loader.gif'+'" class="displaynone" width="30" height="30" style="padding-top:0;margin-top:4px">	 </td>';	
						html +='<td style="display:none;">'+pfullname+'</td>';
					} else {
						html += '<tr class="'+product.id+'" style="background-color: #'+hcolor+'; color: #666;"; data-subcategoryid="'+product.subcat_id+' ">';
						html += '<td class="text-center" title="This product is '+word+'">'+ i +'</td>';
						html += '<td class="text-center" title="This product is '+word+'">'; 
						html += '';						
						var oshop = "Not Display";
						if(product.myoshop != "null" && product.myoshop != null){
							oshop = product.myoshop.oshop_name;
						}				
						html += '<td class="text-center" title="This product is '+word+'">'+ '<span>'+oshop+'</span>';
						html +='</td>';

						html +=  '<td title="This product is '+word+'"><img src="'+JS_BASE_URL+'/images/product/'+product.id+'/'+product.photo_1+'" width="30" height="30" style="padding-top:0;margin-top:4px">&nbsp;<span style="vertical-align: middle;" title="'+product.name+'">'+pname+'</span>';				
						html += '</td>';
						
						html += '<td style="display: none;" title="This product is '+word+'" class="text-left"><span>'+product.formatted_product_id+'</span></td>';
						var background = "#eee";
						var color = "#000";
						var border = "#ddd";
						if(product.available <= 0){
							background = "#FF5151";
							color = "#fff";
							if(product.oshop_selected == 1){
								border = "#C70D0D";
							}
						}
						if(product.private_retail_price != null){
							var retail_price = (parseFloat(product.private_retail_price)/100).toFixed(2);
							var retail_price_nc = (parseFloat(product.private_retail_price)/100).toFixed(2);
						} else {
							var retail_price = (parseFloat(0)/100).toFixed(2);
							var retail_price_nc = (parseFloat(0)/100).toFixed(2);
						}
						html += '<td class="text-right" title="This product is suspended"><span>{{$currentCurrency}} '+retail_price +'</span></td>';
						if(product.private_discounted_price != null){
							var discounted_price = (parseFloat(product.private_discounted_price)/100).toFixed(2);
							var discounted_price_nc = (parseFloat(product.private_discounted_price)/100).toFixed(2);
						} else {
							var discounted_price = (parseFloat(0)/100).toFixed(2);
							var discounted_price_nc = (parseFloat(0)/100).toFixed(2);
						}
						html += '<input type="hidden" value="{{$currentCurrency}}" id="currencyval" /><td  title="This product is '+word+'" class="text-right"><span >{{$currentCurrency}} '+ discounted_price +'</span></td>';	
						
						html += '<td title="This product is '+word+'" style="background: '+background+'; border-color: '+border+'"  class="text-center"><span>'+product.private_available+'</span> </td>';
						html += '<td class="text-right">{{$currentCurrency}} '+ parseFloat(product.delivery_pricec/100).toFixed(2) +' </td>';
						html += '<td class="text-center" title="This product is '+word+'"> Details</td>';
					
						html += '<td class="text-center"  style="display: none;" title="This product is '+word+'"> Details </td>';
						html += '<td class="text-center"  style="display: none;" title="This product is '+word+'"> Special </td>';
					//	html += '<td class="text-center"  style="display: none;" title="This product is '+word+'"> </td>';
						if(product.b2b == null){
							html += '<td class="text-center"  style="display: none;" title="This product is '+word+'"></td>';
						} else {
							html += '<td class="text-center"  style="display: none;" title="This product is '+word+'"><span >'+product.b2b.private_available+'</span> </td>';
						}	
						html +='<td ></td>';
						html +='<td style="display:none;">'+pfullname+'</td>';
						
					}						
				}
				html += '</tr>';
				
				i++;
				}
			} 
		} else {
			html += '<tr><td colspan="11"><p align="center">An error occurred...</p></td></tr>';
		}
			html += '</tbody></table>';
			//for()
		/*	$html += '<tr class="'profile_product->id.''	*/
	//	console.log(html);
		$("#thetable").html(html);
		$("#tab-product-detail").DataTable({
				'order': [],
				"aoColumnDefs": [
					{"bSortable":false, "aTargets": [0,1,2]}
				],
				"columnDefs": [
					{ "targets": "no-sort", "orderable": false },
					{ "targets": "small", "width": "50px" },
					{ "targets": "medium", "width": "80px" },
					{ "targets": "large", "width": "120px" },
					{ "targets": "blarge", "width": "200px" },
					{ "targets": "xlarge", "width": "280px" },
					{ "targets": "xxlarge", "width": "400px" }
				]
			});	
			$("#myspinner").hide();	
			//$('.oshop_select').select2();
		//	$("#tab-product-detail").parents('div.dataTables_wrapper').first().show();	
			$(".ret_price_input").number(true, 2, '.', '');	
			$(".dic_price_input").number(true, 2, '.', '');		
		}	
    	$( document ).ready(function() {
    		
    		$(document).on('change', ".cashbackval",function (event) {
    			$(this).next(".displaynone").css("display","block");
    			var value = $(this).val();
    			var proid = $(this).attr('data-proid');
    			$.ajax({
    				type: "post",
    				url: JS_BASE_URL + '/product/cashback',
    				data: {id: proid,value:value},
    				cache: false,
    				success: function (responseData) {
    					console.log(responseData);
    					$(".displaynone").css("display","none");
    					if(responseData == 1){
    						$('#glyphiconcheck').show();
    					}
    					
    				},
    				
    			});
    		});	 
    	});
        $(document).ready(function () {
        
		$(".delivery_waiver_min_amt").number(true, 2, '.', '');	
		$(".delivery_waiver_min_amt_b2b").number(true, 2, '.', '');	
		
		$(document).delegate( '.ret_price', "click",function (event) {
			var objThis = $(this);
			objThis.hide();
			var id = objThis.attr('rel');
			$("#ret" + id).show();
		});
		
		$(document).delegate( '.ret_price_input', "blur",function (event) {
			var objThis = $(this);
			
			var id = objThis.attr('rel');
			var value = parseFloat(objThis.val());
			var discvalue = parseFloat($("#disc" + id).val());
			if(value < discvalue){
				$("#disc" + id).val(0);
			}
		/*	$("#ret" + id).hide();
			$("#retspan" + id).text("MYR " + value.toFixed(2));
			$("#retspan" + id).show();	*/		
			$.ajax({
					url: JS_BASE_URL + '/product_retailprice',
					cache: false,
					method: 'POST',
					data: {id: id, retail: value},
					success: function(result, textStatus, errorThrown) {
						//objThis.hide();
						$("#ret" + id).hide();
						$("#retspan" + id).text(result.result);
						$("#retspan" + id).show();
					}
			});
			//$("#ret" + id).show();
		});
		
		$(document).delegate( '.disc_price_input', "blur",function (event) {
			var objThis = $(this);
			
			var id = objThis.attr('rel');
			var value = parseFloat(objThis.val());
			var retvalue = parseFloat($("#ret" + id).val());
			if(value >= retvalue){
				toastr.error("Selling price cannot be grater than Retail price!");
			} else {
			/*		*/
				$.ajax({
						url: JS_BASE_URL + '/product_discountedprice',
						cache: false,
						method: 'POST',
						data: {id: id, discounted: value},
						success: function(result, textStatus, errorThrown) {
						//	objThis.hide();
							$("#disc" + id).hide();
							$("#discspan" + id).text(result.result);
							$("#discspan" + id).show();
						}
				});			
			}
		});			

		$(document).delegate( '.allsmm', "click",function (event) {
			if($(this).prop('checked')){
				$(".smm_action").prop('checked',true);			
			} else {
				$(".smm_action").prop('checked',false);
			}			
		});
		
		$(document).delegate( '.b2b_qty_input', "blur",function (event) {
			var objThis = $(this);
			
			var id = objThis.attr('rel');
			var b2bid = objThis.attr('relb2b');
			var value = parseFloat(objThis.val());
			var qty = parseFloat($("#b2b_qty" + id).val());
			console.log(qty)
			console.log(id)
			$("#b2bb" + id).attr('data-qty', qty);
			/*$("#b2b_qty" + id).hide();
			$("#b2b_qtyspan" + id).text(qty);
			$("#b2b_qtyspan" + id).show();	*/			
			$.ajax({
					url: JS_BASE_URL + '/product_qty',
					cache: false,
					method: 'POST',
					data: {id: b2bid, qty: qty},
					success: function(result, textStatus, errorThrown) {
					//	objThis.hide();
						$("#b2b_qty" + id).hide();
						$("#b2b_qtyspan" + id).text(result.result);
						$("#b2b_qtyspan" + id).show();
					}
			});			
		});
		
		$(document).delegate( '.b2b_qty', "click",function (event) {
			var objThis = $(this);
			objThis.hide();
			var id = objThis.attr('rel');
			$("#b2b_qty" + id).show();
		});		
		
		$(document).delegate( '.ret_qty_input', "blur",function (event) {
			var objThis = $(this);
			
			var id = objThis.attr('rel');
			var value = parseFloat(objThis.val());
			var qty = parseFloat($("#ret_qty" + id).val());
		/*	$("#ret_qty" + id).hide();
			$("#ret_qtyspan" + id).text(qty);
			$("#ret_qtyspan" + id).show();	*/	
			$.ajax({
					url: JS_BASE_URL + '/product_qty',
					cache: false,
					method: 'POST',
					data: {id: id, qty: qty},
					success: function(result, textStatus, errorThrown) {
					//	objThis.hide();
						$("#ret_qty" + id).hide();
						$("#ret_qtyspan" + id).text(result.result);
						$("#ret_qtyspan" + id).show();
					}
			});		
		});
		
		$(document).delegate( '.ret_qty', "click",function (event) {
			var objThis = $(this);
			objThis.hide();
			var id = objThis.attr('rel');
			$("#ret_qty" + id).show();
		});
		
		$(document).delegate( '.disc_price', "click",function (event) {
			var objThis = $(this);
			objThis.hide();
			var id = objThis.attr('rel');
			$("#disc" + id).show();
		});		
		
		$(document).delegate( '.product_oshop', "click",function (event) {
			var objThis = $(this);
			objThis.hide();
			var id = objThis.attr('rel');
			$("#select" + id).show();
		});

		$(document).delegate( '.oshop_select', "change",function (event) {
			var objThis = $(this);
			
			objThis.hide();
			var id = objThis.attr('rel');
			var text = $("#select"+id+" option:selected").text();
			var val = objThis.val();
			if(val == ""){
				$("#a" + id).show();
			} else {
				$("#a" + id).html(text);
				$("#a" + id).show();
				$.ajax({
					url: JS_BASE_URL + '/product_oshop',
					cache: false,
					method: 'POST',
					data: {id: id, oshop_id: val},
					success: function(result, textStatus, errorThrown) {
						
					}
				});
			}
			
		});
		
		$(document).delegate( '#tb-product-detail', "click",function (event) {
		//$('#tb-product-detail').on('click', function () {	
		//	product_table.destroy();
		//	$('#tab-product-detail-tbody').empty();	
		//	$("#tab-product-detail").parents('div.dataTables_wrapper').first().hide();	
			$("#tab-product-detail").remove();
			$("#myspinner").show();			
			$.ajax({
				url: '{{ route('getmerchantproducts') }}',
				cache: false,
				method: 'GET',
				data: {merchant_id: $('#merchant_id').val()},
				dataType: 'json',
				success: function(result, textStatus, errorThrown) {
					console.log("Hola");
					resetProductList(result);
				},
				error: function (responseData, textStatus, errorThrown) {
					resetProductList("");	
				}
			});	
			
		});			
			
            $('.transfer-products').on('click', function () {

                var video_banner_id = 0;
                var signboard_id = 0;
                var bunting_id = 0;
                var product_id = [];

                $('[name="video-banner"]').each(function () {
                    if ($(this).is(":checked")) {
                        video_banner_id = $(this).val();
                    }
                });

              /*  $('[name="sign-board"]').each(function () {
                    if ($(this).is(":checked")) {
                        signboard_id = $(this).val();
                    }
                });*/

                $('[name="bunting"]').each(function () {
                    if ($(this).is(":checked")) {
                        bunting_id = $(this).val();
                    }
                });

                $('.selected-product').each(function () {
                    if ($(this).is(":checked")) {
                        product_id.push($(this).attr("data-pro-id"));
                    }
                });

                //console.log(product_id.length);

                /*
                 * Prepare Data For posting
                 */
                if (bunting_id != 0 || video_banner_id != 0 || signboard_id != 0 || product_id.length > 0) {
				//	console.log(signboard_id);
                    $.ajax({
                        url: '{{url('/profile/badge-update')}}',
                        data: {
                            'bunting_id': bunting_id,
                            'video_id': video_banner_id,
                            'signboard_id': signboard_id,
                            'product_id': product_id
                        },
                        headers: {'X-XSRF-TOKEN': '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}'},
                        error: function (err) {
                            console.log(err.message)
                        },
                        success: function (response) {
                            if (response.status == 'true') {
                               $("#sign_success").show("slow");
								setTimeout(function(){ $("#sign_success").hide("slow"); }, 3000);
                            }
                        },
                        type: 'POST'
                    });
                }
                {{--@if (!is_null($section_id))--}}
                {{--var data = [];--}}
                {{--var pro = "";--}}
                {{--var cate = [];--}}
                {{--$('.product_section').each(function () {--}}
                {{--ckbox = $(this);--}}
                {{--if (ckbox.is(':checked')) {--}}
                {{--cat = ckbox.data('cat');--}}
                {{--pro = ckbox.data('p');--}}
                {{--newData = data[cat];--}}
                {{--if (newData == undefined) {--}}
                {{--data[cat] = [pro]--}}
                {{--} else {--}}
                {{--newData.push(pro);--}}
                {{--}--}}
                {{--}--}}
                {{--});--}}
                {{--$.ajax({--}}
                {{--url: '{{url('/profile/add-section-product')}}',--}}
                {{--data: {'data': data},--}}
                {{--headers: {'X-XSRF-TOKEN': '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}'},--}}
                {{--error: function () {--}}
                {{--console.log("error in transfering product");--}}
                {{--},--}}
                {{--success: function (response) {--}}

                {{--if (response.status == 'true') {--}}

                {{--window.location.href = JS_BASE_URL + '/profilesetting';--}}
                {{--}--}}
                {{--},--}}
                {{--type: 'POST'--}}
                {{--});--}}
                {{--@endif--}}
                {{--@if ($updateBunting == 'null')--}}
                {{--var bunting_id = 0;--}}
                {{--$('.badge-checkbox').each(function () {--}}
                {{--if ($(this).is(':checked')) {--}}
                {{--bunting_id = $(this).val();--}}
                {{--}--}}
                {{--});--}}
                {{--if (bunting_id != 0) {--}}
                {{--$.ajax({--}}
                {{--url: '{{url('/profile/badge-update')}}',--}}
                {{--data: {'id': bunting_id, 'badge': 'bunting'},--}}
                {{--headers: {'X-XSRF-TOKEN': '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}'},--}}
                {{--error: function () {--}}

                {{--},--}}
                {{--success: function (response) {--}}
                {{--if (response.status == 'true') {--}}
                {{--window.location.href = '{{url('profilesetting')}}';--}}
                {{--}--}}
                {{--},--}}
                {{--type: 'POST'--}}
                {{--});--}}
                {{--}--}}
                {{--@endif--}}


                {{--@if ($updateVideoBanner == 'null')--}}
                {{--var videoBanner_id = 0;--}}
                {{--$('.video-badge-checkbox').each(function () {--}}
                {{--if ($(this).is(':checked')) {--}}
                {{--videoBanner_id = $(this).val();--}}
                {{--}--}}
                {{--});--}}
                {{--if (videoBanner_id != 0) {--}}
                {{--$.ajax({--}}
                {{--url: '{{url('/profile/badge-update')}}',--}}
                {{--data: {'id': videoBanner_id, 'badge': 'video-banner'},--}}
                {{--headers: {'X-XSRF-TOKEN': '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}'},--}}
                {{--error: function () {--}}

                {{--},--}}
                {{--success: function (response) {--}}
                {{--if (response.status == 'true') {--}}
                {{--window.location.href = '{{url('album')}}';--}}
                {{--}--}}
                {{--},--}}
                {{--type: 'POST'--}}
                {{--});--}}
                {{--}--}}
                {{--@endif--}}
                {{--@if ($updateSignboard == 'null')--}}
                {{--var signboard_id = 0;--}}
                {{--$('.badge-checkbox').each(function () {--}}
                {{--if ($(this).is(':checked')) {--}}
                {{--signboard_id = $(this).val();--}}
                {{--}--}}
                {{--});--}}
                {{--if (signboard_id != 0) {--}}
                {{--$.ajax({--}}
                {{--url: '{{url('/profile/badge-update')}}',--}}
                {{--data: {'id': signboard_id, 'badge': 'signboard'},--}}
                {{--headers: {'X-XSRF-TOKEN': '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}'},--}}
                {{--error: function () {--}}

                {{--},--}}
                {{--success: function (response) {--}}
                {{--if (response.status == 'true') {--}}
                {{--window.location.href = '{{url('profilesetting')}}';--}}
                {{--}--}}
                {{--},--}}
                {{--type: 'POST'--}}
                {{--});--}}
                {{--}--}}
                {{--@endif--}}


            });			
			
          /*  var product_table = $("#tab-product-detail").DataTable({
				'order': [],
                'responsive': false,
                'autoWidth': false,
				"scrollX":true,
				"aoColumnDefs": [
					{"bSortable":false, "aTargets": [0,1,2]},
				],
				"columnDefs": [
					{ "targets": "no-sort", "orderable": false },
					{ "targets": "small", "width": "50px" },
					{ "targets": "medium", "width": "80px" },
					{ "targets": "large", "width": "120px" },
					{ "targets": "blarge", "width": "200px" },
					{ "targets": "xlarge", "width": "280px" }
				]
            });		*/	
			
		/*	product_table.destroy();
			$('#tab-product-detail-tbody').empty();	
			$("#tab-product-detail").parents('div.dataTables_wrapper').first().hide();			
			$("#myspinner").show();			
			$.ajax({
				url: '{{ route('getmerchantproducts') }}',
				cache: false,
				method: 'GET',
				data: {merchant_id: $('#merchant_id').val()},
				success: function(result, textStatus, errorThrown) {
					console.log(result);
					
					$("#tab-product-detail-tbody").append(result);
					product_table = $("#tab-product-detail").DataTable({
						'order': [],
						'responsive': false,
						'autoWidth': false,
						"scrollX":true,
						"aoColumnDefs": [
							{"bSortable":false, "aTargets": [0,1,2]},
						],
						"columnDefs": [
							{ "targets": "no-sort", "orderable": false },
							{ "targets": "small", "width": "50px" },
							{ "targets": "medium", "width": "80px" },
							{ "targets": "large", "width": "120px" },
							{ "targets": "blarge", "width": "200px" },
							{ "targets": "xlarge", "width": "280px" }
						]
					});	
					$("#myspinner").hide();	
					//$('.oshop_select').select2();
					$("#tab-product-detail").parents('div.dataTables_wrapper').first().show();					
				},
				error: function (responseData, textStatus, errorThrown) {
					console.log(errorThrown);
					product_table = $("#tab-product-detail").DataTable({
						'order': [],
						'responsive': false,
						'autoWidth': false,
						"scrollX":true,
						"aoColumnDefs": [
							{"bSortable":false, "aTargets": [0,1,2]},
						],
						"columnDefs": [
							{ "targets": "no-sort", "orderable": false },
							{ "targets": "small", "width": "50px" },
							{ "targets": "medium", "width": "80px" },
							{ "targets": "large", "width": "120px" },
							{ "targets": "blarge", "width": "200px" },
							{ "targets": "xlarge", "width": "280px" }
						]
					});		
					$("#myspinner").hide();	
					$("#tab-product-detail").parents('div.dataTables_wrapper').first().show();				
				}
			});	*/
		
		
		$('#states_biz').on('change', function () {
			$(this).removeClass('error');
			$(this).siblings('label.error').remove();
			var val = $(this).val();
			if (val != "") {
				var text = $('#states_biz option:selected').text();
				//$('#states_p').html(text);
				$.ajax({
					type: "post",
					url: JS_BASE_URL + '/city',
					data: {id: val},
					cache: false,
					success: function (responseData, textStatus, jqXHR) {
						if (responseData != "") {
							$('#cities_biz').html(responseData);
							document.getElementById('cities_biz').disabled = false;
						}
						else {
							$('#cities_biz').empty();
							$('#select2-cities_biz-container').empty();
							document.getElementById('cities_biz').disabled = false;
						}
					},
					error: function (responseData, textStatus, errorThrown) {
						alert(errorThrown);
					}
				});
			}
			else {
				$('#select2-cities_biz-container').empty();
				$('#cities_biz').html('<option value="" selected>Choose Option</option>');
			}
		});

		$('#cities_biz').on('change', function () {
			$(this).removeClass('error');
			$(this).siblings('label.error').remove();
			var val = $(this).val();
			if (val != "") {
				var text = $('#cities_biz option:selected').text();
				//$('#cities_p').html(text);
				$.ajax({
					type: "post",
					url: JS_BASE_URL + '/area',
					data: {id: val},
					cache: false,
					success: function (responseData, textStatus, jqXHR) {
						if (responseData != "") {
							$('#areas_biz').html(responseData);
							document.getElementById('areas_biz').disabled = false;
						}
						else {
							$('#areas_biz').empty();
							$('#select2-areas_biz-container').empty();
							document.getElementById('areas_biz').disabled = false;
						}
					},
					error: function (responseData, textStatus, errorThrown) {
						alert(errorThrown);
					}
				});
			}
			else {
				$('#select2-areas_biz-container').empty();
				$('#areas_biz').html('<option value="" selected>Choose Option</option>');
			}
		});		

		$('#states_biz_b2b').on('change', function () {
			$(this).removeClass('error');
			$(this).siblings('label.error').remove();
			var val = $(this).val();
			if (val != "") {
				var text = $('#states_biz_b2b option:selected').text();
				//$('#states_p').html(text);
				$.ajax({
					type: "post",
					url: JS_BASE_URL + '/city',
					data: {id: val},
					cache: false,
					success: function (responseData, textStatus, jqXHR) {
						if (responseData != "") {
							$('#cities_biz_b2b').html(responseData);
							document.getElementById('cities_biz_b2b').disabled = false;
						}
						else {
							$('#cities_biz_b2b').empty();
							$('#select2-cities_biz_b2b-container').empty();
							document.getElementById('cities_biz_b2b').disabled = false;
						}
					},
					error: function (responseData, textStatus, errorThrown) {
						alert(errorThrown);
					}
				});
			}
			else {
				$('#select2-cities_biz_b2b-container').empty();
				$('#cities_biz_b2b').html('<option value="" selected>Choose Option</option>');
			}
		});
		
		$('#states_biz_hyper').on('change', function () {
			$(this).removeClass('error');
			$(this).siblings('label.error').remove();
			var val = $(this).val();
			if (val != "") {
				var text = $('#states_biz_hyper option:selected').text();
				//$('#states_p').html(text);
				$.ajax({
					type: "post",
					url: JS_BASE_URL + '/city',
					data: {id: val},
					cache: false,
					success: function (responseData, textStatus, jqXHR) {
						if (responseData != "") {
							$('#cities_biz_hyper').html(responseData);
							document.getElementById('cities_biz_hyper').disabled = false;
						}
						else {
							$('#cities_biz_hyper').empty();
							$('#select2-cities_biz_hyper-container').empty();
							document.getElementById('cities_biz_hyper').disabled = false;
						}
					},
					error: function (responseData, textStatus, errorThrown) {
						alert(errorThrown);
					}
				});
			}
			else {
				$('#select2-cities_biz_hyper-container').empty();
				$('#cities_biz_hyper').html('<option value="" selected>Choose Option</option>');
			}
		});		

		$('#cities_biz_b2b').on('change', function () {
			$(this).removeClass('error');
			$(this).siblings('label.error').remove();
			var val = $(this).val();
			if (val != "") {
				var text = $('#cities_biz_b2b option:selected').text();
				//$('#cities_p').html(text);
				$.ajax({
					type: "post",
					url: JS_BASE_URL + '/area',
					data: {id: val},
					cache: false,
					success: function (responseData, textStatus, jqXHR) {
						if (responseData != "") {
							$('#areas_biz_b2b').html(responseData);
							document.getElementById('areas_biz_b2b').disabled = false;
						}
						else {
							$('#areas_biz_b2b').empty();
							$('#select2-areas_biz_b2b-container').empty();
							document.getElementById('areas_biz_b2b').disabled = false;
						}
					},
					error: function (responseData, textStatus, errorThrown) {
						alert(errorThrown);
					}
				});
			}
			else {
				$('#select2-areas_biz_b2b-container').empty();
				$('#areas_biz_b2b').html('<option value="" selected>Choose Option</option>');
			}
		});		

		$('#cities_biz_hyper').on('change', function () {
			$(this).removeClass('error');
			$(this).siblings('label.error').remove();
			var val = $(this).val();
			if (val != "") {
				var text = $('#cities_biz_hyper option:selected').text();
				//$('#cities_p').html(text);
				$.ajax({
					type: "post",
					url: JS_BASE_URL + '/area',
					data: {id: val},
					cache: false,
					success: function (responseData, textStatus, jqXHR) {
						if (responseData != "") {
							$('#areas_biz_hyper').html(responseData);
							document.getElementById('areas_biz_hyper').disabled = false;
						}
						else {
							$('#areas_biz_hyper').empty();
							$('#select2-areas_biz_hyper-container').empty();
							document.getElementById('areas_biz_hyper').disabled = false;
						}
					},
					error: function (responseData, textStatus, errorThrown) {
						alert(errorThrown);
					}
				});
			}
			else {
				$('#select2-areas_biz_hyper-container').empty();
				$('#areas_biz_hyper').html('<option value="" selected>Choose Option</option>');
			}
		});			
			
			$('input:radio[name=del_option]').change(function () {
				if($(this).val()=="pickup"){
					$("#own_delivery").hide();
					$("#system_delivery").hide();
					$("#pspecification").show();
                    $("#pvoucher").hide();
				} else if($(this).val()=="voucher"){
					$("#own_delivery").hide();
					$("#system_delivery").hide();
					$("#pspecification").hide();
                    $("#pvoucher").show();
				} else if($(this).val()=="system"){
					$("#own_delivery").hide();
					$("#system_delivery").show();
					$("#pspecification").show();	
                    $("#pvoucher").hide();				
				} else {
                    // Own
					$("#own_delivery").show();
					$("#system_delivery").hide();
					$("#pspecification").show();	
                    $("#pvoucher").hide();				
				}
				
			});	

			$('input:radio[name=del_option_b2b]').change(function () {
				if($(this).val()=="pickup"){
					$("#own_delivery_b2b").hide();
					$("#system_delivery_b2b").hide();
				} else if($(this).val()=="system"){
					$("#own_delivery_b2b").hide();
					$("#system_delivery_b2b").show();					
				} else {
                    // Own
					$("#own_delivery_b2b").show();
					$("#system_delivery_b2b").hide();					
				}
				
			});				
            function pad (str, max) {
                str = str.toString();
                return str.length < max ? pad("0" + str, max) : str;
            }

            /*
             * Function To Handle Custom Themes
             * When creating products and also
             * for selection of either product
             * or voucher
             */
            $('#append-subCate').on('click','button.create-product',function(){
            //$('.create-product').click(function () { alert("New Product Click");
                var category_id = $(this).attr('data-rowid');
                var modal = $("#myModalProduct");
                var level_1_list  = null;
                var level_2_list  = null;
                var level_3_list  = null;
                var level_4_list  = null;
                //modal.find('.modal-title').text("Options");
                //modal.find('.modal-body').html("<h1>hello</h1>");

                $.ajax({
                    url: '{{url('/gc')}}',
                    data:{'id':category_id},
                    headers: {'X-XSRF-TOKEN': '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}'},
                    error: function (err) {
                        console.log(err.message)
                    },
                    success: function (data) {
                        level_1_list = '<optgroup label="L1">';
                        for(var l1=0; l1 < data.length; l1++){
                            level_1_list += '<option data-level="1" data-type="'+data[l1].type+'" value="'+data[l1].id+'">'+data[l1].description+'</option>';
                            //console.log(data[l1].name);
                            if(data[l1].L2.length > 0){
                                level_2_list = '<optgroup label="L2">';
                                for(var l2=0; l2<data[l1].L2.length; l2++){
                                    level_2_list += '<option data-level="2" data-type="'+data[l1].L2[l2].type+'" value="'+data[l1].L2[l2].id+'">'+data[l1].L2[l2].description+'</option>';
                                    //console.log("   "+data[l1].L2[l2].name);
                                    if(data[l1].L2[l2].L3.length > 0){
                                        level_3_list = '<optgroup label="L3">';
                                        for(var l3=0; l3<data[l1].L2[l2].L3.length; l3++){
                                            level_3_list += '<option data-level="3" data-type="'+data[l1].L2[l2].L3[l3].type+'" value="'+data[l1].L2[l2].L3[l3].id+'">'+data[l1].L2[l2].L3[l3].description+'</option>';
                                            //console.log("       "+data[l1].L2[l2].L3[l3].name);
                                            if(data[l1].L2[l2].L3[l3].L4.length > 0){
                                                level_4_list = '<optgroup label="L4">';
                                                for(var l4=0; l4<data[l1].L2[l2].L3[l3].L4.length; l4++){
                                                    level_4_list += '<option data-level="4"  data-type="'+data[l1].L2[l2].L3[l3].L4[l4].type+'" value="'+data[l1].L2[l2].L3[l3].L4[l4].id+'">'+data[l1].L2[l2].L3[l3].L4[l4].description+'</option>';
                                                    //console.log("           "+data[l1].L2[l2].L3[l3].L4[l4].name);
                                                }
                                                level_4_list += '</optgroup>';
                                                //console.log(level_4_list);
                                            }
                                        }
                                        level_3_list += '</optgroup>';
                                        //console.log(level_3_list);
                                    }
                                }
                                level_2_list += '</optgroup>';
                                //console.log(level_2_list);
                            }
                        }
                        level_1_list += '</optgroup>';
                        //console.log(level_1_list);
                        modal.find('#subcategory').html(level_1_list+level_2_list+level_3_list+level_4_list);
                        modal.find('#subcategory').attr('cat-id', category_id);
                    },
                    type: 'GET'
                });
                //modal.find('#subcategory').html(level_1_list+level_2_list+level_3_list+level_4_list);
                modal.modal('show');

            });

            $("#goToLink").click(function(){
                var  subcat_id = $("#subcategory").val();
                var  level = $("#subcategory option:selected").attr("data-level");
                var  type = $("#subcategory option:selected").attr("data-type");
                var  product_type = $("#product-type").val();
                var category_id = $('#subcategory').attr('cat-id');
                /*
                 Scan Oshop Template for custom Template
                */
                $.ajax({
                    url: "{{ route('scan_oshop_template') }}",
                    data:{'subcat_id':subcat_id,'level':level},
                    headers:{'X-XSRF-TOKEN': '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}'},
                    error:function(error){
                        console.log(error);
                    },
                    success:function(data){
                        //console.log(data[0].productreg_file);
                        if(type.toUpperCase() === 'PRODUCT') {
                            console.log('product Created Selected');
                            if(data.length >0 && data != null){
                                window.location = '/'+data[0].productreg_file+'/'+category_id+'/'+subcat_id;
                            }else{
                                // alert(category_id + '/' + subcat_id)
                                window.location = "{{ route('create_new_product') }}"+'/'+category_id+'/'+subcat_id;
                            }
                        }
                        if(type.toUpperCase() === 'VOUCHER'){

                            // console.log('Voucher Created Selected');
                            if(data[0].productreg_file != null){
                                window.location = '/'+data[0].productreg_file+'/'+category_id+'/'+subcat_id;
                            }else{
                                window.location = '/create_new_voucher/'+category_id+'/'+subcat_id;
                            }
                        }
                    },
                    type:'GET'
                });
                $("#myModalProduct").modal('hide');
            });

            /*==========End OF Function=============*/
            //after redirecting tabs status
            {{--var param = '{{$param}}';--}}
            {{--var updateSignboard = '{{$updateSignboard}}';--}}
            {{--var updateVideoBanner = '{{$updateVideoBanner}}';--}}
            {{--var updateBunting = '{{$updateBunting}}';--}}
            {{--var sectionId = '{{$section_id[0]}}';--}}

            {{--if (param == "profilesetting") {--}}

            {{--$('#add-product').removeClass('in active');--}}
            {{--$('#tb-add-product').removeClass('active');--}}

            {{--if (updateSignboard == 'null') {--}}
            {{--//console.log(updateSignboard);--}}
            {{--$(".nav-tabs li").each(function () {--}}
            {{--$(this).not('#tb-signboard').children('a').removeAttr('data-toggle');--}}
            {{--$(this).not('#tb-signboard').addClass(' disabled');--}}
            {{--});--}}

            {{--$('#tb-signboard').addClass('active');--}}
            {{--$('#album-signboard').addClass(" in active");--}}
            {{--}--}}

            {{--if (updateVideoBanner == 'null') {--}}

            {{--$(".nav-tabs li").each(function () {--}}
            {{--$(this).not('#tb-video-banner').children('a').removeAttr('data-toggle');--}}
            {{--$(this).not('#tb-video-banner').addClass(' disabled');--}}
            {{--});--}}
            {{--$('#tb-video-banner').addClass('active');--}}
            {{--$('#video-banner').addClass(" in active");--}}
            {{--}--}}

            {{--if (updateBunting == 'null') {--}}

            {{--$(".nav-tabs li").each(function () {--}}
            {{--$(this).not('#tb-bunting').children('a').removeAttr('data-toggle');--}}
            {{--$(this).not('#tb-bunting').addClass(' disabled');--}}
            {{--});--}}
            {{--$('#tb-bunting').addClass('active');--}}
            {{--$('#bunting').addClass(" in active");--}}
            {{--}--}}

            {{--if (sectionId != 'null' && sectionId != '') {--}}
            {{--console.log("Section ID" + sectionId[0]);--}}
            {{--$(".nav-tabs li").each(function () {--}}
            {{--$(this).not('#tb-product-icon').children('a').removeAttr('data-toggle');--}}
            {{--$(this).not('#tb-product-icon').addClass(' disabled');--}}
            {{--});--}}
            {{--$('#tb-product-icon').addClass('active');--}}
            {{--$('#product-icon').addClass(" in active");--}}
            {{--}--}}

            {{--}--}}

            //Change All Tables To Datatables
            /************Added By Imran*************/
            $("#tab-wholesale-price").DataTable({
                'autoWidth': false,
                'scrollX': true
            });
            $("#tab-owarehouse-price").DataTable({
                'autoWidth': false,
                'scrollX': true
            });
			
		var validity = $('input[name=validity]:checked').val();
		console.log(validity);	
		var mtoday = $('#mtoday').val();
		var mwmonth = $('#mwmonth').val();
		$('.datepicker-example1').Zebra_DatePicker({
			format: 'M d, Y',
			direction: [mtoday, mwmonth]
		});			
			

			
		 $('body').on("click", ".validity", function () {
			// alert("BBBB");
			var validity = $('input[name=validity]:checked').val();
			var mtoday = $('#mtoday').val();
			var mwyear = $('#mwyear').val();
			var mwmonth = $('#mwmonth').val();
			var wweek = $('#wweek').val();
			var mrange = "";			
			console.log(validity);
			if(validity == "wyear"){
				mrange = mwyear;
				$('.datepicker-example1').Zebra_DatePicker({
					format: 'M d, Y',
					direction: [mtoday, mrange]
				});				
			} else if(validity == "wmonth"){
				mrange = mwmonth;
				$('.datepicker-example1').Zebra_DatePicker({
					format: 'M d, Y',
					direction: [mtoday, mrange]
				});				
			} else if(validity == "wweek"){
				mrange = wweek;
				$('.datepicker-example1').Zebra_DatePicker({
					format: 'M d, Y',
					direction: [mtoday, mrange]
				});					
			} else if(validity == "wkdays"){
				console.log("wkdays");
				$('.datepicker-example1').Zebra_DatePicker({
					format: 'M d, Y',
					direction: 1,
					disabled_dates: ['* * * 0,6'] 
				});					
			} else if(validity == "wkends"){
				console.log("wkends");
				$('.datepicker-example1').Zebra_DatePicker({
					format: 'M d, Y',
					direction: 1,
					disabled_dates: ['* * * 1,2,3,4,5'] 
				});					
			}
		 
		});		

		
		$('.selected-product').on('click', function () {
			var status= $(this).attr('data-status');
			if(status ==  "suspended"){
				$(this).prop('checked', false);
				toastr.warning("Product has been suspended. Please contact OpenSupport");
			}
		});
		  $('#export_public').click(function(){
			  $merchant_id = $('#merchant_id').val();
			  window.location = "{{url('/product/export_public?merchant_id='.$merchant_id)}}";
		 });	
		  $('#import_public').click(function(){
			  $merchant_id = $('#merchant_id').val();
			  window.location = "{{url('/product/import_public?merchant_id='.$merchant_id)}}";
		 });	
        $('#update').click(function(){
			//
			$('#update').html("Updating...");
            var data={};
            $('.oshop_select').each(function () {
				
				var key= $(this).attr('rel');
				//console.log(key);
				data[key]=[$(this).val(),$("#ret" + key).val(),$("#disc" + key).val(),$("#ret_qty" + key).val(),$("#b2b_qty" + key).val(),$("#cashbackval" + key).val()];
            });
            var datasmm={};
			var count_smm = 0;
            $('.smm_action').each(function () {
				var key= $(this).attr('data-pid');
                if (this.checked) {
                    datasmm[key]=true;
					count_smm++;
                } else {
					datasmm[key]=false;
				}
            });
			var smm_quota_max = parseInt($("#smm_quota_max").val());
			console.log(count_smm);
			if(count_smm > smm_quota_max){
				toastr.error("Warning: SMM quota exceeeded");
				$('#update').html("Update<br>Public");	
			} else {
            // Ajax Call
				console.log("Update1");
                $.ajax({
                    type: 'POST',
                    url: JS_BASE_URL + "/product/update/selected_product",
                    data:{'data':data, 'merchant_id':$('#merchant_id').val(), 'datasmm':datasmm},
                    dataType:'json',
                    success: function(resultData) {
                        console.log(resultData);
						$('#update').html("Update<br>Public");
						$('#updatedalert').removeClass('hidden').fadeIn(2000);
						$("#tab-product-detail").remove();
						$("#myspinner").show();			
						$.ajax({
							url: '{{ route('getmerchantproducts') }}',
							cache: false,
							method: 'GET',
							dataType:'json',
							data: {merchant_id: $('#merchant_id').val()},
							success: function(result, textStatus, errorThrown) {
								console.log(result);
								resetProductList(result);					
							},
							
							error: function (responseData, textStatus, errorThrown) {
								console.log(errorThrown);
								product_table = $("#tab-product-detail").DataTable({
									'order': [],
									'responsive': false,
									'autoWidth': false,
									"scrollX":true,
									"aoColumnDefs": [
										{"bSortable":false, "aTargets": [0,1,2]},
									],
									"columnDefs": [
										{ "targets": "no-sort", "orderable": false },
										{ "targets": "small", "width": "50px" },
										{ "targets": "medium", "width": "80px" },
										{ "targets": "large", "width": "120px" },
										{ "targets": "blarge", "width": "200px" },
										{ "targets": "xlarge", "width": "280px" }
									]
								});		
								$("#myspinner").hide();	
								$("#tab-product-detail").parents('div.dataTables_wrapper').first().show();				
							}
						});							
						setTimeout(function () {
							$('#updatedalert').addClass('hidden').fadeIn(2000);						
						}, 3000);
					}
                });
				}
                //
            });			
			
			$('body').on('change', '.dealer_select', function() {
				var dealer_rel = $(this).attr("rel");
				if($(this).val() == ""){
					$("#addsppn-" + dealer_rel).addClass('die');
					$("#dealer-" + dealer_rel).text("");
					$("#dealerid-" + dealer_rel).text("");
				} else {
					$("#addsppn-" + dealer_rel).removeClass('die');
					var val = $("#userID-" + dealer_rel + " option:selected").text();
					$("#dealer_id_" + dealer_rel).val($(this).val());
					var splitarr = val.split("-");
					$("#dealer-" + dealer_rel).text(splitarr[1]);
					$("#dealerid-" + dealer_rel).text(splitarr[0]);
				}
			});

			spp_table = $("#sppTable").DataTable({
				'order': [],
				'responsive': false,
				'autoWidth': false,
				"scrollX":true,
				"columnDefs": [
					{ "targets": "no-sort", "orderable": false },
					{ "targets": "small", "width": "50px" },
					{ "targets": "medium", "width": "80px" },
					{ "targets": "large", "width": "120px" },
					{ "targets": "xlarge", "width": "280px" }
				]
			}	);	

			
			$('body').on('click', '.addsppn', function() {
				var dealer_rel = $(this).attr("rel");
				var rowNo = parseInt($(this).attr("rel"));
				rid = rowNo + 1;
				rid2 = rid + 1;
				route = $('#routegetdealers').val();
				var userid = $('#useridsell').val();
				var productid = $('#myproduct_id').val();
				$.ajax({ type: "get", url: route, data: {pid: productid, userid: userid},dataType: "json",success: function(result){
					console.log(result);
					var options = "<option value=''>Choose User</option>";
					for(var i = 0; i < result.length; i++){
						options = options + '<option value="'+result[i].id+'">' + result[i].nbid + " - "  + result[i].first_name + ' ' + result[i].last_name +  '</option>';
					}
					spp_table
					.row.add( [ '<center id="num-'+rid+'">'+rid2+'</center>', '<span id="userIDs-'+rid+'"><select class="form-control dealer_select" id="userID-'+rid+'" required="" rel="'+rid+'" >'+options+'</select></span><span class="dealer_selected_id" id="dealerid-'+rid+'" rel="'+rid+'" style="display: none;"></span><input type="hidden" id="dealer_id_'+rid+'" value="0" />', '<span class="dealer_selected" id="dealer-'+rid+'" rel="'+rid+'"></span>', '<a href="javascript:void(0);" class="sp_popup" rel="'+rid+'">Special&nbsp;Price</a>','<a href="javascript:void(0);" id="addsppn-'+rid+'" class="die addsppn form-control text-center text-green" rel="'+rid+'"><i class="fa fa-plus-circle"></i></a><a href="javascript:void(0);" id="remsppn-'+rid+'" title="Warning: you will remove this user special prices" class="remsppn form-control text-center text-danger" rel="'+rid+'" style="display:none;"><i class="fa fa-minus-circle"></i></a>' ] )
					.draw();
					$("#userID-"+rid).select2();
					$("#addsppn-" + dealer_rel).hide();
					$("#remsppn-" + dealer_rel).show();					
				}});

				
			});
			
			$('body').on('click', '.remsppn', function() {
				selec=confirm("Are you sure you want to remove this user special prices?"); 
				if (selec){
					var dealer_rel = $(this).attr("rel");
					var rid = $("#dealer_id_" + dealer_rel).val();
					var productid = $('#myproduct_id').val();
					route = $('#routedeletepdealer').val();
					$.ajax({ type: "POST", url: route, data: {id : rid, pid: productid}, success: function(result){
						
					}});	
					
					$(this).parent().parent().remove();
				} 				
			});			
			
			$('body').on('click', '.sp_popup', function() {
				var dealer_rel = $(this).attr("rel");
				var val = $("#dealer_id_" + dealer_rel).val();
				var rprice = $("#rPrice").val();
				var productid = $('#myproduct_id').val();
				if(val == 0 || val == ""){
					toastr.error("Warning: Please, select an user.");
				} else {
					if(rprice == "" || parseFloat(rprice) == 0){
						toastr.error("Warning: Retail product must be fully added before Special Price can be defined.");
					} else {
						if(productid == 0){
							toastr.error("Warning: Retail product must be fully added before Special Price can be defined.");
						} else {
							$("#userIDs-" + dealer_rel).hide();
							$("#dealerid-" + dealer_rel).show();
							var rid = $("#dealer_id_" + dealer_rel).val();
							
							var url=JS_BASE_URL+"/pd/sprices/"+rid+"/"+productid;
							var w=window.open(url,"_blank");
							w.focus();	
						}
					}				
				}		
			});
			
			$('body').on('click', '.delete_product', function() {
				var _this = $(this);
				var pid = $(this).attr('rel');
				var url = JS_BASE_URL + '/products/delete';
				$.ajax({
				  url: url,
				  type: "post",
				  data: {
						'pid': pid			  
				  },
				  success: function(data){
					//location.reload();
					//console.log(data);
					if(data == "1"){
						toastr.info("Product successfully deleted");
						product_table
								.row( _this.parents('tr') )
								.remove()
								.draw();						
					} else {
						toastr.info("Hyper product is currently having active contributions. Unable to Delete");
					}			
				  }
				});				
			});			

            $("#tab-special-price").DataTable({
                'autoWidth': false,
                'scrollX': true
            });


            $("#slotModal").on('show.bs.modal', function (event) {
                var link = $(event.relatedTarget);
                var voucher_id = link.data('voucher_id');
                var voucher_name = link.data('voucher_name');
                var route = link.data('route');
                console.log(route);
                getTimeSlots(voucher_name,voucher_id, route)


                function getTimeSlots(voucher_name,voucher_id, route) {
                    $.ajax({
                        url : route,
                        type : 'POST',
                        data : {"voucher_id":voucher_id},
                        success : function(response) {
                            console.log(response)
                            if(response){
                                $("#slotModal").find('.modal-body').html(response).fadeIn();
                                $("#slotModal").find('.modal-title').html(voucher_name);
								timeSlotGrid.onLoadTimeSlotGrid("modal-voucher-slot");
                            }
                        }
                    });
                }
            });

			$("#myModalB2B").on('show.bs.modal', function (event) {
				 var model = $(this);
                 var button = $(event.relatedTarget);
				 var product_id = button.data('rowid');
				 var b2b = $("#b2bb" + product_id).attr('data-qty');
				 var b2bid = $("#b2bb" + product_id).attr('data-b2b');
				 var product_name = button.data('rowname');
				 console.log(b2b);
				 $("#b2bspan").html('<a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" data-rowid="'+product_id+'" data-rowname="'+product_name+'" data-route="'+JS_BASE_URL +'/wholesale/'+product_id+'" data-detail-type="HSP"> Details </a>');
				 $("#specialspan").html('<a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" data-rowid="'+product_id+'" data-rowname="'+product_name+'" data-route="'+JS_BASE_URL +'/specialprice/'+product_id+'/'+$("#useridsell").val() + '" data-detail-type="SPP"> Special </a>');
				 if(b2b == null || b2b == ""){
						$("#qtyspan").html('');
					} else {
						$("#qtyspan").html('<span class="b2b_qty" id="b2b_qtyspan'+product_id+'" rel="'+product_id+'">'+b2b+'</span> <input style="display:none;" type="text" size="6" class="b2b_qty_input form-control" id="b2b_qty'+product_id+'" rel="'+product_id+'" relb2b="'+b2bid+'" value="'+b2b+'" />');
					}
			});
			
			$("#myModal").on('show.bs.modal', function (event) {
                var model = $(this);
                var button = $(event.relatedTarget);
                var product_id = button.data('rowid');
				$("#productid").val(product_id);
                var product_name = button.data('rowname');
                var isreset = button.data('isreset');
				$("#productname").val(product_name);
                var detail_type = button.data('detail-type');
                var route = button.data('route');
                

                getPopUp(detail_type, route);

                function getPopUp(detail_type, route) {
                    var title = setTitle(detail_type);
                    $.ajax({
                        url : route,
                        type : 'GET',
                        success : function(response) {
                            if(response){
                                $("#myModal").find('.modal-body').html(response);
                                $("#myModal").find('.modal-title').html(title);

								if(detail_type == 'HYSP'){
								var pledgesqty = $("#pledgesqty").val();
								$('.delivery_require_hyper').on('keyup', function () {
									var del_width = $("#del_width_hyper").val();
									var del_lenght = $("#del_lenght_hyper").val();
									var del_height = $("#del_height_hyper").val();
									var del_weight = $("#del_weight_hyper").val();
									
									if(del_weight != "" && del_height != "" && del_lenght != "" && del_width != ""){
										//alert("fdsafsadf");
										del_width = parseFloat(del_width);		
										del_lenght = parseFloat(del_lenght);		
										del_height = parseFloat(del_height);		
										del_weight = parseFloat(del_weight);
										var cms_pricing = parseFloat($("#cms_pricing_hyper").val());
										var grs_pricing = parseFloat($("#grs_pricing_hyper").val());
										var mts_pricing = parseFloat($("#mts_pricing_hyper").val());	
										var total_pricing = (del_width * del_height * del_lenght * cms_pricing) + (del_weight * grs_pricing);
										$("#del_pricing_hyper").val(total_pricing).number(true, 2);
									} else {
										$("#del_pricing_hyper").val("0.00");
									}
								});    
								
								$('#checkboxD_hyper').click(function () {
									$('.toggleDelivery_hyper').find('input').attr('disabled', this.checked);
									$('.toggleDelivery_hyper').find('input').val('');
									if(this.checked){
										$('#checkboxDq_hyper').attr('checked', false);
										$("#checkboxDqn_hyper").prop('disabled', true);
										$("#checkboxDqn_hyper").val('');
									}
								});
								
								$('#checkboxDq_hyper').on('change', function () {
										var boo = $(this).is(":checked");
										if(boo){
											$("#checkboxDqn_hyper").prop('disabled', false);
										} else {
											$("#checkboxDqn_hyper").prop('disabled', true);
											$("#checkboxDqn_hyper").val('');
										}
								});	
								
								$('input:radio[name=del_option_hyper]').change(function () {
									$("#own_delivery_hyper").toggle();
									$("#system_delivery_hyper").toggle();
								});		
									
								$('input.delivery_prices_hyper, input.delivery_require_hyper, input.numberformat').number(true, 2);		
									
								$('#states_hyper').on('change', function () {
									$(this).removeClass('error');
									$(this).siblings('label.error').remove();
									var val = $(this).val();
									if (val != "") {
										var text = $('#states_hyper option:selected').text();
									  //  $('#states_p').html(text);
										$.ajax({
											type: "post",
											url: JS_BASE_URL + '/city',
											data: {id: val},
											cache: false,
											success: function (responseData, textStatus, jqXHR) {
												if (responseData != "") {
													$('#cities_hyper').html(responseData);
													document.getElementById('cities_hyper').disabled = false;
												}
												else {
													$('#cities_hyper').empty();
													$('#select2-cities_hyper-container').empty();
													document.getElementById('cities_hyper').disabled = false;
												}
											},
											error: function (responseData, textStatus, errorThrown) {
												alert(errorThrown);
											}
										});
									}
									else {
										$('#select2-cities_hyper-container').empty();
										$('#cities_hyper').html('<option value="0" selected>Choose Option</option>');
									}
								});

								$('#cities_hyper').on('change', function () {
									$(this).removeClass('error');
									$(this).siblings('label.error').remove();
									var val = $(this).val();
									if (val != "") {
										var text = $('#cities_hyper option:selected').text();
										//$('#cities_p').html(text);
										$.ajax({
											type: "post",
											url: JS_BASE_URL + '/area',
											data: {id: val},
											cache: false,
											success: function (responseData, textStatus, jqXHR) {
												if (responseData != "") {
													$('#areas_hyper').html(responseData);
													document.getElementById('areas_hyper').disabled = false;
												}
												else {
													$('#areas_hyper').empty();
													$('#select2-areas_hyper-container').empty();
													document.getElementById('areas_hyper').disabled = false;
												}
											},
											error: function (responseData, textStatus, errorThrown) {
												alert(errorThrown);
											}
										});
									}
									else {
										$('#select2-areas_hyper-container').empty();
										$('#areas_hyper').html('<option value="0" selected>Choose Option</option>');
									}
								});

								$('#areas_hyper').on('change', function () {
									var val = $(this).val();
									if (val != "") {
										var text = $('#areas_hyper option:selected').text();
									  //  $('#areas_p').html(text);
									}
								});


									$('#states_biz_hyper').on('change', function () {
										$(this).removeClass('error');
										$(this).siblings('label.error').remove();
										var val = $(this).val();
										if (val != "") {
											var text = $('#states_biz_hyper option:selected').text();
											//$('#states_p').html(text);
											$.ajax({
												type: "post",
												url: JS_BASE_URL + '/city',
												data: {id: val},
												cache: false,
												success: function (responseData, textStatus, jqXHR) {
													if (responseData != "") {
														$('#cities_biz_hyper').html(responseData);
														document.getElementById('cities_biz').disabled = false;
													}
													else {
														$('#cities_biz_hyper').empty();
														$('#select2-cities_biz_hyper-container').empty();
														document.getElementById('cities_biz_hyper').disabled = false;
													}
												},
												error: function (responseData, textStatus, errorThrown) {
													alert(errorThrown);
												}
											});
										}
										else {
											$('#select2-cities_biz_hyper-container').empty();
											$('#cities_biz_hyper').html('<option value="0" selected>Choose Option</option>');
										}
									});

									$('#cities_biz_hyper').on('change', function () {
										$(this).removeClass('error');
										$(this).siblings('label.error').remove();
										var val = $(this).val();
										if (val != "") {
											var text = $('#cities_biz_hyper option:selected').text();
											//$('#cities_p').html(text);
											$.ajax({
												type: "post",
												url: JS_BASE_URL + '/area',
												data: {id: val},
												cache: false,
												success: function (responseData, textStatus, jqXHR) {
													if (responseData != "") {
														$('#areas_biz_hyper').html(responseData);
														document.getElementById('areas_biz_hyper').disabled = false;
													}
													else {
														$('#areas_biz_hyper').empty();
														$('#select2-areas_biz_hyper-container').empty();
														document.getElementById('areas_biz_hyper').disabled = false;
													}
												},
												error: function (responseData, textStatus, errorThrown) {
													alert(errorThrown);
												}
											});
										}
										else {
											$('#select2-areas_biz_hyper-container').empty();
											$('#areas_biz_hyper').html('<option value="0" selected>Choose Option</option>');
										}
									});		
									
									$('#hyperprice').on('keyup', function () {
										var rp = parseInt($('#retail_priceh').val());
										var hp = parseInt($('#hyperprice').val());
										var res = 0;
										if(hp > 0 && rp > 0){
											res = ((rp - hp) / rp) * 100;
										}

										if(res>99.99){
											res=99.99
										}
										if(res < 0){
											res = 0;
										}
										//if(!isNaN(res)) {
										if(hp >= rp || hp == 0){
											$("#error_hyper").show();
											$("#save_hyper").hide();
											$("#update_hyper").prop("disabled",true);
											$("#add_hyper").prop("disabled",true);
											$('#resultSaveh').text(0).number(true, 2);
										} else {
											$("#error_hyper").hide();
											$("#save_hyper").show();
											$("#update_hyper").prop("disabled",false);
											$("#add_hyper").prop("disabled",false);				
											if (res > 0) {
												$('#resultSaveh').text(res).number(true, 2);
											} else {
												$('#resultSaveh').text(0).number(true, 2);
											}				
										}

										//}
									});		

									$('.hyper_terms').summernote({
										toolbar: [
										// [groupName, [list of button]]
											['insert', ['picture','table','hr']],
											['style', ['fontname','fontsize','color','bold','italic',
												'underline','strikethrough','superscript','subscript','clear']],
											['para', ['style','ul','ol','paragraph','height']],
											['misc', ['fullscreen','codeview','undo','redo','help']],
											],
										height: 300,     // set editor height
										minHeight: null, // set minimum height of editor
										maxHeight: null, // set maximum height of editor
										dialogsInBody: true,
										focus: true,     // set focus to editable area after initializing summernote
										airMode: false,
									});

									$("#minusmoq").click(function (e) {
										var val = $("#moq").val();
										var valcaf = $("#moqcaf").val();
										var newval = parseInt(val) - (1*parseInt(valcaf));
										if(newval <= 0){
											$("#moq").val(val);
										} else {
											if((parseInt(newval) % parseInt(valcaf)) != 0){
												var modd = (parseInt(newval) % parseInt(valcaf));
												console.log(modd);
												newval = newval + (parseInt(valcaf) - modd);
											}
											$("#moq").val(newval);
										}
									});

									$("#plusmoq").click(function (e) {
										var val = $("#moq").val();
										var valcaf = $("#moqcaf").val();
										var newval = parseInt(val) + (1*parseInt(valcaf));
										if((parseInt(newval) % parseInt(valcaf)) != 0){
											var modd = (parseInt(newval) % parseInt(valcaf));
											newval = newval + (parseInt(valcaf) - modd);
										}										
										$("#moq").val(newval);
									});		

									$("#minushqty").click(function (e) {
										var val = $("#hqty").val();
										var valcaf = $("#moqcaf").val();
										var newval = parseInt(val) - (1*parseInt(valcaf));
										if(newval == 0){
											$("#hqty").val(val);
										} else {
											if((parseInt(newval) % parseInt(valcaf)) != 0){
												var modd = (parseInt(newval) % parseInt(valcaf));
												newval = newval + modd;
											}											
											$("#hqty").val(newval);
										}
									});
									
									
									$("#plushqty").click(function (e) {
										var val = $("#hqty").val();
										var valcaf = $("#moqcaf").val();
										var newval = parseInt(val) + (1*parseInt(valcaf));
										if((parseInt(newval) % parseInt(valcaf)) != 0){
											var modd = (parseInt(newval) % parseInt(valcaf));
											newval = newval + modd;
										}										
										$("#hqty").val(newval);
									});

									$("#minusmoqcaf").click(function (e) {
										var val = $("#moqcaf").val();
										var newval = parseInt(val) - 1;
										if(newval == 0){
											$("#moqcaf").val(val);
											$("#moq").val(val);
											$("#hqty").val(val);
										} else {
											$("#moqcaf").val(newval);
											$("#moq").val(newval);
											$("#hqty").val(newval);											
										}
									});

									$("#plusmoqcaf").click(function (e) {
										var val = $("#moqcaf").val();
										var newval = parseInt(val) + 1;
										$("#moqcaf").val(newval);
										$("#moq").val(newval);
										$("#hqty").val(newval);											
									});
									
									$("#minusdur").click(function (e) {
										var val = $("#duration").val();
										var newval = parseInt(val) - 1;
										if(newval == 0){
											$("#duration").val(val);
										} else {
											$("#duration").val(newval);
										}
									});

									$("#plusdur").click(function (e) {
										var val = $("#duration").val();
										var newval = parseInt(val) + 1;
										$("#duration").val(newval);
									});		
									
									$("#setcaf").click(function (e) {
										var moq_location = $("#moq_location").val();
									//	alert("moq_location: " + moq_location);
										if(moq_location ==  "0"){
											$("#setcaf").addClass("btn-success");
											$("#setcaf").removeClass("btn-warning");
											$("#setcafgly").addClass("glyphicon-check");
											$("#setcafgly").removeClass("glyphicon-transfer");
											$("#moqcaf").attr("disabled", false);
											$("#plusmoqcaf").attr("disabled", false);
											$("#minusmoqcaf").attr("disabled", false);
											$("#plusmoq").attr("disabled", true);
											$("#minusmoq").attr("disabled", true);
											$("#moq").attr("disabled", true);
											$("#plushqty").attr("disabled", true);											
											$("#minushqty").attr("disabled", true);											
											$("#hqty").attr("disabled", true);	
											$("#hyperprice").attr("disabled", true);	
											$("#moq_location").val("1");
										} else {
											$("#setcaf").removeClass("btn-success");
											$("#setcaf").addClass("btn-warning");
											$("#setcafgly").removeClass("glyphicon-check");
											$("#setcafgly").addClass("glyphicon-transfer");
											$("#moqcaf").attr("disabled", true);
											$("#plusmoqcaf").attr("disabled", true);
											$("#minusmoqcaf").attr("disabled", true);
											$("#plusmoq").attr("disabled", false);
											$("#minusmoq").attr("disabled", false);
											$("#moq").attr("disabled", false);
											$("#plushqty").attr("disabled", false);											
											$("#minushqty").attr("disabled", false);											
											$("#hqty").attr("disabled", false);
											$("#hyperprice").attr("disabled", false);
											$("#moq_location").val("0");											
										}
									});										

									$("#close_hyper").click(function (e) {
										$('#myModal').modal('hide');
									});
									
									$("#nremove_hyper").click(function (e) {
										toastr.error("Hyper have not been created yet.");
									});
									
									$("#noremove_hyper").click(function (e) {
										toastr.error("You can't remove this hyper. Already have pledges.");
									});										
									
									$("#remove_hyper").click(function (e) {
                                        /*This code block doesn't seems to run . ~Zurez*/ 
										var isremove = confirm("This will remove product from Hyper Pool and OShop Hyper. Do you want to continue?");
										if(isremove){
											$('#remove_hyper').html('Removing...');
                                            alert("u");
											var owarehouse_id = $("#owarehouse_id").val();
											var hyper_id = $("#hyper_id").val();
											$.ajax({
												url: "/removehyperprice",
												type: "POST",
												data: {
													owarehouse_id : owarehouse_id,
													hyper_id : hyper_id
												},
												async: false,
												success: function(response)
												{
													$('#remove_hyper').html('Removed');
													$('#myModal').modal('hide');
													$("#tab-product-detail").remove();		
													$("#myspinner").show();			
													$.ajax({
														url: '{{ route('getmerchantproducts') }}',
														cache: false,
														method: 'GET',
														data: {merchant_id: $('#merchant_id').val()},
														success: function(result, textStatus, errorThrown) {
															resetProductList(result);					
														},
														error: function (responseData, textStatus, errorThrown) {
															console.log(errorThrown);
															product_table = $("#tab-product-detail").DataTable({
																'order': [],
																'responsive': false,
																'autoWidth': false,
																"scrollX":true,
																"aoColumnDefs": [
																	{"bSortable":false, "aTargets": [0,1,2]},
																],
																"columnDefs": [
																	{ "targets": "no-sort", "orderable": false },
																	{ "targets": "small", "width": "50px" },
																	{ "targets": "medium", "width": "80px" },
																	{ "targets": "large", "width": "120px" },
																	{ "targets": "blarge", "width": "200px" },
																	{ "targets": "xlarge", "width": "280px" }
																]
															});		
															$("#myspinner").hide();	
															$("#tab-product-detail").parents('div.dataTables_wrapper').first().show();				
														}
													});															
												}
											});										
											$('#myModal').modal('hide');											
										}
									});											

									$("#add_hyper").click(function (e) {
										$('#add_hyper').html('Saving...');
										var hyper_duration = $("#hyper_duration").val();
										//var hqty = $("#hqty").val();
										var states_hyper = $("#states_hyper").val();
										var cities_hyper = $("#cities_hyper").val();
										var areas_hyper = $("#areas_hyper").val();
										var del_world_v_hyper = $("#del_world_v_hyper").val();
										var del_malaysia_v_hyper = $("#del_malaysia_v_hyper").val();
										var del_sabah_v_hyper = $("#del_sabah_v_hyper").val();
										var del_sarawak_v_hyper = $("#del_sarawak_v_hyper").val();
										var del_width_hyper = $("#del_width_hyper").val();
										var del_height_hyper = $("#del_height_hyper").val();
										var del_lenght_hyper = $("#del_lenght_hyper").val();
										var del_weight_hyper = $("#del_weight_hyper").val();
										var del_option_hyper = $('input:radio[name=del_option_hyper]:checked').val();
										var states_biz_hyper = $("#states_biz_hyper").val();
										var cities_biz_hyper = $("#cities_biz_hyper").val();
										var areas_biz_hyper = $("#areas_biz_hyper").val();
										var del_pricing_hyper = $("#del_pricing_hyper").val();
										var hqty = $("#hqty").val();
										//var deliveryqty = $("#deliveryqty").val();
										var moq = $("#moq").val();
										var moqcaf = $("#moqcaf").val();
										var hyperprice = $("#hyperprice").val();
										var hyper_terms = $("#hyper_terms").val();
										var parent_id = $("#parent_id").val();
										//alert(cities_hyper);
										if(parseInt(moq) < parseInt(moqcaf) || parseInt(hqty) < parseInt(moqcaf)){
											toastr.error("MOQ and Maximum most be greater than MOQ/location");
										} else {
											if((parseInt(moq) % parseInt(moqcaf)) != 0 ||  (parseInt(hqty) % parseInt(moqcaf)) != 0 ){
												toastr.error("MOQ and Maximum most be multiples of MOQ/location");
											} else {
												$.ajax({
													url: "/addhyperprice",
													type: "POST",
													data: {
														moq : moq,
														moqcaf : moqcaf,
														duration : hyper_duration,
														hyperprice : hyperprice,
														hyper_terms : hyper_terms,
														hqty : hqty,
														del_world_v_hyper : del_world_v_hyper,
														del_malaysia_v_hyper : del_malaysia_v_hyper,
														del_sabah_v_hyper : del_sabah_v_hyper,
														del_sarawak_v_hyper : del_sarawak_v_hyper,
													//	deliveryqty : deliveryqty,
														states_hyper : states_hyper,
														cities_hyper : cities_hyper,
														areas_hyper : areas_hyper,
														del_width_hyper : del_width_hyper,
														del_height_hyper : del_height_hyper,
														del_lenght_hyper : del_lenght_hyper,
														del_weight_hyper : del_weight_hyper,
														del_option_hyper : del_option_hyper,
														states_biz_hyper : states_biz_hyper,
														cities_biz_hyper : cities_biz_hyper,
														areas_biz_hyper : areas_biz_hyper,
														del_pricing_hyper : del_pricing_hyper,
														parent_id : parent_id
													},
													async: false,
													success: function(response)
													{
														$('#add_hyper').html('Saved');
														$('#myModal').modal('hide');
														$("#tab-product-detail").remove();		
														$("#myspinner").show();			
														$.ajax({
															url: '{{ route('getmerchantproducts') }}',
															cache: false,
															method: 'GET',
															data: {merchant_id: $('#merchant_id').val()},
															success: function(result, textStatus, errorThrown) {
																resetProductList(result);					
															},
															error: function (responseData, textStatus, errorThrown) {
																console.log(errorThrown);
																product_table = $("#tab-product-detail").DataTable({
																	'order': [],
																	'responsive': false,
																	'autoWidth': false,
																	"scrollX":true,
																	"aoColumnDefs": [
																		{"bSortable":false, "aTargets": [0,1,2]},
																	],
																	"columnDefs": [
																		{ "targets": "no-sort", "orderable": false },
																		{ "targets": "small", "width": "50px" },
																		{ "targets": "medium", "width": "80px" },
																		{ "targets": "large", "width": "120px" },
																		{ "targets": "blarge", "width": "200px" },
																		{ "targets": "xlarge", "width": "280px" }
																	]
																});		
																$("#myspinner").hide();	
																$("#tab-product-detail").parents('div.dataTables_wrapper').first().show();				
															}
														});															
													}
												});
											}
										}
									});
									
									$("#reset_hyper").click(function (e) {
										$("#hyper_div :input").attr("disabled", false);
										$("#reset_hyper").hide();
										$("#setcaf").addClass("btn-success");
										$("#setcaf").removeClass("btn-warning");
										$("#setcafgly").addClass("glyphicon-check");
										$("#setcafgly").removeClass("glyphicon-transfer");
										$("#moqcaf").attr("disabled", false);
										$("#plusmoqcaf").attr("disabled", false);
										$("#minusmoqcaf").attr("disabled", false);
										$("#plusmoq").attr("disabled", true);
										$("#minusmoq").attr("disabled", true);
										$("#moq").attr("disabled", true);
										$("#plushqty").attr("disabled", true);											
										$("#minushqty").attr("disabled", true);											
										$("#hqty").attr("disabled", true);	
										$("#hyperprice").attr("disabled", true);	
										$("#checkboxDqn_hyper").attr("disabled", true);	
										$("#moq_location").val("1");
										$("#pledges_values").hide();
										$("#update_hyper").hide();
										$("#return_policy").hide();
										$("#hypercant").hide();
										$("#add_hyper").show();
										$("#hyper_terms_summ").show();
									});									

									$("#update_hyper").click(function (e) {
										$('#update_hyper').html('Updating...');
										//alert("1");
										var moq = $("#moq").val();
										var moqcaf = $("#moqcaf").val();
										var hyperprice = $("#hyperprice").val();
										var hyper_duration = $("#hyper_duration").val();
										var owarehouse_id = $("#owarehouse_id").val();
										var hyper_terms = $("#hyper_terms").val();
										var hyper_id = $("#hyper_id").val();
										var parent_id = $("#parent_id").val();
										var states_hyper = $("#states_hyper").val();
										var cities_hyper = $("#cities_hyper").val();
										var areas_hyper = $("#areas_hyper").val();
										var del_world_v_hyper = $("#del_world_v_hyper").val();
										var del_malaysia_v_hyper = $("#del_malaysia_v_hyper").val();
										var del_sabah_v_hyper = $("#del_sabah_v_hyper").val();
										var del_sarawak_v_hyper = $("#del_sarawak_v_hyper").val();
										var del_width_hyper = $("#del_width_hyper").val();
										var del_height_hyper = $("#del_height_hyper").val();
										var del_lenght_hyper = $("#del_lenght_hyper").val();
										var del_weight_hyper = $("#del_weight_hyper").val();
										var del_option_hyper = $('input:radio[name=del_option_hyper]:checked').val();
										var states_biz_hyper = $("#states_biz_hyper").val();
										var cities_biz_hyper = $("#cities_biz_hyper").val();
										var areas_biz_hyper = $("#areas_biz_hyper").val();
										var del_pricing_hyper = $("#del_pricing_hyper").val();
										var hqty = $("#hqty").val();
										//alert("2");
										if(parseInt(moq) < parseInt(moqcaf) || parseInt(hqty) < parseInt(moq)){
											toastr.error("Maximum most be greater than MOQ");
										} else {
											if((parseInt(moq) % parseInt(moqcaf)) != 0 ||  (parseInt(hqty) % parseInt(moqcaf)) != 0 ){
												toastr.error("MOQ and Maximum most be multiples of MOQ/location");
											} else {
												$.ajax({
													url: "/updatehyperprice",
													type: "POST",
													data: {
														moq : moq,
														moqcaf : moqcaf,
														hyperprice : hyperprice,
														duration : hyper_duration,
														hyper_terms : hyper_terms,
														hqty : hqty,
														owarehouse_id : owarehouse_id,
														del_world_v_hyper : del_world_v_hyper,
														del_malaysia_v_hyper : del_malaysia_v_hyper,
														del_sabah_v_hyper : del_sabah_v_hyper,
														del_sarawak_v_hyper : del_sarawak_v_hyper,
														states_hyper : states_hyper,
														cities_hyper : cities_hyper,
														areas_hyper : areas_hyper,
														del_width_hyper : del_width_hyper,
														del_height_hyper : del_height_hyper,
														del_lenght_hyper : del_lenght_hyper,
														del_weight_hyper : del_weight_hyper,
														del_option_hyper : del_option_hyper,
														states_biz_hyper : states_biz_hyper,
														cities_biz_hyper : cities_biz_hyper,
														areas_biz_hyper : areas_biz_hyper,
														del_pricing_hyper : del_pricing_hyper,					
														hyper_id : hyper_id,
														parent_id : parent_id
													},
													async: false,
													success: function(response)
													{
														//alert("3");
														setTimeout(function(){
															$('#update_hyper').html('Updated');
															setTimeout(function(){
																$('#update_hyper').html('Go Hyper!');
																$('#myModal').modal('hide');
																$("#tab-product-detail").remove();			
																$("#myspinner").show();			
																$.ajax({
																	url: '{{ route('getmerchantproducts') }}',
																	cache: false,
																	method: 'GET',
																	data: {merchant_id: $('#merchant_id').val()},
																	success: function(result, textStatus, errorThrown) {
																		resetProductList(result);				
																	},
																	error: function (responseData, textStatus, errorThrown) {
																		console.log(errorThrown);
																		product_table = $("#tab-product-detail").DataTable({
																			'order': [],
																			'responsive': false,
																			'autoWidth': false,
																			"scrollX":true,
																			"aoColumnDefs": [
																				{"bSortable":false, "aTargets": [0,1,2]},
																			],
																			"columnDefs": [
																				{ "targets": "no-sort", "orderable": false },
																				{ "targets": "small", "width": "50px" },
																				{ "targets": "medium", "width": "80px" },
																				{ "targets": "large", "width": "120px" },
																				{ "targets": "blarge", "width": "200px" },
																				{ "targets": "xlarge", "width": "280px" }
																			]
																		});		
																		$("#myspinner").hide();	
																		$("#tab-product-detail").parents('div.dataTables_wrapper').first().show();				
																	}
																});																	
															},2000);
														}, 2000);
													},
													error: function(response){
														alert(response);
													}
												});
											}
										}
									});

									$('#hyperprice').number(true, 2);
									//$('#hqty').number(true, 2);
									//$('#deliveryqty').number(true, 2);	
									
									if(parseInt(pledgesqty)> 0){
										$("#hyper_div :input").attr("disabled", true);
										$("#hypercant").show();
									}
									
									$("#isreset").val(isreset);
									if(isreset == "1"){
										$("#reset_hyper").show();
										$("#reset_hyper").attr("disabled",false);
									}									
								}
                            }
                        }
                    })
                }

                //set title of popup according to detail
                function setTitle(detail_type){
                    if (detail_type == 'HSP') {
                        return 'B2B Price';
                    } else if (detail_type == 'DPR') {
                        return 'Delivery Price';
                    } else if (detail_type == 'DCV') {
                        return 'Delivery Coverage';
                    } else if (detail_type == 'PSP') {
                        return 'Product Specifications';
                    } else if (detail_type == 'SPP') {
                        return 'Special Price';
                    } else if (detail_type == 'HYSP') {
						return 'Hyper Price';
					}
                }
            });

            //------------------------------------------------//

            path = window.location.href;
            var url;
            url = '{{url('/cart/addtocart')}}';
            $('.cartBtn').click(function (e) {
                e.preventDefault();
                var price = $(this).siblings('input[name=price]').val();
                $.ajax({
                    url: url,
                    type: "post",
                    data: {
                        'quantity': $(this).siblings('input[name=quantity]').val(),
                        'id': $(this).siblings('input[name=id]').val(),
                        'price': price
                    },
                    success: function (data) {
                        $('.alert').removeClass('hidden').fadeIn(3000).delay(5000).fadeOut(5000);
                        $('.cart-info').text(data[1] + ' {{$currentCurrency}}' + price +
							" Successfully added to the cart");

                        if (data[0] < 1) {
                            $('.cart-link').text('Cart is empty');
                            $('.badge-cart').text('0');
                        } else {
                            $('.cart-link').text('View Cart');
                            $('.badge-cart').text(data[0]);
                        }
                    }
                });
            });
            $('.sub_section').on('change', function () {
                cbox = $(this);
                var id = cbox.data('id');
                if (cbox.is(':checked')) {
                    $('.product_section_' + id).prop('checked', true);
                } else {
                    $('.product_section_' + id).prop('checked', false);
                }
            });

			$('body').on('change','.del-val', function () {
				cbox = $(this);
				if (!cbox.is(':checked')) {
					alert_confirm=confirm("Warning! Unchecking 'O' will cause product to NOT appear in public.");
					if(!alert_confirm){
						cbox.prop('checked', true);
					}
				}
			});
			
            $('.product_section').on('change', function () {
                var cat_id = $(this).data('cat');
                var status = $(this).is(':checked');
                if (status) {
                    var newstat = true;
                    $('.product_section_' + cat_id).each(function () {
                        if ($(this).is(':checked') != true) {
                            $('.sub_section_' + cat_id).prop('checked', false);
                            newstat = false;
                        }
                    });
                    if (newstat) {
                        $('.sub_section_' + cat_id).prop('checked', true);
                    }
                } else {
                    $('.sub_section_' + cat_id).prop('checked', false);
                }
            });
			
			$("#album_content").show();
			$("#album_wait").hide();
            //ends
        })
        ;
    </script>
{{-- Enable disable SMM checkbox --}}
    <script type="text/javascript">
            $(document).ready(function(){
                @foreach($profile_products as $p)
                    $('.marker_{{$p->id}}').change(function(){
                        if (this.checked) {
                            $('.marker_{{$p->id}}_s').prop('disabled',false);
                        };
                        if (!this.checked) {
							
                            $('.marker_{{$p->id}}_s').prop('disabled',true);
                            $('.marker_{{$p->id}}_s').attr('checked',false);
                        };
                    });
                @endforeach
            });
    </script>
    <script type="text/javascript">

        


        function clearValues() {
            $('input[type="text"]').val('');
        }
        $("#categoryId").on('change', function (e) {

            var categoryId = $('select[name=categoryId]').val();
            var loader = $('.loader');
            var batchOption = $('#subCategoryId');
            $.ajax({
                url: 'selectCategoryWiseSubCategory/' + categoryId,
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    loader.show();
                },
                success: function (data) {
                    batchOption.empty();
                    batchOption.append('<option value="" selected disabled>Please select</option>');
                    $.each(data, function (index, value) {
                        batchOption.append('<option value="' + value.id + '">' + value.description + '</option>');
                    });
                    loader.hide();
                },
                error: function (data) {
                    alert('error occurred! Please Check');
                    loader.hide();
                }
            });

        });
        //time------Slot-----------------//
		$(".table_voucher_timeslot").on("click", ".deleteTimeSlot", function () {
			$(this).parent().parent().parent().remove();


		});
        $(".deleteTimeSlot").on('click', function () {
//            $('.deleteTimeSlot').parents("tr").remove();
        });
        function selectTimeSlot() {
            $('input[class=case4]:checkbox').each(function () {
                if ($('input[class=checkTimeSlot]:checkbox:checked').length == 0) {
                    $(this).prop("checked", false);
                } else {
                    $(this).prop("checked", true);
                }
            });
        }

        function checkTimeSlot() {
            obj = $('.tableSchedule tr').find('span');
            $.each(obj, function (key, value) {
                id = value.id;
                $('#' + id).html(key + 1);
            });
        }
		
        $("#formVoucher").submit(function (e) {

            $("body").addClass("loading");

            $("#errors_voucher").hide();
            $("#success_voucher").hide();
            $("#errors_voucher_product").html('');
            $("#errors_voucher_brand").html('');
            $("#errors_voucher_timeslot").html('');
            $("#errors_voucher_category").html('');
            $("#errors_voucher_sub_category").html('');
            $("#errors_voucher_retail_price").html('');
            $("#errors_voucher_address").html('');
            $("#error_zip").html('');
            $("#error_city").html('');
            $("#error_state").html('');


            e.preventDefault();
            var form = $('#formVoucher')[0]; // You need to use standart javascript object here
            var formData = new FormData(form);
            $.ajax({
                url: $('#formVoucher').attr('action'),
                data: formData,
                type: "POST",
                datatype: "JSON",
                // THIS MUST BE DONE FOR FILE UPLOADING
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response);
                    $('input[type="text"]').val('');
                    $('select').val('');
                    $("#success_voucher").show();
                    $("#errors_voucher").hide();
                    $("body").removeClass("loading");
                },
                error: function (response) {
                    $("body").removeClass("loading");
                    $("#success_voucher").hide();
                    $("#errors_voucher").show();
                    /*if (response.responseJSON.productName !="") {
                     $("#errors_voucher").html('<p>Product name is required</p>');
                     }*/
                    $("#errors_voucher_product").html(response.responseJSON.productName);
                    $("#errors_voucher_brand").html(response.responseJSON.Brand);
                    $("#errors_voucher_category").html(response.responseJSON.categoryId);
                    $("#errors_voucher_sub_category").html(response.responseJSON.subCategoryId);
                    $("#errors_voucher_retail_price").html(response.responseJSON.retail_price);
                    $("#errors_voucher_address").html(response.responseJSON.address);
                    $("#errors_voucher_timeslot").html(response.responseJSON.timeslot);
					$("#error_state").html(response.responseJSON.state);
					$("#error_city").html(response.responseJSON.city);
					$("#error_zip").html(response.responseJSON.zip_code);
					$("#error_country").html(response.responseJSON.country);


                }

            })

        });

		$('#mstates').on('change', function () {
			$(this).removeClass('error');
			$(this).siblings('label.error').remove();
			var val = $(this).val();
			if (val != "") {
				var text = $('#mstates option:selected').text();
				$.ajax({
					type: "post",
					url: JS_BASE_URL + '/city',
					data: {id: val},
					cache: false,
					success: function (responseData, textStatus, jqXHR) {
						if (responseData != "") {
							$('#mcities').html(responseData);
						}
						else {
							$('#mcities').empty();
							$('#select2-mcities-container').empty();
						}
					},
					error: function (responseData, textStatus, errorThrown) {
						alert(errorThrown);
					}
				});
			}
			else {
				$('#select2-mcities-container').empty();
				$('#mcities').html('<option value="" selected>Choose Option</option>');
			}
		});
		/*add discount scripts*/
		$("#discountForm").submit(function (e){
			$("#form_submit_button").val("Submitting");
			$("#form_submit_button").attr("disabled",true);
			e.preventDefault();
			$("#msg_error").hide();
			$("#msg_sucess_discount").hide();
			var product=$('select[name="discount_product"]').val();
			var duration=$('input[name="discount_duration"]').val();
			var start_date=$('input[name="discount_start_date"]').val();
			var quantity=$('input[name="discount_quantity"]').val();
			var percentage=$('input[name="discount_percentage"]').val();
			console.log("DISCOUUUUUNTTTTTTT");
			$.ajax({
				type : "POST",
				url : JS_BASE_URL+"/merchant/addNewDiscount",
				data: new FormData( this ),
				processData: false,
				contentType: false,
				success : function(response){
					$("#msg_error").hide();
					$("#err_discount_product").html('');
					$("#err_discount_start_date").html('');
					$("#err_discount_duration").html('');
					$("#err_discount_quantity").html('');
					$("#err_discount_percentage").html('');
					$("#err_discount_image").html('');
					if (response=='1') {
						clearValues();
                        //$("#msg_sucess_discount").show();
                        toastr.success("Discount added successfully");
					//	get_discounts();
					}else{
						$("#msg_error").show();
					}
				},
				error:function(response){
					$("#form_submit_button").val("Submit");
					$("#form_submit_button").attr("disabled",false);
					$("#msg_error").show();
					$("#err_discount_product").html('');
					$("#err_discount_start_date").html('');
					$("#err_discount_duration").html('');
					$("#err_discount_quantity").html('');
					$("#err_discount_percentage").html('');
					$("#err_discount_image").html('');
					$("#err_discount_image").html(response.responseJSON.discount_image);
					$("#err_discount_product").html(response.responseJSON);
					$("#err_discount_start_date").html(response.responseJSON.discount_start_date);
					$("#err_discount_duration").html(response.responseJSON.discount_duration);
					$("#err_discount_quantity").html(response.responseJSON.discount_quantity);
					$("#err_discount_percentage").html(response.responseJSON.percentage);

				}
			});
		});

		function clearValues(){
			$('input[name="discount_duration"]').val('0');
			$('input[name="discount_durationff"]').val('0');
			$('input[name="discount_start_date"]').val('');
			$('input[name="discount_quantityff"]').val('0');
			$('input[name="discount_quantity"]').val('0');
			$('input[name="discount_percentage"]').val('0');
			$('#txt_remarks').val('');
            $('input[name="percentage"]').val('0');
			$("#form_submit_button").val("Submit");
			$("#form_submit_button").attr("disabled",false);
			$("#msg_sucess").hide();
			$("#imagePreviewDiscount").css('background-image', "url('" + JS_BASE_URL + "/images/discount/default/default.jpg')");
		}

		function change_val(str, item) {
			console.log(item);
			var curr_val = parseInt($('input[name="'+item+'ff'+'"]').val());
			console.log(curr_val);
			$('input[name="'+item+'"]').val(curr_val);
		}
		function decrease_val(str, item) {
			var plural = '';
			var curr_val = parseInt($('input[name="'+item+'"]').val());
			if (curr_val > 0) {
				curr_val = curr_val - 1;
				//plural = (curr_val > 1) ? "s" : "";
				$('input[name="'+item+'ff'+'"]').val(curr_val+' '+str+plural);
				$('input[name="'+item+'"]').val(curr_val);
			}
		};
		function increase_val(str, item) {
			//console.log(item);
			var plural = '';
			var curr_val = parseInt($('input[name="'+item+'ff'+'"]').val());
			if (curr_val<9999) {
				console.log(curr_val);
                curr_val = curr_val + 1;
                //plural = (curr_val > 1) ? "s" : "";
                $('input[name="'+item+'ff'+'"]').val(curr_val+' '+str+plural);
                $('input[name="'+item+'"]').val(curr_val);
            }
		};
		function discount_percentage(){
			var curr_val = parseInt($('input[name="discount_percentage"]').val());
			$('input[name="percentage"]').val(curr_val);
		}
		function discount_percentage_inc(){
			var curr_val = parseInt($('input[name="discount_percentage"]').val());
            if (curr_val <100) {
    			curr_val = curr_val + 1;
    			$('input[name="percentage"]').val(curr_val);
    			$('input[name="discount_percentage"]').val(curr_val+"%");
            }
		};

		function discount_percentage_dec(){
			var curr_val = parseInt($('input[name="discount_percentage"]').val());
			if (curr_val > 0) {
				curr_val = curr_val - 1;
				$('input[name="percentage"]').val(curr_val);
				$('input[name="discount_percentage"]').val(curr_val+"%");
			}
		};
		$('input[name="discount_percentage"]').blur(function(){
			var curr_val = parseInt($('input[name="discount_percentage"]').val());


			$('input[name="percentage"]').val(curr_val);
			$('input[name="discount_percentage"]').val(curr_val+"%");

		});
        $('#uploadBtnDiscount').on("change", function () {
                id=$(this).attr('id');
                var files=""
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function () { // set image data as background of div

                        $("#imagePreviewDiscount").css("background-image","url("+this.result+")");
                        $("#imagePreviewDiscount").css("background-repeat", "round");
                    }
                }
            });
        $('#uploadBtnVoucher').on("change", function () {
                id=$(this).attr('id');
                var files=""
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function () { // set image data as background of div

                        $("#imagePreviewVoucher").attr("src",this.result);
                        //$("#imagePreviewVoucher").css("background-repeat", "round");
                    }
                }
            });
    </script>
	<script>
	$(document).ready(function(){
	    $('#plus_b2b').on('click', function () {
            var rp = parseInt($('#rPrice_p').text());
            var op = $('#oPrice').val();
            var fq = $('#checkboxDqnb2b').val();
            if(fq == ""){
                fq = "0";
            }
            if(op == "" || op == 0){
                op = rp;
            }
            var amount = parseFloat(op);
            var del = $('#del_malaysia_v_b2b').val();
            if(del == ""){
                del = 0;
            }
            del = parseFloat(del);
            var cant =  parseInt($("#cantp_b2b").val());
            cant++;
            $("#cantp_b2b").val(cant);
            if(cant>=parseInt(fq) && parseInt(fq) > 0){
                del = 0;
                $('#retail_delivery').text(0).number(true, 2);
            }
            var total =  amount;

            $("#retail_amount").text((amount*cant)+del).number(true, 2);
            $("#retail_total").text((total*cant)+del).number(true, 2);
        });
      $('#minus_b2b').on('click', function () {
            var rp = $('#rPrice_p').val();
            var op = $('#oPrice').val();
            if(op == "" || op == 0){
                op = rp;
            }
            var fq = $('#checkboxDqnb2b').val();
            if(fq == ""){
                fq = "0";
            }
            var amount = parseFloat(op);
            var del = $('#del_malaysia_v_b2b').val();
            if(del == ""){
                del = 0;
            }
            del = parseFloat(del);
            var cant =  parseInt($("#cantp_b2b").val());
            cant--;
            if (cant > 0) {
                if(cant<parseInt(fq) && parseInt(fq) > 0){
                    del = $('#del_malaysia_v_b2b').val();
                    $('#retail_delivery').text(del).number(true, 2);
                    del = parseFloat(del);
                } else {
                    if(parseInt(fq) > 0){
                        del = 0;
                    }
                }
                $("#cantp_b2b").val(cant);
                var total =  amount + del;
                $("#retail_amount").text((amount*cant)+del).number(true, 2);
                $("#retail_total").text((total*cant)+del).number(true, 2);
            }
        });

    var exceptUser = [];
	var kw = 0;
	var count = 100;
    $('.userid').each(function(){
		console.log("in validation");
        exceptUser[kw] = $(this).attr('user');
        kw++;
        if (count < kw) return false;
    });
	console.log(exceptUser);
    var options = {
        url: "{{ route('jsonusers') }}",
        getValue: "name",
        template: {
            type: "custom",
            method: function(value, item) {
                return "<span class='ulist' rel='"+ item.id + "' />"+ item.name +"</span>";
            }
        },		
        list: {
            match: {
              enabled: true
            },
            onLoadEvent : function () {
                $('.ulist').each(function(){
                    data = $(this).attr('rel');
                    if(jQuery.inArray(data, exceptUser) != -1) {
                        $(this).parents('li').remove();
                    }
                })
            },			
            onClickEvent: function() {
                var id = $("#userID-0").getSelectedItemData().id;
                var justid = $("#userID-0").getSelectedItemData().justid;
                var username = $("#userID-0").getSelectedItemData().username;
				if(id != "0"){
					$("#userID-0").attr('user', id);
					$("#userID-0").val(id);
					$("#userName-0").val(username);
					$("#userID-0").removeClass('errorBorder');
					$('#userName-0').removeClass('errorBorder');
					$('#addspp').removeClass('die');
					//var current = $('#currentspp').val();
					/*console.log(current);
					console.log(justid);*/
					$("#userid0").val(justid);
				}
            }
        }
    };

	$("#userID-0").on('change', function () {
		$("#userid0").val($(this).val());
		$('#addspp').removeClass('die');
	});

    $('input.myr-price').number(true, 2);
    $("input.numeric").on('keypress', checkValidationNumeric);

    function pad (str, max) {
      str = str.toString();
      return str.length < max ? pad("0" + str, max) : str;
    }

    $("#addspp").on('click', function () {
        rowNo = parseInt($('tr.srow').last().attr('data'));
        rid = rowNo + 1;
		$('#currentspp').val(rid);
        lastRowPrice = parseInt($('#sprice-'+rowNo).val());
        lastRowID = $('#userID-'+rowNo).val();
		lastRowUnit = parseFloat($('#spwunit'+rowNo).val());
		$('#spwfunitn'+rid).val(lastRowUnit+1);		
        if (0 < lastRowPrice && lastRowPrice != null && lastRowID != null && lastRowID != '') {
            $('#addRowLabelSpecial').addClass('hidden');
			prevval = lastRowUnit + 1;
            route = $('#routeFetchFieldsForSpecialPrice').val();
            $.ajax({ type: "POST", url: route, data: {id : rid, val: prevval, lastid: lastRowID}, success: function(result){
                $("#sppTable > tbody").append(result);
                $('#userID-'+rowNo).removeClass('errorBorder');
                $('#sprice-'+rowNo).parents('.input-group').removeClass('errorBorderIng');
                $('.remspp').each(function(){
                    $(this).addClass('die');
                })

            $('.remspp').last().removeClass('die');

            }});
        } else {
            $('#addRowLabelSpecial').removeClass('hidden');
            if ((0 >= lastRowPrice || lastRowPrice == null || isNaN(lastRowPrice))) {
                $('#sping-'+rowNo).addClass('errorBorderIng');
            } else {
                $('#sping-'+rowNo).removeClass('errorBorderIng');
            }

            if ((lastRowID == null || lastRowID == '')) {
                $('#userID-'+rowNo).addClass('errorBorder');
            } else {
                $('#userID-'+rowNo).removeClass('errorBorder');
            }
        }
    });

    $('#sprice-0').on('keyup', function() {
        $('#sping-0').siblings('.errorT').remove();
        rprice = parseFloat($("#rPrice").val());
        if (isNaN(rprice)) {
            rprice = 0 ;
            $('#errsx').removeClass('hidden');
            $('#sprice-0').val(null);
            return false;
        } else {
            $('#errsx').addClass('hidden');
        }
    })

    $('#userID-0').on('keyup', function() {
        $('#userID-0').siblings('.errorT').remove();
    })

    $('#wunit0').on('keyup', function() {
        $(this).siblings('.errorT').remove();
    })

    $('#sprice-0').on('blur',function(){
        $('#addRowLabelSpecial').addClass('hidden');
        price = parseFloat($('#sprice-0').val());
        rprice = parseFloat($("#rPrice").val());

        if (0 < price && price != null && (price < rprice || rprice == 0)) {
            $('#sping-0').removeClass('errorBorderIng');
            $('#errsp-0').addClass('hidden');
            $('#addssp').removeClass('die');
            margin = calculateMargin(price);
			if(rprice == 0){
				$('#smar-0').text("N.A");
			} else {
				$('#smar-0').text(margin);
			}
            
            $('#userID-0').removeAttr('disabled');
        } else {
            if ($('#errsx').hasClass('hidden') == 1) {
                $('#sprice-0').val(null);
                $('#sping-0').addClass('errorBorderIng');
                $('#errsp-0').removeClass('hidden');
                $('#addssp').addClass('die');
                $('#spp-0').text(rprice);
                $('#smar-0').text("0.0");
                $('#userID-0').attr('disabled');
            }
        }
    })

    $("#addrsp").on('click', function () {
		var wholesaleprices = $("#wholesaleprices").val();
		wholesaleprices = parseInt(wholesaleprices) + 1;
		$("#wholesaleprices").val(wholesaleprices);
        rowNo = parseInt($('tr.wrow').last().attr('data'));
        rid = rowNo + 1;
        lastRowUnit = parseFloat($('#wunit'+rowNo).val());
        lastRowPrice = parseFloat($('#wprice-'+rowNo).val());
		$('#wfunitn'+rid).val(lastRowUnit+1);

        if (0 < lastRowPrice && lastRowPrice != null && 0 < lastRowUnit && lastRowUnit != null) {
            $('#addRowLabel').addClass('hidden');
            prevval = lastRowUnit + 1;
            route = $('#routeFetchFields').val();
            $.ajax({ type: "POST", url: route, data: {id : rid, pre : prevval}, success: function(result){
                $("#wrpTable > tbody").append(result);
                $('.remrsp').each(function(){
                $(this).addClass('die');
            })

            $('.remrsp').last().removeClass('die');
			$('#wprice-'+rowNo).attr("disabled",true);
            }});
            $('input.myr-price').number(true, 2);
            $("input.numeric").on('keypress', checkValidationNumeric);

        } else {
            $('#addRowLabel').removeClass('hidden');

            if ((0 >= lastRowPrice || lastRowPrice == null || isNaN(lastRowPrice))) {
                $('#wping-'+rowNo).addClass('errorBorderIng');
            } else {
                $('#wping-'+rowNo).removeClass('errorBorderIng');
            }

            if ((lastRowUnit == null || isNaN(lastRowUnit) || lastRowUnit < 0)) {
                $('#wunit-'+rowNo).addClass('errorBorder');
            } else {
                $('#wunit-'+rowNo).removeClass('errorBorder');
            }
        }
    });
    $("#wrpTable").on('click', '.remrsp', function () {
        id = parseInt($(this).attr('rel'));
        $('#wrow-'+id).remove();
		currentwp = parseInt($("#wholesaleprices").val());
		$("#wholesaleprices").val(currentwp-1);
		$("#wholesale" + id).val("0");
		$("#wfunitn" + id).val("0");
		$("#wunitn" + id).val("0");
        var i = 0;
        $('.wholesalep').each(function(){
            $(this).attr('rel', i);
            $(this).attr('id', 'wprice-'+i);
            i++;
        })

        var j = 0;
        $('.wunit').each(function(){
            $(this).attr('rel', j);
            $(this).attr('id', 'wunit'+j);
            j++;
        })

        var k = 0;
        $('.wrow').each(function(){
            $(this).attr('data', k);
            $(this).attr('id', 'wrow-'+k);
            k++;
        })

        var l = 0;
        $('.wfunit').each(function(){
            $(this).attr('id', 'wfunit'+l);
            l++;
        })

        var m = 1;
        $('.remrsp').each(function(){
            $(this).attr('rel', m);
            m++;
        })

        $('.remrsp').last().removeClass('die');
        $('.wholesalep').last().attr('disabled',false);
    });

	$('.wholesalep').on('blur',function(){
		//alert("1");
		$('#addRowLabel').addClass('hidden');
		thisUnit = parseInt($(this).attr('rel'));
		if(thisUnit > 0){
			prevUnit = parseInt(thisUnit) - 1;
			price = parseFloat($('#wprice-'+thisUnit).val());
			prevPrice = parseFloat($('#wprice-'+prevUnit).val());
			if(price == null){
				price = parseFloat($('#rPrice_p').text());
			}			
			if (0 < price && price != null && price < prevPrice && price > 0) {
				$('#wping-'+thisUnit).removeClass('errorBorderIng');
				$('#errp-'+thisUnit).addClass('hidden');
				margin = calculateMargin(price);
				//console.log(margin);
				rprice = parseFloat($("#rPrice").val());
				if(rprice == 0){
					$('#mar-'+thisUnit).text("N.A");
				} else {				
					//console.log("HERE I AM");
					$('#mar-'+thisUnit).text(margin);
					//$('#wprice-'+thisUnit).attr("disabled",true);
				}
			} else {
				if(price < 1){
					prevPrice = 1;
				}
				$('#wprice-'+thisUnit).delay(1200).val(null);
				$('#wping-'+thisUnit).addClass('errorBorderIng');
				$('#errp-'+thisUnit).removeClass('hidden');
				$('#p-'+thisUnit).text(prevPrice);
			}			
		}
	})	
	
    $('.wunit').on('blur', function(){
        $('#addRowLabel').addClass('hidden');
        thisUnit = parseInt($(this).attr('rel'));
        fromUnit = parseInt($('#wfunit'+thisUnit).val());
        toUnit = parseInt($('#wunit'+thisUnit).val());
		//console.log("in validation");
        executeWunit(thisUnit, fromUnit, toUnit);
    })

    $('#wfunit0').on('blur', function(){
        $('#addRowLabel').addClass('hidden');
        thisUnit = parseInt($(this).val());
        if (thisUnit <= 0) {
            $("#ferr-0").removeClass('hidden');
            $(this).addClass('errorBorder');
            $("#wunit0").addClass('die');
        } else {
            $("#ferr-0").addClass('hidden');
            $(this).removeClass('errorBorder');
            $('#wunit0').removeClass('die');
        }
    })

    function executeWunit(thisUnit, fromUnit, toUnit) {
        if (fromUnit < toUnit && toUnit != null) {
            $('#wunit'+thisUnit).removeClass('errorBorder');
            $('#wping-'+thisUnit).removeClass('errorBorderIng');
            $('#err-'+thisUnit).addClass('hidden');
            $('#wprice-'+thisUnit).removeAttr('disabled');
        } else {
            $('#wunit'+thisUnit).val(null);
            $('#wunit'+thisUnit).addClass('errorBorder');
            $('#err-'+thisUnit).removeClass('hidden');
            $('#pu-'+thisUnit).text(fromUnit);
            $('#wping-'+thisUnit).attr('disabled', 'disabled');
        }
    }


    $('#wprice-0').on('keyup', function() {
        $('#wping-0').siblings('.errorT').remove();
        rprice = parseFloat($("#rPrice").val());
        if (isNaN(rprice)) {
            rprice = 0 ;
            $('#errx').removeClass('hidden');
            $('#wprice-0').val(null);
            return false;
        } else {
            $('#errx').addClass('hidden');
        }
    })

    $('#wprice-0').on('blur',function(){
        $('#addRowLabel').addClass('hidden');
		console.log($('#wprice-0').val());
        price = parseFloat($('#wprice-0').val());
        rprice = parseFloat($("#rPrice").val());
		//console.log("price" + price);
		//console.log("rprice" + rprice);
		if(price == null){
			price = parseFloat($('#rPrice_p').text());
		}
        if (0 < price && price != null && price < rprice && price > 0) {
            $('#wping-0').removeClass('errorBorderIng');
            $('#errp-0').addClass('hidden');
            $('#addrsp').removeClass('die');
            margin = calculateMargin(price);
			if(rprice == 0){
				$('#mar-0').text("N.A");
			} else {
				$('#mar-0').text(margin);
				//$('#wprice-0').attr("disabled",true);
			}
            
        } else {
            if ($('#errx').hasClass('hidden') == 1) {
                $('#wprice-0').val(null);
                $('#mar-0').text("0.0");
                $('#wping-0').addClass('errorBorderIng');
                $('#errp-0').removeClass('hidden');
                $('#addrsp').addClass('die');
                $('#p-0').text(rprice);
            }
        }
    })

    function calculateMargin(price) {
        rprice = parseFloat($("#rPrice").val());
        margin = 0;
		//console.log(price);
		//console.log(rprice);
        if ( price < rprice ) {
            margin = ((rprice - price)/rprice) * 100;
        } else {
            margin = 0;
        }
		//console.log(margin);
        if(margin>99.99){margin=99.99};
        return number_format(margin, 2);
    }

    function number_format(number, decimals, dec_point, thousands_sep)
    {
      number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
      var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
          var k = Math.pow(10, prec);
          return '' + (Math.round(n * k) / k).toFixed(prec);
        };
      // Fix for IE parseFloat(0.55).toFixed(0) = 0;
      s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
      if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
      }
      if ((s[1] || '')
        .length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
      }
      return s.join(dec);
    }

    function checkValidationNumeric(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            $("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    }


    $('#send').click(function(){
        $('#productRegForm').validate();
        if ($('#productRegForm').valid()){
            data = $('#productRegForm').serializeArray();
            $.ajax({
                url : "{{ route('albumpost') }}",
                type : "POST",
                data : data,
                cache: false,
                enctype:'multipart/form-data',
                datatype: "json",
                success: function() {
                    $('html, body').animate({
                        scrollTop: $(this).offset().top
                    }, 1000);
                    return false;
                }
            })
        }
    });
	});
	</script>
<script type="text/javascript">
$(document).ready(function(){
    $('#B2B').click(function(e){
        e.preventDefault();
 $(this).tab('show');
    });
});                                    
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.delivery_waiver_min_amt').on("change paste keyup",function(){
            
            var value=$(this).val();
            $('.delivery_waiver_min_amt').val(value);
           
            
        });
		
		$('.delivery_waiver_min_amt_b2b').on("change paste keyup",function(){
            
            var value=$(this).val();
            $('.delivery_waiver_min_amt_b2b').val(value);
           
            
        });
      /* Code for validation of name in merchant album page This same code is also used in edit / add new*/
$("#voucher_expiry").datepicker({
    minDate:0
});
 $(".album_product_name_validation").on("blur",function(){
        $(this).addClass('loadinggif');
        $url="{{url('product/exists/name')}}";
        name=$(this).val()
      /*  $('.name_p').html(name);
        $('#name_p').html(name);*/
        $.ajax({
        type: "POST",
        url:$url,
        data:{
            name:name
        },
        cache: false,
        success: function (responseData, textStatus, jqXHR) {
            if (responseData.status == "success") {
                /*Product with name exists*/
                tmp=`

                    <a target="_blank "href="`+JS_BASE_URL+"/productconsumer/"+responseData.id+`">`+responseData.name+`</a>`;
                $(".pex").text("");
                $(".pex").append(tmp);
                $("#productnamevalid").val("false")
                $("confirm").find("input").prop('disabled', 'disabled');
                $("#submit_button").prop('disabled', 'disabled');
            }else{
                $(".pex").text("");
                $("#productnamevalid").val("true")
                 $("confirm").find("input").prop('disabled',false);
                $("#submit_button").prop('disabled',false);
            }
            $(this).removeClass('loadinggif');
             // $("#overlay_spinner_email").css("display", "none");
        },
        error: function (responseData, textStatus, errorThrown) {
            console.log(errorThrown);
        }
        });
    });
    });
</script>
@stop

