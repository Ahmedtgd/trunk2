<?php
use App\Http\Controllers\UtilityController as UC;
use App\Http\Controllers\IdController;
use App\Classes;
$i = 1;
//$selleruser="";
$cmlbalance=0;
?>
@extends("common.default")
@section("content")

@include("common.sellermenu")

<style type="text/css">
	.numaric{
	    background-color: #0580FE;
	    color: white;
	     border-radius: 10px;
	}
	.pad-control{
    width: 70px;
    height: 70px;
    margin-left: 5px;
	}	
	.table td{
    border-top: none;
    vertical-align: middle;
    line-height: 1;
    padding-top: 5px;
    padding-left:5px;
    padding-right:5px;
    padding-bottom: 5px;
	}
  	.red{
    background-color:#FF0402;
    color: white; 
	}
	.tablesmall td{
		border: none !important;
	}
</style>
<br>
<div class="container">
	<div class="row">
		<div class="col-sm-9">
			<h2>Cash Management Ledger</h2>
		</div>
		<div class="col-sm-3">
			<table style="margin-left:30px;margin-bottom:10px"
				class="table tablesmall">
				<tr>
					<td style="padding-left:0;width:90px;padding-top:2px;padding-bottom:2px">
					<strong>Branch</strong></td>
					<td style="padding-left:0;padding-top:2px;padding-bottom:2px">
					{{$terminal->location}}</td>
				</tr>
				<tr>
					<td style="padding-left:0;width:90px;padding-top:2px;padding-bottom:2px">
					<strong>Terminal&nbsp;ID</strong></td>
					<td style="padding-left:0;padding-top:2px;padding-bottom:2px">
					{{sprintf("%05d",$terminal->terminal_id)}}</td>
				</tr>
				<tr>
					<td style="width:90px;padding-left:0px;padding-top:2px;padding-bottom:2px">
					<strong>Balance</strong></td>
					<td style="padding-left:0;padding-top:2px;padding-bottom:2px">
					MYR <span id="cmlbalance"></span> </td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<table id="cml" class="table">
			<thead>
				<tr style="background-color:green;color:white">
					<th class="text-center">No</th>
					<th class="text-center">Reason</th>
					
					<th class="text-center">Last Update</th>
					
					<th class="text-right">Amount (MYR)</th>
					
				</tr>
			</thead>
			<tbody>
				@def $i=1
				@foreach($cml as $c)
					<?php
						$amount=$c->amount;
						if ($c->type=="cash") {
							if ($c->cash<$c->amount) {
								$amount=$c->amount;
							}
						}
						if(!empty($c->service_charges)) {
							$amount+=(($c->service_charges/100)*$amount);
						}
					?>
					@if($c->status=="voided")

					<tr>
						<td class="text-center">{{$i}}</td>
						<td class="text-center">

							<a href="javascript:void(0)"
							@if($c->type=="reason")
							onclick="showreasonmodal(
							'{{number_format($c->amount/100,2)}}',
							'{{ucfirst($c->description)}}',
							'{{$c->mode}}',
							'{{$c->name}}',
							'{{sprintf('%05d',$c->user_id)}}'
							)"
							@else
							onclick='showopossumreceipt(
                                "{{url('showreceiptproduct', ['id' => $c->id])}}"
                            )'
							@endif

						>Voided Sales</a></td>
						
						<td class="text-center">
						{{date("dMy H:i:s",strtotime($c->voided_at))}}</td>
						
						<td class="text-right">
							
							-{{number_format($amount/100,2)}}
							
						</td>
					</tr>
					<?php
					$cmlbalance-=$c->amount;
					$i+=1
					?>
					@endif
					<tr>
						<td class="text-center">{{$i}}</td>
						<td class="text-center">
							<a href="javascript:void(0)"
							@if($c->type=="reason")
							onclick="showreasonmodal(
							'{{number_format($c->amount/100,2)}}',
							'{{ucfirst($c->description)}}',
							'{{$c->mode}}',
							'{{$c->name}}',
							'{{sprintf('%05d',$c->user_id)}}'
							)"
							@else
							onclick='showopossumreceipt(
                                "{{url('showreceiptproduct', ['id' => $c->id])}}"
                            )'
							@endif

						>{{ucfirst($c->description)}}</a></td>
						
						<td class="text-center">
						{{date("dMy H:i:s",strtotime($c->updated_at))}}</td>
						
						<td class="text-right">
							
							@if($c->mode=="out")-@endif{{number_format($amount/100,2)}}</td>
					</tr>
					
				<?php 
                               
				if ($c->mode=="in") {
					# code...
					$cmlbalance+=$amount;
				}else{
					$cmlbalance-=$amount;
				}
				$i+=1?>
				@endforeach
			</tbody>

			</table>
		</div>
	</div>
</div>
<br><br>
<div class="modal fade oreceipt" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:400px;height: 100%;">
    <div class="modal-content">
       
        <iframe src="" frameborder="0" style="width: 400px;height:1200px !important;" scrolling="no" id="myframe"></iframe>
      </div>
  </div>
</div>


