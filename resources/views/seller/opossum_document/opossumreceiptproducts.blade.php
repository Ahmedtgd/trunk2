
<link href="{{URL::to('opposum_libs/css/app.css')}}" rel="stylesheet">
<link href="{{URL::to('opposum_libs/css/style.css')}}" rel="stylesheet">
<?php
//$bfunction="spa";
use App\Http\Controllers\UtilityController;
?>
<style>
body {
    overflow-x:hidden;
    height:100%;
    width:50%;
}

#voidstamp{
    color: red;
    position: absolute;
    z-index: 2;
    font-size: 70px;
    font-weight: 500;
    margin-top: 65%;
    margin-left: 21%;
    transform: rotate(30deg);
    display:none;
}
.tdformat{
    
}
</style>

<div id="confirmModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:200px;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header"><h3>Void</h3>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
      <div class="modal-body">
            <div class="col-md-12" style="padding:0px">
                <textarea name="remark" id="remark" rows="5" cols="34%" placeholder="Remarks"></textarea>
            </div>&nbsp;
            <div>
            <span class="text-danger" style="font-size:15px;">Are you sure?</span></div>
      </div>
      <div class="modal-footer">
        <button type="button" id="do_void" class="btn btn-primary btn-default"
		style="width:70px" data-dismiss="modal">Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<div id="receiptmodal" style="overflow-x:hidden;overflow-y:auto"
	role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content" style="width:400px;">
        <div class="text-center "><h2 id="voidstamp">Voided<br>
        <span
        style="font-size:15px !important;"
        id="voiddate"
        >{{UtilityController::s_date(!empty($receiptInfo->voided_at)?$receiptInfo->voided_at:"")}}</span>
        </h2></div>

            <div id="style"></div>
            <div style="padding:0" class="modal-body">
                <div style="padding-left:5px" class="">
                    <div id="invoice-container" class="invoice-container"
                         style="padding-left:5px">
						<!--
						<h3 class="rheader">Receipt</h3>
						-->
            @if(!empty($localLogo))
            <div class="text-center" style="padding-bottom:10px">
			   <img src="{{url()}}/images/receipt/{{$receiptInfo->terminal_id}}/{{$localLogo}}"
			   style="object-fit:contain;width:300px;height:100px">
            </div>
            @endif

			<h4 class="company_name">
			{{!empty($company->dispname)?$company->dispname:""}}
			</h4>

            <div style="text-align:center;">
                ({{!empty($company->business_reg_no)?$company->business_reg_no:""}})&nbsp;&nbsp

                @if($show_sst_no==true or $show_sst_no==1)<b>SST No: </b>
                {{!empty($company->gst)?$company->gst:""}}
                @endif
            </div>

				<p class="company_addr">
				{{!empty($company->line1)?$company->line1:""}}</p>

				<p class="company_addr">
				{{!empty($company->line2)?$company->line2:""}}
				{{!empty($company->line2)?', ':""}}
				{{!empty($company->line3)?$company->line3:""}} 
				</p>

				<p class="float-left invoice-title"
				   style="margin-top:5px;margin-left:10px;font-weight:bold">Receipt No:</p>
				<span id="invoiceno"
					class="float-left bold invoice-title">{{sprintf("%010d",!empty($receiptInfo->receipt_no)?$receiptInfo->receipt_no:"")}}</span>
				<span
					class="float-right"
					style="margin-top:5px;margin-right:10px">
					{{Carbon::now()->format('dMy H:i:s')}}</span>
				<br>
				<form id="recsaveform" name="recsaveform"
					style="margin-bottom:0;padding-bottom:0;"
					method="post">
				<table style="margin-bottom:0;padding-bottom:0"
					class="table ">
					<thead class="white">
					<tr>
						<th class="text-left theader-font"
							style="padding-top:3px;padding-bottom:3px;padding-left:10px">
							Description</th>
						<th class="text-center theader-font"
							style="padding-top:3px;padding-bottom:3px;padding-left:5px">
							Qty</th>
						<th class="text-right theader-font"
							style="padding-top:3px;padding-bottom:3px;padding-left:5px">
							Price</th>
						<th class="text-right theader-font"
							style="padding-top:3px;padding-bottom:3px;padding-left:5px">
							Disc</th>
						<th class="width-30 text-right theader-font"
							style="padding-top:3px;padding-bottom:3px;padding-left:5px">
							Total</th>
					</tr>
					</thead>
					
					<?php $total = 0;
						$itemtotal=0;
						$rows="";
					 ?>

					<tbody style="" id="receipt_tbody">
					@foreach($receipts as $receipt)
					  {{-- This is for receipt --}}
					<?php
						$disc = "<br><i style='width:150px; margin-left:0;padding-left:0;padding-right:0;margin-top:2px' class='row col col-xs-12'>(".ucfirst($receipt->discount_name)." Discount)</i>";

						$rows.="
						<tr>
						<td style='text-align:left'>".

						(!empty($receipt->product_id)?$receipt->name:'').
						(!empty($receipt->bundle_id)?$receipt->title:'').
						(($receipt->discount>0)?$disc:'')


						."</td>
						<td style='text-align:center'>".$receipt->quantity."</td>
						
						<td style='text-align:center'>".number_format($receipt->price/100,2)."</td>
						<td style='text-align:right'>".
						(empty($receipt->discount)?'0':$receipt->discount).
							"%</td>
						<td style='text-align:right'>".
							number_format(((($receipt->price)-($receipt->price*($receipt->discount/100)))*$receipt->quantity)/100,2)."</td>
						</tr>";

						if(count($receipt['bundleproduct']) > 0) {
							$bundle = $receipt['bundleproduct'];
							$rows.= "<tr>
							<td style='text-align:left' colspan='3'>";
							foreach($bundle as $bundles) {
								$rows.= "<p style='font-size: 13px;padding-bottom: 7px'>".
								$bundles['product']['name'];
								if($bundles->bpdiscount != 0) {
									$rows.= " , ".$bundles->bpdiscount.
										"<span id='percentsign'>%</span> discount";
								}
								$rows.= " X ".$bundles->bpqty."</p>";
							}
							$rows.="</td>
							<td></td>
							</tr>";
						}
					?>

					  <tr id="rec_row">
						  <td id="receipt_des" class="float-left rec-product-font">
						  @if($receipt->product_id != null)
							  {{$receipt->name}}
						  @endif
						  @if($receipt->bundle_id != null)
							  {{$receipt->title}}
						  @endif
						 @if($receipt->discount!=0)
							<i style="width:150px; margin-left:0;padding-left:0;padding-right:0;margin-top:2px"
								class="row col col-xs-12">
								({{ucfirst($receipt->discount_name)}} Discount)
							</i>
						 @endif
						  </td>
						  <td id="receipt_qty" class="text-center item-font">
							  {{$receipt->quantity}}</td>
						  <td id="receipt_price" class="text-right item-font">
							  {{number_format($receipt->price/100,2)}}
						  </td>
						  <td> <div style="position:relative;top:-2px"
							class="text-center">
							<span class="getdiscountid"
								style="font-size:12px;"
								id="rec_discount">
								{{$receipt->discount or '0'}}</span><span style="font-size:12px" id="percentsign">%</span>
							</button></div> </td>

						  <td id="receipt_amount" class="text-right item-font">
							<?php $total+=((($receipt->price)-($receipt->price*($receipt->discount/100)))*$receipt->quantity)/100; 
								$itemtotal+=((($receipt->price)-($receipt->price*($receipt->discount/100)))*$receipt->quantity)/100; 
							?>
							  {{number_format(((($receipt->price)-($receipt->price*($receipt->discount/100)))*$receipt->quantity)/100,2)}}
						  </td>
					  </tr>
					  @if(count($receipt['bundleproduct']) > 0)
						<?php $bundle = $receipt['bundleproduct'];?>
						<tr id="rec_row">
							<td id="receipt_des" class="float-left rec-product-font" colspan="3">
							  @foreach($bundle as $bundles)
							  <p style="font-size: 13px;padding-bottom: 7px">
								{{$bundles['product']['name']}}
								@if($bundles->bpdiscount != 0)
								, {{$bundles->bpdiscount}}<span id="percentsign">%</span> discount @endif X {{$bundles->bpqty}}
							  </p>
							  @endforeach
							</td>
							<td></td>

							<!-- <td></td> -->
							<!-- <td></td>
							<td></td> -->
						</tr>
					  @endif
					@endforeach
					</tbody>
				</table>
				</form>

				<?php
					//

					if ($receiptInfo->mode=="inclusive") {
						
						$rawtotal=$itemtotal;
						$itemtotal=$rawtotal/(1+($service_tax_per/100));
					 
						$service_tax=$rawtotal-$itemtotal;
					}
				?>
				
				<div style="margin-left:10px;margin-top:0"
						class="total total-font rec-staf width100"></div>
				<table style="padding-top:0;padding-bottom:0;margin-bottom:0" class="table">

				<tr style="border-top:1px solid #a0a0a0" class="billdetailtr">
                   <td class="td1 ">Item Amount</td>
                   <td class="td2 ">&nbsp;</td>
                   <td class="td3 ">MYR</td>
                   <td class="td4 text-right 
				   bold reset0 gtotal">
				   	{{number_format($itemtotal,2)}}</td>
                
               </tr>
               <tr class="billdetailtr disabled">
                   <td class="td1 ">Service&nbsp;Tax&nbsp;@if(empty($service_tax_per))0 @else{{$service_tax_per}}@endif%</td>
                   <td class="td2 text-center">+</td>
                   <td class="td3  ">MYR</td>
                   <td class="td4 text-right  bill_gst reset0"
                    id="bill_gst">
                       <?php 
                       if($receiptInfo->mode!="inclusive")
                        {
                          $service_tax=($receiptInfo->service_tax*$itemtotal)/100;
                          $service_tax=($receiptInfo->service_tax/100)*($itemtotal*100);
                          $service_tax=floor($service_tax)/100;
                        $total+=$service_tax;
                        }
                        
                       ?>
                       {{number_format($service_tax,2)}}
                   </td>
                
               </tr>
               <tr class="billdetailtr disabled">
                   <td class="td1  ">Service&nbsp;Charge&nbsp;(<span id="bill_service_percentage" >{{$service_per}}%</span>)</td>
                   <td class="td2 text-center">+</td>
                   <td class="td3 ">MYR</td>
                   <td class="td4 text-right bill_service reset0"
                   id="bill_service">
                   <?php 
                        //$service_charge=floor(($service_per*$itemtotal*100))/10000;
                        $service_charge=($service_per/100)*($itemtotal*100);
                        $service_charge=floor($service_charge)/100;
                        $total+=$service_charge;
                       ?>
                       {{number_format($service_charge,2)}}
                   </td>
                
               </tr>
            
               <tr class="billdetailtr disabled">
                   <td class="td1">Rounding</td>
                   <td class="td2 text-center">
                     <?php 
                     if($receiptInfo->round>0){
                     $s="+";
                     }else{
                     $s="-";
                     }?>                   
                       {{$s}}
                   </td>
                   <td class="td3 ">MYR</td>
                   <td class="td4 text-right bill_service reset0"
                   id="bill_service">
                   {{number_format(abs($receiptInfo->round)/100,2)}}
                   </td>
                
               </tr>
               <?php
               $total+=($receiptInfo->round/100);
               ?>
               <tr class="billdetailtr disabled " style="border-top:1px solid #a0a0a0;margin-left:10px;width: 94%;">
                   <td class="td1 tdformat ">Total</td>
                   <td class="td2 tdformat "></td>
                   <td class="td3 tdformat ">MYR</td>
                   <td class="td4 text-right tdformat bold reset0 ftotal">{{number_format($total,2)}}</td>       
               </tr>
               <tr class="billdetailtr disabled">
                   <td class="td1 tdformat">Wallet</td>
                   <td class="td2 tdformat text-center">
                       <span style="font-size:15px;">-</span>
                   </td>
                   <td class="td3 tdformat">Pts</td>
                   <td class="td4 text-right tdformat">0.00</td> 
               </tr>
               
               <tr class="billdetailtr">
                   <td class="td1 tdformat">Other Points</td>
				   <td class="td2 tdformat text-center">
						<span style="font-size:15px;">-</span></td>
                   <td class="td3 tdformat">Pts</td>
				   <td class="td4 text-right tdformat" id="othernumber">
				   		{{number_format($receiptInfo->otherpoints/1.0,2)}}</td>
               </tr>

                <tr class="billdetailtr">
                   <td class="td1 tdformat">
                       Cash Received
                   </td>
				   <td class="td2 tdformat text-center">
				   		<span style="font-size:15px;">-</span></td>
                   <td class="td3 tdformat">MYR</td>
                   <td id="final_cash_received" 
                   class="td4 text-right tdformat  cash_received reset0">
                       {{number_format($receiptInfo->cash_received/100,2)}}
                   </td>
                
               </tr>
                <?php
					$remaining_amount=(($total*100)-$receiptInfo->cash_received-($receiptInfo->otherpoints*100))/100;
				?>
               <tr class="billdetailtr">
                   <td class="td1 tdformat">
                       Credit Card
                   </td>
				   <td class="td2 tdformat text-center">
				   		<span style="font-size:15px;">-</span></td>
                   <td class="td3 tdformat">MYR</td>
                   <td class="td4 text-right tdformat  ccardamt 
                   ccardelem reset0" id="ccardamt">
                       @if($receiptInfo->creditcard_no!=0 &&
                        !empty($receiptInfo->creditcard_no)
                        )
                        {{number_format($remaining_amount,2)}}
                        @else
                        0.00
                        @endif
                   </td>
                
               </tr>
               
               <tr class="billdetailtr" style="border-top:1px solid #a0a0a0;margin-left:10px;width: 94%;">
                   <td class="td1 tdformat">Change</td>
                   <td class="td2 tdformat">&nbsp;</td>
                   <td class="td3 tdformat">MYR</td>
                   <td class="td4 text-right tdformat  change reset0">

                        @if($receiptInfo->creditcard_no!=0 &&
                        !empty($receiptInfo->creditcard_no)
                        )
                        0.00
                        @else
                        
                       {{number_format(
                                   abs( ($receiptInfo->otherpoints+$receiptInfo->cash_received/100-$total)),2
                                )}}
                        @endif
                   </td>
                
               </tr>
               @if($receiptInfo->cash_received>0 and ($receiptInfo->creditcard_no==0 || empty($receiptInfo->creditcard_no)))
               <tr>
				   <td
				   style="padding-bottom:8px"
				   colspan="4">This bill is paid by Cash.</td>
               </tr>
               @else
               <tr class="billdetailtr">
                   <td class="td1 tdformat" colspan="1">

                   Credit Card No.</td>
                   
                   <td class="td4 text-right tdformat
                   ccmessage reset  ccardelem
                   " colspan="3"
                   id="creditcard" 
                   >
                  @if(!empty($receiptInfo->creditcard_no))
                            <p style="text-align:right;
                            font-size:15px;
                            padding-left: 0px;
                            margin-left: -50px;">
                                                  
                          XXXX-XXXX-XXXX-{{!empty($receiptInfo->creditcard_no)?$receiptInfo->creditcard_no:""}}
                            </p>
                    @endif
                    </td>
                
               </tr>
               @endif
               {{-- <tr char="billdetailtr">
                   <td colspan="4" class="td0 tdformat">
                       Summary
                   </td>
               </tr>

               <tr class="billdetailtr">
                   <td class="td1 tdformat">Amount</td>
                   <td class="td2 tdformat">&nbsp;</td>
                   <td class="td3 tdformat">MYR</td>
                   <td class="td4 text-right tdformat">0.00</td>
                
               </tr>
               <tr class="billdetailtr">
                   <td class="td1 tdformat">Service Tax</td>
                   <td class="td2 tdformat">{{$gst_rate}}%</td>
                   <td class="td3 tdformat">MYR</td>
                   <td class="td4 text-right tdformat">0.00</td>
                
               </tr> --}}
            {{--    <tr class="billdetailtr">
                   <td class="td1 tdformat">Total</td>
                   <td class="td2 tdformat">&nbsp;</td>
                   <td class="td3 tdformat">MYR</td>
                   <td class="td4 text-right tdformat">0.00</td>
                
               </tr>
 --}}
 		<!--
          <tr style="border-bottom:1px solid #a0a0a0;"></tr>
		  -->
			</table>
			<table style="margin-top:5px;margin-left:5px;width: 98%;" class="">
				@if($bfunction == 'spa')
				<!--
				<tr style="padding-top:5px" class="total-font">
					<td style="padding-top:5px" colspan="3"
						class="text-left">Key&nbsp;Number</td>
					<td style="padding-top:5px" colspan="1"
						class="text-right reset lockerkey"  id="">

						@if(count($key) > 0)
							@foreach($key as $value)
							{{sprintf('%05d',$value->fnumber)}},
							@endforeach
						@endif
					</td>
				</tr>
				-->

				<!--
				<tr style="padding-top:5px" class="total-font">
					<td style="padding-top:5px" colspan="3" class="text-left">Spa Room&nbsp;No.</td>
					<td style="padding-top:5px" colspan="1" class="text-right reset sparoomn  id=""></td>
				</tr>
				-->
				@elseif($bfunction=='table')
				<tr class="total-font">
					<td colspan="3" class="text-left">Table No.</td>
					<td colspan="1" class="text-right reset table">
				   {{--  {{sprintf('%05d',9)}} --}}</td>
				</tr>
				@elseif($bfunction=='hotel')
				<tr class="total-font">
					<td colspan="3" class="text-left">Hotel&nbsp;Room&nbsp;No.</td>
					<td colspan="1" class="text-right reset hotelroom">
				   {{--  {{sprintf('%05d',9)}} --}}</td>
				</tr>
				@endif
				<tr class="total-font" style="border-top:1px solid #a0a0a0">
					<td style="padding-top:5px" colspan="3" class="text-left">
						Branch</td>
					<td style="padding-top:5px" colspan="1" class="text-right"
						id="branch_name">{{$location->location}}</td>
				</tr>
				<tr class="total-font">
					<td colspan="3" class="text-left">Terminal&nbsp;ID</td>
					
					<td colspan="1" class="text-right" id="terminal_id">
					{{sprintf('%05d', $receiptInfo->terminal_id)}}
					
					</td>
				</tr>
				<tr class="total-font">
					<td colspan="3" class="text-left">Staff ID</td>
					<td colspan="1" class="text-right" id="staffid">
					{{sprintf('%010d',!empty($receiptInfo->staff_id)?$receiptInfo->staff_id:"0")}}
					</td>
				</tr>
				<!-- Receipt Modal -->
				<tr class="total-font">
					<td colspan="3" class="text-left">Staff Name</td>
					<td colspan="1" class="text-right" id="staffname">
					{{$receiptInfo->staff_name_concat or $receiptInfo->staff_name}}
					</td>
				</tr>
			</table>
			</table>

			<div style="margin-top:10px;z-index:10" class="invoice-control">
				<button onclick ="ask_print_qz()"
					class="invoice-control-btn center bold blue btn">
					<h5 style="margin:0">Print</h5></button>
			   
				<?php 
			
				if(Auth::user()->hasRole("vod") or
				   Auth::user()->hasRole("mer")){?>
			   <button id="red_void"
			   		style="z-index:10"
					receipt_id="{{$receiptInfo->id}}"
					  @if($is_eod=="eod")
					  disabled="disabled" 
					  @endif
					class="invoice-control-btn center bold red btn">
					<h5 style="margin:0">Void</h5></button>
				<?php } else{ ?>
			   <button id="red_void"
				   style="z-index:10"
					receipt_id="{{$receiptInfo->id}}"
					class="invoice-control-btn center bold red btn" disabled="disabled" title="You are not authorized for this function">
					<h5 style="margin:0">Void</h5></button>
				<?php } 
			 
				?>                           
				<!-- <button style="font-size:18px"
					class="bg-refund invoice-control-btn center crossbtn btn"
					onclick="getRefund({{$receiptInfo->id}});"
					> -->
				<button style="font-size:18px;z-index:10"
					class="bg-refund invoice-control-btn center crossbtn btn"
					onclick="sendEvent({{$receiptInfo->id}});"
					>Refund
				</button>
				<div id="qr"
					class="center qr invoice-control-btn center" >
				</div>
			</div>

 			<div class="text-right"
				style="font-size:10px;margin-right:10px;z-index:10">
			Neon Tetra Version 1.0
			</div> 

			<div class="center" style="margin-top:-25px;z-index:1">
				<canvas id="barcode"></canvas></div>

			<span id="barcodenumber"
				class="width100 float-left text-center"></span>                        
			<span id="thankyou"
				class="width100 float-left text-center">
				<b>Thank You!</b></span>                        
		</div>
		</div>
		</div>
		</div>
        @if(trim($receiptInfo->remark) != '')
        <div style="padding-top:30px;width:378px">
            <p class="total-font text-center" style="color:red"> Void Remarks </p>
            <p style="padding:10px;text-align:justify">{{$receiptInfo->remark}}</p>
        </div>
        @endif
    </div>
