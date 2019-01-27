<?php
use App\Classes;
define('MAX_COLUMN_TEXT', 20);
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>

@extends("common.default")

@section("content")
<style type="text/css">
    .overlay{
        background-color: rgba(1, 1, 1, 0.7);
        bottom: 0;
        left: 0;
        position: fixed;
        right: 0;
        top: 0;
        z-index: 1001;
    }
    .overlay p{
        color: white;
        font-size: 72px;
        font-weight: bold;
        margin: 300px 0 0 55%;
    }
    .action_buttons{
        display: flex;
    }
    .role_status_button{
        margin: 10px 0 0 10px;
        width: 85px;
    }
    #admin-master-modal{
        background-color: white;
    }
    /*dialoguebox*/
	/*  label, input { display:block; } commented due to search label error */
    /*textArea {height: 200px;margin-bottom: 28px;width: 100%;}*/
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .ui-dialog{z-index: 10001}
    .ui-widget-overlay{z-index: 1000
    }
    .fade {
    opacity: 0;
    -webkit-transition: opacity 0.15s linear;
    -moz-transition: opacity 0.15s linear;
    -o-transition: opacity 0.15s linear;
    transition: opacity 0.15s linear;
}
	table#cre_details_table
    {
        table-layout: fixed;
        max-width: none;
        width: auto;
        min-width: 100%;
    }
</style>
<div class="modal fade" id="myModalRemarks" role="dialog" aria-labelledby="myModalRemarks">
	<div class="modal-dialog" role="remarks" style="width: 50%">
		<div class="modal-content">
			<div class="row" style="padding: 15px;">
				<div class="col-md-12" style="">
					<form id="remarks-form">
						<fieldset>
							<h2>Remarks</h2>
							<br>
							<textarea style="width:100%; height: 250px;" name="name" id="status_remarks" class="text-area ui-widget-content ui-corner-all">
							</textarea>
							<br>
							<input type="button" id="save_remarks" class="btn btn-primary" value="Save Remarks">
							<input type="hidden" id="current_role_roleId" remarks_role="" >
							<input type="hidden" id="current_status" value="" >
						</fieldset>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>				
		</div>			
	</div>	
</div>
<?php $i = 1; ?>
<div class="overlay" style="display:none;">
    <p><span style="position: relative;" class="all-filter-fa"><i class="fa-li fa fa-spinner fa-spin fa fa-fw"></i></span></p>
</div>
<div style="display: none;" class="removeable alert">
    <strong id='alert_heading'></strong><span id='alert_text'></span>
</div>

