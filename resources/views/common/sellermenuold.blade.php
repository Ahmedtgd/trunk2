<?php 
use App\Http\Controllers\IdController;
?>
@if(isset($selluser))
<?php
$cf = new \App\lib\CommonFunction();
$tglobals = DB::table('global')->first();
?>
<?php $i=1;
 ?>
<style>
.disableda{
	cursor: not-allowed;
}
.margint7{
	margin-top: 7px;
}
li.activeseller a, .navbar-inverse .navbar-nav > .activeseller > a, .navbar-inverse .navbar-nav > .activeseller > a:focus, .navbar-inverse .navbar-nav > .activeseller > a:hover {
    background-color: transparent;
    color: #3c763d;
}

.seller-menu a {
    font-size: 1.1em !important;
}

.sellernav>li>a {
    padding-top: 8px !important;
    padding-bottom: 8px !important;
}

.customnavbar {
    position: relative;
    min-height: 0px !important;
   /* margin-bottom: 20px; */
    border: 1px solid transparent;
	z-index: auto !important;
}

.custom-form-control {
  /*  display: block;
    width: 100%;*/
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
}
</style>
@if (Auth::check() && (Auth::user()->hasRole('mer') ||
	(Auth::user()->hasRole('adm') && $selluser->hasRole('mer')) || (Auth::user()->hasRole('hcu') ||
	(Auth::user()->hasRole('hcu') && $selluser->hasRole('hcu'))) || (Auth::user()->hasRole('fmu') ||
	(Auth::user()->hasRole('fmu') && $selluser->hasRole('fmu')))))
	<?php
		$sellcompany_name = DB::table('merchant')->
			where('user_id',$selluser->id)->
			pluck('company_name');
	?>	
	<div class="container" style="background-color: black; color: white;">
		<div class="col-md-8 no-padding" >
			<h2 >{{$sellcompany_name}}</h2>
		</div>
		<div class="col-md-4 no-padding">
			<h2 class='pull-right'>
				&nbsp;
			</h2>
		</div>		
	</div>
@else
	@if (Auth::check() && (Auth::user()->hasRole('sto') ||
		(Auth::user()->hasRole('adm') && $selluser->hasRole('sto'))))
		<?php
			$sellcompany_name = DB::table('station')->
				where('user_id',$selluser->id)->pluck('company_name');
		?>	
		<div class="container" style="background-color: black;">
			<div class="col-md-6 no-padding">
				<h2>{{$sellcompany_name}}</h2>
			</div>
			<div class="col-md-6 no-padding">
				<h2 class='pull-right'>
					&nbsp;
				</h2>
			</div>		
		</div>		
	@endif
@endif
@if (Auth::check() && (Auth::user()->hasRole('mer') ||
	(Auth::user()->hasRole('adm') && $selluser->hasRole('mer'))))
