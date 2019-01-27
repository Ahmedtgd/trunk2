
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
</style>


<div id="eodsummary_modal"
	style="overflow-x:hidden;overflow-y:auto"

    <div class="modal-dialog1">
        <!-- Modal content-->
        <div class="modal-content1" style="width:400px;height:auto">
     
        </div>
            <div id="style"></div>
            <div style="padding:0" class="modal-body1">
			<div style="padding-left:5px" class="">
			<div id="invoice-container" class="invoice-container"
				style="padding-left:5px;padding-right:5px;width:390px">
			<!--
			<h3 class="rheader">Receipt</h3>
			-->
            @if(!empty($localLogo))
            <div class="text-center" style="padding-bottom:10px">
			   <img src="{{url()}}/images/receipt/{{$terminal_id}}/{{$localLogo}}"
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
			   style="margin-top:5px;margin-left:10px;font-weight:bold"></p>
			<span id="invoiceno"
				class="float-left bold invoice-title"></span>
			<span
				class="float-right"
				style="margin-top:5px;margin-right:10px">
				{{UtilityController::s_date($log->eod)}}</span>
			<br>
			<div class="row" style="padding-left:4px;font-size:18px">
				<strong>End Of The Day Summary</strong>
			</div>
			<form id="recsaveform" name="recsaveform"
				style="margin-bottom:0;padding-bottom:0;"
				method="post">

			<table style="margin-bottom:0;padding-bottom:0"
				class="table ">
				<thead class="white">
				</thead>
				<tbody class="white">
				<tr>
				  <td><strong>Branch Sales</strong></td>
				  <td><strong>MYR</strong></td>   
				  <td class="text-right"><strong>{{number_format($branchsale/100,2)}}</strong></td>
				</tr>
				<tr>
				  <td>Today Sales</td>
				  <td>MYR</td>
				  <td class="text-right">{{number_format($todaytotal/100,2)}}</td>
				</tr>    
				<td>Service Charge</td>
				  <td>MYR</td>
				  <td class="text-right">{{number_format(floor($todayservicecharge)/100,2)}}</td>

				<tr>
				  <td>SST</td>
				  <td>MYR</td>
				  <!-- <td class="text-right">{{--number_format(floor($todaysst)/100,2)--}}</td> -->
				  <td class="text-right">{{number_format($todaysst/100,2)}}</td>
				</tr> 
				<tr style="border-top:1px solid #a0a0a0;"
					class="">
				  <td>Cash</td>
				  <td>MYR</td>
				  <td class="text-right">{{number_format($cash/100,2)}}</td>
				</tr> 
				<tr>
				  <td>CreditCard</td>
				  <td>MYR</td>
				  <td class="text-right">{{number_format($creditcard/100,2)}}</td>
				</tr> 
				<tr>
				  <td>Other Points</td>
				  <td>Pts</td>
				  <td class="text-right">{{number_format($otherpoints,2)}}</td>
				</tr> 
				<tr>
				  <td>Wallet</td>
				  <td>Pts</td>
				  <td class="text-right">{{number_format(0/100,2)}}</td>
				</tr> 
			  </tbody>
			</table>
			</form>
				
			<div style="margin-left:10px;margin-top:0"
					class="total total-font rec-staf width100"></div>
			<table style="padding-top:0;padding-bottom:0;margin-bottom:0" class="table">
			</table>
			<table style="margin-top:5px;border-top:1px solid #a0a0a0;margin-left:5px;width: 98%;" class="">
	
				<tr class="total-font">
					<td style="padding-top:5px" colspan="3" class="text-left">
						Branch</td>
					<td style="padding-top:5px" colspan="1" class="text-right"
						id="branch_name">{{$location->location}}</td>
				</tr>
				<tr class="total-font">
					<td colspan="3" class="text-left">Terminal&nbsp;ID</td>
					
					<td colspan="1" class="text-right" id="terminal_id">
					{{sprintf('%05d', $terminal_id)}}
					
					</td>
				</tr>
				<tr class="total-font">
					<td colspan="3" class="text-left">Staff ID</td>
					<td colspan="1" class="text-right" id="staffid">
					{{--sprintf('%010d',!empty($staff_id)?$staff_id:"0")--}}
					<?php
						echo !empty($staffid)?$staffid:"0";
					?>
					</td>
				</tr> 
				
			 	<tr class="total-font">
					<td colspan="3" class="text-left">Staff Name</td>
					<td colspan="1" class="text-right" id="staffname">
					{{$staffname}}
					</td>
				</tr>
			</table>
			</table>

			<br>
      <div class="invoice-control">
        <button onclick ="ask_print_qz()"
          class="invoice-control-btn pull-left bold blue btn">
          <h5 style="margin:0">Print</h5></button>
      </div>
	</div>
	</div>
	</div>
    </div>
</div>
</div>