<div class="container" style="margin-top:30px; margin-bottom:30px;">
    @include('admin/panelHeading')

    @if(isset($merchants))
    <h2>MerchantsXXXXXXXXXXXXXXXXXXXXXXXXX</h2>
    {!! $merchants->render() !!}
    <div class="table-responsive1">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="1">Account Information</th>
                    <th colspan="6" class="text-center">Company Details</th>
                    <th>Shop Details</th>
                    <th>Brand Details</th>
                    <th>Remarks</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <th>No</th>
                    <th>company name</th>
                    <th>Domicile</th>
                    <th>Business Type</th>
                    <th>GST</th>
                    <th>Websites</th>
                    <th>Social Media</th>
                    <th>O-Shop Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach($merchants as $merchant)
                <tr>
                    <td>
                        {{ $merchant->id }}
                    </td>

                    <td>
                        {{ $merchant->company_name }}
                    </td>

                    <td>
                        @foreach($merchant->address()->get() as $address)
                        {{ $address->id }}
                        @endforeach
                    </td>

                    <td>
                        {{ $merchant->business_type }}
                    </td>

                    <td>
                        {{ $merchant->gst }}
                    </td>

                    <td>
                        @foreach($merchant->websites()->get() as $website)
                        {{ $website->url }}
                        @endforeach
                    </td>

                    <td>
                        @foreach($merchant->socialmedia()->get() as $socialmedia)
                        {{ $socialmedia->url }}
                        @endforeach
                    </td>

                    <td>
                        {{ $merchant->oshop_name }}
                    </td>

                    <td>
                        @foreach($merchant->brand()->get() as $brand)
                        {{ $brand->name }}
                        @endforeach
                    </td>

                    <td>
                        {{ $merchant->remarks }}
                    </td>
                    <td id="status_column">
                        <span id="status_column_text">
                            {{ $merchant->status }}
                        </span>
                    </td>
                    <td>
                        <div class="action_buttons">
							<?php
							$approve = new Classes\Approval('merchant', $merchant->id);
							echo $approve->view;
							?>
                        </div>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if(isset($stations_approval))
    <div class='col-xs-6 no-padding'><h2>Station Master: Status</h2></div>
	<div class='col-xs-6 no-padding'>
		@if(!is_null($idstation))
			<a class="btn btn-default role_status_button pull-right add_remark" role="station" do_status="add_remark" current_role_id="{{$idstation->id}}" style="width: 110px !important;" href="javascript:void(0)"> Add Remark </a>
		@else
			&nbsp;
		@endif
	</div>
    <span  id="station-error-messages">
    </span>

    <div class="tableData">
        <div class="table-responsive1">
            <table class="table table-bordered" cellspacing="0" width="100%" id="station_details_table">

                <thead>
                    <tr style="background-color: #4E2E28; color: #fff;">
                        <th class="text-center bmedium">Station&nbsp;ID</th>
                        <th class="text-center blarge">Company&nbsp;Name</th>
						<th class="text-center bmedium no-sort">Manager</th>
                        <th class="text-center bmedium">Documents</th>
						<th class="text-center bmedium">PWD</th>
						<th class="text-center xlarge" style="background-color:#008000;color:#fff">Remarks</th>
						{{--
                        <th class="text-center medium" style="background-color:#008000;color:#fff">Status</th>
						--}}
                        <th class="text-center no-sort approv" style="background-color:#008000;color:#fff">Approval</th> 
                    </tr>
                <thead>
                <tbody>

                    @foreach($stations_approval as $station)
                    <tr>
                        <td class="text-center">
						<?php
							$merchant = DB::table('merchant')->where('user_id',$station->user_id)->pluck('id');
						?>
                        <a href="javascript:void(0)" class="view-station-modal" data-id="{{ $merchant }}"> {{IdController::nSeller($station->user_id)}} </a>
						</td>
                        <td>
                            {{ $station->company_name }}
                        </td>
						<td class="text-center">
			 
                        <a href="javascript:void(0);" class="view-details-table-modal" data-st-id="{{$station->id}}">Details</a>
					
						</td>
                        <td class="text-center">
                            <select class="selectstationchannel" rel="{{$station->user_id}}">
                                <option value="">Select</option>
                                <option value="statement/receipt/{{$station->user_id}}">Receipt</option>
                                <option value="statement/overall-statement/{{$station->user_id}}">Statement</option>
                            </select>
                        </td>
						<td class="text-center">
						<?php
						$stationemail = "";
						if(!is_null($station->user()->first())){
							$stationemail = $station->user()->first()->email;
						}
						?>						
							<a rel="{{ $stationemail }}" class="pwd_reset" href="javascript:void(0)">Reset</a>
						</td>						
                        <td id="remarks_column">
							<?php
							$remark = DB::table('remark')
									->select('remark')
									->join('stationremark',
										'stationremark.remark_id', '=', 'remark.id')
									->where('stationremark.station_id', $station->id)
									->orderBy('remark.created_at', 'desc')
									->first();

							/* Processed remark */
							$pfullremark = null;
							$premark = null;

							if ($remark) {
								$elipsis = "...";
								$pfullremark = $remark->remark;
								$premark = substr($pfullremark,0, MAX_COLUMN_TEXT);

								if (strlen($pfullremark) > MAX_COLUMN_TEXT)
									$premark = $premark . $elipsis;
							}
							?>
                            <a href="javascript:void(0)" id="mcrid_{{$station->id}}"
								class="mcrid" rel="{{$station->id}}">
							<span title='{{$pfullremark}}'>{{$premark}}</span>
                            </a>
                        </td>

						{{--
                        <td class="text-center" id="status_column">
                            <span id="status_column_text" >
                                {{ ucfirst($station->status) }}
                            </span>
                        </td>
						--}}

                        <td style="text-align: center;">
								<div class="action_buttons">
									<?php
									$approve = new Classes\Approval('station', $station->id);
									if ($station->status == 'active') {
										$approve->getSuspendButton();
									} else if ($station->status == 'suspended' || $station->status == 'rejected') {
										$approve->getReactivateButton();
									}
									echo $approve->view;
									?>
								</div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif	
	
    @if(isset($stations))
    <h2>Station Master (Active: {{$total_active->counting}})</h2>
    <span  id="station-error-messages">
    </span>

    <div class="tableData">
        <div class="table-responsive1">
            <table class="table table-bordered" cellspacing="0" width="100%" id="station_details_table">

                <thead>
                    <tr style="background-color: #4E2E28; color: #fff;">
                        <th class="text-center no-sort bsmall">No</th>
                        <th class="text-center bmedium">Station&nbsp;ID</th>
                       <!--  <th class="text-center blarge">Company&nbsp;Name</th> -->
                        <th class="text-center blarge">Station&nbsp;Name</th>
                        <th class="text-center bmedium">Details</th>
                     <!--    <th class="text-center blarge">Business&nbsp;Owner</th> -->
                     <!--    <th class="text-center bmedium">Outlet</th> -->
						<th class="text-center medium"
							style="background-color:#FF4C4C;color:#fff">Merchant</th>
                        <th class="text-center medium"
							style="background-color:#400080;color:#fff">Tokens</th>
                        <th class="text-center bmedium">OpenQue</th>
                    <!--    <th class="text-center bmedium no-sort">Manager</th>
                        <th class="text-center bmedium">StatementXXXXXXXX</th>
					 <!-- 	<th class="text-center bmedium">PWD</th>
                      	<th class="text-center xlarge"
							style="background-color:#008000;color:#fff">Remarks</th>
                        <th class="text-center medium"
							style="background-color:#008000;color:#fff">Status</th>-->
                      
                        <th class="text-center no-sort medium"
							style="background-color:#008000;color:#fff">Status</th>
                        <th class="text-center bedium sorting_asc" style="background-color: rgb(254, 102, 0); color: rgb(255, 255, 255); width: 116px;" tabindex="0" aria-controls="grid4c" rowspan="1" colspan="1" aria-label="
                        OpenCredit: activate to sort column descending" aria-sort="ascending">
                        OpenCredit</th>
                    </tr>
                <thead>
                <tbody>

                    @foreach($stations as $station)
                    <tr>
                        <td class="text-center">
                            {{$i++}}
                        </td>
                        <td class="text-center">
						<?php
							$merchant = DB::table('merchant')->where('user_id',$station->user_id)->pluck('id');
						?>						
                        <a href="javascript:void(0)" class="view-station-modal" data-id="{{ $merchant }}"> {{IdController::nSeller($station->user_id)}} </a>
						</td>
                        <!--  <td>
                            {{ $station->company_name }}
                        </td> -->

                        <td>{{$station->company_name}}</td>
						<td style="text-align: center;">
							<a class="approval_details" rel="{{ $station->id }}" target="_blank"  href="{{route('stationDetails', ['id' => $station->id])}}">Details</a>
						</td>
                       <!-- <td>

                        {{$station->contact_person}}</td>

                        <td class="text-center"><a href="javascript:void(0);" data-st-id="{{$station->id}}" class="view-outlet-table-modal"><?php 
							$nstations = DB::table('sproperty')->where('station_id',$station->id)->count();
						?>{{$nstations}}</a></td>-->
						<td class="text-center">
						<?php 
							$merchants_c = DB::table('merchant')->join('autolink','autolink.responder','=','merchant.id')->where('autolink.initiator',$station->user_id)->where('autolink.status','linked')->distinct()->count();
						?>
							<a rel="{{ $station->id }}" target="_blank" class="merchant_network" href="{{route('stationNetwork', ['id' => $station->id])}}">{{$merchants_c}}</a>
						</td>
						<td class="text-center">
							<a href="javascript:void(0)" class="free-tokens" id="free-tokens{{$station->user_id}}" data-id="{{$station->user_id}}">{{$station->tokens}}</a>
						</td>
                        <td class="text-center"><a href="javascript:void(0);" data-st-id="{{$station->id}}" class="view-oqueue-table-modal">OpenQue</a></td>
                <!--        <td class="text-center">
			 
                        <a href="javascript:void(0);" class="view-details-table-modal" data-st-id="{{$station->id}}">Details</a>
					
						</td>
                        <td class="text-center">
                            <select class="selectstationchannel" rel="{{$station->user_id}}">
                                <option value="">Select</option>
                                <option value="statement/receipt/{{$station->user_id}}">Receipt</option>
                                <option value="statement/overall-statement/{{$station->user_id}}">Statement</option>
                            </select>
                        </td>
				 <!-- 		<td class="text-center">
						<?php
						$stationemail = "";
						if(!is_null($station->user()->first())){
							$stationemail = $station->user()->first()->email;
						}
						?>						
							<a rel="{{ $stationemail }}" class="pwd_reset" href="javascript:void(0)">Reset</a>
						</td>	
                      <td id="remarks_column">
							<?php
							$remark = DB::table('remark')
									->select('remark')
									->join('stationremark',
										'stationremark.remark_id', '=', 'remark.id')
									->where('stationremark.station_id', $station->id)
									->orderBy('remark.created_at', 'desc')
									->first();

							/* Processed remark */
							$pfullremark = null;
							$premark = null;

							if ($remark) {
								$elipsis = "...";
								$pfullremark = $remark->remark;
								$premark = substr($pfullremark,0, MAX_COLUMN_TEXT);

								if (strlen($pfullremark) > MAX_COLUMN_TEXT)
									$premark = $premark . $elipsis;
							}
							?>
                            <a href="javascript:void(0)" id="mcrid_{{$station->id}}"
								class="mcrid" rel="{{$station->id}}">
							<span title='{{$pfullremark}}'>{{$premark}}</span>
                            </a>
                        </td>

                        <td class="text-center" id="status_column">
                            <span id="status_column_text" >
                                {{ ucfirst($station->status) }}
                            </span>
                        </td>

                        <td style="text-align: center;">
                            <div class="action_buttons">
								<?php
								$approve = new Classes\Approval('station', $station->id);
								if ($station->status == 'active') {
									$approve->getSuspendButton();
								} else if ($station->status == 'suspended' || $station->status == 'rejected') {
									$approve->getReactivateButton();
								}
								echo $approve->view;
								?>
                            </div>
                        </td>-->
                        
						<td style="text-align: center;">
							<a class="approval_details" rel="{{ $station->id }}" target="_blank"  href="{{route('stationApproval', ['id' => $station->id])}}">{{ ucfirst($station->status) }}</a>
						</td>
                        <td style="text-align: center;">Points&nbsp;{{number_format($station->ocredit/100,2)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
	
	
    @if(isset($stations_details))
    <h2>Station Master: Details</h2>
    <span  id="station-error-messages">
    </span>

    <div class="tableData">
        <div class="table-responsive1">
            <table class="table table-bordered" cellspacing="0" width="100%" id="station_details_table">

                <thead>
                    <tr style="background-color: #4E2E28; color: #fff;">
                        <th class="text-center no-sort bsmall">No</th>
                        <th class="text-center bmedium">Station&nbsp;ID</th>
                        <th class="text-center blarge">Company&nbsp;Name</th> 
                        <th class="text-center blarge">Business&nbsp;Owner</th> 
                        <th class="text-center bmedium">Outlet</th> 
                    </tr>
                <thead>
                <tbody>

                    @foreach($stations_details as $station)
                    <tr>
                        <td class="text-center">
                            {{$i++}}
                        </td>
                        <td class="text-center">
						
                        <a href="javascript:void(0)" class="view-station-modal" data-id="{{ $station->id }}"> {{IdController::nS($station->id)}} </a>
						</td>
                        <td>
                            {{ $station->company_name }}
                        </td> 

                        <td>

                        {{$station->contact_person}}</td>

                        <td class="text-center"><a href="javascript:void(0);" data-st-id="{{$station->id}}" class="view-outlet-table-modal"><?php 
							$nstations = DB::table('sproperty')->where('station_id',$station->id)->count();
						?>{{$nstations}}</a></td>
						</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif	

<div class="modal fade" id="myModalToken" role="dialog" aria-labelledby="myModalRemarks">
	<div class="modal-dialog" role="remarks" style="width: 55%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" align="center"
						id="myModalLabel">Token Control</h4>
			</div>
			<div class="modal-body">
				<div class="row" style="padding: 15px;">
					<div class="col-md-12" style="">	
						<!-- Only users which has role "AAP" is able use Grant -->
						@if(Auth::user()->hasRole('aap'))
							<div class="col-md-3 no-padding" style="">
								<input type="text" class="form-control"
									value="" placeholder="Free Tokens" id="tokens_add" />
							</div>
							<div class="col-md-3 no-padding" style="">
								<a href="javascript:void(0);"
									class="btn btn-primary add_tokens"
									style="background-color: #400080 !important; width: 100%;">Grant</a>
							</div>
							<div class="clearfix"> </div><br>
						@endif
						<div class="col-md-1 no-padding" style="">
							<center style="margin-top: 5px;">Qty</center>
						</div>
						<div class="col-md-3 no-padding" style="">
							<input type="text" class="form-control"
							value="" placeholder="Buy" id="tokens_buy" />
						</div>
						<div class="col-md-1 no-padding" style="">
							<center style="margin-top: 5px;">Price</center>
						</div>
						<div class="col-md-3 no-padding" style="">
							<input type="text" class="form-control"
								value="" placeholder="Free" id="tokens_free" />
						</div>
						<div class="col-md-3 no-padding" style="">
							<a href="javascript:void(0);"
								class="btn btn-primary add_tokens_offer"
								style="background-color: #400080 !important; width: 100%;">Grant</a>
						</div>
						<div class="clearfix"> </div><br>
							<?php
								$tglobals = DB::table('global')->first();
								$product1 = null;
								$product2 = null;
								$product3 = null;
								$product4 = null;
								$product5 = null;
								$checked_p1 = "";
								$checked_p2 = "";
								$checked_p3 = "";
								$checked_p4 = "";
								$checked_p5 = "";
								if(property_exists($tglobals, 'token_product_id1')){
									$product1 = DB::table('product')->where('id',$tglobals->token_product_id1)->first();
								}
								if(property_exists($tglobals, 'token_product_id2')){
									$product2 = DB::table('product')->where('id',$tglobals->token_product_id2)->first();
								}
								if(property_exists($tglobals, 'token_product_id3')){
									$product3 = DB::table('product')->where('id',$tglobals->token_product_id3)->first();
								}
								if(property_exists($tglobals, 'token_product_id4')){
									$product4 = DB::table('product')->where('id',$tglobals->token_product_id4)->first();
								}
								if(property_exists($tglobals, 'token_product_id5')){
									$product5 = DB::table('product')->where('id',$tglobals->token_product_id5)->first();
								}
							?>
								<div class='row no-padding'>
									<div class='col-sm-4'><p align="center"><b>Token</b></p></div>
									<div class='col-sm-4'>
										<p align="center"><b>Quantity</b></p>
									</div>
									<div class='col-sm-4'><p align="left"><b>Price</b></p></div>
								</div>
							@if(!is_null($product1))
								<div class='row no-padding'>
									<div class='col-sm-4'><p align="center"><label style="font-size: 16px;"><b><input type="checkbox" class="showhidetoken" rel="{{$product1->id}}" id="checked_p1" {{$checked_p1}} />&nbsp;{{$product1->name}}</b></label></p></div>
									<div class='col-sm-4'>
										<p align="center">{{number_format(( $product1->retail_price)/100)}}</p>
									</div>
									<div class='col-sm-4'>{{$currentCurrency}}&nbsp;{{number_format($product1->discounted_price/100)}}</div>
								</div>
							@endif
							@if(!is_null($product2))
								<div class='row no-padding'>
									<div class='col-sm-4 margint7' ><p align="center"><label style="font-size: 16px;"><b><input type="checkbox" class="showhidetoken" rel="{{$product2->id}}" id="checked_p2" {{$checked_p2}} />&nbsp;{{$product2->name}}</b></label></p></div>
									<div class='col-sm-4 margint7'>
										<p align="center">{{number_format(($product2->retail_price)/100)}}</p>
									</div>
									<div class='col-sm-4 margint7'>{{$currentCurrency}}&nbsp;{{number_format($product2->discounted_price/100)}}</div>	
								</div>
							@endif
							@if(!is_null($product3))
								<div class='row no-padding'>
									<div class='col-sm-4 margint7'><p align="center"><label style="font-size: 16px;"><b><input type="checkbox" class="showhidetoken" rel="{{$product3->id}}" id="checked_p3" {{$checked_p3}} />&nbsp;{{$product3->name}}</b></label></p></div>
									<div class='col-sm-4 margint7'>
										<p align="center">{{number_format(($product3->retail_price)/100)}}</p>
									</div>
									<div class='col-sm-4 margint7'>{{$currentCurrency}}&nbsp;{{number_format($product3->discounted_price/100)}}</div>
								</div>
							@endif
							@if(!is_null($product4))
								<div class='row no-padding'>
									<div class='col-sm-4 margint7'><p align="center"><label style="font-size: 16px;"><b><input type="checkbox" class="showhidetoken" rel="{{$product4->id}}" id="checked_p4" {{$checked_p4}} />&nbsp;{{$product4->name}}</b></label></p></div>
									<div class='col-sm-4 margint7'>
										<p align="center">{{number_format(( $product4->retail_price)/100)}}</p>
									</div>
									<div class='col-sm-4 margint7'>{{$currentCurrency}}&nbsp;{{number_format($product4->discounted_price/100)}}</div>
								</div>
							@endif
							@if(!is_null($product5))
								<div class='row no-padding'>
									<div class='col-sm-4 margint7'><p align="center"><label style="font-size: 16px;"><b><input type="checkbox" class="showhidetoken" rel="{{$product5->id}}" id="checked_p5" {{$checked_p5}} />&nbsp;{{$product5->name}}</b></label></p></div>
									<div class='col-sm-4 margint7'>
										<p align="center">{{number_format(($product5->retail_price)/100)}}</p>
									</div>							
									<div class='col-sm-4 margint7'>{{$currentCurrency}}&nbsp;{{number_format($product5->discounted_price/100)}}</div>	
								</div>
							@endif	
							<div class="clearfix"> </div><br>
							<div class='row no-padding'>
								<div class='col-sm-12 no-padding'>
									<table id="facilities_info" class="table table-bordered" width="100%">
										<thead style="background-color: #400080; color: #fff;"><th style="text-align:center">No</th><th style="text-align:center">Facility</th><th style="text-align:center">Annual Fee</th><th style="text-align:center">Variable</th><th style="text-align:center">Since</th></thead>
									</table>
								</div>
							</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
			
		</div>
	</div>		
</div>	
	
	@if(isset($cre_approval))
	<h2>Cancellation, Return &amp; Exchange Master: Status</h2>
    <div class="tableData">
        <div class="table-responsive1">
            <table class="table table-bordered" cellspacing="0" width="1480px" id="cre_details_table">
                <thead>
                <style type="text/css">
                                .sort{color: black;}              
                </style>
                    <tr style="background-color:#D8E26D; color: black;">
                        <th style="text-align:center;" class="no-sort text-center no-sort">No</th>
                        <th style="text-align:center;" class="large">Date</th>
						 <th style="text-align:center;" class="large">I&nbsp;wish&nbsp;to</th>
						 <th style="text-align:center;" class="large">Reasons</th>
						 <th style="text-align:center;" class="medium">Photo</th>
						 <th style="text-align:center;background-color:green;color:white" class="xxlarge">Reviews</th>
                        <th style="text-align:center;background-color:green;color:white" class="medium">Status</th>                     
                        <th style="text-align:center;background-color:green;color:white" class="xxlarge">Approval</th>
                    </tr>
                <thead>
                <tbody>
                    <?php $i=1;?>
                    @foreach($cre_approval as $record)
                    {{-- <> --}}
                    <tr style="border:1px solid black;" class="fit">
                        <td style="text-align: center;">
                            {{$i++}}
                        </td>
                        <td style="text-align: center;">{{UtilityController::s_date($record->created_at)}}</td>
						<td style="text-align:center;" class="large">{{ ucfirst($record->iwishto)}}</td>
						<td style="text-align:center;" class="large">
                            @if($record->status !== 'cancelled')
								{{ ucfirst($record->reason)}}
							@endif
						</td>
						<td style="text-align:center;" class="medium">
                          @if($record->status !== 'cancelled')
							<a href="javascript:void(0);" class="view-cre-gallery-modal" data-cre-id="{{$record->cre_id}}">Photo</a>
                          @else 
							--
                          @endif
                        </td>
                        <td style="text-align:center;" class="xxlarge">
							{{ ucfirst($record->conclusion)}}
						</td>
                        <td style="text-align:center;" class="medium">
                           <a href="javascript:void(0)" role_id="{{$record->porder_id}}" class="preventDefault approvalcre">
								@if(is_null($record->status))
									In Process
								@elseif($record->status=='cancelreq')
									Cancel Requested
								@elseif($record->status=='returnreq')
									Return Requested
								@elseif($record->status=="returnrjctd")
									Return Rejected
								@elseif($record->status=="returnaccptd")
									Return Accepted
								@else
									{{ucfirst($record->status)}}
								@endif
							</a>	
						</td>
                        <td class="xxlarge">
                           @if($record->ostatus=="rejected" )
								<a href="javascript:void(0);" class="btn btn-review adminreviewcre" rel-oid="{{$record->op_id}}">Review</a>
                           @endif
                        </td> 
                    </tr>
                    @endforeach

                    {{-- Ends --}}
                 
                </tbody>
            </table>
        </div>
        {{-- Modal --}}
        <!-- Modal -->
        <div id="reviewModal" class="modal fade" role="dialog">
          <div class="modal-dialog" style="width:800px;">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Review</h4>
              </div>
              <div class="modal-body">
            
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-default review" style="background-color: #FF4C4C; color: white;" rel-type="mer">Merchant</button>
                <button type="button" class="btn btn-default review" style="background-color: #0000ff; color: #fff;" rel-type="byr">Buyer&nbsp;&nbsp;&nbsp;</button>
              </div>
            </div>

          </div>
        </div>
		

		
        {{-- Edns --}}
        <script type="text/javascript">
            $(document).ready(function(){
                $('.view-cre-gallery-modal').click(function () {
                    var cre_id=$(this).attr('data-cre-id');
                    var url=JS_BASE_URL+"/cre/images/"+cre_id;
                    var w=window.open(url,"_blank");
                    w.focus();
                });
                $('.adminreviewcre').click(function(){
                    var oid=$(this).attr('rel-oid');
                    var url="{{url('admin/master/cre/review')}}"+"/"+oid;
                    $('#reviewModal').find('.btn').prop("disabled",false);
                    $('#reviewModal').find('input[type=checkbox]').prop("disabled",false);
                    $('#reviewModal').find('.modal-body').load(url);
                    $('#reviewModal').modal('show');
                });
            });
        </script>
<script type="text/javascript">
    $(document).ready(function(){

		
		$(document).delegate( '.approvalcre', "click",function (event) {
            //  Paul on 1st May 2017 at 11 55 pm
            //window.open(JS_BASE_URL + "/admin/master/orderapp/" + $(this).attr("role_id"), '_blank');
            window.open(JS_BASE_URL + "/orderapp/" + $(this).attr("role_id"), '_blank');
        });
        $('.approve').click(function () {
            var cre_id=$(this).attr('data-cre-id');
            var type=$(this).attr('data-type');

            var orderproduct_id=$(this).attr('data-op-id');
            var url = JS_BASE_URL+"/merchant/approve/cre";
            data={
                cre_id:cre_id,
                type:type,
                order_id:orderproduct_id,

            };
            $.ajax({
                url:url,
                data:data,
                type:'POST',
                success:function(r){
                    if (r.status=="success") {

                        toastr.info(r.long_message)
                    }
                    if (r.status=="failure") {
                        toastr.warning(r.long_message);
                    }
                },
                error:function(){
                    toastr.warning("Your action could not be completed. Please try again later.");
                }
            });
        });
        $('.reject').click(function(){
            var cre_id=$(this).attr('data-cre-id');
            var type=$(this).attr('data-type');
            var orderproduct_id=$(this).attr('data-op-id');
           
            data={
                cre_id:cre_id,
                type:type,
                order_id:orderproduct_id,

            };

            var url = JS_BASE_URL+"/merchant/reject/cre";
            $.ajax({
                url:url,
                type:'POST',
                data:data,
                success:function(r){
                    if (r.status=="success") {

                        toastr.info(r.long_message)
                    }
                    if (r.status=="failure") {
                        toastr.warning(r.long_message);
                    }
                },
                error:function(){
                    toastr.warning("Your action could not be completed. Please try again later.");
                }
            });
        });
    });

</script>
    </div>
    @endif	
	
	@if(isset($cre))
	<h2>Cancellation, Return &amp; Exchange Master</h2>
    <div class="tableData">
        <div class="table-responsive1">
            <table class="table table-bordered" cellspacing="0" width="1580px" id="cre_details_table">
                <thead>
                <style type="text/css">
					.sort{color: black;}              
                </style>
                    <tr style="background-color:#D8E26D; color: black;">
                        <th style="text-align:center;"
							class="no-sort text-center no-sort">No.</th>
                        <th style="text-align:center;" class="large">CRE&nbsp;ID</th>
                        <th style="text-align:center;" class="large">Date</th>
                        <th style="text-align:center;" class="large">Order&nbsp;ID</th>
						<th class="large">Name</th>
						<th style="text-align:center;" class="large">Contact</th>
                        <th style="text-align:center;" class="fit large">Email</th>
                      <!--  <th style="text-align:center;" class="large">Product&nbsp;ID</th>
                        <th style="text-align:center;" class="large">Buyer&nbsp;ID</th> -->
                        <th style="text-align:center;background-color:green;color:white"
							class="medium">Status</th>
                       <!-- <th style="text-align:center;" class="large">I&nbsp;wish&nbsp;to</th>
                        <th style="text-align:center;" class="large">Reason</th>
                        <th style="text-align:center;" class="medium">Photo</th>
                        <th style="text-align:center;" class="xxlarge">Approval</th> -->
                    </tr>
                <thead>
                <tbody>
                    <?php $i=1;?>
                    @foreach($cre as $record)
                    {{-- <> --}}
                    <tr style="border:1px solid black;" class="fit">
                        <td style="text-align: center;">
                            {{$i++}}
                        </td>
                        <td style="text-align:center;">{{IdController::nCre($record->cre_id )}}</td>
                        <td style="text-align: center;">{{UtilityController::s_date($record->created_at)}}</td>
                        <td style="text-align:center;" class="large"><a href="{{url('deliveryorder/'.$record->porder_id)}}" target="_blank">{{ IdController::nO($record->porder_id)}}</a></td>
						<td class="large">{{ $record->first_name." ".$record->last_name }}</td>
                        <td style="text-align:center;" class="medium">{{ $record->contact }}</td>
                        <td class="large">{{ $record->email }}</td>
                       <!-- <td style="text-align:center;" class="large"><a href="{{url('productconsumer/'.$record->product_id)}}" target="_blank">{{ IdController::nP($record->product_id)}}</a></td>
                        <td style="text-align:center;" class="large"><a href="{{url('admin/popup/user/'.$record->user_id)}}" target="_blank">{{ IdController::nB($record->user_id)}}</a></td> -->

                        <td style="text-align:center;" class="medium">
							<a class="approval_details" rel="{{ $record->cre_id }}" target="_blank"  href="{{route('creApproval', ['id' => $record->cre_id])}}">
                            @if(is_null($record->status))
                                In Process
                            @elseif($record->status=='cancelreq')
                                Cancel Requested
                            @elseif($record->status=='returnreq')
                                Return Requested
                            @elseif($record->status=="returnrjctd")
                                Return Rejected
                            @elseif($record->status=="returnaccptd")
                                Return Accepted
                            @else
                                {{ucfirst($record->status)}}
                            @endif
							</a>
                        {{-- Ends --}}
                        
                       <!-- <td style="text-align:center;" class="large">{{ ucfirst($record->iwishto)}}</td>
                        <td style="text-align:center;" class="large">
                            @if($record->status !== 'cancelled')
                        {{ ucfirst($record->reason)}}</td>
                        @else --
                        @endif
                        <td style="text-align:center;" class="medium">
                            @if($record->status !== 'cancelled')
                          <a href="javascript:void(0);" class="view-cre-gallery-modal" data-cre-id="{{$record->cre_id}}">Photo</a>
                          @else 
                          --
                          @endif
                        </td>
                        <td class="xxlarge">
                            @if(strpos($record->status,'req')==true)
                            <div style="display: inline-block;"><button class="btn btn-success approve" style="width:100px;" data-cre-id="{{$record->cre_id}}" data-op-id="{{$record->op_id}}" data-type="{{$record->iwishto}}">Approve</button>
                            <button style="width:100px;" class="btn btn-warning reject" data-cre-id="{{$record->cre_id}}" data-op-id="{{$record->op_id}}" data-type="{{$record->iwishto}}">Reject&nbsp;</button></div>
                            @else
                                Processed
                            @endif
                        </td> -->
                    </tr>
                    @endforeach

                    {{-- Ends --}}
                 
                </tbody>
            </table>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.view-cre-gallery-modal').click(function () {
                    var cre_id=$(this).attr('data-cre-id');
                    var url=JS_BASE_URL+"/cre/images/"+cre_id;
                    var w=window.open(url,"_blank");
                    w.focus();
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.view-cre-gallery-modal').click(function () {
                    var cre_id=$(this).attr('data-cre-id');
                    var url=JS_BASE_URL+"/cre/images/"+cre_id;
                    var w=window.open(url,"_blank");
                    w.focus();
                });
            });
        </script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.approve').click(function () {
            var cre_id=$(this).attr('data-cre-id');
            var type=$(this).attr('data-type');

            var orderproduct_id=$(this).attr('data-op-id');
            var url = JS_BASE_URL+"/merchant/approve/cre";
            data={
                cre_id:cre_id,
                type:type,
                order_id:orderproduct_id,

            };
            $.ajax({
                url:url,
                data:data,
                type:'POST',
                success:function(r){
                    if (r.status=="success") {

                        toastr.info(r.long_message)
                    }
                    if (r.status=="failure") {
                        toastr.warning(r.long_message);
                    }
                },
                error:function(){
                    toastr.warning("Your action could not be completed. Please try again later.");
                }
            });
        });
        $('.reject').click(function(){
            var cre_id=$(this).attr('data-cre-id');
            var type=$(this).attr('data-type');
            var orderproduct_id=$(this).attr('data-op-id');
           
            data={
                cre_id:cre_id,
                type:type,
                order_id:orderproduct_id,

            };

            var url = JS_BASE_URL+"/merchant/reject/cre";
            $.ajax({
                url:url,
                type:'POST',
                data:data,
                success:function(r){
                    if (r.status=="success") {

                        toastr.info(r.long_message)
                    }
                    if (r.status=="failure") {
                        toastr.warning(r.long_message);
                    }
                },
                error:function(){
                    toastr.warning("Your action could not be completed. Please try again later.");
                }
            });
        });
    });