<div class="container_fluid" style="margin-bottom:5px;">
	<nav class="customnavbar navbar navbar-inverse megamenu  navbar-static-top" style="border-color: #BBB !important; background-color: #BBB !important; color: #FFF !important;">
	<div class="container">
	<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle"
				data-toggle="collapse" data-target="#main-menu">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand hidden" href="#"></a>
		</div>	
			<?php
				$sellmerchant_id = DB::table('merchant')->
					where('user_id',$selluser->id)->pluck('id');
			?>				
			<div class="collapse navbar-collapse seller-menu">
				<ul class="nav navbar-nav sellernav">				
					<li class="" style="background-color: #FF4C4C;">
						<div style="padding-top:6px;padding-bottom:2px;
						font-weight:bold;font-variant:small-caps;font-size:120%;
						width:100px;padding-left:10px;padding-right:10px">
						Merchant</div>
					</li>
					@if(Auth::user()->hasRole('mer'))
						@def $information_class = $cf->set_activeseller('edit_merchant')
						@def $information_url = URL::to('/edit_merchant')
						@def $dashboard_class = $cf->set_activeseller('dashboard')
						@def $dashboard_url = URL::to('/dashboard')
						@def $member_class = $cf->set_activeseller('sellermembers')
						@def $member_url = URL::to('/sellermembers')						
						@def $openchannel_class = $cf->set_activeseller('merchant/openchannel')
						@def $openchannel_url = route('merchant-openchannel')
						@def $salesreport_class = $cf->set_activeseller('merchant/salesreport')
						@def $salesreport_url = route('merchantsalesreport') 
						@def $album_class = $cf->set_activeseller('album')
						@def $album_url = URL::to('/album')
						@def $inventory_class = $cf->set_activeseller('merchant/inventory')
						@def $inventory_url = URL::to('/merchant/inventory')
						@def $hyper_class = $cf->set_activeseller('merchant/hyper')
						@def $hyper_url = route('merchanthyper')
						@def $discount_class = $cf->set_activeseller('merchant/discount')
						@def $discount_url = route('merchantdiscount') 
						@def $likes_class = $cf->set_activeseller('seller/likes')
						@def $likes_url = route('sellerlikes')
						@def $ageing_class = $cf->set_activeseller('seller/creditorageing')
						@def $ageing_url = route('sellercageing')
						@def $tproducts_class = $cf->set_activeseller('seller/tproducts')
						@def $tproducts_url = route('sellertproducts')
						@def $fairmode_url = route('sellerfair')
						@def $consigment_url = url('seller/consignment')

						@def $caiman_url = ""
						<?php 
							$oshops = DB::table('oshop')->
							select('oshop.*')->
							join('merchantoshop','oshop.id','=',
								 'merchantoshop.oshop_id')->
							join('merchant','merchant.id','=',
								 'merchantoshop.merchant_id')->
							where('merchant.user_id',
								Auth::user()->id)->get();
						?>	
					
					@else
						@def $information_class = $cf->set_activeseller('admin/popup/merchant/' . $sellmerchant_id)
						@def $information_url = URL::to('/admin/popup/merchant/' . $sellmerchant_id)
						@def $dashboard_class = $cf->set_activeseller('sellerdashboard/' . $selluser->id)
						@def $dashboard_url = URL::to('sellerdashboard/' . $selluser->id)
						@def $member_class = $cf->set_activeseller('sellermembers/' . $selluser->id)
						@def $member_url = URL::to('sellermembers/' . $selluser->id)
						@def $openchannel_class = $cf->set_activeseller('merchant/openchannel/' . $selluser->id)
						@def $openchannel_url = route('adminmerchant-openchannel',['uid' => $selluser->id])
						@def $salesreport_class = $cf->set_activeseller('merchant/salesreport/' . $selluser->id)
						@def $salesreport_url = route('adminmerchantsalesreport', ['uid' => $selluser->id])
						@def $album_class = $cf->set_activeseller('merchantalbum/0/' . $selluser->id)
						@def $album_url = URL::to('/merchantalbum/0/' . $selluser->id)
						@def $inventory_class = $cf->set_activeseller('/merchant/inventory/' . $selluser->id)
						@def $inventory_url = URL::to('merchant/inventory/' . $selluser->id)
						@def $hyper_class = $cf->set_activeseller('merchant/hyper/' . $selluser->id)
						@def $hyper_url = route('adminmerchanthyper', ['uid' => $selluser->id])
						@def $discount_class = $cf->set_activeseller('merchant/discount/' . $selluser->id)
						@def $discount_url = route('adminmerchantdiscount', ['uid' => $selluser->id])
						@def $likes_class = $cf->set_activeseller('seller/likes/' . $selluser->id)
						@def $likes_url = route('adminsellerlikes', ['uid' => $selluser->id])
						@def $tproducts_class = $cf->set_activeseller('seller/tproducts/'  . $selluser->id)
						@def $tproducts_url = route('adminsellertproducts', ['uid' => $selluser->id])
						@def $fairmode_url = route('adminsellerfair', ['uid' => $selluser->id])
						@def $consigment_url = url('seller/consignment/' . $selluser->id)
						<?php 
						$oshops = DB::table('oshop')->
							select('oshop.*')->
							join('merchantoshop','oshop.id','=',
								 'merchantoshop.oshop_id')->
							join('merchant','merchant.id','=',
								 'merchantoshop.merchant_id')->
							where('merchant.user_id',
								$selluser->id)->
							where('oshop.status','!=','transferred')->orderBy('oshop.single','DESC')->get();
						?>					
					@endif
					@include('common.sellermenu.information')
					@include('common.sellermenu.dashboard')
					@include('common.sellermenu.openchannel')
					@include('common.sellermenu.salesreport')
					@include('common.sellermenu.member')
					@include('common.sellermenu.likes')
					@include('common.sellermenu.merchant.album')
					@include('common.sellermenu.merchant.inventory')
					@include('common.sellermenu.merchant.hyper')
					@include('common.sellermenu.merchant.discount')
					@include('common.sellermenu.merchant.mterm')
					@include('common.sellermenu.merchant.oshops')
				</ul>
			</div>		
		</div>
	</nav>	
