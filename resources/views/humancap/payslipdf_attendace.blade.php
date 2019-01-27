<style>
#paysliptable{
	border-collapse:collapse;
}
#paysliptable td{
	padding: 3px;
	margin: 0;
	border-right:1px solid black;
}
</style>
<table style="width:100%;">
   <tr>
	  <td>
		<div>Name: @if(isset($payslip['username'])){{$payslip['username']}}@endif</div>
	  </td>
	  <td style="text-align:right;">
		<div>{{date('d-m-Y')}}</div>	
	  </td>
   </tr>
   <tr>
	  <td>
		<div>Staff No.: @if(isset($payslip['employeeid']))[{{str_pad($payslip['employeeid'], 10, '0', STR_PAD_LEFT)}}]@endif</div>
	  </td>
	  <td style="text-align:right;">
		<div>Payslip for @if(date('m') == date('m', strtotime('+1 week'))){{date('F', strtotime('+4 week'))}} @else {{date('F')}} @endif, {{date('Y')}}</div>
	  </td>
   </tr>   
</table>
<br>
<table width="100%" id="paysliptable">
	<tr style="border:1px solid black;">
		<td width="30%" style="border:1px solid black;"><b>Income</b></td>
		<td width="10%" width="30%" style="border:1px solid black;"><b>Current</b></td>
		<td width="10%" width="30%" style="border:1px solid black;"><b style="float:right;">Y-T-D</b></td>
		<td width="30%" width="30%" style="border:1px solid black;"><b>Deduction</b></td>
		<td width="10%" width="30%" style="border:1px solid black;"><b>Current</b></td>
		<td width="10%" width="30%" style="border:1px solid black;"><b style="float:right;">Y-T-D</b></td>						
	</tr>
	<tr style="border-left:1px solid black;border-right:1px solid black;">
		<td style="border-left:1px solid black;">Basic Pay</td>
		<td > @if(isset($payslip['basic_pay']))<span style="float: right;">{{$payslip['basic_pay']}}</span>@endif</td>
		<td >@if(isset($payslip['basic_pay_ytd']))<span style="float: right;">{{$payslip['basic_pay_ytd']}}</span>@endif</td>
		<td >Advance</td>
		<td ></td>
		<td ></td>
	</tr>
	<tr style="border-left:1px solid black;border-right:1px solid black;">
		<td style="border-left:1px solid black;">Bonus</td>
		<td >@if(isset($payslip['bonus']))<span style="float: right;">{{$payslip['bonus']}}</span>@endif</td>
		<td ></td>
		<td >EPF</td>
		<td >@if(isset($payslip['epf']))<span style="float: right;">{{$payslip['epf']}}</span>@endif</td>
		<td >@if(isset($payslip['epf_ytd']))<span style="float: right;">{{$payslip['epf_ytd']}}</span>@endif</td>
	</tr>	
	<tr style="border-left:1px solid black;border-right:1px solid black;">
		<td style="border-left:1px solid black;"></td>
		<td ></td>
		<td ></td>
		<td >SOCSO</td>
		<td >@if(isset($payslip['socso']))<span style="float: right;">{{$payslip['socso']}}</span>@endif</td>
		<td >@if(isset($payslip['socso_ytd']))<span style="float: right;">{{$payslip['socso_ytd']}}</span>@endif</td>
	</tr>		
	<tr style="border-left:1px solid black;border-right:1px solid black;">
		<td style="border-left:1px solid black;"></td>
		<td ></td>
		<td ></td>
		<td >PCB</td>
		<td >@if(isset($payslip['pcb']))<span style="float: right;">{{$payslip['pcb']}}</span>@endif</td>
		<td >@if(isset($payslip['pcb_ytd']))<span style="float: right;">{{$payslip['pcb_ytd']}}</span>@endif</td>
	</tr>
	<tr style="border-left:1px solid black;border-right:1px solid black;">
		<td style="border-left:1px solid black;"></td>
		<td ></td>
		<td ></td>
		<td >CP38</td>
		<td ></td>
		<td ></td>
	</tr>	
	<tr style="border-left:1px solid black;border-right:1px solid black;">
		<td style="border-left:1px solid black;"></td>
		<td >&nbsp;</td>
		<td ></td>
		<td ></td>
		<td ></td>
		<td ></td>
	</tr>		
	<tr style="border-left:1px solid black;border-right:1px solid black;">
		<td style="border-left:1px solid black;"></td>
		<td >&nbsp;</td>
		<td ></td>
		<td ></td>
		<td ></td>
		<td ></td>
	</tr>
	<tr style="border-left:1px solid black;border-right:1px solid black;">
		<td style="border-left:1px solid black;"></td>
		<td >&nbsp;</td>
		<td ></td>
		<td ></td>
		<td ></td>
		<td ></td>
	</tr>
	<tr style="border-left:1px solid black;border-right:1px solid black;">
		<td style="border-left:1px solid black;"></td>
		<td ></td>
		<td ></td>
		<td >Employer EPF</td>
		<td ></td>
		<td >@if(isset($payslip['eepf']))<span style="float: right;">{{$payslip['eepf']}}</span>@endif</td>
	</tr>	
	<tr style="border-left:1px solid black;border-right:1px solid black;">
		<td style="border-left:1px solid black;"></td>
		<td ></td>
		<td ></td>
		<td style="border-right:1px solid black;border-bottom:1px solid black;">Employer SOCSO</td>
		<td style="border-right:1px solid black;border-bottom:1px solid black;"></td>
		<td style="border-right:1px solid black;border-bottom:1px solid black;">@if(isset($payslip['esocso']))<span style="float: right;">{{$payslip['esocso']}}</span>@endif</td>
	</tr>	
	<tr style="border-left:1px solid black;border-right:1px solid black;">
		<td style="border-left:1px solid black;"></td>
		<td ></td>
		<td ></td>
		<td >Gross Income</td>
		<td >@if(isset($payslip['gross']))<span style="float: right;">{{$payslip['gross']}}</span>@endif</td>
		<td >@if(isset($payslip['basic_pay_ytd']))<span style="float: right;">{{$payslip['basic_pay_ytd']}}</span>@endif</td>
	</tr>
	<tr style="border-left:1px solid black;border-right:1px solid black;">
		<td style="border-right:1px solid black;border-bottom:1px solid black; border-left:1px solid black;"></td>
		<td style="border-right:1px solid black;border-bottom:1px solid black;"></td>
		<td style="border-right:1px solid black;border-bottom:1px solid black;"></td>
		<td style="border-right:1px solid black;border-bottom:1px solid black;">Net Income</td>
		<td style="border-right:1px solid black;border-bottom:1px solid black;">@if(isset($payslip['net']))<span style="float: right;">{{$payslip['net']}}</span>@endif</td>
		<td style="border-right:1px solid black;border-bottom:1px solid black;">@if(isset($payslip['net_ytd']))<span style="float: right;">{{$payslip['net_ytd']}}</span>@endif</td>
	</tr>
	<tr style="border-left:1px solid black;border-right:1px solid black; border-bottom:1px solid black;">
		<td style="border-left:1px solid black;border-bottom:1px solid black;">Gross Total</td>
		<td style="border-bottom:1px solid black;">@if(isset($payslip['gross']))<span style="float: right;">{{$payslip['gross']}}</span>@endif</td>
		<td style="border-bottom:1px solid black;">@if(isset($payslip['basic_pay_ytd']))<span style="float: right;">{{$payslip['basic_pay_ytd']}}</span>@endif</td>
		<td style="border-bottom:1px solid black;">End Month Pay</td>
		<td style="border-bottom:1px solid black;">@if(isset($payslip['net']))<span style="float: right;"><b>{{$payslip['net']}}</b></span>@endif</td>
		<td style="border-bottom:1px solid black;"></td>
	</tr>						
</table>