</script>
    </div>
    @endif
    @if(isset($hypers))
        <h2>Hyper Master</h2>
        <div class="tableData">
        <div class="table-responsive1">
            <table id="adminmasterhyper" class="table table-bordered" style="width:100%;background-color:#2F4177;color:white;">
        <thead>
            <tr>
                <th class="no-sort text-center medium">No</th>
                <th class="text-center">Hyper&nbsp;ID</th>
                <th class="text-center">Product&nbsp;ID</th>
                <th class="text-center">MOQ</th>
                <th class="text-center">Price</th>
                <th class="text-center">Save</th>
                <th class="text-center">Left</th>
                <th class="text-center">Time&nbsp;Left</th>
                <th class="text-center">Due&nbsp;Date</th>
                <th class="text-center">Bought</th>
                <th class="text-center" style="background-color:green;color:white">Status</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($hypers))
                <?php
                    $no=1;
                ?>
                @foreach($hypers as $h)
                    <tr style="color:black;">
                        <td class="text-center">{{$no}}</td>
                        <td class="text-center"><a href="javascript:void(0);" class="hypermodal" rel="{{$h['owarehouse_id']}}">{{IdController::nH($h['owarehouse_id'])}}</a></td>
                        <td class="text-center"><a href="{{ route('productconsumer', $h['parent_id']) }}" target="_blank">{{IdController::nP($h['product_id'])}}</a></td>
                        <td class="text-center">{{$h['moq']}}</td>
                        <td class="text-right">{{$currentCurrency}}&nbsp{{number_format($h['price']/100,2)}}</td>
                        <td class="text-center">{{number_format($h['discount'],0)."%"}}</td>
                        <td class="text-center">{{$h['left']}}</td>
                        <td class="text-center">{{$h['time_left']}}</td>
                        <td class="text-center"><a href="javacript:void" class="hyperdate" rel="{{UtilityController::s_date($h['due_date'])}}" drel="{{UtilityController::s_date($h['created_at'])}}">{{UtilityController::s_date($h['due_date'])}}</a></td>
                        <td class="text-right">{{$currentCurrency}} {{number_format($h['pledged']/100,2)}}</td>
                        <td>{{ucfirst($h['status'])}}</td>

                    </tr>
                    <?php $no++; ?>
                @endforeach
            @endif
        </tbody>
    </table>
        </div>
    </div>
    @endif