</div>
@else
	@if (Auth::check() && (Auth::user()->hasRole('hcu') ||
	$selluser->hasRole('hcu')))
	<div class="container_fluid" style="margin-bottom:5px;">
		<nav class="customnavbar navbar navbar-inverse megamenu  navbar-static-top" style="border-color: #BBB !important; background-color: #BBB !important; color: #FFF !important;">
		<div class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle"
					data-toggle="collapse" data-target="#main-menu">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand hidden" href="#"></a>
			</div>	
				<?php
					$sellmerchant_id = DB::table('merchant')->
						where('user_id',$selluser->id)->pluck('id');
				?>				
				<div class="collapse navbar-collapse seller-menu">
					<ul class="nav navbar-nav sellernav">				
						<li class="" style="background-color: #FF4C4C;">
							<div style="padding-top:6px;padding-bottom:2px;
							font-weight:bold;font-variant:small-caps;font-size:120%;
							width:100px;padding-left:10px;padding-right:10px">
							Merchant</div>
						</li>
						@if(!Auth::user()->hasRole('adm'))
							@def $information_class = $cf->set_activeseller('edit_merchant')
							@def $information_url = URL::to('/edit_merchant')
							@def $member_class = $cf->set_activeseller('sellermembers')
							@def $member_url = URL::to('/sellermembers')						
							@def $ageing_class = $cf->set_activeseller('seller/creditorageing')
							@def $ageing_url = route('sellercageing')
							@def $tproducts_class = $cf->set_activeseller('seller/tproducts')
							@def $tproducts_url = route('sellertproducts')
							@def $fairmode_url = route('sellerfair')
							<?php 
								$oshops = DB::table('oshop')->
								select('oshop.*')->
								join('merchantoshop','oshop.id','=',
									 'merchantoshop.oshop_id')->
								join('merchant','merchant.id','=',
									 'merchantoshop.merchant_id')->
								where('merchant.user_id',
									Auth::user()->id)->get();
							?>	
						
						@else
							@def $information_class = $cf->set_activeseller('admin/popup/merchant/' . $sellmerchant_id)
							@def $information_url = URL::to('/admin/popup/merchant/' . $sellmerchant_id)
							@def $member_class = $cf->set_activeseller('sellermembers/' . $selluser->id)
							@def $member_url = URL::to('sellermembers/' . $selluser->id)
							@def $tproducts_class = $cf->set_activeseller('seller/tproducts/'  . $selluser->id)
							@def $tproducts_url = route('adminsellertproducts', ['uid' => $selluser->id])
							@def $fairmode_url = route('adminsellerfair', ['uid' => $selluser->id])
							<?php 
							$oshops = DB::table('oshop')->
								select('oshop.*')->
								join('merchantoshop','oshop.id','=',
									 'merchantoshop.oshop_id')->
								join('merchant','merchant.id','=',
									 'merchantoshop.merchant_id')->
								where('merchant.user_id',
									$selluser->id)->
								where('oshop.status','!=','transferred')->orderBy('oshop.single','DESC')->get();
							?>					
						@endif
						@include('common.sellermenu.information')
						@include('common.sellermenu.disabled.dashboard')
						@include('common.sellermenu.disabled.openchannel')
						@include('common.sellermenu.disabled.salesreport')
						@include('common.sellermenu.member')
						@include('common.sellermenu.disabled.likes')
						@include('common.sellermenu.disabled.album')
						@include('common.sellermenu.disabled.inventory')
						@include('common.sellermenu.disabled.hyper')
						@include('common.sellermenu.disabled.discount')
						@include('common.sellermenu.merchant.mterm')
						@include('common.sellermenu.disabled.oshops')
					</ul>
				</div>		
			</div>
		</nav>	
	</div>
	@else
	
		@if (Auth::check() && (Auth::user()->hasRole('fmu') ||
		 $selluser->hasRole('fmu')))
		<div class="container_fluid" style="margin-bottom:5px;">
			<nav class="customnavbar navbar navbar-inverse megamenu  navbar-static-top" style="border-color: #BBB !important; background-color: #BBB !important; color: #FFF !important;">
			<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle"
						data-toggle="collapse" data-target="#main-menu">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand hidden" href="#"></a>
				</div>	
					<?php
						$sellmerchant_id = DB::table('merchant')->
							where('user_id',$selluser->id)->pluck('id');
					?>				
					<div class="collapse navbar-collapse seller-menu">
						<ul class="nav navbar-nav sellernav">				
							<li class="" style="background-color: #FF4C4C;">
								<div style="padding-top:6px;padding-bottom:2px;
								font-weight:bold;font-variant:small-caps;font-size:120%;
								width:100px;padding-left:10px;padding-right:10px">
								Merchant</div>
							</li>
							@if(!Auth::user()->hasRole('adm'))
								@def $information_class = $cf->set_activeseller('edit_merchant')
								@def $information_url = URL::to('/edit_merchant')
								@def $member_class = $cf->set_activeseller('sellermembers')
								@def $member_url = URL::to('/sellermembers')	
								@def $inventory_class = $cf->set_activeseller('merchant/inventory')
								@def $inventory_url = URL::to('/merchant/inventory')
								@def $ageing_class = $cf->set_activeseller('seller/creditorageing')
								@def $ageing_url = route('sellercageing')
								@def $tproducts_class = $cf->set_activeseller('seller/tproducts')
								@def $tproducts_url = route('sellertproducts')
								@def $fairmode_url = route('sellerfair')
								<?php 
									$oshops = DB::table('oshop')->
									select('oshop.*')->
									join('merchantoshop','oshop.id','=',
										 'merchantoshop.oshop_id')->
									join('merchant','merchant.id','=',
										 'merchantoshop.merchant_id')->
									where('merchant.user_id',
										Auth::user()->id)->get();
								?>	
							
							@else
								@def $information_class = $cf->set_activeseller('admin/popup/merchant/' . $sellmerchant_id)
								@def $information_url = URL::to('/admin/popup/merchant/' . $sellmerchant_id)
								@def $member_class = $cf->set_activeseller('sellermembers/' . $selluser->id)
								@def $member_url = URL::to('sellermembers/' . $selluser->id)
								@def $inventory_class = $cf->set_activeseller('/merchant/inventory/' . $selluser->id)
								@def $inventory_url = URL::to('merchant/inventory/' . $selluser->id)
								@def $tproducts_class = $cf->set_activeseller('seller/tproducts/'  . $selluser->id)
								@def $tproducts_url = route('adminsellertproducts', ['uid' => $selluser->id])
								@def $fairmode_url = route('adminsellerfair', ['uid' => $selluser->id])
								<?php 
								$oshops = DB::table('oshop')->
									select('oshop.*')->
									join('merchantoshop','oshop.id','=',
										 'merchantoshop.oshop_id')->
									join('merchant','merchant.id','=',
										 'merchantoshop.merchant_id')->
									where('merchant.user_id',
										$selluser->id)->
									where('oshop.status','!=','transferred')->orderBy('oshop.single','DESC')->get();
								?>					
							@endif
							@include('common.sellermenu.information')
							@include('common.sellermenu.disabled.dashboard')
							@include('common.sellermenu.disabled.openchannel')
							@include('common.sellermenu.disabled.salesreport')
							@include('common.sellermenu.member')
							@include('common.sellermenu.disabled.likes')
							@include('common.sellermenu.disabled.album')
							@include('common.sellermenu.merchant.inventory')
							@include('common.sellermenu.disabled.hyper')
							@include('common.sellermenu.disabled.discount')
							@include('common.sellermenu.merchant.mterm')
							@include('common.sellermenu.disabled.oshops')
						</ul>
					</div>		
				</div>
			</nav>	
		</div>
		@else	
			<?php 
				$imm = null;
				if(Auth::check()){
					$imm = DB::table('merchant')->where('user_id',$selluser->id)->first();
				}
			?>
			@if (!is_null($imm))
				<div class="container_fluid" style="margin-bottom:5px;">
					<nav class="customnavbar navbar navbar-inverse megamenu  navbar-static-top" style="border-color: #BBB !important; background-color: #BBB !important; color: #FFF !important;">
					<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
							<button type="button" class="navbar-toggle"
								data-toggle="collapse" data-target="#main-menu">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand hidden" href="#"></a>
						</div>	
							<?php
								$sellmerchant_id = DB::table('merchant')->
									where('user_id',$selluser->id)->pluck('id');
							?>				
							<div class="collapse navbar-collapse seller-menu">
								<ul class="nav navbar-nav sellernav">				
									<li class="" style="background-color: #FF4C4C;">
										<div style="padding-top:6px;padding-bottom:2px;
										font-weight:bold;font-variant:small-caps;font-size:120%;
										width:100px;padding-left:10px;padding-right:10px">
										Merchant</div>
									</li>
									@if(!Auth::user()->hasRole('adm'))
										@def $information_class = $cf->set_activeseller('edit_merchant')
										@def $information_url = URL::to('/edit_merchant')
										@def $member_class = $cf->set_activeseller('sellermembers')
										@def $member_url = URL::to('/sellermembers')	
										<?php 
											$oshops = DB::table('oshop')->
											select('oshop.*')->
											join('merchantoshop','oshop.id','=',
												 'merchantoshop.oshop_id')->
											join('merchant','merchant.id','=',
												 'merchantoshop.merchant_id')->
											where('merchant.user_id',
												Auth::user()->id)->get();
										?>	
									
									@else
										@def $information_class = $cf->set_activeseller('admin/popup/merchant/' . $sellmerchant_id)
										@def $information_url = URL::to('/admin/popup/merchant/' . $sellmerchant_id)
										@def $member_class = $cf->set_activeseller('sellermembers/' . $selluser->id)
										@def $member_url = URL::to('sellermembers/' . $selluser->id)
										<?php 
										$oshops = DB::table('oshop')->
											select('oshop.*')->
											join('merchantoshop','oshop.id','=',
												 'merchantoshop.oshop_id')->
											join('merchant','merchant.id','=',
												 'merchantoshop.merchant_id')->
											where('merchant.user_id',
												$selluser->id)->
											where('oshop.status','!=','transferred')->orderBy('oshop.single','DESC')->get();
										?>					
									@endif
									@include('common.sellermenu.information')
									@include('common.sellermenu.disabled.dashboard')
									@include('common.sellermenu.disabled.openchannel')
									@include('common.sellermenu.disabled.salesreport')
									@include('common.sellermenu.member')
									@include('common.sellermenu.disabled.likes')
									@include('common.sellermenu.disabled.album')
									@include('common.sellermenu.disabled.inventory')
									@include('common.sellermenu.disabled.hyper')
									@include('common.sellermenu.disabled.discount')
									@include('common.sellermenu.disabled.mterm')
									@include('common.sellermenu.disabled.oshops')

								</ul>
							</div>		
						</div>
					</nav>	
				</div>				
			@endif	
		@endif	
	@endif	