</div>

</div>
<div class="modal fade" id="opsLokerKeyDataModal" role="dialog">
    <div class="modal-dialog " style="width:385px !important">
        <!-- Modal content-->
        <div class="modal-content modal-content-sku">
            <div class="modal-header">
                <h2 id="opslokerdatatitle"></h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Temporarily disable the modal due to UGLY ERROR -->
            <div id="opslokerdatabody"
                style="padding-left:0;padding-right:0"
                class="modal-body"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="refundModal" role="dialog" style="width:100%;height: 1000px;">
    <div class="modal-dialog" style="max-width:100% !important">
        <!-- Modal content-->
        <div class="modal-content modal-content-sku" style="width:100% !important">
            <div class="modal-header">
                <h2 id="refundtitle"></h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Temporarily disable the modal due to UGLY ERROR -->
            <div id="refundbody"
                style="padding-left:0;padding-right:0;background-color: #ff9900;color:#fff"
                class="modal-body"></div>
        </div>
    </div>
</div>

 <script src="{{URL::to('opposum_libs/js/jquery-2.2.4.min.js')}}"></script>
 <script type="text/javascript" src="{{asset('opposum_libs/js/bootstrap.js')}}"></script>

 <script type="text/javascript" src="{{asset('js/qr.js')}}"></script>
 <script type="text/javascript" src="{{asset('js/barcode.js')}}"></script>