</div>
</div>

<div class="modal fade" id="myModalhyperdate" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 40%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Hyper Master</h4>
            </div>
            <div class="modal-body">
                <h3 id="modal-Tittle"></h3>
                <div class="table-responsive1">
                    <table id="myTableHyper" class="table table-bordered myTable">
						<tr style="width:100%;background-color:#2F4177;color:white;">
							<th>Start Date</th>
							<th>Due Date</th>
						</tr>
						<tr>
							<td><span id="hstartdate"></span></td>
							<td><span id="hduedate"></span></td>
						</tr>
					</table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Statement D</h4>
            </div>
            <div class="modal-body">
                <h3 id="modal-Tittle"></h3>
                <div class="table-responsive1">
                    <table id="myTable" class="table table-bordered myTable"></table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content" style='max-height: 500px; overflow-y: scroll;'>
            <div class="modal-body">
                <h3 id="modal-Tittle2"></h3>
                <div id="myBody2">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="myModalshowremarks" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" id="modal_dialogremarks" style="width: 70%">
        <div class="modal-content" style='max-height: 500px;'>
            <div class="modal-body">
                <h3 id="modal-Tittleremarks"></h3>
                <div id="myBodyremarks">
					<table class='table table-bordered' cellspacing='0' width='860px' id='remarks_table'>
					</table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="myModalhyper" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" id="modal_dialogremarks" style="width: 50%; max-height: 1000px;">
        <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Hyper Product</h4>
			</div>		
            <div class="modal-body" style="height: 750px;">
                <div class="col-sm-3">
				&nbsp;
				</div>
				<div id="Hyperp" class="col-sm-6">
					
                </div>
                <div class="col-sm-3">
				&nbsp;
				</div>				
            </div>
		</div>			
    </div>
