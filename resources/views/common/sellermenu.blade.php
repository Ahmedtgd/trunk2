<?php
use App\Http\Controllers\IdController;	//already defined in login.php
$mode=Session::get("mode");
$oc=0;
?>
<style>
@if($mode=="onz")
.hide_in_mps{
	display: none
}
@endif
.sellerbutton{
	width: 70px;
	height: 70px;
	padding-top: 27px;
	text-align: center;
	vertical-align: middle;
	float: left;
	font-size: 13px;
	cursor: pointer;
	margin-right: 5px;
	margin-bottom: 5px;
	border-radius: 5px;
}

.sellerbuttontwo{
	width: 70px;
	height: 70px;
	padding-top: 19px;
	text-align: center;
	vertical-align: middle;
	float: left;
	font-size: 13px;
	cursor: pointer;
	margin-right: 5px;
	margin-bottom: 5px;
	border-radius: 5px;
}

.sellerbuttonlast{
	width: 70px;
	height: 70px;
	padding-top: 28px;
	text-align: center;
	vertical-align: middle;
	float: left;
	font-size: 13px;
	cursor: pointer;
	border-radius: 5px;
}

.sellerab{
	color: white;
}

.sellerab:hover{
	color: white;
}

.sellerab:active{
	color: white;
}

.sellerab:link{
	color: white;
}

.sellerab:visited{
	color: white;
}

.sellerdropdown{
	display: none;
    position: absolute;
    background-color: rgba(0,0,0,0.1);
	margin-top: 70px;
	padding: 5px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.3);
    z-index: 6;
}

.oposumdropdown{
	display: none;
    position: absolute;
    background-color: rgba(0,0,0,0.1);
	margin-top: 150px;
	padding: 5px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.3);
    z-index: 6;
}

.sellerdropdownchild{
	display: none;
    position: absolute;
	background-color: rgba(0,0,0,0.8);
	margin-top: 150px;
	padding: 5px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 6;
}

.container.container.container:root {
		font-size: 20px;
	}
	.usage.usage.usage.usage {
		min-height: 100px;
		border: 1px solid #c0c0c0;
		margin: 4% 4%;
	}
	.usage h4{
		font-weight: bold;
	}
	.value {
		text-align: right;
	}
	.usage_selected {
		border: 1px solid #c0c0c0;
		padding: 2px;
	}
/* Oluwa: This is MAJOR ERROR! This has caused other parts of the system
 * becomes disfigured!! Don't ever modify such a global attribute in a
 * publicly include file!!
	.row {
		margin: 5px;
		font-size: 1.5rem;
	}
*/
	.add::after {
		content: "";
		position: absolute;
		width: 0;
		height: 0;
		border: 5px solid transparent;
		border-left-color: red;
		top: 4px;
		right: -5px;
	}
	.per {
		background-color: #462055;
		color: #fff;
	}
	.caiman1 .row .col-sm-3 {
		border: 1px solid #c0c0c0;
		height: 10px;
	}
	.caiman1 .row {
		margin: 0;
	}
/* Oluwa: This is MAJOR ERROR!! All tables have borders including those
 * that have been meticulously designed!! Never ever modify such a global
 * attribute in a publicly include file!!
	table td {
		border: 1px solid #c0c0c0;
		padding: 5px 23px;
	}
*/
	.part.part.part {
		margin-top: 8%;
	}
	.part .header {
		font-weight: bold;
	}
	.col-sm-6.green::before,
	.col-sm-6.blue::before,
	.col-sm-6.red::before,
	.col-sm-6.brown::before,
	.col-sm-6.yellow::before {
    content: " ";
    width: 30px;
    border: 1px solid;
    height: 20px;
    position: absolute;
    left: 10px;
	}
	.col-sm-6.green,
	.col-sm-6.blue,
	.col-sm-6.red,
	.col-sm-6.brown,
	.col-sm-6.yellow {
    padding: 0 40px;
	}
	.col-sm-6.green::before{
		background-color: #00A642;
	}
	.col-sm-6.blue::before{
		background-color: #4B00CD;
	}
	.col-sm-6.red::before{
		background-color: #FD0000;
	}
	.col-sm-6.brown::before{
		background-color: #7E0000;
	}
	.col-sm-6.yellow::before{
		background-color: #EEFF00;
	}
	.variable.variable.variable a {
		color: #0e0e0e
	}

	/* Cash Management */
	.table-css{
		width: 100%;
	}
	/* .dataTables_empty{
		text-align: center;
	} */
</style>

