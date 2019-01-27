<?php use App\Http\Controllers\UtilityController;

$total=0;
$c=1;
?>
@extends("common.default")
@section("content")
@include('common.sellermenu')
<!-- <h3>{{ $today }} {{$month}} {{$year}}</h3> -->
<br>
<div class="container">
<div class="row">
<div class="col-sm-12">
    <div class="col-md-6">
        <div class="row">
            <h2>Receipt List (OPOSsum)</h2>
            <h3>{{$month}} {{$year}}</h3>
        </div>
    </div>
     <div class="col-md-3">
        <div class="pull-right" style="margin-top: 15px;">
		<table>
		<tr>
            <td>Branch:</td>
			<td>{{$location->location}}</td>
		</tr>
		<tr>
            <td>Terminal ID:&nbsp;&nbsp;</td>
			<td>{{sprintf('%05d',$terminalId)}}</td>
		</tr>
		</table>
        </div>
    </div> 
    <div class="col-md-3" style="padding-right:0">
        <div class="pull-right" style="margin-top: 15px;">
		<table>
		<tr>
            <td>Monthly:&nbsp;&nbsp;</td>
			<td class="text-right">
                <?php $monthtotal = 0; ?>
                @foreach($monthlyAmount as $receipt)
                <?php
              
                 if($receipt->status=="voided"){
                      //$monthtotal -= $receipt->amount;
                  } else{
                    $monthtotal += $receipt->amount;
                  }
                ?>
                 @endforeach
				{{$currency}} {{number_format($monthtotal,2)}}</td>
		</tr>
		<tr>
            <td>Today:</td>
			<td class="text-right">
				<?php $todaytotal = 0; ?>
                @foreach($todayAmount as $receipt)
                <?php 
                  if($receipt->status=="voided"){
                     // $todaytotal -= $receipt->amount;
                  } else{
                $todaytotal += $receipt->amount;
                  }
                ?>
                 @endforeach
                {{$currency}} {{number_format($todaytotal,2)}}
               
            </td>
		</tr>
		</table>                
        </div>
    </div>

	<p style="position:relative;right:400px;top:38px;color:blue;font-size:12px">
	*This is following calendar day</p>


<table id="opdt" cellspacing="0" class="table table-striped" width="100%">
    <thead>
    
    <tr class="bg-opossum">
        <th class="text-center">Date</th>
        <th class="text-center">Receipt No.</th>

        <th class="text-center">Amount ({{$currency}})</th>
    </tr>
    </thead>

    <tbody>
        <?php 
        $previous_receipt_no="";
        $skip=false;
        $color="yellow"; 
        ?>
        @if(isset($monthlyAmount))
            @foreach($monthlyAmount as $key=> $p)
                              
			@if($color=="red")
			<?php $skip=true; ?>
			@endif
			<?php $color="yellow";
			?>                            

            @if(!empty($reports[$key+1]->receipt_no)
            && $reports[$key+1]->receipt_no==$p->receipt_no)
				<?php $color="red"; ?>

            @endif
            @if(!$skip)
                <tr>
                    <td class="text-center">
                        @if(isset($p->created_at))
                            {{UtilityController::s_date($p->created_at,true)}}
                        @endif
                    </td>

                    <td class="text-center"
						style="background-color:@if($p->status=="voided")red @else yellow @endif;">

						<a href="javascript:void(0);"
                            onclick='showopossumreceipt(
                                "{{url('showreceiptproduct', ['id' => $p->id])}}"
                            )'
							class="uniqopossum" id="uniqreport_{{$p->id}}">
							{{UtilityController::nsid($p->receipt_no,10,"0")}}
						</a></td>
                
                    <td style="text-align: right;padding-right:40px">
						{{number_format($p->amount,2)}} </td>
                </tr>
                @endif

              <?php 
                    $c+=1;
                    $skip=false;
              ?>
            @endforeach
        @endif
    </tbody>
</table>
</div>
</div>
</div>

<div class="modal fade oreceipt" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:400px;height: 100%;">
    <div class="modal-content">
       
        <iframe src="" frameborder="0" style="width: 400px;height:1200px !important;" scrolling="no" id="myframe"></iframe>
      </div>
  </div>
</div>
<br> <br>
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
        $('.oreceipt').on('shown.bs.modal',function(){      //correct here use 'shown.bs.modal' event which comes in bootstrap3
          $(this).find('iframe').attr('src',$url)
        })
        $(".oreceipt").modal("show")
    }
  $(document).ready(function(){
    var id="#opModalLabel2";
    $(id).text('OPOSsum Receipt List');
    $('#opdt').DataTable({
		 "order": [],
		 fixedHeader: {
			footer: true
		},
		/* "scrollX":true,*/
		});
    
  });
</script>


@stop