{{--  <script src="{{URL::to('opposum_libs/js/jquery-2.2.4.min.js')}}"></script>
 <script type="text/javascript" src="{{asset('opposum_libs/js/bootstrap.js')}}"></script>
 --}}


 <script type="text/javascript">
	function display_receipt(content) {
		top.consoleRef=window.open('','receipt','width=350,height=350');
		top.consoleRef.document.write(content)
		top.consoleRef.document.close()
		
    }

	function ask_print_qz() {
		console.log('inpritbutton');
		content=generate_html();
		
		printWin=window.open('','receipt','width=350,height=350');
		printWin.document.write(content);
		printWin.document.close();
		printWin.focus();
		printWin.print();
	    printWin.close();
		// window.top.postMessage({
		// 	type:"print_qz",
		// 	content
		// },'*');

		/* For debugging ONLY */
		// display_receipt(content)
	}


	function generate_html() {

 		return `<html>
            <header><style>
            body {font-family: Arial, Helvetica, sans-serif}
            </style></header>
            <body> 
			<div style="text-align:center">
            @if(!empty($localLogo))
            <div class="text-center" style="padding-bottom:10px">
			   <img src="{{url()}}/images/receipt/{{$terminal_id}}/{{$localLogo}}"
			   style="object-fit:contain;width:300px;height:100px">
            </div>
            @endif

			<h4 class="company_name" style="margin-bottom:0">
			{{!empty($company->dispname)?$company->dispname:""}}
			</h4>

			<div style="text-align:center;font-size:14px">
                ({{!empty($company->business_reg_no)?$company->business_reg_no:""}})&nbsp;&nbsp

                @if($show_sst_no==true or $show_sst_no==1)<b>SST No: </b>
                {{!empty($company->gst)?$company->gst:""}}
                @endif
            </div>

			<p class="company_addr" style="margin-top:0;margin-bottom:0">
			{{!empty($company->line1)?$company->line1:""}}</p>

			<p class="company_addr" style="margin-top:0;margin-bottom:0">
			{{!empty($company->line2)?$company->line2:""}}
			{{!empty($company->line2)?', ':""}}
			{{!empty($company->line3)?$company->line3:""}} 
			</p>

			<p class="float-left invoice-title"
			   style="margin-top:5px;margin-left:10px;font-weight:bold"></p>
			<span id="invoiceno"
				class="float-left bold invoice-title"></span>
			<span
				style="float:right;font-size:14px;margin-top:-5px;margin-right:10px">
				{{UtilityController::s_date($log->eod)}}</span>
			<br>
			<div class="row" style="float:left;margin-left:2px;margin-top:5px;margin-bottom:5px;
				padding-left:0;font-size:18px">
				<strong>End Of The Day Summary</strong>
			</div>
			<form id="recsaveform" name="recsaveform"
				style="margin-bottom:0;padding-bottom:0;"
				method="post">

			<table style="margin-bottom:0;padding-bottom:0;width:98%"
				class="table ">
				<thead class="white">
				</thead>
				<tbody class="white">
				<tr>
				  <td><strong>Branch Sales</strong></td>
				  <td><strong>MYR</strong></td>   
				  <td style="text-align:right"><strong>{{number_format($branchsale/100,2)}}</strong></td>
				</tr>
				<tr>
				  <td>Today Sales</td>
				  <td>MYR</td>
				  <td style="text-align:right">{{number_format($todaytotal/100,2)}}</td>
				</tr>    
				<td>Service Charge</td>
				  <td>MYR</td>
				  <td style="text-align:right">{{number_format($todayservicecharge/100,2)}}</td>

				<tr>
				  <td>SST</td>
				  <td>MYR</td>
				  <td style="text-align:right">{{number_format($todaysst/100,2)}}</td>
				</tr> 
				<tr>
				  <td>Cash</td>
				  <td>MYR</td>
				  <td style="text-align:right">{{number_format($cash/100,2)}}</td>
				</tr> 
				<tr>
				  <td>CreditCard</td>
				  <td>MYR</td>
				  <td style="text-align:right">{{number_format($creditcard/100,2)}}</td>
				</tr> 
				<tr>
				  <td>Other Points</td>
				  <td>Pts</td>
				  <td style="text-align:right">{{number_format($otherpoints,2)}}</td>
				</tr> 
				<tr>
				  <td>Wallet</td>
				  <td>Pts</td>
				  <td style="text-align:right">{{number_format(0/100,2)}}</td>
				</tr> 
			  </tbody>
			</table>
			</form>
				
			<div style="margin-left:10px;margin-top:0"
					class="total total-font rec-staf width100"></div>
			<table style="padding-top:0;padding-bottom:0;margin-bottom:0" class="table">
			</table>
			<table style="margin-top:5px;border-top:1px solid #a0a0a0;margin-left:0;width: 98%;" class="">
	
				<tr class="total-font">
					<td style="padding-top:5px" colspan="3" class="text-left">
						Branch</td>
					<td style="padding-top:5px;text-align:right" colspan="1" 
						id="branch_name">{{$location->location}}</td>
				</tr>
				<tr class="total-font">
					<td colspan="3" class="text-left">Terminal&nbsp;ID</td>
					
					<td colspan="1" style="text-align:right" id="terminal_id">
					{{sprintf('%05d', $terminal_id)}}
					
					</td>
				</tr>
				<tr class="total-font">
					<td colspan="3" class="text-left">Staff ID</td>
					<td colspan="1" style="text-align:right" id="staffid">
					{{--sprintf('%010d',!empty($staff_id)?$staff_id:"0")--}}
					<?php
						echo !empty($staffid)?$staffid:"0";
					?>
					</td>
				</tr> 
				
			 	<tr class="total-font">
					<td colspan="3" class="text-left">Staff Name</td>
					<td colspan="1" style="text-align:right" id="staffname">
					{{$staffname}}
					</td>
				</tr>
			</table>
			</table> 
		</div>
		</body>
		</html>`
		}

 </script>
