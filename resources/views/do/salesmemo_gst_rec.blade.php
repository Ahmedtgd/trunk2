<style type="text/css">
    .table-nonfluid {
        width: 57% !important;
    }
	
	@media(min-width: 1201px){
		.bcspacing{
			letter-spacing: 5px;
		}
	}
	@media(min-width: 1000px) and (max-width: 1200px){
		.bcspacing{
			letter-spacing: 4px;
		}
	}
	@media(min-width: 768px) and (max-width: 999px){
		.bcspacing{
			letter-spacing: 2px;
		}
	}
	@media(min-width: 680px) and (max-width: 767px){
		.bcspacing{
			letter-spacing:25px;
		}
	}
	@media(min-width: 600px) and (max-width: 679px){
		.bcspacing{
			letter-spacing:20px;
		}
	}
	@media(min-width: 550px) and (max-width: 599px){
		.bcspacing{
			letter-spacing:17px;
		}
	}
	
	@media(min-width: 500px) and (max-width: 549px){
		.bcspacing{
			letter-spacing:14px;
		}
	}
	@media(min-width: 450px) and (max-width: 499px){
		.bcspacing{
			letter-spacing:11px;
		}
	}
	@media(min-width: 400px) and (max-width: 459px){
		.bcspacing{
			letter-spacing:9px;
		}
	}
	@media(min-width: 350px) and (max-width: 399px){
		.bcspacing{
			letter-spacing:7px;
		}
	}
	
	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 8px;
		line-height: 1.42857143;
		vertical-align: top;
		border: 1px solid #ddd !important;
	}
	
	.big-blue{
		background-color: #2f5c87;
		color: #fff;
	}
	
	.big-red{
		background-color: #ba3127;
		color: #fff;
	}
	
	.big-black{
		background-color: #111111;
		color: #fff;
	}	
	
	.big-btn{
		width: 40px;
		height: 40px;
		border-radius: 15px;
		padding: 30px;
		font-size: 20px;
	}
	
	.big-btn2{
		width: 40px;
		height: 40px;
		border-radius: 15px;
		padding: 30px;
		font-size: 20px;
		font-weight:"100"
	}	
	
	.big-btn:hover {
		color: white;
	}
	
	.big-btn2:hover {
		color: white;
	}

	div.void:after {
    content:"Void";
    position:absolute;
    top:1%;
    left:2%;
    z-index:1;
    font-family:Arial,sans-serif;
    -webkit-transform: rotate(45deg); /* Safari */
    -moz-transform: rotate(45deg); /* Firefox */
    -ms-transform: rotate(45deg); /* IE */
    -o-transform: rotate(45deg); /* Opera */
    transform: rotate(45deg);
    font-size:150px;
    color:#ff0000 !important ;
        /*background:#fff;*/

    padding:50px;
;
    zoom:1;
    /*filter:alpha(opacity=20);*/
    opacity:0.45;
    /*-webkit-text-shadow: 0 0 2px #c00;*/
    /*text-shadow: 0 0 2px #c00;*/
    /*box-shadow: 0 0 2px #c00;*/
}
</style>
@extends("common.default")
<?php use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
?>
<?php 
	$sstatus = $array_delivery[0]['salesmemostatus'];
	$stylev = "";
	$stylevbtn = "";
	if($sstatus != 'voided'){
		$stylev = "display: none;";
	} else {
		$stylevbtn = "display: none;";
	}