<script>
	sendEvent = function(receipt_id) {
  		k = new MessageEvent("sendClipboard", {
  		data: receipt_id
  		});

		document.dispatchEvent(k);
	}
  </script>

 <script type="text/javascript">


@if(!empty($receiptInfo->status) && $receiptInfo->status=="voided")
document.querySelector("#voidstamp").style.display="block";
document.querySelector("#red_void").style.display="none";
@endif
 var JS_BASE_URL="{{url()}}"
 var newBarcode = function(value) {
            //Convert to boolean
           // value=$('#invoiceno').text();
            $("#barcode").JsBarcode(
                value, {
                    "background":"white", //Transparent bg-> undefined, no quotes
                    "lineColor":"black",
                    "fontSize": 20,
                    "height": 50,
                    "width": 1.5,
                    "margin":2,
                    "textMargin":0,
                    //"displayValue":value,
                    "font":"monospace",
                    "fontOptions":"",
                    "textAlign":"center",
                    "price":"",
                    //"description":value,
                    "valid": function(valid){
                        if(valid){
                            $("#barcode").show();
							/*
                            $('#barcodenumber').html(value);
							 */
							$('#barcodenumber').html(pad(value,10));
                        } else{
                            $("#barcode").hide();
                        }
                    }
                }
            );
        };

	$(document).ready(function(){
        /*Void*/
        
		$("#do_void").click(function(){
		url="{{url('opossum/transaction/receiptvoid')}}"
            type="POST";
            data={
                receipt_id:"{{$receiptInfo->id}}",
                remark: $('#remark').val()
            }
            success=(r)=>{
                alert("Receipt Voided")
                
                if (r.status=="success") {
                    document.querySelector("#red_void").style.display="none";
                    $(".void-stamp").html(`Voided`);
                    $(".void-stamp").slideDown("fast");
                    document.querySelector("#voidstamp").style.display="block";
                    $("#voiddate").text(r.data)
                    //document.querySelector("#red_void").style.display="none";       
                }
            }
            error=(error)=>{
                alert("Failed to connect to server error");
            }
            $.ajax({
                url,
                data,
                type,
                success,
                error
            })

        })

    
    $("#red_void").click(function(){
        /*Show confirm modal.*/
         $(".modal").modal("hide");
        $("#confirmModal").modal("show");
       
    })


        $('#qr').html('');
        $('#qr').qrcode({height:70,width:70,text:"{{$receiptInfo->receipt_no}}{{$receiptInfo->voucher_id}}"});
        
        newBarcode({{$receiptInfo->receipt_no or 123}});

        $(document.body).on('click','.lockerkey',function(){
            lockerkey=$(this).text();
            var url=JS_BASE_URL+"/opossum/lokerkeydat";
            var v_activekey = $("#v_activekey").val();
            if(lockerkey != ''){ 
                $.ajax({
                    type: "POST",
                    url: "{{URL('/lokerkeydata')}}",
                    data:{lockerkey:lockerkey,v_activekey:v_activekey},
                    success: function(data) {
                        $('#opslokerdatatitle').html('Key No '+lockerkey);
                        $('#opslokerdatabody').html(data);
                        $('#opsLokerKeyDataModal').modal('show');
                    }
                });
            }
        });
     })

	function display_receipt(content) {
		top.consoleRef=window.open('','receipt','width=350,height=350');
		top.consoleRef.document.write(content)
		top.consoleRef.document.close()
    }

	function ask_print_qz() {
		content=generate_html();
		window.top.postMessage({
			type:"print_qz",
			content
		},'*');

		//display_receipt(content)
	}

	function pad(num, size) {
		var s = num+"";
		while (s.length < size) s = "0" + s;
		return s;
	}


	function generate_html() {

		barcodecanvas=document.getElementById('barcode');
		bimgdata=barcodecanvas.toDataURL('image/png');
		qrcanvas=document.querySelector('canvas');
		qrimgdata=qrcanvas.toDataURL('image/png');

		return `<html>
            <header><style>
            body {font-family: Arial, Helvetica, sans-serif}
            </style></header>
            <body>
            <div style="text-align:center"><h2 style="color: red;
    position: absolute;
    z-index: 2;
    font-size: 70px;
    font-weight: 500;
    margin-top: 311px;
    margin-left: 42px;
    transform: rotate(30deg);
    @if($receiptInfo->status=="voided")
    display:block;
    @else
    display:none;@endif">Voided<br>
              <span
              style="font-size:15px !important;"
              id="voiddate"
              >{{UtilityController::s_date(!empty($receiptInfo->voided_at)?$receiptInfo->voided_at:"")}}</span>
              </h2></div>
            @if(!empty($localLogo))
            <div style="text-align:center;font-size:16px;font-weight:bold;padding-bottom:6px;margin-bottom:0">
               <img src="{{url()}}/images/receipt/{{$receiptInfo->terminal_id}}/{{$localLogo}}" width="300px" height="100px" style="object-fit:contain">
            </div>
            @endif
            <h4 style="text-align:center;font-size:16px;font-weight:bold;padding:0;margin-bottom:0;margin-top:0">{{!empty($company->dispname)?$company->dispname:""}}</h4>
             <div style="text-align:center;font-size:14px;margin-bottom:5px">
                ({{!empty($company->business_reg_no)?$company->business_reg_no:""}}) &nbsp;&nbsp;
                @if($show_sst_no==true or $show_sst_no==1)<b>SST No: </b>
                {{!empty($company->gst)?$company->gst:""}}
                @endif
               
            </div>
            <div style="text-align:center;font-size:12px;margin-bottom:5px">

            <p style="padding-bottom:0;margin-bottom:-4px;margin-top:0">
            {{!empty($company->line1)?$company->line1:""}}</p>


            <p style="padding-bottom:0;margin-bottom:-4px;margin-top:5px">
			{{!empty($company->line2)?$company->line2:""}}
			{{!empty($company->line2)?', ':""}}
			{{!empty($company->line3)?$company->line3:""}} 
			</p>
            </div>

            <div style="margin-left:10px;font-size:13px">
            <b>Receipt No:</b> {{sprintf("%010d",!empty($receiptInfo->receipt_no)?$receiptInfo->receipt_no:"")}}
			<span style="float:right">
				{{Carbon::now()->format('dMy H:i:s')}}</span> 
            </div>

            <table style="width:100%;text-align:center;">
            <thead style="font-size:12px">
            <tr>
                <th style="border-top:1px solid #a0a0a0;border-bottom:1px solid #a0a0a0;text-align:left;padding-top:3px;padding-bottom:3px;padding-left:10px">
                    Description</th>
                <th style="border-top:1px solid #a0a0a0;border-bottom:1px solid #a0a0a0;text-align:center;padding-top:3px;padding-bottom:3px;padding-left:5px">
                    Qty</th>
                <th style="border-top:1px solid #a0a0a0;border-bottom:1px solid #a0a0a0;text-align:right;padding-top:3px;padding-bottom:3px;padding-left:5px">
                    Price</th>
                <th style="border-top:1px solid #a0a0a0;border-bottom:1px solid #a0a0a0;text-align:center;padding-top:3px;padding-bottom:3px;padding-left:5px">
                    Disc</th>
                <th style="border-top:1px solid #a0a0a0;border-bottom:1px solid #a0a0a0;text-align:right;padding-top:3px;padding-bottom:3px;padding-left:5px">
                    Total</th>
            </tr>
            </thead>
            <tbody style="font-size:12px">
            {!!$rows!!}
            </tbody>
            </table>

            <table style="padding-top:3px;border-top:1px solid #a0a0a0;font-size:12px;margin-bottom:5px;width:100%">
            <tr style="line-height:0.8em">
				<td>Item Amount</td>
				<td>&nbsp;</td>
				<td>MYR</td>
				<td style="text-align:right">
					<b>{{number_format($itemtotal,2)}}</b>
				</td>
            </tr>
            <tr style="line-height:0.8em">
				<td>Service&nbsp;Tax&nbsp;@if(empty($service_tax_per))0 @else{{$service_tax_per}}@endif%</td>
				<td style="text-align:center">+</td>
				<td>MYR</td>
				<td style="text-align:right">
					
					{{number_format($service_tax,2)}}
				</td>
			</tr>
			<tr style="line-height:0.8em">
				<td>Service&nbsp;Charge&nbsp;{{$service_per}}%</td>
				<td style="text-align:center">+</td>
				<td>MYR</td>
				<td style="text-align:right">
					
					{{number_format($service_charge,2)}}
				</td>
			</tr>
       <tr >
                   <td>Rounding</td>
                   <td style="text-align:center" class="td2">
                                        
                       {{$s}}
                   </td>
                   <td >MYR</td>
                  <td style="text-align:right">
                   {{number_format(abs($receiptInfo->round)/100,2)}}
                   </td>
                
               </tr>
			<tr><td></td></tr>



			<tr style="">
				<td style="line-height:0.8em;border-top:1px solid #a0a0a0;padding-top:5px;">Total</td>
				<td style="line-height:0.8em;border-top:1px solid #a0a0a0;padding-top:5px"></td>
				<td style="line-height:0.8em;border-top:1px solid #a0a0a0;padding-top:5px">MYR</td>
				<td style="text-align:right;line-height:0.8em;border-top:1px solid #a0a0a0;padding-top:5px">
					<b>{{number_format($total,2)}}</b>
				</td>       
			</tr>
			<tr style="line-height:0.8em">
				<td>Wallet</td>
				<td style="text-align:center">
					<span style="font-size:15px;">-</span>
				</td>
				<td>Pts</td>
				<td style="text-align:right">0.00</td> 
			</tr>
			<tr style="line-height:0.8em">
				<td>Other Points</td>
				<td style="text-align:center">
					<span style="font-size:15px;">-</span></td>
				<td>Pts</td>
				<td style="text-align:right">
					{{number_format($receiptInfo->otherpoints/1.0,2)}}</td>
			</tr>
			<tr style="line-height:0.8em">
				<td>Cash Received</td>
				<td style="text-align:center">
					<span style="font-size:15px;">-</span></td>
				<td>MYR</td>
				<td style="text-align:right">
					{{number_format($receiptInfo->cash_received/100,2)}}
				</td>
			</tr>
			<tr style="line-height:0.8em">
				<td>Credit Card</td>
				<td style="text-align:center">
					<span style="font-size:15px;">-</span></td>
				<td>MYR</td>
				<td style="text-align:right">
					@if($receiptInfo->creditcard_no!=0 &&
						!empty($receiptInfo->creditcard_no))
						{{number_format($remaining_amount,2)}}
					@else
						0.00
					@endif
			   </td>
			</tr>
			<tr style="line-height:1.2em;margin-left:10px;width: 94%;">
				<td style="border-top:1px solid #a0a0a0">Change</td>
				<td style="border-top:1px solid #a0a0a0">&nbsp;</td>
				<td style="border-top:1px solid #a0a0a0">MYR</td>
				<td style="border-top:1px solid #a0a0a0;text-align:right">
					@if($receiptInfo->creditcard_no!=0 &&
						!empty($receiptInfo->creditcard_no))
						0.00
					@else
						{{number_format(abs((
							$receiptInfo->otherpoints+$receiptInfo->cash_received/100-$total)),2)}}
					@endif
				</td>
			</tr>

			@if($receiptInfo->cash_received>0 and
				($receiptInfo->creditcard_no==0 ||
				empty($receiptInfo->creditcard_no)))
				<tr style="line-height:0.8em">
					<td colspan="4">This bill is paid by Cash.</td>
				</tr>
			@else
				<tr style="line-height:0.8em" class="billdetailtr">
					<td colspan="1">
						Credit Card No.
					</td>
					<td colspan="3">
					@if(!empty($receiptInfo->creditcard_no))
						<p style="text-align:right;
						font-size:12px;
						padding-left: 0px;
						margin-left: -50px;">
							XXXX-XXXX-XXXX-{{
							!empty($receiptInfo->creditcard_no)?$receiptInfo->creditcard_no:""}}
						</p>
                    @endif
                    </td>
               </tr>
			@endif
			</table>

			<!-- This is for hardcopy instance of the receipt -->
			<table style="line-height:0.8em;border-top:1px solid #a0a0a0;width:100%;padding-top:2px">
				<tr style="margin-top:5px;font-weight:bold;font-size:14px">
				<td style="text-align:left">Branch</td>
				<td colspan="3" style="text-align:right" id="branch_name">{{$location->location}}</td>
				</tr>
				<tr style="font-weight:bold;font-size:14px">
				<td colspan="3" style="text-align:left">Terminal&nbsp;ID</td>

				<td colspan="1" style="text-align:right" id="terminal_id">
				{{sprintf('%05d', $receiptInfo->terminal_id)}}
				</td>
				</tr>
				<tr style="font-weight:bold;font-size:14px">
				<td colspan="3" style="text-align:left">Staff ID</td>
				<td colspan="1" style="text-align:right">
				{{sprintf('%010d',!empty($receiptInfo->staff_id)?$receiptInfo->staff_id:"0")}}
				</td>
				</tr>
				<tr style="font-weight:bold;font-size:14px">
				<td colspan="3" style="text-align:left">Staff Name</td>
				<td colspan="1" style="text-align:right">
				{{$receiptInfo->staff_name_concat or $receiptInfo->staff_name}}
				</td>
				</tr>
			</table>

			<div style="z-index:20;margin-top:10px;text-align:center">
				<img src="${qrimgdata}"/></div>
			<div style="z-index:10;text-align:center;">
				<img src="${bimgdata}"/></div>
			<div style="text-align:center;font-size:12px">
				{{sprintf("%010d",!empty($receiptInfo->receipt_no)?$receiptInfo->receipt_no:"")}}
			</div>
 			<div style="margin-top:5px;font-size:13px;font-weight:bold;text-align:center">Thank You!</div>
 

		</body>
		</html>`
	}
 </script>