@if(isset($selluser))
	<?php
 	$cf = new \App\lib\CommonFunction();
	$tglobals = DB::table('global')->first();
	?>
	<?php $i=1;
	 ?>
	@if (Auth::check() && (Auth::user()->hasRole('mer') ||
		(Auth::user()->hasRole('adm') && $selluser->hasRole('mer')) || (Auth::user()->hasRole('hcu') ||
		(Auth::user()->hasRole('hcu') && $selluser->hasRole('hcu'))) || (Auth::user()->hasRole('fmu') ||
		(Auth::user()->hasRole('fmu') && $selluser->hasRole('fmu')))))
		<?php
			$sellcompany_name = DB::table('merchant')->
				where('user_id',$selluser->id)->
				pluck('company_name');
		?>

		<div class="container-fluid" style="margin-top:0;background-color: black; color: white;">
			<div class="container"
				style="background-color: black; color: white;display:flex;align-items:center">
				<div class="col-md-8 no-padding" >
					<h2 style="margin-top:10px">{{$sellcompany_name}}</h2>
				</div>
				<div class="col-md-4 no-padding">
					<h4 class='pull-right' style="margin-top:10px;padding-top:5px">
						{{IdController::nSeller($selluser->id)}}
					</h4>
				</div>
			</div>
		</div>
	@else
		@if (Auth::check() && (Auth::user()->hasRole('sto') ||
			(Auth::user()->hasRole('adm') && $selluser->hasRole('sto'))))
			<?php
				$sellcompany_name = DB::table('station')->
					where('user_id',$selluser->id)->pluck('company_name');
			?>
			<!-- Primary button row -->
			<div class="container-fluid" style="background-color: black; color: white;">
				<div class="container" style="background-color: black; color: white;">
			<!-- Primary button row -->

					<div class="col-md-6 no-padding">
						<h2>{{$sellcompany_name}}</h2>
					</div>
					<div class="col-md-6 no-padding">
						<h2 class='pull-right'>
							{{IdController::nSeller($selluser->id)}}
						</h2>
					</div>
				</div>
			</div>
		@endif
	@endif
	<div class="container-fluid" style="background-color:black;color:white;">
		<div class="container" style="background-color:black;color:white;padding-bottom:15px;">
			@if (Auth::check() && ((Auth::user()->hasRole('mer') ||
				 Auth::user()->hasRole('sto')) ||
			    (Auth::user()->hasRole('adm') && ($selluser->hasRole('mer') ||
				$selluser->hasRole('sto')))))

				@if(Auth::user()->hasRole('mer') || Auth::user()->hasRole("adm"))
					@def $information_class = $cf->set_activeseller('edit_merchant')
					@def $information_url = URL::to('/edit_merchant')
					@def $dashboard_class = $cf->set_activeseller('dashboard')
					@def $dashboard_url = URL::to('/dashboard')
					@def $member_class = $cf->set_activeseller('sellermembers')
					@def $member_url = URL::to('/sellermembers',$selluser->id)
					@def $openchannel_class = $cf->set_activeseller('merchant/openchannel')
					@def $openchannel_url = route('merchant-openchannel')
					@def $salesreport_class = $cf->set_activeseller('merchant/salesreport')
					@def $salesreport_url = route('merchantsalesreport')
					@def $album_class = $cf->set_activeseller('album')
					@def $album_url = url('album',$selluser->id)
					@def $inventory_class = $cf->set_activeseller('merchant/inventory')
					@def $inventory_url = URL::to('/merchant/inventory',$selluser->id)
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
					@def $specialoffer_url = url('inventory/update/product_list')
					@def $breceipt_url = route('sellerbreceipt')
					@def $procurementterm_url = URL::to('/station/order-view-term')
					@def $procurement_url = URL::to('/station/order-view')
					@def $inventorycost_url = URL::to('/inventorycost')
					@def $documents_url = url('seller/documents/'.$selluser->id)
					@def $ageings_url = url('seller/ageings')
					@def $usage_url = url('show/usage')
					@def $sellerWarehouse = url('sellerWarehouse')
					@def $gator_url = url('seller/gator')
					@def $staff_url = url('stafflist')
					@def $scheduler_url = url('manager/schedule')
					@def $warrenty_management = url('raw/warranty_mgmt')
					@def $debitnote_url = url('debitnote')
					@def $wallet_management = url('wallet/wallet_mgmt')
					@def $sale_management = url('sale_report/sale_report_mgmt')

					@def $inventory_cost_url = url('inventorycost')
					@def $deliveryorder_url = url('seller/deliveryorder')
											@def $Arapaima_url = URL::to('/seller/refrigerator')
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

						Log::debug('**** fairmode_url='.$fairmode_url.'* ****');
					?>

				@else
					<?php
						$sellmerchant_id = DB::table('merchant')->
							where('user_id',$selluser->id)->pluck('id');
					?>
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
					@def $album_url1 = URL::to('/merchantalbum/0/' . $selluser->id)
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
					@def $specialoffer_url = url('inventory/update/product_list' . $selluser->id)
					@def $breceipt_url = route('adminsellerbreceipt', ['uid' => $selluser->id])
					@def $procurement_url = URL::to('/station/order-view/' . $selluser->id)
					@def $procurementterm_url = URL::to('/station/order-view-term/' . $selluser->id)
					@def $documents_url = url('seller/documents/' . $selluser->id)
					@def $ageings_url = url('seller/ageings/' . $selluser->id)
					@def $usage_url = url('show/usage')
					@def $inventorycost_url = URL::to('/inventorycost')
					@def $Arapaima_url = URL::to('/seller/refrigerator')
					@def $sellerWarehouse = url('sellerWarehouse',$selluser->id)
					@def $gator_url = route('gator',$selluser->id)
					@def $inventory_cost_url = route('einventory',$selluser->id)
					@def $deliveryorder_url = route('deliveryorder',$selluser->id)
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



						Log::debug('**** fairmode_url='.$fairmode_url.'* ****');
					?>
				@endif

				<div class="sellerbutton" id='settingbutton' style="background-color: rgb(49, 133, 156);">
					<span>Setting</span>
				</div>

				<div class="sellerbutton" id='systembutton' style="background-color: #A9C9C8;
					@if(!Auth::user()->hasAccess('system'))

					display: none;
					@endif
				">
					<span>System</span>
				</div>


				<div class="sellerbutton bg-reports" id='reportsbutton'
				style="@if(!Auth::user()->hasAccess('report'))
					display: none;

				@endif
				"
				>
					<span>Reports</span>
				</div>


				<a href="javascript:void(0)" class="sellerab" id="inventorybuttona"
				style="@if(!Auth::user()->hasAccess('inventory'))
				display: none;
				@endif
				"
				>
					<div class="sellerbutton bg-inventory" id="inventorybutton">
						Inventory
					</div>
				</a>


				<div class="sellerbutton" id='oshopbutton' style="background-color: #FF0000;
				@if(!Auth::user()->hasAccess('oshop'))
					display: none;
				@endif
				">
					<span>O-Shop</span>
				</div>

				@if($mode=="osm" || empty($mode))
				<a href="{{$dashboard_url}}" class="sellerab">
					<div class="sellerbutton" id='salesbutton'
						style="background-color: #ffcc99;">
						Online
					</div>
				</a>
				@endif
				@if(Auth::user()->hasAccess('analytics'))
				<div class="sellerbutton hide_in_mps" id='analyticsbutton' style="background-color: #8EB4E3;">
					<span>Analytics</span>
				</div>
				@endif
				@if(Auth::user()->hasAccess('data'))
				<a href="{{$member_url}}" class="sellerab">
					<div class="sellerbutton" id='databutton'
						style="background-color: #D73942;">
						Data
					</div>
				</a>
				@endif
				@if(Auth::user()->hasAccess('specialoffer'))
				<a href="{{$specialoffer_url}}" class="sellerab hide_in_mps">
					<div class="sellerbuttontwo" id='spbutton'
						style="background-color: #FFCC66;">
						Special<br>Offer
					</div>
				</a>
				@endif
				<!-- This will crap out merchant accessing his own albu!!
				<a href="{{url('/album',$selluser->id)}}" class="sellerab">
				-->

				<a href="{{url('/album',$selluser->id)}}" class="sellerab">
					<div class="sellerbutton" id='albumbutton'
						style="background-color: #FF6666;">
						Album
					</div>
				</a>

				<a href="javascript:void(0)" rel="{{$selluser->id}}" class="sellerab token hide_in_mps">
					<div class="sellerbutton" style="background-color: #440344;">
						Token
					</div>
				</a>
				<!--
				<div class="sellerbutton" id='helpbutton' style="background-color: #A6A6A6;">
					<span>Help</span>
				</div>
				-->
				<div class="sellerdropdown" id="settingdropdown" >
					<a href="{{$information_url}}" class="sellerab">
						<div class="sellerbutton" style="background-color: #FF6666;">
							Info
						</div>
					</a>
					<a href="{{$fairmode_url}}" class="sellerab">
						<div class="sellerbutton bg-location">
							Location
						</div>
					</a>
 					<a href="#" class="sellerab">
						<div class="sellerbuttonlast bg-black">
							Global
						</div>
					</a>
				</div>
				<div class="sellerdropdown" style="margin-left: -10px"
					id="analyticsdropdown" >
					<a href="#" class="sellerab">
						<div class="sellerbutton"
							style="background-color: #8EB4E3;">
							Arowana
						</div>
					</a>
					<a href="{{$salesreport_url}}" class="sellerab">
						<div class="sellerbutton bg-beige">
							Sales
						</div>
					</a>
					<a href="{{$hyper_url}}" class="sellerab hide_in_mps">
						<div class="sellerbutton" style="background-color: #004080;">
							Hyper
						</div>
					</a>
					<a href="{{$likes_url}}" class="sellerab">
						<div class="sellerbutton" style="background-color: #FF0080;">
							Likes
						</div>
					</a>
					<a href="{{$discount_url}}" class="sellerab">
						<div class="sellerbutton" style="background-color: #4F6228;">
							Discount
						</div>
					</a>
 					<a href="{{ url('/voucher') }}" class="sellerab">
						<div class="sellerbutton" style="background-color: #0580fe;">
							Voucher
						</div>
					</a>
				</div>

				<div class="sellerdropdown" style="margin-left: -10px"
					id="reportsdropdown" >

					<a href="{{$documents_url}}" class="sellerab">
						<div class="sellerbutton bg-reports">
							Document
						</div>
					</a>

					@if(Auth::user()->hasAccess('ageing'))
					<a href="{{$ageings_url}}" class="sellerab">
						<div class="sellerbutton bg-ageing"
							style="padding-top:18px;">
							&nbsp;Ageing&nbsp; &nbsp;Reports&nbsp;
						</div>
					</a>
					@endif
				</div>

				<div class="sellerdropdown" id="oshopdropdown" >
					@def $oc=0
					@foreach($oshops as $oshop)
					<a link="{{route('oshop.one',['url'=>$oshop->url])}}"
						 class="sellerab oshopdd" >
						<div class="sellerbutton"
							style="z-index:10;background-color: #FF6666;">
							{{$oshop->oshop_name}}
						</div>
					</a>
					@def $oc+=1
					@endforeach
				</div>
				<div class="sellerdropdown" id="systemdropdown" >
					{{-- <a href="javascript:void(0)" class="sellerab hide_in_mps"
						id="sellermodalusage">
						<div class="sellerbutton" id="usagebutton"
							style="background-color: #A9C9C8;">
							Usage
						</div>
					</a> --}}

					<a href="javascript:void(0)" id="jaguarbuttona"
						class="sellerab"
						style="@if(!Auth::user()->hasAccess('jaguar'))
						display: none;
						@endif">
						<div class="sellerbutton" id="jaguarbutton"
							style="background-color: #F396D4;">
							XJaguar
						</div>
					</a>

 					<a href="{{url('/seller/jaguar',$selluser->id)}}" id="njaguarbuttona"
						class="sellerab"
						style="@if(!Auth::user()->hasAccess('jaguar'))
						display: none;
						@endif">
						<div class="sellerbutton bg-jaguar" id="njaguarbutton">
							Jaguar
						</div>
					</a>

  					<a href="{{url('/seller/consign',$selluser->id)}}" id="consignbuttona"
						class="sellerab"
						style="@if(!Auth::user()->hasAccess('consign'))
						display: none;
						@endif">
						<div class="sellerbutton bg-ageing" id="consignbutton">
							Consign
						</div>
					</a>

   					<a href="{{url('/seller/quotation',$selluser->id)}}" id="poquotebuttona"
						class="sellerab"
						style="@if(!Auth::user()->hasAccess('poquote'))
						display: none;
						@endif">
						<div class="sellerbuttontwo bg-poquote"
							id="poquotebutton">
							PO<br>Quotation
						</div>
					</a>



					<!-- Currently no links under System/Caiman -->
					<!--
					<a class="sellerab">
						<div class="sellerbutton"
							style="background-color: #6666FF;">
							Caiman
						</div>
					</a>
					-->

 					<a href="{{url('seller/gator',$selluser->id)}}" class="sellerab"
 					style="@if(!Auth::user()->hasAccess('gator')) display: none; @endif"
 					>
						<div class="sellerbutton bg-gator">
							Gator
						</div>
					</a>


					<a href="#" id="terminalId"
					style="@if(!Auth::user()->hasAccess('opossum'))
					display: none;
					@endif
					"
						class="sellerab hide_in_mps">
						<div class="sellerbutton bg-opossum" id="OPOSsumbutton">
							OPOSsum
						</div>
					</a>


 					<a href="{{$Arapaima_url}}" id="arowanaa"

 						style="@if(!Auth::user()->hasAccess('arapaima'))
 						display: none;

 						@endif
 						"
						class="sellerab hide_in_mps">
						<div class="sellerbutton bg-arowana" id="arowana">
							Arapaima
						</div>
					</a>
					<?php
						$css = '';
						if(!Auth::user()->hasAccess('logistics')){
							$css = 'display:none';
						}
					?>
					
   					<a href="{{$deliveryorder_url}}" class="sellerab" style="{{$css}}"> 
						<div class="sellerbutton"
							style="background-color: #6d9370;">
							Logistics
						</div>
					</a>

					<a href="{{ url('sellerWarehouse',$selluser->id) }}" class="sellerab"
					style="@if(!Auth::user()->hasAccess('warehouse'))
					display: none;
					@endif
					"
						id="warehouse">
						<div class="sellerbutton bg-warehouse">
							Warehouse
						</div>
					</a>


 					<a href="{{ $warrenty_management }}" id="rawbuttona" class="sellerab hide_in_mps"
 					style="@if(!Auth::user()->hasAccess('raw'))
 					display: none;
 					@endif
 					"

 					>
						<div class="sellerbutton bg-raw" id="rawbutton">
							RaW
						</div>
					</a>

					<!--
  					<a href="{{$staff_url}}" id="hcapbuttona" class="sellerab">
					-->

  					<a href="javascript:void(0)" id="hcapbuttona" class="sellerab hide_in_mps"
  					style="@if(!Auth::user()->hasAccess('humancap'))
  					display: none;

  					@endif
  					"

  					>
						<div class="sellerbutton bg-humancap"
							style="font-size:11px" id="hcapbutton">
							HumanCap
						</div>
					</a>


   					<a href="{{ $wallet_management }}" id="walletbuttona" class="sellerab hide_in_mps"
   					style="@if(!Auth::user()->hasAccess('wallet'))
   					display: none;
   					@endif
   					"

   					>
						<div class="sellerbutton bg-wallet"
							style="" id="walletbutton">
							Wallet
						</div>
					</a>

					<!--
   					<a href="#" id="octopusbuttona" class="sellerab">
						<div class="sellerbutton bg-octopus"
							style="" id="octopusbutton">
							Octopus
						</div>
					</a>
   					<a href="#" id="rhinobuttona" class="sellerab">
						<div class="sellerbuttontwo bg-billing"
							style="" id="rhinobutton">
							Rhino<br>Consign
						</div>
					</a>
   					<a href="#" id="tapirbuttona" class="sellerab">
						<div class="sellerbuttontwo bg-tapir"
							style="" id="tapirbutton">
							Tapir<br>Invoice
						</div>
					</a>
					-->
					<!--
   					<a href="#" id="billingbuttona" class="sellerab">
						<div class="sellerbuttontwo bg-billing"
							style="" id="billingbutton">
							Parrot<br>Billing
						</div>
					</a>
   					<a href="#" id="productbuttona" class="sellerab">
						<div class="sellerbuttontwo bg-anaconda"
							style="" id="productbutton">
							Anaconda<br>Product
						</div>
					</a>
					<a href="#" id="productbuttona" class="sellerab">
						<div class="sellerbutton bg-black"
							style="" id="productbutton">
							Account
						</div>
					</a>
 					<a href="#" id="productbuttona" class="sellerab">
						<div class="sellerbuttontwo bg-black"
							style="" id="productbutton">
							Cloud<br>Leopard
						</div>
					</a>
					-->

  					<a href="#" id="belugabuttona" class="sellerab"
  					style="@if(!Auth::user()->hasAccess('beluga'))
  					display: none;
  					@endif
  					"
  					>
						<div class="sellerbutton bg-beluga"
							style="" id="belugabutton">
							Beluga
						</div>
					</a>

				</div>
				@if(Auth::user()->hasRole('onz'))
				<div class="sellerdropdownchild" id="belugadropdown"
					style="background-color: rgba(255, 255, 255, 0.5);">
					<a href="javascript:void(0);"
						onclick="onz_approval()"
					 class="sellerab">
						<div class="sellerbuttontwo bg-beluga">
							&nbsp;Confirm&nbsp; &nbsp;Approval&nbsp;
						</div>
					</a

				</div>
				@endif
				<div class="sellerdropdownchild" id="jaguardropdown"
					style="background-color: rgba(255, 255, 255, 0.5);">
					<a href="{{ $procurement_url }}" class="sellerab">
						<div class="sellerbuttontwo bg-paymentgw">
							&nbsp;Payment&nbsp; &nbsp;Gateway&nbsp;
						</div>
					</a>
					<a href="{{ $procurementterm_url }}" class="sellerab">
						<div class="sellerbuttontwo"
							style="background-color: #F396D4;">
							&nbsp;Credit&nbsp; &nbsp;Term&nbsp;
						</div>
					</a>
					<a href="{{ $tproducts_url }}" class="sellerab">
						<div class="sellerbutton"
							style="background-color: #F396D4;">
							Term Info
						</div>
					</a>
					<a href="{{ $breceipt_url }}" class="sellerab">
						<div class="sellerbutton"
							style="background-color: #0000FF;">
							Bought
						</div>
					</a>
					<a href="{{ $debitnote_url }}" class="sellerab">
						<div class="sellerbutton"
							 style="background-color: #F396D4;">
							Debit Note
						</div>
					</a>
				</div>
				<div class="sellerdropdown" id="inventorydropdown">
					<a href="{{url('merchant/inventory',$selluser->id)}}" class="sellerab">
						<div class="sellerbuttontwo bg-inventory">
							&nbsp;Merchant&nbsp; &nbsp;Inventory&nbsp;
						</div>
					</a>
					<a href="{{url('inventorycost',$selluser->id)}}" class="sellerab">
						<div class="sellerbuttontwo bg-inventory">
							&nbsp;Inventory&nbsp; &nbsp;Cost&nbsp;
						</div>
					</a>
				</div>
				<div class="oposumdropdown" id="OPOSsumdropdown"
					style="background-color: rgba(255, 255, 255, 0.5);">
					<a href="#" id="terminalId"
						class="sellerab">
						<div class="sellerbutton bg-opossum" id="">
							Terminal
						</div>
					</a>
					<a href="#" id=""
						class="sellerab">
						<div class="sellerbutton bg-beige" id="">
							Cash
						</div>
					</a>
				</div>
  				<div class="sellerdropdownchild" id="hcapdropdown"
					style="background-color: rgba(255, 255, 255, 0.5);">
					<a href="{{$staff_url}}" id="" class="sellerab">
						<div class="sellerbutton bg-humancap" id="">
							Staff
						</div>
					</a>
					<a href="{{$scheduler_url}}" id="" class="sellerab">
						<div class="sellerbutton bg-scheduler" id="">
							Scheduler
						</div>
					</a>
				</div>
				<!--
 				<div class="sellerdropdownchild" id="rawdropdown"
					style="background-color: rgba(255, 255, 255, 0.5);">
					<a href="#" id="" class="sellerab">
						<div class="sellerbutton bg-opossum" id="">
							Chit
						</div>
					</a>
					<a href="#" id="" class="sellerab">
						<div class="sellerbuttontwo bg-beige" id="">
							Define<br>Model
						</div>
					</a>
				</div>
				-->
			@endif
			<br>
		</div>
	</div>