?>
@section("content")
    <div class="container"><!--Begin main cotainer-->
		<div class='col-sm-3'>
		</div>
		<div class='col-sm-6'>
			<div class='col-sm-1'>
			</div>
			<div class='col-sm-10'>
			<h2 align="center">Sales Memo</h2>
			<p style="text-align: center;">
				<b>{{$array_delivery[0]['merchant_name']}}</b>
				<br>
				{{$array_delivery[0]['mbiz']}}
				<br>
				@if($array_delivery[0]['oshop_address_id'] == 0)
					@if($array_delivery[0]['user_address'] != "")
						{{$array_delivery[0]['user_address']}}
						<br>
					@endif
					@if($array_delivery[0]['line2'] != "")
						{{$array_delivery[0]['line2']}}
						<br>
					@endif
					@if($array_delivery[0]['line3'] != "")
						{{$array_delivery[0]['line3']}}
					@endif
				@else

					@if($array_delivery[0]['muser_address'] != "")
						{{$array_delivery[0]['muser_address']}}
						<br>
					@endif
					@if($array_delivery[0]['mline2'] != "")
						{{$array_delivery[0]['mline2']}}
						<br>
					@endif
					@if($array_delivery[0]['mline3'] != "")
						{{$array_delivery[0]['mline3']}}
					@endif


				@endif
				<br>SST Reg. No:
				{{$array_delivery[0]['merchant_gst']}}
				<br>
				{{UtilityController::s_date($array_delivery[0]['orderdate'])}}
				<br>
				<br>
				@if(!is_null($fairlocation))
					<b>{{$fairlocation->company_name}}</b>
					<br>
					@if($fairlocation->line1 != "")
						{{$fairlocation->line1}}
						<br>
					@endif
					@if($fairlocation->line2 != "")
						{{$fairlocation->line2}}
						<br>
					@endif
					@if($fairlocation->line1 != "")
						{{$fairlocation->line1}}
						<br>
					@endif	
					@if($fairlocation->line3 != "")
						{{$fairlocation->line3}}
						<br>
					@endif		
					@if($fairlocation->name != "")
						{{$fairlocation->postcode}}	{{$fairlocation->name}}
						<br>
					@endif						
				@endif
			</p>
			<div id="void" class="<?php
				if($salesmemo->status=="voided"){
					echo "void";
				}

			?>">
 			<div class='col-sm-6'>
				<span><b>Consignment&nbsp;A/C&nbsp;No:</b></span>
			</div> 
 			<div class='col-sm-6'>
			@if (!empty($salesmemo->consignment_account_no))
				<span>{{$salesmemo->consignment_account_no}}</span>
			@else
				<span>&nbsp;</span>
			@endif
			</div> 
			<div class='col-sm-6'>
				<span><b>Sales&nbsp;Memo&nbsp;No:</b></span>
			</div>
			<div class='col-sm-6'>
				<span>{{str_pad($array_delivery[0]['merchantrecno'],10,"0",STR_PAD_LEFT)}}</span>
			</div>
			<div class='col-sm-6'>
				<span><b>SalesMan&nbsp;ID:</b> </span>
									
			</div>
			<div class='col-sm-6'>
				<span>
					{{sprintf('%010d',$salesmemo->creator_user_id)}}
				</span>
			</div>
			<div class='col-sm-6'>
				<span><b>SalesMan:</b> </span>
			</div>
			<div class='col-sm-6'>
				<span>
					@if($buyer->name != ""){{$buyer->name}}
                    @endif
				</span>
			</div>
			<div class='col-sm-6'>
				<span><b>Location:</b> </span>
			</div>
			<div class='col-sm-6'>
				<span>
					@if(!is_null($fairlocation)){{$fairlocation->location}}
                    @endif
				</span>
			</div>
			</div>
			
			<div class='col-sm-12 ' style="margin-top: 15px;" >
				<table class="table" style="border: 1px solid #ddd; font-size: 14px !important;">
				<tr >
					<th>Description</th>
					<th class="text-center">Qty</th>
					<th class="text-right">Unit&nbsp;Price</th>
					<th class="text-right">Total</th>
				</tr>
				<?php $counter = 1; $sum_qty = 0;
				$sum_amount = 0;
				$glob = DB::table('global')->first()->gst_rate;
				$tproducts = DB::table('salesmemoproduct')->where('salesmemo_id',$salesmemo->id)->get();
				?>

				@if(isset($tproducts))
					@foreach($tproducts as $product)
					<tr>
						<?php
						$prime_product = DB::table('product')->
							where('id', $product->product_id)->first();
						?>
						<td style="vertical-align:middle">{{ $prime_product->name }}</td>
						<td style="vertical-align:middle" class="text-center">{{ $product->quantity or 0 }}</td>
						<td style="vertical-align:middle" class="text-right">
							<?php
							$opc = $product->price;
							$tempTotal = ($opc * $product->quantity);
							$revenue = number_format($tempTotal / 100, 2);
							$totalPaid = ($product->quantity * $opc);
							$amount = number_format($totalPaid / 100, 2);
							$sum_qty += $product->quantity;
							$sum_amount += $tempTotal;
							?>
							{{number_format($opc/100,2)}}
						</td>
						<td style="vertical-align:middle" class="text-right">{{ number_format($totalPaid/100,2)}}</td>
					</tr>
					@endforeach
					<tr>
						<td colspan=3>
							<span class="pull-right"><b>Total<b></span>
						</td>
						<?php
						// $aux = ($sum_amount*6)/100;
						$total = $sum_amount;
						$rawTotal = $total / (1 + ($glob / 100));
						$gstTotal = $total - $rawTotal;
						?>
						<td>
							<span class="pull-right">
								<b>&nbsp;{{$currency}}&nbsp;{{number_format($sum_amount/100,2) }}
							</b></span>
						</td>
					</tr>
				@endif
				</table>
			</div>
			<div class="col-sm-12 text-right" style="">
				<table style="float:right;text-align:right;">
					<tr>
						<td style="padding-right: 10px">
						   <b> Total&nbsp;includes&nbsp;{{$gst[0]->gst_rate}}% SST </b>
						</td>
						<td> <b>{{$currency}}&nbsp;{{number_format($gstTotal/100,2)}} </b></td>
					</tr>
					<tr>
						<td style="padding-right: 10px"> <b>Items&nbsp;Total</b></td>
						<td> <b>{{$currency}}&nbsp;{{ number_format($rawTotal/100,2) }} </b></td>
					</tr>
				</table>
			</div>
			<div class="clearfix">
			</div>	
			<div class="row">
				<!--
				<div class="col-sm-4 no-padding" style="margin-top: 50px">
					<center>
						<a href="javascript:void(0)" 
							class="big-btn big-blue print_salesmemo action_butt">
							PrintXX
						</a>	
					</center>	
				</div>
				-->
				<div class="col-sm-6 text-right"
					style="margin-top: 50px;padding-right:3px">
					<a href="javascript:void(0)" style="{{$stylevbtn}}"
						class="big-btn big-red void_salesmemo action_butt">
						Void
					</a>
				</div>
				<div class="col-sm-6 text-left"
					style="margin-top: 50px;padding-left:3px">
					<a href="javascript:void(0)" 
						class="big-btn2 big-black close_salesmemo action_butt">
						&nbsp;&nbsp;X&nbsp;&nbsp;
					</a>	
				</div>
			</div>
			<div class="row">
				<div class='col-sm-2'>
				</div>
				<div class="col-sm-8"
					style="text-align:center;margin-top: 50px">
				<svg class="barcode"
				jsbarcode-value="{{sprintf('%010d',$salesmemo->salesmemo_no)}}"
				jsbarcode-height="50"
				jsbarcode-textmargin="0"
				jsbarcode-fontoptions="bold">
				</svg>
				</div>
				<div class='col-sm-2'>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12"
					style="padding:20px;text-align: center;margin:auto;">
					<div id="qrcode" >
					</div>
				</div>
			</div>
			</div>
			<div class='col-sm-1'>
			</div>
		</div>
		<div class='col-sm-3'>
		</div>
    </div><!--Begin main container-->

    <script type="text/javascript" src={{asset("js/barcode.js")}}></script>
    <script type="text/javascript" src={{asset("js/qr.js")}}></script>
    <script type="text/javascript">
	$("#chkSelectAll").click(function () {
		$('input:checkbox').not(this).prop('checked', this.checked);
	});
	$(document).ready(function(){
		JsBarcode(".barcode").init();
		$qrtext="{{sprintf('%010d',$salesmemo->salesmemo_no)}}";
		$('#qrcode').qrcode({width: 180,height: 180,text:$qrtext});
		$(document).delegate( '.print_salesmemo', "click",function (event) {
			myWindow=window.open(
				JS_BASE_URL +
				"/print/posm/{{$array_delivery[0]['salesmemoid']}}");
			myWindow.focus();
			myWindow.print(); 
		});
		$(document).delegate( '.close_salesmemo', "click",function (event) {
			window.close();
		});
		
		$(document).delegate( '.void_salesmemo', "click",function (event) {
			$.ajax({
				type: "POST",
				url: JS_BASE_URL + "/salesmemo/status/voided/{{$array_delivery[0]['salesmemoid']}}",
				success: function (data) {
					toastr.info("Status changed!");
					// $("#voided_memo").show();
					$(".void_salesmemo").hide();
					// $(".void_salesmemo_br").hide();
					$("#void").addClass("void");
					//obj.html("Send");
				},
				error: function (error) {
					toastr.error("An unexpected error ocurred");
					obj.html("Send");
				}

			});					
		});
	});
	
	
	function openWin() {
	}

	function processdelivery() {
		var items = [];
		$("input:checkbox:checked").each(function () {
			items.push($(this).attr('value'));
		});

		console.log(items);
		if (items.length > 0) {
			jQuery.ajax({
				type: "POST",
				url: "{{ url('deliveryinvoice/process')}}",
				data: {
					items: items,
					porder_id: $('#mporder_id').val(),
					password: $('#orderpassworld').val().trim()
				},
				beforeSend: function () {
				},
				success: function (response) {
					console.log(response);
					if (response == 1) {
						toastr.info("Password matched. Thank you for the purchase");
						window.location.reload();

					} else if (response == -1) {
						toastr.warning("Password do not match. Please try again");
					} else {
						toastr.error("An unexpected error ocurred. Please try again or contact OpenSupermall Support");
					}
				}
			});
		} else {
			toastr.warning("Please select the products!");
		}
	}
    </script>

@stop
