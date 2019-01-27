<div id="voucher_tabs" class="panel with-nav-tabs panel-default">
	<div class="panel-heading" style="font-size: 18px;">
		<ul class="nav nav-tabs">
			<li class="active" >
				<a  data-toggle="tab" class='tab-link'
					id='v1'
					style="color: #000; font-size:18px;margin-right:0"
					href="#content-v1">Scheduled
				</a>
			</li>
			<li>
				<a  data-toggle="tab" class='tab-link'
					id='v2'
					style="color: #000; font-size:18px;margin-left: 0px; margin-right: 0px; padding-left: 20px; padding-right: 20px;"
					href="#content-v2">Ordinary
				</a>
			</li>
		</ul>
	</div>
</div>
<div class="tab-content">
	<div id="content-v1" class='tab-pane fade in active'>
		<div class="col-sm-12" style="margin-bottom:0;margin-top:0">
			@include('voucher.add_v1_voucher')
		</div>
	</div>
	<div id="content-v2" class='tab-pane fade'>
		<div class="col-sm-12" style="margin-bottom:0;margin-top:0">
			@include('voucher.add_v2_voucher')
		</div>
	</div>
</div>
<div class="col-sm-12">
		<div id="commentssv">
		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist" style="background: #e7e7e7;" >
			<li role="presentation" class="active"><a href="#commentsv" aria-controls="commentsv" role="tab" data-toggle="tab" style="color: #000; font-size:18px;margin-left:0;margin-right:0">Comments</a></li>
			{{--
			<li role="presentation"><a href="#sellerinfov" aria-controls="sellerinfov" role="tab" data-toggle="tab" style="color: #000; font-size:18px;margin-left:0;margin-right:0">Seller Info</a></li>
			--}}
			<li role="presentation"><a href="#sellerpolicyv" aria-controls="sellerpolicyv" role="tab" data-toggle="tab" style="color: #000; font-size:18px;margin-left:0;margin-right:0">Seller Policy</a></li>
			<li role="presentation"><a href="#osmallpolicyv" aria-controls="osmallpolicyv" role="tab" data-toggle="tab" style="color: #000; font-size:18px;margin-left:0;margin-right:0">OpenSupermall Policy</a></li>
		  </ul>

		  <!-- Tab panes -->
		  <div class="tab-content">
			<div role="tabpanel" class="tab-pane active"id="commentsv" >
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
			
			{{--
			<div role="tabpanel" class="tab-pane" id="sellerinfov">
				<div class="col-sm-12" style="margin-bottom:20px">
					<div class="row">
						<h2 style="margin-left:9px">Seller Information</h2>
						<div class="col-sm-6 col-xs-12 table-responsive">
							<table class="table pseller">
								<tr><td>Seller Name</td><td>{{ $merchant->company_name }}</td></tr>
										<tr><td>Ship form Address</td><td>
											@if(!is_null($addressm))
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
											@if(!is_null($citym))
												{{strip_tags($citym->name)}}
											@endif														
									</td></tr>
								<tr><td>Return / Exchange Address:</td><td>
											@if(!is_null($oaddressm))
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
											@if(!is_null($ocitym))
												{{strip_tags($ocitym->name)}}
											@endif													
										</td></tr>
							</table>
						</div>							
					</div>
				</div>
			</div>
			--}}

			<div role="tabpanel" class="tab-pane" id="sellerpolicyv">
				<div class="col-sm-12" style="margin-bottom:20px">
					<div class="row">
						<h2 style="margin-left:9px">Seller Policy</h2>
						<div class="col-xs-12">
							{!! Form::textarea('merchant_policyv', $merchant->return_policy, array('class' => 'form-control','id'=>'info-merchantpolicyvoucher'))!!}
						</div>
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="osmallpolicyv">
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