@endif

@if (Auth::check() && ((Auth::user()->hasRole('sto') && !(Auth::user()->hasRole('log')))||
	(Auth::user()->hasRole('adm') && $selluser->hasRole('sto') && !$selluser->hasRole('log'))))
<div class="container_fluid" style="margin-bottom:5px;">
	<nav class="customnavbar navbar navbar-inverse megamenu  navbar-static-top" style="border-color: #BBB !important; background-color: #BBB !important; color: #FFF !important;">
	<div class="container">
	<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle"
				data-toggle="collapse" data-target="#main-menu">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand hidden" href="#"></a>
		</div>	
			<?php
				$sellstation_id = DB::table('station')->
					where('user_id',$selluser->id)->pluck('id');
				$smargin = "0";
				if (Auth::check() && (Auth::user()->hasRole('mer') ||
				   (Auth::user()->hasRole('adm') &&
					$selluser->hasRole('mer')))){
					$smargin = "5px";
				}
			?>	
			<div class="collapse navbar-collapse seller-menu"
				style="margin-top: {{$smargin}};">
				<ul class="nav navbar-nav sellernav">	
					<li class="" style="background-color: #4E2E28;">

					<div style="padding-top:6px;padding-bottom:2px;
					font-weight:bold;font-variant:small-caps;font-size:120%;
					width:100px;padding-left:10px;padding-right:10px">
					Station</div></li>
					@if(Auth::user()->hasRole('sto'))
						@def $information_class = $cf->set_activeseller('edit_station')
						@def $information_url = URL::to('/edit_station')
						@def $dashboard_class = $cf->set_activeseller('dashboard')
						@def $dashboard_url = URL::to('/dashboard')
						@def $member_class = $cf->set_activeseller('sellermembers')
						@def $member_url = URL::to('/sellermembers')
						@def $openchannel_class = $cf->set_activeseller('station/ochannel-supplier')
						@def $openchannel_url = route('open-channel')
						@def $salesreport_class = $cf->set_activeseller('station/salesreport')
						@def $salesreport_url = route('stationsalesreport') 
						@def $procurementterm_class = $cf->set_activeseller('station/order-view-term')
						@def $procurementterm_url = URL::to('/station/order-view-term')
						@def $procurement_class = $cf->set_activeseller('station/order-view')
						@def $procurement_url = URL::to('/station/order-view')
						@def $invupdate_class = $cf->set_activeseller('inventory/update')
						@def $invupdate_url = URL::to('/inventory/update')
						@def $likes_class = $cf->set_activeseller('seller/likes')
						@def $likes_url = route('sellerlikes')
						@def $border_class = $cf->set_activeseller('station/purchases')
						@def $border_url = URL::to('station/purchases')
						@def $breceipt_class = $cf->set_activeseller('seller/buyingreceipt')
						@def $breceipt_url = route('sellerbreceipt')	
						@def $dageing_class = $cf->set_activeseller('seller/debtorageing')
						@def $dageing_url = route('sellerdageing')						
						@def $sdocuments_url = route('sdocuments')						
					
					@else
						@def $information_class = $cf->set_activeseller('admin/popup/station/' . $sellstation_id)
						@def $information_url = URL::to('/admin/popup/station/' . $sellstation_id)
						@def $dashboard_class = $cf->set_activeseller('sellerdashboard/' . $selluser->id)
						@def $dashboard_url = URL::to('sellerdashboard/' . $selluser->id)
						@def $member_class = $cf->set_activeseller('sellermembers/' . $selluser->id)
						@def $member_url = URL::to('sellermembers/' . $selluser->id)
						@def $openchannel_class = $cf->set_activeseller('station/ochannel-supplier/' . $selluser->id)
						@def $openchannel_url = route('adminopen-channel', ['uid' => $selluser->id])
						@def $salesreport_class = $cf->set_activeseller('station/salesreport/' . $selluser->id)
						@def $salesreport_url = route('adminstationsalesreport', ['uid' => $selluser->id])
						@def $procurementterm_class = $cf->set_activeseller('station/order-view-term/' . $selluser->id)
						@def $procurementterm_url = URL::to('/station/order-view-term/' . $selluser->id)
						@def $procurement_class = $cf->set_activeseller('station/order-view/' . $selluser->id)
						@def $procurement_url = URL::to('/station/order-view/' . $selluser->id)
						@def $invupdate_class = $cf->set_activeseller('inventory/update/' . $selluser->id)
						@def $invupdate_url = URL::to('/inventory/update/' . $selluser->id)
						@def $likes_class = $cf->set_activeseller('seller/likes/' . $selluser->id)
						@def $likes_url = route('adminsellerlikes', ['uid' => $selluser->id])	
						@def $border_class = $cf->set_activeseller('station/purchases/' . $selluser->id)
						@def $border_url = URL::to('/station/purchases/' . $selluser->id)
						@def $breceipt_class = $cf->set_activeseller('seller/buyingreceipt/' . $selluser->id)
						@def $breceipt_url = route('adminsellerbreceipt', ['uid' => $selluser->id])
						@def $dageing_class = $cf->set_activeseller('seller/creditorageing' . $selluser->id)
						@def $dageing_url = route('adminsellercageing', ['uid' => $selluser->id])
						@def $sdocuments_url = route('adminsellerdocuments', ['uid' => $selluser->id])
					@endif					
					@include('common.sellermenu.information')
					@include('common.sellermenu.dashboard')
					@include('common.sellermenu.openchannel')
					@include('common.sellermenu.salesreport')
					@include('common.sellermenu.member')
					@include('common.sellermenu.likes')
					@include('common.sellermenu.station.procurement')
					@include('common.sellermenu.station.invupdate')
					@include('common.sellermenu.station.sterm')
					@include('common.sellermenu.border')
					@include('common.sellermenu.breceipt')
				</ul>		
			</div>						
		</div>
	</nav>	