</div>

<div id="admindialog" title="Reset Password" style="display:none">
	<p>Enter new password</p>
	<input type="password" id="user_pass" size="25" />
	<input type="hidden" id="useraid" value="0" />
	<p>Confirm new password</p>
	<input type="password" id="user_passc" size="25" />		
	<input type="button" id="change_password" class="btn btn-primary" value="Reset" style="margin-top: 10px;">
	<p style="color: red; display: none;" id="wrong_pass" style="margin-top: 10px;">Passwords don't match.</p>
	<p style="color: green; display: none;" id="sucess_pass" style="margin-top: 10px;">Password successfully changed!</p>
</div>
{{-- Modal --}}
<div  class="modal fade" role="dialog" id="admin-master-modal">
    <div class="modal-dialog" >
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" style="color:red;">&times;</button>
        </div>
        <div class="modal-body">
            <h3>Outlet</h3>
            <div id="ajax-load-outlet">
            </div>
        </div>
    </div>
</div>

<script src="{{url('js/jquery.dataTables.min.js')}}"></script>
<script src="{{url('jqgrid/jquery.jqGrid.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#adminmasterhyper').DataTable({
            "order": [],
        "scrollX": true,
        "columnDefs": [
			{"targets": "no-sort", "orderable": false},
			{"targets": "medium", "width": "80px"},
			{"targets": "large",  "width": "120px"},
			{"targets": "bsmall",  "width": "20px"},
			{"targets": "approv", "width": "180px"}, //Approval buttons
			{"targets": "blarge", "width": "200px"}, // *Names
			{"targets": "clarge", "width": "250px"},
			{"targets": "xlarge", "width": "300px"}, //Remarks + Notes 
        ],
        });
    });