</div>

    <!-- TOKEN -->
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
							</div>
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
	{{-- Generic Modal to be reused. --}}
	<div id="genericSellerMenuModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="min-width:80% !important;max-width:90%;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header"
		style="border-top-left-radius:5px;border-top-right-radius:5px"
		id="genericSellerMenuModalHeader">
      	<h3 class="modal-title" id="genericSellerMenuModalTitle">
			Modal Header</h3>
        <button type="button" class="close"
			style="position:relative;top:-25px;color:white"
			data-dismiss="modal">&times;</button>

      </div>
      <div class="modal-body" id="genericSellerMenuModalBody">

      </div>
      <div class="modal-footer">
      </div>
    </div>

  </div>
</div>
 	<!--Usage-->
	<div class="modal fade" id="myModalUsage" role="dialog" aria-labelledby="myModalUsage">
		<div class="modal-dialog" role="remarks" style="width: 58%">
			<div class="modal-content">
        <div class="row">
					<div class="col-sm-12">
						<div class='row'>
							<div class='col-sm-5 usage'>
								<div class="wrapper">
									<h4>System Usage</h4>
									<div class="row variable_wrapper usage_selected" id="usage_caiman">
										<div class='col-sm-6 variable'>
											<a href='javascript:void(0)' id="_caiman">Caiman</a>
										</div>
										<div class='col-sm-6 value'>5</div>
									</div>
									<div class="row variable_wrapper" id="usage_jaguar">
										<div class='col-sm-6 variable'><a href='javascript:void(0)' id="_jaguar">Jaguar</a></div>
										<div class=' col-sm-6 value'>5</div>
									</div>
									<div class="row variable_wrapper" id="usage_user">
										<div class='col-sm-6 variable'><a href='javascript:void(0)' id="_user">Additional User</a></div>
										<div class=' col-sm-6 value'>3</div>
									</div>
									<div class="row variable_wrapper" id="usage_max">
										<div class='col-sm-6 variable'><a href='javascript:void(0)' id="_max">Max</a></div>
										<div class='col-sm-6 value'>13</div>
									</div>
									<div class="row variable_wrapper" id="usage_m_token">
										<div class='col-sm-6 variable'><a href='javascript:void(0)' id="_m_token">Monthly Token Deduction</a></div>
										<div class='col-sm-6 value'>1300</div>
									</div>
									<div class="row variable_wrapper" id="usage_t_token">
										<div class='col-sm-6 variable'><a href='javascript:void(0)' id="_t_token">Total Available Tokens</a></div>
										<div class='col-sm-6 value'>2000</div>
									</div>
									<div>
										<div class="variable">
											<div class='row'>
											<div class="col-sm-4 add">Additional</div>
											<div  class="col-sm-4">Qty</div>
											<div class="col-sm-4">Token</div>
											</div>
										</div>
										<div class="value1">
											<div class='row'>
											<div class="col-sm-4">One Head</div>
											<div class="col-sm-4">1</div>
											<div class="col-sm-4 per">100/month</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class='col-sm-5 usage'>
								<div class="wrapper">
									<h4 id="to_change">Caiman</h4>
									<table>
										<tr>
											<td>Max</td>
											<td>Used</td>
											<td>Available</td>
										</tr>
										<tr>
											<td>13</td>
											<td>12</td>
											<td>1</td>
										</tr>
									</table>
									<div class='caiman'>
										<div class='row part'>
											<div class='col-sm-12 header'>
												<div class='col-sm-6'>Staff</div>
												<div class='col-sm-6'>26</div>
											</div>
											<div class='col-sm-12'>
												<div class='col-sm-6 green'>Paid</div>
												<div class='col-sm-6 '>11</div>
											</div>
											<div class='col-sm-12'>
												<div class='col-sm-6 blue'>Total</div>
												<div class='col-sm-6'>15</div>
											</div>
										</div>
										<div class='row part'>
											<div class='col-sm-12 header'>
												<div class='col-sm-6'>Station/Dealer</div>
												<div class='col-sm-6'>130</div>
											</div>
											<div class='col-sm-12'>
												<div class='col-sm-6 red'>Paid</div>
												<div class='col-sm-6'>1</div>
											</div>
											<div class='col-sm-12'>
												<div class='col-sm-6 brown'>Subscriber</div>
												<div class='col-sm-6'>30</div>
											</div>
											<div class='col-sm-12'>
												<div class='col-sm-6 yellow'>Total</div>
												<div class='col-sm-6'>100</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
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
									$product1 = DB::table('product')->select('product.*')->join('tokenuserproduct','tokenuserproduct.product_id','=','product.id')->where('tokenuserproduct.user_id',$selluser->id)->where('product.id',$tglobals->token_product_id1)->first();
								}
								if(property_exists($tglobals, 'token_product_id2')){
									$product2 = DB::table('product')->select('product.*')->join('tokenuserproduct','tokenuserproduct.product_id','=','product.id')->where('tokenuserproduct.user_id',$selluser->id)->where('product.id',$tglobals->token_product_id2)->first();
								}
								if(property_exists($tglobals, 'token_product_id3')){
									$product3 = DB::table('product')->select('product.*')->join('tokenuserproduct','tokenuserproduct.product_id','=','product.id')->where('tokenuserproduct.user_id',$selluser->id)->where('product.id',$tglobals->token_product_id3)->first();
								}
								if(property_exists($tglobals, 'token_product_id4')){
									$product4 = DB::table('product')->select('product.*')->join('tokenuserproduct','tokenuserproduct.product_id','=','product.id')->where('tokenuserproduct.user_id',$selluser->id)->where('product.id',$tglobals->token_product_id4)->first();
								}
								if(property_exists($tglobals, 'token_product_id5')){
									$product5 = DB::table('product')->select('product.*')->join('tokenuserproduct','tokenuserproduct.product_id','=','product.id')->where('tokenuserproduct.user_id',$selluser->id)->where('product.id',$tglobals->token_product_id5)->first();
								}
							?>
								<div class='row'>
									<div class='col-sm-4'><p align="center"><label style="font-size: 16px;"><b>&nbsp;</b></label></p></div>

									<div class='col-sm-8'><p align="center"><label style="font-size: 16px;text-align: center"><b style="font-size: 18px;">
							Tokens Available: <span class="availability">{{number_format($qty_token,0,'.','')}}</span>
							</b></label></p></div>
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

	<div class="modal fade" id="cashManageModel" role="dialog" aria-labelledby="cashManageModal">
		<div class="modal-dialog" role="remarks" style="width: 800px;">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="head_seller">Terminal List
						<small>
							<button type="button" class="close pull-right"
							data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span></button>
						</small>
					</h3>
					<div class="modal-body">
						<div class="table-css">
							<table class="table table-bordered" id="cash-manage-ledger-table">
								<thead>
									<tr class="bg-opossum tr_class_css">
										<th class="text-center">No.</th>
										<th class="text-center">Terminal&nbsp;ID</th>
										<th class="text-center">Branch&nbsp;Sales Report</th>
										<th class="text-center">Cash&nbsp;({{$currentCurrency}})</th>
										<th class="text-center">SST</th>
										<th class="text-center">Business&nbsp;Type</th>
										<th class="text-center">i/e</th>
									</tr>
								</thead>
								<tbody id="cml-tbody"></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
{{-- SST Update Modal --}}
<div id="terminal_sst_updateModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div style="width:300px" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">Sales and Service Tax</h3>
      </div>
      <div class="modal-body">
        <input type="hidden" id="terminal_sst_update_id">
		<div class="radio1">
		<label>
		<input type="radio" name="terminalservicetaxvalue" value="0">
			&nbsp;0%</label>
		</div>
		<div class="radio1">
		<label>
		<input type="radio" name="terminalservicetaxvalue" value="6">
			&nbsp;6%</label>
		</div>

      </div>
      <div class="modal-footer">
	  <!--
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
		-->

        <button type="button" class="btn btn-primary pull-right" data-dismiss="modal" id="terminal_sst_update_save">Save</button>
      </div>
    </div>

  </div>