</div>
@endif

@if (Auth::check())
	<div class="container" style="margin-bottom:2px;">		
		<?php
			$sellmerchant = DB::table('merchant')->
				where('user_id',$selluser->id)->first();
		?>			
		<div>
			@if(!is_null($sellmerchant))
			<!--	<input type="hidden"
				value="{{isset($sellmerchant) ? $sellmerchant->id : null}}"
				id="mmid"/>
				<b>Order per Trip: </b> MYR <input type="text" size="6"
				value="{{number_format($sellmerchant->min_order,2)}}"
				old-value="{{number_format($sellmerchant->min_order,2)}}"
				class="min_order custom-form-control"
				title="Station Minimum Order per Trip"
				rel="{{$sellmerchant_id}}"  />		-->		
			@else
				<input type="hidden"
				value="0"
				id="mmid"/>
			@endif

			<a href="javascript:void(0)" rel="{{$selluser->id}}"
				class="btn btn-info pull-right token"
				style="background-color:#400080;color:#fff;border:0">Token</a>
		</div>
	</div>	
	<div class="modal fade" id="myModalToken" role="dialog" aria-labelledby="myModalToken">
		<div class="modal-dialog" role="remarks" style="width: 40%">
			<div class="modal-content">
				<div class="row" style="padding: 15px;">
					<div class="col-md-12" style="">
						<fieldset>
							<?php
								$token = DB::table('userstoken')->where('user_id',$selluser->id)->first();
								$facilities = DB::table('facility')->get();
								$facilities_subscribed = DB::table('sellerfacility')->where('user_id',$selluser->id)->get();
								$subscribedarr = array();
								$cto = 0;
								foreach($facilities_subscribed as $facsubs){
									$subscribedarr[$cto] = $facsubs->facility_id;
									$cto++;
								}
								$qty_token = 0;
								if(!is_null($token)){
									$qty_token = $token->qty;
								}
							?>
							<div class='col-sm-8'>
							<label style="font-size: 20px;">
							<b>Token</b></label></div>
							<!--
							<div class='col-sm-4'>
							<a href="javascript:void(0)"
							style="width: 150px;"
							class="btn btn-green pull-right buy_token">
							Buy</a>
							</div>
							-->
							<div class='col-sm-8'>
							<b style="font-size: 18px;">
							Tokens Available: <span class="availability">{{number_format($qty_token,0,'.','')}}</span>
							</b></div>
 							<div class='col-sm-4'>
							@if (!Auth::user()->hasRole('adm'))
								<a href="javascript:void(0)"
								style="width: 150px;background-color:#00ff80"
								class="btn btn-green pull-right buy_token">
								Buy</a>
							@else
								<a href="javascript:void(0)"
								style="width: 150px;background-color:#00ff80"
								class="btn btn-green pull-right buy_token_admin">
								Buy</a>
							@endif
							</div> 
							<div class='clearfix'></div>
							<div class='col-sm-8' style="margin-top: 20px;">
								<select id="token_tied">
									@foreach($facilities as $facility)
										@if(!in_array($facility->id,$subscribedarr))
											<option value="{{$facility->id}}"
											rel="{{$facility->token_subscription_fee}}">
											{{$facility->description}}</option>
										@endif
									@endforeach
								</select>
							</div>

							<div class='col-sm-4' style="margin-top: 12px;">
							@if (!Auth::user()->hasRole('adm'))
								<a href="javascript:void(0)"
								style="background-color:#400080 !important; width: 150px;"
								class="btn btn-green pull-right subscribe_token_q">
								Subscribe</a>
							@else
								<a href="javascript:void(0)"
								style="background-color:#400080 !important; width: 150px;"
								class="btn btn-green pull-right subscribe_token_q_admin">
								Subscribe</a>
							@endif
							</div>
							<div class='col-sm-6'>
								<label style="font-size: 18px;margin-top:20px">Tied To:</label>
								<?php $coo = 1; ?>
								@foreach($facilities as $facility)
									@if(!in_array($facility->id,$subscribedarr))
										<p id="facility_{{$facility->id}}"><b>
										{{$coo}}.&nbsp;{{$facility->description}}</b></p>
									@else
										<p style="color: rgb(39,169,138) !important;">
										<b>{{$coo}}.&nbsp;{{$facility->description}}</b></p>
									@endif
									<input type="hidden" id="facility_fee_{{$facility->id}}"
									value="{{$facility->token_subscription_fee}}" />
									<?php $coo++; ?>
								@endforeach
							</div>
							<input type="hidden" id="tokenuser" value="" >
						</fieldset>
					</div>
				</div>
				<div class="modal-footer">
					<button style="width: 60px !important;" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>				
			</div>			
		</div>	
	</div>	
	<div class="modal fade" id="myModalSubscribe" role="dialog" aria-labelledby="myModalToken">
		<div class="modal-dialog" role="remarks" style="width: 40%">
			<div class="modal-content">
				<div class="row" style="padding: 15px;">
					<div class="col-md-12" style="">
						<fieldset>
							<div class='col-sm-12'><label style="font-size: 15px;">Subscribing to <span class="ffacility"></span> facility for <span class="fquantity"></span> Tokens</label></div>
							<div class='col-sm-12'>
								<a href="javascript:void(0)" class="btn btn-danger" id="cancel_susbcribe" data-dismiss="modal">Cancel</a>&nbsp;&nbsp;
								<a href="javascript:void(0)" class="btn btn-info subscribe_token">Confirm</a>
							</div>
						</fieldset>
					</div>
				</div>
				<div class="modal-footer">
					<button style="width: 60px !important;" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>				
			</div>			
		</div>	
	</div>		
	<div class="modal fade" id="myModalTokens" role="dialog" aria-labelledby="myModalTokens">
		<div class="modal-dialog" role="remarks" style="width: 560px;">
			<div class="modal-content">
				<div class="row" style="padding: 15px;">
					<div class="col-md-12" style="">
						<fieldset>
							<?php
								$product1 = null;
								$product2 = null;
								$product3 = null;
								$product4 = null;
								$product5 = null;
								if(property_exists($tglobals, 'token_product_id1')){
									$product1 = DB::table('product')->join('tokenuserproduct','tokenuserproduct.product_id','=','product.id')->where('tokenuserproduct.user_id',$selluser->id)->where('product.id',$tglobals->token_product_id1)->first();
								}
								if(property_exists($tglobals, 'token_product_id2')){
									$product2 = DB::table('product')->join('tokenuserproduct','tokenuserproduct.product_id','=','product.id')->where('tokenuserproduct.user_id',$selluser->id)->where('product.id',$tglobals->token_product_id2)->first();
								}
								if(property_exists($tglobals, 'token_product_id3')){
									$product3 = DB::table('product')->join('tokenuserproduct','tokenuserproduct.product_id','=','product.id')->where('tokenuserproduct.user_id',$selluser->id)->where('product.id',$tglobals->token_product_id3)->first();
								}
								if(property_exists($tglobals, 'token_product_id4')){
									$product4 = DB::table('product')->join('tokenuserproduct','tokenuserproduct.product_id','=','product.id')->where('tokenuserproduct.user_id',$selluser->id)->where('product.id',$tglobals->token_product_id4)->first();
								}
								if(property_exists($tglobals, 'token_product_id5')){
									$product5 = DB::table('product')->join('tokenuserproduct','tokenuserproduct.product_id','=','product.id')->where('tokenuserproduct.user_id',$selluser->id)->where('product.id',$tglobals->token_product_id5)->first();
								}
							?>
								<div class='row'>
									<div class='col-sm-4'><p align="center"><label style="font-size: 16px;"><b>&nbsp;</b></label></p></div>
									<div class='col-sm-4'><p align="center"><label style="font-size: 19px; text-align: center"><b>Tokens</b></label></p></div>
									<div class='col-sm-4'><p align="center"><label style="font-size: 16px;text-align: center"><b>&nbsp;</b></label></p></div>
								</div>
								<div class='row'>
									<div class='col-sm-4'><p align="center"><label style="font-size: 16px;"><b>Name</b></label></p></div>
									<div class='col-sm-4'><p align="center"><label style="font-size: 16px; text-align: center"><b>Quantity</b></label></p></div>
									<div class='col-sm-4'><p align="center"><label style="font-size: 16px;text-align: center"><b>Price</b></label></p></div>
								</div>
							@if(!is_null($product1))
								<div class='row'>
									<div class='col-sm-4'><p align="center"><label style="font-size: 16px;"><b>{{$product1->name}}</b></label></div>
									<div class='col-sm-4'>
										<p align="center">{{number_format(( $product1->retail_price)/100)}}</p>
									</div>
									<div class='col-sm-4'><a href="javascript:void(0)" style="width: 160px !important;" class="btn btn-green buy_token_p" rel="{{$product1->id}}">{{$currentCurrency}}&nbsp;{{number_format($product1->discounted_price/100)}}</a></div>
								</div>
							@endif
							@if(!is_null($product2))
								<div class='row'>
									<div class='col-sm-4 margint7' ><p align="center"><label style="font-size: 16px;"><b>{{$product2->name}}</b></label></p></div>
									<div class='col-sm-4 margint7'>
										<p align="center">{{number_format(($product2->retail_price)/100)}}</p>
									</div>
									<div class='col-sm-4 margint7'><a href="javascript:void(0)" style="width: 160px !important;" class="btn btn-green buy_token_p" rel="{{$product2->id}}">{{$currentCurrency}}&nbsp;{{number_format($product2->discounted_price/100)}}</a></div>	
								</div>
							@endif
							@if(!is_null($product3))
								<div class='row'>
									<div class='col-sm-4 margint7'><p align="center"><label style="font-size: 16px;"><b>{{$product3->name}}</b></label></p></div>
									<div class='col-sm-4 margint7'>
										<p align="center">{{number_format(($product3->retail_price)/100)}}</p>
									</div>
									<div class='col-sm-4 margint7'><a href="javascript:void(0)" style="width: 160px !important;" class="btn btn-green buy_token_p" rel="{{$product3->id}}">{{$currentCurrency}}&nbsp;{{number_format($product3->discounted_price/100)}}</a></div>
								</div>
							@endif
							@if(!is_null($product4))
								<div class='row'>
									<div class='col-sm-4 margint7'><p align="center"><label style="font-size: 16px;"><b>{{$product4->name}}</b></label></p></div>
									<div class='col-sm-4 margint7'>
										<p align="center">{{number_format(( $product4->retail_price)/100)}}</p>
									</div>
									<div class='col-sm-4 margint7'><a href="javascript:void(0)" style="width: 160px !important;" class="btn btn-green buy_token_p" rel="{{$product4->id}}">{{$currentCurrency}}&nbsp;{{number_format($product4->discounted_price/100)}}</a></div>
								</div>
							@endif
							@if(!is_null($product5))
								<div class='row'>
									<div class='col-sm-4 margint7'><p align="center"><label style="font-size: 16px;"><b>{{$product5->name}}</b></label></p></div>
									<div class='col-sm-4 margint7'>
										<p align="center">{{number_format(($product5->retail_price)/100)}}</p>
									</div>							
									<div class='col-sm-4 margint7'><a href="javascript:void(0)" style="width: 160px !important;" class="btn btn-green buy_token_p" rel="{{$product5->id}}">{{$currentCurrency}}&nbsp;{{number_format($product5->discounted_price/100)}}</a></div>	
								</div>
							@endif
						</fieldset>
					</div>
				</div>
				<div class="modal-footer">
					<button style="width: 60px !important;" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>				
			</div>			
		</div>	
	</div>	
	<script type="text/javascript">	
		$(document).ready(function () {
			$(document).delegate( '.token', "click",function (event) {
				$("#tokenuser").val($(this).attr("rel"));
				$("#myModalToken").modal('show');
			});
			$(document).delegate( '.subscribe_token_q', "click",function (event) {
				var tokentied = $("#token_tied").val();
				console.log(tokentied);
				if(tokentied == null){
					toastr.warning('Please, select one facility to tie to');
				} else {
					var fee = $("#facility_fee_" + tokentied).val();
					$(".fquantity").html(fee);
					$(".ffacility").html($("#token_tied option:selected").text());
					$("#myModalToken").modal('toggle');
					$("#myModalSubscribe").modal('show');
					$("#cancel_susbcribe").focus();
				}		
			});
			$(document).delegate( '.subscribe_token', "click",function (event) {
				var subsbtn = $(this);
				subsbtn.html("Subscribing...");
				var tokentied = $("#token_tied").val();
				var tokenuser = $("#tokenuser").val();	
				$.ajax({
					url: JS_BASE_URL + '/merchant/token/subscribe',
					cache: false,
					method: 'POST',
					data: {tokenuser: tokenuser, tokentied: tokentied},
					success: function(result, textStatus, errorThrown) {
						if(result.status == "success"){
							toastr.info('Facility successfully subscribed!');
							$("#facility_" + tokentied).attr('style','color: rgb(39,169,138) !important');
							$("#token_tied option[value='"+tokentied+"']").remove();
							var intval = parseFloat($("#token_value").val());
							intval = intval - parseInt(result.tokens);
							$("#token_value").val(intval);				
							$("#token_value").number(true,2,'.','');	
							$("#token_tied").select2("destroy");
							$("#token_tied").select2();		
							$(".availability").html(result.ntoken);
						} else {
							toastr.warning('You need ' + result.tokens +' token(s) to subscribe!');
						}
						subsbtn.html("Confirm");
						$("#myModalSubscribe").modal('toggle');
						$("#myModalToken").modal('show');
					}
				});	
			});
			$(document).delegate( '.buy_token_admin', "click",function (event) {
				toastr.warning("You can't buy tokens because you are logged as admin.");
			});
			
			$(document).delegate( '.subscribe_token_q_admin', "click",function (event) {
				toastr.warning("You can't subscribe because you are logged as admin.");
			});
			
			$(document).delegate( '.buy_token', "click",function (event) {
				console.log("Buy Token P");
				$("#myModalToken").modal('toggle');
				$("#myModalTokens").modal('show');
			});
			$(document).delegate( '.buy_token_p', "click",function (event) {
				console.log("Buy Token P");
				var buybtn = $(this);
				buybtn.html("Redirecting...");
				var product_id = buybtn.attr('rel');	
				var tokenuser = $("#tokenuser").val();	
				var tokenvalue = $("#token_value").val();
				var tokentied = $("#token_tied").val();
				$.ajax({
					url: JS_BASE_URL + '/merchant/token',
					cache: false,
					method: 'POST',
					data: {tokenuser: tokenuser, tokenvalue: tokenvalue, tokentied: 'token', product_id: product_id},
					success: function(result, textStatus, errorThrown) {
						//objThis.hide();
						toastr.info('Token successfully added!');
						setTimeout(function(){ window.location = JS_BASE_URL + "/cart"; }, 1000);
						
					}
				});	
			});
			$(document).delegate( '.min_order', "blur",function (event) {
				var obj_this = $(this);
				var id = $("#mmid").val();
				var value = parseInt(obj_this.val());
				$.ajax({
					url: JS_BASE_URL + '/merchant/min_order/' + id,
					cache: false,
					method: 'POST',
					data: {value: value},
					success: function(result, textStatus, errorThrown) {
						//objThis.hide();
						console.log(result);
						toastr.info('Mininum Order successfully updated!');
					}
				});							
			});
		});	
	</script>
@endif
@endif
