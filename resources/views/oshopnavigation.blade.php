<?php use App\Http\Controllers\IdController;?>
<style type="text/css">
/*   .panel-heading .nav li a:focus {
        background-color: #1abc9c;
        color: #fff;
   }*/
  .panel-heading ul { background: #fff; }

	.nav-tabs > li > .autolink_validation:hover {
	  background-color: transparent;
	}
	
	.badge1[data-badge]:after {
	   content:attr(data-badge);
	   position:absolute;
	   top:-10px;
	   right:-10px;
	   font-size:.7em;
	   background:red;
	   color:white;
	   width:18px;height:18px;
	   text-align:center;
	   line-height:18px;
	   border-radius:50%;
	   box-shadow:0 0 1px #333;
	}	
	
	.badge1[data-badge=””]:after {
		content: none;
	}	
</style>
<div class="panel-heading" style="padding-top:0;font-size: 18px;">
	<ul id="tab-list" class="nav nav-tabs">
		<li class="active tablist tablistretail" rel="retail">
            <a  data-toggle="tab" class='tab-link'
				style="color: #000; font-size:18px;margin-left:0;margin-right:0"
				id='retail'>Retail
			</a>
		</li>
		@if(count($categoriesb2b) > 0)
		<li class="tablist tablistb2b" rel="B2B" id="b2bref">
            <a  data-toggle="tab" class='tab-link'
            	id='B2B' style="color: #000;font-size:18px;margin-left:0;margin-right:0;padding-left:20px;padding-right:20px;"
				>B2B
			</a>
        </li>	
		@else
			<li>
				<p
					style="color: #666; font-size:18px;margin-left:0;margin-right:0;margin-top: 3px;padding-left: 20px; padding-right: 20px; padding-top: 10px; padding-botton: 10px;" title="No B2B Products defined" class="autoclass"
					href="javascript:void(0);">B2B
				</p>
			</li>			
		@endif		
		@if(count($merchantvouchers) > 0)
		<li class="tablist tablistvoucher" rel="voucher" class="onlytab">
			<a  data-toggle="tab" class='tab-link'
				id='voucher'
				style="color: #000; font-size:18px;margin-left:0;margin-right:0;padding-left: 10px; padding-right: 10px;"
				href="#content-Voucher">Voucher
			</a>
		</li>
		@else
			<li class="onlytab">
				<p
					style="color: #666; font-size:18px;margin-left:0;margin-right:0;padding-left: 20px; padding-right: 20px; padding-top: 10px; padding-botton: 10px;" title="No Voucher Products defined" class="autoclass"
					href="javascript:void(0);">Voucher
				</p>
			</li>			
		@endif		
		@if(count($ow_product) > 0)
		<li class="tablist tablisthyper" rel="hyper" class="onlytab">
			<a  data-toggle="tab" class='tab-link'
				id='hyper'
				style="color: #000; font-size:18px;margin-left:0;margin-right:0;"
				href="#content-Hyper">Hyper
			</a>
		</li>
		@else
			<li class="onlytab">
				<p
					style="color: #666; font-size:18px;margin-left:0;margin-right:0;padding-left: 20px; padding-right: 20px; padding-top: 10px; padding-botton: 10px;" title="No Hyper Products defined" class="autoclass"
					href="javascript:void(0);">Hyper
				</p>
			</li>			
		@endif
		@if(count($smmProducts) > 0)
			<li class="tablist tablistsmm" rel="smm" class="onlytab">
				<a  data-toggle="tab" class='tab-link'
					id='smm'
					style="color: #000; font-size:18px;margin-left:0;margin-right:0;padding-left: 20px; padding-right: 20px;"
					href="#content-SMM">SMM
				</a>
			</li>
		@else
			<li class="onlytab">
				<p
					style="color: #666; font-size:18px;margin-left:0;margin-right:0;margin-top: 3px;padding-left: 20px; padding-right: 20px; padding-top: 10px; padding-botton: 10px;" title="No SMM Products defined" class="autoclass"
					href="javascript:void(0);">SMM
				</p>
			</li>
			
		@endif
		@if(!is_null($specialproducts))
			@if(count($specialproducts) > 0)
				<li >
					<a  data-toggle="tab" class='tab-link'
						id='special'
						style="color: #000; font-size:18px;margin-left:0;margin-right:0;padding-left: 10px; padding-right: 10px;"
						href="#content-special">Special
					</a>
				</li>
			@endif
		@endif		
		<li class="pull-right" style="height:45px">
				<?php $formatted_merchant_id = IdController::nOshop($oshop_id); ?>
			<p style="margin-bottom:0; margin-top: 3px;">
			<span class="formattedid">O-Shop ID: {{$formatted_merchant_id}}&nbsp;&nbsp;</span>
			@if(Auth::check() && $canautolink)
				@if($autolink_status == 0 && $immerchant != $id)
					@if($autolink_requested == 0)
						<button type="button"
							data-button="{{$merchant->id}}"
							class="btn btn-success btn-lg autoclass"
							id="autolink_btn"
							style="background:rgb(0,99,98);color:#fff;right:0;margin-top:1px; right: 0px; padding-bottom: 7px; padding-top: 7px;" title="Press to get B2B and Special pricing">
							<span><img height="27" width="27"
								src="/images/bike-chain.png">&nbsp;</span>
							AutoLink
						</button>
						<button type="button"
							data-button="{{$merchant->id}}"
							class="btn btn-success btn-lg autoclass"
							id="cancel_autolink"
							style="background:#fff;color:rgb(0,99,98);right:0;margin-top:1px; right: 0px; padding-bottom: 7px; padding-top: 7px; display: none;" title="You have an outstanding AutoLink Request to {{$oshop_name}}">
							<span><img height="27" width="27"
								src="/images/bike-chain-rev.png">&nbsp;</span>
							AutoLink
						</button>&nbsp;							
						&nbsp;
					@else
						<button type="button"
							data-button="{{$merchant->id}}"
							class="btn btn-success btn-lg autoclass"
							id="cancel_autolink"
							style="background:#fff;color:rgb(0,99,98);right:0;margin-top:1px; right: 0px; padding-bottom: 7px; padding-top: 7px;"  title="You have an outstanding AutoLink Request to {{$oshop_name}}">
							<span><img height="27" width="27"
								src="/images/bike-chain-rev.png">&nbsp;</span>
							AutoLink
						</button>
						<button type="button"
							data-button="{{$merchant->id}}"
							class="btn btn-success btn-lg autoclass"
							id="autolink_btn"
							style="background:rgb(0,99,98);color:#fff;right:0;margin-top:1px; right: 0px; padding-bottom: 7px; padding-top: 7px; display: none;" title="Press to get B2B and Special pricing">
							<span><img height="27" width="27"
								src="/images/bike-chain.png">&nbsp;</span>
							AutoLink
						</button>						
						&nbsp;							
					@endif
					<input type="hidden" id="autolink_user_id" value="{{Auth::user()->id}}" />
					<input type="hidden" id="autolink_merchant_id" value="{{$id}}" />
				@else
					@if($immerchant == $id)
						<button type="button"
							disabled
							data-button="{{$merchant->id}}"
							class="btn btn-success btn-lg badge1 autoclass"
							id="autolink_merchant"
							style="background:#ddd;color:rgb(0,99,98);right:0;margin-top:1px; right: 0px; padding-bottom: 7px; padding-top: 7px;"
							title="Warning: A merchant cannot AutoLink with yourself"
							@if($badge_num > 0)
								data-badge="{{$badge_num}}"
							@endif
							>
							<span><img height="27" width="27"
								src="/images/bike-chain.png">&nbsp;</span>
							AutoLink
						</button>&nbsp;								
					@else	
						<button type="button"
							data-button="{{$merchant->id}}"
							class="btn btn-success btn-lg autoclass"
							id="cancel_autolink"
							style="background:#fff;color:rgb(0,99,98);right:0;margin-top:1px; right: 0px; padding-bottom: 7px; padding-top: 7px;" title="You are Autolinked to {{$oshop_name}}">
							<span><img height="27" width="27"
								src="/images/bike-chain-rev.png">&nbsp;</span>
							AutoLink
						</button>
						<button type="button"
							data-button="{{$merchant->id}}"
							class="btn btn-success btn-lg autoclass"
							id="autolink_btn"
							style="background:rgb(0,99,98);color:#fff;right:0;margin-top:1px; right: 0px; padding-bottom: 7px; padding-top: 7px; display: none;" title="Press to get B2B and Special pricing">
							<span><img height="27" width="27"
								src="/images/bike-chain.png">&nbsp;</span>
							AutoLink
						</button>						
						&nbsp;	
						<input type="hidden" id="autolink_user_id" value="{{Auth::user()->id}}" />
						<input type="hidden" id="autolink_merchant_id" value="{{$id}}" />						
					@endif					
				@endif
				
			@else			
				@if($canautolink)
					<a href="javascript:void(0)" data-toggle="modal" data-target="#loginModal" class="autolink_validation" style="padding: 0px;">
						<button type="button"
							class="btn btn-success btn-lg autoclass"
							id="autolink"
							style="background:rgb(0,99,98);color:#fff;right:0;margin-top:1px; right: 0px; padding-bottom: 7px; padding-top: 7px;" title="Press to get B2B and Special pricing">
							<span><img height="27" width="27"
								src="/images/bike-chain.png">&nbsp;</span>
							AutoLink
						</button>&nbsp;
					</a>
				@endif
			@endif
			</p>
		</li>
	</ul>
</div>

<script>
	$(document).ready(function(){
		$('.autoclass').tooltip();
		$('#autolink_btn').on('click',function(){
			var autolink_user_id = $("#autolink_user_id").val();
			var autolink_merchant_id = $("#autolink_merchant_id").val();
            $.ajax({
                type: "post",
                url:  JS_BASE_URL + '/request_autolink',
                data: {autolink_user_id: autolink_user_id,autolink_merchant_id: autolink_merchant_id},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    console.log(responseData);
					if(responseData.status == "success"){
						//$("#autolink_btn").attr('style','background:#fff;color:rgb(0,99,98);right:0;margin-top:1px; right: 0px; padding-bottom: 7px; padding-top: 7px;');
						toastr.info("Please wait for Merchant AutoLink approval!");				
						$("#cancel_autolink").show();
						$("#autolink_btn").hide();					
					} else {
						toastr.info("There was an unexpected error, please, try again later");
					}
				
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
		});		
		
		$('#cancel_autolinktest').on('click',function(){
			console.log("Hello");
		});
		
		$('#cancel_autolink').on('click',function(){
			console.log("Hello");
			var autolink_user_id = $("#autolink_user_id").val();
			var autolink_merchant_id = $("#autolink_merchant_id").val();
            $.ajax({
                type: "post",
                url:  JS_BASE_URL + '/cancel_autolink',
                data: {autolink_user_id: autolink_user_id,autolink_merchant_id: autolink_merchant_id},
                cache: false,
                success: function (responseData, textStatus, jqXHR) {
                    console.log(responseData);
					if(responseData.status == "success"){
						toastr.info("AutoLink successfully cancelled!");							
						$("#cancel_autolink").hide();
						$("#autolink_btn").show();
					} else {
						toastr.info("There was an unexpected error, please, try again later");
					}
				
                },
                error: function (responseData, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
		});			
		
		$('#autolink_merchant').on('click',function(){
			window.location.href = JS_BASE_URL + '/merchant/dashboard';
		});
		$('.category_tab').hide();
	    $('#cat-retail').show();
		$('.tab-link').on('click',function(){
			$('.category_tab').hide();
			id = $(this).attr('id');
			$('#cat-'+id).show();
			$('.content-tab').addClass('hidden');
			$('#content-'+id).fadeIn(500, function(){
				$(this).removeClass('hidden');
			});
		});
	})
</script>