</div>
{{-- SST Update Modal --}}
<div id="terminal_mode_updateModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div style="width:300px" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">Mode</h3>
      </div>
      <div class="modal-body">
        <input type="hidden" id="terminal_mode_update_id">
		<div class="radio1">
		<label>
		<input type="radio" name="terminalmodevalue" value="inclusive">
			&nbsp;Inclusive</label>
		</div>
		<div class="radio1">
		<label>
		<input type="radio" name="terminalmodevalue" value="exclusive">
			&nbsp;Exclusive</label>
		</div>

      </div>
      <div class="modal-footer">
	  <!--
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
		-->

        <button type="button" class="btn btn-primary pull-right" data-dismiss="modal" id="terminal_mode_update_save">Save</button>
      </div>
    </div>

  </div>
</div>
<script type="text/javascript">
	<?php

	?>
	$(document).ready(function(){
		@if($mode=="onz")
			$(".hide_in_mps").css("display","none");
		@endif
	})

</script>

<script type="text/javascript">
	$(document).ready(function () {
		var lm = 5;
		var settingposition = $("#settingbutton").position();
		var reportsposition = $("#reportsbutton").position();
		var analyticsposition = $("#analyticsbutton").position();
		var oshopposition = $("#oshopbutton").position();
		var systemposition = $("#systembutton").position();

		var inventoryposition = $("#inventorybutton").position();
		var rawposition = $("#rawbutton").position();
		var hcapposition = $("#hcapbutton").position();
		var sellerwidth = $(".sellerbutton").width();
		$("#settingdropdown").css('marginLeft', -lm);

		var reportsmargin = reportsposition.left - settingposition.left;
		//console.log(analyticsmargin)
		$("#reportsdropdown").css('marginLeft', reportsmargin - lm);

		var analyticsmargin = analyticsposition.left - settingposition.left;
		//console.log(analyticsmargin)
		$("#analyticsdropdown").css('marginLeft', analyticsmargin - lm);

		var oshopmargin = oshopposition.left - settingposition.left;
		//console.log(analyticsmargin)
		$("#oshopdropdown").css('marginLeft', oshopmargin - lm);

		var systemmargin = systemposition.left - settingposition.left;
		//console.log(analyticsmargin)
		$("#systemdropdown").css('marginLeft', systemmargin - lm);

		var systemmargin = systemposition.left - settingposition.left;
		//console.log(analyticsmargin)
		$("#jaguardropdown").css('marginLeft', (systemmargin - (2*lm)) + (sellerwidth + (lm*2)));

        /*var systemmargin = systemposition.left - settingposition.left;*/
        $("#belugadropdown").css('marginLeft', (systemmargin - (2*lm)) + (sellerwidth + (lm*2)));

        var inventorymargin = inventoryposition.left - settingposition.left;
		$("#inventorydropdown").css('marginLeft', inventorymargin - lm);

		$(document.body).click( function(event) {
  			if(event.target.id == "jaguarbutton" ||
			   event.target.id == "jaguarbuttona") {
				var t1 = $("#jaguarbutton").position().top;
				var top = t1 + (2*sellerwidth);

				var sys = systemposition.left - settingposition.left;
				var left = $("#jaguarbutton").position().left + sys - (2*lm);

				$(".sellerdropdownchild").css('marginLeft', left);
				$(".sellerdropdownchild").css('marginTop', top);
				$(".sellerdropdownchild").slideUp( 500, function() {});

			/*
			} else if (event.target.id == "rawbutton" ||
					   event.target.id == "rawbuttona") {
 				var t1 = $("#rawbutton").position().top;
				var top = t1 + (2*sellerwidth);
				var sys = systemposition.left - settingposition.left;
 				var left = $("#rawbutton").position().left + sys - (2*lm);

				$(".sellerdropdownchild").css('marginLeft', left);
				$(".sellerdropdownchild").css('marginTop', top);
				$(".sellerdropdownchild").slideUp( 500, function() {});
			*/

 			} else if(event.target.id == "belugabutton" ||
			   event.target.id == "belugabuttona") {
				var t1 = $("#belugabutton").position().top;
				var top = t1 + (2*sellerwidth);
				var sys = systemposition.left - settingposition.left;
				var left = $("#belugabutton").position().left + sys - (2*lm);

				$(".sellerdropdownchild").css('marginLeft', left);
				$(".sellerdropdownchild").css('marginTop', top);
				$(".sellerdropdownchild").slideUp( 500, function() {});

 			}else if (event.target.id == "hcapbutton" ||
					   event.target.id == "hcapbuttona") {
 				var t1 = $("#hcapbutton").position().top;
				var top = t1 + (2*sellerwidth);
				var sys = systemposition.left - settingposition.left;
 				var left = $("#hcapbutton").position().left + sys - (2*lm);

				$(".sellerdropdownchild").css('marginLeft', left);
				$(".sellerdropdownchild").css('marginTop', top);
				$(".sellerdropdownchild").slideUp( 500, function() {});

			} else {
				$(".sellerdropdown").slideUp( 500, function() {});
				$(".sellerdropdownchild").slideUp( 500, function() {});
			}

		/*
 			if(event.target.id != "jaguarbutton" &&
			   event.target.id != "jaguarbuttona"){
				$(".sellerdropdown").slideUp( 500, function() {});
				$(".sellerdropdownchild").slideUp( 500, function() {});
			} else {
				var t1 = $("#jaguarbutton").position().top;
				var top = t1 + (2*sellerwidth);
				$(".sellerdropdownchild").css('marginTop', top);
				$(".sellerdropdownchild").slideUp( 500, function() {});
			}

			if (event.target.id == "rawbutton") {
				if(event.target.id != "rawbutton" &&
				   event.target.id != "rawbuttona"){
					$(".sellerdropdown").slideUp( 500, function() {});
					$(".sellerdropdownchild").slideUp( 500, function() {});
				} else {
					var t1 = $("#rawbutton").position().top;
					var top = t1 + (2*sellerwidth);
					$(".sellerdropdownchild").css('marginTop', top);
					$(".sellerdropdownchild").slideUp( 500, function() {});
				}
			}
			*/



			// if(event.target.id == "OPOSsumbutton"){
			// 	if(event.target.id != "OPOSsumbutton" && event.target.id != "OPOSsumbuttona"){
			// 		$(".sellerdropdown").slideUp( 500, function() {});
			// 		$(".sellerdropdownchild").slideUp( 500, function() {});
			// 	} else {
			// 		$(".sellerdropdownchild").slideUp( 500, function() {});
			// 	}
			// }
		});

		$(document).delegate( '#settingbutton', "click",function (event) {
			$("#settingdropdown").slideToggle( 500, function() {
				// Animation complete.
			});
		});
		$(document).delegate( '#analyticsbutton', "click",function (event) {
			$("#analyticsdropdown").slideToggle( 500, function() {
				// Animation complete.
			});
		});

		$(document).delegate( '#reportsbutton', "click",function (event) {
			$("#reportsdropdown").slideToggle( 500, function() {
				// Animation complete.
			});
		});

		$(document).delegate( '#oshopbutton', "click",function (event) {
			$("#oshopdropdown").slideToggle( 500, function() {
				// Animation complete.
			});
			@if($oc<1 and $mode=="onz"){
				win=window.open("{{url()}}",'OpenSupermall',height=700,width=700)
				win.focus()
			}
			@endif
		});

		$(document).delegate( '#systembutton', "click",function (event) {
			$("#systemdropdown").slideToggle( 500, function() {
				// Animation complete.
			});
		});

		$(document).delegate( '#jaguarbutton', "click",function (event) {
			$("#jaguardropdown").slideToggle( 500, function() {
				// Animation complete.
			});
		});

        $(document).delegate( '#inventorybutton', "click",function (event) {
			$("#inventorydropdown").slideToggle( 500, function() {
				// Animation complete.
			});
		});

        $(document).delegate( '#hcapbutton', "click",function (event) {
			$("#hcapdropdown").slideToggle( 500, function() {
				// Animation complete.
			});
		});


        $(document).delegate( '#belugabutton', "click",function (event) {
			$("#belugadropdown").slideToggle( 500, function() {
				// Animation complete.
			});
		});



		// $(document).delegate( '#OPOSsumbuttona', "click",function (event) {
		// 	$("#OPOSsumdropdown").slideToggle( 500, function() {
		// 		// Animation complete.
		// 	});
		// });

		/*************** USAGE ************************/
		$(document).delegate( '#sellermodalusage', "click",function (event) {
			$(".modal").hide();
			$("#myModalUsage").modal('show');
		});
		$(document).delegate( '#_caiman', "click",function (event) {
			$(".row.variable_wrapper").removeClass("usage_selected");
			$("#usage_caiman").addClass("usage_selected");
			$("#to_change").html($("#_caiman").text());
		});
		$(document).delegate( '#_jaguar', "click",function (event) {
			$(".row.variable_wrapper").removeClass("usage_selected");
			$("#usage_jaguar").addClass("usage_selected");
			$("#to_change").html($("#_jaguar").text());
		});
		$(document).delegate( '#_user', "click",function (event) {
			$(".row.variable_wrapper").removeClass("usage_selected");
			$("#usage_user").addClass("usage_selected");
			$("#to_change").html($("#_user").text());
		});
		$(document).delegate( '#_max', "click",function (event) {
			$(".row.variable_wrapper").removeClass("usage_selected");
			$("#usage_max").addClass("usage_selected");
			$("#to_change").html($("#_max").text());
		});
		$(document).delegate( '#_m_token', "click",function (event) {
			$(".row.variable_wrapper").removeClass("usage_selected");
			$("#usage_m_token").addClass("usage_selected");
			$("#to_change").html($("#_m_token").text());
		});
		$(document).delegate( '#_t_token', "click",function (event) {
			$(".row.variable_wrapper").removeClass("usage_selected");
			$("#usage_t_token").addClass("usage_selected");
			$("#to_change").html($("#_t_token").text());
		});

		$(document).on("click",".terminal_sst_update",function(){
			terminal_id=$(this).attr('terminal_id')
			$("#terminal_sst_update_id").val(terminal_id)
			$("#terminal_sst_updateModal").modal("show");
		});

		$(document).on("click",".terminal_mode_update",function(){
			terminal_id=$(this).attr('terminal_id')
			//alert(terminal_id)
			$("#terminal_mode_update_id").val(terminal_id)
			$("#terminal_mode_updateModal").modal("show");
		});

		/*************** TOKEN ************************/
		$(document).delegate( '.token', "click",function (event) {
			$("#tokenuser").val($(this).attr("rel"));
			$("#myModalTokens").modal('show');
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
				//	setTimeout(function(){ window.location = JS_BASE_URL + "/cart"; }, 1000);

				}
			});
		});
		$("body").on("click",".oshopdd",function(){
			url=$(this).attr('link')

			@if($mode=="onz" && $oc>0)
			win=window.open(url,'',height=700,width=700);

			@else
			win=window.open(url, '_blank');

			@endif
			win.focus();
		})
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

        $("select[name='cash-manage-ledger-table_length']").select2("destroy");
	});

	// Modal for Cash Managment Ledger
		// Press Button Modal Opens
		// Ajax Request to GET data
		// Click Cash POS opens

	var cashLedger = $("#cash-manage-ledger-table").DataTable({
		'autoWidth':false,
		"columnDefs": [
			/*
			{"targets":'no-sort',"orderable":true,"className":"text-center"},
			{"targets":"medium", "width":  "80px","className":"text-center"},
			{"targets":"bmedium", "width": "10px","className":"text-center"},
			{"targets":"large",  "width": "120px","className":"text-center"},
			{"targets":"approv", "width": "180px","className":"text-center"},
			{"targets":"blarge", "width": "200px","className":"text-center"},
			{"targets":"bsmall",  "width": "20px","className":"text-center"},
			{"targets":"clarge", "width": "250px","className":"text-center"},
			{"targets":"xlarge", "width": "300px","className":"text-center"}
			*/
            {
                "targets": 0,
                "className": "text-center"
            },
            {
                "targets": 1,
                "className": "text-center"
            },
            {
                "targets": 2,
                "className": "text-center"
            },
			/* "targets": 3, */
            {
                "targets": 3,
                "className": "text-right"
            },
            {
                "targets": 4,
                "className": "text-right"
            },
            {
                "targets": 5,
                "className": "text-center"
            },
             {
                "targets": 6,
                "className": "text-center"
            }
		],
        columns: [
            { data: 'index' },
            { data: 'terminal_id' },
            { data: 'branch' },
            { data: 'cash' },
            {data:'servicetax'},
            {data:'bfunction'},
            {data:'mode'}
        ]
	});


	$("#terminalId").click(function(event){
		event.preventDefault();
		$('#cashManageModel').modal('show');
	});


	/* This populates Terminal List */
	$.ajax({
		type:'GET',
		url: "{{route('getTerminalList',$selluser->id)}}",
		success: function(res){
            cashLedger.clear();
            cashLedger.rows.add(res['data']);
            cashLedger.draw();
			$('#select2-container').empty();
			console.log(res);
		},
		error:function(err){
			console.log(err);
		}
	});

    function pad (str, max) {
        str = str.toString();
        return str.length < max ? pad("0" + str, max) : str;
    }
    $("#terminal_sst_update_save").click(function(){
    	terminal_id=$("#terminal_sst_update_id").val();
    	action="update_sst";
    	if (!terminal_id) {return}
    	servicetax=$('input[name=terminalservicetaxvalue]:checked').val();
    	$.ajax({
    		type:"POST",
    		url:"{{url('terminal/update')}}",
    		data:{terminal_id,servicetax,action},
    		success:function(r){
    			if (r=="ok") {
    				$("#terminal_sst_"+terminal_id).text(servicetax+"%");
    			}
    		}

    	})
    })
    $("#terminal_mode_update_save").click(function(){
    	terminal_id=$("#terminal_mode_update_id").val();
    	action="update_mode";
    	if (!terminal_id) {return}
    	mode=$('input[name=terminalmodevalue]:checked').val();
    	$.ajax({
    		type:"POST",
    		url:"{{url('terminal/update')}}",
    		data:{terminal_id,mode,action},
    		success:function(r){

    			$("#terminal_mode_"+terminal_id).text(r);

    		}

    	})
    })
    function onz_approval() {
    	url="{{url('onz/confirmation/approval/view')}}";
    	$("#genericSellerMenuModalTitle").text("Confirmation Approval");
    	$("#genericSellerMenuModalHeader").addClass("bg-beluga");
    	$("#genericSellerMenuModalBody").load(url);
    	$("#genericSellerMenuModal").modal("show");
    }
</script>
@endif