<!-- Petty cash Model -->
<div class="modal fade" id="reasonmodel" role="dialog">
    <div class="modal-dialog maxwidth60" style="max-width: 65%;">

        <!-- Modal content-->
        <div class="modal-content  modal-content-patty" style="width: 400px;
        width: 50% !important;
    margin: auto;
        ">
            <div class="modal-header">
                <h3>Petty Cash</h3>
                <button type="button" style="margin-top:-33px;" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div id="pattymodalbody" style="padding-top:8px" class=" modal-body">

                <label class="pad-control textblack margin-left0 numaric pettyin "  onclick="pettycashmode('in')" style="text-align: center; border-radius:5px;
    padding-top: 24px;">In</label>
                <label class="pad-control textblack margin-left0 red pettyout  " style="text-align: center;  border-radius:5px; padding-top: 24px;"
                >Out</label>
                <table class="table" style="width: 100% !important;">
                <br>
                    <tr>
                        <td>Staff&nbsp;Name</td>
                        <td class="staffname"></td>
                    </tr>
                    <tr>
                        <td>Staff ID</td>
                        <td class="staffid"></td>
                    </tr>
                    
                    <form id="pettycash">
                        <input type="hidden" name="mode" value="" id="pettycashmode" class="reset">
                        <input type="hidden" name="terminal_id" id="pettycashterminalid">
                        
                        <tr>
                            <td>Reason</td>
                            <td >
                                <label class="reason no_select2 noselect2" disabled="disabled" style="width: 100%;">
                                	
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>MYR</td>
                            <td class="">
                                <input type="text" name="amount" class="form-control amount" placeholder="MYR" style="background-color: black;color: white"
                                disabled="disabled" 
                                >
                            </td>
                        </tr>
                    </form>
                </table>
            </div>
            <div class="modal-header">
                <div><br></div>
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
<script type="text/javascript">

/***********************************************
* IFrame SSI script II- (c) Dynamic Drive DHTML code library (http://www.dynamicdrive.com)
* Visit DynamicDrive.com for hundreds of original DHTML scripts
* Please keep this notice intact
***********************************************/

//Input the IDs of the IFRAMES you wish to dynamically resize to match its content height:
//Separate each ID with a comma. Examples: ["myframe1", "myframe2"] or ["myframe"] or [] for none:
var iframeids=["myframe"]

//Should script hide iframe from browsers that don't support this script (non IE5+/NS6+ browsers. Recommended):
var iframehide="yes"

var getFFVersion=navigator.userAgent.substring(navigator.userAgent.indexOf("Firefox")).split("/")[1]
var FFextraHeight=parseFloat(getFFVersion)>=0.1? 16 : 0 //extra height in px to add to iframe in FireFox 1.0+ browsers

function resizeCaller() {
var dyniframe=new Array()
for (i=0; i<iframeids.length; i++){
if (document.getElementById)
resizeIframe(iframeids[i])
//reveal iframe for lower end browsers? (see var above):
if ((document.all || document.getElementById) && iframehide=="no"){
var tempobj=document.all? document.all[iframeids[i]] : document.getElementById(iframeids[i])
tempobj.style.display="block"
}
}
}

function resizeIframe(frameid){
var currentfr=document.getElementById(frameid)
if (currentfr && !window.opera){
currentfr.style.display="block"
if (currentfr.contentDocument && currentfr.contentDocument.body.offsetHeight) //ns6 syntax
currentfr.height = currentfr.contentDocument.body.offsetHeight+FFextraHeight; 
else if (currentfr.Document && currentfr.Document.body.scrollHeight) //ie5+ syntax
currentfr.height = currentfr.Document.body.scrollHeight;
if (currentfr.addEventListener)
currentfr.addEventListener("load", readjustIframe, false)
else if (currentfr.attachEvent){
currentfr.detachEvent("onload", readjustIframe) // Bug fix line
currentfr.attachEvent("onload", readjustIframe)
}
}
}

function readjustIframe(loadevt) {
var crossevt=(window.event)? event : loadevt
var iframeroot=(crossevt.currentTarget)? crossevt.currentTarget : crossevt.srcElement
if (iframeroot)
resizeIframe(iframeroot.id);
}

function loadintoIframe(iframeid, url){
if (document.getElementById)
document.getElementById(iframeid).src=url
}

if (window.addEventListener)
window.addEventListener("load", resizeCaller, false)
else if (window.attachEvent)
window.attachEvent("onload", resizeCaller)
else
window.onload=resizeCaller

</script>

<script type="text/javascript">
	function showopossumreceipt($url) {
		//correct here use 'shown.bs.modal' event which comes in bootstrap3 
        $('.oreceipt').on('shown.bs.modal',function(){
			$(this).find('iframe').attr('src',$url)
        })
        $(".oreceipt").modal("show")
    }

	function showreasonmodal(amount,reason,mode,staffname,staffid){
		if (mode=="in") {
			$(".pettyout").hide();
			$(".pettyin").show();
		}else{
			$(".pettyout").show();
			$(".pettyin").hide();
		}
		$('.reason').empty();
		reason=`
		<option selected>`+reason+`</option>

		`
		$(".modal").modal("hide");
		$(".amount").val(amount.replace("-",""));
		$(".reason").html(reason);
		$(".cashmode").text(mode);
		$(".staffname").text(staffname);
		$(".staffid").text(staffid);
		$("#reasonmodel").modal("show");
	}
	$(document).ready(function(){
		$("#cmlbalance").text("{{number_format($cmlbalance/100,2)}}")
		$("#cml").DataTable()
	})
</script>
@stop