</script>

<script>
$(document).ready(function () {
	function pad(str, max) {
		if (!str) {
			str = str.toString();
			ret = str.length < max ? pad("0" + str, max) : str;
		} else {
			ret = "";
		}
		return ret;
	}

			$(document).delegate( '.hyperdate', "click",function (event) {
				$("#hstartdate").html($(this).attr("drel"));
				$("#hduedate").html($(this).attr("rel"));
				$("#myModalhyperdate").modal("show");
						
			});
			$(document).delegate( '.hypermodal', "click",function (event) {
				var owarehouse_id = $(this).attr("rel");				
				$.ajax({
					type: "GET",
					url: JS_BASE_URL + "/hyperbyid/"+owarehouse_id,
					success: function (data) {
						$("#Hyperp").html(data);
						$("#myModalhyper").modal("show");
						
					},
					error: function (error) {
						
					}

				});				
			});	
	
			$(document).delegate( '.pwd_reset', "click",function (event) {
				var userid = $(this).attr("rel");
				var formData = {
					email: userid
				}				
				$.ajax({
					type: "POST",
					url: JS_BASE_URL + "/forgot_password",
					data: formData,
					dataType: 'json',
					success: function (data) {
						toastr.info("Password successfully sent!");
					},
					error: function (error) {
						toastr.warning("Password could not be changed!");
						console.log(error);
					}

				});				
			});
	
			 $(document).delegate( '#change_password', "click",function (event) {
				//console.log("passs");
				var userid = $("#useraid").val();
				var password = $("#user_pass").val();
				var cpassword = $("#user_passc").val();
			 if(password == cpassword){
					var formData = {
						userid: userid,
						password: password
					}
					$.ajax({
						type: "POST",
						url: JS_BASE_URL + "/changepassword",
						data: formData,
						dataType: 'json',
						success: function (data) {
							$("#sucess_pass").show();						
							setTimeout(function(){
								$("#user_pass").val("");
								$("#sucess_pass").hide();
								$("#admindialog").dialog("close");
							}, 3000);							
						},
						error: function (error) {
							console.log(error);
						}

					});
				} else {
					$("#wrong_pass").show();
					setTimeout(function(){
						$("#wrong_pass").hide();
					}, 4000);					
				}				
			});		
	
	function format(tr) {

		var j = tr.attr('data-last');

		var table = '<table class="table child_table" cellspacing="0" width="100%">';
		table += '<thead>';
		table += '<tr><th>Id</th><th>Name</th><th>Description</th><th>Quantity</th><th>Price</th><th>Sub Total</th></tr>';
		table += '</thead>';
		table += '<tbody>';

		for (i = 1; i <= j; i++) {
			var id = tr.attr('data-id-' + i);
			var name = tr.attr('data-name-' + i);
			var qty = tr.attr('data-qty-' + i);
			var price = tr.attr('data-price-' + i);
			var des = tr.attr('data-des-' + i);
			var total = tr.attr('data-total-' + i);
			table += '<tr><td>' + id + '</td><td>' + name + '</td><td>' + des + '</td><td>' + qty + '</td><td>' + price + '</td><td>' + total + '</td></tr>';
		}

		table += '</tbody>';
		table += '</table>';

		return table;
	}

	var table = $('#station_details_table').DataTable({
		"order": [],
		"scrollX": true,
		"columnDefs": [
			{"targets": "no-sort", "orderable": false},
			{"targets": "medium", "width": "80px"},
			{"targets": "bmedium", "width": "100px"},
			{"targets": "large",  "width": "120px"},
			{"targets": "bsmall",  "width": "20px"},
			{"targets": "approv", "width": "180px"}, //Approval buttons
			{"targets": "blarge", "width": "200px"}, // *Names
			{"targets": "clarge", "width": "250px"},
			{"targets": "xlarge", "width": "300px"}, //Remarks + Notes 
		],
		"fixedColumns": { "leftColumns": 2 }
	});

	var table = $('#cre_details_table').DataTable({
		"order": [],
		"scrollX": true,
		"columnDefs": [
			{"targets": "no-sort", "orderable": false},
			{"targets": "medium", "width": "80px"},
			{"targets": "bmedium", "width": "100px"},
			{"targets": "large",  "width": "120px"},
			{"targets": "bsmall",  "width": "20px"},
			{"targets": "approv", "width": "180px"}, //Approval buttons
			{"targets": "blarge", "width": "200px"}, // *Names
			{"targets": "clarge", "width": "250px"},
			{"targets": "xlarge", "width": "300px"}, //Remarks + Notes 
			{"targets": "xlarge", "width": "400px"}, //Remarks + Notes 
		],
		"fixedColumns": {
			"leftColumns": 2
		}
	});





	$('#shipping_details_table').DataTable();
	$('#lower_product_detail_table').DataTable();
	$('#payment_detail_products').DataTable();
	$('#voucher_payment_detail').DataTable();
	$('#open_wish_table').DataTable();
	$('#auto_link_table').DataTable();
	$('#auto_link_table_2').DataTable();


	var vtable = $('#voucher_detail_table').DataTable({
		"columnDefs": [{
				"targets": 0,
				"data": null,
				"className": 'details-control-2',
				"orderable": false,
				"defaultContent": ""
			}]
	});
	var token_merchant_id = 0;
	$("#tokens_free").number(true,2,'.','');
    $(document).delegate( '.add_tokens_offer', "click",function (event) {
		console.log(token_merchant_id);
		$(this).html("Saving...");
		var but = $(this);
		var val = parseInt($("#tokens_free").val()) || 0;
		var val2 = parseInt($("#tokens_buy").val()) || 0;
		if(val <= 0 || val2 <= 0){
			toastr.warning("Invalid value!");
		} else {
			$.ajax({
				type: "POST",
				data: { 
					tokens_free:$("#tokens_free").val(),
					tokens_buy:$("#tokens_buy").val(),
					user_id:token_merchant_id 
				},
				url: JS_BASE_URL+"/admin/offer_tokens",
				beforeSend: function(){},
				success: function(response){
					toastr.info("Token Offer Successfully saved!");
					//$("#free-tokens" + token_merchant_id).html(response);
					but.html("Offer");
					//location.reload();
					$("#myModalToken").modal('toggle');
				}
			});	
		}
	});
    $(document).delegate( '.add_tokens', "click",function (event) {
		console.log(token_merchant_id);
		$(this).html("Saving...");
		var but = $(this);
		var val = parseInt($("#tokens_add").val()) || 0;
		if(val <= 0){
			toastr.warning("Invalid value!");
		} else {
			$.ajax({
				type: "POST",
				data: { 
					tokens:$("#tokens_add").val(),
					user_id:token_merchant_id 
				},
				url: JS_BASE_URL+"/admin/free_tokens",
				beforeSend: function(){},
				success: function(response){
					toastr.info("Tokens Successfully saved!");
					$("#free-tokens" + token_merchant_id).html(response);
					but.html("Grant");
					//location.reload();
					$("#myModalToken").modal('toggle');
				}
			});	
		}		
	});
	
    $(document).delegate( '.showhidetoken', "click",function (event) {
		var rel = $(this).attr("rel");
		var checked = $(this).prop('checked');
		console.log(checked);
		$.ajax({
			type: "POST",
			data: { 
				user_id:token_merchant_id,
				product_id:rel,
				action:checked
			},
			url: JS_BASE_URL+"/admin/set_tokens",
			beforeSend: function(){},
			success: function(response){
				console.log(response);
			}
		});
		console.log(rel);
	});
	
    $(document).delegate( '.free-tokens', "click",function (event) {
		token_merchant_id = $(this).attr("data-id");
		$.ajax({
			type: "POST",
			data: { 
				user_id:token_merchant_id 
			},
			url: JS_BASE_URL+"/admin/available_tokens",
			dataType: 'json',
			beforeSend: function(){},
			success: function(response){
				console.log(response);
				for(var jj = 0; jj < response.length; jj++){
					var kk = jj +1;
					if(response[jj] == "1"){
						$('#checked_p' + kk).prop('checked', true);
					} else {
						$('#checked_p' + kk).prop('checked', false);
					}
				}
				//toastr.info("Tokens Successfully saved!");
				
				//location.reload();
				//$("#myModalToken").modal('toggle');
			}
		});
		$('#facilities_info').html('');
		$.ajax({
			type: "POST",
			data: { 
				user_id:token_merchant_id 
			},
			url: JS_BASE_URL+"/admin/available_facilities",
			dataType: 'json',
			beforeSend: function(){},
			success: function(response){
				console.log(response);
				$('#facilities_info').append('<thead style="background-color: #400080; color: #fff;"><th style="text-align:center">No</th><th style="text-align:center">Facility</th><th style="text-align:center">Annual Fee</th><th style="text-align:center">Variable Fee</th><th style="text-align:center">Since</th></thead>');
				$('#facilities_info').append('<tbody>');
				for (i=0; i < response.length; i++) {
					var obj = response[i];
					$('#facilities_info').append('<tr><td style="text-align: center;">' + (i+1).toString() +'</td><td style="text-align: center;">'+obj.description +'</td><td style="text-align: center;"><input type="text" size="8" style="display: none;" id="subs_fee_input'+obj.id +'" class="subs_fee_input" rel="'+obj.id +'" value="'+obj.token_subscription_fee +'" /><span class="spantoks" id="spantoks'+obj.id +'" style="display: none;">&nbsp;Tokens</span><span class="subs_fee_text" id="subs_fee_text'+obj.id +'" rel="'+obj.id +'">'+obj.token_subscription_fee +'</span></td><td style="text-align: center;"><a href="javascript:void(0);" class="variable_fee" rel="'+obj.token_admin_fee+'" nrel="'+obj.variable_fee_name+'" idrel="'+obj.id+'">Variable</a></td><td style="text-align: center;">' + obj.since + ' </td></tr>');
				}
				
				$('#facilities_info').append('</tbody>');
			}
		});
		$("#myModalToken").modal('show');
		
	});
		$(document).delegate( '.variable_fee', "click",function (event) {
		var _this = $(this);
		var name = _this.attr("nrel").replace('_',' ');
		var value = _this.attr("rel");
		var id = _this.attr("idrel");

		$("#fee_name").html(toTitleCase(name));
		$("#fee_value").html('<input type="text" style="display: none;" size="4" class="admin_fee_input" rel="'+id +'" value="'+ value +'" /><span class="spantok" style="display: none;">&nbsp;Tokens</span><span rel="'+id+'" class="admin_fee_text">' + value + '</span>');
		 $("#FacilitiesFeeModal").modal("show");
	});
	
	$(document).delegate('.total_token', "click",function (event) {
		var _this = $(this);
		var paid = _this.attr("rel-paid");
		var free = _this.attr("rel-free");
		$("#paid_token").html(paid);
		$("#free_token").html(free);
		 $("#IssuedModal").modal("show");
	});
	
			$(document).delegate( '.subs_fee_input', "blur",function (event) {
				 var _this = $(this);
				 var facility_id = $(this).attr("rel");
				 var val = $(this).val();
				 var url = '/admin/token/facilities/edit_subscription';
				 var formData = {
					facility_id: facility_id,
					value: val
				};
				 $.ajax({
                    type: "POST",
                    url: url,
					data:formData,
                    success: function (data) {
						toastr.info("Fee successfully changed!");
						$("#subs_fee_text" + facility_id).html(val);
						$("#subs_fee_text" + facility_id).show();
						_this.hide();
						$("#spantoks" + facility_id).hide();
					},
                    error: function (error) {
                        console.log(error);
                    }

                });
			});
			
			$(document).delegate( '.admin_fee_input', "blur",function (event) {
				 var facility_id = $(this).attr("rel");
				 var val = $(this).val();
				 var url = '/admin/token/facilities/edit_admin';
				 var formData = {
					facility_id: facility_id,
					value: val
				};
				 $.ajax({
                    type: "POST",
                    url: url,
					data:formData,
                    success: function (data) {
						toastr.info("Fee successfully changed!");
						$(".admin_fee_text").html(val);
						$(".admin_fee_text").show();
						$(".admin_fee_input").hide();
						$(".spantok").hide();
					},
                    error: function (error) {
                        console.log(error);
                    }

                });
			});
			
			$(document).delegate( '.admin_fee_text', "click",function (event) {
				$(".admin_fee_text").hide();
				$(".admin_fee_input").show();
				$(".spantok").show();
			});
			
			$(document).delegate( '.subs_fee_text', "click",function (event) {
				$(this).hide();
				$("#subs_fee_input" + $(this).attr('rel')).show();
				$("#spantoks" + $(this).attr('rel') ).show();
			});

	$('td.details-control-2').on('click', function () {
		console.log('clicked');
		var tr = $(this).closest('tr');
		var row = vtable.row(tr);

		if (row.child.isShown()) {
			// This row is already open - close it
			row.child.hide();
			tr.removeClass('shown');
		} else {
			// Open this row
			row.child(format(tr)).show();
			tr.addClass('shown');
		}
	});


	$('#datetimepicker , #datetimepickerr').on('change', function () {
		var date1 = $('#datetimepicker').val();
		var date2 = $('#datetimepickerr').val();

		$('#dateSince').html(date1);

		$.ajax({
			url: '{{url(' / merchant / calc - sale')}}',
			data: {'date1': date1, 'date2': date2},
			headers: {'X-XSRF-TOKEN': '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}'},
			error: function () {

			},
			success: function (response) {
				$('#amountSince').html(response.payment);
				$('#amountBetween').html(response.paymentSince);
			},
			type: 'POST'
		});
	});
	var remarks_table;
    // $(".mcrid").click(function () {
    $(document).delegate( '.mcrid', "click",function (event) {
		_this = $(this);
		var id_station = _this.attr('rel');
		if(remarks_table){
			remarks_table.destroy();
		}

		$('#modal-Tittleremarks').html("Remarks");

		var url = '/admin/master/station_remarks/' + id_station;
		$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			success: function (data) {
				console.log(data);
				var html = "<thead><tr style='background-color: #4E2E28; color: white;'><th class='no-sort text-center bsmall'>No</th><th class='text-center large'>Station&nbsp;ID</th><th class='text-center bmedium'>Status</th><th class='text-center large'>Admin&nbsp;ID</th><th class='text-center xlarge'>Remarks</th><th class='text-center blarge'>DateTime</th></tr></thead><tbody>";
				for (i = 0; i < data.length; i++) {
					var obj = data[i];
					html += "<tr>";
					html += "<td class='text-center bsmall' style='vertical-align:middle'>" + (i + 1) + "</td>";
					html += "<td class='large' style='vertical-align:middle'><a href='"+JS_BASE_URL+"/admin/popup/station/" + id_station + "' target='_blank' class='update' data-id='" + id_station + "'>" + obj.nseller_id + "</a></td>";
					html += "<td class='bmedium' style='vertical-align:middle'>"+obj.status+"</td>";
					if(obj.nbuyer_id == null){
						html += "<td class='text-center' style='vertical-align:middle'><a href='"+JS_BASE_URL+"/admin/popup/user/"+obj.user_id+"' target='_blank' class='update' data-id='"+obj.user_id+"'>"+obj.user_id+"</td>";
					} else {
						html += "<td class='text-center' style='vertical-align:middle'><a href='"+JS_BASE_URL+"/admin/popup/user/"+obj.user_id+"' target='_blank' class='update' data-id='"+obj.user_id+"'>"+obj.nbuyer_id+"</td>";
					}					
					html += "<td class='xlarge'>" + obj.remark + "</td>";
					html += "<td class='blarge' style='vertical-align:middle'>" + obj.created_at + "</td>";
					html += "</tr>";
				}
				$('#remarks_table').append(html + "</tbody>");
				$("#myModalshowremarks").modal("show");
				remarks_table = $('#remarks_table').DataTable({
					"order": [],
					//"scrollX": true,
					"bAutoWidth": false ,
					"columnDefs": [
						{"targets": "no-sort", "orderable": false},
						{"targets": "medium", "width": "80px"},
						{"targets": "bmedium", "width": "100px"},
						{"targets": "large",  "width": "120px"},
						{"targets": "bsmall",  "width": "20px"},
						{"targets": "approv", "width": "180px"}, //Approval buttons
						{"targets": "blarge", "width": "200px"}, // *Names
						{"targets": "clarge", "width": "250px"},
						{"targets": "xlarge", "width": "300px"}, //Remarks + Notes 
					],
				});		
				
				//remarks_table.fnAdjustColumnSizing();			
			}
		});
	});


    $(".prid").click(function () {

        $('#modal-Tittle').html("");
        $('#modal-Tittle1').html("");
        $('#myTable').empty();
        _this = $(this);

        var id_station= _this.attr('id');
        var pname= $('#pname' + id_station).val();
        var url = '/admin/master/getstationproduct/'+id_station;

        var urlbase = $('meta[name="base_url"]').attr('content');

        $.ajax({
            type: "GET",
            url: url,
            async:false,
            dataType: 'json',
            success: function (data) {
                //	console.log(data);

                for(i=0;i<data.length;i++){

                    var pr = "";
                        pr = '[' + pad(data[i].id,10) + ']';

                    var urlid = data[i].id;
                    if(parseInt(data[i].parent_id) != parseInt(data[i].id)){
                        urlid = data[i].parent_id + "#content-b2b";
                    }

                    $('#myTable').append('<tbody><tr><td>'+ i +'</td><td><a href="'+urlbase+'/album/'+urlid+'">'+ pr +'</a></td><td>'+data[i].name+'</td><td>'+data[i].available+'</td></tr></tbody>');
                }


            },
            error: function (error) {
                console.log(error);
            }
        });

        $('#modal-Tittle').append("Station ID: "+id_station);
        $('#myTable').append('<thead style="background-color: #604a7b; color: #fff;"><th>No</th><th>Product ID</th><th>Item</th><th>Left</th></thead>');


        $('#myTable').DataTable({
            "order": [],
            "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false,
            },{ "targets": "large", "width": "120px" },{ "targets": "xlarge", "width": "300px" }],
            "fixedColumns":  true
        });

        $("#myModal").modal("show");
    });
	
    $(".selectstationchannel").change(function()
    {
        //document.location.href = window.location.protocol + "//" + window.location.host + "/"+$(this).val();
		window.open(window.location.protocol + "//" + window.location.host + "/"+$(this).val(),'_blank');
    });	

});
</script>
{{-- @yield("left_sidebar_scripts") --}}
<script type="text/javascript">
    $(document).ready(function(){
        $('.hover-long-text').tooltip();
        $('.view-outlet-table-modal').click(function(){

            var station_id= $(this).attr('data-st-id');
            var url=JS_BASE_URL+"/admin/master/station/outlet/"+station_id;
            var w=window.open(url,"_blank");
            w.focus();
            
        });
        $('.view-oqueue-table-modal').click(function(){
            // alert("yeyy");
            var station_id= $(this).attr('data-st-id');
            var url=JS_BASE_URL+"/admin/master/station/oqueue/"+station_id;
            var w=window.open(url,"_blank");
            w.focus();
        });
        $('.view-details-table-modal').click(function(){
            var station_id=$(this).attr('data-st-id');
            var url=JS_BASE_URL+"/admin/master/station/detail/"+station_id;
            var w=window.open(url,"_blank");
            w.focus();
        });
        $('.view-station-modal').click(function(){

            var station_id=$(this).attr('data-id');
            var check_url=JS_BASE_URL+"/admin/popup/lx/check/merchant/"+station_id;
            $.ajax({
                url:check_url,
                type:'GET',
                success:function (r) {
                    if (r.status=="success") {
                    var url=JS_BASE_URL+"/admin/popup/merchant/"+station_id;
                    var w=window.open(url,"_blank");
                    w.focus();
                    }
                    if (r.status=="failure") {
                        var msg="<div class='alert alert-danger'>"+r.long_message+"</div>";
                        $('#station-error-messages').html(msg);
                    }
                }
            });


        });
    });

</script>

<script type="text/javascript">


            window.setInterval(function(){
              $('#station-error-messages').empty();
            }, 10000);


</script>

@stop
